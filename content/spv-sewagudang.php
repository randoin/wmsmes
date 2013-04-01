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
$tgl=date("Y-m-d");
if((!empty($_POST['sewagudang'])) AND (!empty($_POST['dokumen'])) AND (!empty($_POST['ppn'])))
	{
		mysql_query("INSERT INTO hargasewa (tgl,sewaperhari,dokumen,user,ppn,minhari,mincharge)
					 values ('$tgl',
					 		 '$_POST[sewagudang]',
							 '$_POST[dokumen]',
							 '$_SESSION[namauser]',
							 '$_POST[ppn]',
							 '$_POST[minhari]',
							 '$_POST[mincharge]',
							 '$POST[minweight]')");
	}
	
	$tampil=mysql_query("select * from hargasewa order by id DESC limit 1");
	$p=mysql_fetch_array($tampil);
?>	

<h2>PARAMETER HARGA SEWA DOKUMEN DAN BIAYA LAINNYA</h2>
<form method="POST" action="?module=sewagudang">
	<table>
		<tr>
        	<td>Sewa Gudang / Hari (Rp)</td>     
			<td> : <input type="text" name="sewagudang" value="<?php $p['sewaperhari'] ?>" onkeypress="return isNumberKey(event)"> *</td>
        </tr>
        
        <tr>
        	<td>Administrasi (Rp)</td>
            <td> : <input type="text" name="dokumen" value="<?php $p['dokumen'] ?>" onkeypress="return isNumberKey(event)"> *</td>
        </tr>
        
        <tr>
        	<td>PPn (%)</td>
            <td> : <input type="text" name="ppn" size="10" value="<?php $p['ppn'] ?>" onkeypress="return isNumberKey(event)"> *</td>
        </tr>		
        
        <tr>
        	<td>Minimal Hari</td>
            <td> : <input type="text" name="minhari" size="10" value="<?php $p['minhari'] ?>" onkeypress="return isNumberKey(event)"> </td>
        </tr>
		
        <tr>
        	<td>Minimal Charge</td>
            <td> : <input type="text" name="mincharge" size="10" value="<?php $p['mincharge'] ?>" onkeypress="return isNumberKey(event)"> *</td>
        </tr>
		
        <tr>
        	<td>Minimal Berat</td>
            <td> : <input type="text" name="minweight" size="10" value="<?php $p['minweight'] ?>" onkeypress="return isNumberKey(event)"> </td>
        </tr>		
  											
		<tr>
        	<td colspan="2">*) wajib diisi, data kosong atau duplikasi/double ID kunci, tidak akan tersimpan.</td>
        </tr> 
        
        <tr>
        	<td colspan="2"><input type="submit" value="UPDATE HARGA">
        				    <input type="button" value="Batal" onclick="self.history.back()"></td>
        </tr>
	</table>
</form>	

<table>
	<tr>
    	<th>no</th>
        <th>Tanggal</th>
        <th>Sewa Gudang/Hari</th>
        <th>Dokumen</th>
		<th>Ppn</th>
        <th>Min Hari</th>
        <th>Min Charge (Rp)</th>
        <th>Min Weight</th>
        <th>user</th>
	</tr>
	
    <?php
		$p      = new Paging;
		$batas  = 5;
		$posisi = $p->cariPosisi($batas);
		$tampil=mysql_query("SELECT * FROM hargasewa ORDER BY id DESC limit $posisi,$batas");
    $no     = $posisi+1;
		$tgl1=my2date($r[tgl]);
  	while ($r=mysql_fetch_array($tampil))
		{
			echo "<tr><td>$no</td>
      	    <td>$r[tgl]</td>
        	  <td>$r[sewaperhari]</td>
						<td>$r[dokumen]</td>
						<td>$r[ppn]</td>
						<td>$r[minhari]</td>
						<td>$r[mincharge]</td>
						<td>$r[minweight]</td>						
						<td>$r[user]</td></tr>";
     	$no++;
  	}
  	echo "</table>";
			$jmldata      = mysql_num_rows(mysql_query("SELECT * FROM hargasewa"));
			$jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
			$linkHalaman  = $p->navHalaman($_GET[h], $jmlhalaman,'0');
		echo "<p>$linkHalaman</p>";
	?>