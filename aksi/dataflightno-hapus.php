<?php
  mysql_query("DELETE FROM flight WHERE idflight  = '$_GET[id]'");
  header('location:media.php?module='.$module);
?>