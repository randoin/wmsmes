<?php
  
  <SCRIPT LANGUAGE="JavaScript" src="cal2.js">
  </script>
  <script language="javascript">
    addCalendar("Caritanggal","Tanggal","tglmanifest","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
  </script>
  <?

//$tampil=mysql_query("SELECT * FROM manifestin where isvoid='0' AND id_manifestin='$_GET[i]' ");
$tampil=mysql_query("SELECT * FROM manifestin where isvoid='0' AND id_manifestin='$_GET[i]' ");
$r=mysql_fetch_array($tampil);
echo "<h2>CARGO MANIFEST import - EDITING</h2>
			<form name=form1 method=POST action=aksi.php?module=manifestin&act=edit>
			<table><tr><td><B>EDIT DATA HEADER MANIFEST</B><BR><table><tr>
      <td>Airline</td><td> :
      <select name=airline>";
$tampil1=mysql_query("SELECT * FROM airline ORDER BY airlinecode");
while($p=mysql_fetch_array($tampil1))
{
	if($p[airlinecode]==$r[airline])
		echo "<option value='$p[airlinecode]' selected>$p[airlinename]</option>";
 	else 
		echo "<option value='$p[airlinecode]'>$p[airlinename]</option>";
	}
echo "</select></td></tr><tr><td>A/C Registration</td>     
			<td> : <input type=text size=30 name=acregistration value='$r[acregistration]'
			onChange=\"javascript:this.value=this.value.toUpperCase();\"></td></tr>
			<tr><td>Flight No</td>     <td> : <input type=text size=30 name=noflight
			value='$r[noflight]' onChange=\"javascript:this.value=this.value.toUpperCase();\"></td></tr>
			<tr><td>Tanggal Manifest</td>     <td> : <input type=text 
			onKeyDown=\"javascript:return dFilter (event.keyCode, this, '##-##-####');\" 
			name=tglmanifest size=20 value=".ymd2dmy($r[tglmanifest])." readonly>";
?>
<a href="javascript:showCal('Caritanggal')"><img src="images/calendar.png" border="0"></a>
  <?
if($r[nil]=='on') {$n='checked=checked';
  echo "
           </td></tr><tr><td align=right>NIL ?</td>     
			 <td> : <input type=checkbox name=nil $n/> (check for NIL)</td></tr>
       	  <tr><td>Asal Airport(NIL)</td><td> :
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


          <tr><td>Status(NIL)</td><td>";
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
		</td></tr>";	} else {$n='';
		  echo "
           </td></tr><tr><td align=right>NIL ?</td>     
			 <td> : <input type=checkbox name=nil $n/> (check for NIL)</td></tr>";
       	  
		
		}

		 
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 echo "<input type=hidden name=i value='$_GET[i]'></td></tr>
				<td colspan=2><strong><center>*) wajib diisi, jika kosong maka data tidak akan 
				tersimpan.</strong></center></td></tr>	
				<tr><td colspan=2><input type=submit value='UPDATE'>
				<input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>";

?>