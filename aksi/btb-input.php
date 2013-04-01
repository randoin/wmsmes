<?php
	$tgl=my2date($_POST['tglbtb']);
	$thn = substr($tgl,0,4);
	
	$a=mysql_query("select btb_nobtb,btb_date from out_dtbarang_h order by id DESC limit 1");
	$b=mysql_fetch_array($a);
	$cthn = substr($b[1],0,4);

	if($cthn<>$thn)
		{
			$nobtb=$thn.'0000000';
		}
	else 
		{
			$nobtb=$b[0]+1;
		}
	mysql_query("
				INSERT INTO out_dtbarang_h(btb_smu,
										   airline,
										   btb_nobtb,
							   			   btb_date,
							   			   btb_by,
							   			   isvoid,
							   			   createdby,
							   			   createdate,
							   			   btb_agent,
							   			   btb_tujuan)
  				VALUES('$_POST[nosmu]',
					   '$_POST[airline]',
		   			   '$nobtb',
					   '$tgl',
		   			   '$_SESSION[namauser]',
		   			   '0',
		   			   '$_SESSION[namauser]',
		   			   '$tgl',
		   			   '$_POST[agent]',
		   			   '$_POST[tujuan]')
				") ;
	
	$s=mysql_query("select * from out_dtbarang_h order by id DESC limit 1") ;			
	$last=mysql_fetch_array($s);
	header('location:media.php?module=btbinput&airline='.$_POST['airline'].'&i='.$last['0'].'&j='.$_POST['jenisbarang']);
?>