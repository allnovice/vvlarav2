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
    Schema::table('users', function (Blueprint $table) {
        $table->string('department')->nullable()->after('email');
        $table->string('position')->nullable()->after('department');
        $table->string('contact_no')->nullable()->after('position');

        $table->string('role')->default('employee')->after('contact_no');

        $table->boolean('is_active')->default(true)->after('role');

        $table->timestamp('verified_at')->nullable()->after('is_active');

        $table->foreignId('verified_by')
            ->nullable()
            ->constrained('users')
            ->nullOnDelete()
            ->after('verified_at');
    });
}

    /**
     * Reverse the migrations.
     */
public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropConstrainedForeignId('verified_by');

        $table->dropColumn([
            'department',
            'position',
            'contact_no',
            'role',
            'is_active',
            'verified_at',
        ]);
    });
}



};
