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
        Schema::create('consumable_drop_rates', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('consumable_id')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();

            $table->foreign('consumable_id')->references('id')->on('consumables')->onUpdate('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onUpdate('cascade');
            $table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('cascade');

            $table->decimal('drop_rate', 15, 8)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consumable_drop_rates');
    }
};
