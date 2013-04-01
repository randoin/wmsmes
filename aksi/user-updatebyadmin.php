<?php
  // Apabila password tidak diubah
 if (empty($_POST[password])) {
    mysql_query("UPDATE user SET 
			nama_lengkap = '$_POST[nama_lengkap]',
			nipp = '$_POST[nipp]',
			telpon    = '$_POST[no_telpon]',
level='$_POST[level]'
			WHERE id_user = '$_POST[id]'");
	}
  // Apabila password diubah
  else{
    $pass=md5($_POST[password]);
   mysql_query("UPDATE user SET 
			nama_lengkap = '$_POST[nama_lengkap]',
			nipp = '$_POST[nipp]',
			password='$pass',
			telpon    = '$_POST[no_telpon]',level='$_POST[level]'
			WHERE id_user = '$_POST[id]'");
  }
  header('location:media.php?module=home');
?>