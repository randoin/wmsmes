<?php
	$tgl=date("Y-m-d");
	$thn = substr($tgl,2,2);
	$tahun_skr_4_digit = substr($tgl,0,4);
	$tahun_skr_2_digit = substr($tgl,2,2);
	
	/*
  	//echo($thn);
	$a=mysql_query("select no_smubtb,tglbayar from deliverybill order by id_deliverybill DESC limit 1");
	$b=mysql_fetch_array($a);
	$cthn = substr($b[1],0,4);
	if($cthn<>$thn)
	{
		$nodb=$thn.'0000000';
	}
	else
	{
		$nodb=$b[0]+1;
	}
	*/
	
		# Set No DB dan No Faktur
	$a=mysql_query("
	select nodb,tglbayar,nofaktur from deliverybill 
	where nofaktur<>'' order by id_deliverybill DESC limit 1
	");
	$b=mysql_fetch_array($a);
	
	# Set No DB
	$tahun_bayar_4_digit = substr($b['tglbayar'],0,4);
	#$cthn = substr($b['tglbayar'],0,4);
	
		if($tahun_bayar_4_digit<>$tahun_skr_4_digit)
		{
			$nodb=$tahun_skr_4_digit.'0000000';
		}
		else 
		{	
			$nodb=$b['nodb']+1;
		}
	
	# Set No Faktur
	#$fthn = substr($b['tglbayar'],2,2);
	$tahun_bayar_2_digit = substr($b['tglbayar'],2,2);
	
		if($tahun_bayar_2_digit<>$tahun_skr_2_digit)
		{
			$nofaktur=$tahun_skr_2_digit.'00000800';
		}
		else 
		{	
			$nofaktur=$b['nofaktur']+1;
		}
	
  	if($_POST[id]=='1')
  
  	{//outgoing atau export
		$a=mysql_query("select nodb, tglbayar from deliverybill where status='1' order by id_deliverybill DESC limit 1");
		$b=mysql_fetch_array($a);
		
				#$cthn = substr($b['tglbayar'],0,4);
		$tahun_bayar_4_digit = substr($b['tglbayar'],0,4);
		
			if($tahun_bayar_4_digit<>$tahun_skr_4_digit)
			{
				$nodb=$tahun_skr_4_digit.'0000000';
			}
			else 
			{	
				$nodb=$b['nodb']+1;
			} 
	
		$cekagent=mysql_fetch_array(mysql_query("select btb_agent from out_dtbarang_h where btb_nobtb='$_POST[nosmubtb]'"));
	
			if(($cekagent['0']=='POS') OR ($cekagent['0']=='SAB'))
			{ 
				$nofakturku='';
			} 
			else 
			{
				$nofakturku=$nofaktur;
			}
		
		$no_smubtb = $_POST['nosmubtb'];
		$document = $_POST['administrasi'];
		$storage = $_POST['after_discount_value'] + $_POST['cargocharge'] + $_POST['kade'];
		$id_carabayar = $_POST['carabayar'];
		$lain = $_POST['ppn_value'];
		$tglbayar = date ('Y-m-d H:i:s');
		$user = $_SESSION['namauser'];
		$overtime = $_POST['total_after_ppn'];
		$hari = $_POST['hari'];
		$status = $_POST['status'];
		$diskon = trim (str_replace('.','',$_POST['discount_value']));
		$keterangan = $_POST['keterangan'];
		$nosmu = trim (str_replace('-','',$_POST['nosmu']));
		$nodb = $nodb;
		$nofaktur = $nofakturku;
		$actual_days = $_POST['hari'];
		$sewagudang = $_POST['sewagudang'];
		$sewagudang_discount = $_POST['discount_value'];
		$sewagudang_after_discount = $_POST['after_discount_value'];
		$cargocharge = $_POST['cargocharge'];
		$cargocharge_ppn = $_POST['cargocharge_ppn'];
		$kade = $_POST['kade'];
		$administrasi = $_POST['administrasi'];
		$ppn = $_POST['ppn_value'];
		$total_biaya = $_POST['total_after_ppn'];
		$minimum_charge = $_POST['minimum_charge'];
		$minimum_weight = $_POST['minimum_weight'];
		
		mysql_query("
					INSERT INTO deliverybill
								(no_smubtb,
								document,
								storage,
								id_carabayar,
								lain,
								tglbayar,
								user,
								overtime,
								hari,
								status,
								diskon,
								keterangan,
								nosmu,
								nodb,
								nofaktur,
								actual_days,
								sewagudang,
								sewagudang_discount,
								sewagudang_after_discount,
								cargocharge,
								cargocharge_ppn,
								kade,
								administrasi,
								ppn,
								total_biaya,
								minimum_charge,
								minimum_weight)
 	 					VALUES ('$no_smubtb',
			   			  		'$document',
			   			   		'$storage',
			   			   		'$id_carabayar',
								'$lain',
								'$tglbayar',
			   			   		'$user',
			   			   		'$overtime',
			   			   		'$hari',
			   			   		'1',
			   			   		'$diskon',
			   			   		'$keterangan',
			   			   		'$nosmu',
			   			   		'$nodb',
						   		'$nofaktur',
						   		'$actual_days',
						   		'$sewagudang',
						   		'$sewagudang_discount',
						   		'$sewagudang_after_discount',
						   		'$cargocharge',
						   		'$cargocharge_ppn',
						   		'$kade',
								'$administrasi',
						   		'$ppn',
						   		'$total_biaya',
						   		'$minimum_charge',
						   		'$minimum_weight')
					");
  
		mysql_query("UPDATE out_dtbarang_h set status_bayar='yes',btb_smu='$_POST[nosmu]' where btb_nobtb='$_POST[nosmubtb]'");
	}
    else
	{ //incoming atau import
		mysql_query("
					INSERT INTO deliverybill
								(no_smubtb,
								document,
								storage,
								id_carabayar,
								lain,
								tglbayar,
								user,
								overtime,
								hari,
								status,
								idbreakdown,
								nosmu,
								diskon,
								keterangan,
								nodb)
 					VALUES ('$_POST[nosmubtb]',
						   '$_POST[document1]',
						   '$_POST[storage1]',
						   '$_POST[id_carabayar]',
						   '$_POST[ppn1]',
						   '$tgl',
						   '$_SESSION[namauser]',
						   '$_POST[overtime1]',
						   '$_POST[hari]',
						   '0',
						   '$_POST[id_breakdown]',
						   '$_POST[nosmu]',
						   '$_POST[afterdiskon]',
						   '$_POST[keterangan]',
						   '$nodb')
					");
   		 mysql_query("UPDATE isimanifestin set penerima='$_POST[penerima]',alamatpenerima='$_POST[penerima]' where no_smu='$_POST[nosmubtb]'");
		 mysql_query("UPDATE breakdown set status_bayar='yes' where id_breakdown='$_POST[id_breakdown]'");
	}

    $t=mysql_query("select * from deliverybill order by id_deliverybill DESC limit 1");
	$r=mysql_fetch_array($t);

  header('location:media.php?module=cetakdb&n='.$r['id_deliverybill']);
?>