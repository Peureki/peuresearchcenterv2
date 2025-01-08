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
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('icon')->nullable();
            $table->string('name')->nullable();
            $table->longtext('description')->nullable();
            $table->longtext('requirement')->nullable();
            $table->string('locked_text')->nullable();
            $table->string('type')->nullable();
            $table->json('flags')->nullable();
            $table->json('tiers')->nullable();
            $table->json('prerequisites')->nullable();
            $table->json('rewards')->nullable();
            $table->json('bits')->nullable();
            $table->integer('point_cap')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
