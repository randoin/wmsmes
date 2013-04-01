<?php
  mysql_query("UPDATE jenisuld SET jenisuld = '$_POST[jenisuld]',kodeuld='$_POST[kodeuld]' WHERE id_jenisuld = '$_POST[id]'");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
?>