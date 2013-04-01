<?php
	$p      = new Paging;
	$batas  =10;
	$posisi = $p->cariPosisi($batas);
    $no     = $posisi+1;
	
	if($_GET['r']=='r'){$tab='customer';}
	else if($_GET['r']=='d'){$tab='cus_desc';}
	else $tab='bendera';
	
if(!empty($_POST['cari'])){$cari=$_POST['cari'];}else{$cari=$_GET['cari'];}
if(!empty($cari))//jika user melakukan pencarian
{
	if($_GET['a']=='1') // urutkan Ascending dulu
  	{
	$b=0; 
	$tampil=mysql_query("SELECT * FROM customer WHERE customer like '%$cari%' OR cus_desc like '%$cari%' 
						order by $tab ASC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM customer WHERE customer like '%$cari%' OR 
						cus_desc like '%$cari%'"));
	}
	else // jika diklik lagi maka akan pengurutan DESCENDING
  	{
	$b=1; 
	$tampil=mysql_query("SELECT * FROM customer WHERE customer like '%$cari%' OR cus_desc like '%$cari%' 
						order by $tab DESC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM customer WHERE customer like '%$cari%' OR 
						cus_desc like '%$cari%'"));
	}
}	
 else//jika user TIDAK melakukan pencarian
{
	if($_GET['a']=='1') // urutkan Ascending dulu
  	{
	$b=0; 
	$tampil=mysql_query("SELECT * FROM customer order by $tab ASC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM customer"));
	}
	else // jika diklik lagi maka akan pengurutan DESCENDING
  	{
	$b=1; 
	$tampil=mysql_query("SELECT * FROM customer order by $tab DESC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM customer"));
	}
}
//mulai membuat FORM nya
 	echo "<h2>DATA CUSTOMER</h2>
 		<form method=POST action='?module=datacustomer'>
		<table border=0 cellpadding=0 cellspacing=0 width=100%>
			<tr><td>
			PENCARIAN : <input name=cari type=text size=20 value='$_POST[cari]' autocomplete=off> 
			<input type=submit value=CARI> <a href=?act=tambah_datacustomer>
			<span class=tombol> TAMBAH DATA </span></a>
			</td></tr>
		</table>"; 
	$jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
	$linkHalaman  = $p->navHalaman($_GET['halaman'], $jmlhalaman,'cari='.$cari);	
	echo "<p>$linkHalaman</p><table><tr><th>no</th>
		<th><a href=?module=datacustomer&r=r&a=$b&cari=$cari>customer</a></th>
		<th><a href=?module=datacustomer&r=d&a=$b&cari=$cari>description</a></th>
		<th><a href=?module=datacustomer&r=b&a=$b&cari=$cari>bendera</a></th>
<th>PIC Transhipment BC12</th>
		<th>action</th></th></tr>";
	while ($r=mysql_fetch_array($tampil))
	{
		echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>$no</td><td align=left>$r[customer]</td>
          	<td>$r[cus_desc]</td><td>$r[bendera]</td><td>$r[pejabatbc12]</td><td><a href=?act=edit_datacustomer&id=$r[idcustomer]>EDIT</a> | 
			<a href=\"javascript:deldata('$r[idcustomer]','Customer : $r[cus_desc] ?',
			'aksi.php?module=datacustomer&act=hapus&id=')\">HAPUS</a>
          	</td></tr>";
     $no++;
  	}
  echo "</table><p>word '$cari' found : $jmldata rows in $jmlhalaman pages</p></form>";

?>