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
  <SCRIPT LANGUAGE="JavaScript" src="cal2.js">
  </script>
  <script language="javascript">
    addCalendar("Caritanggal","Tanggal","tgldatang","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
  </script>
  <?
 $tampil=mysql_query("select *, SUM(beratdatang) AS tberatdatang, SUM(kolidatang) AS tkolidatang from isimanifestin,breakdown where isimanifestin.id_isimanifestin=breakdown.id_isimanifestin AND isimanifestin.id_isimanifestin='$_GET[n]' GROUP BY isimanifestin.id_isimanifestin");
  $r=mysql_fetch_array($tampil);

	if($_GET['p']=='e')
  	{
    	$err='Jumlah Barang Melebihi Manifest !';
	}
  $tglnya=date("d-m-Y");
  echo "<h2>Split kedatangan SMU : $r[no_smu]</h2>
       <form name=form1 method=POST action=aksi.php?module=breakdown&act=input>
       <table><tr><td>
			  <B>UPDATE JUMLAH BARANG <u>SESUAI KEDATANGAN</u> !</B><BR>
       <table>
       <tr><td><b>Total Koli di SMU</b></td>     <td> : <input type=text size=10 name=totalkoli value='$r[totalkoli]' readonly=true> *
       <tr><td><b>Total Berat di SMU</b></td>     <td> : <input type=text size=10 name=totalberat value='$r[totalberat]' readonly=true> *
       <tr><td><b>JML BERAT DATANG</b></td>     <td> : <input type=text size=10 name=tberatdatang value='$r[tberatdatang]'
	    readonly=true> *	   
       <tr><td><b>JML KOLI DATANG</b></td>     <td> : <input type=text size=10 name=tkolidatang  value='$r[tkolidatang]'
	   readonly=true> *	   	   
       <tr><td>Tanggal Datang</td>     <td> : <input type=text name=tgldatang size=10 value='$tglnya' readonly>";
  ?>
  <a href="javascript:showCal('Caritanggal')"><img src="images/calendar.png" border="0"></a>
  <?
  $kol=$r[totalkoli]-$r[tkolidatang];
  $brt=$r[totalberat]-$r[tberatdatang];
  echo "
  <tr><td>Koli Datang</td>     <td> : <input type=text size=10 name=kolidatang value=$kol onkeypress=\"return isNumberKey(event)\">
  <tr><td>Berat Datang</td>     <td> : <input type=text size=10 name=beratdatang value=$brt onkeypress=\"return isNumberKey(event)\">
<input type=hidden name=i value='$_GET[i]'><input type=hidden name=n value='$_GET[n]'></td></tr>
	<tr><td colspan=2><strong><center>*) Readonly - Tidak perlu diisi (otomatis)</center></strong></td></tr>

	<tr><td colspan=2><input type=submit value='Simpan'>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table><span class=error>$err</span>
        </td><td>";

  $p      = new Paging;
  $batas  = 10;
  $posisi = $p->cariPosisi($batas);

  $no     = $posisi+1;
  
$tampil2=mysql_query("SELECT * FROM breakdown where isvoid='0' AND id_isimanifestin='$_GET[n]' order by tgldatang DESC limit $posisi,$batas");
$tampil3=mysql_query("SELECT * FROM breakdown where isvoid='0' AND id_isimanifestin='$_GET[n]' order by tgldatang DESC");

echo "<CENTER><b>== SPLIT SMU import ==</b></CENTER> 
		<table>
    <tr><th>no</th><th>Tgl Datang</th><th>Berat Datang</th><th>Koli Datang</th><th>Status</th><th>BAYAR</th><th>ACTION</th></tr>";
 		while ($r=mysql_fetch_array($tampil2)){
     echo "<tr><td align=center>$no</td>
          <td align=center>".ymd2dmy($r[tgldatang])."</td><td align=center>$r[beratdatang]</td><td align=center>$r[kolidatang]</td><td align=center>$r[status_ambil]</td><td align=center>$r[status_bayar]</td><td align=center> ";
					if(($r[status_ambil]=='INSTORE') AND ($r[status_bayar]=='no'))
					{ 
					echo " 
					<a href=aksi.php?module=breakdown&act=hapus&id=$r[id_breakdown]&i=$_GET[i]&n=$_GET[n] title='klik untuk menghapus' onclick=\"javascript:return confirm('Penghapusan data masih diperbolehkan dan tidak direkam, selama status barang masih INSTORE dan BELUM TERBAYAR. Anda tidak dapat menghapus data jika hanya terdapat sebuah data kedatangan per SMU. Apakah Anda yakin akan menghapus data kedatangan split SMU ini ?')\">Hapus</a> ";
					}
					else
					{echo "Hapus";}
					echo " 
					</td></tr>";
     $no++;
  }
  echo "</table>";
 ;

	$jmldata      = mysql_num_rows($tampil3);
  $jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
  $linkHalaman  = $p->navHalaman($_GET[h], $jmlhalaman,'');


	echo "$linkHalaman";
	echo "<BR><BR>Status <B>\"INSTORE\"</B> berarti barang belum ada di diambil atau belum masuk buildup</B>.</td></tr>
	</table></form>
	
				</td></tr>
        
				</form>";


?>