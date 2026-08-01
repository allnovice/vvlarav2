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

Schema::create('maintenance_photos', function (Blueprint $table) {
    $table->id();

    $table->foreignId('asset_history_id')
        ->constrained()
        ->cascadeOnDelete();

    $table->string('photo_path');
    $table->string('photo_thumb_path')->nullable();

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_photos');
    }
};
