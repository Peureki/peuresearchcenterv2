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

            $table->foreign('item_id')->references('id')->on('items')->onUpdate('cascade');
            $table->foreign('recipe_id')->references('id')->on('recipes')->onUpdate('cascade');

            $table->decimal('avg_output', 8, 2)->nullable(); 
            $table->json('ingredients')->nullable(); 
            $table->integer('crafting_value')->nullable();
            $table->string('preference')->nullable();
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
