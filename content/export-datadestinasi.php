<?php
	$p      = new Paging;
	$batas  =10;
	$posisi = $p->cariPosisi($batas);
    $no     = $posisi+1;
	
	if($_GET[r]=='c'){$tab='d.dest_code';}
	else if($_GET[r]=='d'){$tab='r.dest_desc';}
	else $tab='r.region';
	
if(!empty($_POST[cari])){$cari=$_POST[cari];}else{$cari=$_GET[cari];}
if(!empty($cari))//jika user melakukan pencarian
{
	if($_GET['a']=='1') // urutkan Ascending dulu
  	{
	$b=0; 
	$tampil=mysql_query("SELECT * FROM destination as d,region as r 
			WHERE d.idregion=r.idregion AND 
			(d.dest_code like '%$cari%' OR r.dest_desc like '%$cari%') 
			order by $tab ASC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM destination as d,region as r 
			WHERE d.idregion=r.idregion AND 
			(d.dest_code like '%$cari%' OR r.dest_desc like '%$cari%')"));
	}
	else // jika diklik lagi maka akan pengurutan DESCENDING
  	{
	$b=1; 
	$tampil=mysql_query("SELECT * FROM destination as d,region as r 
			WHERE d.idregion=r.idregion AND 
			(d.dest_code like '%$cari%' OR r.dest_desc like '%$cari%') 
			order by $tab DESC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM destination as d,region as r 
			WHERE d.idregion=r.idregion AND 
			(d.dest_code like '%$cari%' OR r.dest_desc like '%$cari%')"));
	}
}	
 else//jika user TIDAK melakukan pencarian
{
	if($_GET['a']=='1') // urutkan Ascending dulu
  	{
	$b=0; 
	$tampil=mysql_query("SELECT * FROM destination as d,region as r 
			WHERE d.idregion=r.idregion
			order by $tab ASC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM destination as d,region as r 
			WHERE d.idregion=r.idregion"));
	}
	else // jika diklik lagi maka akan pengurutan DESCENDING
  	{
	$b=1; 
	$tampil=mysql_query("SELECT * FROM destination as d,region as r 
			WHERE d.idregion=r.idregion
			order by $tab DESC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM destination as d,region as r 
			WHERE d.idregion=r.idregion"));
	}
}
//mulai membuat FORM nya
 	echo "<h2>DATA DESTINATION</h2>
 		<form method=POST action='?module=datadestinasi'>
		<table border=0 cellpadding=0 cellspacing=0 width=100%>
			<tr><td>
			PENCARIAN : <input name=cari type=text size=20 value='$_POST[cari]' autocomplete=off> 
			<input type=submit value=CARI> <a href=?act=tambah_datadestination>
			<span class=tombol> TAMBAH DATA </span></a>
			</td></tr>
		</table>"; 
	$jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
	$linkHalaman  = $p->navHalaman($_GET['halaman'], $jmlhalaman,'cari='.$cari);	
	echo "<p>$linkHalaman</p><table><tr><th>no</th>
		<th><a href=?module=datadestinasi&r=c&a=$b&cari=$cari>code destination</a></th>
		<th><a href=?module=datadestinasi&r=d&a=$b&cari=$cari>decription</a></th>
		<th><a href=?module=datadestinasi&r=r&a=$b&cari=$cari>region code</a></th>
<th>KPBC</th>
<th>Kode KPBC</th>	<th>TPS</th>		
<th>action</th></th></tr>";
	while ($r=mysql_fetch_array($tampil))
	{
		echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>$no</td><td>$r[dest_code]</td>
          	<td>$r[description]</td><td>$r[region]</td><td>$r[kpbc]</td><td>$r[nokpbc]</td>
<td>$r[tps]</td>
			<td><a href=?act=edit_datadestination&id=$r[iddestination]>EDIT</a> | 
			<a href=\"javascript:deldata('$r[iddestination]','Dest Code : $r[dest_code] ?',
			'aksi.php?module=datadestinasi&act=hapus&id=')\">HAPUS</a>
          	</td></tr>";
     $no++;
  	}
  echo "</table><p>word '$cari' found : $jmldata rows in $jmlhalaman pages</p></form>";

?>