<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovieActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie_activity', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('movie_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->integer('type')->default(0);
            $table->float('penalty', 8, 2)->default(0);
            $table->float('paid', 8, 2)->default(0);
            $table->boolean('concluded')->default(false);
            $table->timestamps();

            $table->foreign('movie_id')->references('id')->on('movie');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movie_activity');
    }
}
