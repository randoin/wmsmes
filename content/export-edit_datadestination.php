<?php
$r=mysql_fetch_array(mysql_query("select * from destination where iddestination='$_GET[id]'"));
  echo "<h2>EDIT DATA DESTINATION</h2>
        <form method=POST action='aksi.php?module=datadestinasi&act=edit' 
		onSubmit=\"return checkrequired(this)\">
        <table>
       <tr><td>CODE</td>     <td> : <input type=text name=requiredcode
		onChange=\"javascript:this.value=this.value.toUpperCase();\" value='$r[dest_code]' 
		autocomplete=off> *</td></tr>
       <tr><td>DESCRIPTION</td>     <td> : <input type=text name=requireddesc
		onChange=\"javascript:this.value=this.value.toUpperCase();\" value='$r[description]' 
		autocomplete=off> *</td></tr>		
       <tr><td>REGION</td>
	    	<td> : <select name=region>";
				$tampil=mysql_query("SELECT * FROM region ORDER BY region ASC");
         		while($p=mysql_fetch_array($tampil))
				{
    	    		if($p[idregion]==$r[idregion])
					{echo "<option value='$p[idregion]' selected>$p[region] -> $p[dest_desc]</option>";}
					else
					{echo "<option value='$p[idregion]'>$p[region] -> $p[dest_desc]</option>";}
				}
		echo "</select>	*</td></tr>
       <tr><td>NO KPBC</td>     <td> : <input type=text name=nokpbc
		onChange=\"javascript:this.value=this.value.toUpperCase();\" value='$r[nokpbc]' 
		autocomplete=off> *</td></tr>		
       <tr><td>KPBC</td>     <td> : <input type=text name=kpbc
		onChange=\"javascript:this.value=this.value.toUpperCase();\" value='$r[kpbc]' 
		autocomplete=off size=40> *</td></tr>	
        <tr><td>TPS</td>     <td> : <input type=text name=tps
		onChange=\"javascript:this.value=this.value.toUpperCase();\" value='$r[tps]' 
		autocomplete=off size=50> </td></tr>	

		<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, tidak akan tersimpan.</td></tr> 
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()>
		<input type=hidden name=id value='$_GET[id]'>
		</td></tr>
        </table>
        </form>";
?>