SELECT  *
FROM 
(
	SELECT  i.itemdesc
	       ,IF(@pi_branch = '','All',ib.branch) branch
	       ,ib.itemcode
	       ,ib.expdate
	       ,(SUM(ib.qty) + invOut.drqty) - invInt.crqty AS qty
	FROM items i
	LEFT JOIN items_branches ib
	ON i.itemcode = ib.itemcode
	LEFT JOIN 
	(
		SELECT  itr.expdate
		       ,itr.itemcode
		       ,IF(@pi_branch = '','ALL',itr.branch) branch
		       ,SUM(itr.drqty) AS drqty
		FROM items_trn_hists itr
		WHERE itr.trndate > pi_trndate 
		AND IF( pi_branch = '', '' = '', itr.branch = pi_branch ) 
		GROUP BY  1
		         ,2
		         ,IF(@pi_branch = '','ALL',itr.branch) 
	) invOut
	ON invOut.branch = ib.branch AND ISNULL(invOut.expdate) = ISNULL(ib.expdate) AND ib.itemcode = invOut.itemcode
	LEFT JOIN 
	(
		SELECT  itr.expdate
		       ,itr.itemcode
		       ,IF(@pi_branch = '','ALL',itr.branch) branch
		       ,SUM(itr.crqty) AS crqty
		FROM items_trn_hists itr
		WHERE itr.trndate > pi_trndate 
		AND IF( pi_branch = '', '' = '', itr.branch = pi_branch ) 
		GROUP BY  1
		         ,2
		         ,IF(@pi_branch = '','ALL',itr.branch) 
	) invInt
	ON invInt.branch = ib.branch AND ISNULL(invInt.expdate) = ISNULL(ib.expdate) AND ib.itemcode = invInt.itemcode
	WHERE IF(@pi_branch = '', '' = '', ib.branch = pi_branch) 
	GROUP BY  1
	         ,2
	         ,3
	         ,4 
) AS q
WHERE qty != 0 order by qty desc; 