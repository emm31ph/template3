<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceCustomerListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_customer_lists', function (Blueprint $table) {
            $table->id();
            $table->string('branch', 10)->nullable();
            $table->string('custno', 50)->nullable();
            $table->string('itemcode', 50); 
            $table->decimal('price',18,0)->default(0); 
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
        Schema::dropIfExists('price_customer_lists');
    }
}
