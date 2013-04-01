<?php
  mysql_query("INSERT INTO jenisuld(jenisuld,kodeuld)VALUES('$_POST[jenisuld]','$_POST[kodeuld]')");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
?>