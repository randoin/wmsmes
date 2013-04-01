<?php
include "config/koneksi.php";
$pass=md5($_POST['password']);
//$pass=$_POST[password];

$login=mysql_query("SELECT * FROM user WHERE id_user='$_POST[username]' AND password='$pass'");
$ketemu=mysql_num_rows($login);
$r=mysql_fetch_array($login);

if ($ketemu > 0){
	if($r['logon']=='1')
  	 {
  		echo "<link href=config/adminstyle.css rel=stylesheet type=text/css>
		<center>Maaf, tapi Anda sudah login. Jika ini kesalahan, hubungi user ADMIN untuk merelease account Anda.<br>
		<a href=index.php><b>ULANGI LAGI</b></a></center>";	
 	 }
	else
 	 {
		session_start();
		session_register("namauser");
		session_register("passuser");
		session_register("level");  
		$_SESSION['namauser']=$r['id_user'];
		$_SESSION['passuser']=$r['password'];
		$_SESSION['level']=$r['level'];  
		//mysql_query("update user set logon='1' WHERE id_user='$_SESSION[namauser]'");	
		header('location:media.php?module=home');
	 }
	}
else
	{
	  /*
		echo "<link href=config/adminstyle.css rel=stylesheet type=text/css>";
	  echo "<center>Login gagal! username & password tidak benar<br>";
	  echo "<a href=index.php><b>ULANGI LAGI</b></a></center>";
    */
		if($_POST['username']=='')
		{header('location:index.php');}
		else {header('location:index.php?e=1');}
	}
?>
