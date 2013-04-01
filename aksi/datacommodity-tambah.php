<?php
  mysql_query("INSERT INTO commodity(commodity, com_desc) 
	                       VALUES('$_POST[requiredcommodity]','$_POST[requireddescription]')");
  header('location:media.php?module='.$module);
?>