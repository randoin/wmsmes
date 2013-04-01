<?php
 $ceksmu=mysql_num_rows(mysql_query("select m.nosmu from master_smu as m where m.nosmu='$_POST[requiredawb]'"));
 if($ceksmu<=0)
 {
  $e=1;
  header('location:media.php?act=tambah_isimanifestexport&idm='.$_POST[idm].'&r='.$_POST[r].'&f='.$_POST[f].'&d='.$_POST[d].'&e='.$e.'&olduld='.$_POST[uld]);	
 }
 else
 {
 
	if($_POST[tombolcek])
	{
		$str=mysql_query("select m.idmastersmu,m.nosmu,m.berat,m.koli from master_smu as m where m.nosmu='$_POST[requiredawb]'");
		$ada=mysql_num_rows($str);
		$ids=mysql_fetch_array($str);
		header('location:media.php?act=tambah_isimanifestexport&idm='.$_POST[idm].'&r='.$_POST[r].'&f='.$_POST[f].'&d='.$_POST[d].'
		&av='.$ada.'&awb='.$_POST[requiredawb].'&ids='.$ids[idmastersmu].'&olduld='.$_POST[uld]);	
	}
	elseif($_POST[tombolkirim])
	{
		if(($_POST[kg]>$_POST[brt]) OR ($_POST[koli]>$_POST[koli]))
		{
			  $e=2;
			  
  header('location:media.php?act=tambah_isimanifestexport&idm='.$_POST[idm].'&r='.$_POST[r].'&f='.$_POST[f].'&d='.$_POST[d].'&e='.$e.'&olduld='.$_POST[uld]);	
		}
		else
		{
		if(($_POST[kg]!='0') AND ($_POST[koli]!='0') AND ($_POST[uld]!=''))
		{
			mysql_query("INSERT INTO isimanifestout (idmanifestout ,idmastersmu ,nould ,
			berat ,koli ,statuscancel ,statusvoid ,keterangan) 
			VALUES ('$_POST[idm]', '$_POST[ids]', '$_POST[uld]', '$_POST[kg]', '$_POST[koli]', '0', '0', '0')");
			mysql_query("INSERT INTO beratuld   (uld,berat,idmanifestout) VALUES('$_POST[uld]','0','$_POST[idm]')");
		}
		  header('location:media.php?act=tambah_isimanifestexport&idm='.$_POST[idm].'&r='.$_POST[r].'&f='.$_POST[f].'&d='.$_POST[d].'&e='.$e.'&olduld='.$_POST[uld]);
		//header('location:media.php?module=isimanifestexport&idm='.$_POST[idm].'&r='.$_POST[r].'&f='.$_POST[f].'&d='.$_POST[d].'&olduld='.$_POST[uld]);	
		}
	}
 }
?>