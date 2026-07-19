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

Schema::table('asset_photo_changes', function (Blueprint $table) {
    $table->foreignId('asset_photo_id')
        ->nullable()
        ->after('asset_id')
        ->constrained('asset_photos')
        ->nullOnDelete();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asset_photo_changes', function (Blueprint $table) {
            //
        });
    }
};
