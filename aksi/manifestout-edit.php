<?php
	$tgl=my2date($_POST[tglmanifest]);
  if((!empty($_POST[noflight])) AND (!empty($_POST[acregistration])))
  {
		$cek=mysql_query("select * from manifestout where noflight='$_POST[noflight]'
    AND acregistration='$_POST[acregistration]'AND tglmanifest='$tgl' AND isvoid='0' 
  	 AND id_manifestout<>'$_POST[i]'");
 		$ada=mysql_num_rows($cek);
  	if($ada > 0)
  	{
 		header('location:media.php?module=manifestout&p=e');
  	}
  	else
  	{
   		mysql_query("UPDATE manifestout SET airline='$_POST[airline]',noflight='$_POST[noflight]',tglmanifest='$tgl',
			acregistration='$_POST[acregistration]',user='$_SESSION[namauser]',nil='$_POST[nil]' WHERE id_manifestout='$_POST[i]' AND status='waiting'");
			header('location:media.php?module=manifestout');
		}
	}
	else {header('location:media.php?module=manifestout');
	}
?>