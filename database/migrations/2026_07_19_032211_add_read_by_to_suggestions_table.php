<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('suggestions', function (Blueprint $table) {
            $table->unsignedBigInteger('read_by')->nullable()->after('responded_at');
            $table->timestamp('read_at')->nullable()->after('read_by');
        });
    }

    public function down(): void
    {
        Schema::table('suggestions', function (Blueprint $table) {
            $table->dropColumn(['read_by', 'read_at']);
        });
    }
};
