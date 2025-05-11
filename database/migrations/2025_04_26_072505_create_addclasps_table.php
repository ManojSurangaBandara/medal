<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addclasps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->unsignedBigInteger('medal_id');
            $table->unsignedBigInteger('clasp_profile_id');
            $table->unsignedBigInteger('rtype_id');
            $table->date('date');
            $table->string('file', 1000);
            $table->string('person_name');
            $table->string('person_rank');
            $table->boolean('is_un')->default(false);
            $table->unsignedBigInteger('country_id')->nullable();
            $table->date('from')->nullable();
            $table->date('to')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addclasps');
    }
};
