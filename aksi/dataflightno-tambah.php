<?php
  mysql_query("INSERT INTO flight(flight, idcustomer) 
	                       VALUES('$_POST[requiredflight]','$_POST[customer]')");
  header('location:media.php?module='.$module);
?>