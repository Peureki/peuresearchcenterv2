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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('type')->nullable();
            $table->unsignedBigInteger('output_item_id')->nullable();
            $table->integer('output_item_count')->nullable();
            $table->integer('time_to_craft_ms')->nullable();
            $table->json('disciplines')->nullable();
            $table->integer('min_rating')->nullable();
            $table->json('flags')->nullable();
            $table->json('ingredients')->nullable();
            $table->json('guild_ingredients')->nullable();
            $table->string('chat_link')->nullable();

            $table->foreign('output_item_id')->references('id')->on('items')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipes');
    }
};
