<?php
  echo "<h2>Tambah Barang</h2>
        <form method=POST action='aksi.php?module=barangoutbound&act=input'>
        <table>
        <tr><td>Penjelasan</td>     <td> : <textarea name=penjelasan rows=3 cols=50></textarea></td></tr>						
        <tr><td>Koli</td>     <td> : <input type=text name=koli size=10></td></tr>				
        <tr><td>KG</td>     <td> : <input type=text name=kg size=10></td></tr>			   				
        <tr><td>No. SMU</td>     <td> : <input type=text name=nosmu size=50 value='$_POST[nosmu]' readonly=true>
		<input type=hidden name=idsmu value='$_POST[idsmu]'></td></tr>			   						
	    <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";

?>