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
        Schema::create('fishes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            
            $table->unsignedBigInteger('bait_id')->nullable();

            $table->foreign('id')->references('id')->on('items')->onUpdate('cascade');
            $table->foreign('bait_id')->references('id')->on('items')->onUpdate('cascade');

            $table->string('map')->nullable();
            $table->string('fishing_hole')->nullable();
            $table->string('time')->nullable();
            $table->integer('sample_size')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fishes');
    }
};
