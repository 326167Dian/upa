<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('operators', function (Blueprint $table) {
            $table->string('username')->nullable()->after('name');
            $table->string('password')->nullable()->after('username');
        });

        $reservedUsernames = DB::table('users')
            ->pluck('username')
            ->filter()
            ->map(static fn (?string $username): string => strtolower((string) $username))
            ->all();

        DB::table('operators')
            ->leftJoin('users', 'users.id', '=', 'operators.user_id')
            ->select(
                'operators.id',
                'operators.name',
                'users.username as linked_username',
                'users.password as linked_password'
            )
            ->orderBy('operators.id')
            ->get()
            ->each(function (object $operator) use (&$reservedUsernames): void {
                $linkedUsername = strtolower((string) $operator->linked_username);

                if ($linkedUsername !== '') {
                    $username = $linkedUsername;
                } else {
                    $baseUsername = Str::slug((string) $operator->name, '') ?: 'operator'.$operator->id;
                    $username = $baseUsername;
                    $suffix = 1;

                    while (in_array($username, $reservedUsernames, true)) {
                        $username = $baseUsername.$suffix;
                        $suffix++;
                    }
                }

                $reservedUsernames[] = $username;

                DB::table('operators')
                    ->where('id', $operator->id)
                    ->update([
                        'username' => $username,
                        'password' => $operator->linked_password,
                    ]);
            });

        Schema::table('operators', function (Blueprint $table) {
            $table->unique('username');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('operators', function (Blueprint $table) {
            $table->dropUnique(['username']);
            $table->dropColumn(['username', 'password']);
        });
    }
};