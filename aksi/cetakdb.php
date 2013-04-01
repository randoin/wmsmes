<?php
$t=mysql_query("SELECT * FROM deliverybill where id_deliverybill='$_GET[n]'");
$r=mysql_fetch_array($t);

if($r['status']=='0')
{
	$t=mysql_query("SELECT *
					  FROM deliverybill,
					  	   isimanifestin,
						   user,
						   breakdown 
					 where deliverybill.nosmu=isimanifestin.no_smu 
					   AND deliverybill.user=user.id_user 
					   AND id_deliverybill='$_GET[n]' 
					   AND deliverybill.idbreakdown=breakdown.id_breakdown
					");
	$r=mysql_fetch_array($t);
	
	if($r['agent']=='')
		{
			$namapenerima=$r['penerima'];
			$alamatpenerima=$r['alamatpenerima'];
			$npwppenerima=$r['npwp'];
		} 
		else
		{
			$a=mysql_fetch_array(mysql_query("select * from agent where btb_agent='$r[agent]'"));
			$namapenerima=$a['agentfullname'];
			$alamatpenerima=$a['address'];
			$npwppenerima=$a['npwp'];
		}
		
	$nodb='No.DBI-'.$r['nodb'];
	$tglmasuk=$r['tglmanifest'];
}
	else if($r['status']=='1')
	{
		$t=mysql_query("SELECT * 
						  FROM deliverybill,
							   out_dtbarang_h,
							   out_dtbarang,
							   user 
						 where deliverybill.no_smubtb=out_dtbarang_h.btb_nobtb 
						   AND out_dtbarang_h.id=out_dtbarang.id_h 
						   AND deliverybill.user=user.id_user 
						   AND id_deliverybill='$_GET[n]'
						");
		$r=mysql_fetch_array($t);
		
		$a=mysql_fetch_array(mysql_query("select * from agent where btb_agent='$r[btb_agent]'"));
		
		$nodb='No.DBO-'.$r['nodb'];
		$tglmasuk=$r['btb_date'];
	}		
if($r['nofaktur']=='')
	{ 
		$nofaktur='';
	}
	else 
	{
		$th=substr($r['nofaktur'],0,2);
		$nof=substr($r['nofaktur'],2,8);
		$nofaktur='010.002-'.$th.'-'.$nof;}

	//$totalbayar=$r['overtime']+$r['document']+$r['lain']-$r['diskon'];

class PDF extends FPDF
{
	//Page header
	function Header()
	{
		$this->SetFillColor(255,255,255);			
	}
}
	
	//Instanciation of inherited class
	$pdf=new PDF('P','mm','A4');
	$pdf->SetMargins(5,1,5);
	
	$pdf->AliasNbPages();
	//buka file
	$pdf->Open();
	
	//Disable automatic page break
	$pdf->SetAutoPageBreak(false);
	
	//set nilai posisi y pada setiap halaman
	$y_axis_initial = 32;
	$y_axis1 = 32;
	//tinggi baris
	$row_height = 6;	
	
	$y_axis = 32; // $y_axis_initial + $row_height;
	$no=1;
	$j1=ymd2dmy(date('Y-m-d'));
	$s1=date('H:i:s');

    $pdf->Header($tgl);
    $pdf->AddPage();

		$pdf->SetFont('times','B',10);
		$pdf->Ln(2);
		$pdf->Cell(60,10,$nofaktur,0,0,'R',1);
		$pdf->Ln();
		$pdf->Cell(60,10,$nodb,0,0,'R',1);
		$pdf->Ln();
		$pdf->SetFont('times','',9);			
		$pdf->Cell(60,4,'PT. GAPURA ANGKASA',0,0,'C',1);
		$pdf->Ln();
		$pdf->Cell(60,4,'GEDUNG DAPENRA LT 1,2 & 3 KOTA BARU',0,0,'C',1);
		$pdf->Ln();
		$pdf->Cell(60,4,'BANDAR KEMAYORAN BLOK B 12 KAV NO.8',0,0,'C',1);
		$pdf->Ln();
		$pdf->Cell(60,4,'KEMAYORAN JAKARTA PUSAT 10610',0,0,'C',1);
		$pdf->Ln();
		$pdf->Cell(60,4,'NPWP : 01.061.170.5-093.000',0,0,'C',1);
		$pdf->Ln();
		$pdf->Cell(60,4,'----------------------------------------------------------',0,0,'C',1);
		$pdf->Ln();						
		$pdf->Cell(60,4,'NOTA PEMBAYARAN JASA GUDANG',0,0,'C',1);
		$pdf->Ln();
		$pdf->Cell(60,4,'----------------------------------------------------------',0,0,'C',1);
		$pdf->Ln();
		
		if($r['status']=='1')
		{	
			$cu='PENGIRIM';								
			$pdf->Cell(60,6,'PENGIRIM',0,0,'C',1);
			$pdf->Ln();
			$pdf->Cell(30,4,'Nama',0,0,'L',1);
			$pdf->Cell(40,4,': '.$a['btb_agent'],0,0,'L',0);
			$pdf->Ln();
			$pdf->Cell(30,4,'NPWP',0,0,'L',1);
			$pdf->Cell(40,4,': '.$a['npwp'],0,0,'L',1);
			$pdf->Ln();
			$pdf->Cell(30,4,'Alamat',0,0,'L',1);
			$pdf->Cell(40,4,': '.$a['address'],0,0,'L',0);
			$pdf->Ln();
		}
		else
		{
			$cu='PENERIMA';								
			$pdf->Cell(60,6,'Penerima',0,0,'C',1);
			$pdf->Ln();
			$pdf->Cell(30,4,'Nama',0,0,'L',1);
			$pdf->Cell(40,4,': '.$namapenerima,0,0,'L',0);
			$pdf->Ln();
			$pdf->Cell(30,4,'NPWP',0,0,'L',1);
			$pdf->Cell(40,4,': '.$npwppenerima,0,0,'L,0');
			$pdf->Ln();
			$pdf->Cell(30,4,'Alamat',0,0,'L',1);
			$pdf->Cell(40,4,': '.$alamatpenerima,0,0,'L',0);
			$pdf->Ln();
		}
		
		$pdf->Cell(60,6,'DATA BARANG',0,0,'C',1);
		$pdf->Ln();
		if($r['status']=='1')
	  	{ 
			$smu=$r['nosmu'];
		} 
		else if($r[status=='0'])
		{
			$smu=$r['nosmubtb'];
		}

		$pdf->Cell(30,4,'No.SMU',0,0,'L',1);
//			$pdf->Cell(30,4,': '.$smu,0,0,'L',1);
     	 $pdf->MultiCell(30,4,': '.$smu,0,'L',0);				
	//		$pdf->Ln();	
		if($r[status]=='1')
		{
			$pdf->Cell(30,4,'Tujuan Airport',0,0,'L',1);
			$pdf->Cell(30,4,': '.$r['btb_tujuan'],0,0,'L',1);	
			$pdf->Ln();
		} 
		else 
		{
			$pdf->Cell(30,4,'Asal Airport',0,0,'L',1);
			$pdf->Cell(30,4,': '.$r['dest_code'],0,0,'L',1);
			$pdf->Ln();
		}		
		
		$pdf->Cell(30,4,'Tgl Masuk/Keluar',0,0,'L',1);
		$pdf->Cell(30,4,': '.ymd2dmy($tglmasuk).' / '.ymd2dmy($r['tglbayar']),0,0,'L',1);
		$pdf->Ln();
		
		$pdf->Cell(30,4,'Koli/Berat Aktual',0,0,'L',1);
		if($r[status]=='1')
		{
			$pdf->Cell(30,4,': '.$r['btb_totalkoli'].' Koli / '.$r['btb_totalberat'].' Kg',0,0,'L',1);
			$pdf->Ln();
		} 
		else 
		{
			$pdf->Cell(30,4,': '.$r['kolidatang'].' Koli / '.$r['beratdatang'].' Kg',0,0,'L',1);
			$pdf->Ln();
		}
		
		$pdf->Cell(30,4,'Berat yang dibayar',0,0,'L',1);
		if($r[status]=='1')
		{
			$pdf->Cell(30,4,': '.$r['btb_totalberatbayar'].' Kg',0,0,'L',1);
			$pdf->Ln();	
		}
		else if($r[status=='0'])
		{
			$pdf->Cell(30,4,': '.$r['beratbayar'].' Kg',0,0,'L',1);
			$pdf->Ln();	
		}				 
		 	 
		$pdf->Cell(30,4,'Komoditi',0,0,'L',1);
		if($r[status]=='1')
		{
			$pdf->Cell(30,4,': '.$r['dtBarang_type'],0,0,'L',1);
			$pdf->Ln();
		} 
		else 
		{
			$pdf->Cell(30,4,': '.$r['jenisbarang'],0,0,'L',1);
			$pdf->Ln();
		} 	
		
	 	/*
		if($r[status]=='1')
		{
			$pdf->Cell(30,4,'Pengirim/Agent',0,0,'L',1);
  		 	//$pdf->MultiCell(40,4,': '.$r[agent],0,'L',0);		 
		 	$pdf->Cell(40,4,': '.$r['btb_agent'],0,0,'L',1);$pdf->Ln();
		} 
		else 
 		{
			$pdf->Cell(30,4,'Penerima',0,0,'L',1);
  		 	$pdf->MultiCell(40,4,': '.$r['penerima'],0,'L',0);		 
			// $pdf->Cell(40,4,': '.$r[penerima],0,0,'L',1);$pdf->Ln();
		}
		*/		 
		
		$pdf->Cell(60,6,'RINCIAN BIAYA',0,0,'C',1);
		$pdf->Ln();
		 		
		$pdf->Cell(30,4,'Jumlah Hari',0,0,'L',1);
		$pdf->Cell(30,4,': '.$r['hari'].' Hari', 0, 0,'L',1);				
		$pdf->Ln();
	 			
		$pdf->Cell(30,4,'Sewa Gudang',0,0,'L',1);
		$pdf->Cell(30,4,': Rp. '.number_format($r['sewagudang'], 0, '.', '.'),0,0,'L',1);						
		$pdf->Ln();
			
		$pdf->Cell(30,4,'Diskon',0,0,'L',1);
		$pdf->Cell(40,4,': Rp. '.number_format($r['sewagudang_discount'], 0, '.', '.'),0,0,'L',1);				
		$pdf->Ln();
		
		$pdf->Cell(30,4,'Tot Sewa Gudang',0,0,'L',1);
		$pdf->Cell(40,4,': Rp. '.number_format($r['sewagudang_after_discount'], 0, '.', '.'),0,0,'L',1);				
		$pdf->Ln();
		
		//$pdf->Cell(30,4,'Cargo Charge',0,0,'L',1);
		//$pdf->Cell(40,4,': Rp. '.number_format($r['cargocharge'], 0, '.', '.'),0,0,'L',1);
		//$pdf->Ln();
			
		$pdf->Cell(30,4,'KADE',0,0,'L',1);
		$pdf->Cell(40,4,': Rp. '.number_format($r['kade'], 0, '.', '.'),0,0,'L',1);
		$pdf->Ln();
 
		$pdf->Cell(30,4,'Administrasi',0,0,'L',1);
		$pdf->Cell(40,4,': Rp. '.number_format($r['administrasi'], 0, '.', '.'),0,0,'L',1);				
		$pdf->Ln();
		
	 	$pdf->Cell(30,4,'PPn(10%)',0,0,'L',1);
		$pdf->Cell(40,4,': Rp. '.number_format($r['ppn'], 0, '.', '.'),0,0,'L',1);				
		$pdf->Ln();
						
		$pdf->Cell(30,4,'TOTAL ',0,0,'R',1);
		$pdf->Cell(30,4,': Rp. '.number_format($r['total_biaya'], 0, '.', '.'),0,0,'L',1);								
		$pdf->Ln();
		
		$bilang=terbilang($r['total_biaya'],1);
		$pdf->MultiCell(60,4,'Terbilang : ' .$bilang.' RUPIAH',0,'J',0);				
												
						
			
		$pdf->Ln(5);			

  

		//bikin halaman baru
			
		//siapkan data
		$pdf->SetFont('times','',8);
		$pdf->Cell(30,5,'',0,0,'L',0);
		$pdf->Cell(30,5,$j1.''.$s1,0,0,'C',0);
		$pdf->Ln(15);
		
		$pdf->Cell(30,5,'Kasir',0,0,'C',0);
		$pdf->Cell(30,5,$cu,0,0,'C',0);
		$pdf->Ln(15);
			
		$pdf->Cell(30,4,$r[nama_lengkap],0,0,'C',0);	
		$pdf->Ln(1);	
		$pdf->Cell(30,4,'--------------------------',0,0,'L',0);	
		$pdf->Cell(30,4,'--------------------------',0,0,'R',0);	

		$pdf->Ln(3);	
	
		$pdf->Cell(30,4,'NIPP. '.$r[nipp],0,0,'C',0);
		$pdf->Ln();
		
		$pdf->Cell(60,6,'TERIMA KASIH',0,0,'C',1);
				$pdf->Ln(4);		
				
				$pdf->SetFont('times','',7);
	
				if($r['status']=='1')
				{
				$pdf->Cell(60,6,' F-MES-FF-03A',0,0,'R',1);		
				} 
		 		else 
				{
				$pdf->Cell(60,6,' F-MES-FF-02A',0,0,'R',1);
				}

/*$file = $nodb;
$file .= '.pdf';
//Save PDF to file
$pdf->Output($file, 'F');
//Redirect
header('Location: '.$file);*/
		$pdf->Output();
?>