<?php
$a=my2date($_POST[tglawal]);
  mysql_query("UPDATE manifestout set idflight='$_POST[flight]' ,idorigin='$_POST[origin]' ,iddestination='$_POST[destination]' ,iddestination2='$_POST[destination2]' ,acregister='$_POST[requiredacregister]' , flightdate = '$a',pointofloading='$_POST[requiredpointofloading]' ,pointul= '$_POST[requiredpointul]' ,username='$_SESSION[namauser]' ,statusnil='$_POST[statusnil]',etd='$_POST[etd]' WHERE idmanifestout='$_POST[idm]'");
if($_POST[statusnil]=='on')
{
	header('location:media.php?module=carimanifestexport&d='.$a);
}
else
{
$lst=mysql_fetch_array(mysql_query("select idmanifestout from manifestout order by idmanifestout DESC limit 1"));  
	$dt=mysql_fetch_array(mysql_query("SELECT m.idmanifestout,m.acregister,
	f.flight,m.flightdate FROM manifestout as m,flight as f, customer as c
	WHERE m.idflight=f.idflight  AND f.idcustomer=c.idcustomer AND m.idmanifestout=$lst[idmanifestout]")); 
 //header('location:media.php?module=carimanifestexport');
 header('location:media.php?module=carimanifestexport&idm='.$dt[idmanifestout].'&r='.$dt[acregister].'&f='.$dt[flight].'&d='.ymd2dmy($dt[flightdate])); 
} 
?>