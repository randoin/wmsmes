<?php
	$tgl=tgl_indo(date("Y m d"));
  	$jam=date("H:i:s");
  	echo "<h2>Selamat Datang $_SESSION[namauser], Tgl Server : $tgl  $jam</h2>";
  	$berita=mysql_fetch_array(mysql_query("select i.*,u.nama_lengkap from informasi as i, user as u where i.user=u.id_user order by i.id DESC limit 1"));
    $tgl=tgl_indo($berita['tgl']);
  	$jam=date("H:i:s");
  	echo "<div id=informasi><i>by $berita[nama_lengkap] $tgl $jam</i><BR><BR><strong>$berita[judul]</strong><BR>$berita[isi]
  </div>";
?>