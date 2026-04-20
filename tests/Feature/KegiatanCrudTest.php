<?php

namespace Tests\Feature;

use App\Models\Kegiatan;
use App\Models\Operator;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KegiatanCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_kegiatan_index(): void
    {
        $user = User::factory()->create();
        Operator::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'role' => $user->role,
            'phone_number' => '-',
            'full_address' => 'Belum diisi',
        ]);

        $response = $this->actingAs($user)->get(route('kegiatan.index'));

        $response->assertOk();
        $response->assertSee('Data Kegiatan');
    }

    public function test_authenticated_user_can_create_kegiatan_and_store_operator_reference(): void
    {
        $user = User::factory()->create(['name' => 'Pembuat Kegiatan', 'role' => 'admin']);
        $operator = Operator::create([
            'user_id' => $user->id,
            'name' => 'Pembuat Kegiatan',
            'role' => 'admin',
            'phone_number' => '08100000001',
            'full_address' => 'Alamat pembuat',
        ]);

        $response = $this->actingAs($user)->post(route('kegiatan.store'), [
            'nama_kegiatan' => 'Rapat Koordinasi',
            'deskripsi' => '<p>Rapat koordinasi mingguan.</p>',
        ]);

        $response->assertRedirect(route('kegiatan.index'));

        $this->assertDatabaseHas('kegiatan', [
            'nama_kegiatan' => 'Rapat Koordinasi',
            'id' => $operator->id,
        ]);
    }

    public function test_authenticated_user_can_update_kegiatan(): void
    {
        $user = User::factory()->create(['name' => 'Editor Kegiatan', 'role' => 'user']);
        $operator = Operator::create([
            'user_id' => $user->id,
            'name' => 'Editor Kegiatan',
            'role' => 'user',
            'phone_number' => '08100000002',
            'full_address' => 'Alamat editor',
        ]);
        $kegiatan = Kegiatan::create([
            'nama_kegiatan' => 'Draft Kegiatan',
            'deskripsi' => '<p>Draft lama</p>',
            'id' => $operator->id,
        ]);

        $response = $this->actingAs($user)->put(route('kegiatan.update', $kegiatan), [
            'nama_kegiatan' => 'Draft Final',
            'deskripsi' => '<p>Draft baru</p>',
        ]);

        $response->assertRedirect(route('kegiatan.index'));

        $this->assertDatabaseHas('kegiatan', [
            'id_kegiatan' => $kegiatan->id_kegiatan,
            'nama_kegiatan' => 'Draft Final',
            'id' => $operator->id,
        ]);
    }

    public function test_authenticated_user_can_delete_kegiatan(): void
    {
        $user = User::factory()->create();
        Operator::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'role' => $user->role,
            'phone_number' => '-',
            'full_address' => 'Belum diisi',
        ]);
        $kegiatan = Kegiatan::create([
            'nama_kegiatan' => 'Kegiatan Hapus',
            'deskripsi' => '<p>Hapus saya</p>',
            'id' => Operator::first()->id,
        ]);

        $response = $this->actingAs($user)->delete(route('kegiatan.destroy', $kegiatan));

        $response->assertRedirect(route('kegiatan.index'));
        $this->assertDatabaseMissing('kegiatan', [
            'id_kegiatan' => $kegiatan->id_kegiatan,
        ]);
    }
}