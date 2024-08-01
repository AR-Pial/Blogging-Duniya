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
        Schema::create('community_location', function (Blueprint $table) {
            $table->foreignUuid('community_id')->constrained()->onDelete('cascade');
            $table->string('country'); 
            $table->primary(['community_id', 'country']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_location');
    }
};
