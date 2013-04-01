<?php
$tampil=mysql_query("select * from isimanifestout where id_isimanifestout='$_GET[n]'");
$r=mysql_fetch_array($tampil);
    echo "<h2>Cancel  No. SMU : $r[no_smu]</h2>
       <form name=form1 method=POST action=aksi.php?module=isimanifestout&act=cancel>
        <table>	
    	  <tr><td>Keterangan</td><td> : <input type=text name=keterangan_void size=60></td></tr>
		</td></tr>
                <tr><td colspan=2><input type=submit value='CANCEL'>
        <input type=button value=Batal onclick=self.history.back()>
		<input type=hidden name=n value='$r[id_isimanifestout]'>
		<input type=hidden name=i value='$_GET[i]'>
		</td></tr>
	   
        </table>
        </form>";

?>