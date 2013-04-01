<?php
$r=mysql_fetch_array(mysql_query("select * from customer where idcustomer='$_GET[id]'"));
  echo "<h2>EDIT DATA customer</h2>
        <form method=POST action='aksi.php?module=datacustomer&act=edit' 
		onSubmit=\"return checkrequired(this)\">
        <table>
        <tr><td>CUSTOMER</td>     <td> : <input type=text name=requiredcustomer
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		value='$r[customer]' autocomplete=off> *</td></tr>
        <tr><td>DESCRIPTION</td>     <td> : <input type=text name=requireddescription size=30 
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		value='$r[cus_desc]' autocomplete=off> *</td></tr>
        <tr><td>BENDERA</td>     <td> : <input type=text name=requiredbendera size=30 
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		value='$r[bendera]' autocomplete=off> *</td>
</tr>
       <tr><td>PIC Transhipment</td>     <td> : <input type=text name=pejabatbc12 size=30 
		autocomplete=off value=\"$r[pejabatbc12]\"></td></tr>		
		<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, tidak akan tersimpan.</td></tr> 
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()>
		<input type=hidden name=id value='$_GET[id]'>
		</td></tr>
        </table>
        </form>";
?>