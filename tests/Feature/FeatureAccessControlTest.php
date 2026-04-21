<?php

namespace Tests\Feature;

use App\Models\Operator;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class FeatureAccessControlTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_custom_operator_with_selected_permissions(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'username' => 'adminfitur',
        ]);

        $response = $this->actingAs($admin)->post(route('operators.store'), [
            'name' => 'Operator Terbatas',
            'username' => 'operatorterbatas',
            'password' => 'secret123',
            'role' => User::ROLE_CUSTOM,
            'permissions' => ['dashboard.view', 'pengumuman.view', 'pengumuman.create'],
            'phone_number' => '08177777777',
            'full_address' => 'Alamat operator terbatas',
        ]);

        $response->assertRedirect(route('operators.index'));

        $operator = Operator::where('username', 'operatorterbatas')->first();

        $this->assertNotNull($operator);
        $this->assertSame(['dashboard.view', 'pengumuman.view', 'pengumuman.create'], $operator->permissions);
        $this->assertSame(['dashboard.view', 'pengumuman.view', 'pengumuman.create'], $operator->user?->permissions);
    }

    public function test_custom_operator_can_only_access_selected_features(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_CUSTOM,
            'permissions' => ['dashboard.view', 'pengumuman.view'],
            'username' => 'customakses',
            'password' => Hash::make('password123'),
        ]);

        Operator::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'password' => $user->password,
            'role' => User::ROLE_CUSTOM,
            'permissions' => ['dashboard.view', 'pengumuman.view'],
            'phone_number' => '08188888888',
            'full_address' => 'Alamat custom',
        ]);

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('pengumuman.index'))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('pengumuman.create'))
            ->assertRedirect(route('dashboard'));

        $blocked = $this->actingAs($user)->get(route('operators.index'));

        $blocked->assertRedirect(route('dashboard'));
        $blocked->assertSessionHas('error');
    }

    public function test_custom_role_requires_at_least_one_permission(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        $response = $this->actingAs($admin)->post(route('operators.store'), [
            'name' => 'Tanpa Fitur',
            'username' => 'tanpafitur',
            'password' => 'secret123',
            'role' => User::ROLE_CUSTOM,
            'phone_number' => '08199999999',
            'full_address' => 'Alamat tanpa fitur',
        ]);

        $response->assertSessionHasErrors('permissions');
    }
}