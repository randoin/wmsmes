<?php
 mysql_query("UPDATE destination SET dest_code = '$_POST[requiredcode]',
 				idregion= '$_POST[region]',description='$_POST[requireddesc]',
				nokpbc='$_POST[nokpbc]',kpbc='$_POST[kpbc]',tps='$_POST[tps]'  
				WHERE iddestination      = '$_POST[id]'");		
  header('location:media.php?module='.$module);
?>