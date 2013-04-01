<?php
	if($_GET['p']=='e')
  	{
    	$err='Data SMU tersebut Sudah Ada';
		}

  ?>
  <SCRIPT LANGUAGE="JavaScript" src="cal2.js">
  </script>
  <script language="javascript">
    addCalendar("Caritanggal","Tanggal","tglmanifest","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
  </script>
  <?
		$tampil=mysql_query("SELECT * FROM isimanifestin where isvoid='0' AND id_isimanifestin='$_GET[i]' ");
    $r=mysql_fetch_array($tampil);
		
		

 echo "<h2>Edit data</h2>

        <form method=POST action='aksi.php?module=isimanifestin&act=input'>
<table><tr><td>
       	<table>
       	  <tr><td>No.SMU</td><td> : <input type=text size=30 name=nosmu value='$r[no_smu]'></td></tr>
          <tr><td>Jenis Barang</td>     <td> :
	  	<select name=jenisbarang>";
  		  $tampil1=mysql_query("SELECT * FROM typebarang ORDER BY typebarang ASC");
  		  while($p=mysql_fetch_array($tampil1))
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
       	  <tr><td>Total Koli</td>     <td> : <input type=text size=10 name=totalkoli value='$r[totalkoli]'></td></tr>
    	  <tr><td>Total Berat</td><td> : <input type=text name=totalkg size=10 value='$r[totalberat]'></td></tr>
       	  <tr><td>Asal Airport</td><td> :
          <select name=asal>";
  	    	  $tampil2=mysql_query("SELECT * FROM destination ORDER BY destination ASC");
  		  while($p=mysql_fetch_array($tampil2))
                  {
									if($p[destination]==$r[asal]){echo "<option value=$p[destination] selected>$p[destinationdesc]</option>";}
									else{echo "<option value=$p[destination]>$p[destinationdesc]</option>";}
									}
  	  echo "</select>
          <tr><td>Status</td><td>";
			if($r[status_transit]=='MES'){ 
			echo("
          <input type=radio name=transit value='MES' checked>MES
          <input type=radio name=transit value='TRANSIT'>Transit to :");}
					else {
								echo("
          <input type=radio name=transit value='MES'>MES
          <input type=radio name=transit value='TRANSIT' checked>Transit to :");}

echo "
	<select name=tujuan>";
    	    	  $tampil2=mysql_query("SELECT * FROM destination ORDER BY destination ASC");
  		  while($p=mysql_fetch_array($tampil2))
                  {
									if($p[destination]==$r[tujuan]){echo "<option value=$p[destination] selected>$p[destinationdesc]</option>";}
									else{echo "<option value=$p[destination]>$p[destinationdesc]</option>";}
									}

  		echo "</select>
		</td></tr>
                <tr><td colspan=2>
								<input type=hidden name=idman value='$idmanifestin'><input type=submit value='Simpan dan Tambah'>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>";

?>