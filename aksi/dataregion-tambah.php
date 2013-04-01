<?php
  mysql_query("INSERT INTO region(region, dest_desc) 
	                       VALUES('$_POST[requiredregion]','$_POST[requireddescription]')");
  header('location:media.php?module='.$module);
?>