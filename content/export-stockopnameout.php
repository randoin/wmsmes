<?php
$tglnya=date("Y-m-d");
$tgl=ymd2dmy($tglnya);
mysql_query("delete from stockopnameout");

/*
PROSES MENGHITUNG STOCKOPNAME
proses ini menggunakan bantuan tabel stockopnameout
stockopname dibagi 2 proses yaitu :
 1. penghitungan untuk AWB yang SUDAH di MANIFEST EXPORT, confirm/tdk, split/tdk :
     1.1 yg sudah CONFIRM
     1.2 sisa nya
 2. penghitungan untuk AWB yang BELUM SAMA SEKALI di MANIFIEST EXPORT
*/

// 1. penghitungan untuk AWB yang SUDAH di MANIFEST EXPORT, confirm/tdk, split/tdk
//daftar awb yang sudah CONFIRM di manifest export -> m.statusconfirm=1:
$manifest_confirm=mysql_query("select s.idmastersmu,s.nosmu,s.tglsmu,sum(i.berat) as berat,sum(i.koli) as koli 
FROM master_smu as s, isimanifestout as i, manifestout as m
WHERE m.idmanifestout=i.idmanifestout AND 
i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND s.isvoid='0' 
AND m.statusvoid='0' AND m.statuscancel='0' AND m.statusconfirm='1' GROUP BY s.idmastersmu");

//menghitung jumlah barang tersisa untuk awb yang sudah terconfirm di manifest
$tberat=0;$tkoli=0;
while ($r=mysql_fetch_array($manifest_confirm))
 {
	 //data berat koli awb yang confirm secara keseluruhan
	$data0=mysql_fetch_array(mysql_query("SELECT nosmu,berat,koli,tglsmu,idorigin,iddestination 
	FROM master_smu where  
	 idmastersmu='$r[idmastersmu]' and isvoid='0'"));
	// data berat koli -> awb yang di confirm
	$data1=mysql_fetch_array(mysql_query("SELECT SUM(i.berat) as berat,SUM(i.koli) as koli 
	FROM isimanifestout as i, manifestout as m where m.idmanifestout=i.idmanifestout AND 
	i.idmastersmu='$r[idmastersmu]'  and i.statusvoid='0' and i.statuscancel='0' AND 
	m.statusvoid='0' and m.statuscancel='0' AND m.statusconfirm='1' GROUP BY i.idmastersmu"));
	
	//total berat awb yang di confirm
	$berat=$data0[berat]-$data1[berat];
	//total berat datang awb
	$berat_of=$data0[berat];
	//total koli awb yang di confirm
	$koli=$data0[koli]-$data1[koli];
	//total koli datang awb
	$koli_of=$data0[koli];
	
	if(($berat<>'0') AND ($koli<>'0'))
	{
			//simpan ke tabel stockopnameout
		mysql_query("insert into stockopnameout 
		values('$data0[nosmu]','$data0[tglsmu]','$berat','$koli',
		'$data0[berat]','$data0[koli]','$data0[idorigin]','$data0[iddestination]')");
		 $tberat+=$berat;$tkoli+=$koli;
	}
  }

//end of  penghitungan untuk AWB yang SUDAH di MANIFEST EXPORT, confirm/tdk, split/tdk  

//  2. penghitungan untuk AWB yang BELUM SAMA SEKALI di MANIFEST EXPORT 
//daftar semua AWB di database
$nomanifest=mysql_query("select s.idmastersmu,s.nosmu,s.tglsmu,s.berat,s.koli,s.idorigin,s.iddestination 
FROM master_smu as s WHERE s.isvoid='0'");

while ($r=mysql_fetch_array($nomanifest))
{
	//cari apakah AWB ini sudah ada di tabel manifest dan confirm dan tdk void & tdk cancel
	$st=mysql_num_rows(mysql_query("select i.idmastersmu 
	from isimanifestout as i,manifestout as m 
	WHERE m.idmanifestout=i.idmanifestout AND i.statusvoid='0' AND i.statuscancel='0' 
	AND m.statusvoid='0' AND m.statuscancel='0' AND m.statusconfirm='1' 
	AND i.idmastersmu='$r[idmastersmu]'")); 
	if($st<=0)
	{
		mysql_query("insert into stockopnameout 
		values('$r[nosmu]','$r[tglsmu]','$r[berat]','$r[koli]',
		'$r[berat]','$r[koli]','$r[idorigin]','$r[iddestination]')");
		 $tberat+=$berat;$tkoli+=$koli;
	}
}
// end of penghitungan untuk AWB yang BELUM SAMA SEKALI di MANIFIEST EXPORT 
//-------------------------------
$jml=mysql_fetch_array(mysql_query("select count(nosmu) as jsmu,sum(berat) as jberat,sum(koli) as jkoli from stockopnameout"));

  echo "<h2>Kondisi Gudang EXPORT Per : $tgl | 
			".number_format($jml[jsmu], 0, ',', '.')." AWB : 
			".number_format($jml[jkoli], 0, ',', '.')." Koli / 
			".number_format($jml[jberat] , 1, ',', '.')." Kg </h2>
		<p><a href=aksi.php?module=cetakstockopnameout target=_blank>[Cetak Stockopname] </a> <a href=#join>[Joining] </a> <a href=#transit>[Transit] </a></p>";
//hitung berat joining
$jml=mysql_fetch_array(mysql_query("select  count(s.nosmu) as jsmu,sum(s.berat) as jberat,sum(s.koli) as jkoli from stockopnameout as s,origin as o, destination as d WHERE s.idorigin=o.idorigin AND s.iddestination = d.iddestination 
AND o.origin_code='MES'"));
echo "<p><a name=join id=join>JOINING</a> -> 			".number_format($jml[jsmu], 0, ',', '.')." AWB : 
			".number_format($jml[jkoli], 0, ',', '.')." Koli / 
			".number_format($jml[jberat] , 1, ',', '.')." Kg</p>
<table><tr><th>no</th><th>#AWB / Date</th><th>Kg</th><th>Koli</th>
<th>ORG</th><th>DEST</th>";
$no=1;  

$data=mysql_query("select s.*,o.origin_code,d.dest_code from stockopnameout as s,origin as o, destination as d WHERE s.idorigin=o.idorigin AND s.iddestination = d.iddestination 
AND o.origin_code='MES' order by d.dest_code ASC");
while ($r=mysql_fetch_array($data))
  {
	echo "<tr><td>$no</td><td align=center>".format_awb($r[nosmu])." / ".ymd2dmy($r[tglsmu])."</td><td align=right width=80>$r[berat] of $r[berat_of]</td><td align=right width=80>$r[koli] of $r[koli_of]</td><td align=center width=40>$r[origin_code]</td><td align=center width=40>$r[dest_code]</td></tr>";
    $no++;		
	}
  echo "</table>
<p><a href=aksi.php?module=cetakstockopnameout target=_blank>[Cetak Stockopname] </a> <a href=#join>[Joining] </a> <a href=#transit>[Transit] </a></p><BR>";
//utk transit :
//hitung berat transit
$jml=mysql_fetch_array(mysql_query("select  count(s.nosmu) as jsmu,sum(s.berat) as jberat,sum(s.koli) as jkoli from stockopnameout as s,origin as o, destination as d WHERE s.idorigin=o.idorigin AND s.iddestination = d.iddestination 
AND o.origin_code<>'MES'"));
echo "<p><a name=transit id=transit>TRANSIT -> 			".number_format($jml[jsmu], 0, ',', '.')." AWB : 
			".number_format($jml[jkoli], 0, ',', '.')." Koli / 
			".number_format($jml[jberat] , 1, ',', '.')." Kg</p>
<table><tr><th>no</th><th>#AWB / Date</th><th>Kg</th><th>Koli</th>
<th>ORG</th><th>DEST</th>";
$no=1;  
$data=mysql_query("select s.*,o.origin_code,d.dest_code from stockopnameout as s,origin as o, destination as d WHERE s.idorigin=o.idorigin AND s.iddestination = d.iddestination 
AND o.origin_code<>'MES' order by d.dest_code ASC");
while ($r=mysql_fetch_array($data))
  {
	echo "<tr><td>$no</td><td align=center>".format_awb($r[nosmu])." / ".ymd2dmy($r[tglsmu])."</td><td align=right width=80>$r[berat] of $r[berat_of]</td><td align=right width=80>$r[koli] of $r[koli_of]</td><td align=center width=40>$r[origin_code]</td><td align=center width=40>$r[dest_code]</td></tr>";
    $no++;		
	}
  echo "</table>
		<p><a href=aksi.php?module=cetakstockopnameout target=_blank>[Cetak Stockopname] </a> <a href=#join>[Joining] </a> <a href=#transit>[Transit] </a></p>";  

?>