<?php
  $tgl=my2date($_POST['tgldatang']);
	if((($_POST['kolidatang']+$_POST['tkolidatang'])>$_POST['totalkoli']) 
		OR (($_POST['beratdatang']+$_POST['tberatdatang'])>$_POST['totalberat']))
		{
			header('location:media.php?module=splitsmu&n='.$_POST['n'].'&i='.$_POST['i'].'&p=e');
		}
		else
		{
		 if((!empty($_POST['kolidatang'])) 
		 	AND (!empty($_POST['beratdatang'])))
 			 {
	  			mysql_query("
							INSERT INTO breakdown(kolidatang,beratdatang,tgldatang,id_isimanifestin)
							VALUES('$_POST[kolidatang]','$_POST[beratdatang]','$tgl','$_POST[n]')");
				header('location:media.php?module=splitsmu&n='.$_POST['n'].'&i='.$_POST['i']);
			}
 	header('location:media.php?module=splitsmu&n='.$_POST['n'].'&i='.$_POST['i']);
		}
?>