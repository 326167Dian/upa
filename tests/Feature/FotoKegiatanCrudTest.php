<?php

namespace Tests\Feature;

use App\Models\FotoKegiatan;
use App\Models\Kegiatan;
use App\Models\Operator;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FotoKegiatanCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_foto_kegiatan_index(): void
    {
        $user = User::factory()->create();
        $this->createOperatorForUser($user);

        $response = $this->actingAs($user)->get(route('foto-kegiatan.index'));

        $response->assertOk();
        $response->assertSee('Foto Kegiatan');
    }

    public function test_authenticated_user_can_create_foto_kegiatan_and_store_created_by(): void
    {
        Storage::fake('public');

        $user = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $operator = $this->createOperatorForUser($user);
        $kegiatan = $this->createKegiatan($operator);

        $response = $this->actingAs($user)->post(route('foto-kegiatan.store'), [
            'id_kegiatan' => $kegiatan->id_kegiatan,
            'foto' => UploadedFile::fake()->image('kegiatan.jpg')->size(900),
            'keterangan' => 'Dokumentasi kegiatan pertama.',
        ]);

        $response->assertRedirect(route('foto-kegiatan.index'));

        $fotoKegiatan = FotoKegiatan::query()->first();

        $this->assertNotNull($fotoKegiatan);
        $this->assertSame($kegiatan->id_kegiatan, $fotoKegiatan->id_kegiatan);
        $this->assertSame($operator->id, $fotoKegiatan->created_by);
        $this->assertTrue(Storage::disk('public')->exists($fotoKegiatan->foto));
    }

    public function test_authenticated_user_can_update_foto_kegiatan(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $operator = $this->createOperatorForUser($user);
        $kegiatanAwal = $this->createKegiatan($operator, 'Kegiatan Awal');
        $kegiatanBaru = $this->createKegiatan($operator, 'Kegiatan Baru');
        $pathAwal = UploadedFile::fake()->image('awal.jpg')->store('foto-kegiatan', 'public');

        $fotoKegiatan = FotoKegiatan::create([
            'id_kegiatan' => $kegiatanAwal->id_kegiatan,
            'foto' => $pathAwal,
            'keterangan' => 'Foto awal.',
            'created_by' => $operator->id,
        ]);

        $response = $this->actingAs($user)->put(route('foto-kegiatan.update', $fotoKegiatan), [
            'id_kegiatan' => $kegiatanBaru->id_kegiatan,
            'foto' => UploadedFile::fake()->image('baru.jpg')->size(950),
            'keterangan' => 'Foto sudah diperbarui.',
        ]);

        $response->assertRedirect(route('foto-kegiatan.index'));

        $fotoKegiatan->refresh();

        $this->assertSame($kegiatanBaru->id_kegiatan, $fotoKegiatan->id_kegiatan);
        $this->assertSame('Foto sudah diperbarui.', $fotoKegiatan->keterangan);
        $this->assertFalse(Storage::disk('public')->exists($pathAwal));
        $this->assertTrue(Storage::disk('public')->exists($fotoKegiatan->foto));
    }

    public function test_authenticated_user_can_delete_foto_kegiatan(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $operator = $this->createOperatorForUser($user);
        $kegiatan = $this->createKegiatan($operator);
        $path = UploadedFile::fake()->image('hapus.jpg')->store('foto-kegiatan', 'public');

        $fotoKegiatan = FotoKegiatan::create([
            'id_kegiatan' => $kegiatan->id_kegiatan,
            'foto' => $path,
            'keterangan' => 'Foto yang akan dihapus.',
            'created_by' => $operator->id,
        ]);

        $response = $this->actingAs($user)->delete(route('foto-kegiatan.destroy', $fotoKegiatan));

        $response->assertRedirect(route('foto-kegiatan.index'));
        $this->assertDatabaseMissing('foto_kegiatan', [
            'id_foto_kegiatan' => $fotoKegiatan->id_foto_kegiatan,
        ]);
        $this->assertFalse(Storage::disk('public')->exists($path));
    }

    public function test_custom_user_without_create_permission_cannot_create_foto_kegiatan(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'role' => User::ROLE_CUSTOM,
            'permissions' => ['dashboard.view', 'foto_kegiatan.view'],
        ]);
        $operator = $this->createOperatorForUser($user);
        $kegiatan = $this->createKegiatan($operator);

        $response = $this->actingAs($user)->post(route('foto-kegiatan.store'), [
            'id_kegiatan' => $kegiatan->id_kegiatan,
            'foto' => UploadedFile::fake()->image('blocked.jpg')->size(500),
            'keterangan' => 'Tidak boleh tersimpan.',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseCount('foto_kegiatan', 0);
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

    protected function createKegiatan(Operator $operator, string $namaKegiatan = 'Kegiatan Dokumentasi'): Kegiatan
    {
        return Kegiatan::create([
            'nama_kegiatan' => $namaKegiatan,
            'deskripsi' => '<p>Deskripsi kegiatan.</p>',
            'id' => $operator->id,
        ]);
    }
}