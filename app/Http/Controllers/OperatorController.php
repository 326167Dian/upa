<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OperatorController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->string('search'));
        $role = (string) $request->string('role');

        return view('operators.index', [
            'operators' => Operator::query()
                ->when($search !== '', function (Builder $query) use ($search) {
                    $query->where(function (Builder $nestedQuery) use ($search) {
                        $nestedQuery
                            ->where('name', 'like', '%'.$search.'%')
                            ->orWhere('phone_number', 'like', '%'.$search.'%')
                            ->orWhere('full_address', 'like', '%'.$search.'%');
                    });
                })
                ->when(in_array($role, ['admin', 'user'], true), function (Builder $query) use ($role) {
                    $query->where('role', $role);
                })
                ->latest()
                ->paginate(10)
                ->withQueryString(),
            'filters' => [
                'search' => $search,
                'role' => $role,
            ],
        ]);
    }

    public function create(): View
    {
        return view('operators.create', [
            'operator' => new Operator(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        Operator::create($data);

        return redirect()
            ->route('operators.index')
            ->with('success', 'Operator berhasil ditambahkan.');
    }

    public function edit(Operator $operator): View
    {
        return view('operators.edit', [
            'operator' => $operator,
        ]);
    }

    public function update(Request $request, Operator $operator): RedirectResponse
    {
        $operator->update($this->validatedData($request));

        return redirect()
            ->route('operators.index')
            ->with('success', 'Data operator berhasil diperbarui.');
    }

    public function destroy(Request $request, Operator $operator): RedirectResponse
    {
        if ($request->user()?->role !== 'admin') {
            return redirect()
                ->route('operators.index')
                ->with('error', 'Hanya admin yang dapat menghapus data operator.');
        }

        $operator->delete();

        return redirect()
            ->route('operators.index')
            ->with('success', 'Data operator berhasil dihapus.');
    }

    /**
     * @return array<string, string>
     */
    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'in:admin,user'],
            'phone_number' => ['required', 'string', 'max:30'],
            'full_address' => ['required', 'string'],
        ]);
    }
}