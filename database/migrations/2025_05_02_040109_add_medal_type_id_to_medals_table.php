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
        Schema::table('medals', function (Blueprint $table) {
            $table->unsignedBigInteger('medal_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medals', function (Blueprint $table) {
            $table->dropColumn('medal_type_id');
        });
    }
};
