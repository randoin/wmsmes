<?php
 mysql_query("UPDATE flight SET flight = '$_POST[requiredflight]',
 				idcustomer= '$_POST[customer]' 
				WHERE idflight      = '$_POST[id]'");
  header('location:media.php?module='.$module);
?>