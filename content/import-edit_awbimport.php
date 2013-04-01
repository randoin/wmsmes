<?php
?>
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
	var kgd0=eval(document.form2.requiredkgdoc0.value);
	var kgb=eval(document.form2.requiredkgb.value);
	var kgd0b=eval(document.form2.requiredkgdoc0b.value);
var koli=eval(document.form2.requiredkoli.value);
	var kolid0=eval(document.form2.requiredkolidoc0.value);
	

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
   	else if (document.form2.requiredkg.value=="")
	{
		alert("Berat KG datang tidak boleh kosong");
		valid=false;
	}
   	else if (document.form2.requiredkgb.value=="")
	{
		alert("Berat KG Bayar datang tidak boleh kosong");
		valid=false;
	}	
	
	else if (koli<kolid0)
   	{
			alert("Jumlah Koli Lebih Kecil Dari Yang Sudah Terdaftar di Manifest !");
			valid=false;
	}		
	else if (kg<kgd0)
   	{
			alert("Berat KG Lebih Kecil Dari Yang Sudan Terdaftar di Manifest !");
			valid=false;
	}		

	else if (kgb<kgd0b)
   	{
			alert("Berat KG Bayar Lebih Kecil Dari Yang Sudah Terdaftar di Manifest !");
			valid=false;
	}		
	
return valid;
}

</script>	
<?
$tgl=date('Y-m-d');	
$smu=mysql_fetch_array(mysql_query("select * from master_smu where idmastersmu='$_GET[ids]'"));
$smu0=mysql_fetch_array(mysql_query("select sum(berat) as berat,sum(beratbayar) as beratbayar,sum(koli) as koli from isimanifestin where idmastersmu='$_GET[ids]'"));
//'aksi.php?module=awbimport&act=tambah' 


if($smu[idcommodityap]=='18')
{
	$noawb=format_nopos($smu[nosmu]);
echo "<h2>Editing AWB $noawb</h2>
        <form name=form2 method=POST action='aksi.php?module=awbimport&act=tambah' 
onsubmit=\"return cekdulu();\"><table>";

}
	else
{
	$noawb=format_awb($smu[nosmu]);
echo "<h2>Editing AWB</h2>
        <form name=form2 method=POST action='aksi.php?module=awbimport&act=edit' 
onsubmit=\"return cekdulu();\"><table>
        <tr><td>COMMODITY</td><td> : <select name=commodity>";
		$tampil=mysql_query("SELECT a.idcommodityap,a.commodityap,c.commodity FROM commodity_ap as a, 
		commodity as c WHERE a.idcommodity=c.idcommodity ORDER BY a.commodityap ASC");
        while($r=mysql_fetch_array($tampil))
		{
			if($smu[idcommodityap]==$r[idcommodityap])
			{ echo "<option value='$r[idcommodityap]' selected>$r[commodityap] ($r[commodity])</option>";
			}
			
			{ echo "<option value='$r[idcommodityap]'>$r[commodityap] ($r[commodity])</option>";
			}	
		}
		echo "</select></td></tr>
        <td>AWB</td>     <td> : <input type=text name=requiredawb
		 onkeypress=\"return isNumberKey(event)\" value=$smu[nosmu] autocomplete=off> * 11 digit untuk cargo / bebas untuk POS</td></tr>";
}
		echo"	<tr><td>
			Date</td><td>: <input type=text name=tglawal value=".ymd2dmy($smu[tglsmu]).">"; 
				 ?>
  <a href="javascript:showCal('Caritanggalawal')"><img src="images/calendar.png" border="0"></a>
  <?			
			

        echo "<tr><td>ORIGIN</td><td> : <select name=origin>";
		$tampil=mysql_query("SELECT o.idorigin,o.origin_code,r.region,r.dest_desc FROM 
		origin as o, region as r WHERE o.idregion=r.idregion order by o.origin_code ASC");
        while($r=mysql_fetch_array($tampil))
		{
		  if($r[idorigin]==$smu[idorigin])
    	 {echo "<option value='$r[idorigin]' selected>$r[origin_code] / Region : $r[region] ($r[dest_desc])</option>";}else
		     	 {echo "<option value='$r[idorigin]'>$r[origin_code] / Region : $r[region] ($r[dest_desc])</option>";}
		}
		echo "</select></td></tr>
        <tr><td>DESTINATION</td><td> : <select name=destination>";
		$tampil=mysql_query("SELECT d.iddestination,d.dest_code,r.region,r.dest_desc FROM 
		destination as d, region as r WHERE d.idregion=r.idregion order by d.dest_code ASC");
        while($r=mysql_fetch_array($tampil))
		{
		  if($r[iddestination]==$smu[iddestination])
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
		<input type=text size=5 name=requiredkoli onkeypress=\"return isNumberKey(event)\" autocomplete=off value=$smu[koli]>
		  => Registered : <input type=text name=requiredkolidoc0 value=\"$smu0[koli]\" size=5 readonly=true>		
        <tr><td>Weight (Kg)</td>     <td> : 
		<input type=text size=5 name=requiredkg
		 onkeypress=\"return isNumberKey(event)\" 
		 autocomplete=off value=$smu[berat]> => Registered : 
		 <input type=text name=requiredkgdoc0 value=\"$smu0[berat]\" size=5 readonly=true></td></tr>
        <tr><td>Chgbl Wght (Kg)</td>     <td> : 
		<input type=text size=5 name=requiredkgb
		 onkeypress=\"return isNumberKey(event)\" 
		 autocomplete=off value=$smu[beratbayar]> => Registered : 
		 <input type=text name=requiredkgdoc0b value=\"$smu0[beratbayar]\" size=5 readonly=true></td></tr>
       

<tr><td>Consignee</td><td> : <select name=consignee>";
		$tampil=mysql_query("SELECT * FROM 
		consignee order by consignee ASC");
        while($r=mysql_fetch_array($tampil))
		{
		  if($r[idconsignee]==$smu[consignee])
    	 {echo "<option value='$r[idconsignee]' selected>$r[consignee]</option>";}else
		     	 {echo "<option value='$r[idconsignee]'>$r[consignee]</option>";}
		}
		echo "</select></td></tr>
       <tr><td>Shipper</td><td> : <select name=shipper>";
		$tampil=mysql_query("SELECT * FROM 
		shipper order by shipper ASC");
        while($r=mysql_fetch_array($tampil))
		{
		  if($r[idshipper]==$smu[shipper])
    	 {echo "<option value='$r[idshipper]' selected>$r[shipper]</option>";}else
		     	 {echo "<option value='$r[idshipper]'>$r[shipper]</option>";}
		}
		echo "</select></td></tr>
        <tr><td>AGENT</td><td> : <select name=agent>
		<option value='15'>none</option>";
		$tampil=mysql_query("SELECT * FROM agent ORDER BY agent ASC");
        while($r=mysql_fetch_array($tampil))
		{
		 if($r[idagent]==$smu[idagent]){
    	 echo "<option value='$r[idagent]' selected>$r[agent]</option>";}else
		 {    	 echo "<option value='$r[idagent]'>$r[agent]</option>";}
		}
		echo "</select></td></tr>
         <tr><td>Connecting Flight</td><td> : <select name=connectingflight >";
		$tampil=mysql_query("SELECT * FROM connectingflight order by nama ASC");
        while($r=mysql_fetch_array($tampil))
		{
			if($r[idconnectingflight]==$smu[idconnectingflight])
			{
				 echo "<option value='$r[idconnectingflight]' selected>$r[nama]</option>";}
				else
				{
					 echo "<option value='$r[idconnectingflight]'>$r[nama]</option>";}
    	
		}
		echo " <tr><td>Remark</td>     <td> : 
		<input type=text size=30 name=remark value=\"$smu[remark]\"></td></tr>";
       


		echo "</select></td></tr><tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
		
        </table>
		<input type=hidden name=ids value=$_GET[ids]>
       </form>";	
		

?>