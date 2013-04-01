<?php
		$tampil=mysql_query("SELECT * FROM manifest where id_manifest='$_GET[id]'");
  		$w=mysql_fetch_array($tampil);
		
 	echo "<h2>A/C Registration : $w[acregistration]</h2>
        <form method=POST action='?act=tambahbuildup'>
		<input type=hidden value='$w[nosmu]' name=nosmu><input type=hidden value='$w[id_smu]' name=idsmu><input type=hidden value='$w[id_manifest]' name=id_manifest>
        <input type=submit value='Tambah Barang'>
        </form>";
        echo "<table>
        <tr><th>no</th><th>No.ULD</th><th>No. SMU</th><th>Berat(KG)</th><th>Komoditi</th><th>Tujuan</th></tr>";
  $tampil=mysql_query("SELECT * from buildup where id_manifest='$w[id_manifest]'");
  $no=1;
  while ($r=mysql_fetch_array($tampil)){
     echo "<tr><td>$no</td>
          <td>$r[nould]</td><td>$r[nosmu]</td><td>$r[kg]</td><td>$r[kode]</td><td>$r[kodekomoditi]</td>
         </tr>";
     $no++;
  }
  echo "</table>";

?>