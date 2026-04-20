<?php

namespace Tests\Feature;

use App\Models\Operator;
use App\Models\User;
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
}