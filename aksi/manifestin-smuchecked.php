<?php
  mysql_query("UPDATE breakdown SET status_check='confirm' WHERE id_breakdown='$_GET[b]'");
  header('location:media.php?module=barangdatang&i='.$_GET[i]);
?>