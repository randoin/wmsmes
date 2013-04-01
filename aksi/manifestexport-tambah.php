<?php
$a=my2date($_POST[tglawal]);
  mysql_query("INSERT INTO manifestout (idflight ,idorigin ,iddestination ,iddestination2,acregister ,
  flightdate ,etd,pointofloading ,pointul ,username ,statusnil ,statusconfirm ,statuscancel ,statusvoid ,keterangan)
  VALUES ('$_POST[flight]', '$_POST[origin]', '$_POST[destination]','$_POST[destination2]', '$_POST[requiredacregister]',
  '$a','$_POST[etd]','$_POST[requiredpointofloading]', '$_POST[requiredpointul]', '$_SESSION[namauser]', '$_POST[statusnil]', '0','0', '0', '')");
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
 header('location:media.php?module=isimanifestexport&idm='.$dt[idmanifestout].'&r='.$dt[acregister].'&f='.$dt[flight].'&d='.ymd2dmy($dt[flightdate]));
} 
?>