<?php
if(!empty($_POST[keterangan]))
{
$str=mysql_query("SELECT * FROM manifestout where id_manifestout='$_POST[i]'");
$r=mysql_fetch_array($str);
mysql_query("$_POST[i] INSERT INTO manifestout (airline,noflight,user,tglmanifest,acregistration,
isvoid,voidby,keterangan,status) VALUES ('$r[airline]','$r[noflight]','$r[user]','$r[tglmanifest]','$r[acregistration]',
'1','$_SESSION[namauser]','$_POST[keterangan]','checked')");
mysql_query("UPDATE manifestout SET status='waiting' WHERE id_manifestout='$_POST[i]'");
mysql_query("UPDATE buildup set status_keluar='INSTORE',tglkeluar='' where id_manifestout='$_POST[i]'");
mysql_query("UPDATE out_dtbarang_h,buildup set out_dtbarang_h.status_keluar='INSTORE' where buildup.id_manifestout='$_POST[i]' AND buildup.nosmu=out_dtbarang_h.btb_smu");

mysql_query("UPDATE breakdown,isimanifestin,buildup set breakdown.status_ambil='INSTORE', tglambil='$tgl' where buildup.id_manifestout='$_POST[i]' AND  buildup.nosmu=isimanifestin.no_smu AND 
isimanifestin.id_isimanifestin=breakdown.id_isimanifestin");

  header('location:media.php?module=manifestout');
}
else
header('location:media.php?module=manifestout');
?>