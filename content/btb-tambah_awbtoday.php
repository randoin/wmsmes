<SCRIPT LANGUAGE="JavaScript" src="cal2.js">
</script>
<script language="javascript">
    addCalendar("Caritanggalawal","Tanggal","tglawal","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
</script>

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
   		alert("Format Penomoran AWB 11 Digit utk BUKAN MAIL/POS");
		valid=false;
		}
	} 
   	if (document.form1.requiredkoli.value=="")
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
</script>	

<?php
$tgl=date('Y-m-d');	
?>

<h2>Tambah AWB</h2>
<form name="form1" method="POST" action="aksi.php?module=awbtoday&act=tambah" onsubmit="return cekdulu();"> 
	<table>
		<tr>
        	<td>COMMODITY</td>
            <td> : <select name="commodity">
				<?php 
					$tampil=mysql_query("SELECT a.idcommodityap,a.commodityap,c.commodity FROM commodity_ap as a, 
					commodity as c WHERE a.idcommodity=c.idcommodity ORDER BY a.commodityap ASC");
        			while($r=mysql_fetch_array($tampil))
					{
    	 				echo "<option value='$r[idcommodityap]'>$r[commodityap] ($r[commodity])</option>";
					}
				?>
					</select></td>
		</tr>
        
		<tr>
        	<td>Date</td>
            <td>: <input type="text" name="tglawal" value="<?php ymd2dmy($tgl) ?>">
			<a href="javascript:showCal('Caritanggalawal')"><img src="images/calendar.png" border="0"></a></td>
            
        <tr>
        	<td>AWB</td>
            <td> : <input type="text" name="requiredawb" onkeypress="return isNumberKey(event)" 
            		value="<?php $_GET['s'] ?>" autocomplete="off" maxlength="11" size="12"> * 11 digit untuk cargo / bebas untuk POS</td>
        </tr>

        <tr>
        	<td>ORIGIN</td>
            <td> : <select name="origin">
            	<?php
					$tampil=mysql_query("SELECT o.idorigin,o.origin_code,r.region,r.dest_desc FROM 
					origin as o, region as r WHERE o.idregion=r.idregion order by o.origin_code ASC");
        			while($r=mysql_fetch_array($tampil))
					{
						if($r[origin_code]=='MES')
							{
								echo "<option value='$r[idorigin]' selected>$r[origin_code] / Region : $r[region] ($r[dest_desc])</option>";
							}
						else
							{
    	 						echo "<option value='$r[idorigin]'>$r[origin_code] / Region : $r[region] ($r[dest_desc])</option>";
							} 
					}
				?></select></td>
        </tr>
        
        <tr>
        	<td>DESTINATION</td>
            <td> : <select name="destination">
            	<?php	
					$tampil=mysql_query("SELECT d.iddestination,d.dest_code,r.region,r.dest_desc FROM 
					destination as d, region as r WHERE d.idregion=r.idregion order by d.dest_code ASC");
        			while($r=mysql_fetch_array($tampil))
					{
    	 				echo "<option value='$r[iddestination]'>$r[dest_code] / Region : $r[region] ($r[dest_desc])</option>";
					}
				?></select></td>
        </tr>	
        
        <tr>
        	<td>Collies</td>
            <td> : <input type="text" size="5" name="requiredkoli" onkeypress="return isNumberKey(event)" autocomplete="off"> * </td>
        </tr>		

        <tr>
        	<td>Weight (Kg)</td>
            <td> : <input type="text" size="5" name="requiredkg" onkeypress="return isNumberKey(event)" autocomplete="off"> * </td>
        </tr>
        
        <tr>
        	<td>Consignee</td>
            <td> : <input type="text" size="50" name="consignee" autocomplete="off"> </td>
        </tr>
        
        <tr>
        	<td>Shipper</td>
            <td> : <input type="text" size="50" name="shipper" autocomplete="off"> </td>
        </tr>
        	
        <tr>
        	<td>AGENT</td>
            <td> : <select name="agent"> <option value="15">none</option>
            	<?php	
					$tampil=mysql_query("SELECT * FROM agent ORDER BY agent ASC");
        			while($r=mysql_fetch_array($tampil))
					{
    	 				echo "<option value='$r[idagent]'>$r[agent]</option>";
					}
				?></select></td>
        </tr>								
		
        <tr>
        	<td colspan="2">*) wajib diisi, data kosong atau duplikasi/double ID kunci, tidak akan tersimpan.</td>
        </tr> 
        
        <tr>
        	<td colspan="2"><input type="submit" value="Simpan">
        					<input type="button" value="Batal" onclick="self.history.back()"></td>
        </tr>
		
</table>
</form>