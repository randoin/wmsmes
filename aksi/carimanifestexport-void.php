<?php
  mysql_query("UPDATE manifestout set statusvoid='1' WHERE idmanifestout  = '$_GET[idm]'");
  mysql_query("UPDATE isimanifestout set statusvoid='1' WHERE idmanifestout  = '$_GET[idm]'"); 
 header('location:media.php?module='.$module);
?>