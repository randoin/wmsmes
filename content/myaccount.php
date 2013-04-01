<?php
	$data=mysql_query("SELECT * FROM user WHERE id_user='$_SESSION[namauser]'");
	$r=mysql_fetch_array($data);
	echo "<h2>USERNAME :  $_SESSION[namauser]</h2>
        <form method=POST action=aksi.php?&act=user_update>
        <input type=hidden name=id value='$r[id_user]'>
        <table>
        <tr><td>Password</td>     <td> : <input type=text name=password> *) </td></tr>
        <tr>
			<td>Nama Lengkap</td> 
			<td> : <input type=text name=nama_lengkap size=30  value='$r[nama_lengkap]' onChange=\"javascript:this.value=this.value.toUpperCase();\"  ></td>
		</tr>
        <tr>
			<td>NIPP</td> 
			<td> : <input type=text name=nipp size=20 value='$r[nipp]' onChange=\"javascript:this.value=this.value.toUpperCase();\"  > </td>
		</tr>					
 
        <tr>
			<td>User Level</td> <td> : $r[level] </td>
		</tr>
		<tr>
			<td>No. Telpon</td>
			<td> : <input type=text name=no_telpon size=30 value='$r[telpon]'></td>
		</tr>						
        <tr><td colspan=2>*) Apabila password tidak diubah, dikosongkan saja.</td></tr>
        <tr><td colspan=2><input type=submit value=Update>
			<input type=hidden name=module value=$_GET[module]>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";

?>