<?php

namespace Tests\Feature;

use App\Models\Kegiatan;
use App\Models\Kehadiran;
use App\Models\Operator;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KehadiranCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_kehadiran_index(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('kehadiran.index'));

        $response->assertOk();
        $response->assertSee('Data Kehadiran');
    }

    public function test_authenticated_user_can_create_kehadiran(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $operator = Operator::create([
            'user_id' => $user->id,
            'name' => 'Operator Hadir',
            'role' => 'admin',
            'phone_number' => '08111111111',
            'full_address' => 'Alamat operator hadir',
        ]);
        $kegiatan = Kegiatan::create([
            'nama_kegiatan' => 'Briefing Pagi',
            'deskripsi' => '<p>Briefing pagi operator</p>',
            'id' => $operator->id,
        ]);

        $response = $this->actingAs($user)->post(route('kehadiran.store'), [
            'id' => $operator->id,
            'id_kegiatan' => $kegiatan->id_kegiatan,
            'waktu' => '2026-04-20 08:00:00',
            'hadir' => '1',
            'keterangan' => 'Datang tepat waktu',
        ]);

        $response->assertRedirect(route('kehadiran.index'));

        $this->assertDatabaseHas('kehadiran', [
            'id' => $operator->id,
            'id_kegiatan' => $kegiatan->id_kegiatan,
            'hadir' => 1,
            'keterangan' => 'Datang tepat waktu',
        ]);
    }

    public function test_authenticated_user_can_update_kehadiran(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $operator = Operator::create([
            'user_id' => $user->id,
            'name' => 'Operator Update',
            'role' => 'admin',
            'phone_number' => '08222222222',
            'full_address' => 'Alamat update',
        ]);
        $kegiatan = Kegiatan::create([
            'nama_kegiatan' => 'Pelatihan Sistem',
            'deskripsi' => '<p>Pelatihan sistem internal</p>',
            'id' => $operator->id,
        ]);
        $kehadiran = Kehadiran::create([
            'id' => $operator->id,
            'id_kegiatan' => $kegiatan->id_kegiatan,
            'waktu' => '2026-04-20 09:00:00',
            'hadir' => 0,
            'keterangan' => 'Belum hadir',
        ]);

        $response = $this->actingAs($user)->put(route('kehadiran.update', $kehadiran), [
            'id' => $operator->id,
            'id_kegiatan' => $kegiatan->id_kegiatan,
            'waktu' => '2026-04-20 09:30:00',
            'hadir' => '1',
            'keterangan' => 'Sudah hadir',
        ]);

        $response->assertRedirect(route('kehadiran.index'));

        $this->assertDatabaseHas('kehadiran', [
            'id_kehadiran' => $kehadiran->id_kehadiran,
            'hadir' => 1,
            'keterangan' => 'Sudah hadir',
        ]);
    }

    public function test_authenticated_user_can_delete_kehadiran(): void
    {
        $user = User::factory()->create();
        $operator = Operator::create([
            'name' => 'Operator Hapus Kehadiran',
            'role' => 'user',
            'phone_number' => '08333333333',
            'full_address' => 'Alamat hapus kehadiran',
        ]);
        $kegiatan = Kegiatan::create([
            'nama_kegiatan' => 'Monitoring Lapangan',
            'deskripsi' => '<p>Monitoring lapangan</p>',
            'id' => $operator->id,
        ]);
        $kehadiran = Kehadiran::create([
            'id' => $operator->id,
            'id_kegiatan' => $kegiatan->id_kegiatan,
            'waktu' => '2026-04-20 10:00:00',
            'hadir' => 1,
            'keterangan' => 'Siap tugas',
        ]);

        $response = $this->actingAs($user)->delete(route('kehadiran.destroy', $kehadiran));

        $response->assertRedirect(route('kehadiran.index'));
        $this->assertDatabaseMissing('kehadiran', [
            'id_kehadiran' => $kehadiran->id_kehadiran,
        ]);
    }
}