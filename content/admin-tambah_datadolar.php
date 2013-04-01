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
    
<?php
$hrg=mysql_fetch_array(mysql_query("select * from dolar order by id DESC limit 1"));
  echo "<h2>TAMBAH DATA KURS DOLAR</h2>
        <form method=POST name=form1 id=form1 action='aksi.php?module=datadolar&act=tambah' 
		onSubmit=\"return checkrequired(this)\">
        <table>
        <tr><td>Tanggal</td>     <td> : <input type=text name=requireddate 
		autocomplete=off readonly=true> * ";
			 ?>
  <a href="javascript:showCal('Caritanggalawal')"><img src="images/calendar.png" border="0"></a>
  <?
		echo "</td></tr>
        <tr><td>Rupiah/USD</td>     <td> : <input type=text name=requireddolar size=30 
		onkeypress=\"return isNumberKey(event)\"  
		autocomplete=off value=$hrg[dolar]> *</td></tr>
<tr><td>CL/WH</td>     <td> : <input type=text name=cl size=30 
		onkeypress=\"return isNumberKey(event)\"  
		autocomplete=off value=\"$hrg[cl]\"> berlaku sebagai W/H Charge utk EX-GA</td></tr>
<tr><td>HND/Admin</td>     <td> : <input type=text name=hnd size=30 
		onkeypress=\"return isNumberKey(event)\"  
		autocomplete=off value=\"$hrg[hnd]\">   berlaku sebagai Admin utk EX-GA</td></tr>
<tr><td>DOC</td>     <td> : <input type=text name=doc size=30 
		onkeypress=\"return isNumberKey(event)\"  
		autocomplete=off value=\"$hrg[doc]\"></td></tr>
<tr><td>Ex GA</td>     <td> : <input type=checkbox name=exga></td></tr>
		        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";

?>