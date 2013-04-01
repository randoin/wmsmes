<?php
  mysql_query("UPDATE manifestin SET status='checked' WHERE id_manifestin='$_GET[i]'");
  header('location:media.php?module=manifestin');
?>