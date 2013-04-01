<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
  echo "<link href='/config/adminstyle.css' rel='stylesheet' type='text/css'>
 <center>Anda harus login <br>";
  echo "<a href=login.php><b>LOGIN</b></a></center>";
}
else{
?>

<html>
<head>
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
<? echo "<title>WMS INTERNATIONAL CARGO : GAPURA ANGKASA - Medan | user : $_SESSION[namauser]</title>";?>
<link href="config/adminstyle.css" rel="stylesheet" type="text/css" />

</head>
<body>

<div id="header"> 	
</div>
    <div id="content">
		<?php include "content.php"; ?>
  </div> 
	<div id="menu">
	   <ul>
        <li><a href=?module=home>&#187; Home</a></li>
		<li><a href=?module=myacc>&#187; My Account</a></li>		
		<li><a href=logout.php>&#187; Logout</a></li>
		
        <?php include "menu.php"; ?>
        
      </ul>
	    <p>&nbsp;</p>


</div>
</body>
</html>
<?
}
?>
