<?php

namespace Tests\Feature;

use App\Models\JenisJurnal;
use App\Models\Kas;
use App\Models\Operator;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JurnalKasCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_jurnal_kas_index(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->createOperatorForUser($user);

        $response = $this->actingAs($user)->get(route('jurnal-kas.index'));

        $response->assertOk();
        $response->assertSee('Jurnal Kas');
    }

    public function test_admin_can_manage_transaction_type(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $operator = $this->createOperatorForUser($user);

        $response = $this->actingAs($user)->post(route('jurnal-kas.types.store'), [
            'nm_jurnal' => 'Biaya Transport',
            'tipe' => 1,
        ]);

        $response->assertRedirect(route('jurnal-kas.types.index'));

        $this->assertDatabaseHas('jenis_jurnal', [
            'nm_jurnal' => 'Biaya Transport',
            'tipe' => 1,
            'update_at' => $operator->id,
        ]);
    }

    public function test_authenticated_user_can_create_expense_and_sync_kas_balance(): void
    {
        $user = User::factory()->create(['name' => 'Petugas Kas', 'role' => 'user']);
        $operator = $this->createOperatorForUser($user);
        $type = JenisJurnal::create([
            'nm_jurnal' => 'Pembelian ATK',
            'tipe' => 1,
            'created_by' => now(),
            'update_at' => $operator->id,
        ]);
        Kas::create([
            'saldo' => 0,
            'created_by' => now(),
            'update_at' => $operator->id,
        ]);

        $response = $this->actingAs($user)->post(route('jurnal-kas.expenses.store'), [
            'idjenis' => $type->idjenis,
            'ket' => 'Pembelian alat tulis kantor',
            'carabayar' => 'TUNAI',
            'nominal' => 150000,
        ]);

        $response->assertRedirect(route('jurnal-kas.index'));

        $this->assertDatabaseHas('jurnal', [
            'ket' => 'Pembelian alat tulis kantor',
            'petugas' => 'Petugas Kas',
            'idjenis' => $type->idjenis,
            'debit' => 150000,
            'kredit' => 0,
            'update_at' => $operator->id,
        ]);

        $this->assertSame(-150000.0, (float) Kas::query()->first()->saldo);
    }

    protected function createOperatorForUser(User $user): Operator
    {
        return Operator::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'password' => $user->password,
            'role' => $user->role,
            'phone_number' => '081234567890',
            'full_address' => 'Alamat operator',
        ]);
    }
}