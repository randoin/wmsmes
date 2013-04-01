<html>
<head>
<title>WMS INTERNATIONAL CARGO : GAPURA ANGKASA MEDAN -  Login</title>
<link href="config/adminstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div id="content">
 		<a href="index.php">
		<img src="images/gapura_login.jpg" border="0" hspace="10" vspace="20" align="left" 
		title="Klik disini untuk ke menu pencarian" alt="Klik disini untuk menu pencarian">
		</a>
	
<?
function masuk($pesan)
{
	echo "
<p><font color=#FF0000><B>$pesan</B></font></p>
<form method=POST action=cek_login.php>
			<table>
      		<tr>
				<td>Username</td>
				<td> : <input type=text name=username value='' autocomplete=off></td>
			</tr>
			<tr>
				<td>Password</td>
				<td> : <input type=password name=password value='' autocomplete=off></td>
			</tr>
      		<tr>
				<td colspan=2><input type=submit value=Login></td>
			</tr>
			</table>
      </form>";
	  
}

if($_GET['e']=='')
{
	masuk('');
}
else
{
	masuk("Maaf, LOGIN Anda Salah !");
}

?>

	<p>Use FIREFOX 3.09 for Best Performances</p>
	</div>
</body>
</html>
