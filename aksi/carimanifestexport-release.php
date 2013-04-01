<?php
  mysql_query("UPDATE manifestout set statusconfirm='0' WHERE idmanifestout  = '$_GET[idm]'");
  header('location:media.php?module='.$module);
?>