<?php
$a=mysql_query("SELECT * FROM out_dtbarang_h,out_dtbarang,typebarang 
where out_dtbarang_h.id=out_dtbarang.id_h AND out_dtbarang.dtBarang_type=typebarang.typebarang AND
out_dtbarang_h.id='$_GET[i]' AND out_dtbarang_h.isvoid='0'");
$d=mysql_fetch_array($a);
$str=mysql_query("SELECT * FROM out_dtbarang where id_h='$_GET[i]'");
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

    $pdf->Header($tgl);
    $pdf->AddPage();
$pdf->SetLeftMargin(3);				
$waktu=date("d-m-Y H:i:s");
			$pdf->SetFont('arial','',10);
			$pdf->Ln(5);
			$pdf->Cell(60,4,$waktu,0,0,'R',1);
			$pdf->Ln(10);
			$pdf->Cell(60,4,'PT. GAPURA ANGKASA',0,0,'C',1);$pdf->Ln();
			$pdf->Cell(60,4,'CAB. BANDARA POLONIA MEDAN',0,0,'C',1);$pdf->Ln();
			$pdf->Cell(60,4,'CARGO INTERNATIONAL',0,0,'C',1);$pdf->Ln();

			$pdf->Cell(60,4,'-------------------------------------------------------------',0,0,'C',1);			
			$pdf->Ln();		
			$pdf->Cell(60,4,'BUKTI TIMBANG BARANG',0,0,'C',1);$pdf->Ln(5);
			$pdf->Cell(20,4,'No.BTB',0,0,'L',1);
			$pdf->Cell(40,4,': '.$d[btb_smu],0,0,'L',1);$pdf->Ln(4);
			$pdf->Cell(20,4,'Pengirim/Agent',0,0,'L',1);
			$pdf->Cell(40,4,': '.$d[btb_agent],0,0,'L',1);$pdf->Ln(4);
			$pdf->Cell(20,4,'Airline/Tujuan',0,0,'L',1);
			$pdf->Cell(40,4,': '.$d[airline].'/'.$d[btb_tujuan],0,0,'L',1);$pdf->Ln(4);
			$pdf->Cell(20,4,'No.SMU',0,0,'L',1);
			$pdf->Cell(40,4,': '.$d[btb_smu],0,0,'L',1);$pdf->Ln(4);	
			$pdf->Cell(20,4,'Jenis Barang',0,0,'L',1);
			$pdf->Cell(40,4,': '.$d[kategori],0,0,'L',1);$pdf->Ln(4);												
			$pdf->Cell(60,4,'-------------------------------------------------------------',0,0,'C',1);$pdf->Ln();								
			$pdf->Cell(69,4,'BERAT ',0,0,'C',1);$pdf->Ln(4);	
			
			$pdf->Cell(7,4,'NO',0,0,'C',1);
			$pdf->Cell(13,4,'KOLI',0,0,'C',1);
			$pdf->Cell(40,4,'---------------------------------------',0,0,'C',1);$pdf->Ln(4);				
			
			$pdf->Cell(5,4,'',0,0,'C',1);
			$pdf->Cell(15,4,'',0,0,'C',1);
			$pdf->Cell(12,4,'AKTUAL',0,0,'C',1);
			$pdf->Cell(4,4,'',0,0,'C',1);
			$pdf->Cell(12,4,'PxLxT',0,0,'C',1);
			$pdf->Cell(12,4,'VOL',0,0,'C',1);$pdf->Ln(4);												
			$pdf->Cell(60,4,'-------------------------------------------------------------',0,0,'C',1);	$pdf->Ln(4);		
	$no=1;		
//				$pdf->SetFont('helvetica','',9);
	while($r=mysql_fetch_array($str))//
	{
		
			$pdf->Cell(7,3,$no,0,0,'C',1);
			$pdf->Cell(10,3,$r[dtBarang_koli],0,0,'C',1);
			$pdf->Cell(12,3,$r[dtBarang_berat],0,0,'C',1);
			$pdf->Cell(1,3,'',0,0,'C',1);
			$pdf->Cell(20,3,number_format($r[dtBarang_panjang], 0, '.', '.').' x '.number_format($r[dtBarang_lebar], 0, '.', '.').' x '.number_format($r[dtBarang_tinggi], 0, '.', '.'),0,0,'C',1);
			$pdf->Cell(12,3,number_format($r[dtBarang_luasdimensi], 0, '.', '.'),0,0,'L',1);$pdf->Ln(4);
			$no+=1;
		}													
			$pdf->Cell(60,3,'-------------------------------------------------------------',0,0,'C',1);	$pdf->Ln(4);					

  			$pdf->Cell(7,3,'TTL:',0,0,'L',1);
			$pdf->Cell(10,3,$d[btb_totalkoli],0,0,'C',1);
			$pdf->Cell(12,3,$d[btb_totalberat],0,0,'C',1);
			$pdf->Cell(1,3,'',0,0,'C',1);
			$pdf->Cell(20,3,'',0,0,'C',1);
			$pdf->Cell(12,3,$d[btb_totalvolume],0,0,'L',1);$pdf->Ln(4);												
			$pdf->Cell(60,3,'= = = = = = = = = = = = = = = = = = = = = = = = = ',0,0,'C',1);	$pdf->Ln(4);	 		
 			$pdf->Cell(50,3,'TOTAL BERAT DIBAYAR',0,0,'L',1);
			$pdf->Cell(12,3,$d[btb_totalberatbayar],0,0,'L',1);$pdf->Ln(4);												
			$pdf->Cell(60,3,'= = = = = = = = = = = = = = = = = = = = = = = = = ',0,0,'C',1);	$pdf->Ln(10);	 		

		//bikin halaman baru
			
			//siapkan data
	$pdf->Cell(30,3,'Penimbang :',0,0,'C',0);
	$pdf->Cell(30,3,'Pengirim',0,0,'C',0);	
	$pdf->Ln(15);	
	$pdf->Cell(30,3,'('.$d[createdby].')',0,0,'C',0);
	$pdf->Cell(30,3,'('.$d[btb_agent].')',0,0,'C',0);	
	$pdf->Output();
?>