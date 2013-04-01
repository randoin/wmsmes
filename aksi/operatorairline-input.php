<?php
  mysql_query("INSERT INTO operatorairline(operatorairline,kodeoperator)VALUES('$_POST[operatorairline]','$_POST[kodeoperator]')");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
?>