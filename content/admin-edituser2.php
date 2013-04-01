<?php
  $edit=mysql_query("SELECT * FROM user WHERE id_user='$_GET[id]'");
  $r=mysql_fetch_array($edit);

  echo "<h2>Edit User</h2>
        <form method=POST action=aksi.php?module=user&act=update>
        <input type=hidden name=id value='$r[id_user]'>
        <table>
        <tr><td>Username</td>     <td> : <input type=text name=id_user value='$r[id_user]'></td></tr>
        <tr><td>Password</td>     <td> : <input type=text name=password> *) </td></tr>
        <tr><td>Nama Lengkap</td> <td> : <input type=text name=nama_lengkap size=30  value='$r[nama_lengkap]'></td></tr>
        <tr><td>NIPP</td> <td> : <input type=text name=nipp size=20 value='$r[nipp]'> *</td></tr>					
        <tr><td>User Level</td> <td> : 
		<select name=level>";
		if($r[level]=='supervisor')
		{
		echo "<option value='supervisor' selected>SUPERVISOR</option>
			<option value='kasir'>KASIR</option>
			<option value='import'>import BREAKDOWN</option>
			<option value='export'>export BUILDUP</option>";
		}
		else if($r[level]=='kasir')
		{
		echo "<option value='supervisor' selected>SUPERVISOR</option>
			<option value='kasir' selected>KASIR</option>
			<option value='import'>import BREAKDOWN</option>
			<option value='export'>export BUILDUP</option>";
		}
		else if($r[level]=='import')
		{
		echo "<option value='supervisor'>SUPERVISOR</option>
			<option value='kasir'>KASIR</option>
			<option value='import' selected>import BREAKDOWN</option>
			<option value='export'>export BUILDUP</option>";
		}
		else if($r[level]=='export')
		{
		echo "<option value='supervisor'>SUPERVISOR</option>
			<option value='kasir'>KASIR</option>
			<option value='import'>import BREAKDOWN</option>
			<option value='export' selected>export BUILDUP</option>";
		}
		
		echo "</select></td></tr>
		<tr><td>No. Telpon</td> <td> : <input type=text name=no_telpon size=30 value='$r[telpon]'></td></tr>						
        <tr><td colspan=2>*) Apabila password tidak diubah, dikosongkan saja.</td></tr>
        <tr><td colspan=2><input type=submit value=Update>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";

?>