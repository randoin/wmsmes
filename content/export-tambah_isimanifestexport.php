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

	//Allow only alphabetical input, decimal point, backspace
	function isNumber(evt)
	{
		var myValidChars = new Array(0,8,46,48,49,50,51,52,53,54,55,56,57,190);
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode in oc(myValidChars))
		return true;
		return false;
	}	

	//Allow only alphabetical input, decimal point, backspace
	function iscek(evt)
	{
		var myValidChars = new Array(0,8,46,48,49,50,51,52,53,54,55,56,57,190,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122);
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode in oc(myValidChars))
		return true;
		return false;
	}
	
</SCRIPT>
<?
$data0=mysql_fetch_array(mysql_query("SELECT berat,koli FROM master_smu where 
idmastersmu='$_GET[ids]' and isvoid='0'"));
$data1=mysql_fetch_array(mysql_query("SELECT SUM(berat) as berat,SUM(koli) as koli FROM isimanifestout where idmastersmu='$_GET[ids]' and statusvoid='0' and statuscancel='0' GROUP BY idmastersmu"));
$berat=$data0[berat]-$data1[berat];
$koli=$data0[koli]-$data1[koli];

$tgl=date('Y-m-d');	
  echo "<h2>Tambah Isi Manifest Export -> A/C Reg.$_GET[r] Flight $_GET[f] $_GET[d]</h2>
        <form name=form1 method=POST action='aksi.php?module=isimanifestexport&act=tambah' 
		onSubmit=\"return checkrequired(this)\">
		<input type=hidden name=idm value='$_GET[idm]'>
		<input type=hidden name=r value='$_GET[r]'>
		<input type=hidden name=f value='$_GET[f]'>
		<input type=hidden name=d value='$_GET[d]'>	
		<input type=hidden name=ids value='$_GET[ids]'>
		<input type=hidden name=brt value='$berat'>
		<input type=hidden name=kl value='$koli'>	
        <table>
        <tr><td>AWB</td>     <td> : <input type=text size=20 name=requiredawb 
		 autocomplete=off value='$_GET[awb]'> 
		<input type=submit value=CHECK name=tombolcek></td></tr>
        <tr><td>KOLI</td>     <td> : <input type=text size=5 name=koli onkeypress=\"return isNumberKey(event)\"
		autocomplete=off value=$koli> *</td></tr>
        <tr><td>KG</td>     <td> : <input type=text size=5 name=kg onkeypress=\"return isNumberKey(event)\"
		autocomplete=off value=$berat> *</td></tr>
        <tr><td>ULD</td>     <td> : <input type=text size=20 onChange=\"javascript:this.value=this.value.toUpperCase();\"  
		name=uld onkeypress=\"return iscek(event)\" autocomplete=off value=$_GET[olduld]> * ex : AKE12345678GA (tanpa tanda minus atau spasi)</td></tr>		
		<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, 
		tidak akan tersimpan.
		</td></tr> 
        <tr><td colspan=2><input type=submit value=Simpan name=tombolkirim>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>
		<p>
		<a href=\"?module=isimanifestexport&idm=$_GET[idm]&r=$_GET[r]&f=$_GET[f]&d=$_GET[d]\">[KEMBALI]</a> ";
?>		<script language="JavaScript" type="text/javascript">
  var frmvalidator  = new Validator("form1");
  frmvalidator.addValidation("requiredawb","req","Nomor AWB tidak boleh kosong!");  
  frmvalidator.addValidation("koli","req","Jumlah Koli AWB tidak boleh kosong!");  
  frmvalidator.addValidation("koli","dec","Jumlah Koli AWB hanya boleh diisi angka!");
  frmvalidator.addValidation("kg","req","Berat AWB tidak boleh kosong!");  
  frmvalidator.addValidation("kg","dec","Berat AWB hanya boleh diisi angka!");  

 </script>
 <?
if($_GET[e]=='1')
{
 echo " No. AWB Tidak Ditemukan !</p>";
}
else if($_GET[e]=='2')
{
 echo " Maaf, Kg dan Koli Melebihi AWB, Silahkan ketik ulang !</p>";
}
		

?>