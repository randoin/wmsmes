<?php
  mysql_query("UPDATE out_dtbarang_h set isvoid='1',editedby='$_SESSION[namauser]' WHERE id='$_GET[i]'");
  header('location:media.php?module=btb');
?>