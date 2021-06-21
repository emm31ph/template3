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

        DB::unprepared("DROP PROCEDURE IF EXISTS sp_items;
        CREATE DEFINER = 'root'@'localhost'
        PROCEDURE sp_items(
             IN pi_branch VARCHAR(10),
             IN pi_trndatefrom VARCHAR(10),
             IN pi_trndateto VARCHAR(10)
             )
          BEGIN

          select * from (
          select *,
          ((bal+ifnull((select sum(itr.drqty) from items_trn_hists itr
            where itr.trndate > pi_trndateto
            and itr.itemcode=q.itemcode
            and itr.branch=q.branch
            and ifnull(itr.expdate,'1900-01-01')=ifnull(q.expdate,'1900-01-01')),0))-ifnull((select  sum(itr.crqty)
              from items_trn_hists itr where itr.trndate > pi_trndateto
              and itr.itemcode=q.itemcode and itr.branch=q.branch
              and ifnull(itr.expdate,'1900-01-01')=ifnull(q.expdate,'1900-01-01')),0)) as qty,

          ((bal+ifnull((select sum(itr.drqty) from items_trn_hists itr
            where itr.trndate > pi_trndateto
            and itr.itemcode=q.itemcode
            and itr.branch=q.branch
            and ifnull(itr.expdate,'1900-01-01')=ifnull(q.expdate,'1900-01-01')),0))-ifnull((select  sum(itr.crqty)
              from items_trn_hists itr where itr.trndate > pi_trndateto
              and itr.itemcode=q.itemcode and itr.branch=q.branch
              and ifnull(itr.expdate,'1900-01-01')=ifnull(q.expdate,'1900-01-01')),0))/q.numperuompu as qtya,

            ifnull((select sum(itr.drqty) from items_trn_hists itr
            where itr.trndate > pi_trndateto and itr.itemcode=q.itemcode and itr.branch=q.branch and ifnull(itr.expdate,'1900-01-01')=ifnull(q.expdate,'1900-01-01')),0) dr,
            ifnull((select sum(itr.crqty) from items_trn_hists itr
            where itr.trndate > pi_trndateto and itr.itemcode=q.itemcode and itr.branch=q.branch and ifnull(itr.expdate,'1900-01-01')=ifnull(q.expdate,'1900-01-01')),0) cr,
            ifnull((select max(itr.trndate ) from items_trn_hists itr
            where itr.trndate <= pi_trndateto and itr.itemcode=q.itemcode and itr.branch=q.branch and ifnull(itr.expdate,'1900-01-01')=ifnull(q.expdate,'1900-01-01') limit 1),'') as lasttrn,
            ifnull((select if(itr.p!='', if(itr.trndate= pi_trndateto,'x',''),'')
              from items_trn_hists itr
            where itr.trndate = pi_trndateto  and itr.itemcode=q.itemcode and itr.branch=q.branch and ifnull(itr.expdate,'1900-01-01')=ifnull(q.expdate,'1900-01-01') limit 1),'') as p
            from (
          select
            ibr.branch,
            i.itemcode,
            i.itemdesc,
            ifnull(ibr.expdate,'1900-01-01') as expdate,
            i.u_skucode,
            i.pckgsize,
            i.numperuompu,
            ibr.qty as bal
            from items_branches ibr
            left join items i on i.itemcode=ibr.itemcode ) as q ) as qq
          where (lasttrn <= pi_trndateto and qq.qty!=0)   and if(pi_branch='',''='',qq.branch=pi_branch)
          order by qq.branch,qq.itemdesc,qq.expdate
          ;
          END;
        ");

        DB::unprepared("
        DROP PROCEDURE IF EXISTS sp_items_detialed;
        CREATE DEFINER = 'root'@'localhost'
        PROCEDURE sp_items_detialed(
                IN pi_branch VARCHAR(10),
                IN pi_trndatefrom VARCHAR(10),
                IN pi_trndateto VARCHAR(10)
              )
        BEGIN
                select * from (
        select *,
          ((bal + ifnull((select  sum(itr.drqty) from items_trn_hists itr
          where itr.trndate >= pi_trndatefrom
          and itr.itemcode=q.itemcode
          and itr.branch=q.branch
          and ifnull(itr.expdate,'1900-01-01')=ifnull(q.expdate,'1900-01-01')  ),0) )-
               ifnull((select  sum(itr.crqty) from items_trn_hists itr
               where itr.trndate >= pi_trndatefrom
               and itr.itemcode=q.itemcode
               and itr.branch=q.branch
               and ifnull(itr.expdate,'1900-01-01')=ifnull(q.expdate,'1900-01-01')
            ),0)) as preqty,

          ((bal+ifnull((select sum(itr.drqty) from items_trn_hists itr
            where itr.trndate > pi_trndateto
            and itr.itemcode=q.itemcode
            and itr.branch=q.branch
            and ifnull(itr.expdate,'1900-01-01')=ifnull(q.expdate,'1900-01-01')),0))-ifnull((select  sum(itr.crqty)
              from items_trn_hists itr where itr.trndate > pi_trndateto
              and itr.itemcode=q.itemcode and itr.branch=q.branch
              and ifnull(itr.expdate,'1900-01-01')=ifnull(q.expdate,'1900-01-01')),0)) as qty,

          ((bal+ifnull((select sum(itr.drqty) from items_trn_hists itr
            where itr.trndate > pi_trndateto
            and itr.itemcode=q.itemcode
            and itr.branch=q.branch
            and ifnull(itr.expdate,'1900-01-01')=ifnull(q.expdate,'1900-01-01')),0))-ifnull((select  sum(itr.crqty)
              from items_trn_hists itr where itr.trndate > pi_trndateto
              and itr.itemcode=q.itemcode and itr.branch=q.branch
              and ifnull(itr.expdate,'1900-01-01')=ifnull(q.expdate,'1900-01-01')),0))/q.numperuompu as qtya,

            ifnull((select sum(if(itr.trntype='BR', itr.crqty,0)) from items_trn_hists itr
            where itr.trndate BETWEEN pi_trndatefrom and pi_trndateto  and itr.itemcode=q.itemcode and itr.branch=q.branch and ifnull(itr.expdate,'1900-01-01')=ifnull(q.expdate,'1900-01-01')),0) BR,
            ifnull((select sum(if(itr.trntype='RR', itr.crqty,0)) from items_trn_hists itr
            where itr.trndate BETWEEN pi_trndatefrom and pi_trndateto  and itr.itemcode=q.itemcode and itr.branch=q.branch and ifnull(itr.expdate,'1900-01-01')=ifnull(q.expdate,'1900-01-01')),0) RR,
            ifnull((select sum(if(itr.trntype='WP', itr.crqty,0)) from items_trn_hists itr
            where itr.trndate BETWEEN pi_trndatefrom and pi_trndateto  and itr.itemcode=q.itemcode and itr.branch=q.branch and ifnull(itr.expdate,'1900-01-01')=ifnull(q.expdate,'1900-01-01')),0) WP,
            ifnull((select sum(if(itr.trntype='OD', itr.drqty,0)) from items_trn_hists itr
            where itr.trndate BETWEEN pi_trndatefrom and pi_trndateto  and itr.itemcode=q.itemcode and itr.branch=q.branch and ifnull(itr.expdate,'1900-01-01')=ifnull(q.expdate,'1900-01-01')),0) OD,
            ifnull((select max(itr.trndate ) from items_trn_hists itr
            where itr.trndate <= pi_trndateto and itr.itemcode=q.itemcode and itr.branch=q.branch and ifnull(itr.expdate,'1900-01-01')=ifnull(q.expdate,'1900-01-01') limit 1),'') as lasttrn,
            ifnull((select if(itr.p!='', if(itr.trndate= pi_trndateto,'x',''),'')
              from items_trn_hists itr
            where itr.trndate = pi_trndateto  and itr.itemcode=q.itemcode and itr.branch=q.branch and ifnull(itr.expdate,'1900-01-01')=ifnull(q.expdate,'1900-01-01') limit 1),'') as p
            from (
          select
            ibr.branch,
            i.itemcode,
            i.itemdesc,
            ifnull(ibr.expdate,'1900-01-01') as expdate,
            i.u_skucode,
            i.pckgsize,
            i.numperuompu,
            ibr.qty as bal
            from items_branches ibr
            left join items i on i.itemcode=ibr.itemcode ) as q ) as qq
           where ((lasttrn <= pi_trndateto and qq.qty!=0) or  (lasttrn = pi_trndateto and qq.qty=0)) and if(pi_branch='',''='',qq.branch=pi_branch)
          order by qq.branch,qq.itemdesc,qq.expdate;
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
