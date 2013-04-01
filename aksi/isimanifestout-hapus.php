<?php
  mysql_query("DELETE FROM buildup WHERE id_buildup='$_GET[n]' AND status_keluar='INSTORE'");
  header('location:media.php?module=manifestoutinput&i='.$_GET[i]);
?>