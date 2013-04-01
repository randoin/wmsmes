<?php
  mysql_query("INSERT INTO commodity_ap(commodityap,idcommodity) 
	                       VALUES('$_POST[requiredsubcodecommodity]','$_POST[commodity]')");
  header('location:media.php?module='.$module);
?>