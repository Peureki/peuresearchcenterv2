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
        Schema::create('glyphs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('item_id')->nullable();

            $table->foreign('item_id')
            ->references('id')
            ->on('items')
            ->onUpdate('cascade');

            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('level')->nullable();
            $table->integer('sample_size')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('glyphs');
    }
};
