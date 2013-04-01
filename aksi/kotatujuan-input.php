<?php
  mysql_query("INSERT INTO kotatujuan(kode,keterangan,status)VALUES('$_POST[kode]','$_POST[keterangan]','$_POST[status]')");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
?>