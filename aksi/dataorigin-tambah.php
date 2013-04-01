<?php
  mysql_query("INSERT INTO origin(origin_code, idregion,description,nokpbc,kpbc) 
	                       VALUES('$_POST[requiredcode]','$_POST[region]','$_POST[requireddesc]','$_POST[nokpbc]','$_POST[kpbc]')");
  header('location:media.php?module='.$module);
?>