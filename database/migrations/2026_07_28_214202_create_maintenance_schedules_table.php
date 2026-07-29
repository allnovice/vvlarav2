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
    Schema::create('maintenance_schedules', function (Blueprint $table) {
        $table->id();

        $table->foreignId('asset_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->unique('asset_id');

        $table->date('maintenance_date');

        $table->string('frequency');

        $table->unsignedInteger('custom_interval')->nullable();

        $table->date('next_due_date');

        $table->text('notes')->nullable();

        $table->foreignId('created_by')
            ->constrained('users');

        $table->foreignId('updated_by')
            ->nullable()
            ->constrained('users');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_schedules');
    }
};
