<?php
?>
			<SCRIPT LANGUAGE="JavaScript">
			function popupwindow(URL) {
			day = new Date();
			id = day.getTime();
			eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=700,height=450,left = 50,top = 50');");
			}
			</script>
<SCRIPT LANGUAGE="JavaScript" src="cal2.js">
</script>
<script language="JavaScript">
    addCalendar("Caritanggalawal","Tanggal","tglawal","form2");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
</script>
 <SCRIPT language="JavaScript">
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
</script>
 <SCRIPT language="JavaScript">	

function cekdulu() 
{
	var baca=eval(document.form2.commodity.value);
	var kg=eval(document.form2.requiredkg.value);
	var kgd=eval(document.form2.requiredkgdoc.value);
	var kgd0=eval(document.form2.requiredkgdoc0.value);	
	var kgb=eval(document.form2.requiredkgb.value);
	var kgbd=eval(document.form2.requiredkgbdoc.value);
	var kgbd0=eval(document.form2.requiredkgbdoc0.value);	
	var koli=eval(document.form2.requiredkoli.value);
	var kolid=eval(document.form2.requiredkolidoc.value);
	var kolid0=eval(document.form2.requiredkolidoc0.value);
	var con=eval(document.form2.consignee.value);
	var ship=eval(document.form2.shipper.value);
	var pos=eval(document.form2.requiredpos.value);	

	valid=true;
	
	if(baca!="18")
	{
	if ((document.form2.requiredawb.value.length<11) || (document.form2.requiredawb.value.length>11))
	  {
          alert("Format Penomoran AWB 11 Digit utk BUKAN MAIL/POS");
		valid=false;
	  }
	} 

	if (document.form2.requiredkoli.value=="")
	{
		alert("Jumlah koli datang tidak boleh kosong");
		valid=false;
	}
   	else if (document.form2.requiredkolidoc.value=="")
	{
		alert("Jumlah koli AWB tidak boleh kosong");
		valid=false;
	}	
   	else if (document.form2.requiredkg.value=="")
	{
		alert("Berat KG datang tidak boleh kosong");
		valid=false;
	}
   	else if (document.form2.requiredkgdoc.value=="")
	{
		alert("Berat KG AWB tidak boleh kosong");
		valid=false;
	}	
//////
   	else if (document.form2.requiredkgb.value=="")
	{
		alert("Berat KG terbayar datang tidak boleh kosong");
		valid=false;
	}
   	else if (document.form2.requiredkgbdoc.value=="")
	{
		alert("Berat KG AWB terbayar tidak boleh kosong");
		valid=false;
	}	
	/////

	else if (kolid0=="0" && koli>kolid)
   	{
			alert("Jumlah Koli Datang Melebihi AWB");
			valid=false;
	}
	else if (kolid0!="0" && koli>kolid0)
   	{
			alert("Jumlah Koli Datang Melebihi SISA AWB");
			valid=false;
	}		
	
	else if (kgd0=="0" && kg>kgd)
   	{
			alert("Berat KG Datang melebihi AWB");
			valid=false;
	}
	else if (kgd0!="0" && kg>kgd0)
   	{
			alert("Berat KG Datang melebihi SISA AWB");
			valid=false;
	}		
	//////
		else if (kgbd0=="0" && kgb>kgbd)
   	{
			alert("Berat KG Datang melebihi AWB");
			valid=false;
	}
	else if (kgbd0!="0" && kgb>kgbd0)
   	{
			alert("Berat KG Datang melebihi SISA AWB");
			valid=false;
	}	
	//////
	else if (document.form2.consignee.value=="")
	{
		alert("Consignee tidak boleh kosong");
		valid=false;
	}
   	else if (document.form2.shipper.value=="")
	{
		alert("Shipper tidak boleh kosong");
		valid=false;
	}		
   	else if (document.form2.pos.value=="")
	{
		alert("Nomor POSITION tidak boleh kosong");
		valid=false;
	}				
	
return valid;
}

</script>	
<?
$tgl=date('Y-m-d');	
//'aksi.php?module=awbimport&act=tambah' 
echo "<h2>Tambah AWB => $_GET[f] Reg.$_GET[r]</h2>
        <form name=form2 method=POST action='aksi.php?module=awbimport&act=tambah' 
onsubmit=\"return cekdulu();\">";
if($_GET[sp]=='')
{
  echo "<table>
        <tr><td>COMMODITY</td><td> : <select name=commodity>";
		$tampil=mysql_query("SELECT a.idcommodityap,a.commodityap,c.commodity FROM commodity_ap as a, 
		commodity as c WHERE a.idcommodity=c.idcommodity ORDER BY a.commodityap ASC");
        while($r=mysql_fetch_array($tampil))
		{
    	 echo "<option value='$r[idcommodityap]'>$r[commodityap] ($r[commodity])</option>";
		}
		echo "</select></td></tr>
			<tr><td>
			Date</td><td>: <input type=text name=tglawal value=".ymd2dmy($tgl).">"; 
				 ?>
  <a href="javascript:showCal('Caritanggalawal')"><img src="images/calendar.png" border="0"></a>
  <?			
			
        echo "</td><tr><td>AWB</td>     <td> : <input type=text name=requiredawb
		 onkeypress=\"return isNumberKey(event)\" value=$_GET[s] autocomplete=off maxlength=11> * 11 digit untuk cargo / bebas untuk POS</td></tr>

        <tr><td>ORIGIN</td><td> : <select name=origin>";
		$tampil=mysql_query("SELECT o.idorigin,o.origin_code,r.region,r.dest_desc FROM 
		origin as o, region as r WHERE o.idregion=r.idregion order by o.origin_code ASC");
        while($r=mysql_fetch_array($tampil))
		{
    	 echo "<option value='$r[idorigin]'>$r[origin_code] / Region : $r[region] ($r[dest_desc])</option>";
		}
		echo "</select></td></tr>
        <tr><td>DESTINATION</td><td> : <select name=destination>";
		$tampil=mysql_query("SELECT d.iddestination,d.dest_code,r.region,r.dest_desc FROM 
		destination as d, region as r WHERE d.idregion=r.idregion order by d.dest_code ASC");
        while($r=mysql_fetch_array($tampil))
		{
			if($r[dest_code]=='MES')
			{
				echo "<option value='$r[iddestination]' selected>$r[dest_code] / Region : $r[region] ($r[dest_desc])</option>";
				}
				else
				{
    	 echo "<option value='$r[iddestination]'>$r[dest_code] / Region : $r[region] ($r[dest_desc])</option>";
		} 
		}
		echo "</select></td></tr>	
        <tr><td>Collies</td>     <td> : 
		<input type=text size=5 name=requiredkoli onkeypress=\"return isNumberKey(event)\" autocomplete=off> of <input type=text size=5 name=requiredkolidoc 
		onkeypress=\"return isNumberKey(event)\" autocomplete=off>
		<input type=hidden name=requiredkolidoc0 value=0></td></tr>		

        <tr><td>Weight (Kg)</td>     <td> : 
		<input type=text size=5 name=requiredkg
		 onkeypress=\"return isNumberKey(event)\" 
		 autocomplete=off> of <input type=text size=5 name=requiredkgdoc 
		 onkeypress=\"return isNumberKey(event)\" autocomplete=off>
		 <input type=hidden name=requiredkgdoc0 value=0></td></tr>

  <tr><td>Chgbl Wght (Kg)</td>     <td> : 
		<input type=text size=5 name=requiredkgb
		 onkeypress=\"return isNumberKey(event)\" 
		 autocomplete=off> of <input type=text size=5 name=requiredkgbdoc 
		 onkeypress=\"return isNumberKey(event)\" autocomplete=off>
		 <input type=hidden name=requiredkgbdoc0 value=0></td></tr>


         <tr><td>Consignee</td><td> : 
		<input type=text name=consignee1 readonly=true  size=40>
	<a href=\"javascript:popupwindow('popupconsignee.php');\">
	<img src=\"images/searching.png\" width=\"24\" height=\"27\"border=\"0\" align=\"middle\"></a><input type=hidden name=consignee> 

		</td></tr>
         <tr><td>Shipper</td><td> : 
		<input type=text name=shipper1 readonly=true  size=40>
	<a href=\"javascript:popupwindow('popupshipper.php');\">
	<img src=\"images/searching.png\" width=\"24\" height=\"27\"border=\"0\" align=\"middle\"></a><input type=hidden name=shipper> 
</td/></tr>
        <tr><td>AGENT</td><td> : <select name=agent>
		<option value='15'>none</option>";
		$tampil=mysql_query("SELECT * FROM agent ORDER BY agent ASC");
        while($r=mysql_fetch_array($tampil))
		{
    	 echo "<option value='$r[idagent]'>$r[agent]</option>";
		}
		echo "</select></td></tr>
         <tr><td>Connecting Flight</td><td> : <select name=connectingflight >";
		$tampil=mysql_query("SELECT * FROM connectingflight order by nama ASC");
        while($r=mysql_fetch_array($tampil))
		{
    	 echo "<option value='$r[idconnectingflight]'>$r[nama]</option>";
		}
		echo "</select></td></tr>
<tr><td>Remark</td>     <td> : 
		<input type=text size=30 name=remark autocomplete=off> (utk TRANSHIPMENTS CUSTOMS CLEARANCE CHARGES)</td></tr>
";
}


else
//jika split alias barang sisanya
{
	$idcomo=mysql_fetch_array(mysql_query("SELECT idcommodityap from master_smu where nosmu='$_GET[s]'"));
echo "   <table>
  		<tr><td>
		Date</td><td>: <input type=text name=tglawal value=".ymd2dmy($tgl).">"; 
				 ?>
  <a href="javascript:showCal('Caritanggalawal')"><img src="images/calendar.png" border="0"></a>
  <?			
			
        echo "</td><tr><td>AWB</td>     <td> : <input type=text name=requiredawb
		 onkeypress=\"return isNumberKey(event)\" value=$_GET[s] autocomplete=off readonly></td></tr>
        <tr><td>Collies</td>     <td> : <input type=text size=5 name=requiredkoli value=$_GET[k] 
		 onkeypress=\"return isNumberKey(event)\"
		autocomplete=off> of <input type=text size=5 name=requiredkolidoc value=$_GET[k0] 
		 onkeypress=\"return isNumberKey(event)\"
		autocomplete=off readonly>
		<input type=hidden name=requiredkolidoc0 value=$_GET[k]>	
        <tr><td>Weight (Kg)</td>     <td> : <input type=text size=5 name=requiredkg value=$_GET[b] 
		 onkeypress=\"return isNumberKey(event)\" autocomplete=off> of <input type=text size=5 name=requiredkgdoc
		 onkeypress=\"return isNumberKey(event)\" autocomplete=off value=$_GET[b0] readonly></td></tr>
        <tr><td>Chgbl Wght (Kg)</td>     <td> : <input type=text size=5 name=requiredkgb value=$_GET[bb] 
		 onkeypress=\"return isNumberKey(event)\" autocomplete=off> of <input type=text size=5 name=requiredkgbdoc
		 onkeypress=\"return isNumberKey(event)\" autocomplete=off value=$_GET[bb0] readonly></td></tr>
		 		<input type=hidden name=requiredkgbdoc0 value=$_GET[bb]>
		 		<input type=hidden name=requiredkgdoc0 value=$_GET[b]>
				<input type=hidden name=commodity value=$idcomo[0]>";
		}			
		
		echo "
        <tr><td>Position</td>     <td> : 
		<input type=text size=5 name=requiredpos onkeypress=\"return isNumberKey(event)\" autocomplete=off></td></tr>


<tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
		
        </table>
		<input type=hidden name=idm value=$_GET[idm]>
		<input type=hidden name=d value=$_GET[d]>
		<input type=hidden name=f value=$_GET[f]>				
		<input type=hidden name=r value=$_GET[r]>	
		<input type=hidden name=sp value=$_GET[sp]>		
        </form>";	
		
							


?>