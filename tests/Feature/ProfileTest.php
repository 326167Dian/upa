<?php

namespace Tests\Feature;

use App\Models\Operator;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_open_profile_page(): void
    {
        $user = User::factory()->create();
        $this->createOperatorForUser($user);

        $response = $this->actingAs($user)->get(route('profile.edit'));

        $response->assertOk();
        $response->assertSee('Edit Profil');
    }

    public function test_authenticated_user_can_update_personal_profile(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'password' => Hash::make('passwordlama123'),
        ]);
        $operator = $this->createOperatorForUser($user, [
            'phone_number' => '08120000000',
            'full_address' => 'Alamat lama',
        ]);

        $response = $this->actingAs($user)->put(route('profile.update'), [
            'avatar' => UploadedFile::fake()->image('avatar.png'),
            'phone_number' => '08129999999',
            'full_address' => 'Alamat baru lengkap',
            'current_password' => 'passwordlama123',
            'password' => 'passwordbaru123',
            'password_confirmation' => 'passwordbaru123',
        ]);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('success');

        $operator->refresh();
        $user->refresh();

        $this->assertSame('08129999999', $operator->phone_number);
        $this->assertSame('Alamat baru lengkap', $operator->full_address);
        $this->assertNotNull($operator->avatar_path);
        $this->assertTrue(Storage::disk('public')->exists($operator->avatar_path));
        $this->assertTrue(Hash::check('passwordbaru123', $user->password));
        $this->assertTrue(Hash::check('passwordbaru123', $operator->password));
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    protected function createOperatorForUser(User $user, array $attributes = []): Operator
    {
        return Operator::create(array_merge([
            'user_id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'password' => $user->password,
            'role' => $user->role,
            'permissions' => $user->permissions,
            'phone_number' => '081234567890',
            'full_address' => 'Alamat operator',
        ], $attributes));
    }
}