<?php
echo "<h2>BATAS CETAKAN BAWAH KERTAS</h2>
        <form method=POST action='aksi.php?module=cetakdaftarbongkar'>
        <table>
        <tr><td>Batas Cetak</td>     <td> : <input type=text name=batas size=10 value=10></td></tr>
	<tr><td colspan=2><input type=submit value=PREVIEW></td></tr>
	</table>
	<input type=hidden name=i value=$_GET[i]>
	<input type=hidden name=idm value=$_GET[idm]>
	</form>";

?>