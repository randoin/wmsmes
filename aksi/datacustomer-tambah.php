<?php
  mysql_query("INSERT INTO customer(customer, cus_desc,bendera,pejabatbc12) 
	                       VALUES('$_POST[requiredcustomer]','$_POST[requireddescription]','$_POST[requiredbendera]','$_POST[pejabatbc12]')");
  header('location:media.php?module='.$module);
?>