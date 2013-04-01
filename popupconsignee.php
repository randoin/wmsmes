<?
include "config/koneksi.php";
include "config/library.php";
include "config/class_paging.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script language="JavaScript" src="myvalidator.js" type="text/javascript"></script>
<script type="text/javascript" src="basicvalidation.js"></script>
<SCRIPT LANGUAGE="JavaScript">
function validate(field) {
var valid = "abcdefghijklmnopqrstuvwxyz0123456789"
var ok = "yes";
var temp;
for (var i=0; i<field.value.length; i++) {
temp = "" + field.value.substring(i, i+1);
if (valid.indexOf(temp) == "-1") ok = "no";
}
if (ok == "no") {
alert("Invalid entry!  Only characters and numbers are accepted!");
field.focus();
field.select();
   }
}
</script>
<script type='text/javascript' src='dFilter.js'></script>
</script>
<script language="JavaScript" type="text/javascript">
function deldata(dataid, datatitle,dataurl)
{
   if (confirm("Yakin ingin menghapus '" + datatitle + "'"))
   {
      window.location.href = dataurl + dataid;
   }
}
 
</script>
<script>
			function pick(id,jenis)
			{
			window.opener.document.form2.consignee.value=id
			window.opener.document.form2.consignee1.value=jenis
			window.close()
			}
			</script>	
<? echo "<title>CONSIGNEE</title>";?>
<link href="config/adminstyle.css" rel="stylesheet" type="text/css" />

</head>
<body>
    <div id="contentpop">
<?
    $p      = new Paging;
	$batas  =5;
	$posisi = $p->cariPosisi($batas);
    $no     = $posisi+1;
	

if(!empty($_POST[cari])){$cari=$_POST[cari];}else{$cari=$_GET[cari];}
if(!empty($cari))//jika user melakukan pencarian
{
	if($_GET[a]=='1') // urutkan Ascending dulu
  	{
	$b=0; 
	$tampil=mysql_query("SELECT * FROM consignee WHERE consignee like '%$cari%' order by consignee ASC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM consignee WHERE consignee like '%$cari%'"));
	}
	else // jika diklik lagi maka akan pengurutan DESCENDING
  	{
	$b=1; 
	$tampil=mysql_query("SELECT * FROM consignee WHERE consignee like '%$cari%' order by consignee DESC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM consignee WHERE consignee like '%$cari%'"));
	}
}	
 else//jika user TIDAK melakukan pencarian
{
	if($_GET[a]=='1') // urutkan Ascending dulu
  	{
	$b=0; 
	$tampil=mysql_query("SELECT * FROM consignee order by consignee ASC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM consignee"));
	}
	else // jika diklik lagi maka akan pengurutan DESCENDING
  	{
	$b=1; 
	$tampil=mysql_query("SELECT * FROM consignee order by consignee DESC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM consignee"));
	}
}
//mulai membuat FORM nya
 	echo "<h2>DATA CONSIGNEE</h2>
 		<form method=POST action='?module=consignee'>
		<table border=0 cellpadding=0 cellspacing=0 width=100%>
			<tr><td>
			PENCARIAN : <input name=cari type=text size=20 value='$_POST[cari]' autocomplete=off> 
			<input type=submit value=CARI> <a href=tambahconsignee.php>
			<span class=tombol> TAMBAH DATA </span></a>
			</td></tr>
		</table>"; 
	$jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
	$linkHalaman  = $p->navHalaman($_GET[halaman], $jmlhalaman,'cari='.$cari);	
	echo "<p>$linkHalaman</p><table><tr><th>no</th>
		<th><a href=?module=consignee&r=r&a=$b&cari=$cari>consignee</a></th>
		<th>address</th><th>action</th></th></tr>";
	while ($r=mysql_fetch_array($tampil))
	{
		echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>$no</td><td><a href=\"javascript:pick('$r[idconsignee]','$r[consignee]')\">$r[consignee]</td><td>$r[alamat]</td>
          <td><a href=editconsignee.php?id=$r[idconsignee]>EDIT</a> | 
			<a href=\"javascript:deldata('$r[idconsignee]','consignee : $r[consignee] ?',
			'aksi.php?module=consignee&act=hapus&id=')\">HAPUS</a>
          	</td></tr>";
     $no++;
  	}
  echo "</table><p>word '$cari' found : $jmldata rows in $jmlhalaman pages</p></form>";
?>  

  </div> 
	
</body>
</html>