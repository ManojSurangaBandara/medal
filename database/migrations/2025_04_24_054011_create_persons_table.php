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
        Schema::create('persons', function (Blueprint $table) {
            $table->id();
            $table->string('service_no');
            $table->string('eno');
            $table->string('name');
            $table->timestamps();
            $table->unsignedBigInteger('regiment_id')->nullable(); // Use appropriate type
            $table->foreign('regiment_id')->references('id')->on('regiments')->onDelete('cascade'); // Define the action on delete
            $table->unsignedBigInteger('rank_id')->nullable(); // Use appropriate type
            $table->foreign('rank_id')->references('id')->on('ranks')->onDelete('cascade'); // Define the action on delete
            $table->unsignedBigInteger('unit_id')->nullable(); // Use appropriate type
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade'); // Define the action on delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persons');
    }
};
