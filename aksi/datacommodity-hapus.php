<?php
  mysql_query("DELETE FROM commodity WHERE idcommodity  = '$_GET[id]'");
  header('location:media.php?module='.$module);
?>