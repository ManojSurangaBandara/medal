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
        Schema::create('medal_data_old', function (Blueprint $table) {
            $table->id();
            $table->string('service_no');
            $table->string('rank')->nullable();
            $table->string('name')->nullable();
            $table->string('regiment')->nullable();
            $table->string('medal');
            $table->string('reference_string')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medal_data_old');
    }
};
