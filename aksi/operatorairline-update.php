<?php
  mysql_query("UPDATE operatorairline SET operatorairline = '$_POST[operatorairline]',kodeoperator='$_POST[kodeoperator]' WHERE id_operatorairline = '$_POST[id]'");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
?>