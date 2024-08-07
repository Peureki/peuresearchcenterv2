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
        Schema::create('silver_fed_salvageable_drop_rates', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('item_id')->nullable();
            $table->unsignedBigInteger('silver_fed_salvageable_id')->nullable();

            $table->foreign('item_id')
                ->references('id')
                ->on('items')
                ->onUpdate('cascade');
            $table->foreign('silver_fed_salvageable_id', 'fk_sil_sal_id')
                ->references('id')
                ->on('silver_fed_salvageables')
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
        Schema::dropIfExists('silver_fed_salvageable_drop_rates');
    }
};
