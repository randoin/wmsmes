<?php
	$uld=$_POST['uld'];$idb=$_POST['idb'];$berat=$_POST['berat'];
	$n=0;
	foreach ($idb as $idb1)
		{
			$idb[n]=$idb1;$n+=1;
		}$n=0;
	foreach ($berat as $berat1)
		{
			$berat[n]=$berat1;$n+=1;
		}	$n=0;	
foreach ($uld as $uld1)
		{
			mysql_query("UPDATE beratuld SET uld='$uld1', 
				berat= '$berat[$n]' WHERE idberauld  = '$idb[$n]'");
					$n+=1;
		}
 
header('location:media.php?module=carimanifestexport&d='.$_POST[d]);
?>