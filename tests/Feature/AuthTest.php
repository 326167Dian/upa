<?php

namespace Tests\Feature;

use App\Models\Operator;
use App\Models\User;
use App\Support\FeaturePermission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_log_in_with_username(): void
    {
        $user = User::factory()->create([
            'username' => 'mysifa',
            'password' => Hash::make('326167Dian&&'),
        ]);

        $response = $this->post('/login', [
            'username' => 'mysifa',
            'password' => '326167Dian&&',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_authenticated_user_can_log_out(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_operator_credentials_created_from_crud_can_log_in(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'username' => 'adminutama',
        ]);

        $this->actingAs($admin)->post(route('operators.store'), [
            'name' => 'Operator Login',
            'username' => 'operatorlogin',
            'password' => 'password123',
            'role' => 'user',
            'phone_number' => '08155555555',
            'full_address' => 'Alamat login operator',
        ])->assertRedirect(route('operators.index'));

        $this->post('/logout')->assertRedirect('/login');

        $response = $this->post('/login', [
            'username' => 'operatorlogin',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();

        $operator = Operator::where('username', 'operatorlogin')->first();

        $this->assertNotNull($operator);
        $this->assertSame('operatorlogin', $operator->user?->username);
    }

    public function test_guest_can_register_operator_account_with_non_operator_access_and_jurnal_kas_view_only(): void
    {
        $response = $this->post(route('register.store'), [
            'username' => 'operatorbaru',
            'name' => 'Operator Baru',
            'phone_number' => '081234567890',
            'full_address' => 'Jl. Pendaftaran No. 1, Jakarta',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'username' => 'operatorbaru',
            'role' => User::ROLE_USER,
        ]);

        $this->assertDatabaseHas('operators', [
            'username' => 'operatorbaru',
            'name' => 'Operator Baru',
            'role' => User::ROLE_USER,
            'phone_number' => '081234567890',
            'full_address' => 'Jl. Pendaftaran No. 1, Jakarta',
        ]);

        $user = User::where('username', 'operatorbaru')->first();
        $operator = Operator::where('username', 'operatorbaru')->first();

        $this->assertNotNull($user);
        $this->assertNotNull($operator);
        $this->assertSame(FeaturePermission::defaultUserPermissions(), $user->permissions);
        $this->assertSame(FeaturePermission::defaultUserPermissions(), $operator->permissions);
    }

    public function test_registered_user_can_access_non_operator_features_but_jurnal_kas_is_view_only(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_USER,
            'permissions' => FeaturePermission::defaultUserPermissions(),
            'username' => 'jurnalsaja',
        ]);

        Operator::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'password' => $user->password,
            'role' => User::ROLE_USER,
            'permissions' => FeaturePermission::defaultUserPermissions(),
            'phone_number' => '081111111111',
            'full_address' => 'Alamat jurnal saja',
        ]);

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('kegiatan.index'))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('kehadiran.index'))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('pengumuman.index'))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('foto-kegiatan.index'))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('jurnal-kas.index'))
            ->assertOk()
            ->assertDontSee('Input Pengeluaran')
            ->assertDontSee('Input Pemasukan')
            ->assertDontSee(route('jurnal-kas.expenses.create'))
            ->assertDontSee(route('jurnal-kas.incomes.create'));

        $this->actingAs($user)
            ->get(route('jurnal-kas.types.index'))
            ->assertOk()
            ->assertDontSee(route('jurnal-kas.types.create'));

        $this->actingAs($user)
            ->get(route('operators.index'))
            ->assertRedirect(route('dashboard'));

        $this->actingAs($user)
            ->get(route('jurnal-kas.expenses.create'))
            ->assertRedirect(route('dashboard'));

        $this->actingAs($user)
            ->get(route('jurnal-kas.types.create'))
            ->assertRedirect(route('dashboard'));
    }
}