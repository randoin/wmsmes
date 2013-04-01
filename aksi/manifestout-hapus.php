<?php
  mysql_query("DELETE FROM manifestout WHERE id_manifestout='$_GET[i]'");
  header('location:media.php?module=manifestout');
?>