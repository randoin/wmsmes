<SCRIPT LANGUAGE="JavaScript" src="cal2.js">
</script>
  <script language="javascript">
    addCalendar("Caritanggal","Tanggal","tglbtb","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
  </script>
  
<?php
$tglnya=date("d-m-Y");
?>
<h2>BUKTI TIMBANG BARANG</h2>
<form name="form1" method="POST" action="aksi.php?module=btb&act=input">
<B>INPUTKAN DATA SMU</B><BR>
	<table>
		<tr>
			<td>Airline</td>
       		<td> : <select name="airline">
                    <?php
           			$tampil=mysql_query("SELECT * FROM airline ORDER BY airlinecode ASC");
           			while($p=mysql_fetch_array($tampil))
           			{
    	     			$airline_code = $p['airlinecode'];
						$airline_name = $p['airlinename'];
						echo "<option value=\"$airline_code\">$airline_name</option>";
  	   				}
  					?>
					</select></td>
       	</tr>
       
       	<tr>
        	<td>Agent</td>
            <td> : <select name="agent">
           			<?php
           			$tampil=mysql_query("SELECT * FROM agent ORDER BY btb_agent");
           			while($p=mysql_fetch_array($tampil))
           			{
    	     			$btb_agent = $p['btb_agent'];
						echo "<option value=\"$btb_agent\">$btb_agent</option>";
  	   				}
  					?>
					</select></td>
		</tr>
        
		<tr>
        	<td>Tujuan</td>
            <td> : <select name="tujuan">
                    <?php
  	    	  		$tampil=mysql_query("SELECT * FROM destination ORDER BY dest_code DESC");
  		  			while($p=mysql_fetch_array($tampil))
                  	{
   		    			//$iddestination = $p['destination'];
						//$dest_code = $p['destinationdesc'];
						//echo "<option value=\"$destination\">$destination_desc</option>";
						echo "<option value='$p[dest_code]' selected='selected'> $p[dest_code] </option>";
					}
  	  				?>
					</select></td>
         </tr>
         	
         <tr>
         	<td>Jenis Barang</td>
            <td> : <select name=jenisbarang>
                    <?php
  		  			$tampil=mysql_query("SELECT * FROM typebarang ORDER BY typebarang ASC");
  		  			while($p=mysql_fetch_array($tampil))
                  	{
						$type_barang = $p['typebarang'];
						echo "<option value='$type_barang'>$type_barang</option>";
					}				
					?>
                    </select></td>
		</tr>	
         	
		<tr>
        	<td>No.SMU</td>
            <td> : <input type="text" onKeyDown="javascript:return dFilter (event.keyCode, this, '###-####-### #');" name="nosmu" size="20"/>
        </td>														
       	
        <tr>
        	<td>Tanggal BTB</td>
            <td> : <input type="text" onKeyDown="javascript:return dFilter (event.keyCode, this, '##-##-####');" name="tglbtb" size="20"
            		value=<?php echo $tglnya; ?>>
  				  <a href="javascript:showCal('Caritanggal')"><img src="images/calendar.png" border="0"></a>
  				  <input type="hidden" name="nosmubtb" value="<?php echo $_GET['n']; ?>">
                  <input type="hidden" name="id" value="<?php echo $_GET['d']; ?>"></td>
		</tr>
	
    	<tr>
        	<td colspan=2> *) Wajib Diisi</td>
        </tr>
  
		<tr>
        	<td colspan=2><input type="submit" value="Simpan dan Breakdown">
        	<input type="button" value="Batal" onclick="self.history.back()"></td>
       	</tr>
	</table><span class=error><?php echo $err; ?></span>
</form>