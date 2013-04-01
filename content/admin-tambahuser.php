<?php
  echo "<h2>TAMBAH USER ACCOUNT WMS</h2>
        <form method=POST action='aksi.php?module=user&act=input'>
        <table>
        <tr><td>Username</td>     <td> : <input type=text name=id_user> *</td></tr>
        <tr><td>Password</td>     <td> : <input type=text name=password> *</td></tr>
        <tr><td>Nama Lengkap</td> <td> : <input type=text name=nama_lengkap size=30> *</td></tr>
        <tr><td>NIPP</td> <td> : <input type=text name=nipp size=20> *</td></tr>				
		<tr><td>No. Telpon</td> <td> : <input type=text name=no_telpon size=30></td></tr>		  
        <tr><td>User Level</td> <td> : 
		<select name=level>
			<option value='supervisor' selected>SUPERVISOR</option>
			<option value='kasir'>KASIR</option>
			<option value='export'>EXPORT</option>
			<option value='import'>IMPORT</option>
			<option value='btb'>BTB</option>
		</select>
		</td></tr>
		<tr><td colspan=2>*) wajib diisi, jika kosong maka data tidak akan tersimpan.</td></tr> 
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";

?>