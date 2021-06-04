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
            $table->string('os_id');
            $table->integer('cid');
            $table->integer('user_id')->comment('salesman');
            $table->date('trndate')->nullable();
            $table->string('sono')->nullable();
            $table->string('pono')->nullable();
            $table->date('deliverydate')->nullable();
            $table->string('terms')->nullable();
            $table->string('deliver_to')->nullable();
            $table->decimal('totalunit', 36, 0)->nullable();
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
