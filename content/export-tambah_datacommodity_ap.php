<?php
  echo "<h2>TAMBAH DATA COMMODITY (REFF:AP)</h2>
        <form method=POST action='aksi.php?module=datacommodity_ap&act=tambah' 
		onSubmit=\"return checkrequired(this)\">
        <table>
        <tr><td>SUB CODE</td>     <td> : <input type=text name=requiredsubcodecommodity
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		autocomplete=off> *</td></tr>
        <tr><td>COMMODITY CODE</td>
	    	<td> : <select name=commodity>";
				$tampil=mysql_query("SELECT * FROM commodity ORDER BY commodity ASC");
         		while($r=mysql_fetch_array($tampil))
				{
    	    		echo "<option value='$r[idcommodity]'>$r[commodity] -> $r[com_desc]</option>";
				}
		echo "</select>	*</td></tr>
		<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, tidak akan tersimpan.</td></tr> 
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";
?>