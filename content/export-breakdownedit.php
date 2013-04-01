<?php
$tampil=mysql_query("select * from isimanifestout where id_isimanifestout='$_GET[n]'");
$r=mysql_fetch_array($tampil);
    echo "<h2>Edit Breakdown No. SMU : $r[no_smu]</h2>
       <form name=form1 method=POST action=aksi.php?module=isimanifestout&act=edit>
        <table>
		<tr><td>No SMU</td><td> : <input type=text name=no_smu size=20 value='$r[no_smu]'></td></tr>		
          <tr><td>Jenis Barang</td>     <td> :
	  	<select name=jenisbarang>";
  		  $a=mysql_query("SELECT * FROM typebarang ORDER BY typebarang ASC");
  		  while($p=mysql_fetch_array($a))
                {
                    if($p[typebarang]==$r[jenisbarang])
					{
						echo "<option value='$p[typebarang]' selected>$p[typebarang]</option>";
					}
                    else 
					{
						echo "<option value='$p[typebarang]'>$p[typebarang]</option>";
					}
				}
  	  echo "</select>
          </td></tr>
			
    	  <tr><td>Jml  Koli (SMU)</td><td> : <input type=text name=totalkoli size=10 value=$r[totalkoli]></td></tr>
    	  <tr><td>Berat  (SMU)</td><td> : <input type=text name=totalberat size=10 value=$r[totalberat]></td></tr>
    	  <tr><td>Jml  Koli (DATANG)</td><td> : <input type=text name=totalkolidatang size=10 value=$r[totalkoli]></td></tr>
    	  <tr><td>Berat  (DATANG)</td><td> : <input type=text name=totalberatdatang size=10 value=$r[totalberat]></td></tr>
       	  <tr><td>Asal Airport</td><td> :
          <select name=asal>";
  	    	  $tampil=mysql_query("SELECT * FROM destination ORDER BY destination ASC");
  		  while($p=mysql_fetch_array($tampil))
                {
                    if($p[destination]==$r[asal])
					{
						echo "<option value=$p[destination] selected>$p[destinationdesc]</option>";
					}
                    else 
					{
						echo "<option value=$p[destination]>$p[destinationdesc]</option>";
					}
				}
  	  echo "</select>
          <tr><td>Status</td><td>";
		  if($r[status_transit]=='MES')
		  {
          echo("<input type=radio name=transit value='MES' checked>MES
				<input type=radio name=transit value='TRANSIT'>Transit to :");
		  }
		  else
		  {
          echo("<input type=radio name=transit value='MES'>MES
				<input type=radio name=transit value='TRANSIT' checked>Transit to :");
		  }

	echo "<select name=tujuan>";
  		$tampil=mysql_query("SELECT * FROM destination ORDER BY destination ASC");
 		  while($p=mysql_fetch_array($tampil))
                {
                    if($p[destination]==$r[tujuan])
					{
						echo "<option value=$p[destination] selected>$p[destinationdesc]</option>";
					}
                    else 
					{
						echo "<option value=$p[destination]>$p[destinationdesc]</option>";
					}
				}
  		echo "</select>
		</td></tr>
                <tr><td colspan=2><input type=submit value='UPDATE'>
        <input type=button value=Batal onclick=self.history.back()>
		<input type=hidden name=n value='$r[id_isimanifestout]'>
		<input type=hidden name=i value='$_GET[i]'>
		</td></tr>
	   
        </table>
        </form>";

?>