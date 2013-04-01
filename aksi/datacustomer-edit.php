<?php
 mysql_query("UPDATE customer SET customer = '$_POST[requiredcustomer]',
 				cus_desc= '$_POST[requireddescription]',bendera= '$_POST[requiredbendera]',pejabatbc12= '$_POST[pejabatbc12]' 
				WHERE idcustomer      = '$_POST[id]'");
  header('location:media.php?module='.$module);
?>