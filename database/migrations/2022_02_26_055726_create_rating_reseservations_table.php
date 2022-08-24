<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingReseservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rating_reseservations', function (Blueprint $table) {
            $table->id();
            $table->string('rating');
            $table->string('note');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('chef_id')->unsigned();
            $table->foreign('chef_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('reservations_id')->unsigned();
            $table->foreign('reservations_id')->references('id')->on('reservations')->onDelete('cascade');
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
        Schema::dropIfExists('rating_reseservations');
    }
}
