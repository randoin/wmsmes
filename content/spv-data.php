<?php
$tgl=date("Y-m-d");

  $no     = $posisi+1;
    echo "<h2>Releasing import Data</h2>
        <form name=form1 method=POST action=?module=data>
        <table>
        <tr><td>Cari</td>     <td> : <input type=text size=30 name=cari>		
		<input type=hidden name=carii value=1>
	    <tr><td colspan=2><input type=submit value=CARI DATA>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";
		
if(($_POST[carii]=='1') AND ($_POST[cari]<>''))
{

$tampil1=mysql_query("SELECT * FROM deliverybill,breakdown where 
deliverybill.idbreakdown=breakdown.id_breakdown  
AND (deliverybill.nosmu like '%$_POST[cari]%' OR deliverybill.nodb like '%$_POST[cari]%') 
ORDER BY id_deliverybill DESC");

if($r=mysql_fetch_array($tampil1))
{
$tampil=mysql_query("SELECT * FROM deliverybill,breakdown where 
deliverybill.idbreakdown=breakdown.id_breakdown  
AND (deliverybill.nosmu like '%$_POST[cari]%' OR deliverybill.nodb like '%$_POST[cari]%') 
ORDER BY id_deliverybill DESC");
$a='1';
}
else
{
$tampil=mysql_query("SELECT * FROM breakdown,isimanifestin where 
isimanifestin.id_isimanifestin=breakdown.id_isimanifestin  
AND isimanifestin.no_smu like '%$_POST[cari]%' ORDER BY isimanifestin.no_smu DESC");
$a='2';
}




echo "<table>        
<tr><th>no</th><th>No. SMU</th><th>No. DB</th><th>Berat Bayar</th><th>Jml Bayar</th><th>Cara Bayar</th><th>CONFIRM</th><th>OUT</th><th>PAID</th></tr>";



  while ($r=mysql_fetch_array($tampil)){
$total=round(($r[document]+$r[overtime]+$r[lain]-$r[diskon])/10)*10;
$tgl=ymd2dmy($r[tglbayar]);
$formattotal=number_format($total, 0, '.', '.');   
$formatberatbayar=number_format($r[beratbayar], 0, '.', '.');   
$nodb='DBI-'.$r[nodb];

if(deliverybill.isvoid=='1')
{

     echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\"><td>$no</td><td align='center'>$r[no_smubtb]</td><td align='center'>$nodb</td><td align='center'>$formatberatbayar</td><td>Rp. $formattotal</td><td align='center'>$r[id_carabayar]</td><td>$r[status_check]</td><td>$r[status_ambil]</td><td>$r[status_bayar]</td></tr>";}
else
{
 if($a=='1')
 {

     echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\"><td>$no</td><td align='center'>$r[no_smubtb]</td><td align='center'>$nodb</td><td align='center'>$formatberatbayar</td><td>Rp. $formattotal</td><td align='center'>$r[id_carabayar]</td><td>$r[status_check] <a href=\"aksi.php?module=release_confirm&b=$r[idbreakdown]\">[waiting]</td><td>$r[status_ambil]  <a href=\"aksi.php?module=release_ambil&b=$r[idbreakdown]\">[release]</td><td>$r[status_bayar]</td></tr>";
	}
	else
	{
	     echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\"><td>$no</td><td align='center'>$r[no_smu]</td><td align='center'>$nodb</td><td align='center'>$formatberatbayar</td><td>Rp. $formattotal</td><td align='center'>$r[id_carabayar]</td><td>$r[status_check] <a href=\"aksi.php?module=release_confirm&b=$r[id_breakdown]\">[waiting]</td><td>$r[status_ambil]  <a href=\"aksi.php?module=release_ambil&b=$r[id_breakdown]\">[release]</td><td>$r[status_bayar]</td></tr>";
	}
	 
	 
	 }

     $no++;
  }
/*keluar 
$tampil1=mysql_query("SELECT * FROM deliverybill,out_dtbarang_h where deliverybill.no_smubtb=out_dtbarang_h.btb_nobtb AND (deliverybill.no_smubtb like '%$_POST[cari]%' OR deliverybill.nosmu like '%$_POST[cari]%' OR deliverybill.nodb like '%$_POST[cari]%') ORDER BY deliverybill.id_deliverybill DESC");  
while ($r=mysql_fetch_array($tampil1)){
$total=round(($r[document]+$r[overtime]+$r[lain]-$r[diskon])/10)*10;
$tgl=ymd2dmy($r[tglbayar]);
$formattotal=number_format($total, 0, '.', '.');   
$formatberatbayar=number_format($r[btb_totalberatbayar], 1, '.', '.');   
$nodb='DBO-'.$r[nodb];

if(deliverybill.isvoid=='1')
{

     echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\"><td>$no</td><td align='center'>$r[no_smubtb]</td><td align='center'>$nodb</td><td align='center'>$formatberatbayar</td><td>Rp. $formattotal</td><td align='center'>$r[id_carabayar]</td><td></td><td>$r[status_keluar]</td><td>$r[status_bayar]</td></tr>";}
else
{

     echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\"><td>$no</td><td align='center'>$r[no_smubtb]</td><td align='center'>$nodb</td><td align='center'>$formatberatbayar</td><td>Rp. $formattotal</td><td align='center'>$r[id_carabayar]</td><td></td><td>$r[status_keluar] <a href=\"?module=voiddb&n=$nodb&i=$r[no_smubtb]&s=0&b=$r[idbreakdown]\" 
					onclick=\"javascript:return confirm('VOID hanya dapat dilakukan bila barang sudah terbayar tapi belum 
					keluar gudang. Proses VOID ini akan direkam beserta alasan VOID. 
					Apakah Anda yakin akan VOID barang ini ?')\">[release]</td><td>$r[status_bayar]</td></tr>";}

     $no++;
  }
 */ 
  echo "</table>";
  
}

?>