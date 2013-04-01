<script language="javascript">
function cekdulu() 
{
	valid=true;
   if (document.form1.consignee.value=="")
	{
		alert("Nama tidak boleh kosong");
		valid=false;
	}
	return valid;
}	
</script>		

<?php
  echo "<h2>TAMBAH DATA CONSIGNEE</h2>
        <form method=POST name=form1 action='aksi.php?module=consignee&act=tambah' 
		onSubmit=\"return cekdulu()\">
        <table>
        <tr><td>CONSIGNEE</td>     <td> : <input type=text name=consignee size=40 onChange=\"javascript:this.value=this.value.toUpperCase();\"></td>
		<tr><td>ADDRESS</td><td> : <textarea name=alamat
		onChange=\"javascript:this.value=this.value.toUpperCase();\" cols=30 rows=2></textarea>
		</td></tr>
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";

?>