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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->longText('title');
            $table->longText('location_place');
            $table->float('happiness')->nullable();
            $table->float('internet')->nullable();
            $table->float('safety')->nullable();
            $table->float('opportunities')->nullable();
            $table->float('location')->nullable();
            $table->float('reputation')->nullable();
            $table->float('facilities')->nullable();
            $table->float('social')->nullable();
            $table->float('food')->nullable();
            $table->float('clubs')->nullable();
            $table->float('overallRating')->nullable();
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
        Schema::dropIfExists('schools');
    }
};
