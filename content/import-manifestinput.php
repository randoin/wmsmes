<SCRIPT LANGUAGE="JavaScript">
 agree= 0;
</script>

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
$tglnya=date("d-m-Y");
	$tampil=mysql_query("SELECT * FROM manifestin where id_manifestin='$_GET[i]'");
	$r=mysql_fetch_array($tampil);
	$idmanifestin=$r[id_manifestin];
if($_GET['a']>0)
{
$tmp=mysql_query("select no_smu,jenisbarang,agent,asal,tujuan,id_isimanifestin from isimanifestin where isimanifestin.no_smu='$_GET[n]'");
$tp=mysql_fetch_array($tmp);	
$idisiman=$tp[id_isimanifestin]; 
}
$tglman=$r[tglmanifest];
$tgl2=ymd2dmy($r[tglmanifest]);
$dbr=mysql_query("SELECT SUM(totalberat),SUM(totalkoli) FROM isimanifestin where id_manifestin='$idmanifestin' and isvoid='0' ORDER BY id_manifestin");
$databerat=mysql_fetch_array($dbr);

	     	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM isimanifestin where id_manifestin='$idmanifestin' and isvoid='0' ORDER BY id_manifestin"));

echo "<h2>Flight No.$r[noflight] A/C Reg.$r[acregistration] Tgl.$tgl2</h2>

        <form name=form1 method=POST action='aksi.php?module=isimanifestin&act=input'>
<table><tr><td>
       	<table>
       	  <tr><td>No.SMU</td><td> : 
					<input type=text onKeyDown=\"javascript:return dFilter 
					(event.keyCode, this, '###-#### ### ### ###');\" size=20 
					name=nosmu autocomplete=off onChange=\"javascript:this.value=this.value.toUpperCase();\" value=";
					if($_GET[n]=='')
					{
						if(($_GET[airline]=='GA') OR ($_POST[airline]=='GA')) {$a='126-';} else {$a='000-00';}
					}
					else 
					{
					$a=$_GET[n];
					}
					echo "\"$a\">
					<input type=submit value=\"Cek\" name=tombol>
					</td></tr>
          <tr><td>Komoditi</td>     <td> :
	  	<select name=jenisbarang>";
  		  $tampil=mysql_query("SELECT * FROM typebarang ORDER BY typebarang ASC");
  		  while($r=mysql_fetch_array($tampil))
                  {
                    if($r[typebarang]==$tp[jenisbarang])
										{
										echo "<option value='$r[typebarang]' selected>$r[typebarang]</option>";
										}
										else
										{
										echo "<option value='$r[typebarang]'>$r[typebarang]</option>";
										}										
										
  		  }
  	  echo "</select>
          </td></tr>
       	  <tr><td>Agent</td><td> :
          <select name=agent>";
					if($tp[agent]=='POST')
					{
						echo "<option value=''>-</option>
						<option value='POST' selected>POS</option>
						<option value='GMFAA'>GMFAA</option>
						<option value='ACS'>ACS</option>
										<option value='QATAR'>QATAR</option>";
						 		
					}
					elseif($tp[agent]=='GMFAA')
					{
						echo "<option value=''>-</option>
						<option value='POST'>POS</option>
						<option value='GMFAA' selected>GMFAA</option>
						<option value='ACS'>ACS</option>
										<option value='QATAR'>QATAR</option>"; 		
					}
					elseif($tp[agent]=='ACS')
					{
						echo "<option value=''>-</option>
						<option value='POST'>POS</option>
						<option value='GMFAA'>GMFAA</option>
						<option value='ACS' selected>ACS</option>
										<option value='QATAR'>QATAR</option>"; 		
					}		
					elseif($tp[agent]=='QATAR')
					{
						echo "<option value=''>-</option>
						<option value='POST'>POS</option>
						<option value='GMFAA'>GMFAA</option>
						<option value='ACS'>ACS</option>
										<option value='QATAR' selected>QATAR</option>"; 		
					}										
					else
					{
						echo "<option value='' selected>-</option>
						<option value='POST'>POS</option>
						<option value='GMFAA'>GMFAA</option>
						<option value='ACS'>ACS</option>
										<option value='QATAR'>QATAR</option>"; 		
					}					
		  echo "</select> 
       	  <tr><td>Koli</td>     <td> : <input type=text size=10 name=totalkoli autocomplete=off onkeypress=\"return isNumberKey(event)\" value='$_GET[k]'></td></tr>
    	  <tr><td>Berat</td><td> : <input type=text name=totalkg size=10 autocomplete=off onkeypress=\"return isNumberKey(event)\" value='$_GET[b]'></td></tr>
       	  <tr><td>Asal</td><td> :
          <select name=asal>";
  	    	  $tampil=mysql_query("SELECT * FROM destination ORDER BY destination ASC");
  		  while($r=mysql_fetch_array($tampil))
                  {
                    if($r[destination]==$tp[asal])
										{
    		    echo "<option value=$r[destination] selected>$r[destinationdesc]</option>";
						}
							else									{
    		    echo "<option value=$r[destination]>$r[destinationdesc]</option>";
						}
  		  }
  	  echo "</select>
          <tr><td>Status</td><td>";
		  if(($tp[tujuan]=='MES') OR ($tp[tujuan]==''))
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
  		while($r=mysql_fetch_array($tampil))
                {
								                    if($r[destination]==$tp[tujuan])
										{
    		  echo "<option value=$r[destination] selected>$r[destinationdesc]</option>";
					}
					else
															{
    		  echo "<option value=$r[destination]>$r[destinationdesc]</option>";
					}
  		}
			if($_POST[airline]=='')
			{
			$air=$_GET[airline];
			}
			else
			{
			$air=$_POST[airline];
			}
  		echo "</select>
		</td></tr>
                <tr><td colspan=2><strong>Data diisikan sesuai Manifest kedatangan</strong></td></tr>
								<tr><td colspan=2>
								<input type=hidden name=airline value='$air'>								
								<input type=hidden name=k value='$_GET[k]'>
								<input type=hidden name=b value='$_GET[b]'>
								<input type=hidden name=a value='$_GET[a]'>																
								<input type=hidden name=idman value='$idmanifestin'>
								<input type=hidden name=idisiman value='$idisiman'>								
								<input type=hidden name=tglmanifest value='$tglman'>
								<input type=submit name=tombol value=\"Simpan\">
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
</td>
<td><B><CENTER>== DAFTAR ISI CARGO MANIFEST ==</B><BR>
( Total isi : ".$jmldata." items - ".$databerat[0]." Kg - ".$databerat[1]." Koli)</CENTER>";

	 echo "<table><tr><th>no</th>
	 <th>No.SMU</th><th>Koli</th><th>Berat</th>
	 <th>Tujuan</th>
				 <th>Action</th>
         </tr>";
	$tgl1=my2date($tgl);
	$tampil=mysql_query("SELECT * FROM breakdown,isimanifestin where breakdown.id_isimanifestin = isimanifestin.id_isimanifestin AND breakdown.id_manifestin='$idmanifestin' and breakdown.isvoid='0' ORDER BY id_breakdown DESC");

    	$no     = $posisi+1;
  	while ($r=mysql_fetch_array($tampil))
        {
        	if($r[status]=='MES'){$tuju='MES';}else {$tuju=$r[tujuan];}
     	   echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\"><td>$no</td>
          <td>$r[no_smu]</td><td align=center>$r[kolidatang]</td><td align=center>$r[beratdatang]</td><td align=center>$tuju</td><td align=center>";
					if(($r[status_check]=='waiting') AND ($r[b_iscancel]=='0')){ echo "<a href=?module=isimanifestindel&n=$r[id_isimanifestin]&b=$r[id_breakdown]&i=$_GET[i] title='klik untuk cancel SMU' onclick=\"javascript:return confirm('CANCEL hanya dilakukan pada SMU yang batal datang. Jika memang cancel, Anda harus melengkapi alasannya setelah ini.CANCEL hanya bisa dilakukan pada data SMU yang masih berstatus WAITING. Apakah Anda yakin data SMU ini dibatalkan ?')\"><img src=images/b_drop.png border=0 hspace=5></a>";
					
					
					/*echo "<a href=\"aksi.php?module=isimanifestin&act=hapus&i=$r[id_isimanifestin]&b=$r[id_breakdown]\" onclick=\"javascript:return confirm('Penghapusan data diperbolehkan dan tidak akan direkam karena SMU ini belum CONFIRM. Apakah Anda yakin SMU ini akan dihapus ?')\">
					<img src=images/b_drop.png border=0 alt=\"klik untuk menghapus\" title=\"klik untuk menghapus\"></a>
					*/
					echo "</td></tr>";
					}
     	  $no++;
  	}
        echo "</table>";

echo "</td></tr></table>
     </form>";


?>