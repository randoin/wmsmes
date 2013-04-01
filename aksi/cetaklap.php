<?php
if($_GET[i]=='1'){
$tgl=date("Y-m-d");$tgl1=ymd2dmy($tgl);

  echo "<link href='config/printstyle.css' rel='stylesheet' type='text/css'>";
  echo "<h2>Laporan Sewa CARGO INTERNATIONAL - CASH OUTGOING</h2>";
  echo "<h3>Tanggal $tgl1</h3>";
  
$tampil=mysql_query("SELECT * FROM deliverybill,out_dtbarang_h where deliverybill.no_smubtb=out_dtbarang_h.btb_nobtb AND tglbayar =  '$tgl' AND id_carabayar='1' AND deliverybill.isVoid='0' ORDER BY id_deliverybill DESC");
$no=1;
echo "<table border=1>         <tr><th>NO</th><th>No. BTB</th><th>No. SMU</th><th>Agent</th><th>No. DB</th><th>Berat (KG)</th><th>Hari</th><th>Admin (Rp.)</th><th>Sewa (Rp.)</th><th>PPn (Rp.)</th><th>TOTAL (Rp.)</th></tr>";

$fdokumen=0;
$fstorage=0;
$flain=0;
$ftotal=0;
  while ($r=mysql_fetch_array($tampil)){
$total=$r[document]+$r[overtime]+$r[lain]+$r[storage];
$tgl=ymd2dmy($r[tglbayar]);
//if($r[id_carabayar]=='1'){$stb='CASH';}else{$stb='PERIODICAL';}
$formatdokumen=number_format($r[document], 0, '.', '.');   
$formatstorage=number_format($r[storage], 0, '.', '.');   
$formatlain=number_format($r[lain], 0, '.', '.');   
$formattotal=number_format($total, 0, '.', '.');   
$fdokumen=$fdokumen+$r[document];
$fstorage=$fstorage+$r[storage];
$flain=$flain+$r[lain];
$ftotal=$ftotal+$total;
if($r[id_deliverybill]<10){$nodb='O000000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10 AND $r[id_deliverybill]<100){$nodb='O00000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100 AND $r[id_deliverybill]<1000){$nodb='O0000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000 AND $r[id_deliverybill]<10000){$nodb='O000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10000 AND $r[id_deliverybill]<100000){$nodb='O00'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100000 AND $r[id_deliverybill]<1000000){$nodb='O0'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000000 AND $r[id_deliverybill]<10000000){$nodb='O'.$r[id_deliverybill];}
     echo "<tr><td>$no</td>
          <td>$r[no_smubtb]</td><td>$r[btb_smu]</td><td>$r[btb_agent]</td><td>$nodb</td><td>$r[btb_totalberatbayar]</td><td>$r[hari]</td><td>$formatdokumen</td><td>$formatstorage</td><td>$formatlain</td><td> $formattotal</td>
         </tr>";
     $no++;
  }
  $fdokumen=number_format($fdokumen, 0, '.', '.');
$fstorage=number_format($fstorage, 0, '.', '.');
$flain=number_format($flain, 0, '.', '.');
$ftotal=number_format($ftotal, 0, '.', '.');
      echo "<tr><td colspan=6 align=right><B>TOTAL : </B></td><td><B>$fdokumen</B></td><td><B>$fstorage</B></td><td><B>$flain</B></td><td><B> $ftotal</B></td>
         </tr>";

  echo "</table>";
}
//2 itu utk INCOMING CASH
else if($_GET[i]=='2'){
$tgl=date("Y-m-d");$tgl1=ymd2dmy($tgl);

  echo "<link href='config/printstyle.css' rel='stylesheet' type='text/css'>";
  echo "<h2>Laporan Sewa CARGO INTERNATIONAL - CASH INCOMING</h2>";
  echo "<h3>Tanggal $tgl1</h3>";
  
$tampil=mysql_query("SELECT * FROM deliverybill,in_dtbarang_h where deliverybill.no_smubtb=in_dtbarang_h.no_smu AND tglbayar =  '$tgl' AND id_carabayar='1' AND deliverybill.isVoid='0' ORDER BY id_deliverybill DESC");
$no=1;
echo "<table border=1>         <tr><th>NO</th><th>No. BTB</th><th>Agent</th><th>No. DB</th><th>Berat (KG)</th><th>Hari</th><th>Admin (Rp.)</th><th>Sewa (Rp.)</th><th>PPn (Rp.)</th><th>TOTAL (Rp.)</th></tr>";

$fdokumen=0;
$fstorage=0;
$flain=0;
$ftotal=0;
  while ($r=mysql_fetch_array($tampil)){
$total=$r[document]+$r[overtime]+$r[lain]+$r[storage];
$tgl=ymd2dmy($r[tglbayar]);
//if($r[id_carabayar]=='1'){$stb='CASH';}else{$stb='PERIODICAL';}
$formatdokumen=number_format($r[document], 0, '.', '.');   
$formatstorage=number_format($r[storage], 0, '.', '.');   
$formatlain=number_format($r[lain], 0, '.', '.');   
$formattotal=number_format($total, 0, '.', '.');   
$fdokumen=$fdokumen+$r[document];
$fstorage=$fstorage+$r[storage];
$flain=$flain+$r[lain];
$ftotal=$ftotal+$total;
if($r[id_deliverybill]<10){$nodb='I000000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10 AND $r[id_deliverybill]<100){$nodb='I00000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100 AND $r[id_deliverybill]<1000){$nodb='I0000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000 AND $r[id_deliverybill]<10000){$nodb='I000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10000 AND $r[id_deliverybill]<100000){$nodb='I00'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100000 AND $r[id_deliverybill]<1000000){$nodb='I0'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000000 AND $r[id_deliverybill]<10000000){$nodb='I'.$r[id_deliverybill];}

     echo "<tr><td>$no</td>
          <td>$r[no_smubtb]</td><td></td><td>$nodb</td><td>$r[totalberat]</td><td>$r[hari]</td><td>$formatdokumen</td><td>$formatstorage</td><td>$formatlain</td><td> $formattotal</td>
         </tr>";
     $no++;
  }
  $fdokumen=number_format($fdokumen, 0, '.', '.');
$fstorage=number_format($fstorage, 0, '.', '.');
$flain=number_format($flain, 0, '.', '.');
$ftotal=number_format($ftotal, 0, '.', '.');
      echo "<tr><td colspan=6 align=right><B>TOTAL : </B></td><td><B>$fdokumen</B></td><td><B>$fstorage</B></td><td><B>$flain</B></td><td><B> $ftotal</B></td>
         </tr>";

  echo "</table>";
}
?>