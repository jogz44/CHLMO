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
        Schema::create('shelter_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wall_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('roof_type_id')->constrained()->onDelete('cascade');
            $table->string('other_materials', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shelter_materials');
    }
};
