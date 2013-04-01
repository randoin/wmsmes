<?php
$tglawal=my2date($_POST[tglawal]);

$k=mysql_query("SELECT nama_lengkap,nipp FROM user where id_user='$_SESSION[namauser]'");
$ka=mysql_fetch_array($k);
$kasir=$ka[0];$nipp=$ka[1];

	class PDF extends FPDF
	{
		//Page header
		function Header()
		{	
//		$this->SetTopMargin(5);			
			//$this->SetY(10);
			$this->SetFillColor(255,255,255);
			$this->SetFont('Arial','',12);
			$this->Cell(170,8,'PERINCIAN FLOWN AIRWAYBILL(AWB)',0,0,'C');
			$this->Ln();
			$this->Cell(170,8,'PT. GARUDA INDONESIA',0,0,'C');	$this->Ln();		
			$this->SetFont('Times','I',11);
			$this->Cell(170,8,'Tanggal : '.$_POST[tglawal],0,0,'L',1);$this->Ln(10);

	
				
		}
		
		//Page footer
		function Footer()
		{
			//Position at 1.5 cm from bottom
			$this->SetY(-80);
			//Arial italic 8
			$this->SetFont('Arial','I',9);
			//Page number
			$this->Cell(0,10,'GAPURA MEDAN WMS INTER - Page '.$this->PageNo().'/{nb}',0,0,'C');
		}
	}
	
	//Instanciation of inherited class
	$pdf=new PDF('P','mm','A4');
		//$pdf->SetLeftMargin(20);		
	$pdf->SetMargins(20,10,5);	
	//$pdf->SetY(10);
	
	$pdf->AliasNbPages();
	//buka file
	$pdf->Open();
	
	//Disable automatic page break
	$pdf->SetAutoPageBreak(on,80);
	
	
	//set nilai posisi y pada setiap halaman
	$y_axis_initial = 32;
	$y_axis1 = 32;
	//tinggi baris
	$row_height = 6;	
	
	$y_axis = 32; // $y_axis_initial + $row_height;
				$pdf->SetFillColor(255,255,255);
   $pdf->AddPage();	

			$pdf->SetFont('Arial','',9);
			$pdf->Cell(10,5,'No',1,0,'C',1);
			$pdf->Cell(40,5,'No.AWB',1,0,'C',1);
			$pdf->Cell(20,5,'FLT NUM',1,0,'C',1);
			$pdf->Cell(25,5,'DATE',1,0,'C',1);		
			$pdf->Cell(20,5,'DEST',1,0,'C',1);		
			$pdf->Cell(20,5,'AGENT',1,0,'C',1);		
			$pdf->Cell(40,5,'REMARK',1,0,'C',1);
			$pdf->SetFont('Arial','',9);$pdf->Ln();								
$no=0;
				
/*		$str_data=mysql_query("SELECT s.nosmu,f.flight,m.flightdate,d.dest_code,a.agent FROM manifestout as m, master_smu as s,flight as f, origin as o, destination as d,agent as a,customer as c,isimanifestout as i WHERE m.idmanifestout=i.idmanifestout AND m.idflight=f.idflight AND m.statusconfirm='1' AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND o.origin_code='DPS' AND s.idagent=a.idagent AND f.idcustomer=c.idcustomer AND a.agent<>'RPX' AND a.agent<>'POST' AND a.agent<>'GMFAA' AND a.agent<>'GARUDA' AND c.customer='GA' AND i.idmastersmu=s.idmastersmu AND  m.flightdate='$tglawal' group by s.idmastersmu
		");
		*/
$str_data=mysql_query("SELECT s.nosmu,f.flight,m.flightdate,d.dest_code,a.agent FROM manifestout as m, master_smu as s,flight as f, origin as o, destination as d,agent as a,customer as c,isimanifestout as i WHERE m.idmanifestout=i.idmanifestout AND m.idflight=f.idflight AND m.statusconfirm='1' AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND o.origin_code='MES' AND s.idagent=a.idagent AND f.idcustomer=c.idcustomer AND c.customer='GA' AND i.idmastersmu=s.idmastersmu AND  m.flightdate='$tglawal' group by s.idmastersmu
		");
  		while($r=mysql_fetch_array($str_data))  
  		{
if(format_flown($r[nosmu])=='126')
{
	
$no+=1;
			$pdf->Cell(10,5,$no,1,0,'R',1);
			$pdf->Cell(40,5,format_awb($r[nosmu]),1,0,'L',1);
			$pdf->Cell(20,5,$r[flight],1,0,'L',1);
			$pdf->Cell(25,5,$_POST[tglawal],1,0,'L',1);		
			$pdf->Cell(20,5,$r[dest_code],1,0,'L',1);		
			$pdf->Cell(20,5,$r[agent],1,0,'L',1);		
			$pdf->Cell(40,5,'',1,0,'C',1);$pdf->Ln();			
	}	
		}
		$pdf->Ln(10);	
  				$pdf->Cell(50,6,'Yang Menyerahkan',0,0,'C',1);
				 $pdf->Cell(15,6,'',0,0,'C',1);
				 $pdf->Cell(50,6,'Mengetahui',0,0,'C',1);
				$pdf->Ln(20);	
  				$pdf->Cell(50,6,'( ..................................... )',0,0,'C',1); 
  				$pdf->Cell(15,6,'',0,0,'C',1); 				
				$pdf->Cell(50,6,'( ..................................... )',0,0,'C',1);
				$pdf->Ln(15);				
	
	$pdf->Output('flown_ga.pdf','I');
?>