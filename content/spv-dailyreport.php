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

	echo "<h2>Daily Report</h2>
				<form name=form1 method=POST action='aksi.php?module=daily_cargo'>
				<table>
				<tr><td>Tanggal  </td><td>: <input type=text onKeyDown=\"javascript:return dFilter (event.keyCode, this, '##-##-####');\" name=tglawal value='$today'>"; 
				 ?>
  <a href="javascript:showCal('Caritanggalawal')"><img src="images/calendar.png" border="0"></a>
  <? 
/*
					 <option value='SEMUA'>SEMUA</option>					
					 <option value='EXPORT'>EXPORT</option>
					 <option value='import'>IMPORT</option>
					 <option value='TRANSIT'>TRANSIT</option>			
*/  echo "
				<tr><td>Proses  </td><td>: 
					<select name=outin>
					 <option value='IMPORT'>IMPORT</option>
						<option value='EXPORT'>EXPORT</option>
					 <option value='TRANSIT'>TRANSIT</option>			 
					</select>
				</td></tr>


				<tr><td colspan=2>
				<input type=submit value=\"Preview\" name=bt_preview>
				</td> 	
											
				</table>
        </form>";

?>