<?php
			$n1=mysql_query("select * from out_dtbarang where id='$_GET[i]'");
			$q=mysql_fetch_array($n1);

 mysql_query("DELETE FROM out_dtbarang WHERE id='$_GET[i]'");
	

			
			$n2=mysql_query("select * from out_dtbarang_h where id='$_GET[h]'");
			$p=mysql_fetch_array($n2);

;
$pberat=$p[btb_totalberat]-$q[dtBarang_berat];
$pkoli=$p[btb_totalkoli]-$q[dtBarang_koli];
$pvol=$p[btb_totalvolume]-$q[dtBarang_luasdimensi];
$pbayar=$p[btb_totalberatbayar]-$q[dtBarang_brtdibayar];

  		mysql_query("UPDATE out_dtbarang_h
			set btb_totalberat='$pberat',btb_totalkoli='$pkoli',btb_totalvolume='$pvol',
			btb_totalberatbayar='$pbayar' where id='$_GET[h]'");
				
  header('location:media.php?module=btbinput&i='.$_GET[h]);
?>