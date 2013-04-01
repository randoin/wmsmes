<?php
?>
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
	
function cekdulu2() 
{
	var baca=document.form2.commodity.value;
	var kg=document.form2.requiredkg.value;
	var kgd=document.form2.requiredkgdoc.value;
	var kgd0=document.form2.requiredkgdoc0.value;	
	var koli=document.form2.requiredkoli.value;
	var kolid=document.form2.requiredkolidoc.value;
	var kolid0=document.form2.requiredkolidoc0.value;
	valid=true;
	
	
	if(baca!="18")
	{
	if ((document.form2.requiredawb.value.length<11) || (document.form2.requiredawb.value.length>11))
	  {
          alert("Format Penomoran AWB 11 Digit utk BUKAN MAIL/POS");
		valid=false;
		}
		else
		{
		}
	} 
	else
	{
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
	
	else if ((kolid0=="0") && (koli>kolid))
   	{
			alert("Jumlah Koli Datang Melebihi AWB");
			valid=false;
	}
	else if ((kolid0!=0) && (koli>kolid0))
   	{
			alert("Jumlah Koli Datang Melebihi SISA AWB");
			valid=false;
	}		
	
	else if ((kgd0=="0") && (kg>kgd))
   	{
			alert("Berat KG Datang melebihi AWB");
			valid=false;
	}
	else if ((kgd0!="0") &&(kg>kgd0))
   	{
			alert("Berat KG Datang melebihi AWB");
			valid=false;
	}		
			
	
return valid;
}
</script>	
<?
$tgl=date('Y-m-d');	
$data=mysql_fetch_array(mysql_query("select i.berat,i.koli,s.nosmu from isimanifestin as i, 
master_smu as s where i.idmastersmu=s.idmastersmu AND idisimanifestin=$_GET[iim]")); 

  echo "<h2>Edit AWB Datang => $_GET[f] Reg.$_GET[r]</h2>
        <form name=form2 method=POST action='aksi.php?module=isimanifestin&act=edit' 
onsubmit=\"return cekdulu2();\">

        <table>
  		<tr><td>
		Date</td><td>: <input type=text name=tglawal value=".ymd2dmy($tgl).">"; 
				 ?>
  <a href="javascript:showCal('Caritanggalawal')"><img src="images/calendar.png" border="0"></a>
  <?			
			
        echo "</td><tr><td>AWB</td>     <td> : <input type=text name=requiredawb
		 onkeypress=\"return isNumberKey(event)\" value=$data[nosmu] autocomplete=off maxlength=11 readonly></td></tr>
        <tr><td>Collies</td>     <td> : <input type=text size=5 name=requiredkoli value=$data[koli] 
		 onkeypress=\"return isNumberKey(event)\"
		autocomplete=off> of <input type=text size=5 name=requiredkolidoc value=$_GET[k0] 
		 onkeypress=\"return isNumberKey(event)\"
		autocomplete=off readonly>
		<input type=hidden name=requiredkolidoc0 value=$_GET[k]>	
        <tr><td>Weight (Kg)</td>     <td> : <input type=text size=5 name=requiredkg value=$data[berat] 
		 onkeypress=\"return isNumberKey(event)\" autocomplete=off> of <input type=text size=5 name=requiredkgdoc
		 onkeypress=\"return isNumberKey(event)\" autocomplete=off value=$_GET[b0] readonly>
		 		<input type=hidden name=requiredkgdoc0 value=$_GET[b]>
				<input type=hidden name=commodity value=$idcomo[0]>";	
		echo "<tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
		
        </table>
		<input type=hidden name=idm value=$_GET[idm]>
		<input type=hidden name=d value=$_GET[d]>
		<input type=hidden name=f value=$_GET[f]>				
		<input type=hidden name=r value=$_GET[r]>	
		<input type=hidden name=sp value=$_GET[sp]>		
        </form>";

?>