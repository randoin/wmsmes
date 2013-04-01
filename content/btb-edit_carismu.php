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
	
function cekdulu() 
{
	var baca=document.form1.commodity.value;
	valid=true;
	
		
	if(baca!="18")
	{
	if ((document.form1.requiredawb.value.length<11) || (document.form1.requiredawb.value.length>11))
	  {
          alert("Batas penomoran AWB 11 digit!");
		valid=false;
		}
	} 
   	else if (document.form1.requiredkoli.value=="")
	{
		alert("Jumlah koli tidak boleh kosong");
		valid=false;
	}
   	else if (document.form1.requiredkg.value=="")
	{
		alert("Berat KG tidak boleh kosong");
		valid=false;
	}	
	return valid;
}
</SCRIPT>

<?php
$tgl=date('Y-m-d');	
$sql=mysql_fetch_array(mysql_query("select * from master_smu where idmastersmu='$_GET[ids]'"));
		if($sql[idcommodityap]=='18')
		{
			$noawb=format_nopos($sql[nosmu]);
			echo "<h2>Editing AWB # $noawb</h2>
			<form name=form1 method=POST action='aksi.php?module=awbtoday&act=edit' 
			onsubmit=\"return cekdulu();\">
			<table>
			<input type=hidden name=requiredawb value='$sql[nosmu]'> 
			<input type=hidden name=commodity value='18'> ";
		 }
		else
		{
			
			echo "<h2>Editing AWB</h2>
			<form name=form1 method=POST action='aksi.php?module=awbtoday&act=edit' 
			onsubmit=\"return cekdulu();\">
			<table>
			<tr><td>AWB</td>     <td> : <input type=text name=requiredawb 
			onkeypress=\"return isNumberKey(event)\" autocomplete=off value='$sql[nosmu]'> 
			* ex : 11122223333 (tanpa tanda minus atau spasi, 11 digit!)</td></tr>
        <tr><td>COMMODITY</td><td> : <select name=commodity>";
		$tampil=mysql_query("SELECT a.idcommodityap,a.commodityap,c.commodity FROM commodity_ap as a, 
		commodity as c WHERE a.idcommodity=c.idcommodity AND a.idcommodityap<>'18' ORDER BY a.commodityap ASC");
        while($r=mysql_fetch_array($tampil))
		{
			if($sql[idcommodityap]==$r[idcommodityap])
			{
				echo "<option value='$r[idcommodityap]' selected>$r[commodityap] ($r[commodity])</option>";
			}
			else
			{
				echo "<option value='$r[idcommodityap]'>$r[commodityap] ($r[commodity])</option>";
			}
		 }
		echo "</select></td></tr>";
		}
  
       echo " <tr><td>ORIGIN</td><td> : <select name=origin>";
		$tampil=mysql_query("SELECT o.idorigin,o.origin_code,r.region,r.dest_desc FROM 
		origin as o, region as r WHERE o.idregion=r.idregion order by o.origin_code ASC");
        while($r=mysql_fetch_array($tampil))
		{
			if($sql[idorigin]==$r[idorigin])
			{
				echo "<option value='$r[idorigin]' selected>$r[origin_code] / Region : $r[region] ($r[dest_desc])</option>";
			}
			else
			{
				echo "<option value='$r[idorigin]'>$r[origin_code] / Region : $r[region] ($r[dest_desc])</option>";
			}			
    	 
		}
		echo "</select></td></tr>
        <tr><td>DESTINATION</td><td> : <select name=destination>";
		$tampil=mysql_query("SELECT d.iddestination,d.dest_code,r.region,r.dest_desc FROM 
		destination as d, region as r WHERE d.idregion=r.idregion order by d.dest_code ASC");
        while($r=mysql_fetch_array($tampil))
		{
			if($sql[iddestination]==$r[iddestination])
			{
				echo "<option value='$r[iddestination]' selected>$r[dest_code] / Region : $r[region] ($r[dest_desc])</option>";
			}
			else
			{
				echo "<option value='$r[iddestination]'>$r[dest_code] / Region : $r[region] ($r[dest_desc])</option>";
			}					
    	 
		}
		echo "</select></td></tr>	
        <tr><td>Weight (Kg)</td>     <td> : <input type=text size=5 name=requiredkg
		 onkeypress=\"return isNumberKey(event)\" autocomplete=off value=$sql[berat]> *
        <tr><td>Collies</td>     <td> : <input type=text size=5 name=requiredkoli
		 onkeypress=\"return isNumberKey(event)\"
		autocomplete=off value=$sql[koli]> *		
        <tr><td>Consignee</td>     <td> : <input type=text size=50 name=consignee autocomplete=off value=$sql[consignee]>
        <tr><td>Shipper</td>     <td> : <input type=text size=50 name=shipper autocomplete=off value=$sql[shipper]>	
        <tr><td>AGENT</td><td> : <select name=agent>
		<option value='15'>none</option>";
		$tampil=mysql_query("SELECT * FROM agent ORDER BY agent ASC");
        while($r=mysql_fetch_array($tampil))
		{
			if($sql[idagent]==$r[idagent])
			{
			echo "<option value='$r[idagent]' selected>$r[agent]</option>";
			}
			else
			{
			echo "<option value='$r[idagent]' >$r[agent]</option>";
			}
		}
		echo "</select></td></tr>								
		<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, 
		tidak akan tersimpan.</td></tr> 
				<input type=hidden name=tglsmu value=$tgl>
				<input type=hidden name=ids value=$sql[idmastersmu]>
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
		
        </table>
        </form>";


?>