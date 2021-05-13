<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items_batches', function (Blueprint $table) {
            $table->string('batch');
            $table->string('trnType', 3)->nullable();
            $table->decimal('drqty', 8, 0)->default('0');
            $table->decimal('crqty', 8, 0)->default('0');
            $table->integer('user_id')->nullable();
            $table->string('rono')->nullable();
            $table->string('refno')->nullable();
            $table->string('remarks')->nullable();
            $table->text('customer')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->date('trndate')->nullable();
            $table->string('year', 4)->nullable();
            $table->integer('approvedby')->nullable();
            $table->integer('preparedby')->nullable();
            $table->integer('receivedby')->nullable();
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
        Schema::dropIfExists('items_batches');
    }
}
