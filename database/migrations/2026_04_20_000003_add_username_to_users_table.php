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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->after('name');
        });

        $existingUsernames = [];

        DB::table('users')
            ->select('id', 'name', 'email')
            ->orderBy('id')
            ->get()
            ->each(function (object $user) use (&$existingUsernames) {
                $baseUsername = Str::slug((string) $user->name, '') ?: Str::before((string) $user->email, '@');
                $baseUsername = $baseUsername !== '' ? strtolower($baseUsername) : 'user'.$user->id;

                $username = $baseUsername;
                $suffix = 1;

                while (in_array($username, $existingUsernames, true)) {
                    $username = $baseUsername.$suffix;
                    $suffix++;
                }

                $existingUsernames[] = $username;

                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['username' => $username]);
            });

        Schema::table('users', function (Blueprint $table) {
            $table->unique('username');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['username']);
            $table->dropColumn('username');
        });
    }
};