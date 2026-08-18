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
        Schema::table('tagged_and_validated_applicants', function (Blueprint $table) {
            //changing the column type in place
             $table->foreignId('tribe_id')->nullable()->after('tribe')->constrained('tribes');

        });

        
        Schema::table('tagged_and_validated_applicants', function (Blueprint $table) {
            $table->dropColumn('tribe'); // remove old column once data is migrated
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('[tagged_and_validated_applicants]', function (Blueprint $table) {
            $table->dropForeign(['tribe_id']);
            $table->dropColumn('tribe_id');
            $table->string('tribe')->nullable();
        });
    }
};
