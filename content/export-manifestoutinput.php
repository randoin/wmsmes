<?php
?>
  <script language="javascript">
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

//Allow only numeric input, decimal point, backspace
function isNumberKey(evt)
{
var myValidChars = new Array(0,8,46,48,49,50,51,52,53,54,55,56,57,190);
var charCode = (evt.which) ? evt.which : event.keyCode
if (charCode in oc(myValidChars))
return true;
return false;
}
   </SCRIPT>
<?
		
$tglnya=date("d-m-Y");
if($_GET[i]=='')
{
	$tampil=mysql_query("SELECT * FROM manifestout order by id_manifestout DESC limit 1 ");
	$r=mysql_fetch_array($tampil);
	$idmanifestout=$r[id_manifestout];
}
else
{
	$tampil=mysql_query("SELECT * FROM manifestout where id_manifestout='$_GET[i]' ");
	$r=mysql_fetch_array($tampil);
	$idmanifestout=$r[id_manifestout];
}
$ni=$r[nil];
$c=$r[status];
$tglman=$r[tglmanifest];
$tgl2=ymd2dmy($r[tglmanifest]);
 $tampill=mysql_query("SELECT * FROM buildup where isvoid='0' AND 
 id_manifestout='$idmanifestout' ORDER BY nould DESC");
$jmldata = mysql_num_rows($tampill);
$dbr=mysql_query("SELECT SUM(berat),SUM(koli) FROM buildup where id_manifestout='$idmanifestout' and isvoid='0'");
$databerat=mysql_fetch_array($dbr);

echo "<h2>$r[airline] : A/C Reg.$r[acregistration] Flight No.$r[noflight] / $tgl2</h2>";
if($_GET[e]=='1')
{$err='Data BUILDUP melebihi Data SMU !!!';}

if($_GET['a']>=1)
{
//cari di BTB dulu
$str=mysql_query("SELECT * FROM out_dtbarang_h,out_dtbarang where out_dtbarang_h.id=out_dtbarang.id_h AND out_dtbarang_h.btb_smu='$_GET[n]' AND out_dtbarang_h.status_bayar='yes' AND out_dtbarang_h.status_keluar='INSTORE' GROUP BY out_dtbarang_h.id");
$p=mysql_fetch_array($str);
	$tkoli=mysql_query("SELECT SUM(koli) AS totkoli,SUM(berat) AS totberat 
		FROM buildup,out_dtbarang_h where out_dtbarang_h.id=buildup.id_out_dtbarang_h 
		AND buildup.nosmu='$p[1]' AND out_dtbarang_h.status_keluar='INSTORE' GROUP BY buildup.id_out_dtbarang_h");
		$tk=mysql_fetch_array($tkoli);
		$sisakoli=$p[12]-$tk[totkoli];
		$sisaberat=$p[9]-$tk[totberat];
		$tipe=$p[32];
		$asal='MES';
		$tujuan=$p[btb_tujuan];
		$transit='MES';
		$totalberat=$p[9];
		$totalkoli=$p[12];	
		$beratbuildup=$tk[totberat];
		$kolibuildup=$tk[totkoli];
		$iddt=$p[0];

	}
	else
	{
	
		//kalau tdk ada di BTB baru cek di import
		/*$str=mysql_query("SELECT * FROM isimanifestin,manifestin where isimanifestin.no_smu='$_GET[n]' 
		AND manifestin.status='checked' AND isimanifestin.isvoid='0' AND isimanifestin.status_transit='TRANSIT'  
		AND isimanifestin.status_out='INSTORE'");
		$pr=mysql_fetch_array($str);*/

		$breakdata=mysql_query("SELECT *,SUM(kolidatang) AS bkolidatang,
		SUM(beratdatang) AS bberatdatang FROM breakdown,isimanifestin where 
		breakdown.id_isimanifestin=isimanifestin.id_isimanifestin AND isimanifestin.status_transit='TRANSIT' 
		AND breakdown.status_check='confirm'
		AND isimanifestin.no_smu='$_GET[n]' GROUP BY breakdown.id_isimanifestin");
		$p=mysql_fetch_array($breakdata);
		
		$tkoli=mysql_query("SELECT SUM(koli) AS totkoli,SUM(berat) AS totberat FROM buildup where 
		buildup.nosmu='$_GET[n]'");
		/*
		$tkoli=mysql_query("SELECT SUM(koli) AS totkoli,SUM(berat) AS totberat FROM buildup where 
		buildup.nosmu='$_GET[n]' AND status_keluar='INSTORE'");		
		*/

		$tk=mysql_fetch_array($tkoli);
		$sisakoli=$p[bkolidatang]-$tk[totkoli];
		$sisaberat=$p[bberatdatang]-$tk[totberat];
		$tipe=$p[jenisbarang];
		$asal=$p[asal];
		$tujuan=$p[tujuan];
		$transit='TRANSIT';
		$totalberat=$p[bberatdatang];
		$totalkoli=$p[bkolidatang];	
		$beratbuildup=$tk[totberat];
		$kolibuildup=$tk[totkoli];
		$iddt=$p[0];
	}


echo "<form name=form1 method=POST action='aksi.php?module=isimanifestout&act=input'>
<table><tr><td>
       	<table><tr><td>No.SMU</td><td> : <input name=nosmu size=20 value='$_GET[n]' autocomplete=off>
				<input type=submit value=CHECK name=tombolcek>
</td></tr><tr><td><B>Asal Airport</B></td><td> : <input type=text name=asal id=txtasal size=20  value='$asal' readonly=true></td</tr>
          <tr><td><B>Tujuan</B></td><td> : <input type=text name=tujuan size=20  value='$tujuan' readonly=true></td></tr>					
          <tr><td><B>Jenis Barang</B></td>     <td> : <input type=text size=30 name=jenisbarang  value='$tipe' readonly=true></td></tr>
       	  <tr><td><B>Koli/Berat (SMU)</B></td>     <td> : <input type=text size=8 name=totalkolismu  value='$totalkoli' readonly=true> koli / <input type=text name=totalberatsmu size=8 value='$totalberat' readonly=true> Kg</td></tr>
       	  <tr><td><B>Koli/Berat (Buildup)</B></td>     <td> : <input type=text size=8 name=totalkolibuildup  value='$kolibuildup' readonly=true> koli / <input type=text name=totalberatbuildup size=8 value='$beratbuildup' readonly=true> Kg</td></tr>
          <tr><td>No. ULD</td><td> : <input type=text name=nould size=20 autocomplete=off onChange=\"javascript:this.value=this.value.toUpperCase();\"> *</td></tr>					
       	  <tr><td>Jml Koli</td>     <td> : <input type=text size=10 name=koli  value='$sisakoli' autocomplete=off onkeypress=\"return isNumberKey(event)\"> *</td></tr>
    	  <tr><td>Berat(KG)</td><td> : <input type=text name=berat size=10  value='$sisaberat' autocomplete=off onkeypress=\"return isNumberKey(event)\"> *</td></tr>


                <tr><td colspan=2><center><strong>*) DATA TIDAK AKAN TERSIMPAN JIKA FIELD INI MASIH KOSONG</strong></center></td></tr>
                <tr><td colspan=2>
								<input type=hidden name=idman value='$idmanifestout'>
								<input type=hidden name=idoutdata value='$iddt'>
								<input type=hidden name=transit value='$transit'>
								";
								if(($c=='waiting') AND ($ni<>'on')) {echo "<input type=submit name=tombolsimpan value='Simpan dan Tambah'>
        <input type=button value=Batal onclick=self.history.back()>";}
				echo "</td></tr>
        </table>
				<span class=error>$err</span>
</td>
<td><B><CENTER>== DAFTAR ISI CARGO MANIFEST OUT ==</B><BR>( Total isi : ".$jmldata." items - ".$databerat[0]." Kg - ".$databerat[1]." Koli)</CENTER></B>";

	$p      = new Paging;
	$batas  = 10;
	$posisi = $p->cariPosisi($batas);
	$no     = $posisi+1;
	

 $tampil=mysql_query("SELECT * FROM buildup where isvoid='0' AND id_manifestout='$idmanifestout' 
 ORDER BY nould DESC limit $posisi,$batas");




	 echo "<table>
         <tr><th>no</th><th>No.ULD</th><th>No.SMU</th><th>Jml Koli</th><th>Berat(KG)</th><th>Asal</th><th>Tujuan</th><th>Jenis</th><th>Action</th>
         </tr>";
	$tgl1=my2date($tgl);

/*
	$tampil=mysql_query("
	SELECT * FROM buildup,out_dtbarang_h where buildup.id_out_dtbarang_h=out_dtbarang_h.id and buildup.isvoid='0' ORDER BY buildup.id_out_dtbarang_h DESC limit $posisi,$batas");
 */
// $tampil=mysql_query("
//	SELECT * FROM buildup where isvoid='0' AND id_manifestout='$idmanifestout' ORDER BY nosmu DESC limit $posisi,$batas");
	
	   	
  	while ($r=mysql_fetch_array($tampil))
        {
        	if($r[status]=='MES'){$tuju='MES';}else {$tuju=$r[tujuan];}
     	   echo "<tr><td>$no</td>
          <td align=center>$r[nould]</td><td>$r[nosmu]</td><td align=center>$r[koli]</td><td align=center>$r[berat]</td><td align=center>$r[asal]</td><td align=center>$r[tujuan]</td><td align=center>$r[jenisbarang]</td><td align=center>";
					if($r[status_keluar]=='INSTORE'){ echo "<a href=\"aksi.php?module=isimanifestout&act=hapus&n=$r[id_buildup]&i=$_GET[i]\" onclick=\"javascript:return confirm('Penghapusan data masih diperbolehkan dan tidak direkam, selama MANIFEST belum bestatus CHECKED. Apakah Anda yakin akan menghapus data ?')\">Delete</a></td></tr>";
					}
					else
					{
					echo "Delete";
					}
     	  $no++;
  	}
        echo "</table>";
     	
	$jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
  $linkHalaman  = $p->navHalaman($_GET[h], $jmlhalaman,'i='.$_GET[i]);
	echo $linkHalaman;
		 if($ni=='on') echo "MANIFEST NIL !!";
echo "</td></tr></table>
     </form>";


?>