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
        Schema::create('fishing_estimates', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('fishing_hole_id')->nullable();

            $table->foreign('fishing_hole_id')->references('id')->on('fishing_holes')->onUpdate('cascade');

            $table->string('map')->nullable();
            $table->decimal('average_fishing_holes', 15, 8)->nullable();
            $table->decimal('average_time', 15, 8)->nullable();
            $table->decimal('time_variable', 15, 8)->nullable();
            $table->decimal('estimate_variable', 15, 8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fishing_estimates');
    }
};
