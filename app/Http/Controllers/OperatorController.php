<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use App\Models\User;
use App\Support\FeaturePermission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OperatorController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->string('search'));
        $role = (string) $request->string('role');
        $operators = Operator::query()
            ->when($search !== '', function (Builder $query) use ($search) {
                $query->where(function (Builder $nestedQuery) use ($search) {
                    $nestedQuery
                        ->where('name', 'like', '%'.$search.'%')
                        ->orWhere('username', 'like', '%'.$search.'%')
                        ->orWhere('phone_number', 'like', '%'.$search.'%')
                        ->orWhere('full_address', 'like', '%'.$search.'%');
                });
            })
            ->when(in_array($role, [User::ROLE_ADMIN, User::ROLE_USER, User::ROLE_CUSTOM], true), function (Builder $query) use ($role) {
                $query->where('role', $role);
            })
            ->latest()
            ->get();

        return view('operators.index', [
            'operators' => $operators,
            'filters' => [
                'search' => $search,
                'role' => $role,
            ],
            'featureDefinitions' => FeaturePermission::definitions(),
            'permissionSummaries' => $operators
                ->mapWithKeys(fn (Operator $operator) => [
                    $operator->id => FeaturePermission::summarize($operator->permissions),
                ]),
        ]);
    }

    public function create(): View
    {
        return view('operators.create', [
            'operator' => new Operator(),
            'featureDefinitions' => FeaturePermission::definitions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        DB::transaction(function () use ($data): void {
            $permissions = $this->normalizePermissions((string) $data['role'], $data['permissions'] ?? []);
            $passwordHash = Hash::make($data['password']);
            $user = $this->upsertOperatorUser($data, null, $passwordHash);

            Operator::create([
                ...Arr::except($data, ['password']),
                'user_id' => $user->id,
                'password' => $passwordHash,
                'permissions' => $permissions,
            ]);
        });

        return redirect()
            ->route('operators.index')
            ->with('success', 'Operator berhasil ditambahkan.');
    }

    public function edit(Operator $operator): View
    {
        return view('operators.edit', [
            'operator' => $operator,
            'featureDefinitions' => FeaturePermission::definitions(),
        ]);
    }

    public function show(int $operator): RedirectResponse
    {
        $existingOperator = Operator::find($operator);

        if (! $existingOperator) {
            return redirect()
                ->route('operators.index')
                ->with('error', 'Operator yang diminta tidak ditemukan atau sudah dihapus.');
        }

        return redirect()->route('operators.edit', $existingOperator);
    }

    public function update(Request $request, Operator $operator): RedirectResponse
    {
        $data = $this->validatedData($request, $operator);

        DB::transaction(function () use ($data, $operator): void {
            $permissions = $this->normalizePermissions((string) $data['role'], $data['permissions'] ?? []);
            $passwordHash = filled($data['password'] ?? null)
                ? Hash::make($data['password'])
                : $operator->password;

            $user = $this->upsertOperatorUser($data, $operator, $passwordHash);

            $operator->update([
                ...Arr::except($data, ['password']),
                'user_id' => $user->id,
                'password' => $passwordHash,
                'permissions' => $permissions,
            ]);
        });

        return redirect()
            ->route('operators.index')
            ->with('success', 'Data operator berhasil diperbarui.');
    }

    public function destroy(Request $request, Operator $operator): RedirectResponse
    {
        DB::transaction(function () use ($operator): void {
            $linkedUser = $operator->user;

            $operator->delete();

            $linkedUser?->delete();
        });

        return redirect()
            ->route('operators.index')
            ->with('success', 'Data operator berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    protected function validatedData(Request $request, ?Operator $operator = null): array
    {
        $passwordRule = $operator && filled($operator->password) ? 'nullable' : 'required';

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('operators', 'username')->ignore($operator?->id),
                Rule::unique('users', 'username')->ignore($operator?->user_id),
            ],
            'password' => [$passwordRule, 'string', 'min:8'],
            'role' => ['required', 'in:admin,user,custom'],
            'permissions' => ['required_if:role,custom', 'array'],
            'permissions.*' => ['string', Rule::in(FeaturePermission::keys())],
            'phone_number' => ['required', 'string', 'max:30'],
            'full_address' => ['required', 'string'],
        ]);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function upsertOperatorUser(array $data, ?Operator $operator, string $passwordHash): User
    {
        $user = $operator?->user ?? new User();
        $permissions = $this->normalizePermissions((string) $data['role'], $data['permissions'] ?? []);

        $user->fill([
            'name' => $data['name'],
            'username' => $data['username'],
            'role' => $data['role'],
            'permissions' => $permissions,
            'email' => $this->operatorEmail((string) $data['username']),
            'password' => $passwordHash,
        ]);

        $user->save();

        return $user;
    }

    protected function operatorEmail(string $username): string
    {
        return strtolower($username).'@upa.local';
    }

    /**
     * @param  array<int, string>  $permissions
     * @return array<int, string>
     */
    protected function normalizePermissions(string $role, array $permissions): array
    {
        if ($role === User::ROLE_ADMIN) {
            return FeaturePermission::keys();
        }

        if ($role === User::ROLE_USER) {
            if ($permissions === []) {
                return FeaturePermission::keys();
            }

            return array_values(array_intersect(FeaturePermission::keys(), $permissions));
        }

        return array_values(array_intersect(FeaturePermission::keys(), $permissions));
    }
}