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
        Schema::create('currency_bag_drop_rates', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('bag_id')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->decimal('drop_rate', 10, 8)->nullable();
            // Assign foreign keys
            $table->foreign('bag_id')->references('id')->on('bags')->onUpdate('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currency_bag_drop_rates');
    }
};
