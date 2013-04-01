<SCRIPT LANGUAGE="JavaScript" src="cal2.js">
</script>
<script language="javascript">
    addCalendar("Caritanggalawal","Tanggal","requireddate","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
</script>
<script language="javascript">
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
	</script>
<?

$r=mysql_fetch_array(mysql_query("select * from dolar where id='$_GET[id]'"));
  echo "<h2>EDIT DATA Kurs Dolar</h2>
        <form method=POST action='aksi.php?module=datadolar&act=edit' 
		onSubmit=\"return checkrequired(this)\">
        <table>
        <tr><td>Tanggal</td>     <td> : <input type=text name=requireddate 
		autocomplete=off readonly=true value=".ymd2dmy($r[tgl])."></td></tr>
        <tr><td>Rupiah/USD</td>     <td> : <input type=text name=requireddolar size=30 
		onkeypress=\"return isNumberKey(event)\"  
		autocomplete=off value=\"$r[dolar]\"> *</td></tr>
<tr><td>CL</td>     <td> : <input type=text name=cl size=30 
		onkeypress=\"return isNumberKey(event)\"  
		autocomplete=off value=\"$r[cl]\"> *</td></tr>
<tr><td>HND</td>     <td> : <input type=text name=hnd size=30 
		onkeypress=\"return isNumberKey(event)\"  
		autocomplete=off value=\"$r[hnd]\"> *</td></tr>
<tr><td>DOC</td>     <td> : <input type=text name=doc size=30 
		onkeypress=\"return isNumberKey(event)\"  
		autocomplete=off value=\"$r[doc]\"> *</td></tr>
<tr><td>Ex GA</td>     <td> : ";
if($r[exga]=='on'){ echo "<input type=checkbox name=exga checked disabled";}
else { echo "<input type=checkbox name=exga disabled>";}
echo "</td></tr>
		        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()>
		<input type=hidden name=id value='$_GET[id]'>
		</td></tr>
        </table>
        </form>";

?>