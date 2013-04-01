<?php
$tgl=date("Y-m-d");
$tgl1=my2date($_POST[tgl]);
 mysql_query("UPDATE breakdown set status_ambil='INSTORE' where id_breakdown='$_GET[b]'");
 header('location:media.php?module=data');
?>