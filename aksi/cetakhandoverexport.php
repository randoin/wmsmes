<?php
	class PDF extends FPDF
	{

	}
	

	$pdf=new PDF('P','mm','half');
		$pdf->SetMargins(15,15,15);	
	
	$pdf->AliasNbPages();
	//buka file
	$pdf->Open();
	
	//Disable automatic page break
	$pdf->SetAutoPageBreak(off);
	
	//set nilai posisi y pada setiap halaman
	$y_axis_initial = 32;
	$y_axis1 = 32;
	//tinggi baris
	$row_height = 6;	
	
	$y_axis = 32; // $y_axis_initial + $row_height;
	
//cek dulu data pesawatnya
$flight=mysql_fetch_array(mysql_query("SELECT m.idmanifestout,m.acregister,m.flightdate,m.pointofloading,m.pointul,m.statusnil,m.etd,
f.flight,o.origin_code, d.dest_code,m.statusconfirm,m.statuscancel,c.bendera,c.cus_desc
FROM manifestout as m,origin as o,destination as d,flight as f, customer as c
WHERE m.idorigin=o.idorigin AND m.iddestination=d.iddestination AND m.idflight=f.idflight AND m.statusvoid='0' AND f.idcustomer=c.idcustomer AND m.idmanifestout='$_GET[idm]'")); 

$nama=mysql_fetch_array(mysql_query("SELECT u.nama_lengkap, u.code, u.nipp from user as u,manifestout as m where u.id_user=m.username AND m.idmanifestout='$_GET[idm]'"));

$jmlsmu=mysql_num_rows(mysql_query("select idmastersmu from isimanifestout where idmanifestout='1' AND statusvoid='0' AND statuscancel='0' GROUP BY idmastersmu"));

	
	$pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',14);
		$pdf->Cell(170,5,'CARGO DOCUMENTS HANDOVER',0,0,'C',1);
		$pdf->Ln(10);
		$pdf->SetFont('Arial','',10);
	$pdf->Cell(30,5,'FLIGHT  NO',0,0,'L',1);$pdf->Cell(90,5,': '.$flight[flight],0,0,'L',1);	
	$pdf->Cell(30,5,'DATE',100,'L',1);$pdf->Cell(30,5,': '.ymd2dmy($flight[flightdate]),0,0,'L',1);$pdf->Ln();
	$pdf->Cell(30,5,'FROM',0,0,'L',1);$pdf->Cell(90,5,': '.$flight[origin_code],0,0,'L',1);	$pdf->Cell(30,5,'DELIVERY TIME',0,0,'L',1);$pdf->Cell(30,5,'',0,0,'R',1);$pdf->Ln();
	$pdf->Cell(30,5,'REGISTRATION',0,0,'L',1);$pdf->Cell(90,5,': '.$flight[acregister],0,0,'L',1);	$pdf->Cell(30,5,'ETD ',0,0,'L',1);$pdf->Cell(30,5,': '.$flight[etd],0,0,'L',1);$pdf->Ln(8);	
	$pdf->Cell(10,8,'NO',1,0,'C',1);$pdf->Cell(70,8,'DOCUMENTS',1,0,'C',1);	$pdf->Cell(30,8,'DEST ',1,0,'C',1);$pdf->Cell(70,8,'REMARKS',1,0,'C',1);$pdf->Ln();
		$pdf->Cell(10,5,'',1,0,'C',1);$pdf->Cell(70,5,'',1,0,'C',1);	$pdf->Cell(30,5,' ',1,0,'C',1);$pdf->Cell(70,5,'',1,0,'C',1);$pdf->Ln();
		$pdf->Cell(10,5,'1',1,0,'C',1);$pdf->Cell(70,5,'CARGO & MAIL MANIFEST',1,0,'L',1);	$pdf->Cell(30,5,$flight[dest_code],1,0,'C',1);$pdf->Cell(70,5,'',1,0,'C',1);$pdf->Ln();	
/*		$pdf->Cell(10,5,'',1,0,'C',1);$pdf->Cell(70,5,'- AWB           = '.$jmlsmu.' sheet',1,0,'L',1);	$pdf->Cell(30,5,' ',1,0,'C',1);$pdf->Cell(70,5,'',1,0,'C',1);$pdf->Ln();
$pdf->Cell(10,5,'',1,0,'C',1);$pdf->Cell(70,5,'- MANIFEST =',1,0,'L',1);	$pdf->Cell(30,5,' ',1,0,'C',1);$pdf->Cell(70,5,'',1,0,'C',1);$pdf->Ln();*/
		$pdf->Cell(10,5,'',1,0,'C',1);$pdf->Cell(70,5,'',1,0,'C',1);	$pdf->Cell(30,5,' ',1,0,'C',1);$pdf->Cell(70,5,'',1,0,'C',1);$pdf->Ln(10);
$pdf->Cell(120,5,'CARGO OFFICER',0,0,'L',1);
$pdf->Cell(70,5,'PURSER/CREW ON DUTY',0,0,'L',1);$pdf->Ln();	
$pdf->Cell(120,5,'PT. GAPURA ANGKASA',0,0,'L',1);
$pdf->Cell(70,5,'',0,0,'L',1);$pdf->Ln(15);
$pdf->Cell(120,5,$nama[nama_lengkap].'/MESKFXH',0,0,'L',1);
$pdf->Cell(70,5,'',0,0,'L',1);$pdf->Ln(5);
$pdf->Cell(120,1,'----------------------------',0,0,'L',1);
$pdf->Cell(70,1,'----------------------------',0,0,'L',1);$pdf->Ln();
$pdf->Cell(120,5,'ID NBR. '.$nama[nipp],0,0,'L',1);
$pdf->Cell(70,5,'ID NBR',0,0,'L',1);$pdf->Ln();
	
	$pdf->Output();
?>