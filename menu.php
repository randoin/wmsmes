<?php
include "config/koneksi.php";

if ($_SESSION['level']=='admin'){
  $sql=mysql_query("select * from modul where status='admin' AND aktif='Y' order by urutan");
}
else if ($_SESSION['level']=='export'){
  $sql=mysql_query("select * from modul where status='export' AND aktif='Y' order by urutan");
}
else if ($_SESSION['level']=='gapura'){
  $sql=mysql_query("select * from modul where status='gapura' AND aktif='Y' and publish='Y' order by urutan");
}

else if ($_SESSION['level']=='import'){
  $sql=mysql_query("select * from modul where status='import' AND aktif='Y' and publish='Y' order by urutan");
}
else if ($_SESSION['level']=='export'){
  $sql=mysql_query("select * from modul where status='export' AND aktif='Y' and publish='Y' order by urutan");
}
else if ($_SESSION['level']=='store_in'){
  $sql=mysql_query("select * from modul where status='store_in' AND aktif='Y' order by urutan");
}
else if ($_SESSION['level']=='kasir'){
  $sql=mysql_query("select * from modul where status='kasir' AND aktif='Y' AND publish='Y' order by urutan");
}
else if ($_SESSION['level']=='btb'){
  $sql=mysql_query("select * from modul where status='btb' AND aktif='Y' AND publish='Y' order by urutan");
}
else if ($_SESSION['level']=='supervisor'){
  $sql=mysql_query("select * from modul where status='supervisor' AND aktif='Y' order by urutan");
 // $sql=mysql_query("select * from modul where aktif='Y' AND s='1' order by urutan");
}

while ($data=mysql_fetch_array($sql))
{  
	if($data['link']=='')
	{
		echo "<BR><div id=jdl>$data[nama_modul]</div>";
	}
	else
	{
		echo "<li><a href='$data[link]'>&#187; $data[nama_modul]</a></li>";
	}	
//  echo "<td><a href='$data[link]'>&#187; $data[nama_modul]</a></td>";
}
?>
