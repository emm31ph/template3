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
             IN pi_trndatefrom DATE,
             IN pi_trndateto DATE
             )
          BEGIN
          select qq.*  from (
            select q.*
               from (
              select
                ibr.branch,
                i.itemcode,
                i.itemdesc,
                ifnull(ibr.expdate,'1900-01-01') as expdate,
                i.u_stockcode,
                i.pckgsize,
                i.numperuompu,
                ((ibr.qty+ifnull((select  sum(itr.drqty) from items_trn_hists itr where itr.trndate >= pi_trndatefrom and itr.itemcode=ibr.itemcode and itr.branch=ibr.branch and ifnull(itr.expdate,'1900-01-01')=ifnull(ibr.expdate,'1900-01-01')),0))
                -
                          ifnull((select  sum(itr.crqty) from items_trn_hists itr where itr.trndate >= pi_trndatefrom and itr.itemcode=ibr.itemcode and itr.branch=ibr.branch and ifnull(itr.expdate,'1900-01-01')=ifnull(ibr.expdate,'1900-01-01')),0)) as preqty,
                 ifnull(a.BR,0) BR,
                 ifnull(a.RR,0) RR,
                 ifnull(a.WPin,0) WPin,
                 ifnull(a.WPout,0) WPout,
                 ifnull(a.OD,0) OD,


                (ibr.qty+ifnull((select sum(itr.drqty) from items_trn_hists itr where itr.trndate > pi_trndateto  and itr.itemcode=ibr.itemcode and itr.branch=ibr.branch and ifnull(itr.expdate,'1900-01-01')=ifnull(ibr.expdate,'1900-01-01')),0))
                 -
                         ifnull((select sum(itr.crqty) from items_trn_hists itr where itr.trndate > pi_trndateto  and itr.itemcode=ibr.itemcode and itr.branch=ibr.branch and ifnull(itr.expdate,'1900-01-01')=ifnull(ibr.expdate,'1900-01-01')),0)
                as qty,

                ifnull((select max(itr.trndate ) from items_trn_hists itr
                where itr.trndate <= pi_trndateto and itr.itemcode=ibr.itemcode and itr.branch=ibr.branch and ifnull(itr.expdate,'1900-01-01')=ifnull(ibr.expdate,'1900-01-01') limit 1),'') as lasttrn
                from items_branches ibr
                left join items i on i.itemcode=ibr.itemcode and i.status!=0
                left join (select ith.branch,ith.itemcode,ith.expdate,
                sum(if(ith.trntype='RRM', ith.crqty,0)) as BR,
                sum(if(ith.trntype='RR', ith.crqty,0))as RR,
                sum(if(ith.trntype='WP', ith.crqty,0)) as WPin,
                sum(if(ith.trntype='WP', ith.drqty,0)) as WPout,
                sum(if(ith.trntype='OD', ith.drqty,0)) as OD,

              0 as qq
              from items_trn_hists ith
              left join items_batches ib on ith.batch=ib.batch and ib.status='01'
              WHERE ith.branch=pi_branch
              and ith.trndate BETWEEN  pi_trndatefrom and pi_trndateto
             GROUP by 1,2,3) a on a.branch=ibr.branch and a.itemcode=ibr.itemcode and a.expdate=ibr.expdate
                where if(pi_branch='',''='',ibr.branch=pi_branch)
            ) as q
            ) as qq
             where qq.itemcode!='' and ((lasttrn <= pi_trndateto and qq.qty!=0) or (lasttrn = pi_trndateto and qq.qty=0)) and if(pi_branch='',''='',qq.branch=pi_branch)
             order by qq.branch,qq.itemdesc,qq.expdate;
          END;
        ");

            // DB::unprepared("
            // DELIMITER $$
            // DROP PROCEDURE IF EXISTS dr_invoice;$$
            // CREATE PROCEDURE dr_invoice ( 
            //   IN pi_docno varchar(100)
            // )
            // BEGIN
             
            // SELECT  sd.docno,
            //               sd.bpname AS 'Customer',
            //               REPLACE(sd.billtoaddress,'Philippines','') AS 'Address',
            //               sp.salespersonname AS 'Sales',
            //               sd.u_sono AS 'SO_no',
            //               sd.bprefno AS  'PO_no',
            //               sd.u_pono as 'PO',
            //               sd.docdate AS 'Date',
            //               cc.name AS 'Attention',
            //               sdi.quantity AS 'Qty',
            //               #IF(i.remarks <> '',CONCAT(sdi.itemdesc,'\n ',i.remarks),CONCAT(sdi.itemdesc)) AS 'Description',
            //        sdi.itemdesc AS 'Description',
            //        uv.fieldvaluedesc AS 'Stock_Condition',
            //               sdi.unitprice AS 'Unit_price',
            //              sdi.linetotal-sdi.vatamount AS 'Amount',
            //               sdi.vatamount 'VAT_Amount',
            //               sdi.linetotaldisc 'Discounted_Amount',
            //               pt.paymenttermname AS 'Terms',
            //               sdi.uom as 'Unit',
            //               tb.fieldvaluedesc,
            //               sdi.discperc AS 'Line_Discount',
            //           sd.discperc AS 'Percentage_Disc',
            //           sd.discamount,
            //           sdi.u_qty_service 
            //       ,i.itemcode,i.U_STOCKCODE,m.MAKENAME
              
            // FROM arinvoices sd
            // LEFT JOIN arinvoiceitems sdi ON sdi.company = sd.company
            //       AND sdi.branch = sd.branch
            //       AND sdi.docid = sd.docid
            //  LEFT JOIN items i ON i.itemcode = sdi.itemcode
            //  LEFT JOIN makes m on m.MAKE=i.MAKE
            // LEFT JOIN customercontacts cc ON cc.contactperson = sd.contactperson
            //       AND cc.custno = sd.bpcode
            // LEFT JOIN salespersons sp ON sp.salesperson = sd.salesperson
            // LEFT JOIN paymentterms pt ON pt.paymentterm = sd.paymentterm
            // LEFT JOIN users u ON u.userid = sd.createdby
            // LEFT OUTER JOIN udfvalues tb ON tb.tablename = 'salesdeliveries'
            //       AND tb.fieldname = 'approver'
            //       AND tb.fieldvalue = u_approver
            // LEFT JOIN udfvalues uv ON uv.fieldvalue = sdi.u_stockcondition
            //       AND uv.fieldname = 'stockcondition'
            //       AND uv.tablename = 'arinvoiceitems'
            // WHERE   sd.docno = pi_docno or sd.bprefno=pi_docno;
            
            // END$$
            // DELIMITER ;
            
            //  ");
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
