<?php
mysql_query("INSERT INTO 
barangoutbound(id_smu,penjelasan,koli,kg)VALUES('$_POST[idsmu]','$_POST[penjelasan]','$_POST[koli]','$_POST[kg]')");
$t=mysql_query("select sum(kg)AS totalkg, sum(koli) AS totalkoli from barangoutbound where id_smu='$_POST[idsmu]'");
$tot=mysql_fetch_array($t);
mysql_query("UPDATE smu SET beratdibayar='$tot[totalkg]',beratkoli='$tot[totalkoli]' where id_smu='$_POST[idsmu]'");
header('location:media.php?act='.$module.'&id='.$_POST[idsmu]);
?>