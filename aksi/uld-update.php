<?php
  mysql_query("UPDATE uld SET id_jenisuld = '$_POST[id_jenisuld]',nould='$_POST[nould]' WHERE id_uld = '$_POST[id]'");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
?>