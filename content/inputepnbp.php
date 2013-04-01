<SCRIPT LANGUAGE="JavaScript" src="cal2.js">
</script>
<script language="javascript">
    addCalendar("Caritanggalawal","Tanggal","requireddate","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
</script>
	<script language="javascript">
jQuery(function($){
   $("#tgl").mask("99/99/9999"), 
   $("#nomor").mask("999999")              
               
}) </script>
<?
$r=mysql_fetch_array(mysql_query("select tglpnbp,nomorpnbp from manifestin where idmanifestin='$_GET[idm]' "));
$tgl=ymd2dmy($r[tglpnbp]);
		echo "<h2>PNBP</h2>
        <form method=POST id=form1 action='aksi.php?module=carimanifestimport&act=pnbpconfirm' 	onSubmit=\"return checkrequired(this)\">
        <table>
        <tr><td>Nomor</td>     <td> : <input type=text id=nomor name=requirednomor size=10 value=\"$r[nomorpnbp]\"></td></tr>
        <tr><td>Tanggal Setor</td>     <td> : <input type=text id=tgl name=requireddate 
		autocomplete=off value=\"$tgl\"> * ";
			 ?>
  <a href="javascript:showCal('Caritanggalawal')"><img src="images/calendar.png" border="0"></a>
  <?
		echo "</td></tr>
	<tr><td colspan=2><input type=submit value=SAVE></td></tr>
	</table>
<input type=hidden name=idm value='$_GET[idm]'>
	<input type=hidden name=d value=$_GET[d]>
	</form>";	
?>
