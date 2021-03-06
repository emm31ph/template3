<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('cid');
            $table->string('branch', 10)->nullable();
            $table->string('custno', 50)->nullable();
            $table->string('custname')->nullable();
            $table->string('pricelist',10)->nullable();
            $table->string('status', 3)->nullable();
            $table->string('region', 15)->nullable();
            $table->string('salesperson', 30)->nullable();
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
        Schema::dropIfExists('customers');
    }
}
