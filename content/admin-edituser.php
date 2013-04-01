<?php
  $edit=mysql_query("SELECT * FROM user WHERE id_user='$_GET[id]'");
  $r=mysql_fetch_array($edit);

  echo "<h2>Edit User</h2>
        <form method=POST action=aksi.php?module=user&act=update>
        <input type=hidden name=id value='$r[id_user]'>
        <table>
        <tr><td>Username</td>     <td> : $r[id_user]</td></tr>
        <tr><td>Password</td>     <td> : <input type=text name=password> *) </td></tr>
        <tr><td>Nama Lengkap</td> <td> : <input type=text name=nama_lengkap size=30  value='$r[nama_lengkap]'></td></tr>
        <tr><td>NIPP</td> <td> : <input type=text name=nipp size=20 value='$r[nipp]'> *</td></tr>					
        <tr><td>User Level</td> <td> : 
		<select name=level>";
		if($r[level]=='supervisor')
		{
		echo "<option value='supervisor' selected>SUPERVISOR</option>
			<option value='export'>EXPORT</option>
			<option value='import'>IMPORT</option>
			<option value='btb'>BTB</option>";
		}
		else if($r[level]=='export')
		{
		echo "<option value='supervisor'>SUPERVISOR</option>
			<option value='export' selected>EXPORT</option>
			<option value='import'>IMPORT</option>
			<option value='btb'>BTB</option>";
		}
		else if($r[level]=='import')
		{
		echo "<option value='supervisor'>SUPERVISOR</option>
			<option value='export'>EXPORT</option>
			<option value='import' selected>IMPORT</option>
			<option value='btb'>BTB</option>";
		}
		else if($r[level]=='btb')
		{
		echo "<option value='supervisor'>SUPERVISOR</option>
			<option value='export'>EXPORT</option>
			<option value='import'>IMPORT</option>
			<option value='btb' selected>BTB</option>";
		}
		
		echo "</select></td></tr>
		<tr><td>No. Telpon</td> <td> : <input type=text name=no_telpon size=30 value='$r[telpon]'></td></tr>						
        <tr><td colspan=2>*) Apabila password tidak diubah, dikosongkan saja.</td></tr>
        <tr><td colspan=2><input type=submit value=Update>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";

?>