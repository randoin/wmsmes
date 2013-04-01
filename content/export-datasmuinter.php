<?php
 	echo "<h2>DATA AWB INTERNATIONAL</h2>
 		<form method=POST action='?module=datasmuinter'>
		<table border=0 cellpadding=0 cellspacing=0 width=100%>
			<tr><td>
			PENCARIAN : <input name=cari type=text size=20 value='$_POST[cari]' autocomplete=off> 
			<input type=submit value=CARI> <a href=?act=tambah_datasmuinter>
			<span class=tombol> TAMBAH DATA </span></a>
			</td></tr>
		</table></form>"; 
		
if(!empty($_POST[cari])){$cari=$_POST[cari];}else{$cari=$_GET[cari];}
if(!empty($cari))//jika user melakukan pencarian
{
	$no1 = substr($cari,0,3);
	$no2 = substr($cari,3,4);
	$no3 = substr($cari,7,4);
	$cari= $no1.'-'.$no2.' '.$no3;
	$jmldata=mysql_num_rows(mysql_query("SELECT * FROM mastersmu WHERE nosmu = '$cari'"));
	if($jmldata<=0)
	{
	echo "<p><B><font color=#FF0000>Sorry, AWB# $cari NOT FOUND !!</font></b><BR>
	<B>Perlu diingat dan dicek lagi :</B><BR>1. No AWB TIDAK USAH DIMASUKKAN TANDA '-' nya atau spasinya, langsung ketik angkanya saja. <BR>
	2. Panjang No AWB adalah 11 (tanpa -) digit, contoh : XXX-YYYY ZZZZ<BR>
	<b>Jika kedua hal tersebut sudah benar tapi data belum ditemukan, kemungkinan AWB memang belum ada di database.</b></p>";
	}
	else
	{
	$p=mysql_query("SELECT * FROM mastersmu as m,commodity_ap as c,
	agent as a,origin as o, destination as d WHERE 
	m.nosmu = '$cari' AND m.idcommodityap=c.idcommodityap 
	AND m.idorigin=o.idorigin AND m.iddestination=d.iddestination
	AND m.idagent = a.idagent");
	$r=mysql_fetch_array($p);
	echo "<table>
	<tr align=left><td><B>AWB No.</B></td><td>: $r[nosmu]</td></tr>
	<tr><td><B>AWB Date</B></td><td>: $r[tglsmu]</td></tr>
	<tr><td><B>Commodity</B></td><td>: $r[commodityap]-$r[comm_code]</td></tr>
	<tr><td><B>Origin</B></td><td>: $r[origin_code] - region $r[region]</td></tr>
	<tr><td><B>Destination</B></td><td>: $r[dest_code] - region $r[region]</td></tr>			
	<tr><td><B>Weight(Kg)</B></td><td>: $r[berat]</td></tr>
	<tr><td><B>Collies</B></td><td>: $r[koli]</td></tr>
	<tr><td><B>Transit ?</B></td><td>: $r[status_transit]</td></tr>
	<tr><td><B>Agent</B></td><td>:  $r[agent]</td></tr>			
	<tr><td><B>Consignee</B></td><td>: $r[consignee]</td></tr>
	<tr><td><B>Shipper</B></td><td>: $r[shipper]</td></tr></table>";
	}
}	
?>