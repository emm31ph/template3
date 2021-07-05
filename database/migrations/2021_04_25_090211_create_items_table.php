<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('shortcode', 50)->nullable();
            $table->string('u_stockcode', 50)->nullable();
            $table->string('itemcode', 50);
            $table->string('itemdesc');
            $table->string('pckgsize', 15)->nullable();
            $table->string('uompu', 15)->nullable();
            $table->decimal('numperuompu', 36, 0)->nullable(); 
            $table->string('status', 3)->nullable();
            $table->string('itemclass', 5)->nullable();
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
        Schema::dropIfExists('items');
    }
}
