<?
include "config/koneksi.php";
include "config/library.php";
include "config/class_paging.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
<title>NEW CONSIGNEE</title>
<link href="config/adminstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div id="contentpop">
<?
$r=mysql_fetch_array(mysql_query("select * from consignee where idconsignee='$_GET[id]'"));
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

  </div> 
	
</body>
</html>
