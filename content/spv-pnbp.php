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

	echo "<h2>REKAPITULASI PEMBAYARAN PNBP</h2>
				<form name=form1 method=POST action='aksi.php?module=pnbp'>
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
	

				<tr><td>Airline  </td><td>: <input type=text name=airline onkeyup=\"javascript:this.value=this.value.toUpperCase();\"><i> contoh : GA</i>
				</td></tr>	
				<tr><td>Batas Margin Bawah </td><td>: <input type=text name=margin value=10>
				</td></tr>	
				<tr><td colspan=2>
				<input type=submit value=\"Preview\" name=bt_preview>
				</td> 	
											
				</table>
        </form>";

?>