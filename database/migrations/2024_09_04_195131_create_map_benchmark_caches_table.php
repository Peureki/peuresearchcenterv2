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
        Schema::create('map_benchmark_caches', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('cache_key')->unique(); 
            $table->json('includes');
            $table->string('sell_order_setting');
            $table->decimal('tax', 8, 2);
            $table->json('drop_rates');
            $table->json('benchmarks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('map_benchmark_caches');
    }
};
