<?php

namespace Tests\Feature;

use App\Models\Operator;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
            'role' => 'admin',
            'phone_number' => '08123456789',
            'full_address' => 'Jl. Mawar No. 10, Jakarta',
        ]);

        $response->assertRedirect(route('operators.index'));

        $this->assertDatabaseHas('operators', [
            'name' => 'Operator Satu',
            'role' => 'admin',
            'phone_number' => '08123456789',
            'full_address' => 'Jl. Mawar No. 10, Jakarta',
        ]);
    }

    public function test_authenticated_user_can_update_operator(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $operator = Operator::create([
            'name' => 'Operator Lama',
            'role' => 'user',
            'phone_number' => '0812000000',
            'full_address' => 'Alamat lama',
        ]);

        $response = $this->actingAs($user)->put(route('operators.update', $operator), [
            'name' => 'Operator Baru',
            'role' => 'admin',
            'phone_number' => '0899999999',
            'full_address' => 'Alamat baru',
        ]);

        $response->assertRedirect(route('operators.index'));

        $this->assertDatabaseHas('operators', [
            'id' => $operator->id,
            'name' => 'Operator Baru',
            'role' => 'admin',
            'phone_number' => '0899999999',
            'full_address' => 'Alamat baru',
        ]);
    }

    public function test_authenticated_user_can_delete_operator(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $operator = Operator::create([
            'name' => 'Operator Hapus',
            'role' => 'user',
            'phone_number' => '0811111111',
            'full_address' => 'Alamat hapus',
        ]);

        $response = $this->actingAs($user)->delete(route('operators.destroy', $operator));

        $response->assertRedirect(route('operators.index'));
        $this->assertDatabaseMissing('operators', [
            'id' => $operator->id,
        ]);
    }

    public function test_non_admin_cannot_delete_operator(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $operator = Operator::create([
            'name' => 'Operator Aman',
            'role' => 'user',
            'phone_number' => '0812222222',
            'full_address' => 'Alamat aman',
        ]);

        $response = $this->actingAs($user)->delete(route('operators.destroy', $operator));

        $response->assertRedirect(route('operators.index'));
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
            'role' => 'admin',
            'phone_number' => '0813333333',
            'full_address' => 'Jakarta Pusat',
        ]);

        Operator::create([
            'name' => 'User Bandung',
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