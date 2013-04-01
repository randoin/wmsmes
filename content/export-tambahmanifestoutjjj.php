<?php
?>
	
	<SCRIPT LANGUAGE="JavaScript" src="cal2.js">
    </script>
	<script language="javascript">
    addCalendar("Caritanggal","Date of Departure","etd","form1");
    setWidth(90, 1, 15, 1);
	setFormat("dd-mm-yyyy");
    </script>

			
  <? $tglnya=date("d-m-Y");
  echo "<h2>Tambah Cargo Manifest - Outbound</h2>
        <form name=form1 method=POST action='aksi.php?module=manifestout&act=input'>
        <table>
        <tr><td>Date</td>     <td> : <input type=text name=etd size=20 value='$tglnya'>";?>
		<a href="javascript:showCal('Caritanggal')"><img src="images/calendar.png" border="0"></a>
		<?
		echo "</td></tr>				
        <tr><td>Operator Airline</td>     <td> :
      	<select name=id_operatorairline>
        <option value=0 selected>- Pilih Airlines -</option>";
  		$tampil=mysql_query("SELECT * FROM operatorairline ORDER BY operatorairline");
  			while($r=mysql_fetch_array($tampil)){
    	echo "<option value=$r[id_operatorairline]>$r[operatorairline] ($r[kodeoperator])</option>";
  		}
  		echo "</select></td></tr>	   	
        <tr><td>Flight No.</td>     <td> : <input type=text name=noflight size=20></td></tr>	
        <tr><td>A/C Registration</td>     <td> : <input type=text name=acregistration size=20></td></tr>			
			
	    <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";

?>