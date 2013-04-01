<?php
 mysql_query("UPDATE origin SET origin_code = '$_POST[requiredcode]',
 				idregion= '$_POST[region]',description='$_POST[requireddesc]',
				nokpbc='$_POST[nokpbc]',kpbc='$_POST[kpbc]' 
				WHERE idorigin      = '$_POST[id]'");		
  header('location:media.php?module='.$module);
?>