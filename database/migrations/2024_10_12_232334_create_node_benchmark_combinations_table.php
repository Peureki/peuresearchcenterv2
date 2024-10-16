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
        Schema::create('node_benchmark_combinations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('node_benchmark_id')->nullable();
            $table->unsignedBigInteger('pick_id')->nullable();
            $table->unsignedBigInteger('axe_id')->nullable();
            $table->unsignedBigInteger('sickle_id')->nullable();
            $table->unsignedBigInteger('most_valued_item_id')->nullable();

            $table->foreign('node_benchmark_id')
            ->references('id')
            ->on('node_benchmarks')
            ->onUpdate('cascade');

            $table->foreign('pick_id')
            ->references('id')
            ->on('items')
            ->onUpdate('cascade');
            
            $table->foreign('axe_id')
            ->references('id')
            ->on('items')
            ->onUpdate('cascade');

            $table->foreign('sickle_id')
            ->references('id')
            ->on('items')
            ->onUpdate('cascade');

            $table->foreign('most_valued_item_id')
            ->references('id')
            ->on('items')
            ->onUpdate('cascade');

            $table->string('pick')->nullable();
            $table->string('axe')->nullable();
            $table->string('sickle')->nullable();
            $table->integer('value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('node_benchmark_combinations');
    }
};
