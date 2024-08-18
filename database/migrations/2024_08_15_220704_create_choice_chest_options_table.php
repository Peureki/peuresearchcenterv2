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

            $table->foreign('item_id')
                ->references('id')
                ->on('items')
                ->onUpdate('cascade');

            $table->foreign('bag_id')
                ->references('id')
                ->on('bags')
                ->onUpdate('cascade');

            $table->foreign('currency_id')
                ->references('id')
                ->on('currencies')
                ->onUpdate('cascade');

            $table->foreign('choice_chest_id')
                ->references('id')
                ->on('choice_chests')
                ->onUpdate('cascade');

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
