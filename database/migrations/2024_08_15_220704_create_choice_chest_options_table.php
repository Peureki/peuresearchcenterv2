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
        Schema::create('choice_chest_options', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('item_id')->nullable();
            $table->unsignedBigInteger('bag_id')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->unsignedBigInteger('choice_chest_id')->nullable();

            $table->string('option')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('currency_quantity')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('choice_chest_options');
    }
};
