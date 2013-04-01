<?php


	class PDF extends FPDF
	{
		//Page header
		function Header()
		{	
			//$this->SetLeftMargin(10);
			//$this->SetTopMargin(5);
			$this->SetLeftMargin(10);			
//			
			$this->SetFont('Arial','B',14);
			//$this->Ln(10);
			$this->Cell(190,10,'C A R G O   M A N I F E S T',0,0,'C');
			$this->Ln(5);
			$this->Cell(190,10,'ICAO ANNEX 9 APPENDIX 2',0,0,'C');
			$this->Ln(15);	
$tampil=mysql_query("SELECT  m.idmanifestout,m.iddestination2,m.acregister,m.flightdate,m.pointofloading,m.pointul,m.statusnil,
f.flight,o.origin_code, d.dest_code,m.statusconfirm,m.statuscancel,c.bendera,c.cus_desc
FROM manifestout as m,origin as o,destination as d,flight as f, customer as c
WHERE m.idorigin=o.idorigin AND m.iddestination=d.iddestination AND m.idflight=f.idflight AND m.statusvoid='0' AND f.idcustomer=c.idcustomer AND m.idmanifestout='$_POST[idm]'"); 
	
$p=mysql_fetch_array($tampil);

 			$this->SetFillColor(255,255,255);
			$this->SetFont('Arial','',10);
			$this->Cell(50,5,'OWNER/OPERATOR',0,0,'L',1);
			$this->Cell(50,5,'A/C REGISTRATION',0,0,'L',1);
			$this->Cell(50,5,'FLIGHT NO',0,0,'L',1);
			$this->Cell(50,5,'DATE',0,0,'L',1);
			$this->Ln(4);			
			$this->Cell(50,5,$p[cus_desc],0,0,'L',1);
			$this->Cell(50,5,$p[acregister],0,0,'L',1);
			$this->Cell(50,5,$p[flight],0,0,'L',1);
			$this->Cell(50,5,ymd2dmy($p[flightdate]),0,0,'L',1);
			$this->Ln(5);			
			$this->Cell(50,5,'',0,0,'L',1);
			$this->Cell(50,5,'',0,0,'L',1);
			$this->Cell(50,5,'',0,0,'L',1);
			$this->Cell(50,5,'WEIGHT IN KG',0,0,'L',1);
			$this->Ln(5);			
			$this->Cell(100,5,'POINT OF LOADING : '.$p[pointofloading],0,0,'L',1);
	if($_POST[s]=='1'){$this->Cell(100,5,'POINT OF UNLOADING : '.$p[dest_code],0,0,'L',1);}
	else
	{$this->Cell(100,5,'POINT OF UNLOADING : '.$p[pointul],0,0,'L',1);}
	
			$this->Ln(10);							
			$this->Cell(40,5,'AWB NUMBER',0,0,'L',1);
			$this->Cell(15,5,'NO',0,0,'L',1);
			$this->Cell(50,5,'NATURE OF GOODS',0,0,'L',1);
			$this->Cell(5,5,'',0,0,'L',1);
			$this->Cell(20,5,'WEIGHT',0,0,'C',1);
			$this->Cell(10,5,'EX',0,0,'C',1);
			$this->Cell(10,5,'TO',0,0,'C',1);
			$this->Cell(50,5,'FOR OFFICIAL',0,0,'L',1);
			$this->Ln(5);					
			$this->Cell(40,5,'',0,0,'L',1);
			$this->Cell(10,5,'PKG',0,0,'L',1);
			$this->Cell(50,5,'',0,0,'L',1);
			$this->Cell(10,5,'',0,0,'L',1);
			$this->Cell(20,5,'KGS',0,0,'C',1);
			$this->Cell(10,5,'',0,0,'L',1);
			$this->Cell(10,5,'',0,0,'L',1);
			$this->Cell(50,5,'USE ONLY',0,0,'L',1);

			$this->Ln(10);		
		}
		
		//Page footer
		function Footer()
		{
			
			//Position at 1.5 cm from bottom
			$this->SetY(-25);
			//Arial italic 8
			$this->SetFont('Arial','I',8);
			//Page number
				$this->Cell(0,8,'PT. GAPURA ANGKASA - MEDAN - WMS Page '.$this->PageNo().'/{nb}',0,0,'C');
		}		
	var $widths;
var $aligns;
function SetWidths($w)
{
	//Set the array of column widths
	$this->widths=$w;
}

function SetAligns($a)
{
	//Set the array of column alignments
	$this->aligns=$a;
}
	
//set parameter********************
function Row($data)
{
	//Calculate the height of the row
	$nb=0;
	for($i=0;$i<count($data);$i++)
		$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
	$h=4*$nb;
	//Issue a page break first if needed
	//$this->CheckPageBreak($h);
$this->CheckPageBreak($_POST[batas]);
	//Draw the cells of the row
	for($i=0;$i<count($data);$i++)
	{
		$w=$this->widths[$i];
		$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
		//Save the current position
		$x=$this->GetX();
		$y=$this->GetY();
		//$this->Rect($x,$y,$w,$h);
		//Print the text
		$this->MultiCell($w,3,$data[$i],0,$a);
		//Put the position to the right of the cell
		$this->SetXY($x+$w,$y);
	}
	//Go to the next line
	$this->Ln($h);

}




function CheckPageBreak($h)
{
	//If the height h would cause an overflow, add a new page immediately
	if($this->GetY()+$h>$this->PageBreakTrigger)
		$this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
	//Computes the number of lines a MultiCell of width w will take
	$cw=&$this->CurrentFont['cw'];
	if($w==0)
		$w=$this->w-$this->rMargin-$this->x;
	$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	$s=str_replace("\r",'',$txt);
	$nb=strlen($s);
	if($nb>0 and $s[$nb-1]=="\n")
		$nb--;
	$sep=-1;
	$i=0;
	$j=0;
	$l=0;
	$nl=1;
	while($i<$nb)
	{
		$c=$s[$i];
		if($c=="\n")
		{
			$i++;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
			continue;
		}
		if($c==' ')
			$sep=$i;
		$l+=$cw[$c];
		if($l>$wmax)
		{
			if($sep==-1)
			{
				if($i==$j)
					$i++;
			}
			else
				$i=$sep+1;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
		}
		else
			$i++;
	}
	return $nl;
}

function GenerateWord()
{
	//Get a random word
	$nb=rand(3,10);
	$w='';
	for($i=1;$i<=$nb;$i++)
		$w.=chr(rand(ord('a'),ord('z')));
	return $w;
}

function GenerateSentence()
{
	//Get a random sentence
	$nb=rand(1,10);
	$s='';
	for($i=1;$i<=$nb;$i++)
		$s.=GenerateWord().' ';
	return substr($s,0,-1);
}
//***********************************	
}	
	$totberat=0;$totkoli=0;
	//Instanciation of inherited class
	$pdf=new PDF('P','mm','A4');
	
	$pdf->AliasNbPages();
	//buka file
	$pdf->Open();
	
	//Disable automatic page break

	$pdf->SetAutoPageBreak(true,$_POST[batas]);
	
	//set nilai posisi y pada setiap halaman
	//$y_axis_initial = 32;
	//$y_axis1 = 32;
	//tinggi baris
	//$row_height = 6;	
	
	//$y_axis = 32; // $y_axis_initial + $row_height;

$tampil=mysql_query("SELECT  m.idmanifestout,m.iddestination2,m.iddestination,m.acregister,m.flightdate,m.pointofloading,m.pointul,m.statusnil,
f.flight,o.origin_code, d.dest_code,m.statusconfirm,m.statuscancel,c.bendera,c.cus_desc
FROM manifestout as m,origin as o,destination as d,flight as f, customer as c
WHERE m.idorigin=o.idorigin AND m.iddestination=d.iddestination AND m.idflight=f.idflight AND m.statusvoid='0' AND f.idcustomer=c.idcustomer AND m.idmanifestout='$_POST[idm]'"); 
	
$p=mysql_fetch_array($tampil);


$nama=mysql_fetch_array(mysql_query("SELECT u.nama_lengkap, u.code, u.nipp from user as u,manifestout as m where u.id_user=m.username AND m.idmanifestout='$_POST[idm]'"));
			

//cek nil dulu
$ceknil=mysql_num_rows(mysql_query("SELECT i.nould FROM isimanifestout as i, manifestout as m 
				where m.idmanifestout=i.idmanifestout AND i.idmanifestout='$_POST[idm]' 
				AND i.statusvoid='0' AND i.statuscancel='0' AND m.statusvoid='0' AND 
				m.statuscancel='0'  "));
				
				$pdf->AddPage();


//Jika manifest NORMAL
if($_POST[s]=='0') //jika CARGO tok
{
$no=1;
			$pdf->SetFillColor(255,255,255);
							
			
			//siapkan data utk ULD selain BULK  khjusus CARGo
			
				$uld=mysql_query("SELECT i.nould FROM isimanifestout as i, manifestout as m 
				,master_smu as s where m.idmanifestout=i.idmanifestout 
				AND s.idmastersmu=i.idmastersmu AND i.idmanifestout='$_POST[idm]' 
				AND s.idcommodityap<>'18' AND i.statusvoid='0' AND i.statuscancel='0' AND m.statusvoid='0' AND 
				m.statuscancel='0'  AND i.nould NOT like '%bulk%' GROUP BY i.nould order by i.idisimanifestout ASC");

				while ($r=mysql_fetch_array($uld))
				{
					$no_uld=$r[nould];
$pdf->SetAligns(array('L')); 
$pdf->SetWidths(array(28)); 
$pdf->Row(array(format_uld($r[nould])));

					$pdf->SetFont('Arial','',10);
					//$pdf->Ln(1);
					//$pdf->Cell(30,8,format_uld($r[nould]),0,0,'L',1);		
					//$pdf->Ln(7);
$subkoliuld=0;$subkguld=0;
$smu=mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	 AND m.idmanifestout='$_POST[idm]' AND i.nould='$no_uld'"); 
			while ($x=mysql_fetch_array($smu))
				{
$of=mysql_fetch_array(mysql_query("select s.koli from isimanifestout as i, manifestout as m, master_smu as s 
WHERE i.idmanifestout=m.idmanifestout AND i.idmastersmu=s.idmastersmu AND
m.statuscancel='0' AND m.statusvoid='0'  AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));

				if($of[0]<=$x[koli])
				{$str_of='';}else
				{$str_of='/'. $of[0];}
				if($x[commodity]<>'GEN')
				{$str_com=$x[commodity];}
				else
				{$str_com='';}
$pdf->SetX(15);
 $pdf->SetAligns(array('L','R','L','L','L','R','C','C')); 
$pdf->SetWidths(array(28,15,15,40,10,15,15,15)); 
$pdf->Row(array(format_awb($x[nosmu]),number_format($x[koli], 0, '.', '.'),$str_of,$x[commodityap],$str_com,number_format($x[berat], 1, ',', '.'),$x[origin_code],$x[dest_code]));
$subkoliuld+=$x[koli];$subkguld+=$x[berat];
}				


				/*$jml=mysql_query("SELECT SUM(koli) AS jum, SUM(berat) as ber FROM isimanifestout WHERE idmanifestout='$_POST[idm]' AND statusvoid='0' AND statuscancel='0' AND nould='$no_uld'");
*/
				$beratuld=mysql_fetch_array(mysql_query("
					select berat as beratuld from beratuld where uld='$no_uld' AND idmanifestout='$_POST[idm]'"));
			 
				$pdf->Cell(35,1,'',0,0,'L',1);
				$pdf->Cell(20,1,'---------',0,0,'L',1);
				$pdf->Cell(38,1,'',0,0,'L',1);
				$pdf->Cell(15,1,'',0,0,'C',1);
				$pdf->Cell(20,1,'---------',0,0,'R',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Ln();				 	
			//  while ($y=mysql_fetch_array($jml))
			//	{
				//$grossweight=$y[ber]+ $beratuld[beratuld];	ndk jadi, pake netto saja
				$grossweight=$subkguld;	
				$pdf->SetX(20);
				$pdf->Cell(40,5,'',0,0,'L',1);
				$pdf->SetX(43);				
				$pdf->Cell(15,5,number_format($subkoliuld, 0, '.', '.'),0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,number_format($grossweight, 1, ',', '.'),0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln(3);
				$totberat+=$grossweight;
				$totkoli+=$subkoliuld;
				$subkoliuld=0;$subkguld=0;
				//}						

			$no+=1;
			

			}
			
						//siapkan data utk ULD  BULK

$jmldes=mysql_num_rows(mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	 AND m.idmanifestout='$_POST[idm]' AND i.nould like '%bulk%' AND s.idcommodityap<>'18'"));
	if($jmldes>0)
	{
		

							$no_uld=$r[nould];
					$pdf->SetFont('Arial','',10);
					//$pdf->Ln();
					$pdf->Cell(40,8,'BULK',0,0,'L',1);		
					$pdf->Ln();
					
$smu=mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	 AND m.idmanifestout='$_POST[idm]' AND i.nould like '%bulk%' AND s.idcommodityap<>'18'"); 
				$subkoliuld=0;$subkguld=0;
		while ($x=mysql_fetch_array($smu))
				{
$of=mysql_fetch_array(mysql_query("select s.koli from isimanifestout as i, manifestout as m, master_smu as s 
WHERE i.idmanifestout=m.idmanifestout AND i.idmastersmu=s.idmastersmu AND
m.statuscancel='0' AND m.statusvoid='0'  AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));


				if($of[0]<=$x[koli])
				{$str_of='';}else
				{$str_of='/'. $of[0];}
				if($x[commodity]<>'GEN')
				{$str_com=$x[commodity];}
				else
				{$str_com='';}
$pdf->SetX(15);
 $pdf->SetAligns(array('L','R','L','L','L','R','C','C')); 
$pdf->SetWidths(array(28,15,15,40,10,15,15,15)); 
$pdf->Row(array(format_awb($x[nosmu]),number_format($x[koli], 0, '.', '.'),$str_of,$x[commodityap],$str_com,number_format($x[berat], 1, ',', '.'),$x[origin_code],$x[dest_code]));
$subkoliuld+=$x[koli];$subkguld+=$x[berat];
}				

//				$jml=mysql_query("SELECT SUM(koli) AS jum, SUM(berat) as ber FROM isimanifestout WHERE idmanifestout='$_POST[idm]' AND statusvoid='0' AND statuscancel='0' AND nould like '%bulk%'");
				$beratuld=mysql_fetch_array(mysql_query("
					select sum(berat) as beratuld from beratuld where uld like 'bulk' AND idmanifestout='$_POST[idm]'"));
			 
			 
				$pdf->Cell(35,1,'',0,0,'L',1);
				$pdf->Cell(20,1,'---------',0,0,'L',1);
				$pdf->Cell(38,1,'',0,0,'L',1);
				$pdf->Cell(15,1,'',0,0,'C',1);
				$pdf->Cell(20,1,'---------',0,0,'R',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Ln();				 	
			 // while ($y=mysql_fetch_array($jml))
			//	{
				//$grossweight=$y[ber]+ $beratuld[beratuld];	ndk jadi, pake netto saja
				$grossweight=$subkguld;	
				$pdf->SetX(20);
				$pdf->Cell(40,5,'',0,0,'L',1);
				$pdf->SetX(43);				
				$pdf->Cell(15,5,number_format($subkoliuld, 0, '.', '.'),0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,number_format($grossweight, 1, ',', '.'),0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln(3);
				$totberat+=$grossweight;
				$totkoli+=$subkoliuld;
						$subkoliuld=0;$subkguld=0;
		//		}							

			$no+=1;	

			}
			
	$pdf->Ln(5);	 
	if($totkoli=='0')
	{
						$pdf->SetX(10);
				$pdf->Cell(28,5,'TOTAL',0,0,'L',1);		
				$pdf->Cell(20,5,'NIL',0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,'NIL',0,0,'R',1);

		}
		else
		{
							$pdf->SetX(10);
				$pdf->Cell(28,5,'TOTAL',0,0,'L',1);		
				$pdf->Cell(20,5,number_format($totkoli, 0, '.', '.'),0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,number_format($totberat, 1, ',', '.'),0,0,'R',1);

			}
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln();		
		$pdf->Ln(10);
		
	$pdf->Cell(40,5,'PREPARED BY : '.$nama[nama_lengkap],0,0,'L',1);$pdf->Ln(5);	
	$pdf->Cell(40,5,'ID : '.$nama[nipp],0,0,'L',1);
	}//end of NORMAL MANIFEST CARGO

else if($_POST[s]=='1') 
{
$no=1;
//UTK MAIL
				$totberat=0;
				$totkoli=0;
		$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','B',14);
			$pdf->Ln(2);
			$pdf->Cell(190,20,'M A I L',0,0,'C');
$no=1;
			$pdf->SetFillColor(255,255,255);
			$pdf->Ln();					
			$pdf->SetFont('Arial','',10);
			
			//siapkan data utk ULD selain BULK  khusus MAIL
			
			/*  $uld=mysql_query("SELECT i.nould FROM isimanifestout as i, manifestout as m 
				where m.idmanifestout=i.idmanifestout AND i.idmanifestout='$_POST[idm]' 
				AND i.statusvoid='0' AND i.statuscancel='0' AND m.statusvoid='0' AND 
				m.statuscancel='0'  AND i.nould NOT like '%bulk%' GROUP BY i.nould order by i.idisimanifestout ASC");
				*/$uld=mysql_query("SELECT i.nould FROM isimanifestout as i, manifestout as m 
				,master_smu as s where m.idmanifestout=i.idmanifestout 
				AND s.idmastersmu=i.idmastersmu AND i.idmanifestout='$_POST[idm]' 
				AND s.idcommodityap='18' AND i.statusvoid='0' AND i.statuscancel='0' AND m.statusvoid='0' AND 
				m.statuscancel='0'  AND i.nould NOT like '%bulk%' GROUP BY i.nould order by i.idisimanifestout ASC");

				while ($r=mysql_fetch_array($uld))
				{
					$no_uld=$r[nould];
					$pdf->SetFont('Arial','',10);
					//$pdf->Ln(1);
					$pdf->Cell(30,8,format_uld($r[nould]),0,0,'L',1);		
					$pdf->Ln();
$subkoliuld=0;$subkguld=0;
$smu=mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity 
AND s.idcommodityap='18' 
	 AND m.idmanifestout='$_POST[idm]' AND i.nould='$no_uld'"); 
			while ($x=mysql_fetch_array($smu))
				{
$of=mysql_fetch_array(mysql_query("select s.koli from isimanifestout as i, manifestout as m, master_smu as s 
WHERE i.idmanifestout=m.idmanifestout AND i.idmastersmu=s.idmastersmu AND
m.statuscancel='0' AND m.statusvoid='0'  AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));

				if($of[0]<=$x[koli])
				{$str_of='';}else
				{$str_of='/'. $of[0];}
				if($x[commodity]<>'GEN')
				{$str_com='';}
				else
				{$str_com='';}
$pdf->SetX(15);
 $pdf->SetAligns(array('L','R','L','L','L','R','C','C')); 
$pdf->SetWidths(array(28,15,15,40,10,15,15,15)); 
$pdf->Row(array(format_nopos($x[nosmu]),number_format($x[koli], 0, '.', '.'),$str_of,$x[commodityap],$str_com,number_format($x[berat], 1, ',', '.'),$x[origin_code],$x[dest_code]));
$subkoliuld+=$x[koli];$subkguld+=$x[berat];
}				


				/*$jml=mysql_query("SELECT SUM(koli) AS jum, SUM(berat) as ber FROM isimanifestout WHERE idmanifestout='$_POST[idm]' AND statusvoid='0' AND statuscancel='0' AND nould='$no_uld'");
*/
				$beratuld=mysql_fetch_array(mysql_query("
					select berat as beratuld from beratuld where uld='$no_uld' AND idmanifestout='$_POST[idm]'"));
			 
				$pdf->Cell(35,1,'',0,0,'L',1);
				$pdf->Cell(20,1,'---------',0,0,'L',1);
				$pdf->Cell(38,1,'',0,0,'L',1);
				$pdf->Cell(15,1,'',0,0,'C',1);
				$pdf->Cell(20,1,'---------',0,0,'R',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Ln();				 	
			//  while ($y=mysql_fetch_array($jml))
			//	{
				//$grossweight=$y[ber]+ $beratuld[beratuld];	ndk jadi, pake netto saja
				$grossweight=$subkguld;	
				$pdf->SetX(20);
				$pdf->Cell(40,5,'',0,0,'L',1);
				$pdf->SetX(43);				
				$pdf->Cell(15,5,number_format($subkoliuld, 0, '.', '.'),0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,number_format($grossweight, 1, ',', '.'),0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln(3);
				$totberat+=$grossweight;
				$totkoli+=$subkoliuld;
				$subkoliuld=0;$subkguld=0;
				//}						

			$no+=1;
			

			}
			
						//siapkan data utk ULD  BULK

$jmldes=mysql_num_rows(mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	 AND m.idmanifestout='$_POST[idm]' AND i.nould like '%bulk%' AND s.idcommodityap='18'"));
	if($jmldes>0)
	{
		

							$no_uld=$r[nould];
					$pdf->SetFont('Arial','',10);
					//$pdf->Ln();
					$pdf->Cell(40,8,'BULK',0,0,'L',1);		
					$pdf->Ln();
					
$smu=mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	AND s.idcommodityap='18' AND m.idmanifestout='$_POST[idm]' AND i.nould like '%bulk%'"); 
				$subkoliuld=0;$subkguld=0;
		while ($x=mysql_fetch_array($smu))
				{
$of=mysql_fetch_array(mysql_query("select s.koli from isimanifestout as i, manifestout as m, master_smu as s 
WHERE i.idmanifestout=m.idmanifestout AND i.idmastersmu=s.idmastersmu AND
m.statuscancel='0' AND m.statusvoid='0'  AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));


				if($of[0]<=$x[koli])
				{$str_of='';}else
				{$str_of='/'. $of[0];}
				if($x[commodity]<>'GEN')
				{$str_com='';}
				else
				{$str_com='';}
$pdf->SetX(15);
 $pdf->SetAligns(array('L','R','L','L','L','R','C','C')); 
$pdf->SetWidths(array(28,15,15,40,10,15,15,15)); 
$pdf->Row(array(format_awb($x[nosmu]),number_format($x[koli], 0, '.', '.'),$str_of,$x[commodityap],$str_com,number_format($x[berat], 1, ',', '.'),$x[origin_code],$x[dest_code]));
$subkoliuld+=$x[koli];$subkguld+=$x[berat];
}				

//				$jml=mysql_query("SELECT SUM(koli) AS jum, SUM(berat) as ber FROM isimanifestout WHERE idmanifestout='$_POST[idm]' AND statusvoid='0' AND statuscancel='0' AND nould like '%bulk%'");
				$beratuld=mysql_fetch_array(mysql_query("
					select sum(berat) as beratuld from beratuld where uld like 'bulk' AND idmanifestout='$_POST[idm]'"));
			 
			 
				$pdf->Cell(35,1,'',0,0,'L',1);
				$pdf->Cell(20,1,'---------',0,0,'L',1);
				$pdf->Cell(38,1,'',0,0,'L',1);
				$pdf->Cell(15,1,'',0,0,'C',1);
				$pdf->Cell(20,1,'---------',0,0,'R',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Ln();				 	
			 // while ($y=mysql_fetch_array($jml))
			//	{
				//$grossweight=$y[ber]+ $beratuld[beratuld];	ndk jadi, pake netto saja
				$grossweight=$subkguld;	
				$pdf->SetX(20);
				$pdf->Cell(40,5,'',0,0,'L',1);
				$pdf->SetX(43);				
				$pdf->Cell(15,5,number_format($subkoliuld, 0, '.', '.'),0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,number_format($grossweight, 1, ',', '.'),0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln(3);
				$totberat+=$grossweight;
				$totkoli+=$subkoliuld;
						$subkoliuld=0;$subkguld=0;
		//		}							

			$no+=1;	

			}
			
	$pdf->Ln(5);
	if($totkoli=='0')
	{
				$pdf->SetX(10);
				$pdf->Cell(28,5,'TOTAL',0,0,'L',1);		
				$pdf->Cell(20,5,'NIL',0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,'NIL',0,0,'R',1);

}
		else
		{
				$pdf->SetX(10);
				$pdf->Cell(28,5,'TOTAL',0,0,'L',1);		
				$pdf->Cell(20,5,number_format($totkoli, 0, '.', '.'),0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,number_format($totberat, 1, ',', '.'),0,0,'R',1);

}
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln();		
		$pdf->Ln(10);
		
	$pdf->Cell(40,5,'PREPARED BY : '.$nama[nama_lengkap],0,0,'L',1);$pdf->Ln(5);	
	$pdf->Cell(40,5,'ID : '.$nama[nipp],0,0,'L',1);
}
//end of NORMAL MANIFEST MAIL


// jika SPLIT MANIFEST -> 1 manifest utk split, 1 manifest utl selainnya
else

 {
	$tampil=mysql_query("SELECT  m.idmanifestout,m.iddestination2,m.iddestination,m.acregister,m.flightdate,m.pointofloading,m.pointul,m.statusnil,
f.flight,o.origin_code, d.dest_code,m.statusconfirm,m.statuscancel,c.bendera,c.cus_desc
FROM manifestout as m,origin as o,destination as d,flight as f, customer as c
WHERE m.idorigin=o.idorigin AND m.iddestination=d.iddestination AND m.idflight=f.idflight AND m.statusvoid='0' AND f.idcustomer=c.idcustomer AND m.idmanifestout='$_POST[idm]'"); 
	
$p=mysql_fetch_array($tampil);
 
	if($p[iddestination2]=='0')
	{
//1. print yang sama dgn destination dulu
// yang sama dgn destinasi 1 dulu
$no=1;
			$pdf->SetFillColor(255,255,255);

			$pdf->Ln();				
			
			//siapkan data
			$jbr=0;$jkl=0;
/*
			  $uld=mysql_query("SELECT i.nould FROM isimanifestout as i, 
				manifestout as m,master_smu as s  
				where m.idmanifestout=i.idmanifestout AND i.idmanifestout='$_POST[idm]' AND
				i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND
				m.statusvoid='0' AND s.iddestination='$p[iddestination]' AND 
				m.statuscancel='0' AND m.statusconfirm='1' GROUP BY i.nould");*/
				$uld=mysql_query("SELECT i.nould FROM isimanifestout as i, 
				manifestout as m,master_smu as s  
				where m.idmanifestout=i.idmanifestout AND i.idmanifestout='$_POST[idm]' AND
				i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND
				m.statusvoid='0' AND s.iddestination='$p[iddestination]' AND 
				s.idcommodityap<>'18' AND m.statuscancel='0' AND i.nould not like '%bulk%' GROUP BY i.nould");
$subkoliuld=0;$subkguld=0;
while ($r=mysql_fetch_array($uld))
				{
	
	$no_uld=$r[nould];
					$pdf->SetFont('Arial','',10);
					//$pdf->Ln(1);
					$pdf->Cell(30,8,format_uld($r[nould]),0,0,'L',1);		
					$pdf->Ln();
$jbr=0;$jkl=0;
$smu=mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	 AND s.idcommodityap<>'18' AND m.idmanifestout='$_POST[idm]' AND i.nould='$no_uld' AND d.dest_code='$p[dest_code]'"); 
			while ($x=mysql_fetch_array($smu))
				{
/*
					$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_POST[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0' AND m.statusconfirm='1' AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
*/
$of=mysql_fetch_array(mysql_query("select s.koli from isimanifestout as i, manifestout as m, master_smu as s 
WHERE i.idmanifestout=m.idmanifestout AND i.idmastersmu=s.idmastersmu AND
m.statuscancel='0' AND m.statusvoid='0'  AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
				if($of[0]<=$x[koli])
				{$str_of='';}else
				{$str_of='/'. $of[0];}
				if($x[commodity]<>'GEN')
				{$str_com=$x[commodity];}
				else
				{$str_com='';}
$pdf->SetX(15);
$pdf->SetAligns(array('L','R','L','L','L','R','C','C')); 
$pdf->SetWidths(array(28,15,15,40,10,15,15,15)); 
$pdf->Row(array(format_awb($x[nosmu]),number_format($x[koli], 0, '.', '.'),$str_of,$x[commodityap],$str_com,number_format($x[berat], 1, ',', '.'),$x[origin_code],$x[dest_code]));
$subkoliuld+=$x[koli];$subkguld+=$x[berat];
}				

				$beratuld=mysql_fetch_array(mysql_query("
					select berat as beratuld from beratuld where uld='$no_uld' AND idmanifestout='$_POST[idm]'"));
			 
				$pdf->Cell(35,1,'',0,0,'L',1);
				$pdf->Cell(20,1,'---------',0,0,'L',1);
				$pdf->Cell(38,1,'',0,0,'L',1);
				$pdf->Cell(15,1,'',0,0,'C',1);
				$pdf->Cell(20,1,'---------',0,0,'R',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Ln();				 	
//			  while ($y=mysql_fetch_array($jml))
	//			{
				//$grossweight=$y[ber]+ $beratuld[beratuld];	ndk jadi, pake netto saja
				$grossweight=$subkguld;	
				$pdf->SetX(20);
				$pdf->Cell(40,5,'',0,0,'L',1);
				$pdf->SetX(43);				
				$pdf->Cell(15,5,number_format($subkoliuld, 0, '.', '.'),0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,number_format($grossweight, 1, ',', '.'),0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln(3);
				$totberat+=$grossweight;
				$totkoli+=$subkoliuld;
				$subkoliuld=0;$subkguld=0;
		//		}						

			$no+=1;
			

			}
//BULK			

$jmlbulk=mysql_num_rows(mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND 
s.idcommodityap<>'18' AND 
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	 AND m.idmanifestout='$_POST[idm]' AND i.nould like '%bulk%' AND d.dest_code='$p[dest_code]'"));
if($jmlbulk>0){
						$no_uld=$r[nould];
					$pdf->SetFont('Arial','',10);
					//$pdf->Ln();
					$pdf->Cell(30,8,'BULK',0,0,'L',1);		
					$pdf->Ln();
$jbr=0;$jkl=0;
$smu=mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	 AND s.idcommodityap<>'18' AND m.idmanifestout='$_POST[idm]' AND i.nould like '%bulk%' AND d.dest_code='$p[dest_code]'"); 
	$subkoliuld=0;$subkguld=0; 
			while ($x=mysql_fetch_array($smu))
				{
/*
					$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_POST[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0' AND m.statusconfirm='1' AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
*/
$of=mysql_fetch_array(mysql_query("select s.koli from isimanifestout as i, manifestout as m, master_smu as s 
WHERE i.idmanifestout=m.idmanifestout AND i.idmastersmu=s.idmastersmu AND
m.statuscancel='0' AND m.statusvoid='0'  AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
				if($of[0]<=$x[koli])
				{$str_of='';}else
				{$str_of='/'. $of[0];}
				if($x[commodity]<>'GEN')
				{$str_com=$x[commodity];}
				else
				{$str_com='';}
$pdf->SetX(15);
 $pdf->SetAligns(array('L','R','L','L','L','R','C','C')); 
$pdf->SetWidths(array(28,15,15,40,10,15,15,15)); 
$pdf->Row(array(format_awb($x[nosmu]),number_format($x[koli], 0, '.', '.'),$str_of,$x[commodityap],$str_com,number_format($x[berat], 1, ',', '.'),$x[origin_code],$x[dest_code]));
$subkoliuld+=$x[koli];$subkguld+=$x[berat];
}				
/*
echo("SELECT SUM(i.koli) AS jum, SUM(i.berat) as ber FROM isimanifestout as i, master_smu as s WHERE i.idmastersmu=s.idmastersmu AND idmanifestout='$_POST[idm]' AND i.statusvoid='0' AND i.statuscancel='0' AND nould like '%BULK%' AND s.iddestination='$p[iddestination]'");
*/
				$beratuld=mysql_fetch_array(mysql_query("
					select berat as beratuld from beratuld where uld='$no_uld' AND idmanifestout='$_POST[idm]'"));
			 
				$pdf->Cell(35,1,'',0,0,'L',1);
				$pdf->Cell(20,1,'---------',0,0,'L',1);
				$pdf->Cell(38,1,'',0,0,'L',1);
				$pdf->Cell(15,1,'',0,0,'C',1);
				$pdf->Cell(20,1,'---------',0,0,'R',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Ln();				 	
	//		  while ($y=mysql_fetch_array($jml))
		//		{
				//$grossweight=$y[ber]+ $beratuld[beratuld];	ndk jadi, pake netto saja
				$grossweight=$subkguld;	
				$pdf->SetX(20);
				$pdf->Cell(40,5,'',0,0,'L',1);
				$pdf->SetX(43);				
				$pdf->Cell(15,5,number_format($subkoliuld, 0, '.', '.'),0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,number_format($grossweight, 1, ',', '.'),0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln(3);
				$totberat+=$grossweight;
				$totkoli+=$subkoliuld;
				$subkoliuld=0;$subkguld=0;
			//	}						

			$no+=1;
			}

			
			
			
 
	$pdf->Ln(5);	 
				$pdf->SetX(10);
				$pdf->Cell(28,5,'TOTAL',0,0,'L',1);		
				$pdf->Cell(20,5,number_format($totkoli, 0, '.', '.'),0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,number_format($totberat, 1, ',', '.'),0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln();		
		$pdf->Ln(10);
		
	$pdf->Cell(40,8,'PREPARED BY : '.$nama[nama_lengkap],0,0,'L',1);$pdf->Ln(5);
	$pdf->Cell(40,8,'ID : '.$nama[nipp],0,0,'L',1);
//2. print yang tdk sama dgn destination 
//utk destinasi 1
				
				$pdf->AddPage();
			
			$pdf->SetFillColor(255,255,255);

$no=1;
$totberat=0;$totkoli=0;$grossweight=0;
			$pdf->Ln();				
			
			//siapkan data
			$jbr=0;$jkl=0;
/*
			  $uld=mysql_query("SELECT i.nould FROM isimanifestout as i, 
				manifestout as m,master_smu as s  
				where m.idmanifestout=i.idmanifestout AND i.idmanifestout='$_POST[idm]' AND
				i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND
				m.statusvoid='0' AND s.iddestination<>'$p[iddestination]' AND 
				m.statuscancel='0' AND m.statusconfirm='1' GROUP BY i.nould");
*/

$uld=mysql_query("SELECT i.nould FROM isimanifestout as i, 
				manifestout as m,master_smu as s  
				where m.idmanifestout=i.idmanifestout AND i.idmanifestout='$_POST[idm]' AND
				i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND
				m.statusvoid='0' AND s.iddestination<>'$p[iddestination]' AND  s.idcommodityap<>'18' AND 
				m.statuscancel='0' AND  i.nould not like '%bulk%' GROUP BY i.nould");
				
				while ($r=mysql_fetch_array($uld))
				{
					$no_uld=$r[nould];
					$pdf->SetFont('Arial','',10);
					//$pdf->Ln(1);
					$pdf->Cell(30,8,format_uld($r[nould]),0,0,'L',1);		
					$pdf->Ln();
$jbr=0;$jkl=0;
$smu=mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	 AND m.idmanifestout='$_POST[idm]' AND i.nould='$no_uld' AND d.dest_code<>'$p[dest_code]'"); 
	$subkoliuld=0;$subkguld=0; 
			while ($x=mysql_fetch_array($smu))
				{
/*
					$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_POST[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0' AND m.statusconfirm='1' AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
*/
$of=mysql_fetch_array(mysql_query("select s.koli from isimanifestout as i, manifestout as m, master_smu as s 
WHERE i.idmanifestout=m.idmanifestout AND i.idmastersmu=s.idmastersmu AND
m.statuscancel='0' AND m.statusvoid='0'  AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
				if($of[0]<=$x[koli])
				{$str_of='';}else
				{$str_of='/'. $of[0];}
				if($x[commodity]<>'GEN')
				{$str_com=$x[commodity];}
				else
				{$str_com='';}
$pdf->SetX(15);
 $pdf->SetAligns(array('L','R','L','L','L','R','C','C')); 
$pdf->SetWidths(array(28,15,15,40,10,15,15,15)); 
$pdf->Row(array(format_awb($x[nosmu]),number_format($x[koli], 0, '.', '.'),$str_of,$x[commodityap],$str_com,number_format($x[berat], 1, ',', '.'),$x[origin_code],$x[dest_code]));
$subkoliuld+=$x[koli];$subkguld+=$x[berat];
}				

	/*			$jml=mysql_query("SELECT SUM(koli) AS jum, SUM(berat) as ber FROM isimanifestout WHERE idmanifestout='$_POST[idm]' AND statusvoid='0' AND statuscancel='0' AND nould='$no_uld'");
		*/		$beratuld=mysql_fetch_array(mysql_query("
					select berat as beratuld from beratuld where uld='$no_uld' AND idmanifestout='$_POST[idm]'"));
			 
				$pdf->Cell(35,1,'',0,0,'L',1);
				$pdf->Cell(20,1,'---------',0,0,'L',1);
				$pdf->Cell(38,1,'',0,0,'L',1);
				$pdf->Cell(15,1,'',0,0,'C',1);
				$pdf->Cell(20,1,'---------',0,0,'R',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Ln();				 	
			//  while ($y=mysql_fetch_array($jml))
				//{
				//$grossweight=$y[ber]+ $beratuld[beratuld];	ndk jadi, pake netto saja
				$grossweight=$subkguld;	
				$pdf->SetX(20);
				$pdf->Cell(40,5,'',0,0,'L',1);
				$pdf->SetX(43);				
				$pdf->Cell(15,5,number_format($subkoliuld, 0, '.', '.'),0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,number_format($grossweight, 1, ',', '.'),0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln(3);
				$totberat+=$grossweight;
				$totkoli+=$subkoliuld;
				$subkoliuld=0;$subkguld=0;
				//}						

			$no+=1;
			

			}
			

//BULK			

$jmlbulk=mysql_num_rows(mysql_query("SELECT i.nould FROM isimanifestout as i, 
				manifestout as m,master_smu as s  
				where m.idmanifestout=i.idmanifestout AND i.idmanifestout='$_POST[idm]' AND
				i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND
				m.statusvoid='0' AND s.iddestination<>'$p[iddestination]' AND s.idcommodityap<>'18' 
				AND m.statuscancel='0' AND i.nould like '%bulk%' GROUP BY i.nould"));
if($jmlbulk>0){
						$no_uld=$r[nould];
					$pdf->SetFont('Arial','',10);
					//$pdf->Ln();
					$pdf->Cell(30,8,'BULK',0,0,'L',1);		
					$pdf->Ln();
$jbr=0;$jkl=0;
$smu=mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	 AND m.idmanifestout='$_POST[idm]' AND i.nould like '%bulk%' AND d.dest_code<>'$p[dest_code]'"); 
	$subkoliuld=0;$subkguld=0; 
			while ($x=mysql_fetch_array($smu))
				{
/*
					$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_POST[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0' AND m.statusconfirm='1' AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
*/
$of=mysql_fetch_array(mysql_query("select s.koli from isimanifestout as i, manifestout as m, master_smu as s 
WHERE i.idmanifestout=m.idmanifestout AND i.idmastersmu=s.idmastersmu AND
m.statuscancel='0' AND m.statusvoid='0'  AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
				if($of[0]<=$x[koli])
				{$str_of='';}else
				{$str_of='/'. $of[0];}
				if($x[commodity]<>'GEN')
				{$str_com=$x[commodity];}
				else
				{$str_com='';}
$pdf->SetX(15);
 $pdf->SetAligns(array('L','R','L','L','L','R','C','C')); 
$pdf->SetWidths(array(28,15,15,40,10,15,15,15)); 
$pdf->Row(array(format_awb($x[nosmu]),number_format($x[koli], 0, '.', '.'),$str_of,$x[commodityap],$str_com,number_format($x[berat], 1, ',', '.'),$x[origin_code],$x[dest_code]));
$subkoliuld+=$x[koli];$subkguld+=$x[berat];
}				

				$jml=mysql_query("SELECT SUM(koli) AS jum, SUM(berat) as ber FROM isimanifestout WHERE idmanifestout='$_POST[idm]' AND statusvoid='0' AND statuscancel='0' AND nould like '%BULK%'");
				$beratuld=mysql_fetch_array(mysql_query("
					select berat as beratuld from beratuld where uld='$no_uld' AND idmanifestout='$_POST[idm]'"));
			 
				$pdf->Cell(35,1,'',0,0,'L',1);
				$pdf->Cell(20,1,'---------',0,0,'L',1);
				$pdf->Cell(38,1,'',0,0,'L',1);
				$pdf->Cell(15,1,'',0,0,'C',1);
				$pdf->Cell(20,1,'---------',0,0,'R',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Ln();				 	
	//		  while ($y=mysql_fetch_array($jml))
		//		{
				//$grossweight=$y[ber]+ $beratuld[beratuld];	ndk jadi, pake netto saja
				$grossweight=$subkguld;	
				$pdf->SetX(20);
				$pdf->Cell(40,5,'',0,0,'L',1);
				$pdf->SetX(43);				
				$pdf->Cell(15,5,number_format($subkoliuld, 0, '.', '.'),0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,number_format($grossweight, 1, ',', '.'),0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln(3);
				$totberat+=$grossweight;
				$totkoli+=$subkoliuld;
				$subkoliuld=0;$subkguld=0;
			//	}						

			$no+=1;
			}
			

	$pdf->Ln(5);	 
				$pdf->SetX(10);
				$pdf->Cell(28,5,'TOTAL',0,0,'L',1);		
				$pdf->Cell(20,5,number_format($totkoli, 0, '.', '.'),0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,number_format($totberat, 1, ',', '.'),0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln();		
		$pdf->Ln(10);
		
	$pdf->Cell(40,8,'PREPARED BY : '.$nama[nama_lengkap],0,0,'L',1);$pdf->Ln(5);
	$pdf->Cell(40,8,'ID : '.$nama[nipp],0,0,'L',1);
}
else //jika destinasi 2 ada 
	{
		$dq=mysql_fetch_array(mysql_query("select * from destination where iddestination='$p[iddestination]'"));
$tujuan1=$dq[dest_code];
$dq=mysql_fetch_array(mysql_query("select * from destination where iddestination='$p[iddestination2]'"));
		$tujuan2=$dq[dest_code];		
		
		
//1. print yang sama dgn destination dulu
// yang sama dgn destinasi 1 dulu
$no=1;
			$pdf->SetFillColor(255,255,255);

			$pdf->Ln();				
$pdf->Cell(190,8,$p[origin_code].'-'. $tujuan1,0,0,'C',1);		
$pdf->Ln();				

			//siapkan data
			$jbr=0;$jkl=0;
/*
			  $uld=mysql_query("SELECT i.nould FROM isimanifestout as i, 
				manifestout as m,master_smu as s  
				where m.idmanifestout=i.idmanifestout AND i.idmanifestout='$_POST[idm]' AND
				i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND
				m.statusvoid='0' AND s.iddestination='$p[iddestination]' AND 
				m.statuscancel='0' AND m.statusconfirm='1' GROUP BY i.nould");*/
				$uld=mysql_query("SELECT i.nould FROM isimanifestout as i, 
				manifestout as m,master_smu as s  
				where m.idmanifestout=i.idmanifestout AND i.idmanifestout='$_POST[idm]' AND
				i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND
				m.statusvoid='0' AND s.iddestination='$p[iddestination]' AND 
				m.statuscancel='0' AND i.nould not like '%bulk%' GROUP BY i.nould");
$subkoliuld=0;$subkguld=0;



while ($r=mysql_fetch_array($uld))
				{
	
	$no_uld=$r[nould];
					$pdf->SetFont('Arial','',10);
					//$pdf->Ln(1);
					$pdf->Cell(30,8,format_uld($r[nould]),0,0,'L',1);		
					$pdf->Ln();
$jbr=0;$jkl=0;
$smu=mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	 AND s.idcommodityap<>'18' AND m.idmanifestout='$_POST[idm]' AND i.nould='$no_uld' AND d.dest_code='$p[dest_code]'"); 
			while ($x=mysql_fetch_array($smu))
				{
/*
					$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_POST[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0' AND m.statusconfirm='1' AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
*/
$of=mysql_fetch_array(mysql_query("select s.koli from isimanifestout as i, manifestout as m, master_smu as s 
WHERE i.idmanifestout=m.idmanifestout AND i.idmastersmu=s.idmastersmu AND
m.statuscancel='0' AND m.statusvoid='0'  AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
				if($of[0]<=$x[koli])
				{$str_of='';}else
				{$str_of='/'. $of[0];}
				if($x[commodity]<>'GEN')
				{$str_com=$x[commodity];}
				else
				{$str_com='';}
$pdf->SetX(15);
$pdf->SetAligns(array('L','R','L','L','L','R','C','C')); 
$pdf->SetWidths(array(28,15,15,40,10,15,15,15)); 
$pdf->Row(array(format_awb($x[nosmu]),number_format($x[koli], 0, '.', '.'),$str_of,$x[commodityap],$str_com,number_format($x[berat], 1, ',', '.'),$x[origin_code],$x[dest_code]));
$subkoliuld+=$x[koli];$subkguld+=$x[berat];
}				

				$beratuld=mysql_fetch_array(mysql_query("
					select berat as beratuld from beratuld where uld='$no_uld' AND idmanifestout='$_POST[idm]'"));
			 
				$pdf->Cell(35,1,'',0,0,'L',1);
				$pdf->Cell(20,1,'---------',0,0,'L',1);
				$pdf->Cell(38,1,'',0,0,'L',1);
				$pdf->Cell(15,1,'',0,0,'C',1);
				$pdf->Cell(20,1,'---------',0,0,'R',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Ln();				 	
//			  while ($y=mysql_fetch_array($jml))
	//			{
				//$grossweight=$y[ber]+ $beratuld[beratuld];	ndk jadi, pake netto saja
				$grossweight=$subkguld;	
				$pdf->SetX(20);
				$pdf->Cell(40,5,'',0,0,'L',1);
				$pdf->SetX(43);				
				$pdf->Cell(15,5,number_format($subkoliuld, 0, '.', '.'),0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,number_format($grossweight, 1, ',', '.'),0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln(3);
				$totberat+=$grossweight;
				$totkoli+=$subkoliuld;
				$subkoliuld=0;$subkguld=0;
		//		}						

			$no+=1;
			

			}
//BULK			

$jmlbulk=mysql_num_rows(mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND 
s.idcommodityap<>'18' AND 
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	 AND m.idmanifestout='$_POST[idm]' AND i.nould like '%bulk%' AND d.dest_code='$p[dest_code]'"));
if($jmlbulk>0){
						$no_uld=$r[nould];
					$pdf->SetFont('Arial','',10);
					//$pdf->Ln();
					$pdf->Cell(30,8,'BULK',0,0,'L',1);		
					$pdf->Ln();
$jbr=0;$jkl=0;
$smu=mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	 AND m.idmanifestout='$_POST[idm]' AND i.nould like '%bulk%' AND d.dest_code='$p[dest_code]'"); 
	$subkoliuld=0;$subkguld=0; 
			while ($x=mysql_fetch_array($smu))
				{
/*
					$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_POST[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0' AND m.statusconfirm='1' AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
*/
$of=mysql_fetch_array(mysql_query("select s.koli from isimanifestout as i, manifestout as m, master_smu as s 
WHERE i.idmanifestout=m.idmanifestout AND i.idmastersmu=s.idmastersmu AND
m.statuscancel='0' AND m.statusvoid='0'  AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
				if($of[0]<=$x[koli])
				{$str_of='';}else
				{$str_of='/'. $of[0];}
				if($x[commodity]<>'GEN')
				{$str_com=$x[commodity];}
				else
				{$str_com='';}
$pdf->SetX(15);
 $pdf->SetAligns(array('L','R','L','L','L','R','C','C')); 
$pdf->SetWidths(array(28,15,15,40,10,15,15,15)); 
$pdf->Row(array(format_awb($x[nosmu]),number_format($x[koli], 0, '.', '.'),$str_of,$x[commodityap],$str_com,number_format($x[berat], 1, ',', '.'),$x[origin_code],$x[dest_code]));
$subkoliuld+=$x[koli];$subkguld+=$x[berat];
}				
/*
echo("SELECT SUM(i.koli) AS jum, SUM(i.berat) as ber FROM isimanifestout as i, master_smu as s WHERE i.idmastersmu=s.idmastersmu AND idmanifestout='$_POST[idm]' AND i.statusvoid='0' AND i.statuscancel='0' AND nould like '%BULK%' AND s.iddestination='$p[iddestination]'");
*/
				$beratuld=mysql_fetch_array(mysql_query("
					select berat as beratuld from beratuld where uld='$no_uld' AND idmanifestout='$_POST[idm]'"));
			 
				$pdf->Cell(35,1,'',0,0,'L',1);
				$pdf->Cell(20,1,'---------',0,0,'L',1);
				$pdf->Cell(38,1,'',0,0,'L',1);
				$pdf->Cell(15,1,'',0,0,'C',1);
				$pdf->Cell(20,1,'---------',0,0,'R',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Ln();				 	
	//		  while ($y=mysql_fetch_array($jml))
		//		{
				//$grossweight=$y[ber]+ $beratuld[beratuld];	ndk jadi, pake netto saja
				$grossweight=$subkguld;	
				$pdf->SetX(20);
				$pdf->Cell(40,5,'',0,0,'L',1);
				$pdf->SetX(43);				
				$pdf->Cell(15,5,number_format($subkoliuld, 0, '.', '.'),0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,number_format($grossweight, 1, ',', '.'),0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln(3);
				$totberat+=$grossweight;
				$totkoli+=$subkoliuld;
				$subkoliuld=0;$subkguld=0;
			//	}						

			$no+=1;
			}

			
			
			
 
	$pdf->Ln(5);	 
				$pdf->SetX(10);
				$pdf->Cell(28,5,'TOTAL',0,0,'L',1);		
				$pdf->Cell(20,5,number_format($totkoli, 0, '.', '.'),0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,number_format($totberat, 1, ',', '.'),0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln();		
		$pdf->Ln(10);
		
	$pdf->Cell(40,8,'PREPARED BY : '.$nama[nama_lengkap],0,0,'L',1);$pdf->Ln(5);
	$pdf->Cell(40,8,'ID : '.$nama[nipp],0,0,'L',1);
//2. print yang tdk sama dgn destination 
//utk destinasi 1


				$pdf->AddPage();
			
			$pdf->SetFillColor(255,255,255);

$no=1;
$totberat=0;$totkoli=0;$grossweight=0;
			$pdf->Ln();				



$pdf->Cell(190,8,$p[origin_code].'-'. $tujuan2,0,0,'C',1);		
$pdf->Ln();				
			//siapkan data
			$jbr=0;$jkl=0;
/*
			  $uld=mysql_query("SELECT i.nould FROM isimanifestout as i, 
				manifestout as m,master_smu as s  
				where m.idmanifestout=i.idmanifestout AND i.idmanifestout='$_POST[idm]' AND
				i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND
				m.statusvoid='0' AND s.iddestination<>'$p[iddestination]' AND 
				m.statuscancel='0' AND m.statusconfirm='1' GROUP BY i.nould");
*/

$uld=mysql_query("SELECT i.nould FROM isimanifestout as i, 
				manifestout as m,master_smu as s  
				where m.idmanifestout=i.idmanifestout AND i.idmanifestout='$_POST[idm]' AND
				i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND
				m.statusvoid='0' AND s.iddestination<>'$p[iddestination]' AND  s.idcommodityap<>'18' AND 
				m.statuscancel='0' AND  i.nould not like '%bulk%' GROUP BY i.nould");
				
				while ($r=mysql_fetch_array($uld))
				{
					$no_uld=$r[nould];
					$pdf->SetFont('Arial','',10);
					//$pdf->Ln(1);
					$pdf->Cell(30,8,format_uld($r[nould]),0,0,'L',1);		
					$pdf->Ln();
$jbr=0;$jkl=0;
$smu=mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	 AND m.idmanifestout='$_POST[idm]' AND i.nould='$no_uld' AND d.dest_code<>'$p[dest_code]'"); 
	$subkoliuld=0;$subkguld=0; 
			while ($x=mysql_fetch_array($smu))
				{
/*
					$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_POST[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0' AND m.statusconfirm='1' AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
*/
$of=mysql_fetch_array(mysql_query("select s.koli from isimanifestout as i, manifestout as m, master_smu as s 
WHERE i.idmanifestout=m.idmanifestout AND i.idmastersmu=s.idmastersmu AND
m.statuscancel='0' AND m.statusvoid='0'  AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
				if($of[0]<=$x[koli])
				{$str_of='';}else
				{$str_of='/'. $of[0];}
				if($x[commodity]<>'GEN')
				{$str_com=$x[commodity];}
				else
				{$str_com='';}
$pdf->SetX(15);
 $pdf->SetAligns(array('L','R','L','L','L','R','C','C')); 
$pdf->SetWidths(array(28,15,15,40,10,15,15,15)); 
$pdf->Row(array(format_awb($x[nosmu]),number_format($x[koli], 0, '.', '.'),$str_of,$x[commodityap],$str_com,number_format($x[berat], 1, ',', '.'),$x[origin_code],$x[dest_code]));
$subkoliuld+=$x[koli];$subkguld+=$x[berat];
}				

	/*			$jml=mysql_query("SELECT SUM(koli) AS jum, SUM(berat) as ber FROM isimanifestout WHERE idmanifestout='$_POST[idm]' AND statusvoid='0' AND statuscancel='0' AND nould='$no_uld'");
		*/		$beratuld=mysql_fetch_array(mysql_query("
					select berat as beratuld from beratuld where uld='$no_uld' AND idmanifestout='$_POST[idm]'"));
			 
				$pdf->Cell(35,1,'',0,0,'L',1);
				$pdf->Cell(20,1,'---------',0,0,'L',1);
				$pdf->Cell(38,1,'',0,0,'L',1);
				$pdf->Cell(15,1,'',0,0,'C',1);
				$pdf->Cell(20,1,'---------',0,0,'R',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Ln();				 	
			//  while ($y=mysql_fetch_array($jml))
				//{
				//$grossweight=$y[ber]+ $beratuld[beratuld];	ndk jadi, pake netto saja
				$grossweight=$subkguld;	
				$pdf->SetX(20);
				$pdf->Cell(40,5,'',0,0,'L',1);
				$pdf->SetX(43);				
				$pdf->Cell(15,5,number_format($subkoliuld, 0, '.', '.'),0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,number_format($grossweight, 1, ',', '.'),0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln(3);
				$totberat+=$grossweight;
				$totkoli+=$subkoliuld;
				$subkoliuld=0;$subkguld=0;
				//}						

			$no+=1;
			

			}
			

//BULK			

$jmlbulk=mysql_num_rows(mysql_query("SELECT i.nould FROM isimanifestout as i, 
				manifestout as m,master_smu as s  
				where m.idmanifestout=i.idmanifestout AND i.idmanifestout='$_POST[idm]' AND
				i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND
				m.statusvoid='0' AND s.iddestination<>'$p[iddestination]' AND s.idcommodityap<>'18' 
				AND m.statuscancel='0' AND i.nould like '%bulk%' GROUP BY i.nould"));
if($jmlbulk>0){
						$no_uld=$r[nould];
					$pdf->SetFont('Arial','',10);
					//$pdf->Ln();
					$pdf->Cell(30,8,'BULK',0,0,'L',1);		
					$pdf->Ln();
$jbr=0;$jkl=0;
$smu=mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	 AND m.idmanifestout='$_POST[idm]' AND i.nould like '%bulk%' AND d.dest_code<>'$p[dest_code]'"); 
	$subkoliuld=0;$subkguld=0; 
			while ($x=mysql_fetch_array($smu))
				{
/*
					$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_POST[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0' AND m.statusconfirm='1' AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
*/
$of=mysql_fetch_array(mysql_query("select s.koli from isimanifestout as i, manifestout as m, master_smu as s 
WHERE i.idmanifestout=m.idmanifestout AND i.idmastersmu=s.idmastersmu AND
m.statuscancel='0' AND m.statusvoid='0'  AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
				if($of[0]<=$x[koli])
				{$str_of='';}else
				{$str_of='/'. $of[0];}
				if($x[commodity]<>'GEN')
				{$str_com=$x[commodity];}
				else
				{$str_com='';}
$pdf->SetX(15);
 $pdf->SetAligns(array('L','R','L','L','L','R','C','C')); 
$pdf->SetWidths(array(28,15,15,40,10,15,15,15)); 
$pdf->Row(array(format_awb($x[nosmu]),number_format($x[koli], 0, '.', '.'),$str_of,$x[commodityap],$str_com,number_format($x[berat], 1, ',', '.'),$x[origin_code],$x[dest_code]));
$subkoliuld+=$x[koli];$subkguld+=$x[berat];
}				

				$jml=mysql_query("SELECT SUM(koli) AS jum, SUM(berat) as ber FROM isimanifestout WHERE idmanifestout='$_POST[idm]' AND statusvoid='0' AND statuscancel='0' AND nould like '%BULK%'");
				$beratuld=mysql_fetch_array(mysql_query("
					select berat as beratuld from beratuld where uld='$no_uld' AND idmanifestout='$_POST[idm]'"));
			 
				$pdf->Cell(35,1,'',0,0,'L',1);
				$pdf->Cell(20,1,'---------',0,0,'L',1);
				$pdf->Cell(38,1,'',0,0,'L',1);
				$pdf->Cell(15,1,'',0,0,'C',1);
				$pdf->Cell(20,1,'---------',0,0,'R',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Ln();				 	
	//		  while ($y=mysql_fetch_array($jml))
		//		{
				//$grossweight=$y[ber]+ $beratuld[beratuld];	ndk jadi, pake netto saja
				$grossweight=$subkguld;	
				$pdf->SetX(20);
				$pdf->Cell(40,5,'',0,0,'L',1);
				$pdf->SetX(43);				
				$pdf->Cell(15,5,number_format($subkoliuld, 0, '.', '.'),0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,number_format($grossweight, 1, ',', '.'),0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln(3);
				$totberat+=$grossweight;
				$totkoli+=$subkoliuld;
				$subkoliuld=0;$subkguld=0;
			//	}						

			$no+=1;
			}
			

	$pdf->Ln(5);	 
				$pdf->SetX(10);
				$pdf->Cell(28,5,'TOTAL',0,0,'L',1);		
				$pdf->Cell(20,5,number_format($totkoli, 0, '.', '.'),0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,number_format($totberat, 1, ',', '.'),0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln();		
		$pdf->Ln(10);
		
	$pdf->Cell(40,8,'PREPARED BY : '.$nama[nama_lengkap],0,0,'L',1);$pdf->Ln(5);
	$pdf->Cell(40,8,'ID : '.$nama[nipp],0,0,'L',1);
	
//*********putu

//1. print yang sama dgn destination dulu
// yang sama dgn destinasi 2 dulu
				
				$pdf->AddPage();
			
			$pdf->SetFillColor(255,255,255);
$no=1;
			$pdf->Ln();				



$pdf->Cell(190,8,$p[origin_code].'-'. $tujuan2,0,0,'C',1);		
$pdf->Ln();							
			//siapkan data
			$jbr=0;$jkl=0;
/*
			  $uld=mysql_query("SELECT i.nould FROM isimanifestout as i, 
				manifestout as m,master_smu as s  
				where m.idmanifestout=i.idmanifestout AND i.idmanifestout='$_POST[idm]' AND
				i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND
				m.statusvoid='0' AND s.iddestination='$p[iddestination2]'AND 
				m.statuscancel='0' AND m.statusconfirm='1' GROUP BY i.nould");*/
				$uld=mysql_query("SELECT i.nould FROM isimanifestout as i, 
				manifestout as m,master_smu as s  
				where m.idmanifestout=i.idmanifestout AND i.idmanifestout='$_POST[idm]' AND
				i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND
				m.statusvoid='0' AND s.iddestination='$p[iddestination2]'AND 
				m.statuscancel='0' AND i.nould not like '%bulk%' GROUP BY i.nould");
				while ($r=mysql_fetch_array($uld))
				{
					$no_uld=$r[nould];
					$pdf->SetFont('Arial','',10);
					//$pdf->Ln(1);
					$pdf->Cell(30,8,format_uld($r[nould]),0,0,'L',1);		
					$pdf->Ln();
$jbr=0;$jkl=0;
$subkoliuld=0;$subkguld=0;
$smu=mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	 AND m.idmanifestout='$_POST[idm]' AND i.nould='$no_uld' AND d.dest_code='$p[dest_code]'"); 
			while ($x=mysql_fetch_array($smu))
				{
/*
					$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_POST[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0' AND m.statusconfirm='1' AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
*/
$of=mysql_fetch_array(mysql_query("select s.koli from isimanifestout as i, manifestout as m, master_smu as s 
WHERE i.idmanifestout=m.idmanifestout AND i.idmastersmu=s.idmastersmu AND
m.statuscancel='0' AND m.statusvoid='0'  AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
				if($of[0]<=$x[koli])
				{$str_of='';}else
				{$str_of='/'. $of[0];}
				if($x[commodity]<>'GEN')
				{$str_com=$x[commodity];}
				else
				{$str_com='';}
$pdf->SetX(15);
 $pdf->SetAligns(array('L','R','L','L','L','R','C','C')); 
$pdf->SetWidths(array(28,15,15,40,10,15,15,15)); 
$pdf->Row(array(format_awb($x[nosmu]),number_format($x[koli], 0, '.', '.'),$str_of,$x[commodityap],$str_com,number_format($x[berat], 1, ',', '.'),$x[origin_code],$x[dest_code]));
$subkoliuld+=$x[koli];$subkguld+=$x[berat];
}				

				$jml=mysql_query("SELECT SUM(koli) AS jum, SUM(berat) as ber FROM isimanifestout WHERE idmanifestout='$_POST[idm]' AND statusvoid='0' AND statuscancel='0' AND nould='$no_uld'");
				$beratuld=mysql_fetch_array(mysql_query("
					select berat as beratuld from beratuld where uld='$no_uld' AND idmanifestout='$_POST[idm]'"));
			 
				$pdf->Cell(35,1,'',0,0,'L',1);
				$pdf->Cell(20,1,'---------',0,0,'L',1);
				$pdf->Cell(38,1,'',0,0,'L',1);
				$pdf->Cell(15,1,'',0,0,'C',1);
				$pdf->Cell(20,1,'---------',0,0,'R',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Ln();				 	
//			  while ($y=mysql_fetch_array($jml))
	//			{
				//$grossweight=$y[ber]+ $beratuld[beratuld];	ndk jadi, pake netto saja
				$grossweight=$subkguld;	
				$pdf->SetX(20);
				$pdf->Cell(40,5,'',0,0,'L',1);
				$pdf->SetX(43);				
				$pdf->Cell(15,5,number_format($subkoliuld, 0, '.', '.'),0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,number_format($grossweight, 1, ',', '.'),0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln(3);
				$totberat+=$grossweight;
				$totkoli+=$subkoliuld;
				$subkoliuld=0;$subkguld=0;
		//		}						

			$no+=1;
			

			}
//BULK			

$jmlbulk=mysql_num_rows(mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	 AND m.idmanifestout='$_POST[idm]' AND i.nould like '%bulk%' AND d.dest_code='$p[dest_code]'"));
if($jmlbulk>0){
						$no_uld=$r[nould];
					$pdf->SetFont('Arial','',10);
					//$pdf->Ln();
					$pdf->Cell(30,8,'BULK',0,0,'L',1);		
					$pdf->Ln();
$jbr=0;$jkl=0;
$smu=mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	 AND m.idmanifestout='$_POST[idm]' AND i.nould like '%bulk%' AND d.dest_code='$p[dest_code]'"); 
	$subkoliuld=0;$subkguld=0; 
			while ($x=mysql_fetch_array($smu))
				{
/*
					$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_POST[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0' AND m.statusconfirm='1' AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
*/
$of=mysql_fetch_array(mysql_query("select s.koli from isimanifestout as i, manifestout as m, master_smu as s 
WHERE i.idmanifestout=m.idmanifestout AND i.idmastersmu=s.idmastersmu AND
m.statuscancel='0' AND m.statusvoid='0'  AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
				if($of[0]<=$x[koli])
				{$str_of='';}else
				{$str_of='/'. $of[0];}
				if($x[commodity]<>'GEN')
				{$str_com=$x[commodity];}
				else
				{$str_com='';}
$pdf->SetX(15);
 $pdf->SetAligns(array('L','R','L','L','L','R','C','C')); 
$pdf->SetWidths(array(28,15,15,40,10,15,15,15)); 
$pdf->Row(array(format_awb($x[nosmu]),number_format($x[koli], 0, '.', '.'),$str_of,$x[commodityap],$str_com,number_format($x[berat], 1, ',', '.'),$x[origin_code],$x[dest_code]));
$subkoliuld+=$x[koli];$subkguld+=$x[berat];
}				

	/*			$jml=mysql_query("SELECT SUM(koli) AS jum, SUM(berat) as ber FROM isimanifestout WHERE idmanifestout='$_POST[idm]' AND statusvoid='0' AND statuscancel='0' AND nould='$no_uld'");
		*/		$beratuld=mysql_fetch_array(mysql_query("
					select berat as beratuld from beratuld where uld='$no_uld' AND idmanifestout='$_POST[idm]'"));
			 
				$pdf->Cell(35,1,'',0,0,'L',1);
				$pdf->Cell(20,1,'---------',0,0,'L',1);
				$pdf->Cell(38,1,'',0,0,'L',1);
				$pdf->Cell(15,1,'',0,0,'C',1);
				$pdf->Cell(20,1,'---------',0,0,'R',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Ln();				 	
			 // while ($y=mysql_fetch_array($jml))
				//{
				//$grossweight=$y[ber]+ $beratuld[beratuld];	ndk jadi, pake netto saja
				$grossweight=$subkguld;	
				$pdf->SetX(20);
				$pdf->Cell(40,5,'',0,0,'L',1);
				$pdf->SetX(43);				
				$pdf->Cell(15,5,number_format($subkoliuld, 0, '.', '.'),0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,number_format($grossweight, 1, ',', '.'),0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln(3);
				$totberat+=$grossweight;
				$totkoli+=$subkoliuld;
				$subkoliuld=0;$subkguld=0;
			//	}						

			$no+=1;
			}

			
			
			
 
	$pdf->Ln(5);	 
				$pdf->SetX(10);
				$pdf->Cell(28,5,'TOTAL',0,0,'L',1);		
				$pdf->Cell(20,5,number_format($totkoli, 0, '.', '.'),0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,number_format($totberat, 1, ',', '.'),0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln();		
		$pdf->Ln(10);
		
	$pdf->Cell(40,8,'PREPARED BY : '.$nama[nama_lengkap],0,0,'L',1);$pdf->Ln(5);
	$pdf->Cell(40,8,'ID : '.$nama[nipp],0,0,'L',1);
//2. print yang tdk sama dgn destination 
//utk destinasi 1
				
				$pdf->AddPage();
			
			$pdf->SetFillColor(255,255,255);
$no=1;
$totberat=0;$totkoli=0;$grossweight=0;
			$pdf->SetFillColor(255,255,255);
						$pdf->Ln();				



$pdf->Cell(190,8,$p[origin_code].'-'. $tujuan1,0,0,'C',1);		
$pdf->Ln();				
			//siapkan data
			$jbr=0;$jkl=0;
/*
			  $uld=mysql_query("SELECT i.nould FROM isimanifestout as i, 
				manifestout as m,master_smu as s  
				where m.idmanifestout=i.idmanifestout AND i.idmanifestout='$_POST[idm]' AND
				i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND
				m.statusvoid='0' AND s.iddestination<>'$p[iddestination2]'AND 
				m.statuscancel='0' AND m.statusconfirm='1' GROUP BY i.nould");
*/

$uld=mysql_query("SELECT i.nould FROM isimanifestout as i, 
				manifestout as m,master_smu as s  
				where m.idmanifestout=i.idmanifestout AND i.idmanifestout='$_POST[idm]' AND
				i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND
				m.statusvoid='0' AND s.iddestination<>'$p[iddestination2]'AND 
				m.statuscancel='0' AND  i.nould not like '%bulk%' GROUP BY i.nould");
				while ($r=mysql_fetch_array($uld))
				{
					$no_uld=$r[nould];
					$pdf->SetFont('Arial','',10);
					//$pdf->Ln(1);
					$pdf->Cell(30,8,format_uld($r[nould]),0,0,'L',1);		
					$pdf->Ln();
$jbr=0;$jkl=0;
$smu=mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	 AND m.idmanifestout='$_POST[idm]' AND i.nould='$no_uld' AND d.dest_code<>'$p[dest_code]'"); 
	$subkoliuld=0;$subkguld=0; 
			while ($x=mysql_fetch_array($smu))
				{
/*
					$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_POST[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0' AND m.statusconfirm='1' AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
*/
$of=mysql_fetch_array(mysql_query("select s.koli from isimanifestout as i, manifestout as m, master_smu as s 
WHERE i.idmanifestout=m.idmanifestout AND i.idmastersmu=s.idmastersmu AND
m.statuscancel='0' AND m.statusvoid='0'  AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
				if($of[0]<=$x[koli])
				{$str_of='';}else
				{$str_of='/'. $of[0];}
				if($x[commodity]<>'GEN')
				{$str_com=$x[commodity];}
				else
				{$str_com='';}
$pdf->SetX(15);
 $pdf->SetAligns(array('L','R','L','L','L','R','C','C')); 
$pdf->SetWidths(array(28,15,15,40,10,15,15,15)); 
$pdf->Row(array(format_awb($x[nosmu]),number_format($x[koli], 0, '.', '.'),$str_of,$x[commodityap],$str_com,number_format($x[berat], 1, ',', '.'),$x[origin_code],$x[dest_code]));
$subkoliuld+=$x[koli];$subkguld+=$x[berat];
}				

				$beratuld=mysql_fetch_array(mysql_query("
					select berat as beratuld from beratuld where uld='$no_uld' AND idmanifestout='$_POST[idm]'"));
			 
				$pdf->Cell(35,1,'',0,0,'L',1);
				$pdf->Cell(20,1,'---------',0,0,'L',1);
				$pdf->Cell(38,1,'',0,0,'L',1);
				$pdf->Cell(15,1,'',0,0,'C',1);
				$pdf->Cell(20,1,'---------',0,0,'R',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Ln();				 	
	//		  while ($y=mysql_fetch_array($jml))
	//			{
				//$grossweight=$y[ber]+ $beratuld[beratuld];	ndk jadi, pake netto saja
				$grossweight=$subkguld;	
				$pdf->SetX(20);
				$pdf->Cell(40,5,'',0,0,'L',1);
				$pdf->SetX(43);				
				$pdf->Cell(15,5,number_format($subkoliuld, 0, '.', '.'),0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,number_format($grossweight, 1, ',', '.'),0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln(3);
				$totberat+=$grossweight;
				$totkoli+=$subkoliuld;
				$subkoliuld=0;$subkguld=0;
		//		}						

			$no+=1;
			

			}
			

//BULK			

$jmlbulk=mysql_num_rows(mysql_query("SELECT i.nould FROM isimanifestout as i, 
				manifestout as m,master_smu as s  
				where m.idmanifestout=i.idmanifestout AND i.idmanifestout='$_POST[idm]' AND
				i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND
				m.statusvoid='0' AND s.iddestination<>'$p[iddestination2]'AND 
				m.statuscancel='0' AND i.nould like '%bulk%' GROUP BY i.nould"));
if($jmlbulk>0){
						$no_uld=$r[nould];
					$pdf->SetFont('Arial','',10);
				//	$pdf->Ln();
					$pdf->Cell(30,8,'BULK',0,0,'L',1);		
					$pdf->Ln();
$jbr=0;$jkl=0;
$smu=mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	 AND m.idmanifestout='$_POST[idm]' AND i.nould like '%bulk%' AND d.dest_code<>'$p[dest_code]'"); 
	$subkoliuld=0;$subkguld=0; 
			while ($x=mysql_fetch_array($smu))
				{
/*
					$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_POST[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0' AND m.statusconfirm='1' AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
*/
$of=mysql_fetch_array(mysql_query("select s.koli from isimanifestout as i, manifestout as m, master_smu as s 
WHERE i.idmanifestout=m.idmanifestout AND i.idmastersmu=s.idmastersmu AND
m.statuscancel='0' AND m.statusvoid='0'  AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
				if($of[0]<=$x[koli])
				{$str_of='';}else
				{$str_of='/'. $of[0];}
				if($x[commodity]<>'GEN')
				{$str_com=$x[commodity];}
				else
				{$str_com='';}
$pdf->SetX(15);
 $pdf->SetAligns(array('L','R','L','L','L','R','C','C')); 
$pdf->SetWidths(array(28,15,15,40,10,15,15,15)); 
$pdf->Row(array(format_awb($x[nosmu]),number_format($x[koli], 0, '.', '.'),$str_of,$x[commodityap],$str_com,number_format($x[berat], 1, ',', '.'),$x[origin_code],$x[dest_code]));
$subkoliuld+=$x[koli];$subkguld+=$x[berat];
}				

					$beratuld=mysql_fetch_array(mysql_query("
					select berat as beratuld from beratuld where uld='$no_uld' AND idmanifestout='$_POST[idm]'"));
			 
				$pdf->Cell(35,1,'',0,0,'L',1);
				$pdf->Cell(20,1,'---------',0,0,'L',1);
				$pdf->Cell(38,1,'',0,0,'L',1);
				$pdf->Cell(15,1,'',0,0,'C',1);
				$pdf->Cell(20,1,'---------',0,0,'R',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Ln();				 	
				//$grossweight=$y[ber]+ $beratuld[beratuld];	ndk jadi, pake netto saja
				$grossweight=$subkguld;	
				$pdf->SetX(20);
				$pdf->Cell(40,5,'',0,0,'L',1);
				$pdf->SetX(43);				
				$pdf->Cell(15,5,number_format($subkoliuld, 0, '.', '.'),0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,number_format($grossweight, 1, ',', '.'),0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln(3);
				$totberat+=$grossweight;
				$totkoli+=$subkoliuld;
	$subkoliuld=0;$subkguld=0;
			$no+=1;
			}
			

	$pdf->Ln(5);	 
				$pdf->SetX(10);
				$pdf->Cell(28,5,'TOTAL',0,0,'L',1);		
				$pdf->Cell(20,5,number_format($totkoli, 0, '.', '.'),0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,number_format($totberat, 1, ',', '.'),0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln();		
		$pdf->Ln(10);
		
	$pdf->Cell(40,8,'PREPARED BY : '.$nama[nama_lengkap],0,0,'L',1);$pdf->Ln(5);
	$pdf->Cell(40,8,'ID : '.$nama[nipp],0,0,'L',1);
	
	
//***********
}//end of jika destinasi 2 ada
}

	
$pdf->Output();
	
?>