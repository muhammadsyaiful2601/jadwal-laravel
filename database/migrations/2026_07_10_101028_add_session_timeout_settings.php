<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Insert default session timeout settings
        \Illuminate\Support\Facades\DB::table('settings')->updateOrInsert(
            ['setting_key' => 'session_timeout_minutes'],
            [
                'setting_value' => '30',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        \Illuminate\Support\Facades\DB::table('settings')->updateOrInsert(
            ['setting_key' => 'session_auto_logout_enabled'],
            [
                'setting_value' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
