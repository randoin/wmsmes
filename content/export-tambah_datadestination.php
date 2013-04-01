<?php
  echo "<h2>TAMBAH DATA DESTINATION</h2>
        <form method=POST action='aksi.php?module=datadestinasi&act=tambah' 
		onSubmit=\"return checkrequired(this)\">
        <table>
        <tr><td>CODE</td>     <td> : <input type=text name=requiredcode
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		autocomplete=off> *</td></tr>
        <tr><td>DESCRIPTION</td>     <td> : <input type=text name=requireddesc
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		autocomplete=off> *</td></tr>		
        <tr><td>REGION/DESTINATION</td>
	    	<td> : <select name=region>";
				$tampil=mysql_query("SELECT * FROM region ORDER BY region ASC");
         		while($r=mysql_fetch_array($tampil))
				{
    	    		echo "<option value='$r[idregion]'>$r[region] -> $r[dest_desc]</option>";
				}
		echo "</select></td></tr>
        <tr><td>NO. KPBC</td>     <td> : <input type=text name=nokpbc
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		autocomplete=off> *</td></tr>
        <tr><td>KPBC</td>     <td> : <input type=text name=kpbc
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		autocomplete=off size=30> *</td></tr>		
        <tr><td>TPS</td>     <td> : <input type=text name=tps
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		autocomplete=off size=50> </td></tr>	
		<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, tidak akan tersimpan.</td></tr> 
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";
?>