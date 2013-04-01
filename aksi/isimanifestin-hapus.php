<?php
//cek dulu apakah SMU ini tersplit
$cek=mysql_query("select count(*) from breakdown WHERE id_isimanifestin='$_GET[i]'");
$ada=mysql_fetch_array($cek);

	if($ada[0]>1)//berarti sudah ada barang lain yang menggunakan smu yang sama (split)
	{
	mysql_query("DELETE FROM breakdown WHERE id_breakdown='$_GET[b]'");
	}
	else
	{
  mysql_query("DELETE FROM isimanifestin WHERE id_isimanifestin='$_GET[i]'");
	mysql_query("DELETE FROM breakdown WHERE id_isimanifestin='$_GET[i]'");	
	}
  header('location:media.php?module=manifestininput&i='.$_GET[i]);
?>