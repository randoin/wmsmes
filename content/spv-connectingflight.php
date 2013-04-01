<?php
	$p      = new Paging;
	$batas  =10;
	$posisi = $p->cariPosisi($batas);
    $no     = $posisi+1;
	

if(!empty($_POST['cari'])){$cari=$_POST['cari'];}else{$cari=$_GET['cari'];}
if(!empty($cari))//jika user melakukan pencarian
{
	if($_GET['a']=='1') // urutkan Ascending dulu
  	{
	$b=0; 
	$tampil=mysql_query("SELECT * FROM connectingflight 
			WHERE  
			(nama like '%$cari%' OR alamat like '%$cari%' OR npwp like '%$cari%') 
			order by nama ASC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM connectingflight 
			WHERE 
			(nama like '%$cari%' OR alamat like '%$cari%'  OR npwp like '%$cari%')"));
	}
	else // jika diklik lagi maka akan pengurutan DESCENDING
  	{
	$b=1; 
	$tampil=mysql_query("SELECT * FROM connectingflight 
			WHERE  
			(nama like '%$cari%' OR alamat like '%$cari%'  OR npwp like '%$cari%') 
			order by nama DESC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM connectingflight 
			WHERE  
			(nama like '%$cari%' OR alamat like '%$cari%'  OR npwp like '%$cari%')"));
	}
}	
 else//jika user TIDAK melakukan pencarian
{
	if($_GET['a']=='1') // urutkan Ascending dulu
  	{
	$b=0; 
	$tampil=mysql_query("SELECT * FROM connectingflight 
			
			order by nama ASC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM connectingflight 
			"));
	}
	else // jika diklik lagi maka akan pengurutan DESCENDING
  	{
	$b=1; 
	$tampil=mysql_query("SELECT * FROM connectingflight 
			
			order by nama DESC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM connectingflight 
			"));
	}
}
//mulai membuat FORM nya
 	echo "<h2>DATA CONNECTING FLIGHT</h2>
 		<form method=POST action='?module=connectingflight'>
		<table border=0 cellpadding=0 cellspacing=0 width=100%>
			<tr><td>
			PENCARIAN : <input name=cari type=text size=20 value='$_POST[cari]' autocomplete=off> 
			<input type=submit value=CARI> <a href=?act=tambah_dataconnectingflight>
			<span class=tombol> TAMBAH DATA </span></a>
			</td></tr>
		</table>"; 
	$jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
	$linkHalaman  = $p->navHalaman($_GET['halaman'], $jmlhalaman,'cari='.$cari);	
	echo "<p>$linkHalaman</p><table><tr><th>no</th>
		<th>nama</th>
		<th>alamat</th>
		<th>npwp</th>
<th>action</th></th></tr>";
	while ($r=mysql_fetch_array($tampil))
	{
		echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>$no</td><td>$r[nama]</td>
          	<td>$r[alamat]</td><td>$r[npwp]</td>
			<td><a href=?act=edit_dataconnectingflight&id=$r[idconnectingflight]>EDIT</a> | 
			<a href=\"javascript:deldata('$r[idconnectingflight]','Con FLight : $r[nama] ?',
			'aksi.php?module=connectingflight&act=hapus&id=')\">HAPUS</a>
          	</td></tr>";
     $no++;
  	}
  echo "</table><p>word '$cari' found : $jmldata rows in $jmlhalaman pages</p></form>";

?>