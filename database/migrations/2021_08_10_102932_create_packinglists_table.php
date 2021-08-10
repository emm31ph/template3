<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackinglistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packinglists', function (Blueprint $table) {
            $table->id();
            $table->string('batch');
            $table->string('branch', 10)->nullable();
            $table->string('trnType', 3)->nullable();
            $table->integer('user_id')->nullable(); 
            $table->string('contactperson', 100)->nullable();
            $table->string('consignee', 100)->nullable();
            $table->string('address', 199)->nullable();
            $table->date('trndate')->nullable();
            $table->string('booking_no', 12)->nullable();
            $table->string('sa_no', 12)->nullable();
            $table->string('dr_no', 12)->nullable();
            $table->string('po_no', 12)->nullable();
            $table->string('so_no', 12)->nullable();
            $table->date('shippingdate')->nullable();
            $table->string('shippingline', 100)->nullable();
            $table->string('shippingmethod', 100)->nullable();
            $table->string('control_no', 12)->nullable();
            $table->string('remarks')->nullable();
            $table->string('seal_no', 12)->nullable();
            $table->string('trucking_no', 12)->nullable();
            $table->string('gross', 50)->nullable();
            $table->string('status', 3)->default('01');
            $table->integer('approvedby')->nullable(); 
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
        Schema::dropIfExists('packinglists');
    }
}
