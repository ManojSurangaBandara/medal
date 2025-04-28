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
        Schema::table('medal_profiles', function (Blueprint $table) {
            $table->renameColumn('reference', 'reference_no');
            $table->unsignedBigInteger('rtype_id');
            $table->date('date');
            $table->string('file', 1000);
            $table->unsignedTinyInteger('status');
            $table->unsignedBigInteger('medal_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medal_profiles', function (Blueprint $table) {
            //
        });
    }
};
