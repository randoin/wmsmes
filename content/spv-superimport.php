<?php
$tgl=date("Y-m-d");
  $p      = new Paging;
  $batas  = 10;
  $posisi = $p->cariPosisi($batas);

  
  $no     = $posisi+1;

if($_POST[carii]=='1')
{
$tampil=mysql_query("SELECT * FROM deliverybill,in_dtbarang_h where deliverybill.no_smubtb=in_dtbarang_h.no_smu AND tglbayar =  '$tgl' AND (deliverybill.no_smubtb like '%$_POST[cari]%' OR deliverybill.id_deliverybill like '%$_POST[cari]%' OR in_dtbarang_h.agent like '%$_POST[cari]%')ORDER BY deliverybill.id_deliverybill DESC limit $posisi,$batas");

$tampil1=mysql_query("SELECT * FROM deliverybill,in_dtbarang_h where deliverybill.no_smubtb=in_dtbarang_h.no_smu AND tglbayar =  '$tgl' AND (deliverybill.no_smubtb like '%$_POST[cari]%' OR deliverybill.id_deliverybill like '%$_POST[cari]%' OR in_dtbarang_h.agent like '%$_POST[cari]%')ORDER BY deliverybill.id_deliverybill DESC");

}
else
{
$tampil=mysql_query("SELECT * FROM deliverybill,in_dtbarang_h where deliverybill.no_smubtb=in_dtbarang_h.no_smu AND tglbayar =  '$tgl' ORDER BY id_deliverybill DESC limit $posisi,$batas");
$tampil1=mysql_query("SELECT * FROM deliverybill,in_dtbarang_h where deliverybill.no_smubtb=in_dtbarang_h.no_smu AND tglbayar =  '$tgl' ORDER BY id_deliverybill DESC");
}

    echo "<h2>Data Transaksi import </h2>
  <a href=aksi.php?module=cetaklap&i=1 target=_blank><img src=images/printer.jpg border=0></a>

       <form name=form1 method=POST action=?module=superexport>
        <table>
        <tr><td>Cari</td>     <td> : <input type=text size=30 name=cari>		
		<input type=hidden name=carii value=1>
	    <tr><td colspan=2><input type=submit value=CARI DATA>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";
		
echo "<table>         <tr><th>no</th><th>No. BTB</th><th>TOTAL BAYAR</th><th>Tgl Bayar</th><th>No. DB</th>
<th>STATUS</th><th>Tgl Void</th><th>Operator</th><th>Keterangan</th></tr>";


  while ($r=mysql_fetch_array($tampil)){
  if($r[isVoid]=='1'){$v='VOID';}else {$v='-';}
$total=$r[document]+$r[overtime]+$r[lain]+$r[storage];
$tgl=ymd2dmy($r[tglbayar]);
//if($r[id_carabayar]=='1'){$stb='CASH';}else{$stb='PERIODICAL';}
$formatdokumen=number_format($r[document], 0, '.', '.');   
$formatstorage=number_format($r[storage], 0, '.', '.');   
$formatlain=number_format($r[lain], 0, '.', '.');   
$formattotal=number_format($total, 0, '.', '.');   
if($r[id_deliverybill]<10){$nodb='I000000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10 AND $r[id_deliverybill]<100){$nodb='I00000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100 AND $r[id_deliverybill]<1000){$nodb='I0000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000 AND $r[id_deliverybill]<10000){$nodb='I000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10000 AND $r[id_deliverybill]<100000){$nodb='I00'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100000 AND $r[id_deliverybill]<1000000){$nodb='I0'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000000 AND $r[id_deliverybill]<10000000){$nodb='I'.$r[id_deliverybill];}
     echo "<tr><td>$no</td>
          <td>$r[no_smubtb]</td><td>Rp. $formattotal</td><td>$tgl</td><td>$nodb</td><td>$v</td>
					<td>$v</td><td>$v</td><td>$r[keterangan]</td>
         </tr>";
     $no++;
  }
  echo "</table>";
  $jmldata      = mysql_num_rows($tampil1);
  $jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
  $linkHalaman  = $p->navHalaman($_GET[h], $jmlhalaman,'0');

  echo "<p>$linkHalaman</p>";
  
 
 

?>