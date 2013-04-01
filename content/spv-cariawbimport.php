<?php
	$p      = new Paging;
	$batas  =10;
	$posisi = $p->cariPosisi($batas);
    $no     = $posisi+1;
	

if(!empty($_POST[cari])){$cari=$_POST[cari];}else{$cari=$_GET[cari];}

//mulai membuat FORM nya
 	echo "<h2>Data AWB Import</h2>
 		<form method=POST action='?module=cariawbimport'>
		<table border=0 cellpadding=0 cellspacing=0 width=100%>
			<tr><td>
			PENCARIAN : <input name=cari type=text size=20 value='$_POST[cari]' autocomplete=off> 
			<input type=submit value=CARI></td></tr>
		</table>"; 
if(!empty($cari))//jika user melakukan pencarian
{
$tampil=mysql_query("
SELECT i.idisimanifestin,i.berat as berat,i.koli as koli,m.acregister,m.flightdate,f.flight,m.idmanifestin,s.idcommodityap,s.nosmu,
s.tglsmu,c.commodityap,o.origin_code,d.dest_code,i.statusconfirm,i.paid 
FROM isimanifestin as i,master_smu as s,manifestin as m, flight as f,origin as o, destination as d,commodity_ap as c,agent as a
WHERE i.idmastersmu=s.idmastersmu AND i.idmanifestin=m.idmanifestin AND s.nosmu like '%$cari%' AND i.statusvoid='0' AND i.statuscancel='0' AND m.statusvoid='0' AND m.idflight=f.idflight AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND s.idcommodityap=c.idcommodityap AND s.idagent=a.idagent
");
		
	echo "<table><tr>
		<th>#AWB / Date</th><th>Qty</th><th>Com</th><th>Org</th><th>Dest</th><th>action</th></tr>";
	while ($r=mysql_fetch_array($tampil))
	{
if($r[idcommodityap]=='18')
{
	$noawb=format_nopos($r[nosmu]);} else{
		$noawb=format_awb($r[nosmu]);
		}

if(($r[statusconfirm]=='1') AND ($r[paid]=='1'))
	{
	$idb=mysql_fetch_array(mysql_query("select iddeliverybill from deliverybill where idisimanifestin='$r[idisimanifestin]'"));	
	echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>$noawb / ".ymd2dmy($r[tglsmu])."</td><td>$r[koli] koli $r[berat] kg</td><td>$r[commodityap]</td>
          	<td>$r[origin_code]</td><td>$r[dest_code]</td><td><a href=aksi.php?module=cariawbimport&act=voiddb&id=$r[idisimanifestin]&idb=$idb[0] onclick=\"javascript:return confirm('Apakah Anda yakin akan void DO untuk AWB ini?')\">[VOID DO]</a></td>";
	}
	else
	if(($r[statusconfirm]=='1') AND ($r[paid]<>'1'))
	{
	echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>$noawb / ".ymd2dmy($r[tglsmu])."</td><td>$r[koli] koli $r[berat] kg</td><td>$r[commodityap]</td>
          	<td>$r[origin_code]</td><td>$r[dest_code]</td><td><a href=aksi.php?module=cariawbimport&act=release&id=$r[idisimanifestin] onclick=\"javascript:return confirm('Apakah Anda yakin akan merelase AWB ini?')\">[RELEASE]</a></td>";
	}
     $no++;
  	}
	$no=1;
  echo "</table>
</form>";
}

?>