<?php
	$tgl=my2date($_POST[tglmanifest]);
  if((!empty($_POST[noflight])) AND (!empty($_POST[acregistration])))
  {
		$cek=mysql_query("select * from manifestout where noflight='$_POST[noflight]'
    AND acregistration='$_POST[acregistration]'AND tglmanifest='$tgl' AND isvoid='0'");
 		$ada=mysql_num_rows($cek);
  	if($ada > 0)
  	{
 			header('location:media.php?module=manifestout&p=e');
  	}
  	else
  	{
   		mysql_query("INSERT INTO manifestout(airline,noflight,tglmanifest,acregistration,user,isvoid,nil)
      VALUES('$_POST[airline]','$_POST[noflight]','$tgl', '$_POST[acregistration]',
      '$_SESSION[namauser]','0','$_POST[nil]')") ;
	   if(empty($_POST[nil]))
			header('location:media.php?module=manifestoutinput');
		else header('location:media.php?module=manifestout');	
		}
	}
	else
	{
		header('location:media.php?module=manifestout');
	}
?>