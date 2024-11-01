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
        Schema::create('gathering_tools', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('item_id')->nullable();

            $table->foreign('item_id')
            ->references('id')
            ->on('items')
            ->onUpdate('cascade');

            $table->string('type')->nullable();
            $table->integer('max_cast')->nullable();
            $table->integer('min_cast')->nullable();
            $table->boolean('animation_locked')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gathering_tools');
    }
};
