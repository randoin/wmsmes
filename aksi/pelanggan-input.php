<?php
  if($_POST[noktp]<>'')
  {
  $ceknoktp=mysql_query("select * from pelanggan where noktp='$_POST[noktp]'");
  $ada=mysql_num_rows($ceknoktp);
  	if($ada > 0)
  		{
  		header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
  		}
  	else
  		{  
			mysql_query("INSERT INTO 		pelanggan(nama,alamat,notelpon,noktp,nonpwp,id_carabayar,id_kotatujuan)VALUES('$_POST[nama]','$_POST[alamat]','$_POST[notelpon]','$_POST[noktp]','$_POST[nonpwp]','$_POST[id_carabayar]','$_POST[id_kotatujuan]')");
			header('location:media.php?module='.$module.'&l='.$_SESSION[level]);}
  
  }
  else
	{
   	mysql_query("INSERT INTO pelanggan(nama,alamat,notelpon,noktp,nonpwp,id_carabayar,id_kotatujuan)VALUES('$_POST[nama]','$_POST[alamat]','$_POST[notelpon]','$_POST[noktp]','$_POST[nonpwp]','$_POST[id_carabayar]','$_POST[id_kotatujuan]')");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
 }
?>