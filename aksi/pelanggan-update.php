<?php
 if($_POST[noktp]<>'')
  {
  $ceknoktp=mysql_query("select * from pelanggan where noktp='$_POST[noktp]' AND id_pelanggan<>'$_POST[id]'");
  $ada=mysql_num_rows($ceknoktp);
  	if($ada > 0)
  		{
  		header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
  		}
  	else
  		{  
   	mysql_query("UPDATE pelanggan SET  nama='$_POST[nama]',alamat='$_POST[alamat]',notelpon='$_POST[notelpon]',noktp='$_POST[noktp]',nonpwp='$_POST[nonpwp]',id_carabayar='$_POST[id_carabayar]',id_kotatujuan='$_POST[id_kotatujuan]' WHERE id_pelanggan='$_POST[id]'");
			header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
			}
  
  }
  else
	{
   	mysql_query("UPDATE pelanggan SET  nama='$_POST[nama]',alamat='$_POST[alamat]',notelpon='$_POST[notelpon]',noktp='$_POST[noktp]',nonpwp='$_POST[nonpwp]',id_carabayar='$_POST[id_carabayar]',id_kotatujuan='$_POST[id_kotatujuan]' WHERE id_pelanggan='$_POST[id]'");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
 }
?>