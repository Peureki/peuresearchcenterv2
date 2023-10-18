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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('chat_link')->nullable();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->integer('level')->nullable();
            $table->string('name')->nullable();
            $table->string('rarity')->nullable();
            $table->string('type')->nullable();
            $table->integer('vendor_value')->nullable();
            $table->integer('buy_quantity')->nullable();
            $table->integer('buy_price')->nullable();
            $table->integer('sell_quantity')->nullable();
            $table->integer('sell_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
};
