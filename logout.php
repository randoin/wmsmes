<?php
include "config/koneksi.php";
  session_start();
  mysql_query("update user set logon='0' WHERE id_user='$_SESSION[namauser]'");	 
  session_destroy();

//  echo "<center>Anda telah sukses keluar sistem <b>[LOGOUT]<b>";

 header('location:index.php');
?>
