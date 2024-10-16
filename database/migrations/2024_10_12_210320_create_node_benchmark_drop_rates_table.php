<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('node_benchmark_drop_rates', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('node_benchmark_id')->nullable();
            $table->unsignedBigInteger('node_id')->nullable();

            $table->foreign('node_benchmark_id')->references('id')->on('node_benchmarks')->onUpdate('cascade');
            $table->foreign('node_id')->references('id')->on('nodes')->onUpdate('cascade');

            $table->string('level')->nullable();
            $table->decimal('drop_rate', 15, 8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('node_benchmark_drop_rates');
    }
};
