<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('service_no');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            // $table->boolean('active')->default(0);
            // $table->timestamp('active_date_time')->nullable();
            // $table->foreignId('role_id')->nullable()->constrained();
            // $table->foreignId('location_id')->nullable()->constrained();
            // $table->foreignId('rank_id')->nullable()->constrained();
            // $table->foreignId('unit_id')->nullable()->constrained();
            $table->tinyInteger('active')->default(0);
            $table->dateTime('active_date_time')->nullable();
            // $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('role_id')->nullable(); // Use appropriate type
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            // $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('regiment_id')->nullable(); // Use appropriate type
            $table->foreign('regiment_id')->references('id')->on('regiments')->onDelete('cascade'); // Define the action on delete
            // $table->foreignId('rank_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('rank_id')->nullable(); // Use appropriate type
            $table->foreign('rank_id')->references('id')->on('ranks')->onDelete('cascade'); // Define the action on delete
            // $table->foreignId('unit_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('unit_id')->nullable(); // Use appropriate type
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade'); // Define the action on delete
            // Define the action on delete
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
