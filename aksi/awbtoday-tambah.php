<?php
	if($_POST[commodity]=='18') //selalu utk MAIL !!
	{
			$noawb=nopos($_POST[requiredawb]);
	}
	else
	{
			$noawb=$_POST[requiredawb];
	}
	
	$tgl=my2date($_POST[tglawal]);
	mysql_query("INSERT INTO master_smu (nosmu,
										idcommodityap,
										idorigin,
										iddestination,
										berat,
										koli,
										isvoid,
										status_transit,
										user,
										tglsmu,
										shipper,
										consignee,
										idagent)
								VALUES ('$noawb',
										'$_POST[commodity]',
										'$_POST[origin]',
										'$_POST[destination]',
										'$_POST[requiredkg]',
										'$_POST[requiredkoli]',
										'0',
										'$_POST[transit]',
										'$_SESSION[namauser]',
										'$tgl',
										'$_POST[shipper]',
										'$_POST[consignee]',
										'$_POST[agent]')");
 header('location:media.php?module='.$module);
?>