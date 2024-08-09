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
        Schema::create('map_benchmark_drop_rates', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('map_benchmark_id')->nullable();
            $table->unsignedBigInteger('copper_fed_salvageable_id')->nullable();
            $table->unsignedBigInteger('runecrafters_salvageable_id')->nullable();
            $table->unsignedBigInteger('silver_fed_salvageable_id')->nullable();
            $table->unsignedBigInteger('mixed_salvageable_id')->nullable();
            $table->unsignedBigInteger('bag_id')->nullable();
            $table->unsignedBigInteger('fish_id')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();


            $table->foreign('map_benchmark_id')->references('id')->on('map_benchmarks')->onUpdate('cascade');
            $table->foreign('copper_fed_salvageable_id')->references('id')->on('copper_fed_salvageables')->onUpdate('cascade');
            $table->foreign('runecrafters_salvageable_id')->references('id')->on('runecrafters_salvageables')->onUpdate('cascade');
            $table->foreign('silver_fed_salvageable_id')->references('id')->on('silver_fed_salvageables')->onUpdate('cascade');
            $table->foreign('mixed_salvageable_id')->references('id')->on('mixed_salvageables')->onUpdate('cascade');
            $table->foreign('bag_id')->references('id')->on('bags')->onUpdate('cascade');
            $table->foreign('fish_id')->references('id')->on('fishes')->onUpdate('cascade');
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
        Schema::dropIfExists('map_benchmark_drop_rates');
    }
};
