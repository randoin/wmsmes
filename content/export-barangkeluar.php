<?php

	if($_POST[i]==''){$i=$_GET[i];} else {$i=$_POST[i];}
	$dataman=mysql_query("SELECT * from manifestout where id_manifestout='$i'"); 
	$r=mysql_fetch_array($dataman);
$tgl=ymd2dmy($r[tglmanifest]);
	
$tgl1=my2date($_POST[cari]);
  $p      = new Paging;
  $batas  = 10;
  $posisi = $p->cariPosisi($batas);


  $no     = $posisi+1;
if($_POST[carii]=='1')
{
$tampil=mysql_query("select *, SUM(beratdatang) AS tberatdatang, SUM(kolidatang) AS tkolidatang from isimanifestout,breakdown 
where isimanifestout.id_isimanifestout=breakdown.id_isimanifestout AND isimanifestout.id_manifestout='$i' 
AND isimanifestout.no_smu like '%$_POST[cari]%' AND isimanifestout.isvoid='0' GROUP BY isimanifestout.id_isimanifestout 
order by isimanifestout.id_isimanifestout DESC limit $posisi,$batas");

$tampill=mysql_query("select *, SUM(beratdatang) AS tberatdatang, SUM(kolidatang) AS tkolidatang from isimanifestout,breakdown where isimanifestout.id_isimanifestout=breakdown.id_isimanifestout AND isimanifestout.id_manifestout='$i' 
AND isimanifestout.no_smu like '%$_POST[cari]%' AND isimanifestout.isvoid='0' GROUP BY isimanifestout.id_isimanifestout order by isimanifestout.id_isimanifestout DESC");
}
else
{
$tampil=mysql_query("select * FROM buildup where id_manifestout='$_GET[i]'  
order by nould ASC limit $posisi,$batas");
$tampill=mysql_query("select * FROM buildup where id_manifestout='$_GET[i]'  
order by nould ASC");

}



$tglnya=date("d-m-Y");
    echo "<h2>Isi Cargo Manifest => $r[airline] : A/C Reg.$r[acregistration] Flight No.$r[noflight] / $tgl </h2>
       <form name=form1 method=POST action=?module=barangdatang>
        <table>
        <tr><td>Cari No.SMU</td>     <td> : <input type=text size=30 name=cari>
		<input type=hidden name=carii value=1><input type=hidden name=i value='$i'><input type=submit value=CARI DATA>
        <input type=button value=Batal onclick=self.history.back()>

        </table>
        </form>";

echo "<table>
        <tr><th align=center>no</th><th align=center>No. ULD</th><th align=center>No. SMU</th><th align=center>Berat(Kg)</th><th align=center>Koli</th><th>Jenis Barang</th><th>Asal</th><th>Tujuan</th><th>Action</th></tr>";

  while ($r=mysql_fetch_array($tampil)){
  $tglnya=ymd2dmy($r[tgl]);
     echo "<tr><td align=center>$no</td>
          <td align=center>$r[nould]<td align=center>$r[nosmu]</td><td align=center>$r[berat]</td>
		  <td align=center>$r[koli]</td><td>$r[jenisbarang]</td><td align=center>$r[asal]</td>
		  <td align=center>$r[tujuan]</td>";
				  if($r[status_bayar]=='no')
		  {
		  echo "<td align=center>
			<a href=?module=isimanifestoutdel&n=$r[id_isimanifestout]&i=$i  
		  title='klik untuk menghapus SMU'>CANCEL</a> | ";
			
						  if($r[status_update]=='no')
		  				{
		  				echo "<a href=?module=breakdownedit&n=$r[id_isimanifestout]&i=$i 
							title='klik untuk update data sesuai dgn SMU datang'>Edit</a> | Split SMU";}
							else {echo "Edit | <a href=?module=splitsmu&n=$r[id_isimanifestout]&i=$i 
							title='Jika barang datang tidak sejumlah SMU'>Split SMU</a></td>";}
			
			
			}
	else {echo "<td align=center>CANCEL | Edit | <a href=?module=splitsmu&n=$r[id_isimanifestout]&i=$i 
							title='Jika barang datang tidak sejumlah SMU'>Split SMU</a> ";}
		echo" </tr>";
     $no++;
  }
  echo "</table>";
   $jmldata      = mysql_num_rows($tampill);
  $jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
  $linkHalaman  = $p->navHalaman($_GET[h], $jmlhalaman,'i='.$_GET[i]);

  echo "<p>$linkHalaman</p>";



?>