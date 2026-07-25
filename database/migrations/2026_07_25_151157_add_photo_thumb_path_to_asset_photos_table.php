<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::table('asset_photos', function (Blueprint $table) {
        $table->string('photo_thumb_path')->nullable()->after('photo_path');
    });
}

public function down(): void
{
    Schema::table('asset_photos', function (Blueprint $table) {
        $table->dropColumn('photo_thumb_path');
    });
}
};
