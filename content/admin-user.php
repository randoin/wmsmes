<?php
  echo "<h2>MANAJEMEN USER ACCOUNT WMS</h2>
        <form method=POST action='?act=tambahuser'>
        <input type=submit value='Tambah User' class='tombol'>
        </form>
        <table>
        <tr><th>no</th><th>username</th><th>nama lengkap</th><th>nipp</th><th>user level</th>
		<th>no telpon</th><th>action</th></th></tr>";
	$p      = new Paging;
	$batas  = 100;
	$posisi = $p->cariPosisi($batas);
	$tampil=mysql_query("SELECT * FROM user WHERE id_user!='admin' ORDER BY level DESC limit $posisi,$batas");
    $no     = $posisi+1;
  while ($r=mysql_fetch_array($tampil)){
	echo "<tr><td>$no</td>
          <td>$r[id_user]</td>
          <td>$r[nama_lengkap]</td><td>$r[nipp]</td><td>$r[level]</td><td>$r[telpon]</td>
		      
          <td><a href=?act=edituser&id=$r[id_user]>EDIT</a> | 
	            <a href=aksi.php?module=user&act=hapus&id=$r[id_user]>HAPUS</a>
          </td></tr>";
     $no++;
  }
  echo "</table>";
	$jmldata      = mysql_num_rows(mysql_query("SELECT * FROM user WHERE id_user!='admin'"));
	$jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
	$linkHalaman  = $p->navHalaman($_GET['h'], $jmlhalaman,'');
	echo "<p>$linkHalaman</p>";

?>