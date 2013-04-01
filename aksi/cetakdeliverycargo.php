<?php
	class PDF extends FPDF
	{

	}
	

	$pdf=new PDF('P','mm','half');
		//$pdf->SetMargins(1,1,1);	//LTR
	$pdf->SetTopMargin(25);
	
	$pdf->AliasNbPages();
	//buka file
	$pdf->Open();
	


	$pdf->SetAutoPageBreak(on,1);
	

	
//cek dulu data pesawatnya
$flight=mysql_fetch_array(mysql_query("SELECT m.idmanifestout,m.acregister,m.flightdate,m.pointofloading,m.pointul,m.statusnil,m.etd,
f.flight,o.origin_code, d.dest_code,m.statusconfirm,m.statuscancel,c.bendera,c.cus_desc
FROM manifestout as m,origin as o,destination as d,flight as f, customer as c
WHERE m.idorigin=o.idorigin AND m.iddestination=d.iddestination AND m.idflight=f.idflight AND m.statusvoid='0' AND f.idcustomer=c.idcustomer AND m.idmanifestout='$_GET[idm]'")); 

$nama=mysql_fetch_array(mysql_query("SELECT u.nama_lengkap, u.code, u.nipp from user as u,manifestout as m where u.id_user=m.username AND m.idmanifestout='$_GET[idm]'"));

/**$jmlsmu=mysql_num_rows(mysql_query("select idmastersmu from isimanifestout where idmanifestout='1' AND statusvoid='0' AND statuscancel='0' GROUP BY idmastersmu"));
*/


$datauld=mysql_query("SELECT i.nould,sum(i.berat) as berat,d.dest_code  FROM isimanifestout as i, manifestout as m,master_smu as s, destination as d 
where m.idmanifestout=i.idmanifestout AND i.idmastersmu=s.idmastersmu AND
s.iddestination=d.iddestination AND i.idmanifestout='$_GET[idm]'
AND i.statusvoid='0' AND i.statuscancel='0' AND m.statusvoid='0' AND 
m.statuscancel='0' AND m.statusconfirm='1' 
GROUP BY i.nould order by i.idisimanifestout");
	
	$pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',10);
	$pdf->Cell(20,5,'',0,0,'L',1);$pdf->Cell(40,5,': '.$flight[flight],0,0,'L',1);	
	$pdf->Cell(10,5,'',100,'L',1);$pdf->Cell(40,5,': '.ymd2dmy($flight[flightdate]),0,0,'L',1);$pdf->Ln();
	$pdf->Cell(20,5,'',0,0,'L',1);$pdf->Cell(40,5,': MESKFXH',0,0,'L',1);	
	$pdf->Cell(10,5,'',0,0,'L',1);$pdf->Cell(40,5,': MESKRXH',0,0,'L',1);$pdf->Ln();
	$pdf->Cell(20,5,'',0,0,'L',1);$pdf->Cell(40,5,': '.$flight[acregister],0,0,'L',1);	
	$pdf->Cell(10,5,' ',0,0,'L',1);$pdf->Cell(40,5,': '.$flight[etd].' LT',0,0,'L',1);$pdf->Ln(8);	
	$pdf->Cell(10,8,'',0,0,'C',1);
	$pdf->Cell(50,8,'',0,0,'C',1);
	$pdf->Cell(50,8,' ',0,0,'C',1);
	$pdf->Cell(50,8,'',0,0,'C',1);
	$pdf->Cell(50,8,'',0,0,'C',1);$pdf->Ln();
$no=1;
	while($r=mysql_fetch_array($datauld))
	{
		
$jmlnya=mysql_num_rows(mysql_query("SELECT i.idmastersmu,d.dest_code  FROM isimanifestout as i, manifestout as m,master_smu as s, destination as d 
where m.idmanifestout=i.idmanifestout AND i.idmastersmu=s.idmastersmu AND
s.iddestination=d.iddestination AND i.idmanifestout='$_GET[idm]'
AND i.statusvoid='0' AND i.statuscancel='0' AND m.statusvoid='0' AND 
m.statuscancel='0' AND m.statusconfirm='1'  AND i.nould='$r[nould]'
GROUP BY d.dest_code"));
if($jmlnya>1)
{
$de=$flight[dest_code];	
}
	else
	{
		$de=$r[dest_code];
		}

$beratuld=mysql_fetch_array(mysql_query("
	select berat as beratuld from beratuld where uld='$r[nould]' AND idmanifestout='$_GET[idm]'"));		
	$pdf->SetX(5);
	$pdf->Cell(10,4,$no,0,0,'L',1);
	$pdf->Cell(60,4,$r[nould],0,0,'L',1);
	$pdf->Cell(30,4,$de,0,0,'C',1);
	$pdf->Cell(30,4,number_format($r[berat]+$beratuld[beratuld], 1, ',', '.'),0,0,'R',1);
	$pdf->Ln();		
	$no+=1;
	}
		
$pdf->SetY(143);
$pdf->Cell(120,5,$nama[nama_lengkap].'/MESKFXH',0,0,'L',1);$pdf->Ln(6);
$pdf->Cell(100,5,'            '.$nama[nipp],0,0,'L',1);
	
	$pdf->Output();
?>