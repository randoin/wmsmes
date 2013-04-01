<?php
$r=mysql_fetch_array(mysql_query("select * from commodity_ap where idcommodityap='$_GET[id]'"));
  echo "<h2>EDIT DATA COMMODITY (REFF:AP)</h2>
        <form method=POST action='aksi.php?module=datacommodity_ap&act=edit' 
		onSubmit=\"return checkrequired(this)\">
        <table>
        <tr><td>SUB CODE</td>     <td> : <input type=text name=requiredsubcodecommodity
		onChange=\"javascript:this.value=this.value.toUpperCase();\" value='$r[commodityap]'  
		autocomplete=off> *</td></tr>
         <tr><td>COMMODITY CODE</td>
	    	<td> : <select name=commodity>";
				$tampil=mysql_query("SELECT * FROM commodity ORDER BY commodity ASC");
         		while($p=mysql_fetch_array($tampil))
				{
    	    		if($p[idcommodity]==$r[idcommodity])
					{echo "<option value='$p[idcommodity]' selected>$p[commodity] -> $p[com_desc]</option>";}
					else
					{echo "<option value='$p[idcommodity]'>$p[commodity] -> $p[com_desc]</option>";}
				}
		echo "</select>	*</td></tr>
		<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, tidak akan tersimpan.</td></tr> 
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()>
		<input type=hidden name=id value='$_GET[id]'>
		</td></tr>
        </table>
        </form>";
?>