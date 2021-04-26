<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items_branches', function (Blueprint $table) {
            $table->string('branch', 10)->nullable();
            $table->string('itemcode', 50)->nullable();
            $table->date('expdate')->nullable();
            $table->string('status', 3)->nullable();
            $table->decimal('qty', 8, 0)->default('0');
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
        Schema::dropIfExists('items_branches');
    }
}
