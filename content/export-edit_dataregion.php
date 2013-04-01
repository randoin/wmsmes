<?php
$r=mysql_fetch_array(mysql_query("select * from region where idregion='$_GET[id]'"));
  echo "<h2>EDIT DATA REGION</h2>
        <form method=POST action='aksi.php?module=dataregion&act=edit' 
		onSubmit=\"return checkrequired(this)\">
        <table>
        <tr><td>REGION</td>     <td> : <input type=text name=requiredregion
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		value='$r[region]' autocomplete=off> *</td></tr>
        <tr><td>DESCRIPTION</td>     <td> : <input type=text name=requireddescription size=30 
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		value='$r[dest_desc]' autocomplete=off> *</td></tr>
		<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, tidak akan tersimpan.</td></tr> 
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()>
		<input type=hidden name=id value='$_GET[id]'>
		</td></tr>
        </table>
        </form>";

?>