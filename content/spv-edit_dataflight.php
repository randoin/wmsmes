<?php
$r=mysql_fetch_array(mysql_query("select * from flight where idflight='$_GET[id]'"));
  echo "<h2>EDIT DATA FLIGHT</h2>
        <form method=POST action='aksi.php?module=dataflightno&act=edit' 
		onSubmit=\"return checkrequired(this)\">
        <table>
        <tr><td>FLIGHT</td>     <td> : <input type=text name=requiredflight
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		value='$r[flight]' autocomplete=off> *</td></tr>
       <tr><td>CUSTOMER</td>
	    	<td> : <select name=customer>";
				$tampil=mysql_query("SELECT * FROM customer ORDER BY customer ASC");
         		while($p=mysql_fetch_array($tampil))
				{
    	    		if($p[idcustomer]==$r[idcustomer])
					{echo "<option value='$p[idcustomer]' selected>$p[customer] -> $p[cus_desc] -> $p[bendera]</option>";}
					else
					{echo "<option value='$p[idcustomer]'>$p[customer] -> $p[cus_desc] -> $p[bendera]</option>";}
				}
		echo "</select>	</td></tr>
		<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, tidak akan tersimpan.</td></tr> 
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()>
		<input type=hidden name=id value='$_GET[id]'>
		</td></tr>
        </table>
        </form>";
?>