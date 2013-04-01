<SCRIPT LANGUAGE="JavaScript" src="cal2.js"></script>
  <script language="javascript">
    addCalendar("Caritanggalawal","Tanggal","tglawal","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
  </script>
  <script language="javascript">
    addCalendar("Caritanggalawal2","Tanggal","tglawal","form2");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
  </script>
  <script language="javascript">
    addCalendar("Caritanggalawal3","Tanggal","tglawal","form3");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
  </script>	
  
<?
	$tglsekarang=date("Y-m-d");
	$today=ymd2dmy($tglsekarang);
	echo "<h2>Daily Report</h2>
				<table><tr><td><form name=form1 method=POST action='aksi.php?module=dailyreport'>
				<table>
				<tr><td>Tanggal </td><td>: <input type=text name=tglawal value='$today'>"; 
?>
  <a href="javascript:showCal('Caritanggalawal')"><img src="images/calendar.png" border="0"></a>
<?
	echo "</td></tr>
			<tr><td>Airline  </td><td>: 
	      <select name=airline>
				<option value='' selected>*</option>";
        $tampil=mysql_query("SELECT * FROM airline ORDER BY airlinecode");
         while($r=mysql_fetch_array($tampil))
				{
    	    echo "<option value='$r[airlinecode]'>$r[airlinename]</option>";
				}
  echo "</select>
				</td></tr>
				<tr><td>Proses </td><td>: 
				<select name=outin>
				<option value='0' selected>import</option>
				<option value='1'>export</option>
				</select>
				</td></tr>
				<tr><td>Jenis Pembayaran  </td><td>: 
					<select name=cara_bayar>
					 <option value=''>*</option>
					 <option value='CASH' selected>CASH</option>
					 <option value='PERIODICAL'>PERIODICAL</option>
					</select>
				</td></tr>		
				<tr><td>Untuk  </td><td>: 
					<select name=untuk>
					 <option value='gp' selected>Internal GAPURA</option>
					 <option value='ap'>Angkasa Pura</option>
					</select>
				</td></tr>
		
				<tr><td colspan=2 align=center><input type=submit value='CETAK Per Airline Per SMU' name=pilih></td> 								
				</table>
        </form></td><td><form name=form2 method=POST action='aksi.php?module=dailyreport'>
				<table>
				<tr><td>Tanggal </td><td>: <input type=text name=tglawal value='$today'>"; 
?>
  <a href="javascript:showCal('Caritanggalawal2')"><img src="images/calendar.png" border="0"></a>
<?
	echo "</td></tr>
			<tr><td>Airline  </td><td>: 
	      <select name=airline>
				<option value='' selected>*</option>";
        $tampil=mysql_query("SELECT * FROM airline ORDER BY airlinecode");
         while($r=mysql_fetch_array($tampil))
				{
    	    echo "<option value='$r[airlinecode]'>$r[airlinename]</option>";
				}
  echo "</select>
				</td></tr>
				<tr><td>Proses </td><td>: 
				<select name=outin>
 	 		  <option value=''>*</option>				
				<option value='0' selected>import</option>
				<option value='1'>export</option>
				</select>
				</td></tr>
				<tr><td>Jenis Pembayaran  </td><td>: 
					<select name=cara_bayar>
					 <option value=''>*</option>
					 <option value='CASH' selected>CASH</option>
					 <option value='PERIODICAL'>PERIODICAL</option>
					</select>
				</td></tr>		
				<tr><td>Untuk  </td><td>: 
					<select name=untuk>
					 <option value='gp' selected>Internal GAPURA</option>
					 <option value='ap'>Angkasa Pura</option>
					</select>
				</td></tr>
		
				<tr><td colspan=2 align=center><input type=submit value='CETAK Per Airline Per Komoditi' name=pilih></td> 								
				</table>
        </form></td><td><form name=form3 method=POST action='aksi.php?module=dailyreport'>
				<table>
				<tr><td>Tanggal </td><td>: <input type=text name=tglawal value='$today'>"; 
?>
  <a href="javascript:showCal('Caritanggalawal3')"><img src="images/calendar.png" border="0"></a>
<?
	echo "</td></tr>
				<tr><td>Agent</td><td>: 
	      <select name=agent>
				<option value='' selected>*</option>";
        $tampil=mysql_query("SELECT * FROM btb_agent ORDER BY btb_agent");
         while($r=mysql_fetch_array($tampil))
				{
    	    echo "<option value='$r[btb_agent]'>$r[btb_agent]</option>";
				}
	
	echo"			</td></tr>
				<tr><td>Proses </td><td>: 
				<select name=outin>
 	 		  <option value=''>*</option>				
				<option value='0' selected>import</option>
				<option value='1'>export</option>
				</select>
				</td></tr>
				<tr><td>Jenis Pembayaran  </td><td>: 
					<select name=cara_bayar>
					 <option value=''>*</option>
					 <option value='CASH' selected>CASH</option>
					 <option value='PERIODICAL'>PERIODICAL</option>
					</select>
				</td></tr>		
				<tr><td>Untuk  </td><td>: 
					<select name=untuk>
					 <option value='gp' selected>Internal GAPURA</option>
					 <option value='ap'>Angkasa Pura</option>
					</select>
				</td></tr>
		
				<tr><td colspan=2 align=center><input type=submit value='CETAK Per Agent Per Komoditi' name=pilih></td> 								
				</table>
        </form></td></tr></table>";
	

?>