<?php
if($_POST[i]=='') //i digunakan untuk menyimpan id manifest
{$i=$_GET[i];} 
else {$i=$_POST[i];}

$dataman=mysql_query("SELECT * from manifestin where id_manifestin='$i'"); 
$r=mysql_fetch_array($dataman);
$tgl=ymd2dmy($r[tglmanifest]);
$tgl1=my2date($_POST[cari]);

$p      = new Paging;
$batas  = 50;
$posisi = $p->cariPosisi($batas);
$no     = $posisi+1;

//hitung jumlah total berat datang dan koli datang dalam sebuah manifest
$a=mysql_query("SELECT SUM(beratdatang),SUM(kolidatang) 
	FROM breakdown,isimanifestin where 
	breakdown.id_isimanifestin=isimanifestin.id_isimanifestin
	AND breakdown.id_manifestin='$i'  
	AND breakdown.isvoid='0'");	
$instok=mysql_fetch_array($a);	
	
if($_POST[carii]=='1')
{
	$tampill=mysql_query("SELECT * FROM breakdown,isimanifestin where 
	breakdown.id_isimanifestin = isimanifestin.id_isimanifestin AND	
	breakdown.id_manifestin='$i' and breakdown.isvoid='0' AND isimanifestin.no_smu like	
	'%$_POST[cari]%' ORDER BY id_breakdown DESC");
}
else
{
	$tampill=mysql_query("SELECT * FROM breakdown,isimanifestin where	
	breakdown.id_isimanifestin = isimanifestin.id_isimanifestin AND	
	breakdown.id_manifestin='$i' and breakdown.isvoid='0' ORDER BY id_breakdown DESC");
}
$tglnya=date("d-m-Y");

echo "<h2>Isi Cargo Manifest => $r[airline] : A/C Reg.$r[acregistration] 
			Flight No.$r[noflight] / $tgl | $instok[0] Kg / $instok[1] Koli</h2>
      <form name=form1 method=POST action=?module=barangdatang>
      <table>
      <tr><td>Cari No.SMU</td><td> : <input type=text size=30 name=cari onKeyDown=\"javascript:return dFilter (event.keyCode, this, '###-#### ### #');\">
			<input type=hidden name=carii value=1><input type=hidden name=i value='$i'>
			<input type=submit value=CARI DATA>
      <input type=button value=Batal onclick=self.history.back()>
			</table></form>";
			if($r[nil]<>'on'){ echo "<a href='?module=manifestininput&act=input&idman=$_GET[i]&i=$_GET[i]&airline=$r[airline]'<img src=images/joined_lg.gif border=0 alt=\"menambah data\" title=\"menambah data\"></a><BR>";}
			else { echo "NUL MANIFEST !";}

echo "<table>
        <tr>
					<th align=center>no</th>
					<th align=center>No. SMU</th>
					<th align=center width=30>KOLI </th>
					<th align=center width=30>BERAT AKT</th>
					<th align=center width=30>KOLI DTG</th>	
					<th align=center width=30>BERAT DTG</th>			
					<th align=center width=30>BERAT BAYAR</th>
					<th align=center width=100>KOMODITI</th>
					<th align=center width=30>AGENT</th>	
					<th align=center width=30>ASAL</th>			
					<th align=center width=30>TUJUAN</th>
					<th align=center>STATUS</th><th>Action</th>
				</tr>";

  while ($r=mysql_fetch_array($tampill))
	{
  $tglnya=ymd2dmy($r[tgl]);

	//untuk status SMU, sudah di cek untuk CONFIRM atau belum Waiting
	if($r[status_check]=='waiting')
	{$cl='red';}else{$cl='green';}
	
	//untuk membedakan warna status CANCEL
	if($r[b_iscancel]=='1'){$st='cancel';$cl='yellow';}else {$st=$r[status_check];}
	
echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		 <td align=center>$no</td>
		 <td align=center>$r[no_smu]</td>
		 <td align=center>$r[totalkoli]</td>		 
		 <td align=center>$r[totalberat]</td>
		 <td align=center>$r[kolidatang]</td>
		 <td align=center>$r[beratdatang]</td>
		 <td align=center>$r[beratbayar]</td>		
		 <td align=left>$r[jenisbarang]</td>
		 <td align=center>$r[agent]</td>
		 <td align=center>$r[asal]</td>
		 <td align=center>$r[tujuan]</td>				  
		 <td align=center><font color=$cl>$st</font></td>";
				  
//jika status SMU masih WAITING 
if(($r[status_check]=='waiting') AND ($r[b_iscancel]=='0'))
	{
		echo "<td align=center>
		<a href=?module=isimanifestindel&n=$r[id_isimanifestin]&b=$r[id_breakdown]&i=$i title='klik untuk cancel SMU' onclick=\"javascript:return confirm('CANCEL hanya dilakukan pada SMU yang batal datang. Jika memang cancel, Anda harus melengkapi alasannya setelah ini.CANCEL hanya bisa dilakukan pada data SMU yang masih berstatus WAITING. Apakah Anda yakin data SMU ini dibatalkan ?')\"><img src=images/b_drop.png border=0 hspace=5></a>
		<a href=?module=breakdownedit&n=$r[id_isimanifestin]&b=$r[id_breakdown]&i=$i title='klik untuk update data sesuai dgn SMU datang' onclick=\"javascript:return confirm('Editing hanya dilakukan untuk SMU yang datanya	tidak sesuai dengan data MANIFEST INPUT. Apakah Anda yakin akan mengedit data sesuai SMU ?')\"><img src=images/b_edit.png border=0 hspace=5></a>
		<a href=aksi.php?module=manifestin&act=smuchecked&i=$_GET[i]&b=$r[id_breakdown] 		 title='klik untuk confirm barang datang' onclick=\"javascript:return confirm('Status CONFIRM berarti melakukan konfirmasi bahwa cargo untuk No.SMU ini telah tiba dan di verifikasi/cek. SMU ini tidak dapat dihapus atau diedit setelah CONFIRM. Apakah Anda yakin ? ')\"><img src=images/b_usrcheck.png border=0 hspace=5></a>";
	}
		else {echo"<td></td>";}

	echo" </tr>";
  $no++;
}
  echo "</table>";

?>