<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderSlipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_slips', function (Blueprint $table) {
            $table->bigIncrements('docid');
            $table->string('batch');
            $table->string('branch', 10)->nullable();
            $table->string('custno', 50)->nullable()->comment('customer id');
            $table->integer('user_id')->comment('user');
            $table->integer('salesperson')->comment('salesperson');
            $table->date('trndate')->nullable();
            $table->string('sono')->nullable();
            $table->string('pono')->nullable();
            $table->date('deliverydate')->nullable();
            $table->string('terms')->nullable();
            $table->string('address')->nullable();
            $table->string('deliver_to')->nullable(); 
            $table->decimal('totalamount', 36, 0)->nullable();
            $table->decimal('totaldiscount', 36, 0)->nullable();
            $table->string('remarks')->nullable();
            $table->string('acknowledge')->nullable();
            $table->string('creditcollection')->nullable();
            $table->string('approvedby')->nullable();
            $table->string('status', 3)->nullable();
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
        Schema::dropIfExists('order_slips');
    }
}