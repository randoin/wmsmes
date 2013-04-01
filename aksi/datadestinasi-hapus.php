<?php
  mysql_query("DELETE FROM destination WHERE iddestination  = '$_GET[id]'");
  header('location:media.php?module='.$module);
?>