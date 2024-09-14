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
        Schema::create('fishing_hole_drop_rates', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('item_id')->nullable();
            $table->unsignedBigInteger('fish_id')->nullable();
            $table->unsignedBigInteger('fishing_hole_id')->nullable();
            $table->unsignedBigInteger('bag_id')->nullable();

            $table->foreign('item_id')->references('id')->on('items')->onUpdate('cascade');
            $table->foreign('fish_id')->references('id')->on('fishes')->onUpdate('cascade');
            $table->foreign('fishing_hole_id')->references('id')->on('fishing_holes')->onUpdate('cascade');
            $table->foreign('bag_id')->references('id')->on('bags')->onUpdate('cascade');

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
        Schema::dropIfExists('fishing_hole_drop_rates');
    }
};
