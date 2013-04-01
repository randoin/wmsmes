<?php
  mysql_query("DELETE FROM customer WHERE idcustomer  = '$_GET[id]'");
  header('location:media.php?module='.$module);
?>