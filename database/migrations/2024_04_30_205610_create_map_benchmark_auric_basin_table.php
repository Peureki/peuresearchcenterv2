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
        Schema::create('map_benchmark_auric_basin', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('drop')->nullable(); 
            $table->decimal('drop_rate', 20, 3)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('map_benchmark_auric_basin');
    }
};
