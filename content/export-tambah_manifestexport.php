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
  

	<h2>Tambah Manifest Export</h2>
        <form name="form1" method="POST" action="aksi.php?module=manifestexport&act=tambah" onSubmit="return checkrequired(this)"\>
        <table>
			<tr>
            	<td>FLIGHT DATE</td>
				<td>: <input type="text" onKeyDown="javascript:return dFilter (event.keyCode, this,'##-##-####');" name="tglawal" value="<?php echo ($tgl=date('Y-m-d')); ?>">
  					  <a href="javascript:showCal('Caritanggalawal')"><img src="images/calendar.png" border="0"></a></td>
            </tr>
		
        	<tr>
            	<td>ETD</td>
				<td>: <input type="text" onKeyDown="javascript:return dFilter (event.keyCode, this,'##:##:##');" name="etd" value='00:00:00'> (hours:minutes:second)</td>
            </tr> 
        
        	<tr>
            	<td>FLIGHT NUMBER</td>
                <td> : <select name="flight">
					<?php
                       	echo $tampil=mysql_query("SELECT f.idflight,f.flight,c.cus_desc,c.bendera FROM flight as f,customer as c 
						WHERE f.idcustomer = c.idcustomer order by flight");
        				while($r=mysql_fetch_array($tampil))
						{
							if($r['flight'] == 'GA343')
								{
				     				echo "<option value=$r[idflight] select>$r[flight]-$r[cus_desc] / Bendera : $r[bendera]</option>";
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
							if($r['origin_code']=='MES')
								{
									echo "<option value='$r[idorigin]' select>$r[origin_code] / Region : $r[region] ($r[dest_desc])</option>";
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
                <td> : <select name='destination'>
                	<?php	
						echo $tampil=mysql_query("SELECT d.iddestination,d.dest_code,r.region,r.dest_desc FROM destination as d, region as r
						WHERE d.idregion=r.idregion order by d.dest_code ASC");
        				while($r=mysql_fetch_array($tampil))
						{
    	 					echo "<option value='$r[iddestination]'>$r[dest_code] / Region : $r[region] ($r[dest_desc])</option>";
						}
					?>
				</select></td>
			</tr>	
        
        	<tr>
            	<td>DESTINATION 2</td>
                <td> : <select name='destination2'>
                	   <option value='0'>none</option>
					<?php	
						echo $tampil=mysql_query("SELECT d.iddestination,d.dest_code,r.region,r.dest_desc FROM destination as d, region as r
						WHERE d.idregion=r.idregion order by d.dest_code ASC");
        				while($r=mysql_fetch_array($tampil))
						{
    	 					echo "<option value='$r[iddestination]'>$r[dest_code] / Region : $r[region] ($r[dest_desc])</option>";
						}
					?>
				</select></td>
			</tr>	
            
        	<tr>
            	<td>A/C REGISTER</td>
                <td> : <input type='text' size='5' name='requiredacregister' onChange="javascript:this.value=this.value.toUpperCase();" autocomplete='off'> *</td>
            </tr>
        
        	<tr>
            	<td>POINT OF LOADING</td>
                <td> : <input type='text' size='20' name='requiredpointofloading' value='DENPASAR' onChange="javascript:this.value=this.value.toUpperCase();" autocomplete='off'> *	</td>
            </tr>
        
        	<tr>
            	<td>POINT U/L</td>
                <td> : <input type='text' size='20' name='requiredpointul'  value='AS BELOW' onChange="javascript:this.value=this.value.toUpperCase();" 
						autocomplete='off'> *</td>
            </tr>
        
        	<tr>
            	<td>Status NIL</td>
                <td> : <input type='checkbox' size='5' name='statusnil' autocomplete='off'></td>
            </tr>	
            	
			<tr>
            	<td colspan='2'> *) wajib diisi, data kosong atau duplikasi/double ID kunci, tidak akan tersimpan.</td>
            </tr> 
            
        	<tr>
            	<td colspan='2'>
				<input type='submit' value='Simpan'>
        		<input type='button' value='Batal' onclick='self.history.back()'></td>
            </tr>
		</table>
	</form>