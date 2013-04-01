<?php
$tgl=date("Y-m-d");
$tgl1=my2date($_POST[tgl]);
if($_POST[s]=='1')
  {
  mysql_query("UPDATE deliverybill set isvoid='1',tglvoid='$tgl',voidby='$_SESSION[namauser]',
	keterangan='$_POST[keterangan]',document='0',storage='0',lain='0',overtime='0',hari='0',diskon='0'
	 where no_smubtb='$_POST[i]' AND status='1'");
  mysql_query("UPDATE out_dtbarang_h set status_bayar='no' where btb_nobtb='$_POST[i]'");
 header('location:media.php?module=dboutgoing');
  }
  else if($_POST[s]=='0')
  {
   mysql_query("UPDATE deliverybill set isvoid='1',tglvoid='$tgl',voidby='$_SESSION[namauser]',keterangan='$_POST[keterangan]',
	 keterangan='$_POST[keterangan]',document='0',storage='0',lain='0',overtime='0',hari='0',diskon='0' 
	  where nosmu='$_POST[i]' AND status='0' AND idbreakdown='$_POST[b]'");
  mysql_query("UPDATE breakdown set status_bayar='no' where id_breakdown='$_POST[b]'");
 header('location:media.php?module=dbincoming');
  }
?>