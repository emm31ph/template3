<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTrnHistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items_trn_hists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('_trn')->nullable();
            $table->string('trntype')->nullable();
            $table->string('branch', 10)->nullable();
            $table->string('status', 3)->nullable();
            $table->string('batch');
            $table->string('_cancelled')->nullable();
            $table->string('itemcode', 50);
            $table->string('p', 1)->nullable();
            $table->decimal('preqty', 8, 0)->default('0');
            $table->decimal('drqty', 8, 0)->default('0');
            $table->decimal('crqty', 8, 0)->default('0');
            $table->decimal('curqty', 8, 0)->default('0');
            $table->date('trndate')->nullable();

            $table->date('expdate')->nullable();
            $table->string('year', 4)->nullable();
            $table->timestamps();

        });

        DB::unprepared("
            DROP PROCEDURE IF EXISTS sp_items;

            CREATE PROCEDURE sp_items (
                IN pi_branch VARCHAR(10),
                IN pi_trndate VARCHAR(10)
            )
            BEGIN
             select * from (
            select i.itemdesc, IF(pi_branch='','All',ib.branch) branch,ib.itemcode,ib.expdate ,
            cast(((avg(ib.qty)+ifnull(sum(drqty),0))-ifnull(sum(crqty),0))  as decimal(36,0))  as qty
                from items i
                left join items_branches ib on i.itemcode=ib.itemcode
                left JOIN (select * from items_trn_hists itr  where itr.trndate > pi_trndate
                ) it on it.branch=ib.branch and ISNULL(it.expdate)=ISNULL(ib.expdate) and ib.itemcode=it.itemcode
                where
                IF(pi_branch='',''='',ib.branch=pi_branch )
                GROUP by 1,2,3,4 ) as q where qty!=0  order by qty asc ;
            END;
        ");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items_trn_hists');
    }
}
