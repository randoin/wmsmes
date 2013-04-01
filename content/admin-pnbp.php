<?php
	
	$tampil=mysql_query("SELECT * FROM hargapnbp order by id desc limit 1");
 	echo "<h2>TARIF PNBP</h2>
 		<form name=form1 id=form1 method=POST action='?module=pnbp'>
		<a href=?act=tambah_datapnbp>
			<span class=tombol> TAMBAH DATA </span></a>
		<table><tr>
		<th>Jumlah Patokan</a></th>
		<th>Harga Bawah/Sama</th><th>Harga Atas</th></tr>";
	while ($r=mysql_fetch_array($tampil))
	{
				echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td align=center>".$r[jml1]."</td>
          	<td align=right>".number_format($r[hargajml1], 0, ',', '.')."</td>
<td align=right>".number_format($r[hargajml2], 0, ',', '.')."</td>
</tr>";
     $no++;
  	}

?>