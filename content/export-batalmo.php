<?php
$str=mysql_query("select * from manifestout where id_manifestout='$_GET[i]'");
$r=mysql_fetch_array($str);
$tgl2=ymd2dmy($r[tglmanifest]);
    echo "<h2>Pembatalan Manifest Out $r[airline] : A/C Reg.$r[acregistration] Flight No.$r[noflight] / $tgl2</h2>
       <form name=form1 method=POST action=aksi.php?module=batalmo>
        <table>	
    	  <tr><td>Keterangan</td><td> : <input type=text name=keterangan size=60></td></tr>
		</td></tr>
                <tr><td colspan=2><input type=submit value='OK'>
        <input type=button value=BACK onclick=self.history.back()>
		<input type=hidden name=i value='$_GET[i]'>
		</td></tr>
	   
        </table>
        </form>";

?>