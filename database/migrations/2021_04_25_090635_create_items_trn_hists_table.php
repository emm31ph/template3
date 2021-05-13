<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTrnHistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * return void
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
            $table->string('unit', 4)->nullable();
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
            select *,
              ((bal+ifnull((select  sum(itr.drqty) from items_trn_hists itr
                                where itr.trndate > pi_trndate
                                and itr.itemcode=q.itemcode
                                and itr.branch=q.branch
                                and ifnull(itr.expdate,'1900-01-01')=ifnull(q.expdate,'1900-01-01')
                              ),0))- ifnull((select  sum(itr.crqty) from items_trn_hists itr
                                where itr.trndate > pi_trndate
                                and itr.itemcode=q.itemcode
                                and itr.branch=q.branch
                                and ifnull(itr.expdate,'1900-01-01')=ifnull(q.expdate,'1900-01-01')
                              ),0)) as qty,
                ifnull((select  max(itr.trndate ) from items_trn_hists itr
                                where itr.trndate <= pi_trndate
                                and itr.itemcode=q.itemcode
                                and itr.branch=q.branch
                                and ifnull(itr.expdate,'1900-01-01')=ifnull(q.expdate,'1900-01-01') limit 1
                              ),0) as lasttrn,
                ifnull((select  max(p) from items_trn_hists itr
                                where itr.trndate <= pi_trndate
                                and itr.itemcode=q.itemcode
                                and itr.branch=q.branch
                                and ifnull(itr.expdate,'1900-01-01')=ifnull(q.expdate,'1900-01-01') limit 1
                              ),'') as p
              from (
              select i.itemdesc, IF(pi_branch='','ALL',ib.branch) branch,ib.itemcode,ifnull(ib.expdate,'1900-01-01') as expdate
              , sum(ib.qty)  as bal, i.u_skucode, i.pckgsize
            from items i
              left join items_branches ib on i.itemcode=ib.itemcode
              where  IF(pi_branch='',''='',ib.branch=pi_branch )
            GROUP by 1,2,3,4 ) as q ) as qq where qq.qty!=0   order by qq.branch,qq.itemdesc  asc;
            END;
        ");

    }

    /**
     * Reverse the migrations.
     *
     * return void
     */
    public function down()
    {
        Schema::dropIfExists('items_trn_hists');
    }
}
