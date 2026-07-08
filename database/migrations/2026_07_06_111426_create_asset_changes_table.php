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


Schema::create('asset_changes', function (Blueprint $table) {
    $table->id();

    $table->foreignId('asset_id')
        ->nullable()
        ->constrained()
        ->nullOnDelete();

    $table->foreignId('user_id')
        ->constrained()
        ->cascadeOnDelete();

    $table->string('action'); // create, update, delete

    $table->json('data');

    $table->string('status')->default('pending');

    $table->foreignId('approved_by')
        ->nullable()
        ->constrained('users')
        ->nullOnDelete();

    $table->timestamp('approved_at')->nullable();

    $table->text('rejection_reason')->nullable();

    $table->timestamps();
});




    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_changes');
    }
};
