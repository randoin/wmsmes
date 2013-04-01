<?php
	if($_GET['p']=='e')
  	{
    	$err='Data Manifest Sudah Ada';
		}

  ?>
  <SCRIPT LANGUAGE="JavaScript" src="cal2.js">
  </script>
  <script language="javascript">
    addCalendar("Caritanggal","Tanggal","tglmanifest","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
  </script>
  <?
		$tampil=mysql_query("SELECT * FROM manifestout where isvoid='0' AND id_manifestout='$_GET[i]' ");
    $r=mysql_fetch_array($tampil);

if($r[nil]=='on') {$n='checked=checked';} else {$n='';}
		
		

  echo "<h2>CARGO MANIFEST export - EDITING</h2>
       <form name=form1 method=POST action=aksi.php?module=manifestout&act=edit>
       <table><tr><td>
			  <B>EDIT DATA HEADER MANIFEST</B><BR>
       <table>
       <tr>
       <td>Airline</td>     <td> :
       <select name=airline>";
           $tampil1=mysql_query("SELECT * FROM airline ORDER BY airlinecode");
  				 while($p=mysql_fetch_array($tampil1))
           	{
							if($p[airlinecode]==$r[airline])
							{
    	     		echo "<option value='$p[airlinecode]' selected>$p[airlinename]</option>";
							}
							else echo "<option value='$p[airlinecode]'>$p[airlinename]</option>";
							
  	   			}
  echo "</select></td></tr>
       <tr><td>A/C Registration</td>     <td> : <input type=text size=30 name=acregistration value='$r[acregistration]' autocomplete=off  onChange=\"javascript:this.value=this.value.toUpperCase();\">*
       <tr><td>Flight No</td>     <td> : <input type=text size=30 name=noflight value='$r[noflight]' autocomplete=off  onChange=\"javascript:this.value=this.value.toUpperCase();\">*
       <tr><td>Tanggal Manifest</td>     <td> : <input type=text name=tglmanifest size=20 value=".ymd2dmy($r[tglmanifest])." readonly>*";
  ?>
  <a href="javascript:showCal('Caritanggal')"><img src="images/calendar.png" border="0"></a>
  <?
	 echo "
           </td></tr><tr><td align=right>NIL ?</td>     
			 <td> : <input type=checkbox name=nil $n/> (check for NIL)</td></tr>
<input type=hidden name=i value='$_GET[i]'></td></tr>
	<tr><td colspan=2><input type=submit value='UPDATE'>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>";

?>