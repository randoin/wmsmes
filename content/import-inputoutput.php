<?php
?>
<SCRIPT LANGUAGE="JavaScript" src="cal2.js">
</script>
<script language="javascript">
    addCalendar("Caritanggalawal","Tanggal","tglawal","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
</script>
	<script language="javascript">
function cekdulu() 
{
	valid=true;
   if (document.form1.no.value=="")
	{
		alert("Nomor tidak boleh kosong");
		valid=false;
	}
		
	return valid;
}	
</script>
 <?
$tgl=date('Y-m-d');	
  echo "<h2>INPUT DATA $_GET[b]</h2>
        <form name=form1 method=POST action='aksi.php?module=inputoutput&act=tambah' onSubmit=\"return cekdulu()\">
        <table>
		<tr><td>TANGGAL </td>
		<td>: <input type=text onKeyDown=\"javascript:return dFilter (event.keyCode, this,'##-##-####');\" name=tglawal value=".ymd2dmy($tgl).">"; 
				 ?>
  <a href="javascript:showCal('Caritanggalawal')"><img src="images/calendar.png" border="0"></a>
  <?
	echo "</td></tr>		";
		if($_GET[b]=='BC1.2')
		{
		echo "<tr><td>No.BC1.2</td>
		<td>: <input type=text name=no></td></tr>"; } else
		if($_GET[b]=='BC2.3')
		{
		echo "<tr><td>No.BC2.3</td>
		<td>: <input type=text name=no></td></tr>"; } else
		if($_GET[b]=='SPPB')
		{
		echo "<tr><td>No.SPPB</td>
		<td>: <input type=text name=no></td></tr>"; }
	
		echo "<tr><td colspan=2><input type=submit value=Simpan>
<input type=hidden name=idm value=$_GET[idm]>
<input type=hidden name=b value=$_GET[b]>
<input type=hidden name=r value=$_GET[r]>
<input type=hidden name=f value=$_GET[f]>
<input type=hidden name=d value=$_GET[d]>
<input type=hidden name=id value=$_GET[id]>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
		
        </table>
        </form>";

?>