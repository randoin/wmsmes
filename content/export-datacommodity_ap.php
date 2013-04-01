<?php
	$p      = new Paging;
	$batas  =10;
	$posisi = $p->cariPosisi($batas);
    $no     = $posisi+1;
	
	if($_GET[r]=='r'){$tab='cp.commodityap';}
	else $tab='c.commodity';
	
if(!empty($_POST[cari])){$cari=$_POST[cari];}else{$cari=$_GET[cari];}
if(!empty($cari))//jika user melakukan pencarian
{
	if($_GET['a']=='1') // urutkan Ascending dulu
  	{
	$b=0; 
	$tampil=mysql_query("SELECT * FROM commodity_ap as cp,commodity as c 
			WHERE cp.idcommodity=c.idcommodity AND 
			(cp.commodityap like '%$cari%' OR c.commodity like '%$cari%') 
			order by $tab ASC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM commodity_ap as cp,commodity as c 
			WHERE cp.idcommodity=c.idcommodity AND 
			(cp.commodityap like '%$cari%' OR c.commodity like '%$cari%')"));
	}
	else // jika diklik lagi maka akan pengurutan DESCENDING
  	{
	$b=1; 
	$tampil=mysql_query("SELECT * FROM commodity_ap as cp,commodity as c 
			WHERE cp.idcommodity=c.idcommodity AND 
			(cp.commodityap like '%$cari%' OR c.commodity like '%$cari%') 
			order by $tab DESC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM commodity_ap as cp,commodity as c 
			WHERE cp.idcommodity=c.idcommodity AND 
			(cp.commodityap like '%$cari%' OR c.commodity like '%$cari%')"));
	}
}	
 else//jika user TIDAK melakukan pencarian
{
	if($_GET['a']=='1') // urutkan Ascending dulu
  	{
	$b=0; 
	$tampil=mysql_query("SELECT * FROM commodity_ap as cp,commodity as c 
			WHERE cp.idcommodity=c.idcommodity order by $tab ASC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM commodity_ap as cp,commodity as c 
			WHERE cp.idcommodity=c.idcommodity"));
	}
	else // jika diklik lagi maka akan pengurutan DESCENDING
  	{
	$b=1; 
	$tampil=mysql_query("SELECT * FROM commodity_ap as cp,commodity as c 
			WHERE cp.idcommodity=c.idcommodity order by $tab DESC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM commodity_ap as cp,commodity as c 
			WHERE cp.idcommodity=c.idcommodity"));
	}
}
//mulai membuat FORM nya
 	echo "<h2>DATA COMMODITY (REFF:AP)</h2>
 		<form method=POST action='?module=datacommodity_ap'>
		<table border=0 cellpadding=0 cellspacing=0 width=100%>
			<tr><td>
			PENCARIAN : <input name=cari type=text size=20 value='$_POST[cari]' autocomplete=off> 
			<input type=submit value=CARI> <a href=?act=tambah_datacommodity_ap>
			<span class=tombol> TAMBAH DATA </span></a>
			</td></tr>
		</table>"; 
	$jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
	$linkHalaman  = $p->navHalaman($_GET['halaman'], $jmlhalaman,'cari='.$cari);	
	echo "<p>$linkHalaman</p><table><tr><th>no</th>
		<th><a href=?module=datacommodity_ap&r=r&a=$b&cari=$cari>sub commodity code</a></th>
		<th><a href=?module=datacommodity_ap&r=d&a=$b&cari=$cari>commodity code</a></th><th>action</th></th></tr>";
	while ($r=mysql_fetch_array($tampil))
	{
		echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>$no</td><td>$r[commodityap]</td>
          	<td>$r[commodity]</td>
			<td><a href=?act=edit_datacommodity_ap&id=$r[idcommodityap]>EDIT</a> | 
			<a href=\"javascript:deldata('$r[idcommodityap]','Commodity $r[commodityap] ?',
			'aksi.php?module=datacommodity_ap&act=hapus&id=')\">HAPUS</a>
          	</td></tr>";
     $no++;
  	}
  echo "</table><p>word '$cari' found : $jmldata rows in $jmlhalaman pages</p></form>";
?>