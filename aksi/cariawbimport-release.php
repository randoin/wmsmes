<?php
  mysql_query("UPDATE isimanifestin set statusconfirm='0' WHERE idisimanifestin  = '$_GET[id]'");
  header('location:media.php?module='.$module);
?>