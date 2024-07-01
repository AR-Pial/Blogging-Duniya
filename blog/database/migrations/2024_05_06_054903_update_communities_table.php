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
        Schema::table('communities', function (Blueprint $table) {

            $table->dropColumn('type');
            $table->enum('visibility', ['public', 'private', 'closed'])->default('public')->after('type');
            $table->string('short_title')->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('communities', function (Blueprint $table) {
            $table->enum('type', ['private', 'private', 'closed'])->default('public');
            $table->dropColumn('visibility');
        });
    }
};
