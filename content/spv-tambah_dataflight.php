<?php
  echo "<h2>TAMBAH DATA FLIGHT</h2>
        <form method=POST action='aksi.php?module=dataflightno&act=tambah' 
		onSubmit=\"return checkrequired(this)\">
        <table>
        <tr><td>FLIGHT</td>     <td> : <input type=text name=requiredflight
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		autocomplete=off> *</td></tr>
        <tr><td>CUSTOMER</td>
	    	<td> : <select name=customer>";
				$tampil=mysql_query("SELECT * FROM customer ORDER BY customer ASC");
         		while($r=mysql_fetch_array($tampil))
				{
    	    		echo "<option value=$r[idcustomer]>$r[customer] -> $r[cus_desc] -> $r[bendera]</option>";
				}
		echo "</select>	</td></tr>
		<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, tidak akan tersimpan.</td></tr> 
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";

?>