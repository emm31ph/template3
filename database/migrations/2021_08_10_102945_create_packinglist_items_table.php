<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackinglistItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packinglist_items', function (Blueprint $table) {
            $table->id();
            $table->integer('docid')->nullable();
            $table->string('itemcode',50);
            $table->date('expdate')->nullable();
            $table->decimal('qty',16,0)->default(0);
            $table->string('unit',4)->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('packinglist_items');
    }
}
