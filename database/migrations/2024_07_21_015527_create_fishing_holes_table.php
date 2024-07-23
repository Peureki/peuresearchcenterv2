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
        Schema::create('fishing_holes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('bait_id')->nullable();

            $table->foreign('bait_id')->references('id')->on('items')->onUpdate('cascade');

            $table->string('name')->nullable();
            $table->string('region')->nullable();
            $table->string('time')->nullable();
            $table->integer('fishing_power')->nullable();
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
        Schema::dropIfExists('fishing_holes');
    }
};
