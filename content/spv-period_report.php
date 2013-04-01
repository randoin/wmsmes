<?php
  ?>
  <SCRIPT LANGUAGE="JavaScript" src="cal2.js">
  </script>
  <script language="javascript">
    addCalendar("Caritanggalawal","Tanggal","tglawal","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
  </script>
  <script language="javascript">
    addCalendar("Caritanggalakhir","Tanggal","tglakhir","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
  </script>
	
  <?
	$tglsekarang=date("Y-m-d");
$today=ymd2dmy($tglsekarang);

	echo "<h2>After Manifest Reporting</h2>
				<form name=form1 method=POST action='aksi.php?module=period_cargo'>
				<table>
				<tr><td>Tanggal Awal </td><td>: <input type=text onKeyDown=\"javascript:return dFilter (event.keyCode, this, '##-##-####');\" name=tglawal value='$today'>"; 
				 ?>
  <a href="javascript:showCal('Caritanggalawal')"><img src="images/calendar.png" border="0"></a>
  <?
	echo "</td></tr>
				<tr><td>Tanggal Akhir </td><td>: <input type=text onKeyDown=\"javascript:return dFilter (event.keyCode, this, '##-##-####');\" name=tglakhir value='$today'>"; 
				 ?>
  <a href="javascript:showCal('Caritanggalakhir')"><img src="images/calendar.png" border="0"></a>
  <?
	echo "</td></tr>
	
				<tr><td>Proses  </td><td>: 
					<select name=outin>
<option value='SEMUA'>SEMUA</option>
				 <option value='IMPORT'>IMPORT</option>
				<option value='EXPORT'>EXPORT</option>
					 <option value='TRANSIT'>TRANSIT</option>		 
					</select>
				</td></tr>
				<tr><td>Airline  </td><td>: 
					<select name=airline>
					 <option value='SEMUA'>SEMUA</option>
";
	$data=mysql_query("select c.customer from customer as c
					order by c.customer ASC");
					while($r=mysql_fetch_array($data))
					{
						echo "<option value=$r[customer]>$r[customer]</option>";
					}
					echo "</select>
				</td></tr>		

				<tr><td colspan=2>
				<input type=submit value=\"Preview\" name=bt_preview>
				<input type=submit value=\"Per Airport\" name=bt_preview>
				</td> 	
											
				</table>
        </form>";

?>