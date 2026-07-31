<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::table('assets', function (Blueprint $table) {
        $table->timestamp('last_verified_at')->nullable()->after('updated_at');
        $table->timestamp('next_verification_due')->nullable()->after('last_verified_at');
    });
}
public function down(): void
{
    Schema::table('assets', function (Blueprint $table) {
        $table->dropColumn([
            'last_verified_at',
            'next_verification_due',
        ]);
    });
}
};
