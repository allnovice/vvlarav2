<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.*/
public function up(): void
{
    Schema::create('asset_history_changes', function (Blueprint $table) {
        $table->id();

        $table->foreignId('asset_id')->constrained()->cascadeOnDelete();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();

        $table->string('type');
        $table->string('title');
        $table->text('description')->nullable();
        $table->string('performed_by');
        $table->dateTime('performed_at');
        $table->text('remarks')->nullable();

        $table->string('status')->default('pending');

        $table->foreignId('approved_by')->nullable()->constrained('users');
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
        Schema::dropIfExists('asset_history_changes');
    }
};
