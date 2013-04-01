<?php
$tgl=date("Y-m-d");

mysql_query("UPDATE manifestout SET status='checked' WHERE id_manifestout='$_GET[i]'");
mysql_query("UPDATE buildup set status_keluar='OUT',tglkeluar='$tgl' where id_manifestout='$_GET[i]'");
mysql_query("UPDATE out_dtbarang_h,buildup set out_dtbarang_h.status_keluar='OUT' where buildup.id_manifestout='$_GET[i]' AND buildup.nosmu=out_dtbarang_h.btb_smu");

mysql_query("UPDATE breakdown,isimanifestin,buildup set breakdown.status_ambil='OUT', tglambil='$tgl' where buildup.id_manifestout='$_GET[i]' AND  buildup.nosmu=isimanifestin.no_smu AND 
isimanifestin.id_isimanifestin=breakdown.id_isimanifestin");
  header('location:media.php?module=manifestout');
?>