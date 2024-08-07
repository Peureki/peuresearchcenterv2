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
        Schema::create('copper_fed_salvageables', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreign('id')->references('id')->on('items')->onUpdate('cascade');

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
        Schema::dropIfExists('copper_fed_salvageables');
    }
};
