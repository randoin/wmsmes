<?php
  mysql_query("INSERT INTO jenisbarang(jenisbarang,keterangan)VALUES('$_POST[jenisbarang]','$_POST[keterangan]')");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
?>