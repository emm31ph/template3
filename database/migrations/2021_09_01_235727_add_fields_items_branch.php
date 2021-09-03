<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsItemsBranch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items_branches', function (Blueprint $table) {
              $table->string("type")->default('00');
        });

        
        Schema::table('items_trn_hists', function (Blueprint $table) {
              $table->string("type")->default('00');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('items_branches', function (Blueprint $table) {
        //     //
        // });
    }
}