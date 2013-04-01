<?php
$today=date('Y-m-d');


if($_GET[d]!=''){$tdy=$_GET[d];}
else {$tdy=ymd2dmy($today);}

	$tampil=mysql_query("SELECT m.tglpnbp,m.nomorpnbp,m.idmanifestin,m.acregister,m.flightdate,m.pointofloading,m.pointul,m.statusnil,
	f.flight,o.origin_code, m.statusconfirm,m.statuscancel,c.bendera,c.cus_desc,m.iddestination1,m.iddestination2,m.iddestination3 
	FROM manifestin as m,origin as o,flight as f, customer as c
	WHERE m.idorigin=o.idorigin AND m.idflight=f.idflight AND m.statusvoid='0' AND 
	f.idcustomer=c.idcustomer AND m.flightdate='$today' order by f.flight asc"); 



//mulai membuat FORM nya
 	echo "<h2>Data Manifest Import Today : $tdy</h2>
		<p><a href=?act=tambah_manifestimport>[TAMBAH DATA]</a>
		<a href=?module=carimanifestimport>[KEMBALI]</a></p>
 <table><tr>
		<th>A/C Reg.</th>
		<th>Flight Date</th>
		<th>Flight</th>
		<th>Org</th 
		<th>Dest</th>
		<th>Koli / Kg</th>
		<th>action</th><th>bongkar/timbun</th><th>PNBP</th>
		</tr>";
	while ($r=mysql_fetch_array($tampil))
	{
				$tglpnbp=ymd2dmy($r[tglpnbp]);
		$pnbp=$r[nomorpnbp].' '.$tglpnbp;
		
		$cekbrt=mysql_fetch_array(mysql_query("select sum(i.koli) as koli,sum(i.berat) as berat 
						from manifestin as m, isimanifestin as i 
						where i.idmanifestin=m.idmanifestin AND i.statusvoid='0' 
						AND i.idmanifestin=$r[idmanifestin]"));
						
		if($cekbrt[koli]==''){$koli=0;} else $koli=$cekbrt[koli];
		if($cekbrt[berat]==''){$berat=0;} else $berat=$cekbrt[berat];
		$confir=mysql_num_rows(mysql_query("select statusconfirm from isimanifestin where idmanifestin='$r[idmanifestin]' AND statusconfirm='1'"));
		
$de1=mysql_fetch_array(mysql_query("select d.dest_code from destination as d where d.iddestination=$r[iddestination1]"));
$de2=mysql_fetch_array(mysql_query("select d.dest_code from destination as d where d.iddestination=$r[iddestination2]"));
$de3=mysql_fetch_array(mysql_query("select d.dest_code from destination as d where d.iddestination=$r[iddestination3]"));

if($r[statusnil]=='on'){$n='nil';
	echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>$r[acregister]</td>";}
else {$n="$koli / $berat";
	echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td><a href=\"?module=isimanifestimport&idm=$r[idmanifestin]&r=$r[acregister]&f=$r[flight]&d=".ymd2dmy($r[flightdate])."\">$r[acregister]</a></td>";		}
	echo "<td width=10>".ymd2dmy($r[flightdate])."</td><td>$r[flight]</td>
          	<td>$r[origin_code]</td><td>$de1[0] - $de2[0] - $de3[0] </td><td align=right>$n</td>
			";
			if($confir>0)
			 {
			  echo "<td></td><td><a href=?module=batascetakbongkar&idm=$r[idmanifestin]&i=1>[BONGKAR]</a> <a href=?module=batascetakbongkar&idm=$r[idmanifestin]&i=2>[TIMBUN]</a></td>";
			 }
			 else
			 {
			  echo "<td>
<a href=?act=edit_carimanifestimport&idm=$r[idmanifestin]&r=$r[acregister]&f=$r[flight]&d=".ymd2dmy($r[flightdate]).">[EDIT]</a>";
		if($koli<>'0'){ echo "";}
		echo "  </td><td><a href=?module=batascetakbongkar&idm=$r[idmanifestin]&i=1>[BONGKAR]</a> <a href=?module=batascetakbongkar&idm=$r[idmanifestin]&i=2>[TIMBUN]</a></td>";
			 }
echo "
	<td><a href=?module=inputepnbp&idm=$r[idmanifestin]&r=$r[acregister]&f=$r[flight]&d=".ymd2dmy($r[flightdate]).">$pnbp</a></td></tr>";	
     $no++;
  	}
  echo "</table>";

?>