<?php
$tgl=date("Y-m-d");
  if($_POST[id]=='1'){//outgoing
  mysql_query("INSERT INTO deliverybill(no_smubtb,document,storage,id_carabayar,lain,tglbayar,user,overtime,hari,status,diskon,keterangan,nosmu)
  VALUES('$_POST[nosmubtb]','$_POST[document1]','$_POST[storage1]','$_POST[id_carabayar]',
  '$_POST[ppn1]','$tgl','$_SESSION[namauser]','$_POST[overtime1]','$_POST[hari]','1',
	'$_POST[afterdiskon]','$_POST[keterangan]','$_POST[nosmu]')");
  
	mysql_query("UPDATE out_dtbarang_h set status_bayar='yes',btb_smu='$_POST[nosmu]' where btb_nobtb='$_POST[nosmubtb]'");}
    else { //incoming
mysql_query("INSERT INTO deliverybill(no_smubtb,document,storage,id_carabayar,lain,tglbayar,user,overtime,hari,status,idbreakdown,nosmu,
diskon,keterangan)
 VALUES('$_POST[nosmubtb]','$_POST[document1]','$_POST[storage1]','$_POST[id_carabayar]',
	'$_POST[ppn1]','$tgl','$_SESSION[namauser]','$_POST[overtime1]','$_POST[hari]','0',
	'$_POST[id_breakdown]','$_POST[nosmu]','$_POST[afterdiskon]','$_POST[keterangan]')");
    mysql_query("UPDATE isimanifestin set penerima='$_POST[penerima]',alamatpenerima='$_POST[penerima]' where no_smu='$_POST[nosmubtb]'");
		    mysql_query("UPDATE breakdown set status_bayar='yes' where id_breakdown='$_POST[id_breakdown]'");
				}


    $t=mysql_query("select * from deliverybill order by id_deliverybill DESC limit 1");
		$r=mysql_fetch_array($t);


  header('location:media.php?module=cetakdb&n='.$r[id_deliverybill]);
?>