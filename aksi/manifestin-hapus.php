<?php
  mysql_query("DELETE FROM manifestin WHERE id_manifestin='$_GET[i]'");
  header('location:media.php?module=manifestin');
?>