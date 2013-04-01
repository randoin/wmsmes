<?php
	$p      = new Paging;
	$batas  =10;
	$posisi = $p->cariPosisi($batas);
    $no     = $posisi+1;
	

if(!empty($_POST['cari'])){$cari=$_POST['cari'];}else{$cari=$_GET['cari'];}

//mulai membuat FORM nya
 	echo "<h2>Data AWB</h2>
 		<form method=POST action='?module=carismu'>
		<table border=0 cellpadding=0 cellspacing=0 width=100%>
			<tr><td>
			PENCARIAN : <input name=cari type=text size=20 value='$_POST[cari]' autocomplete=off> 
			<input type=submit value=CARI> Masukkan No.AWB yang ingin dicari. Nomor tidak perlu lengkap.</td></tr>
		</table><p><a href=?act=tambah_awbtoday&s=$_POST[cari]>[TAMBAH DATA]</a> 
		<a href=?module=awbtoday>[AWB TODAY]</a></p>"; 
		
if(!empty($cari))//jika user melakukan pencarian
{
	$tampil=mysql_query("SELECT m.idmastersmu,m.nosmu,m.tglsmu,o.origin_code,d.dest_code,m.berat,m.koli,p.commodityap,a.agent,m.exim 
	FROM master_smu as m,origin as o,destination as d,commodity_ap as p, agent as a
	WHERE m.idorigin=o.idorigin AND m.iddestination=d.iddestination AND m.idagent=a.idagent 
	AND m.idcommodityap=p.idcommodityap AND m.nosmu like '%$cari%' AND m.isvoid='0'
						order by m.nosmu ASC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT m.idmastersmu,m.nosmu,m.tglsmu,o.origin_code,d.dest_code,m.berat,m.koli FROM master_smu as m,origin as o,destination as d,commodity_ap as p WHERE m.idorigin=o.idorigin AND m.iddestination=d.iddestination AND m.idcommodityap=p.idcommodityap AND m.nosmu like '%$cari%' AND m.isvoid='0'"));

		
	$jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
	$linkHalaman  = $p->navHalaman($_GET['halaman'], $jmlhalaman,'cari='.$cari);	
	echo "<p>$linkHalaman</p><table><tr>
		<th>AWB #</th><th>Date</th><th>Com</th><th>Org</th><th>Dest</th><th>Koli</th><th>KG</th><th>agent</th><th>status</th><th>action</th></tr>";
	while ($r=mysql_fetch_array($tampil))
	{
				if($r[commodityap]=='MAIL')
		{$noawb=format_nopos($r[nosmu]);}
		else{$noawb=format_awb($r[nosmu]);}
	$cekterbang = mysql_num_rows(mysql_query("select m.flightdate,m.acregister,f.flight
		from manifestout as m,isimanifestout as i,flight as f
		where m.idmanifestout=i.idmanifestout AND m.statuscancel='0' AND m.statusvoid='0' AND i.statuscancel='0' AND i.statusvoid='0'  
		AND m.idflight=f.idflight AND i.idmastersmu='$r[idmastersmu]' AND m.statusconfirm='1'"));
	
	

	echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>$noawb</td><td>".ymd2dmy($r[tglsmu])."</td><td>$r[commodityap]</td>
          	<td>$r[origin_code]</td><td>$r[dest_code]</td><td align=right>$r[koli]</td><td align=right>$r[berat]</td><td>$r[agent]</td>
			<td>";
		if($cekterbang>0) 
		{
			$data=mysql_fetch_array(mysql_query("select m.flightdate,m.acregister,f.flight
			from manifestout as m,isimanifestout as i,flight as f
			where m.idmanifestout=i.idmanifestout
			AND m.idflight=f.idflight AND i.idmastersmu='$r[idmastersmu]'")); 
			echo "Reg.$data[acregister] $data[flight] ".ymd2dmy($data[flightdate])."</td><td></td>";
		}
		else if(($cekterbang<=0)AND($r[exim]=='1')) 
		{
			echo "import</td><td></td>";
		}		

		else if(($cekterbang<=0)AND($r[exim]=='')) 
		{
			echo "instore</td><td><a href=?act=edit_carismu&ids=$r[idmastersmu]>[EDIT]</a> | <a href=aksi.php?module=carismu&act=hapus&ids=$r[idmastersmu]>[DELETE]</a></td>";
		}		
			echo "</td></tr>";
     $no++;
  	}
  echo "</table><p>word '$cari' found : $jmldata rows</p></form>";
}

?>