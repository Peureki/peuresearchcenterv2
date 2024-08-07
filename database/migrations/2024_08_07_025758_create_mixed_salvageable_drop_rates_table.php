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
        Schema::create('mixed_salvageable_drop_rates', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('currency_id')->nullable();
            $table->unsignedBigInteger('mixed_salvageable_id')->nullable();

            $table->foreign('curency_id')
                ->references('id')
                ->on('currencies')
                ->onUpdate('cascade');

            $table->foreign('mixed_salvageable_id')
                ->references('id')
                ->on('mixed_salvageables')
                ->onUpdate('cascade');

            $table->decimal('drop_rate', 15, 8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mixed_salvageable_drop_rates');
    }
};
