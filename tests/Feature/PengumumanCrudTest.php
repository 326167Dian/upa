<?php

namespace Tests\Feature;

use App\Models\Operator;
use App\Models\Pengumuman;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PengumumanCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_pengumuman_index(): void
    {
        $user = User::factory()->create();
        $this->createOperatorForUser($user);

        $response = $this->actingAs($user)->get(route('pengumuman.index'));

        $response->assertOk();
        $response->assertSee('Data Pengumuman');
    }

    public function test_authenticated_user_can_create_pengumuman_and_store_operator_reference(): void
    {
        $user = User::factory()->create(['name' => 'Pembuat Pengumuman', 'role' => 'admin']);
        $operator = $this->createOperatorForUser($user);

        $response = $this->actingAs($user)->post(route('pengumuman.store'), [
            'berita' => '<p>Pengumuman <strong>baru</strong> untuk seluruh operator.</p>',
        ]);

        $response->assertRedirect(route('pengumuman.index'));

        $this->assertDatabaseHas('pengumuman', [
            'berita' => '<p>Pengumuman <strong>baru</strong> untuk seluruh operator.</p>',
            'id_operator' => $operator->id,
        ]);
    }

    public function test_authenticated_user_can_update_pengumuman(): void
    {
        $user = User::factory()->create(['name' => 'Editor Pengumuman', 'role' => 'admin']);
        $operator = $this->createOperatorForUser($user);
        $pengumuman = Pengumuman::create([
            'berita' => '<p>Isi lama</p>',
            'id_operator' => $operator->id,
        ]);

        $response = $this->actingAs($user)->put(route('pengumuman.update', $pengumuman), [
            'berita' => '<p>Isi terbaru</p>',
        ]);

        $response->assertRedirect(route('pengumuman.index'));

        $this->assertDatabaseHas('pengumuman', [
            'id_pengumuman' => $pengumuman->id_pengumuman,
            'berita' => '<p>Isi terbaru</p>',
            'id_operator' => $operator->id,
        ]);
    }

    public function test_authenticated_user_can_delete_pengumuman(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $operator = $this->createOperatorForUser($user);
        $pengumuman = Pengumuman::create([
            'berita' => '<p>Hapus pengumuman ini</p>',
            'id_operator' => $operator->id,
        ]);

        $response = $this->actingAs($user)->delete(route('pengumuman.destroy', $pengumuman));

        $response->assertRedirect(route('pengumuman.index'));
        $this->assertDatabaseMissing('pengumuman', [
            'id_pengumuman' => $pengumuman->id_pengumuman,
        ]);
    }

    public function test_custom_user_without_write_permissions_cannot_create_edit_or_delete_pengumuman(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_CUSTOM,
            'permissions' => ['pengumuman.view', 'dashboard.view'],
        ]);
        $operator = $this->createOperatorForUser($user);
        $pengumuman = Pengumuman::create([
            'berita' => '<p>Isi awal</p>',
            'id_operator' => $operator->id,
        ]);

        $createResponse = $this->actingAs($user)->post(route('pengumuman.store'), [
            'berita' => '<p>Tidak boleh dibuat</p>',
        ]);

        $updateResponse = $this->actingAs($user)->put(route('pengumuman.update', $pengumuman), [
            'berita' => '<p>Tidak boleh diubah</p>',
        ]);

        $deleteResponse = $this->actingAs($user)->delete(route('pengumuman.destroy', $pengumuman));

        $createResponse->assertRedirect(route('dashboard'));
        $updateResponse->assertRedirect(route('dashboard'));
        $deleteResponse->assertRedirect(route('dashboard'));

        $this->assertDatabaseMissing('pengumuman', [
            'berita' => '<p>Tidak boleh dibuat</p>',
        ]);
        $this->assertDatabaseHas('pengumuman', [
            'id_pengumuman' => $pengumuman->id_pengumuman,
            'berita' => '<p>Isi awal</p>',
        ]);
    }

    public function test_admin_can_upload_pengumuman_image(): void
    {
        Storage::fake('public');

        $user = User::factory()->create(['role' => 'admin']);
        $this->createOperatorForUser($user);

        $response = $this->actingAs($user)->post(route('pengumuman.upload-image'), [
            'upload' => UploadedFile::fake()->image('pengumuman.jpg'),
        ]);

        $response->assertOk();
        $response->assertJsonStructure(['url']);

        $uploadedPath = ltrim((string) parse_url($response->json('url'), PHP_URL_PATH), '/');
        $relativePath = str_replace('storage/', '', $uploadedPath);

        $this->assertTrue(Storage::disk('public')->exists($relativePath));
    }

    public function test_custom_user_without_write_permissions_cannot_upload_pengumuman_image(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'role' => User::ROLE_CUSTOM,
            'permissions' => ['pengumuman.view', 'dashboard.view'],
        ]);
        $this->createOperatorForUser($user);

        $response = $this->actingAs($user)->post(route('pengumuman.upload-image'), [
            'upload' => UploadedFile::fake()->image('pengumuman.jpg'),
        ]);

        $response->assertForbidden();
    }

    protected function createOperatorForUser(User $user): Operator
    {
        return Operator::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'password' => $user->password,
            'role' => $user->role,
            'permissions' => $user->permissions,
            'phone_number' => '081234567890',
            'full_address' => 'Alamat operator',
        ]);
    }
}