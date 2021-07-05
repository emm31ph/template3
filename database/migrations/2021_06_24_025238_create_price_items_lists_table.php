<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceItemsListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_items_lists', function (Blueprint $table) {
            $table->id(); 
            $table->string('itemcode', 50); 
            $table->string('pricelist',10)->nullable();
            $table->decimal('price',18,0)->default(0);
            $table->decimal('discount',18,0)->default(0);
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
        Schema::dropIfExists('price_items_lists');
    }
}
