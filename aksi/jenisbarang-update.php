<?php
  mysql_query("UPDATE jenisbarang SET jenisbarang = '$_POST[jenisbarang]',keterangan='$_POST[keterangan]' WHERE id_jenisbarang = '$_POST[id]'");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
?>