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
        Schema::create('trophy_shipment', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('item');
            $table->string('icon'); 
            $table->string('type');
            $table->string('rarity');
            $table->string('chat_link');
            $table->integer('buy_price');
            $table->integer('sell_price');
            $table->decimal('drop_rate', 10, 8); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trophy_shipment');
    }
};
