<?php
  echo "<h2>TAMBAH DATA customer</h2>
        <form method=POST action='aksi.php?module=datacustomer&act=tambah' 
		onSubmit=\"return checkrequired(this)\">
        <table>
        <tr><td>CUSTOMER</td>     <td> : <input type=text name=requiredcustomer
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		autocomplete=off> *</td></tr>
        <tr><td>DESCRIPTION</td>     <td> : <input type=text name=requireddescription size=30 
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		autocomplete=off> *</td></tr>
       <tr><td>BENDERA</td>     <td> : <input type=text name=requiredbendera size=30 
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		autocomplete=off> *</td></tr>
       <tr><td>PIC Transhipment</td>     <td> : <input type=text name=pejabatbc12 size=30 
		autocomplete=off></td></tr>
		<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, tidak akan tersimpan.</td></tr> 
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";

?>