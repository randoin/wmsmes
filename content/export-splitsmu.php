<?php
 ?>
  <SCRIPT LANGUAGE="JavaScript" src="cal2.js">
  </script>
  <script language="javascript">
    addCalendar("Caritanggal","Tanggal","tgldatang","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
  </script>
  <?
 $tampil=mysql_query("select *, SUM(beratdatang) AS tberatdatang, SUM(kolidatang) AS tkolidatang from isimanifestout,breakdown where isimanifestout.id_isimanifestout=breakdown.id_isimanifestout AND isimanifestout.id_isimanifestout='$_GET[n]' GROUP BY isimanifestout.id_isimanifestout");
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
  <tr><td>Koli Datang</td>     <td> : <input type=text size=10 name=kolidatang value=$kol>
  <tr><td>Berat Datang</td>     <td> : <input type=text size=10 name=beratdatang value=$brt>
<input type=hidden name=i value='$_GET[i]'><input type=hidden name=n value='$_GET[n]'></td></tr>
	<tr><td colspan=2><strong><center>*) Readonly - Otomatis terisi</center></strong></td></tr>

	<tr><td colspan=2><input type=submit value='Simpan'>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table><span class=error>$err</span>
        </td><td>";

  $p      = new Paging;
  $batas  = 10;
  $posisi = $p->cariPosisi($batas);

  $no     = $posisi+1;
  
$tampil2=mysql_query("SELECT * FROM breakdown where isvoid='0' AND id_isimanifestout='$_GET[n]' order by tgldatang DESC limit $posisi,$batas");
$tampil3=mysql_query("SELECT * FROM breakdown where isvoid='0' AND id_isimanifestout='$_GET[n]' order by tgldatang DESC");

echo "<CENTER><b>== SPLIT SMU export ==</b></CENTER> 
		<table>
    <tr><th>no</th><th>Tgl Datang</th><th>Berat Datang</th><th>Koli Datang</th><th>Status</th><th>ACTION</th></tr>";
 		while ($r=mysql_fetch_array($tampil2)){
     echo "<tr><td align=center>$no</td>
          <td align=center>".ymd2dmy($r[tgldatang])."</td><td align=center>$r[beratdatang]</td><td align=center>$r[kolidatang]</td><td align=center>$r[status_ambil]</td><td align=center> ";
					if($r[status_ambil]=='INSTORE')
					{ 
					echo " 
					<a href=aksi.php?module=breakdown&act=hapus&id=$r[id_breakdown]&i=$_GET[i]&n=$_GET[n] title='klik untuk menghapus'>Hapus</a> ";
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