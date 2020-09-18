<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimecardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('timecards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->comment("User ID in the users table");
            $table->bigInteger('project_id')->unsigned()->comment("Project ID in the projects table");
            $table->date('date')->comment("Work date");
            $table->string('time_in')->comment("starting time");
            $table->string('time_out')->comment("ending time");
            $table->float('regulartime', 8 ,2);
            $table->float('nighttime', 8, 2);
            $table->float('overtime', 8, 2);
            $table->float('total_hours', 8, 2);
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade');
            $table->foreign('project_id')
            ->references('id')->on('projects')
            ->onDelete('cascade');
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
        Schema::dropIfExists('timecards');
    }
}
