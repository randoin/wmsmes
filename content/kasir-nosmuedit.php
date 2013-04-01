<?php
$tampil=mysql_query("select * from out_dtbarang_h where id='$_GET[n]'");
$r=mysql_fetch_array($tampil);
    echo "<h2>Edit SMU No. BTB : $r[btb_nobtb]</h2>
       <form name=form1 method=POST action=aksi.php?module=editnosmu>
        <table>
        <tr>
					<td>No. SMU</td>     
					<td> : <input type=text size=30 name=nosmu value='$r[btb_smu]'> *		
				</tr>
	    <tr><td colspan=2>*) tidak boleh duplikasi no smu
	    <tr><td colspan=2><input type=submit value=UPDATE><input type=hidden name=no value='$r[id]'><input type=hidden name=nobtb value='$r[btb_nobtb]'>
			
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";

?>