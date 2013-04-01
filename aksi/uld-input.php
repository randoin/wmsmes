<?php
  mysql_query("INSERT INTO uld(id_jenisuld,nould)VALUES('$_POST[id_jenisuld]','$_POST[nould]')");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
?>