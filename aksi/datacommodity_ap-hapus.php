<?php
  mysql_query("DELETE FROM commodity_ap WHERE idcommodityap  = '$_GET[id]'");
  header('location:media.php?module='.$module);
?>