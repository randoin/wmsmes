<?php
  echo "<h2>Tambah Modul</h2>
        <form method=POST action='aksi.php?module=modul&act=input'>
        <table>
        <tr><td>Nama Modul</td> <td> : <input type=text name=nama_modul></td></tr>
        <tr><td>Link</td>       <td> : <input type=text name=link size=30></td></tr>
        <tr><td>Publish</td>    <td> : <input type=radio name=publish value='Y' checked>Y 
                                       <input type=radio name=publish value='N'>N  </td></tr>
        <tr><td>Aktif</td>      <td> : <input type=radio name=aktif value='Y' checked>Y 
                                       <input type=radio name=aktif value='N'>N  </td></tr>
        <tr><td>Status</td>     <td> : <input type=radio name=status value='admin'>admin
		<input type=radio name=status value='export' checked>export
		<input type=radio name=status value='btb' >btb
		<input type=radio name=status value='import'>import
									   <input type=radio name=status value='export'>store out
									   <input type=radio name=status value='store_in'>store in
									   <input type=radio name=status value='kasir'>kasir
									   <input type=radio name=status value='supervisor'>supervisor  </td></tr>
        <tr><td>Urutan</td>     <td> : <input type=text name=urutan size=1></td></tr>
        <tr><td colspan=2><input type=submit value=Simpan name=simpanmodul>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";
?>