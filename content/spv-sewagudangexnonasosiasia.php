<SCRIPT language=Javascript>
//Convert array into object
function oc(a)
{
	var o = {};
	for(var i=0;i<a.length;i++)
	{
		o[a[i]]='';
	}
	return o;
}

//Allow only numeric input, decimal point, backspace
function isNumberKey(evt)
{
	var myValidChars = new Array(0,8,46,48,49,50,51,52,53,54,55,56,57,190);
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode in oc(myValidChars))
	return true;
	return false;
}
</SCRIPT>

<?php
date_default_timezone_set('Asia/Jakarta');
//error_reporting(E_ALL);
$tgl=date("Y-m-d");

	if((!empty($_POST['sewagudang'])) AND (!empty($_POST['dokumen'])) AND (!empty($_POST['ppn'])))
	{
		mysql_query("INSERT INTO hargasewa (tgl,
											sewaperhari,
											cargocharge,
											kade,
											dokumen,
											user,
											ppn,
											minhari,
											mincharge,
											minweight,
											asperindo,
											shareasperindo,
											loading,
											type)
									VALUES ('$tgl',
											'$_POST[sewagudang]',
											'$_POST[cargocharge]',
											'$_POST[kade]',
											'$_POST[dokumen]',
											'$_SESSION[namauser]',
											'$_POST[ppn]',
											'$_POST[minhari]',
											'$_POST[mincharge]',
											'$_POST[minweight]',
											'0',
											'$_POST[shareasperindo]',
											'$_POST[loading]',
											'export')
					");
	}
	
	$tampil=mysql_query("select * from hargasewa where asperindo='0' AND type='export' order by id DESC limit 1");
	$p=mysql_fetch_array($tampil);
?>	

<h2>HARGA SEWA DAN SHARING EXPORT NON ASOSIASI</h2>  
<form method="POST" action='?module=sewagudangimnonasosiasi'>
<table width="376">
	<tr>
    	<td align="center" colspan="2"><b>EXPORT NON ASOSIASI</b></td>
    </tr>
       			
	<tr>
    	<td width="159">Sewa Gudang / Hari / KG</td>
        <td width="193"> : Rp. <input type="text" name="sewagudang" value="<?php echo $p['sewaperhari']; ?>" onkeypress="return isNumberKey(event)"/> *</td>
	</tr>
	
	<tr>
		<td>Cargo Charge / KG</td>
        <td> : Rp. <input type="text" name="cargocharge" value="<?php echo $p['cargocharge']; ?>" onkeypress=\"return isNumberKey(event)\"> *</td>
	</tr>
	
	<tr>
		<td>KADE / KG</td>
        <td> : Rp. <input type="text" name="kade" value="<?php echo $p['kade']; ?>" onkeypress=\"return isNumberKey(event)\"> *</td>
	</tr>
    
	<tr>
    	<td>Administrasi</td>
        <td> : Rp. <input type="text" name="dokumen" value="<?php echo $p['dokumen']; ?>" onkeypress=\"return isNumberKey(event)\"> *</td>
	</tr>
    
	<tr>
    	<td>PPn</td>
        <td> : <input type="text" name="ppn" size="10" value="<?php echo $p['ppn']; ?>" onkeypress=\"return isNumberKey(event)\">% *</td>
    </tr>		
        		
	<tr>
    	<td>Minimal Hari</td>
        <td> : <input type="text" name="minhari" size="10" value="<?php echo $p['minhari']; ?>" onkeypress=\"return isNumberKey(event)\"> 
          hari ( min 1 ) </td>
    </tr>
	
	<tr>
    	<td>Minimal Sewa Gudang</td>
        <td> : Rp. <input type="text" name="mincharge" size="10" value="<?php echo $p['mincharge']; ?>" onkeypress="return isNumberKey(event)"> *</td>
    </tr>
	
    <tr>
    	<td>Minimal Berat</td>
        <td> : <input type="text" name="minweight" size="10" value="<?php echo $p['minweight']; ?>" onkeypress="return isNumberKey(event)"> KG *</td>
    </tr>		
  	
    <tr>
    	<td align="center" colspan='2'><b>EXPORT NON ASOSIASI</b></td>
    </tr>							
	
    <tr>
    	<td>Sharing Asosiasi / KG</td>
        <td> : Rp. <input type="text" name="shareasperindo" size="10" value="<?php echo $p['shareasperindo']; ?>" onkeypress="return isNumberKey(event)"></td>
    </tr>
    
    <tr>
		<td>Sharing Loading</td>
        <td> : Rp. <input type="text" name="loading" size="10" value="<?php echo $p['loading']; ?>" onkeypress="return isNumberKey(event)"></td>
    </tr>
	
    <tr>
    	<td colspan=2>*) wajib diisi, jika kosong maka data tidak akan tersimpan.</td>
    </tr> 
    
    <tr>
    	<td colspan=2><input type="submit" value="UPDATE HARGA"> <input type="button" value="Batal" onclick=self.history.back()></td>
    </tr>
    
  </table>
</form>	

<table>
	<tr>
    	<th>no</th>
        <th>Tanggal</th>
        <th>Sewa Gudang/Hari/KG</th>
        <th>Airport Charge/KG</th>
        <th>KADE/KG</th>
        <th>Administrasi</th>
		<th>Ppn</th>
        <th>Min Hari</th>
        <th>Min Sewa Gudang (Rp)</th>
        <th>Min Berat/KG</th>
        <th>Sharing Asosiassi/KG</th>
        <th>Sharing Loading/KG</th>
        <th>Update By</th>
	</tr> 
        
     <?php
	 //error_reporting(E_ALL);
		$p      = new Paging;
		$batas  = 10;
		$posisi = $p->cariPosisi($batas);
		$tampil=mysql_query("SELECT * FROM hargasewa where asperindo='0' AND type='export' ORDER BY id DESC limit $posisi,$batas");
    	$no     = $posisi+1;
		//$tgl1=my2date($r['tgl']);
  			while ($r=mysql_fetch_array($tampil))
		{
	 	
		  	echo "<tr>";
          	echo "<td>$no</td>";
      	  	echo "<td>$r[tgl]</td>";
          	echo "<td>$r[sewaperhari]</td>";
          	echo "<td>$r[cargocharge]</td>";
         	echo "<td>$r[kade]</td>";
		  	echo "<td>$r[dokumen]</td>";
		  	echo "<td>$r[ppn]%</td>";
		  	echo "<td>$r[minhari] Hari</td>";
		  	echo "<td>$r[mincharge]</td>";
		  	echo "<td>$r[minweight] KG</td>";
          	echo "<td>$r[shareasperindo]</td>";
          	echo "<td>$r[loading]</td>";			
		  	echo "<td>$r[user]</td>";
          	echo "</tr>";
      	
     		$no++;
  		}
		
   echo "</table>";
   
			$jmldata      = mysql_num_rows(mysql_query("SELECT * FROM hargasewa where asperindo='0' AND type='export'"));
			$jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
			$linkHalaman  = $p->navHalaman($_GET['h'], $jmlhalaman,'0');
		 	echo "<p>$linkHalaman</p>";
	?>