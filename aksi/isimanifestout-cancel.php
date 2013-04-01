<?php
$tgl=date("Y-m-d");
	$cek=mysql_query("select * from isimanifestout,breakdown WHERE isimanifestout.id_isimanifestout=breakdown.id_isimanifestout AND 
	isimanifestout.id_isimanifestout='$_POST[n]' AND breakdown.status_bayar='yes'");
	$ada=mysql_num_rows($cek);
	if($ada<1)
	{
  mysql_query("UPDATE isimanifestout set isvoid='1',editedby='$_SESSION[namauser]',editdate='$tgl',keterangan_void='$_POST[keterangan_void]'
	WHERE id_isimanifestout='$_POST[n]'");
	}
  header('location:media.php?module=barangdatang&n='.$_POST[n].'&i='.$_POST[i]);
?>