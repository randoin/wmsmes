<?php
  mysql_query("UPDATE isimanifestin set paid='0' WHERE idisimanifestin  = '$_GET[id]'");
  mysql_query("UPDATE deliverybill set isvoid='1' WHERE iddeliverybill  = '$_GET[idb]'");  
  
  header('location:media.php?module='.$module);
?>