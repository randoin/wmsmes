<?php
$tgl=date("Y-m-d");
mysql_query("UPDATE breakdown SET status_ambil='OUT', tglambil='$tgl' WHERE id_breakdown='$_GET[i]' AND isvoid='0' AND status_bayar='yes'");
header('location:media.php?module=stockopnamein');
?>