<?php

namespace Tests\Feature;

use App\Models\Operator;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class OperatorCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_operator_index(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('operators.index'));

        $response->assertOk();
        $response->assertSee('Data Operator');
    }

    public function test_authenticated_user_can_create_operator(): void
    {
        $user = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($user)->post(route('operators.store'), [
            'name' => 'Operator Satu',
            'username' => 'operatorsatu',
            'password' => 'secret123',
            'role' => 'admin',
            'phone_number' => '08123456789',
            'full_address' => 'Jl. Mawar No. 10, Jakarta',
        ]);

        $response->assertRedirect(route('operators.index'));

        $this->assertDatabaseHas('operators', [
            'name' => 'Operator Satu',
            'username' => 'operatorsatu',
            'role' => 'admin',
            'phone_number' => '08123456789',
            'full_address' => 'Jl. Mawar No. 10, Jakarta',
        ]);

        $this->assertDatabaseHas('users', [
            'username' => 'operatorsatu',
            'role' => 'admin',
        ]);
    }

    public function test_authenticated_user_can_update_operator(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $operator = Operator::create([
            'name' => 'Operator Lama',
            'username' => 'operatorlama',
            'password' => Hash::make('passwordlama'),
            'role' => 'user',
            'phone_number' => '0812000000',
            'full_address' => 'Alamat lama',
        ]);
        $linkedUser = User::create([
            'name' => 'Operator Lama',
            'username' => 'operatorlama',
            'role' => 'user',
            'email' => 'operatorlama@upa.local',
            'password' => Hash::make('passwordlama'),
        ]);
        $operator->update(['user_id' => $linkedUser->id]);

        $response = $this->actingAs($user)->put(route('operators.update', $operator), [
            'name' => 'Operator Baru',
            'username' => 'operatorbaru',
            'password' => 'passwordbaru',
            'role' => 'admin',
            'phone_number' => '0899999999',
            'full_address' => 'Alamat baru',
        ]);

        $response->assertRedirect(route('operators.index'));

        $this->assertDatabaseHas('operators', [
            'id' => $operator->id,
            'name' => 'Operator Baru',
            'username' => 'operatorbaru',
            'role' => 'admin',
            'phone_number' => '0899999999',
            'full_address' => 'Alamat baru',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $linkedUser->id,
            'username' => 'operatorbaru',
            'role' => 'admin',
        ]);
    }

    public function test_authenticated_user_can_delete_operator(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $operator = Operator::create([
            'name' => 'Operator Hapus',
            'username' => 'operatorhapus',
            'password' => Hash::make('passwordhapus'),
            'role' => 'user',
            'phone_number' => '0811111111',
            'full_address' => 'Alamat hapus',
        ]);
        $linkedUser = User::create([
            'name' => 'Operator Hapus',
            'username' => 'operatorhapus',
            'role' => 'user',
            'email' => 'operatorhapus@upa.local',
            'password' => Hash::make('passwordhapus'),
        ]);
        $operator->update(['user_id' => $linkedUser->id]);

        $response = $this->actingAs($user)->delete(route('operators.destroy', $operator));

        $response->assertRedirect(route('operators.index'));
        $this->assertDatabaseMissing('operators', [
            'id' => $operator->id,
        ]);
        $this->assertDatabaseMissing('users', [
            'id' => $linkedUser->id,
        ]);
    }

    public function test_custom_user_without_delete_permission_cannot_delete_operator(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_CUSTOM,
            'permissions' => ['operators.view', 'dashboard.view'],
        ]);
        $operator = Operator::create([
            'name' => 'Operator Aman',
            'username' => 'operatoraman',
            'password' => Hash::make('passwordaman'),
            'role' => 'user',
            'phone_number' => '0812222222',
            'full_address' => 'Alamat aman',
        ]);

        $response = $this->actingAs($user)->delete(route('operators.destroy', $operator));

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('operators', [
            'id' => $operator->id,
        ]);
    }

    public function test_operator_index_supports_search_and_role_filter(): void
    {
        $user = User::factory()->create();

        Operator::create([
            'name' => 'Admin Jakarta',
            'username' => 'adminjakarta',
            'password' => Hash::make('secret123'),
            'role' => 'admin',
            'phone_number' => '0813333333',
            'full_address' => 'Jakarta Pusat',
        ]);

        Operator::create([
            'name' => 'User Bandung',
            'username' => 'userbandung',
            'password' => Hash::make('secret456'),
            'role' => 'user',
            'phone_number' => '0814444444',
            'full_address' => 'Bandung Barat',
        ]);

        $response = $this->actingAs($user)->get(route('operators.index', [
            'search' => 'Jakarta',
            'role' => 'admin',
        ]));

        $response->assertOk();
        $response->assertSee('Admin Jakarta');
        $response->assertDontSee('User Bandung');
    }
}