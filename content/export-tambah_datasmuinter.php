<SCRIPT language=Javascript>
	//Convert array into object
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
  </SCRIPT>
<?
  echo "<h2>TAMBAH DATA AWB INTERNATIONAL</h2>
        <form method=POST action='aksi.php?module=datasmuinter&act=tambah' 
		onSubmit=\"return checkrequired(this)\">
        <table>
        <tr><td>AWB</td>     <td> : <input type=text maxlength=11 name=requiredawb
		 onkeypress=\"return isNumberKey(event)\"
		autocomplete=off> * ex : 11122223333 (tanpa tanda minus atau spasi, max 11 angka)</td></tr>
        <tr><td>COMMODITY</td><td> : <select name=commodity>";
		$tampil=mysql_query("SELECT * FROM commodity_ap ORDER BY commodityap ASC");
        while($r=mysql_fetch_array($tampil))
		{
    	 echo "<option value='$r[idcommodityap]'>$r[commodityap] / $r[comm_code]</option>";
		}
		echo "</select></td></tr>
        <tr><td>ORIGIN</td><td> : <select name=origin>";
		$tampil=mysql_query("SELECT * FROM origin ORDER BY origin_code ASC");
        while($r=mysql_fetch_array($tampil))
		{
    	 echo "<option value='$r[idorigin]'>$r[origin_code] / Region : $r[region]</option>";
		}
		echo "</select></td></tr>
        <tr><td>DESTINATION</td><td> : <select name=destination>";
		$tampil=mysql_query("SELECT * FROM destination ORDER BY dest_code ASC");
        while($r=mysql_fetch_array($tampil))
		{
    	 echo "<option value='$r[iddestination]'>$r[dest_code] / Region : $r[region]</option>";
		}
		echo "</select></td></tr>	
        <tr><td>Weight (Kg)</td>     <td> : <input type=text maxlength=5 name=requiredkg
		 onkeypress=\"return isNumberKey(event)\"
		autocomplete=off> *
        <tr><td>Collies</td>     <td> : <input type=text maxlength=5 name=requiredkoli
		 onkeypress=\"return isNumberKey(event)\"
		autocomplete=off> *		
        <tr><td>Consignee</td>     <td> : <input type=text maxlength=5 name=requiredkg
		 onkeypress=\"return isNumberKey(event)\"
		autocomplete=off> *
        <tr><td>Shipper</td>     <td> : <input type=text maxlength=5 name=requiredkoli
		 onkeypress=\"return isNumberKey(event)\"
		autocomplete=off> *	
        <tr><td>AGENT</td><td> : <select name=agent>
		<option value='0'>none</option>";
		$tampil=mysql_query("SELECT * FROM agent ORDER BY agent ASC");
        while($r=mysql_fetch_array($tampil))
		{
    	 echo "<option value='$r[idagent]'>$r[agent]</option>";
		}
		echo "</select></td></tr>								
		
		<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, 
		tidak akan tersimpan.</td></tr> 
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";
?>