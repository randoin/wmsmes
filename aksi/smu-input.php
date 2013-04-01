<?php
$tgl=my2date($_POST[tglbtb]);
  mysql_query("INSERT INTO smu(nobtb,nosmu,idpengirim,idtujuan,idairline,idjenisbarang,idkomoditi,tglbtb,statuskirim,user,statusbayar)VALUES('$_POST[nobtb]','$_POST[nosmu]','$_POST[idpengirim]','$_POST[idpenerima]','$_POST[idairline]','$_POST[idjenisbarang]','$_POST[idkomoditi]','$tgl','0','$_SESSION[namauser]','0')");
 header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
?>