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
<script language="javascript">
function cekdulu() 
{
	valid=true;
   if (document.form1.admin.value=="")
	{
		alert("Harga tidak boleh kosong");
		valid=false;
	}
		
	return valid;
}	
</script>

<?php
$tgl=date('Y-m-d');	
  echo "<h2>INPUT DATA $_GET[b]</h2>
        <form name=form1 method=POST action='aksi.php?module=inputdo' onSubmit=\"return cekdulu()\">
        <table>
		<tr><td>Administration</td>
		<td>: <input type=text name=admin onkeypress=\"return isNumberKey(event)\" value=5000></td></tr>
		<tr><td>Penerima</td>
		<td>: <input type=text name=penerima size=40></td></tr>
		<tr><td>Alamat</td>
		<td>: <input type=text name=alamat size=40></td></tr>

		<tr><td>Keterangan</td>
		<td>: <input type=text name=keterangan size=40></td></tr>


		<tr><td colspan=2><input type=submit value=Simpan>
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