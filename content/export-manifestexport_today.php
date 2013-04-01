<?php
$today=date('Y-m-d');


if($_GET[d]!=''){$tdy=$_GET[d];}
else {$tdy=ymd2dmy($today);}

	$tampil=mysql_query("SELECT m.idmanifestout,m.acregister,m.flightdate,m.pointofloading,m.pointul,m.statusnil,
	f.flight,o.origin_code, d.dest_code,m.iddestination2,m.statusconfirm,m.statuscancel,c.bendera,c.cus_desc
	FROM manifestout as m,origin as o,destination as d,flight as f, customer as c
	WHERE m.idorigin=o.idorigin AND m.iddestination=d.iddestination AND m.idflight=f.idflight AND m.statusvoid='0' AND 
	f.idcustomer=c.idcustomer AND m.flightdate='$today' order by m.idmanifestout desc"); 


//mulai membuat FORM nya
 	echo "<h2>Data Manifest Export Today : $tdy</h2>
		<p><a href=?act=tambah_manifestexport>[TAMBAH DATA]</a></p>
 <table><tr>
		<th>A/C Reg.</th>
		<th>Flight Date</th>
		<th>Flight</th>
		<th>Org</th 
		<th>Dest</th>
		<th>Koli / Kg</th>
		<th>status</th>
		<th>action</th><th>manifest</th>
<th>h.ovr</th>
<th>delv.</th>
		</tr>";
	while ($r=mysql_fetch_array($tampil))
	{
		$cekbrt=mysql_fetch_array(mysql_query("select sum(i.koli) as koli,sum(i.berat) as berat 
						from manifestout as m, isimanifestout as i 
						where i.idmanifestout=m.idmanifestout AND i.statusvoid='0' 
						AND i.idmanifestout=$r[idmanifestout]"));
		if($cekbrt[koli]==''){$koli=0;} else $koli=$cekbrt[koli];
		if($cekbrt[berat]==''){$berat=0;} else $berat=$cekbrt[berat];
	$des2=mysql_fetch_array(mysql_query("SELECT dest_code from destination 
	where iddestination=$r[iddestination2]"));	
		
if($r[statusnil]=='on'){$n='nil';
	echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>$r[acregister]</td>";}
else {$n="$koli / $berat";
	echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td><a href=\"?module=isimanifestexport&idm=$r[idmanifestout]&r=$r[acregister]&f=$r[flight]&d=".ymd2dmy($r[flightdate])."\">$r[acregister]</a></td>";		}
	echo "<td width=10>".ymd2dmy($r[flightdate])."</td><td>$r[flight]</td>
          	<td>$r[origin_code]</td><td>$r[dest_code] $des2[0]</td><td align=right>$n</td>
			<td>";
			if(($r[statusconfirm]=='1') AND ($r[statuscancel]=='0'))
			 {
			  echo "OUT</td><td></td><td><a href=aksi.php?module=cetakmanifestout&idm=$r[idmanifestout]&s=0>[CARGO]</a><a href=aksi.php?module=cetakmanifestout&idm=$r[idmanifestout]&s=1>[MAIL]</a>
<a href=aksi.php?module=cetakmanifestout&idm=$r[idmanifestout]&s=2>[SPLIT]</a></td><td align=center><a href=aksi.php?module=cetakhandoverexport&idm=$r[idmanifestout]>[CETAK]</a></td><td align=center><a href=aksi.php?module=cetakdeliverycargo&idm=$r[idmanifestout]&s=0>[CETAK]</a></td>";
			 }
			else if($r[statuscancel]=='1')
			 {
			  echo "CANCEL</td><td></td><td></td><td></td>";
			 }
			 else
			 {
			  echo "</td><td><a href=aksi.php?module=carimanifestexport&act=confirm&idm=$r[idmanifestout]&d=$dt 
		  onclick=\"javascript:return confirm('CONFIRM MANIFEST INI ?')\">[CONFIRM]</a>  
<a href=?act=edit_carimanifestexport&idm=$r[idmanifestout]&r=$r[acregister]&f=$r[flight]&d=$dt>[EDIT]</a>";
		if($koli<>'0'){ echo " 
<a href=\"?module=beratuld&idm=$r[idmanifestout]&d=$dt&red=$r[acregister]&f=$r[flight] 
		  \">[KG ULD]</a>";}
		echo "  </td><td><a href=aksi.php?module=cetakmanifestout&idm=$r[idmanifestout]&s=0>[CARGO]</a><a href=aksi.php?module=cetakmanifestout&idm=$r[idmanifestout]&s=1>[MAIL]</a>
<a href=aksi.php?module=cetakmanifestout&idm=$r[idmanifestout]&s=2>[SPLIT]</a></td><td></td><td></td>";
			 }
			echo "
	</tr>";
     $no++;
  	}
  echo "</table>";

?>