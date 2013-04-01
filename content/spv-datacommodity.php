<?php
	$p      = new Paging;
	$batas  =10;
	$posisi = $p->cariPosisi($batas);
    $no     = $posisi+1;
	
	if($_GET['r']=='r'){$tab='commodity';}
	else if($_GET['r']=='d'){$tab='com_desc';}
	else $tab='commodity';
	
if(!empty($_POST['cari'])){$cari=$_POST['cari'];}else{$cari=$_GET['cari'];}
if(!empty($cari))//jika user melakukan pencarian
{
	if($_GET['a']=='1') // urutkan Ascending dulu
  	{
	$b=0; 
	$tampil=mysql_query("SELECT * FROM commodity WHERE commodity like '%$cari%' OR com_desc like '%$cari%' 
						order by $tab ASC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM commodity WHERE commodity like '%$cari%' OR 
						com_desc like '%$cari%'"));
	}
	else // jika diklik lagi maka akan pengurutan DESCENDING
  	{
	$b=1; 
	$tampil=mysql_query("SELECT * FROM commodity WHERE commodity like '%$cari%' OR com_desc like '%$cari%' 
						order by $tab DESC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM commodity WHERE commodity like '%$cari%' OR 
						com_desc like '%$cari%'"));
	}
}	
 else//jika user TIDAK melakukan pencarian
{
	if($_GET['a']=='1') // urutkan Ascending dulu
  	{
	$b=0; 
	$tampil=mysql_query("SELECT * FROM commodity order by $tab ASC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM commodity"));
	}
	else // jika diklik lagi maka akan pengurutan DESCENDING
  	{
	$b=1; 
	$tampil=mysql_query("SELECT * FROM commodity order by $tab DESC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM commodity"));
	}
}
//mulai membuat FORM nya
 	echo "<h2>DATA COMMODITY</h2>
 		<form method=POST action='?module=datacommodity'>
		<table border=0 cellpadding=0 cellspacing=0 width=100%>
			<tr><td>
			PENCARIAN : <input name=cari type=text size=20 value='$_POST[cari]' autocomplete=off> 
			<input type=submit value=CARI> <a href=?act=tambah_datacommodity>
			<span class=tombol> TAMBAH DATA </span></a>
			</td></tr>
		</table>"; 
	$jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
	$linkHalaman  = $p->navHalaman($_GET['halaman'], $jmlhalaman,'cari='.$cari);	
	echo "<p>$linkHalaman</p><table><tr><th>no</th>
		<th><a href=?module=datacommodity&r=r&a=$b&cari=$cari>commodity</a></th>
		<th><a href=?module=datacommodity&r=d&a=$b&cari=$cari>description</a></th><th>action</th></th></tr>";
	while ($r=mysql_fetch_array($tampil))
	{
		echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>$no</td><td>$r[commodity]</td>
          	<td>$r[com_desc]</td><td><a href=?act=edit_datacommodity&id=$r[idcommodity]>EDIT</a> | 
			<a href=\"javascript:deldata('$r[idcommodity]','Commodity : $r[com_desc] ?',
			'aksi.php?module=datacommodity&act=hapus&id=')\">HAPUS</a>
          	</td></tr>";
     $no++;
  	}
  echo "</table><p>word '$cari' found : $jmldata rows in $jmlhalaman pages</p></form>";

?>