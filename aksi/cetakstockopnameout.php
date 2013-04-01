<?php
	class PDF extends FPDF
	{
		function Header()
		{
			$tglnya=date("Y-m-d");
			$tgl='Kondisi Tanggal : '.ymd2dmy($tglnya);
			$this->SetFont('Arial','B',14);
			$this->Ln();
			$this->Cell(170,20,'STOCK OPNAME EXPORT',0,0,'C');
			$this->Ln(10);		
 			$this->SetFont('Arial','B',11);
			$this->Cell(170,20,$tgl,0,0,'C');			
			$this->Ln();
				
		}

	//Page footer
		function Footer()
		{
			//Position at 1.5 cm from bottom
			$this->SetY(-15);
			//Arial italic 8
			$this->SetFont('Arial','I',8);
			//Page number
			$this->Cell(0,10,'GAPURA MEDAN WMS INTER - Page '.$this->PageNo().'/{nb}',0,0,'C');
		}
		
	}
	
$nama=mysql_fetch_array(mysql_query("SELECT nama_lengkap, code, nipp from user 
where id_user= '$_SESSION[namauser]'"));

	$pdf=new PDF('P','mm','A4');
//	$pdf->SetMargins(5,1,5);	
		$pdf->SetMargins(15,10,5);	
	
	$pdf->AliasNbPages();
	//buka file
	$pdf->Open();
	
	//Disable automatic page break
	$pdf->SetAutoPageBreak(on,50);
	
	//set nilai posisi y pada setiap halaman
	$y_axis_initial = 32;
	$y_axis1 = 32;
	//tinggi baris
	$row_height = 6;	
	
	$y_axis = 32; // $y_axis_initial + $row_height;
//utk joining
$no=1;
$data=mysql_query("select s.*,o.origin_code,d.dest_code from stockopnameout as s,origin as o, destination as d WHERE s.idorigin=o.idorigin AND s.iddestination = d.iddestination 
AND o.origin_code='MES' order by d.dest_code ASC");
 $pdf->AddPage();
$berat=0;$koli=0;
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(10,5,'JOINING',0,0,'L',1);
			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','B',11);
				$pdf->Ln();
		$pdf->Cell(10,12,'No',1,0,'C',1);
			$pdf->Cell(30,12,'#AWB',1,0,'C',1);
			$pdf->Cell(20,12,'DATE',1,0,'C',1);
			$pdf->Cell(25,12,'COLLIES',1,0,'C',1);
			$pdf->Cell(25,12,'KG',1,0,'C',1);
			$pdf->Cell(15,12,'ORG',1,0,'C',1);
			$pdf->Cell(15,12,'DEST',1,0,'C',1);
			
			$pdf->Cell(40,12,'REMARK',1,0,'C',1);
			$pdf->Ln();		
while ($r=mysql_fetch_array($data))
{
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(10,5,$no,1,0,'C',1);
		$pdf->Cell(30,5,format_awb($r[nosmu]),1,0,'C',1);
		$pdf->Cell(20,5,ymd2dmy($r['tglsmu']),1,0,'C',1);	
		$pdf->Cell(25,5,$r[koli].' of '.$r[koli_of],1,0,'R',1);
		$pdf->Cell(25,5,$r[berat].' of '.$r[berat_of],1,0,'R',1);	
		$pdf->Cell(15,5,$r[origin_code],1,0,'C',1);
		$pdf->Cell(15,5,$r[dest_code],1,0,'C',1);	
		$pdf->Cell(40,5,'',1,0,'C',1);	
		$pdf->Ln();
  $berat_jo+=$r[berat];$koli_jo+=$r[koli];
	$no+=1;
}
		$pdf->SetX(55);
		$pdf->Cell(20,5,'JUMLAH',1,0,'R',1);	
		$pdf->Cell(25,5,$koli_jo,1,0,'R',1);
		$pdf->Cell(25,5,$berat_jo,1,0,'R',1);	
$jmlsmu=$no-1;		
$pdf->Ln(10);
//utk transit
$no=1;
$data=mysql_query("select s.*,o.origin_code,d.dest_code from stockopnameout as s,origin as o, destination as d WHERE s.idorigin=o.idorigin AND s.iddestination = d.iddestination 
AND o.origin_code<>'MES' order by d.dest_code ASC");
 $berat_tr=0;$koli_tr=0;
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(10,5,'TRANSIT',0,0,'L',1);
			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','B',11);
				$pdf->Ln();
		$pdf->Cell(10,12,'No',1,0,'C',1);
			$pdf->Cell(30,12,'#AWB',1,0,'C',1);
			$pdf->Cell(20,12,'DATE',1,0,'C',1);
			$pdf->Cell(25,12,'COLLIES',1,0,'C',1);
			$pdf->Cell(25,12,'KG',1,0,'C',1);
			$pdf->Cell(15,12,'ORG',1,0,'C',1);
			$pdf->Cell(15,12,'DEST',1,0,'C',1);
			
			$pdf->Cell(40,12,'REMARK',1,0,'C',1);
			$pdf->Ln();		
while ($r=mysql_fetch_array($data))
{
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(10,5,$no,1,0,'C',1);
		$pdf->Cell(30,5,format_awb($r[nosmu]),1,0,'C',1);
		$pdf->Cell(20,5,ymd2dmy($r['tglsmu']),1,0,'C',1);	
		$pdf->Cell(25,5,$r[koli].' of '.$r[koli_of],1,0,'R',1);
		$pdf->Cell(25,5,$r[berat].' of '.$r[berat_of],1,0,'R',1);	
		$pdf->Cell(15,5,$r[origin_code],1,0,'C',1);
		$pdf->Cell(15,5,$r[dest_code],1,0,'C',1);	
		$pdf->Cell(40,5,'',1,0,'C',1);	
		$pdf->Ln();
  $berat_tr+=$r[berat];$koli_tr+=$r[koli];
	$no+=1;
}
	$jmlsmu+=$no-1;
	$pdf->SetX(55);
		$pdf->Cell(20,5,'JUMLAH',1,0,'R',1);	
		$pdf->Cell(25,5,$koli_tr,1,0,'R',1);
		$pdf->Cell(25,5,$berat_tr,1,0,'R',1);	
	$pdf->Ln(10);
		$pdf->Cell(100,5,'TOTAL JUMLAH STOK :  '.$jmlsmu.' sheets =>  '
		.number_format($koli_tr+$koli_jo, 0, ',', '.').' koli / '
		.number_format($berat_tr+$berat_jo, 1, ',', '.').' kg',0,0,'L',0);
		$pdf->Ln(10);
	$pdf->Cell(40,8,'CHECKED : ',0,0,'C',1);$pdf->Ln(10);
	$pdf->Cell(120,5,$nama[nama_lengkap],0,0,'L',1);
	$pdf->Ln(5);
	$pdf->Cell(120,1,'----------------------------',0,0,'L',1);
	$pdf->Ln();
	$pdf->Cell(120,5,'ID NBR. '.$nama[nipp],0,0,'L',1);
	$pdf->Output();
?>