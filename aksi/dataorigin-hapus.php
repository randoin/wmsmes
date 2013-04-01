<?php
  mysql_query("DELETE FROM origin WHERE idorigin  = '$_GET[id]'");
  header('location:media.php?module='.$module);
?>