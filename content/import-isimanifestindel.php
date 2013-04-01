<?php
$tampil=mysql_query("select * from isimanifestin where id_isimanifestin='$_GET[n]'");
$r=mysql_fetch_array($tampil);
echo "<h2>Cancel  No. SMU : $r[no_smu]</h2>
	<form name=form1 method=POST action=aksi.php?module=isimanifestin&act=cancel>
  <table>
	<tr><td>Keterangan</td><td> : <input type=text name=keterangan_void size=60 
	autocomplete=off></td></tr>
	</td></tr>
	<tr><td colspan=2><input type=submit value='SIMPAN'>
  <input type=button value=Batal onclick=self.history.back()>
	<input type=hidden name=n value='$r[id_isimanifestin]'>
	<input type=hidden name=i value='$_GET[i]'>
	<input type=hidden name=b value='$_GET[b]'>		
	<input type=hidden name=nosmu value='$r[no_smu]'>		
	</td></tr>
  </table>
  </form>";

?>