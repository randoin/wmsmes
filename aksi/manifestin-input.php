<?php
	$tgl=my2date($_POST[tglmanifest]);
  if((!empty($_POST[noflight])) AND (!empty($_POST[acregistration])))
  {
		/*$cek=mysql_query("select * from manifestin where noflight='$_POST[noflight]'
    AND acregistration='$_POST[acregistration]'AND tglmanifest='$tgl' AND isvoid='0'");
 		$ada=mysql_num_rows($cek);
  	if($ada > 0)
  	{
 			header('location:media.php?module=manifestin&p=e');
  	}
  	else
  	{*/
   		mysql_query("INSERT INTO manifestin(airline,noflight,tglmanifest,acregistration,user,isvoid,nil)
      VALUES('$_POST[airline]','$_POST[noflight]','$tgl', '$_POST[acregistration]',
      '$_SESSION[namauser]','0','$_POST[nil]')") ;
$s=mysql_query("select * from manifestin order by id_manifestin DESC limit 1") ;			
$last=mysql_fetch_array($s);
			if(empty($_POST[nil])) //jika manifest NIL
			header('location:media.php?module=manifestininput&airline='.$_POST[airline].'&i='.$last[0]);
			else
			header('location:media.php?module=manifestin');
		//}
	}
	else
	{
		header('location:media.php?module=manifestin');
	}
?>