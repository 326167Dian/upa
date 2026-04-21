<?php

namespace Tests\Feature;

use App\Models\Kegiatan;
use App\Models\Kehadiran;
use App\Models\Operator;
use App\Models\User;
use App\Support\FeaturePermission;
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

    public function test_non_admin_create_form_locks_operator_to_logged_in_user(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_USER,
            'permissions' => FeaturePermission::defaultUserPermissions(),
            'name' => 'Maulana',
        ]);
        $ownOperator = Operator::create([
            'user_id' => $user->id,
            'name' => 'Maulana',
            'username' => $user->username,
            'password' => $user->password,
            'role' => User::ROLE_USER,
            'permissions' => FeaturePermission::defaultUserPermissions(),
            'phone_number' => '081200000003',
            'full_address' => 'Alamat maulana',
        ]);
        Operator::create([
            'name' => 'Operator Lain',
            'username' => 'operatorlain',
            'password' => $user->password,
            'role' => User::ROLE_USER,
            'phone_number' => '081200000004',
            'full_address' => 'Alamat operator lain',
        ]);

        $response = $this->actingAs($user)->get(route('kehadiran.create'));

        $response->assertOk();
        $response->assertSee('value="'.$ownOperator->id.'"', false);
        $response->assertSee('value="Maulana"', false);
        $response->assertDontSee('Pilih operator');
        $response->assertDontSee('Operator Lain');
    }

    public function test_non_admin_kehadiran_store_is_forced_to_logged_in_operator(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_USER,
            'permissions' => FeaturePermission::defaultUserPermissions(),
            'name' => 'Maulana',
        ]);
        $ownOperator = Operator::create([
            'user_id' => $user->id,
            'name' => 'Maulana',
            'username' => $user->username,
            'password' => $user->password,
            'role' => User::ROLE_USER,
            'permissions' => FeaturePermission::defaultUserPermissions(),
            'phone_number' => '081200000005',
            'full_address' => 'Alamat maulana',
        ]);
        $otherOperator = Operator::create([
            'name' => 'Operator Lain',
            'username' => 'operatorlain2',
            'password' => $user->password,
            'role' => User::ROLE_USER,
            'phone_number' => '081200000006',
            'full_address' => 'Alamat operator lain',
        ]);
        $kegiatan = Kegiatan::create([
            'nama_kegiatan' => 'Briefing User',
            'deskripsi' => '<p>Briefing user</p>',
            'id' => $ownOperator->id,
        ]);

        $response = $this->actingAs($user)->post(route('kehadiran.store'), [
            'id' => $otherOperator->id,
            'id_kegiatan' => $kegiatan->id_kegiatan,
            'waktu' => '2026-04-21 08:00:00',
            'hadir' => '1',
            'keterangan' => 'Diisi user sendiri',
        ]);

        $response->assertRedirect(route('kehadiran.index'));

        $this->assertDatabaseHas('kehadiran', [
            'id' => $ownOperator->id,
            'id_kegiatan' => $kegiatan->id_kegiatan,
            'keterangan' => 'Diisi user sendiri',
        ]);

        $this->assertDatabaseMissing('kehadiran', [
            'id' => $otherOperator->id,
            'id_kegiatan' => $kegiatan->id_kegiatan,
            'keterangan' => 'Diisi user sendiri',
        ]);
    }

    public function test_admin_create_form_can_choose_another_operator(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'name' => 'Admin Kehadiran',
        ]);
        Operator::create([
            'user_id' => $admin->id,
            'name' => 'Admin Kehadiran',
            'username' => $admin->username,
            'password' => $admin->password,
            'role' => User::ROLE_ADMIN,
            'phone_number' => '081200000007',
            'full_address' => 'Alamat admin',
        ]);
        Operator::create([
            'name' => 'Operator Target',
            'username' => 'operatortarget',
            'password' => $admin->password,
            'role' => User::ROLE_USER,
            'phone_number' => '081200000008',
            'full_address' => 'Alamat operator target',
        ]);

        $response = $this->actingAs($admin)->get(route('kehadiran.create'));

        $response->assertOk();
        $response->assertSee('Pilih operator');
        $response->assertSee('Admin Kehadiran');
        $response->assertSee('Operator Target');
        $response->assertDontSee('readonly');
    }

    public function test_admin_can_store_kehadiran_for_another_operator(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'name' => 'Admin Kehadiran',
        ]);
        $adminOperator = Operator::create([
            'user_id' => $admin->id,
            'name' => 'Admin Kehadiran',
            'username' => $admin->username,
            'password' => $admin->password,
            'role' => User::ROLE_ADMIN,
            'phone_number' => '081200000009',
            'full_address' => 'Alamat admin',
        ]);
        $targetOperator = Operator::create([
            'name' => 'Operator Target',
            'username' => 'operatortarget2',
            'password' => $admin->password,
            'role' => User::ROLE_USER,
            'phone_number' => '081200000010',
            'full_address' => 'Alamat operator target',
        ]);
        $kegiatan = Kegiatan::create([
            'nama_kegiatan' => 'Pendampingan Operator',
            'deskripsi' => '<p>Pendampingan operator</p>',
            'id' => $adminOperator->id,
        ]);

        $response = $this->actingAs($admin)->post(route('kehadiran.store'), [
            'id' => $targetOperator->id,
            'id_kegiatan' => $kegiatan->id_kegiatan,
            'waktu' => '2026-04-21 09:15:00',
            'hadir' => '1',
            'keterangan' => 'Diisi oleh admin untuk operator target',
        ]);

        $response->assertRedirect(route('kehadiran.index'));

        $this->assertDatabaseHas('kehadiran', [
            'id' => $targetOperator->id,
            'id_kegiatan' => $kegiatan->id_kegiatan,
            'keterangan' => 'Diisi oleh admin untuk operator target',
        ]);

        $this->assertDatabaseMissing('kehadiran', [
            'id' => $adminOperator->id,
            'id_kegiatan' => $kegiatan->id_kegiatan,
            'keterangan' => 'Diisi oleh admin untuk operator target',
        ]);
    }
}