<?php
    echo "<h2>VOID DeliveryBill # $_GET[n]</h2>
       <form name=form1 method=POST action=aksi.php?module=voiddb>
        <table>	
    	  <tr><td>Keterangan</td><td> : <input type=text name=keterangan size=60></td></tr>
		</td></tr>
                <tr><td colspan=2><input type=submit value='SIMPAN'>
        <input type=button value=Batal onclick=self.history.back()>
		<input type=hidden name=i value='$_GET[i]'>		<input type=hidden name=s value='$_GET[s]'><input type=hidden name=b value='$_GET[b]'>
		</td></tr>
	   
        </table>
        </form>";

?>