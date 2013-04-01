<?php
$r=mysql_fetch_array(mysql_query("select * from connectingflight where idconnectingflight='$_GET[id]'"));
  echo "<h2>EDIT DATA CONNECTING FLIGHT</h2>
        <form method=POST action='aksi.php?module=connectingflight&act=edit' 
		onSubmit=\"return cekdulu()\">
        <table>
       <tr><td>NAMA</td>     <td> : <input type=text name=nama
		onChange=\"javascript:this.value=this.value.toUpperCase();\" value='$r[nama]' 
		autocomplete=off size=30></td></tr>
       <tr><td>ALAMAT</td>     <td> : <textarea name=alamat
		onChange=\"javascript:this.value=this.value.toUpperCase();\">$r[alamat]</textarea></td></tr>		
       <tr><td>NPWP</td>     <td> : <input type=text name=npwp
		onChange=\"javascript:this.value=this.value.toUpperCase();\" value='$r[npwp]' 
		autocomplete=off> *</td></tr>		
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()>
		<input type=hidden name=id value='$_GET[id]'>
		</td></tr>
        </table>
        </form>";

?>