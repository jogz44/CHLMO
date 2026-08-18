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
        Schema::table('profiled_tagged_applicants', function (Blueprint $table) {
             //changing the column type in place
             $table->foreignId('religion_id')->nullable()->after('religion')->constrained('religions');
        });

         Schema::table('profiled_tagged_applicants', function (Blueprint $table) {
            $table->dropColumn('religion'); // remove old column once data is migrated
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiled_tagged_applicants', function (Blueprint $table) {
            $table->dropForeign(['religion_id']);
            $table->dropColumn('religion_id');
            $table->string('religion')->nullable();
        });
    }
};
