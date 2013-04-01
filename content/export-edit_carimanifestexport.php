<SCRIPT LANGUAGE="JavaScript" src="cal2.js">
</script>
<script language="javascript">
    addCalendar("Caritanggalawal","Tanggal","tglawal","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
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
  
	
<h2>Editing Manifest Export</h2>
<?php
	echo $tgl=date('Y-m-d');	
	echo $cekadasmu=mysql_num_rows(mysql_query("select i.idmastersmu from manifestout as m, isimanifestout as i 
		 WHERE i.idmanifestout=m.idmanifestout AND m.statusvoid='0' AND i.statusvoid='0' AND m.idmanifestout='$_GET[idm]'"));
	echo $sql=mysql_fetch_array(mysql_query("select * from manifestout where idmanifestout='$_GET[idm]'"));
?>

<form name='form1' method='POST' action="aksi.php?module=manifestexport&act=edit" onSubmit="return checkrequired(this)"\>
	<table>
		<tr>
           	<td>FLIGHT DATE</td>
			<td>: <input type="text" onKeyDown="javascript:return dFilter (event.keyCode, this,'##-##-####');" name="tglawal"
            	   value="<?php echo $sql['flightdate']; ?>"> 
				  <a href="javascript:showCal('Caritanggalawal')"><img src="images/calendar.png" border="0"></a></td>
        </tr>
		
        <tr>
        	<td>ETD</td>
			<td>: <input type="text" onKeyDown="javascript:return dFilter (event.keyCode, this,'##:##:##');" name="etd"
            	   value="<?php echo $sql['etd']; ?>"> (hours:minutes:second)</td>
        </tr> 
        
        <tr>
        	<td>FLIGHT NUMBER</td>
            <td> : <select name="flight">
            	<?php	
					echo $tampil=mysql_query("SELECT f.idflight,f.flight,c.cus_desc,c.bendera FROM flight as f,customer as c 
					WHERE f.idcustomer = c.idcustomer order by f.flight ASC");
        			while($r=mysql_fetch_array($tampil))
					{
						if($r[idflight]==$sql[idflight])
							{
								echo "<option value=$r[idflight] selected>$r[flight]-$r[cus_desc] / Bendera : $r[bendera]</option>";
							}
						else
							{
								echo "<option value=$r[idflight]>$r[flight]-$r[cus_desc] / Bendera : $r[bendera]</option>";				
							}
					}
				?>
			</select></td>
        </tr>
        
        <tr>
        	<td>ORIGIN</td>
            <td> : <select name="origin">
            	<?php	
					echo $tampil=mysql_query("SELECT o.idorigin,o.origin_code,r.region,r.dest_desc FROM origin as o, region as r
					WHERE o.idregion=r.idregion order by o.origin_code ASC");
        			while($r=mysql_fetch_array($tampil))
					{
						if($r[idorigin]==$sql[idorigin])
							{
								echo "<option value='$r[idorigin]' selected>$r[origin_code] / Region : $r[region] ($r[dest_desc])</option>";
							}
						else
							{
								echo "<option value='$r[idorigin]'>$r[origin_code] / Region : $r[region] ($r[dest_desc])</option>";
							}
    	 			}
				?>
			</select></td>
        </tr>
        
        <tr>
        	<td>DESTINATION 1</td>
            <td> : <select name="destination">
            	<?php	
					echo $tampil=mysql_query("SELECT d.iddestination,d.dest_code,r.region,r.dest_desc FROM destination as d, region as r
					WHERE d.idregion=r.idregion order by d.dest_code ASC");
        			while($r=mysql_fetch_array($tampil))
					{
						if($r[iddestination]==$sql[iddestination])
							{
								echo "<option value='$r[iddestination]' selected>$r[dest_code] / Region : $r[region] ($r[dest_desc])</option>";
							}
						else
							{
								echo "<option value='$r[iddestination]'>$r[dest_code] / Region : $r[region] ($r[dest_desc])</option>";			}			
					}
				?>
			</select></td>
        </tr>	
        
        <tr>
        	<td>DESTINATION 2</td>
            <td> : <select name="destination2">
            	<?php	
					echo $tampil=mysql_query("SELECT d.iddestination,d.dest_code,r.region,r.dest_desc FROM destination as d, region as r
					WHERE d.idregion=r.idregion order by d.dest_code ASC");
					if($sql[iddestination2]=='0')
						{
							echo "<option value=0 selected>none</option>";	
							while($r=mysql_fetch_array($tampil))
								{
									echo "<option value='$r[iddestination]'>$r[dest_code] / Region : $r[region] ($r[dest_desc])</option>";
								}
						}
					else
						{
							echo "<option value=0>none</option>";	
        					while($r=mysql_fetch_array($tampil))
								{
									if($r[iddestination]==$sql[iddestination2])
										{
											echo "<option value='$r[iddestination]' selected>$r[dest_code] / Region : $r[region] ($r[dest_desc])</option>";
										}
									else
										{
											echo "<option value='$r[iddestination]'>$r[dest_code] / Region : $r[region] ($r[dest_desc])</option>";
										}			
								}
						}
				?>
			</select></td>
        </tr>	
        
        <tr>
        	<td>A/C REGISTER</td>
            <td> : <input type="text" size="5" name="requiredacregister" onChange="javascript:this.value=this.value.toUpperCase();" autocomplete="off"
            		value="<?php echo $sql['acregister']; ?>"> *</td>
        </tr>
        
        <tr>
        	<td>POINT OF LOADING</td>
            <td> : <input type="text" size="20" name="requiredpointofloading" value="<?php echo $sql['pointofloading']; ?>"
            		onChange="javascript:this.value=this.value.toUpperCase();" autocomplete="off"> *</td>
        </tr>
        
        <tr>
        	<td>POINT U/L</td>
            <td> : <input type="text" size="20" name="requiredpointul"  value="<?php echo $sql['pointul']; ?>"
            		onChange="javascript:this.value=this.value.toUpperCase();" autocomplete="off"> *</td>
        </tr>
		<?php	
        //cek, kalau sdh ada smu didalamnya,tida boleh nil !
		if($cekadasmu<=0)
			{
				echo "<tr>
						<td>Status NIL</td>
						<td> :";
							if($sql[statusnil]=='on')
								{
									echo "<input type=checkbox size=5 name=statusnil checked>";
								}
							else
								{
									echo "<input type=checkbox size=5 name=statusnil>";			
								}
									echo "
						</td>
					  </tr>";
			}
		?>		
		<tr>
        	<td colspan="2"> *) wajib diisi, data kosong atau duplikasi/double ID kunci, tidak akan tersimpan.</td>
        </tr> 
        
        <tr>
        	<td colspan="2">
			<input type="submit" value="Simpan"><input type="hidden" name="idm" value='$_GET[idm]'
        	<input type="button" value="Batal" onclick="self.history.back()"></td>
        </tr>
		
	</table>
</form>