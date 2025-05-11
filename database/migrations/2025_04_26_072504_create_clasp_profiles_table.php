<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clasp_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no');
            $table->unsignedBigInteger('rtype_id');
            $table->date('date');
            $table->string('file', 1000);
            $table->unsignedTinyInteger('status');
            $table->unsignedBigInteger('medal_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clasp_profiles');
    }
};
