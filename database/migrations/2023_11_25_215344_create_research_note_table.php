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
        Schema::create('research_note', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('item_id')->nullable();
            $table->unsignedBigInteger('recipe_id')->nullable();
            $table->string('name')->nullable();
            $table->json('disciplines')->nullable(); 
            $table->integer('min_rating')->nullable(); 
            $table->integer('avg_output')->nullable(); 
            $table->json('ingredients')->nullable(); 
            $table->integer('buy_price')->nullable();
            $table->integer('sell_price')->nullable();

            $table->foreign('item_id')->references('id')->on('items')->onUpdate('cascade');
            $table->foreign('recipe_id')->references('id')->on('recipes')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('research_note');
    }
};
