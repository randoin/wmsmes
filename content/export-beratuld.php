<?php
?>
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
$uld_data=mysql_query("select idberauld,uld,sum(berat) as berat from beratuld where idmanifestout='$_GET[idm]' GROUP BY uld");
 	echo "<h2>Daftar Berat ULD untuk Manifest A/C Reg.".$_GET[red]." : ".$_GET[f].
		" Flight Date ".ymd2dmy($_GET[d])."</h2>
 		<form name=form1 method=POST action='aksi.php?module=beratuld&act=update'>
		<table border=0 cellpadding=0 cellspacing=0>
		<tr><th>No</th><th>No uld</th><th>kg</th></tr>";
		$no=1;
		while($r=mysql_fetch_array($uld_data))
		{
			echo "<tr><td>$no</td><td>$r[uld]</td><td>: <input type=text name=berat[] size=5 value=".number_format($r[berat], 1, ',', '.')." onkeypress=\"return isNumberKey(event)\"></td></tr>
<input type=hidden name=idb[] value=$r[idberauld]>
<input type=hidden name=d value=\"$_GET[d]\">
<input type=hidden name=uld[] value=\"$r[uld]\">";
			$no++;
			
		}
		echo "<tr><td colspan=3><input type=submit value=UPDATE></td></tr></form>
<p><a href=\"?module=carimanifestexport&d=$_GET[d]\">[KEMBALI]</p>";

?>