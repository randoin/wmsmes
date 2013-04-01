<?php
  mysql_query("INSERT INTO komoditi(kodekomoditi,keterangan)VALUES('$_POST[kodekomoditi]','$_POST[keterangan]')");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
?>