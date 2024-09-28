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
        Schema::create('other_recipes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('output_item_id')->nullable();

            $table->foreign('output_item_id')->references('id')->on('items')->onUpdate('cascade');

            $table->json('disciplines')->nullable();
            $table->json('merchant')->nullable();
            $table->string('name')->nullable();
            $table->integer('output_item_count')->nullable();
            $table->string('merchant_data_hash')->nullable();
            $table->json('ingredients')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('other_recipes');
    }
};
