<?php
 mysql_query("UPDATE region SET region = '$_POST[requiredregion]',
 				dest_desc= '$_POST[requireddescription]' 
				WHERE idregion      = '$_POST[id]'");
  header('location:media.php?module='.$module);
?>