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
        Schema::create('mixed_salvageable_drop_rates', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('item_id')->nullable(); 
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->unsignedBigInteger('mixed_salvageable_id')->nullable(); 
            $table->decimal('drop_rate', 15, 8)->nullable();

            $table->foreign('item_id')->references('id')->on('items')->onUpdate('cascade');
            $table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('cascade');
            $table->foreign('mixed_salvageable_id')->references('id')->on('mixed_salvageables')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mixed_salvageable_drop_rates');
    }
};
