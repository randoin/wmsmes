<?php
mysql_query("UPDATE commodity_ap SET commodityap = '$_POST[requiredsubcodecommodity]',
 				
				idcommodity= '$_POST[commodity]' 
				WHERE idcommodityap      = '$_POST[id]'");
header('location:media.php?module='.$module);
?>