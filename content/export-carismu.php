<?php
	$p      = new Paging;
	$batas  =10;
	$posisi = $p->cariPosisi($batas);
    $no     = $posisi+1;
	

if(!empty($_POST[cari])){$cari=$_POST[cari];}else{$cari=$_GET[cari];}

//mulai membuat FORM nya
 	echo "<h2>Data AWB</h2>
 		<form method=POST action='?module=carismu'>
		<table border=0 cellpadding=0 cellspacing=0 width=100%>
			<tr><td>
			PENCARIAN : <input name=cari type=text size=20 value='$_POST[cari]' autocomplete=off> 
			<input type=submit value=CARI></td></tr>
		</table>"; 
if(!empty($cari))//jika user melakukan pencarian
{
$tampil=mysql_query("
SELECT i.berat,i.koli,m.acregister,m.flightdate,f.flight
FROM isimanifestout as i,master_smu as s,manifestout as m, flight as f,origin as o, destination as d,commodity_ap as c,agent as a
WHERE i.idmastersmu=s.idmastersmu AND i.idmanifestout=m.idmanifestout AND s.nosmu='$cari' AND i.statusvoid='0' AND i.statuscancel='0' AND m.statusvoid='0' AND m.statusconfirm='1' AND m.idflight=f.idflight AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND s.idcommodityap=c.idcommodityap AND s.idagent=a.idagent
");
$tampil1=mysql_query("
SELECT s.nosmu,s.tglsmu,s.berat as brt,s.koli as kl,o.origin_code,d.dest_code,c.commodityap,a.agent,s.idcommodityap 
FROM master_smu as s,origin as o, destination as d,commodity_ap as c,agent as a
WHERE s.nosmu ='$cari' AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND s.idcommodityap=c.idcommodityap AND s.idagent=a.idagent
");

	echo "<table><tr>
		<th>#AWB / Date</th><th>Qty</th><th>Com</th><th>Org</th><th>Dest</th><th>agent</th></tr>";
	$b=0;$k=0;
	while ($r=mysql_fetch_array($tampil1))
	{
if($r[idcommodityap]=='18'){$noawb=format_nopos($r[nosmu]);}
else {$noawb=format_awb($r[nosmu]);}

	echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>$noawb / ".ymd2dmy($r[tglsmu])."</td><td>$r[kl] koli $r[brt] kg</td><td>$r[commodityap]</td>
          	<td>$r[origin_code]</td><td>$r[dest_code]</td><td>$r[agent]</td>";
     $no++;
	 $b+=$r[brt];$k+=$r[kl];
  	}
	$no=1;
  echo "</table>
<table><tr><th colspan=4>Histories : </th></tr>
		<th>no</th><th>A/C Reg</th><th>Flight / Date</th><th>Qty</th></tr>";
	while ($r=mysql_fetch_array($tampil))
	{
	echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>$no</td><td>$r[acregister]</td><td>$r[flight] / ".ymd2dmy($r[flightdate])."</td><td>$r[koli] koli $r[berat] kg</td>";
     $no++;
	$b-=$r[berat];$k-=$r[koli]; 
  	}
  echo "</table>
<p>Instore : $k koli $b kg</p>


</form>";
}

?>