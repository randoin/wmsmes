<?php
  echo "<h2>Cargo Manifest - Outbound</h2>
        <form method=POST action='?act=tambahmanifestout'>
        <input type=submit value='Tambah Manifest'>
        </form>
        <table>
        <tr><th>no</th><th>Date</th><th>Operator</th><th>Flight No</th><th>A/C Registration</th></tr>";
  $tampil=mysql_query("SELECT * from manifest,operatorairline where 
  manifest.id_operatorairline=operatorairline.id_operatorairline order by etd DESC");
  $no=1;
  while ($r=mysql_fetch_array($tampil)){
  $tglnya=ymd2dmy($r[etd]);
     echo "<tr><td>$no</a></td>
          <td>$tglnya</td><td>$r[operatorairline]</td><td>$r[noflight]</td><td><a href=?act=buildup&id=$r[id_manifest]>$r[acregistration]</a></td></tr>";
     $no++;
  }
  echo "</table>";

?>