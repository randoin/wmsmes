<?php
  echo "<h2>Modul</h2>
        <form method=POST action='?act=tambahmodul'>
        <input type=submit value='Tambah Modul'>
        </form>
        <table>
        <tr><th>no</th><th>nama modul</th><th>link</th>
        <th>publish</th><th>aktif</th><th>status</th><th>aksi</th></th></tr>";
  $tampil=mysql_query("SELECT * FROM modul ORDER BY urutan");
  while ($r=mysql_fetch_array($tampil)){
    echo "<tr><td>$r[urutan]</td>
          <td>$r[nama_modul]</td>
          <td><a href=$r[link]>$r[link]</a></td>
          <td align=center>$r[publish]</td>
          <td align=center>$r[aktif]</td>
          <td align=center>$r[status]</td>
          <td><a href=?act=editmodul&id=$r[id_modul]>Edit</a> | 
	            <a href=aksi.php?module=modul&act=hapus&id=$r[id_modul]>Hapus</a>
          </td></tr>";
  }
  echo "</table>";
?>