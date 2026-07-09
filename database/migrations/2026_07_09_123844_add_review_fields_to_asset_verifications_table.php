<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::table('asset_verifications', function (Blueprint $table) {

        $table->string('attachment_path')
            ->nullable()
            ->after('remarks');

        $table->text('reviewer_remarks')
            ->nullable()
            ->after('attachment_path');

    });
}

public function down(): void
{
    Schema::table('asset_verifications', function (Blueprint $table) {

        $table->dropColumn([
            'attachment_path',
            'reviewer_remarks',
        ]);

    });
}
};
