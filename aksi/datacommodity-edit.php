<?php
 mysql_query("UPDATE commodity SET commodity = '$_POST[requiredcommodity]',
 				com_desc= '$_POST[requireddescription]' 
				WHERE idcommodity      = '$_POST[id]'");
  header('location:media.php?module='.$module);
?>