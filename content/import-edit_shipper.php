<script language="javascript">
function cekdulu() 
{
	valid=true;
   if (document.form1.shipper.value=="")
	{
		alert("Nama tidak boleh kosong");
		valid=false;
	}
	return valid;
}	
</script>		
	
<?php	
$r=mysql_fetch_array(mysql_query("select * from shipper where idshipper='$_GET[id]'"));
  echo "<h2>EDIT DATA SHIPPER</h2>
        <form method=POST action='aksi.php?module=shipper&act=edit' 
		onSubmit=\"return cekdulu()\">
        <table>
        <tr><td>SHIPPER</td>     <td> : <input type=text value=\"$r[shipper]\" name=shipper size=40 onChange=\"javascript:this.value=this.value.toUpperCase();\"></td>
		<tr><td>ADDRESS</td><td> : <textarea name=alamat
		onChange=\"javascript:this.value=this.value.toUpperCase();\" cols=30 rows=2>$r[alamat]</textarea></td></tr>
         <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()>
		<input type=hidden name=id value='$_GET[id]'>
		</td></tr>
        </table>
        </form>";

?>