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
        Schema::table('assets', function (Blueprint $table) {

            // Specifications
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('manufacturer')->nullable();

            // Assignment
            $table->string('assigned_to')->nullable();
            $table->string('department')->nullable();
            $table->string('location')->nullable();

             // Acquisition
            $table->date('acquisition_date')->nullable();
            $table->decimal('acquisition_cost', 12, 2)->nullable();
            $table->string('supplier')->nullable();
            $table->date('warranty_expiry')->nullable();

        });
    }

    public function down(): void
{
    Schema::table('assets', function (Blueprint $table) {

        $table->dropColumn([
            'brand',
            'model',
            'serial_number',
            'manufacturer',
            'assigned_to',
            'department',
            'location',
            'acquisition_date',
            'acquisition_cost',
            'supplier',
            'warranty_expiry',
        ]);

    });
}

};
