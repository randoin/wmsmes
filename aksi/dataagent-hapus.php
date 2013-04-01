<?php
  mysql_query("DELETE FROM Agent WHERE idagent  = '$_GET[id]'");
  header('location:media.php?module='.$module);
?>