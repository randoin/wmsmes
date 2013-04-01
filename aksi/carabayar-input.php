<?php
  mysql_query("INSERT INTO carabayar(carabayar)VALUES('$_POST[cara_bayar]')");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
?>