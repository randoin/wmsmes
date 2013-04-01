<?php
	$tgl=my2date($_POST[tglbtb]);
	  		mysql_query("UPDATE out_dtbarang_h,out_dtbarang SET out_dtbarang_h.airline='$_POST[airline]',out_dtbarang_h.btb_agent='$_POST[agent]',
out_dtbarang_h.btb_date='$tgl',out_dtbarang_h.btb_tujuan='$_POST[tujuan]',
out_dtbarang_h.btb_smu='$_POST[nosmu]',out_dtbarang.dtBarang_type='$_POST[jenisbarang]' WHERE out_dtbarang_h.id='$_POST[id]'
			AND out_dtbarang_h.id=out_dtbarang.id_h AND out_dtbarang_h.isvoid='0'");
header('location:media.php?module=btb');
?>