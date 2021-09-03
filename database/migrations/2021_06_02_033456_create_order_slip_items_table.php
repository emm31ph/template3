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
            $table->string('branch', 10)->nullable();
            $table->integer('docid')->nullable();
            $table->string('itemcode', 50); 
            $table->decimal('qty', 36, 0)->nullable();
            $table->string('unit', 4);
            $table->decimal('unitprice', 36, 0)->nullable();
            $table->decimal('price', 36, 0)->nullable();
            $table->decimal('discount', 36, 0)->nullable();
            $table->decimal('linetotal', 36, 0)->nullable();
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