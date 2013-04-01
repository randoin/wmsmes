<?php
$tgl=date("Y-m-d");
	$tampil=mysql_query("select * from deliverybill where id_deliverybill='$_GET[n]'");
	$r=mysql_fetch_array($tampil);
	if($r['status']=='0')
		{
		$nodb='DBI-'.$r['nodb'];
		}
	else if($r['status']=='1')
		{
		$nodb='DBO-'.$r['nodb'];
		}
	echo "<BR><BR><p><a href=aksi.php?module=cetakdb&n=$r[id_deliverybill] target=_blank alt='klik untuk melihat preview kuitansi sebelum di cetak' title='klik untuk melihat preview kuitansi sebelum di cetak'>Cetak Deliver Bill #$nodb</a></p>";
?>