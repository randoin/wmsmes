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
$hrg=mysql_fetch_array(mysql_query("select * from hargapnbp order by id DESC limit 1"));
  echo "<h2>UPDATE DATA PNBP</h2>
        <form method=POST name=form1 id=form1 action='aksi.php?module=datapnbp&act=tambah' 
		onSubmit=\"return checkrequired(this)\">
        <table>
         <tr><td>Jumlah Patokan</td>     <td> : <input type=text name=requiredpatokan size=30 
		onkeypress=\"return isNumberKey(event)\"  
		autocomplete=off value=$hrg[jml1]> *</td></tr>
<tr><td>Harga Bawah/Sama</td>     <td> : <input type=text name=bawah size=30 
		onkeypress=\"return isNumberKey(event)\"  
		autocomplete=off value=\"$hrg[hargajml1]\"></td></tr>
		<tr><td>Harga Atas</td>     <td> : <input type=text name=atas size=30 
		onkeypress=\"return isNumberKey(event)\"  
		autocomplete=off value=\"$hrg[hargajml2]\"></td></tr>
			        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";

?>