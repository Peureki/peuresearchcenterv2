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
        Schema::create('map_benchmarks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('map')->nullable();
            $table->string('type')->nullable();
            $table->string('drops')->nullable(); 
            $table->decimal('drop_rates', 10, 8)->nullable();
            $table->integer('sample_size')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('map_benchmarks');
    }
};
