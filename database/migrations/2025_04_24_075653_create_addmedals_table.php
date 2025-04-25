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
        Schema::create('addmedals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id')->nullable(); // Use appropriate type
            $table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade'); // Define the action on delete
            $table->unsignedBigInteger('medal_id')->nullable(); // Use appropriate type
            $table->foreign('medal_id')->references('id')->on('medals')->onDelete('cascade'); // Define the action on delete
            $table->unsignedBigInteger('reference_id')->nullable(); // Use appropriate type
            $table->foreign('reference_id')->references('id')->on('references')->onDelete('cascade'); // Define the action on delete
            
            $table->unsignedBigInteger('rtype_id')->nullable(); // Use appropriate type
            $table->foreign('rtype_id')->references('id')->on('rtypes')->onDelete('cascade'); // Define the action on delete
            $table->date('date')->nullable(); // Or remove nullable() if it's required
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addmedals');
    }
};
