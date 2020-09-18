<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fullname')->comment("User Full Name");
            $table->string('title')->comment('User title');
            $table->enum('role', ['Admin', 'Employee'])->comment("User Access level in the system");
            $table->enum('level', ['Merchanic', 'Finisher'])->nullable()->comment("Employee level");
            $table->string('username')->unique()->comment("Unique Identifier in the system");
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
