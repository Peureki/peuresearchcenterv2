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
        Schema::table('users', function (Blueprint $table) {
            $table->json('includes')->nullable();
            $table->json('filter_research_notes')->nullable();
            $table->string('settings_buy_order')->default('buy_price')->nullable();
            $table->string('settings_sell_order')->default('sell_price')->nullable();
            $table->decimal('settings_tax', 8, 2)->default(0.85)->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
