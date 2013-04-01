<script language="javascript">
function cekdulu() 
{
	valid=true;
   if (document.form1.nama.value=="")
	{
		alert("Nama tidak boleh kosong");
		valid=false;
	}
   	else if (document.form1.alamat.value=="")
	{
		alert("Alamat tidak boleh kosong");
		valid=false;
	}	
  	else if (document.form1.npwp.value=="")
	{
		alert("No.NPWP tidak boleh kosong");
		valid=false;
	}		
	return valid;
}	
	</script>

<?php
  echo "<h2>TAMBAH DATA CONNECTING FLIGHT</h2>
        <form name=form1 method=POST action='aksi.php?module=connectingflight&act=tambah' 
		onSubmit=\"return cekdulu()\">
        <table>
        <tr><td>NAMA</td>     <td> : <input type=text name=nama
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		autocomplete=off size=40></td></tr>
        <tr><td>ALAMAT</td>     <td> : <textarea name=alamat
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		autocomplete=off cols=30 rows=2> </textarea></td></tr>		
        <tr><td>NPWP</td>     <td> : <input type=text name=npwp
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		autocomplete=off></td></tr>
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";

?>