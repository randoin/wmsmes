<?php
  if ((!empty($_POST['id_user'])) AND (!empty($_POST['nama_lengkap'])))
  {
	$pass=md5($_POST['password']);
	mysql_query("INSERT INTO user(id_user,password,nama_lengkap,nipp,telpon,level) 
							VALUES('$_POST[id_user]','$pass','$_POST[nama_lengkap]','$_POST[nipp]',
									'$_POST[no_telpon]','$_POST[level]')");
  }
  header('location:media.php?module='.$module);
?>