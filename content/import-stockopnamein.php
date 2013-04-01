<?php
$tglnya=date("Y-m-d");
$tgl=ymd2dmy($tglnya);
mysql_query("delete from stockopnamein");

//SMU yang sudah confirm dan statuskeluar kosong dan tujuan MES(130) 
mysql_query("insert into stockopnamein select m.nosmu,m.tglsmu,sum(i.berat) as berat,sum(i.koli) as koli,sum(i.berat) as ofberat,sum(i.koli) as ofkoli,m.idorigin,m.iddestination from master_smu as m, isimanifestin as i where i.idmastersmu=m.idmastersmu AND i.statuskeluar='' AND m.iddestination='130' group by i.idmastersmu");
//SMU yang sudah confirm dan statuskeluar kosong dan tujuan BUKAN MES(!=130) 
mysql_query("insert into stockopnamein select m.nosmu,m.tglsmu,sum(i.berat) as berat,sum(i.koli) as koli,sum(i.berat) as ofberat,sum(i.koli) as ofkoli,m.idorigin,m.iddestination from master_smu as m, isimanifestin as i where i.idmastersmu=m.idmastersmu AND i.statuskeluar='' AND m.iddestination<>'130' group by i.idmastersmu");

$jmlmes=mysql_fetch_array(mysql_query("select count(nosmu) as jsmu,sum(berat) as jberat,sum(koli) as jkoli from stockopnamein where iddestination='130'"));
$jmlnonmes=mysql_fetch_array(mysql_query("select count(nosmu) as jsmu,sum(berat) as jberat,sum(koli) as jkoli from stockopnamein where iddestination<>'130'"));

$jml=mysql_fetch_array(mysql_query("select count(nosmu) as jsmu,sum(berat) as jberat,sum(koli) as jkoli from stockopnamein"));



$tberat=0;$tkoli=0;

 echo "<h2>Kondisi Gudang Import Per : $tgl | 
			".number_format($jml[jsmu], 0, ',', '.')." AWB : 
			".number_format($jml[jkoli], 0, ',', '.')." Koli / 
			".number_format($jml[jberat] , 1, ',', '.')." Kg </h2>
		<p><a href=aksi.php?module=cetakstockopnamein target=_blank>[Cetak Stockopname] </a> <a href=#join>[MES] </a> <a href=#transit>[Transit] </a></p>";
echo "<p><a name=join id=join>MES</a> -> 			".number_format($jmlmes[jsmu], 0, ',', '.')." AWB : 
			".number_format($jmlmes[jkoli], 0, ',', '.')." Koli / 
			".number_format($jmlmes[jberat] , 1, ',', '.')." Kg</p>
<table><tr><th>no</th><th>#AWB / Date</th><th>Kg</th><th>Koli</th>
<th>ORG</th><th>DEST</th>";
$no=1;  

$datastock=mysql_query("select *,d.dest_code as destination,o.origin_code as origin  from stockopnamein as s,destination as d,origin as o where s.iddestination=d.iddestination AND s.idorigin=o.idorigin AND s.iddestination ='130' order by nosmu asc");
while ($r=mysql_fetch_array($datastock))
 {
	 echo "<tr><td>$no</td><td align=center>".format_awb($r[nosmu])." / ".ymd2dmy($r[tglsmu])."</td><td align=right width=80>$r[berat] of $r[berat_of]</td><td align=right width=80>$r[koli] of $r[koli_of]</td><td align=center width=40>$r[origin]</td><td align=center width=40>$r[destination]</td></tr>";
    $no++;		
	}
  echo "</table>
<p><a href=aksi.php?module=cetakstockopnamein target=_blank>[Cetak Stockopname] </a> <a href=#join>[MES] </a> <a href=#transit>[Transit] </a></p><BR>";
//utk transit :
//hitung berat transit
echo "<p><a name=join id=join>TRANSIT</a> -> 			".number_format($jmlnonmes[jsmu], 0, ',', '.')." AWB : 
			".number_format($jmlnonmes[jkoli], 0, ',', '.')." Koli / 
			".number_format($jmlnonmes[jberat] , 1, ',', '.')." Kg</p>
<table><tr><th>no</th><th>#AWB / Date</th><th>Kg</th><th>Koli</th>
<th>ORG</th><th>DEST</th>";
$no=1;  

$datastock=mysql_query("select *,d.dest_code as destination,o.origin_code as origin  from stockopnamein as s,destination as d,origin as o where s.iddestination=d.iddestination AND s.idorigin=o.idorigin AND s.iddestination <>'130' order by s.iddestination,s.nosmu asc");
$no=1;
while ($r=mysql_fetch_array($datastock))
 {
	 echo "<tr><td>$no</td><td align=center>".format_awb($r[nosmu])." / ".ymd2dmy($r[tglsmu])."</td><td align=right width=80>$r[berat] of $r[berat_of]</td><td align=right width=80>$r[koli] of $r[koli_of]</td><td align=center width=40>$r[origin]</td><td align=center width=40>$r[destination]</td></tr>";
    $no++;		
	}
  echo "</table>
		<p><a href=aksi.php?module=cetakstockopnamein target=_blank>[Cetak Stockopname] </a> <a href=#join>[MES] </a> <a href=#transit>[Transit] </a></p>";  


?>