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

Schema::create('asset_photo_changes', function (Blueprint $table) {
    $table->id();

    $table->foreignId('asset_id')
        ->constrained()
        ->cascadeOnDelete();

    $table->foreignId('submitted_by')
        ->constrained('users')
        ->cascadeOnDelete();

    $table->string('photo_path');

    $table->string('caption')->nullable();

    $table->enum('status', [
        'pending',
        'approved',
        'rejected',
    ])->default('pending');

    $table->foreignId('reviewed_by')
        ->nullable()
        ->constrained('users')
        ->nullOnDelete();

    $table->timestamp('reviewed_at')->nullable();

    $table->text('remarks')->nullable();

    $table->timestamps();
});




    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_photo_changes');
    }
};
