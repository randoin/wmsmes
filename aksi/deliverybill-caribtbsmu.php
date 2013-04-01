<?php
	$tgl=date("Y-m-d");
  	$cek=mysql_query("SELECT * from out_dtbarang_h where btb_nobtb ='$_POST[nobtbsmu]' AND 
				status_bayar='no' AND isvoid='0' AND posted='1'");
  	$ada=mysql_num_rows($cek);  
  	if($ada<=0)
  	{
		$cek1=mysql_query("SELECT * from breakdown,
										 isimanifestin 
								   where breakdown.id_isimanifestin=isimanifestin.id_isimanifestin 
								   	AND  breakdown.status_ambil='INSTORE' 
									AND  isimanifestin.no_smu ='$_POST[nobtbsmu]' 
									AND  breakdown.status_bayar='no' 
									AND  isimanifestin.status_transit='MES' 
									AND  breakdown.isvoid='0' 
									AND  breakdown.status_check='confirm'");
		$p=mysql_fetch_array($cek1);

  		$ada1=mysql_num_rows($cek1);  
  		if($ada1<=0)
		{
				$cek2=mysql_query("SELECT * from breakdown,
												 isimanifestin,
												 manifestin
										   where breakdown.id_isimanifestin=isimanifestin.id_isimanifestin 
										   	AND  isimanifestin.id_manifestin=manifestin.idmanifestin 
											AND  isimanifestin.no_smu ='$_POST[nobtbsmu]' 
											AND  breakdown.isvoid='0'");
											
				$c=mysql_fetch_array($cek2);
   			if($c[23]=='TRANSIT'){header('location:media.php?module='.$module.'&psn=t');}
			elseif($c[15]=='waiting'){header('location:media.php?module='.$module.'&psn=w');}
			elseif($c[8]=='waiting'){header('location:media.php?module='.$module.'&psn=o');}			
			else {header('location:media.php?module='.$module.'&psn=e');}
			
 		}
  	else
  	{
    	header('location:media.php?module=bayar&d=0&n='.$_POST[nobtbsmu].'&x='.$p[0]);//inbound
		}
	}	
	else
	{
		 header('location:media.php?module=bayar&d=1&n='.$_POST[nobtbsmu]);//outbound
	}
?>