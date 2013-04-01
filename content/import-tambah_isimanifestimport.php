<?php
?>
 <SCRIPT language=Javascript>
	//Convert array into object
	function oc(a)
	{
	var o = {};
	 for(var i=0;i<a.length;i++)
	 {
	  o[a[i]]='';
	 }
	return o;
	}

	//Allow only alphabetical input, decimal point, backspace
	function isNumber(evt)
	{
		var myValidChars = new Array(0,8,46,48,49,50,51,52,53,54,55,56,57,190);
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode in oc(myValidChars))
		return true;
		return false;
	}	

	//Allow only alphabetical input, decimal point, backspace
	function iscek(evt)
	{
		var myValidChars = new Array(0,8,46,48,49,50,51,52,53,54,55,56,57,190,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122);
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode in oc(myValidChars))
		return true;
		return false;
	}
	
</SCRIPT>
<?
$cari=$_POST[cari];

$import0=mysql_fetch_array(mysql_query("SELECT s.idmastersmu from master_smu as s 
WHERE s.isvoid='0' AND nosmu='$cari' AND s.exim='1'")); //klu import exim=1 dan belum ada

$import1=mysql_fetch_array(mysql_query("SELECT s.idmastersmu from master_smu as s,isimanifestin as i WHERE i.idmastersmu=s.idmastersmu AND s.isvoid='0' AND nosmu='$cari'")); //klu import dan SUDAH ADA

$data0=mysql_fetch_array(mysql_query("SELECT beratbayar as beratbayar,berat as berat,koli as koli FROM master_smu where 
nosmu='$cari' and isvoid='0'"));//berat SMU

$data1=mysql_fetch_array(mysql_query("SELECT SUM(i.beratbayar) as beratbayar,SUM(i.berat) as berat,SUM(i.koli) as koli FROM isimanifestin as i, master_smu as s where i.idmastersmu=s.idmastersmu AND s.nosmu='$cari' and s.isvoid='0' GROUP BY i.idmastersmu"));//berat Manifest


$berat0=$data0[berat];//AWB
$beratb0=$data0[beratbayar];//AWB
$koli0=$data0[koli];


$berat1=$data1[berat];//manifest
$beratb1=$data1[beratbayar];//manifest
$koli1=$data1[koli];

$brt=$berat0-$berat1;
$brtb=$beratb0-$beratb1;
$kl=$koli0-$koli1;

$tgl=date('Y-m-d');	
  echo "<h2>Tambah Isi Manifest Import -> A/C Reg.$_GET[r] Flight $_GET[f] $_GET[d]</h2>
 		<form method=POST action='?act=tambah_isimanifestimport&idm=$_GET[idm]&r=$_GET[r]&f=$_GET[f]&d=$_GET[d]'>
		<table border=0 cellpadding=0 cellspacing=0 width=100%>
			<tr><td>
			#AWB : <input name=cari type=text size=20 value='$_POST[cari]' autocomplete=off> 
			<input type=submit value=CHECK></td></tr>
		</table>"; 
if(!empty($cari))//jika user melakukan pencarian
{
$tampil=mysql_query("
SELECT i.beratbayar,i.berat,i.koli,m.acregister,m.flightdate,f.flight
FROM isimanifestin as i,master_smu as s,manifestin as m, flight as f,origin as o, destination as d,commodity_ap as c,agent as a
WHERE i.idmastersmu=s.idmastersmu AND i.idmanifestin=m.idmanifestin AND s.nosmu='$cari' AND i.statusvoid='0' AND i.statuscancel='0' AND m.statusvoid='0' AND m.idflight=f.idflight AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND s.idcommodityap=c.idcommodityap AND s.idagent=a.idagent
");
$tampil1=mysql_query("
SELECT s.nosmu,s.tglsmu,s.beratbayar as brtb,s.berat as brt,s.koli as kl,o.origin_code,d.dest_code,c.commodityap,a.agent,s.idcommodityap 
FROM master_smu as s,origin as o, destination as d,commodity_ap as c,agent as a
WHERE s.nosmu ='$cari' AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND s.idcommodityap=c.idcommodityap AND s.idagent=a.idagent
");
if($import0<=0){echo "<a href=?module=tambah_awb&idm=$_GET[idm]&r=$_GET[r]&f=$_GET[f]&d=$_GET[d]&s=$cari>[TAMBAHKAN AWB]</a>";}
	echo "<table><tr>
		<th>#AWB / Date</th><th>Qty</th><th>Com</th><th>Org</th><th>Dest</th><th>action</th></tr>";
	$b=0;$k=0;
	while ($r=mysql_fetch_array($tampil1))
	{
	if($r[idcommodityap]=='18'){$noawb=format_nopos($r[nosmu]);}
	else {$noawb=format_awb($r[nosmu]);}
	
	echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>$noawb / ".ymd2dmy($r[tglsmu])."</td><td>$koli1/$koli0 koli --> $berat1/$berat0 kg --> Chgbl Wght : $beratb1/$beratb0 kg</td><td>$r[commodityap]</td>
          	<td>$r[origin_code]</td><td>$r[dest_code]</td>";
			if(($import1>=0) AND ($brt>0) AND ($brtb>0)){echo "<td><a href=?module=tambah_awb&idm=$_GET[idm]&r=$_GET[r]&f=$_GET[f]&d=$_GET[d]&s=$cari&sp=1&b0=$berat0&bb0=$beratb0&k0=$koli0&bb=$brtb&b=$brt&k=$kl&rm=>[TAMBAH]</a></td>";} else {"<td></td>";}
     $no++;
	 $b+=$r[brt];$k+=$r[kl];
  	}
	$no=1;
  echo "</table>
<table><tr><th colspan=6>Histories : </th></tr>
		<th>no</th><th>A/C Reg</th><th>Flight / Date</th><th>Qty</th><th>Cetak</th></tr>";
	while ($r=mysql_fetch_array($tampil))
	{
	echo "
	<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
	<td>$no</td><td>$r[acregister]</td><td>$r[flight] / ".ymd2dmy($r[flightdate])."</td><td>$r[koli] koli $r[berat] kg</td><td>[BC1.2] [NOA]</td>";
     $no++;
  	}
  echo "</table>


</form>";
}
		

?>