<?php
	$p      = new Paging;
	$batas  =10;
	$posisi = $p->cariPosisi($batas);
    $no     = $posisi+1;
	
	if($_GET[r]=='r'){$tab='region';}
	else if($_GET[r]=='d'){$tab='dest_desc';}
	else $tab='region';
	
if(!empty($_POST[cari])){$cari=$_POST[cari];}else{$cari=$_GET[cari];}
if(!empty($cari))//jika user melakukan pencarian
{
	if($_GET['a']=='1') // urutkan Ascending dulu
  	{
	$b=0; 
	$tampil=mysql_query("SELECT * FROM region WHERE region like '%$cari%' OR dest_desc like '%$cari%' 
						order by $tab ASC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM region WHERE region like '%$cari%' OR 
						dest_desc like '%$cari%'"));
	}
	else // jika diklik lagi maka akan pengurutan DESCENDING
  	{
	$b=1; 
	$tampil=mysql_query("SELECT * FROM region WHERE region like '%$cari%' OR dest_desc like '%$cari%' 
						order by $tab DESC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM region WHERE region like '%$cari%' OR 
						dest_desc like '%$cari%'"));
	}
}	
 else//jika user TIDAK melakukan pencarian
{
	if($_GET['a']=='1') // urutkan Ascending dulu
  	{
	$b=0; 
	$tampil=mysql_query("SELECT * FROM region order by $tab ASC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM region"));
	}
	else // jika diklik lagi maka akan pengurutan DESCENDING
  	{
	$b=1; 
	$tampil=mysql_query("SELECT * FROM region order by $tab DESC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM region"));
	}
}
//mulai membuat FORM nya
 	echo "<h2>DATA REGION</h2>
 		<form method=POST action='?module=dataregion'>
		<table border=0 cellpadding=0 cellspacing=0 width=100%>
			<tr><td>
			PENCARIAN : <input name=cari type=text size=20 value='$_POST[cari]' autocomplete=off> 
			<input type=submit value=CARI> <a href=?act=tambah_dataregion>
			<span class=tombol> TAMBAH DATA </span></a>
			</td></tr>
		</table>"; 
	$jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
	$linkHalaman  = $p->navHalaman($_GET['halaman'], $jmlhalaman,'cari='.$cari);	
	echo "<p>$linkHalaman</p><table><tr><th>no</th>
		<th><a href=?module=dataregion&r=r&a=$b&cari=$cari>region</a></th>
		<th><a href=?module=dataregion&r=d&a=$b&cari=$cari>description</a></th><th>action</th></th></tr>";
	while ($r=mysql_fetch_array($tampil))
	{
		echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>$no</td><td>$r[region]</td>
          	<td>$r[dest_desc]</td><td><a href=?act=edit_dataregion&id=$r[idregion]>EDIT</a> | 
			<a href=\"javascript:deldata('$r[idregion]','Dest Region : $r[dest_desc] ?',
			'aksi.php?module=dataregion&act=hapus&id=')\">HAPUS</a>
          	</td></tr>";
     $no++;
  	}
  echo "</table><p>word '$cari' found : $jmldata rows in $jmlhalaman pages</p></form>";

?>