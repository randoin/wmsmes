<?php
  mysql_query("INSERT INTO destination(dest_code, idregion,description,nokpbc,kpbc,tps) 
	                       VALUES('$_POST[requiredcode]','$_POST[region]','$_POST[requireddesc]','$_POST[nokpbc]','$_POST[kpbc]','$_POST[tps]')");
  header('location:media.php?module='.$module);
?>