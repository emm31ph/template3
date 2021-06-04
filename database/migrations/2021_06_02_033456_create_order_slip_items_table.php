<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderSlipItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_slip_items', function (Blueprint $table) {
            $table->bigIncrements('line');
            $table->string('os_id');
            $table->string('itemcode', 50);
            $table->decimal('tinsqty', 36, 0)->nullable();
            $table->decimal('qty', 36, 0)->nullable();
            $table->string('unit', 5);
            $table->decimal('unit_price', 36, 0)->nullable();
            $table->decimal('discount', 36, 0)->nullable();
            $table->decimal('total', 36, 0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_slip_items');
    }
}
