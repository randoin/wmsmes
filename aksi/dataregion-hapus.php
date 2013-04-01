<?php
  mysql_query("DELETE FROM region WHERE idregion  = '$_GET[id]'");
  header('location:media.php?module='.$module);
?>