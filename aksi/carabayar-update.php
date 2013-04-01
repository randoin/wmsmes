<?php
  mysql_query("UPDATE carabayar SET carabayar = '$_POST[cara_bayar]' WHERE id_carabayar = '$_POST[id]'");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
?>