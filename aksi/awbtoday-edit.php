<?php
mysql_query("UPDATE master_smu  set 
nosmu='$_POST[requiredawb]' ,idcommodityap='$_POST[commodity]' ,idorigin='$_POST[origin]' ,iddestination ='$_POST[destination]',berat='$_POST[requiredkg]' ,koli='$_POST[requiredkoli]' ,
user='$_SESSION[namauser]' ,tglsmu='$_POST[tglsmu]' ,shipper= '$_POST[shipper]' ,consignee= '$_POST[consignee]' ,idagent='$_POST[agent]' WHERE idmastersmu='$_POST[ids]'"); 

 header('location:media.php?module=carismu&cari='.$_POST[requiredawb]);
?>