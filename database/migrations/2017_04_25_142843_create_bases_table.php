<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('variation_id')->unsigned();
            $table->integer('pattern_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('version',10);
            $table->string('note','150');
            $table->string('column',10);
            $table->string('name',150);
            $table->string('used_by',100);
            $table->integer('used')->unsigned();
            $table->string('url');
            $table->string('leader_check_name');
            $table->integer('leader_check_result')->unsigned();
            $table->string('leader_check_problem');
            $table->string('first_checker_name');
            $table->integer('first_checker_result')->unsigned;
            $table->string('first_checker_problem');
            $table->string('second_checker_name');
            $table->string('second_checker_result',10);
            $table->string('second_checker_problem');
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
        Schema::dropIfExists('bases');
    }
}
