<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingAdviceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_advice_items', function (Blueprint $table) {
            $table->id();
            $table->integer('docid')->nullable();
            $table->string('itemcode',50);
            $table->decimal('qty',16,0)->default(0);
            $table->string('unit',4)->nullable();
            $table->decimal('price',16,0)->default(0);
            $table->decimal('total',16,0)->default(0);
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
        Schema::dropIfExists('shipping_advice_items');
    }
}
