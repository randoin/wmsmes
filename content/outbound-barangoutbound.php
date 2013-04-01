<?php
		$tampil=mysql_query("SELECT * FROM smu where id_smu='$_GET[id]'");
  		$w=mysql_fetch_array($tampil);
if($w[statusbayar]=='0'){
  echo "<h2>No SMU : $w[nosmu]</h2>
        <form method=POST action='?act=tambahbarangoutbound'>
		<input type=hidden value='$w[nosmu]' name=nosmu><input type=hidden value='$w[id_smu]' name=idsmu>
        <input type=submit value='Tambah Barang'>
        </form>";} 
        echo "<table>
        <tr><th>no</th><th>Penjelasan</th><th>Koli</th><th>KG</th></tr>";
  $tampil=mysql_query("SELECT * from barangoutbound where id_smu='$w[id_smu]'");
  $no=1;
  while ($r=mysql_fetch_array($tampil)){
     echo "<tr><td>$no</td>
          <td>$r[penjelasan]</td><td>$r[koli]</td><td>$r[kg]</td>
         </tr>";
     $no++;
  }
  echo "</table>";

?>