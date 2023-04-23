<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_ratings', function (Blueprint $table) {
            $table->id();
            $table->longText('review');
            $table->bigInteger('happiness');
            $table->bigInteger('internet');
            $table->bigInteger('safety');
            $table->bigInteger('opportunities');
            $table->bigInteger('location');
            $table->bigInteger('reputation');
            $table->bigInteger('facilities');
            $table->bigInteger('social');
            $table->bigInteger('food');
            $table->bigInteger('clubs');
            $table->float('overallRating');
            $table->bigInteger('school_id')->unsigned();
            $table->foreign('school_id')->references('id')->on('schools');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->nullable();
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
        Schema::dropIfExists('school_ratings');
    }
};
