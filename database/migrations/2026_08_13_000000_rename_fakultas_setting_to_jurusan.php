<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Politeknik tidak menggunakan "fakultas".
     * Pindahkan nilai setting lama 'fakultas' menjadi 'jurusan'.
     * Nilai lama yang masih berisi default "Fakultas Teknik" diabaikan
     * agar "Fakultas Teknik" tidak muncul lagi; admin mengisi jurusan secara manual.
     */
    public function up(): void
    {
        $old = DB::table('settings')->where('setting_key', 'fakultas')->value('setting_value');

        // Hanya pertahankan jika admin pernah mengisi nilai selain default yang tidak dipakai.
        if (!is_null($old) && trim($old) !== '' && strtolower(trim($old)) !== 'fakultas teknik') {
            $exists = DB::table('settings')->where('setting_key', 'jurusan')->exists();
            if (!$exists) {
                DB::table('settings')->insert([
                    'setting_key' => 'jurusan',
                    'setting_value' => $old,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        DB::table('settings')->where('setting_key', 'fakultas')->delete();
    }

    public function down(): void
    {
        $jurusan = DB::table('settings')->where('setting_key', 'jurusan')->value('setting_value');

        if (!is_null($jurusan)) {
            DB::table('settings')->updateOrInsert(
                ['setting_key' => 'fakultas'],
                ['setting_value' => $jurusan, 'created_at' => now(), 'updated_at' => now()]
            );
        }

        DB::table('settings')->where('setting_key', 'jurusan')->delete();
    }
};
