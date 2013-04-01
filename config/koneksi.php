<?php
$server = "localhost";
$username = "root";
$password = "123456";
$database = "wms_inter";
mysql_connect($server,$username,$password) or die("Connection to MySQL Server FAILED !!");
mysql_select_db($database) or die("Cannot Open Database !!!");
?>