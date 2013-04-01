<?php
?>
 
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
<?

$tampil=mysql_query("select * from breakdown,isimanifestin where breakdown.id_isimanifestin=isimanifestin.id_isimanifestin AND breakdown.id_breakdown='$_GET[b]'");
$r=mysql_fetch_array($tampil);
$kol=$r[kolidatang];
$ber=$r[beratdatang];

//cek dulu apakah SMU ini (jika split) sudah ada yang CONFIRM
$st=mysql_query("select count(*) from breakdown where status_check='confirm' AND id_isimanifestin='$_GET[n]'");
$st1=mysql_fetch_array($st);
$adacek=$st1[0];


echo "<h2>Edit Breakdown No. SMU : $r[no_smu]</h2>
      <form name=form1 method=POST action=aksi.php?module=isimanifestin&act=edit>
      <table>";		
				
//jika belum ada yang CONFIRM maka seluruh data SMU dapat diedit
if($adacek=='0')
{
echo "<tr><td>No SMU</td><td> : <input type=text onKeyDown=\"javascript:return dFilter (event.keyCode, this, '###-####-### #');\" name=no_smu size=40 value='$r[no_smu]' onChange=\"javascript:this.value=this.value.toUpperCase();\"></td></tr><tr><td>Jenis Barang</td><td> : <select name=jenisbarang>";
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
			
     	  <tr><td>Jumlah Koli di SMU </td><td> : <input type=text name=totalkoli size=10 value=$r[totalkoli] onkeypress=\"return isNumberKey(event)\" autocomplete=off> -> Datang : <input type=text name=totalkolidatang size=10 value=$kol onkeypress=\"return isNumberKey(event)\" autocomplete=off></td></tr>
    	  <tr><td>Berat Aktual di SMU</td><td> : <input type=text name=totalberat size=10 value=$r[totalberat] onkeypress=\"return isNumberKey(event)\" autocomplete=off> -> Datang : <input type=text name=totalberatdatang size=10 value=$ber onkeypress=\"return isNumberKey(event)\" autocomplete=off></td></tr>      	  
     	  <tr><td>Berat Di Bayar </td><td> : <input type=text name=totalberatbayar size=10 value=$r[beratbayar] onkeypress=\"return isNumberKey(event)\" autocomplete=off></td></tr>				
				
				<tr><td>Agent</td><td> :
          <select name=agent>";
					if($r[agent]=='POST')
					{
						echo "<option value=''>-</option>
						<option value='POST' selected>POST</option>
						<option value='GMFAA'>GMFAA</option>
						<option value='ACS'>ACS</option>
						<option value='QATAR'>QATAR</option>"; 		
					}
					elseif($r[agent]=='GMFAA')
					{
						echo "<option value=''>-</option>
						<option value='POST'>POST</option>
						<option value='GMFAA' selected>GMFAA</option>
						<option value='ACS'>ACS</option>
						<option value='QATAR'>QATAR</option>"; 		
					}
					elseif($r[agent]=='ACS')
					{
						echo "<option value=''>-</option>
						<option value='POST'>POST</option>
						<option value='GMFAA'>GMFAA</option>
						<option value='ACS' selected>ACS</option>
						<option value='QATAR'>QATAR</option>"; 		
					}		
					elseif($r[agent]=='QATAR')
					{
						echo "<option value=''>-</option>
						<option value='POST'>POST</option>
						<option value='GMFAA'>GMFAA</option>
						<option value='ACS'>ACS</option>
						<option value='QATAR' selected>QATAR</option>"; 		
					}									
					else
					{
						echo "<option value='' selected>-</option>
						<option value='POST'>POST</option>
						<option value='GMFAA'>GMFAA</option>
						<option value='ACS'>ACS</option>
						<option value='QATAR'>QATAR</option>"; 		
					}					
		  echo "</select> 

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
          echo("<input type=radio name=transit value='MES' onClick=\"agree=0; document.form1.tujuan.focus();\" checked>MES
				<input type=radio name=transit value='TRANSIT' onClick=\"agree=1; document.form1.tujuan.focus();\">Transit to :");
		  }
		  else
		  {
          echo("<input type=radio name=transit value='MES' onClick=\"agree=0; document.form1.tujuan.focus();\">MES
				<input type=radio name=transit value='TRANSIT' onClick=\"agree=1; document.form1.tujuan.focus();\" checked>Transit to :");
		  }

	echo "<select name=tujuan onFocus=\"if (!agree)this.blur();\" onChange=\"if (!agree)this.value='';\">
		<option value='MES' selected>--Pilih Tujuan--</option>";
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
		</td></tr>";
}

//jika ternyata SMU adalah split dan sudah ada yang melakukan CONFIRM, maka
// data tidak dapat diedit kecuali sisa kedatangan
else
{
   echo "
		<tr><td>No SMU</td><td> : $r[no_smu]</td></tr>		
          <tr><td>Komoditi</td>     <td> :$r[jenisbarang]
          </td></tr>
			
     	  <tr><td>Jumlah Koli di SMU </td><td> : $r[totalkoli] -> Datang : <input type=text name=totalkolidatang size=10 value=$kol onkeypress=\"return isNumberKey(event)\" autocomplete=off></td></tr>
    	  <tr><td>Berat Aktual di SMU</td><td> : $r[totalberat] -> Datang : <input type=text name=totalberatdatang size=10 value=$ber onkeypress=\"return isNumberKey(event)\" autocomplete=off></td></tr>      	  
     	  <tr><td>Berat Di Bayar </td><td> : <input type=text name=totalberatbayar size=10 value=$r[beratbayar] onkeypress=\"return isNumberKey(event)\" autocomplete=off></td></tr>				
				
				<tr><td>Agent</td><td> :$r[agent]</td></tr>
         

       	  <tr><td>Asal Airport</td><td> :$r[asal]</td></tr>
         


          <tr><td>Status</td><td> : $r[status_transit]</td></tr>
		  
		</td></tr>";}

echo "		<tr><td colspan=2><strong>Data diisikan sesuai dengan riil kedatangan dokumen SMU/Cargo</strong></td></tr>
                <tr><td colspan=2><input type=submit value='UPDATE'>
        <input type=button value=Batal onclick=self.history.back()>
		<input type=hidden name=n value='$r[id_isimanifestin]'>
		<input type=hidden name=i value='$_GET[i]'>
		<input type=hidden name=a value='$_GET[a]'>
		<input type=hidden name=b value='$_GET[b]'>	
				<input type=hidden name=adacek value='$adacek'>	
		</td></tr>
	   
        </table>
        </form>";



?>