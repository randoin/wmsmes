<?php
session_start();
require "fpdf.php";
include "config/koneksi.php";
include "config/library.php";
$module=$_GET[module];
$act=$_GET[act];

//******************************START OF EXPORT ********************************************

//---------------UPDATE Berat ULD-------------------------------------------------
if ($module=='beratuld' AND $act=='update')
{
	$uld=$_POST['uld'];$idb=$_POST['idb'];$berat=$_POST['berat'];
	$n=0;
	foreach ($idb as $idb1)
		{
			$idb[n]=$idb1;$n+=1;
		}$n=0;
	foreach ($berat as $berat1)
		{
			$berat[n]=$berat1;$n+=1;
		}	$n=0;	
foreach ($uld as $uld1)
		{
			mysql_query("UPDATE beratuld SET uld='$uld1', 
				berat= '$berat[$n]' WHERE idberauld  = '$idb[$n]'");
					$n+=1;
		}
 
header('location:media.php?module=carimanifestexport&d='.$_POST[d]);

}
//---------------End of UPDATE BERAT ULD -------------------------------------------------


//---------------Confirm AWB Manifest Export -------------------------------------------------
if ($module=='carimanifestexport' AND $act=='confirm')
{
  mysql_query("UPDATE manifestout SET statusconfirm='1' WHERE idmanifestout  = '$_GET[idm]'");
  header('location:media.php?module='.$module.'&d='.$_GET[d]);
}
//---------------End of Confirm AWB Manifest Export -------------------------------------------------

//------------- Mencetak Manifest Export ---------
if ($module=='cetakmanifestout')
{


	class PDF extends FPDF
	{
		//Page header
		function Header()
		{	
		$this->SetLeftMargin(10);			
//			$this->SetX(100);
			$this->SetFont('Arial','B',14);
			$this->Ln(10);
			$this->Cell(190,20,'C A R G O   M A N I F E S T',0,0,'C');
			$this->Ln(10);
			$this->Cell(190,20,'ICAO ANNEX 9 APPENDIX 2',0,0,'C');
			$this->Ln();			
				
		}
		
		//Page footer
		function Footer()
		{
			/*
			//Position at 1.5 cm from bottom
			$this->SetY(-15);
			//Arial italic 8
			$this->SetFont('Arial','I',8);
			//Page number
			$this->Cell(0,10,'GAPURA BALI WMS INTER - Page '.$this->PageNo().'/{nb}',0,0,'C');
		*/
		}
	}
	
	$totberat=0;$totkoli=0;
	//Instanciation of inherited class
	$pdf=new PDF('P','mm','A4');
	
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

//cek nil dulu
$ceknil=mysql_num_rows(mysql_query("SELECT i.nould FROM isimanifestout as i, manifestout as m 
				where m.idmanifestout=i.idmanifestout AND i.idmanifestout='$_GET[idm]' 
				AND i.statusvoid='0' AND i.statuscancel='0' AND m.statusvoid='0' AND 
				m.statuscancel='0'  "));
if($ceknil<=0)
{
$tampil=mysql_query("SELECT m.idmanifestout,m.acregister,m.flightdate,m.pointofloading,m.pointul,m.statusnil,
f.flight,o.origin_code, d.dest_code,m.statusconfirm,m.statuscancel,c.bendera,c.cus_desc
FROM manifestout as m,origin as o,destination as d,flight as f, customer as c
WHERE m.idorigin=o.idorigin AND m.iddestination=d.iddestination AND m.idflight=f.idflight AND m.statusvoid='0' AND f.idcustomer=c.idcustomer AND m.idmanifestout='$_GET[idm]'"); 
	
$p=mysql_fetch_array($tampil);
$pdf->AddPage();

 	//bikin halaman baru
			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(50,5,'OWNER/OPERATOR',0,0,'L',1);
			$pdf->Cell(50,5,'A/C REGISTRATION',0,0,'L',1);
			$pdf->Cell(50,5,'FLIGHT NO',0,0,'L',1);
			$pdf->Cell(50,5,'DATE',0,0,'L',1);
			$pdf->Ln();			
			$pdf->Cell(50,5,$p[cus_desc],0,0,'L',1);
			$pdf->Cell(50,5,$p[acregister],0,0,'L',1);
			$pdf->Cell(50,5,$p[flight],0,0,'L',1);
			$pdf->Cell(50,5,ymd2dmy($p[flightdate]),0,0,'L',1);$pdf->Ln();			
			$pdf->Cell(50,5,'',0,0,'L',1);
			$pdf->Cell(50,5,'',0,0,'L',1);
			$pdf->Cell(50,5,'',0,0,'L',1);
			$pdf->Cell(50,5,'WEIGHT IN KG',0,0,'L',1);
			$pdf->Ln(10);			
			$pdf->Cell(100,5,'POINT OF LOADING : '.$p[pointofloading],0,0,'L',1);
			$pdf->Cell(100,5,'POINT OF UNLOADING : '.$p[pointul],0,0,'L',1);
			$pdf->Ln(15);							
			$pdf->Cell(40,5,'AWB NUMBER',0,0,'L',1);
			$pdf->Cell(15,5,'NO',0,0,'L',1);
			$pdf->Cell(50,5,'NATURE OF GOODS',0,0,'L',1);
			$pdf->Cell(5,5,'',0,0,'L',1);
			$pdf->Cell(20,5,'WEIGHT',0,0,'C',1);
			$pdf->Cell(10,5,'EX',0,0,'C',1);
			$pdf->Cell(10,5,'TO',0,0,'C',1);
			$pdf->Cell(50,5,'FOR OFFICIAL',0,0,'L',1);
			$pdf->Ln();					
			$pdf->Cell(40,5,'',0,0,'L',1);
			$pdf->Cell(10,5,'PKG',0,0,'L',1);
			$pdf->Cell(50,5,'',0,0,'L',1);
			$pdf->Cell(10,5,'',0,0,'L',1);
			$pdf->Cell(20,5,'KGS',0,0,'C',1);
			$pdf->Cell(10,5,'',0,0,'L',1);
			$pdf->Cell(10,5,'',0,0,'L',1);
			$pdf->Cell(50,5,'USE ONLY',0,0,'L',1);
			$pdf->Ln(30);
						$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','',20);
			$pdf->Cell(200,8,'NIL ',0,0,'C',1);
			$pdf->Ln(30);
			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','',10);			


				$pdf->Cell(40,8,'PREPARED BY : ',0,0,'C',1);	
}
else
{

//Jika manifest NORMAL
if($_GET[s]=='0')
{
$no=1;
$tampil=mysql_query("SELECT m.idmanifestout,m.acregister,m.flightdate,m.pointofloading,m.pointul,m.statusnil,
f.flight,o.origin_code, d.dest_code,m.statusconfirm,m.statuscancel,c.bendera,c.cus_desc
FROM manifestout as m,origin as o,destination as d,flight as f, customer as c
WHERE m.idorigin=o.idorigin AND m.iddestination=d.iddestination AND m.idflight=f.idflight AND m.statusvoid='0' AND f.idcustomer=c.idcustomer AND m.idmanifestout='$_GET[idm]'"); 
	
$p=mysql_fetch_array($tampil);
    $pdf->AddPage();

 	//bikin halaman baru
			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(50,5,'OWNER/OPERATOR',0,0,'L',1);
			$pdf->Cell(50,5,'A/C REGISTRATION',0,0,'L',1);
			$pdf->Cell(50,5,'FLIGHT NO',0,0,'L',1);
			$pdf->Cell(50,5,'DATE',0,0,'L',1);
			$pdf->Ln();			
			$pdf->Cell(50,5,$p[cus_desc],0,0,'L',1);
			$pdf->Cell(50,5,$p[acregister],0,0,'L',1);
			$pdf->Cell(50,5,$p[flight],0,0,'L',1);
			$pdf->Cell(50,5,ymd2dmy($p[flightdate]),0,0,'L',1);$pdf->Ln();			
			$pdf->Cell(50,5,'',0,0,'L',1);
			$pdf->Cell(50,5,'',0,0,'L',1);
			$pdf->Cell(50,5,'',0,0,'L',1);
			$pdf->Cell(50,5,'WEIGHT IN KG',0,0,'L',1);
			$pdf->Ln(10);			
			$pdf->Cell(100,5,'POINT OF LOADING : '.$p[pointofloading],0,0,'L',1);
			$pdf->Cell(100,5,'POINT OF UNLOADING : '.$p[pointul],0,0,'L',1);
			$pdf->Ln(15);							
			$pdf->Cell(40,5,'AWB NUMBER',0,0,'L',1);
			$pdf->Cell(15,5,'NO',0,0,'L',1);
			$pdf->Cell(50,5,'NATURE OF GOODS',0,0,'L',1);
			$pdf->Cell(5,5,'',0,0,'L',1);
			$pdf->Cell(20,5,'WEIGHT',0,0,'C',1);
			$pdf->Cell(10,5,'EX',0,0,'C',1);
			$pdf->Cell(10,5,'TO',0,0,'C',1);
			$pdf->Cell(50,5,'FOR OFFICIAL',0,0,'L',1);
			$pdf->Ln();					
			$pdf->Cell(40,5,'',0,0,'L',1);
			$pdf->Cell(10,5,'PKG',0,0,'L',1);
			$pdf->Cell(50,5,'',0,0,'L',1);
			$pdf->Cell(10,5,'',0,0,'L',1);
			$pdf->Cell(20,5,'KGS',0,0,'C',1);
			$pdf->Cell(10,5,'',0,0,'L',1);
			$pdf->Cell(10,5,'',0,0,'L',1);
			$pdf->Cell(50,5,'USE ONLY',0,0,'L',1);
			$pdf->Ln();					
			
			//siapkan data utk ULD selain BULK
			  $uld=mysql_query("SELECT i.nould FROM isimanifestout as i, manifestout as m 
				where m.idmanifestout=i.idmanifestout AND i.idmanifestout='$_GET[idm]' 
				AND i.statusvoid='0' AND i.statuscancel='0' AND m.statusvoid='0' AND 
				m.statuscancel='0'  AND i.nould NOT like '%bulk%' GROUP BY i.nould order by i.idisimanifestout ASC");
				/*
 $uld=mysql_query("SELECT i.nould FROM isimanifestout as i, manifestout as m 
				where m.idmanifestout=i.idmanifestout AND i.idmanifestout='$_GET[idm]' 
				AND i.statusvoid='0' AND i.statuscancel='0' AND m.statusvoid='0' AND 
				m.statuscancel='0' AND m.statusconfirm='1' GROUP BY i.nould order by i.idisimanifestout ASC");
*/
				while ($r=mysql_fetch_array($uld))
				{
					$no_uld=$r[nould];
					$pdf->SetFont('Arial','',10);
					//$pdf->Ln(1);
					$pdf->Cell(40,8,format_uld($r[nould]),0,0,'L',1);		
					$pdf->Ln();

$smu=mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	 AND m.idmanifestout='$_GET[idm]' AND i.nould='$no_uld'"); 
			while ($x=mysql_fetch_array($smu))
				{
					/*$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_GET[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0'  AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));*/
$of=mysql_fetch_array(mysql_query("select s.koli from isimanifestout as i, manifestout as m, master_smu as s 
WHERE i.idmanifestout=m.idmanifestout AND i.idmastersmu=s.idmastersmu AND
m.statuscancel='0' AND m.statusvoid='0'  AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
		
/*
$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_GET[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0' AND m.statusconfirm='1' AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));

*/
				$pdf->SetX(20);
				$pdf->Cell(40,5,format_awb($x[nosmu]),0,0,'L',1);
				$pdf->SetX(45);				
				$pdf->Cell(10,5,$x[koli],0,0,'R',1);
				
				if($of[0]<=$x[koli])
				{
					$pdf->Cell(8,5,'',0,0,'L',1);}else
					{
						$pdf->Cell(8,5,'/'. $of[0],0,0,'L',1);}
						
				$pdf->Cell(50,5,$x[commodityap],0,0,'L',1);
				if($x[commodity]<>'GEN')
				{$pdf->Cell(10,5,$x[commodity],0,0,'C',1);}
				else
				{$pdf->Cell(10,5,'',0,0,'C',1);}
				$pdf->Cell(12,5,$x[berat],0,0,'R',1);
				$pdf->SetX(140);				
				$pdf->Cell(10,5,$x[origin_code],0,0,'C',1);
				$pdf->Cell(10,5,$x[dest_code],0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln();
				}				
				$jml=mysql_query("SELECT SUM(koli) AS jum, SUM(berat) as ber FROM isimanifestout WHERE idmanifestout='$_GET[idm]' AND statusvoid='0' AND statuscancel='0' AND nould='$no_uld'");
				$beratuld=mysql_fetch_array(mysql_query("
					select berat as beratuld from beratuld where uld='$no_uld' AND idmanifestout='$_GET[idm]'"));
			 
				$pdf->Cell(35,1,'',0,0,'L',1);
				$pdf->Cell(10,1,'---------',0,0,'L',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(20,1,'---------',0,0,'R',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Ln();				 	
			  while ($y=mysql_fetch_array($jml))
				{
				//$grossweight=$y[ber]+ $beratuld[beratuld];	ndk jadi, pake netto saja
				$grossweight=$y[ber];	
				$pdf->SetX(20);
				$pdf->Cell(40,5,'',0,0,'L',1);
				$pdf->SetX(45);				
				$pdf->Cell(10,5,$y[jum],0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,$grossweight,0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln(1);
				$totberat+=$grossweight;
				$totkoli+=$y[jum];
				}							

			$no+=1;
			

			}
			
						//siapkan data utk ULD  BULK

$jmldes=mysql_num_rows(mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	 AND m.idmanifestout='$_GET[idm]' AND i.nould like '%bulk%'"));
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
	 AND m.idmanifestout='$_GET[idm]' AND i.nould like '%bulk%'"); 
			while ($x=mysql_fetch_array($smu))
				{
/*					$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_GET[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0'  AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
*/$of=mysql_fetch_array(mysql_query("select s.koli from isimanifestout as i, manifestout as m, master_smu as s 
WHERE i.idmanifestout=m.idmanifestout AND i.idmastersmu=s.idmastersmu AND
m.statuscancel='0' AND m.statusvoid='0'  AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));


/*
$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_GET[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0' AND m.statusconfirm='1' AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));

*/
				$pdf->SetX(20);
				$pdf->Cell(40,5,format_awb($x[nosmu]),0,0,'L',1);
				$pdf->SetX(45);				
				$pdf->Cell(10,5,$x[koli],0,0,'R',1);
				if($of[0]<=$x[koli])
				{
					$pdf->Cell(8,5,'',0,0,'L',1);}else
					{
						$pdf->Cell(8,5,'/'. $of[0],0,0,'L',1);}
						
				$pdf->Cell(50,5,$x[commodityap],0,0,'L',1);
if($x[commodity]<>'GEN')
				{$pdf->Cell(10,5,$x[commodity],0,0,'C',1);}
				else
				{$pdf->Cell(10,5,'',0,0,'C',1);}
				

				$pdf->Cell(12,5,$x[berat],0,0,'R',1);
				$pdf->SetX(140);				
				$pdf->Cell(10,5,$x[origin_code],0,0,'C',1);
				$pdf->Cell(10,5,$x[dest_code],0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln();
				}				
				$jml=mysql_query("SELECT SUM(koli) AS jum, SUM(berat) as ber FROM isimanifestout WHERE idmanifestout='$_GET[idm]' AND statusvoid='0' AND statuscancel='0' AND nould like '%bulk%'");
				$beratuld=mysql_fetch_array(mysql_query("
					select sum(berat) as beratuld from beratuld where uld like 'bulk' AND idmanifestout='$_GET[idm]'"));
			 
				$pdf->Cell(35,1,'',0,0,'L',1);
				$pdf->Cell(10,1,'---------',0,0,'L',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(20,1,'---------',0,0,'R',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Ln();				 	
			  while ($y=mysql_fetch_array($jml))
				{
				//$grossweight=$y[ber]+ $beratuld[beratuld];	ndk jadi, pake netto saja
				$grossweight=$y[ber];	
				$pdf->SetX(20);
				$pdf->Cell(40,5,'',0,0,'L',1);
				$pdf->SetX(45);				
				$pdf->Cell(10,5,$y[jum],0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,$grossweight,0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln(1);
				$totberat+=$grossweight;
				$totkoli+=$y[jum];
				}							

			$no+=1;
			}
			
	$pdf->Ln(10);	 
				$pdf->SetX(20);
				$pdf->Cell(40,5,'TOTAL',0,0,'L',1);
				$pdf->SetX(45);				
				$pdf->Cell(10,5,$totkoli,0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,$totberat,0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln();		
		$pdf->Ln(10);
		
	$pdf->Cell(40,8,'PREPARED BY : ',0,0,'C',1);	
	}//end of NORMAL MANIFEST

// jika SPLIT MANIFEST -> 1 manifest utk split, 1 manifest utl selainnya
else
{
//1. print yang sama dgn destination dulu
// yang sama dgn destinasi 1 dulu
$no=1;
$tampil=mysql_query("SELECT m.idmanifestout,m.iddestination2,m.acregister,m.flightdate,m.pointofloading,m.pointul,m.statusnil,m.iddestination,
f.flight,o.origin_code, d.dest_code,m.statusconfirm,m.statuscancel,c.bendera,c.cus_desc
FROM manifestout as m,origin as o,destination as d,flight as f, customer as c
WHERE m.idorigin=o.idorigin AND m.iddestination=d.iddestination AND m.idflight=f.idflight AND m.statusvoid='0' AND f.idcustomer=c.idcustomer AND m.idmanifestout='$_GET[idm]'"); 
	
$p=mysql_fetch_array($tampil);
//$dest1=mysql_fetch_array(mysql_query("select dest_code 
//from destination where iddestination=$p[iddestination2]"));
    $pdf->AddPage();

 	//bikin halaman baru
			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(50,5,'OWNER/OPERATOR',0,0,'L',1);
			$pdf->Cell(50,5,'A/C REGISTRATION',0,0,'L',1);
			$pdf->Cell(50,5,'FLIGHT NO',0,0,'L',1);
			$pdf->Cell(50,5,'DATE',0,0,'L',1);
			$pdf->Ln();			
			$pdf->Cell(50,5,$p[cus_desc],0,0,'L',1);
			$pdf->Cell(50,5,$p[acregister],0,0,'L',1);
			$pdf->Cell(50,5,$p[flight],0,0,'L',1);
			$pdf->Cell(50,5,ymd2dmy($p[flightdate]),0,0,'L',1);$pdf->Ln();			
			$pdf->Cell(50,5,'',0,0,'L',1);
			$pdf->Cell(50,5,'',0,0,'L',1);
			$pdf->Cell(50,5,'',0,0,'L',1);
			$pdf->Cell(50,5,'WEIGHT IN KG',0,0,'L',1);
			$pdf->Ln(10);			
			$pdf->Cell(100,5,'POINT OF LOADING : '.$p[pointofloading],0,0,'L',1);
			$pdf->Cell(100,5,'POINT OF UNLOADING : '.$p[pointul],0,0,'L',1);
			$pdf->Ln(15);							
			$pdf->Cell(40,5,'AWB NUMBER',0,0,'L',1);
			$pdf->Cell(15,5,'NO',0,0,'L',1);
			$pdf->Cell(50,5,'NATURE OF GOODS',0,0,'L',1);
			$pdf->Cell(5,5,'',0,0,'L',1);
			$pdf->Cell(20,5,'WEIGHT',0,0,'C',1);
			$pdf->Cell(10,5,'EX',0,0,'C',1);
			$pdf->Cell(10,5,'TO',0,0,'C',1);
			$pdf->Cell(50,5,'FOR OFFICIAL',0,0,'L',1);
			$pdf->Ln();					
			$pdf->Cell(40,5,'',0,0,'L',1);
			$pdf->Cell(10,5,'PKG',0,0,'L',1);
			$pdf->Cell(50,5,'',0,0,'L',1);
			$pdf->Cell(10,5,'',0,0,'L',1);
			$pdf->Cell(20,5,'KGS',0,0,'C',1);
			$pdf->Cell(10,5,'',0,0,'L',1);
			$pdf->Cell(10,5,'',0,0,'L',1);
			$pdf->Cell(50,5,'USE ONLY',0,0,'L',1);
		//	$pdf->Ln();					
			
			//siapkan data
			$jbr=0;$jkl=0;
/*
			  $uld=mysql_query("SELECT i.nould FROM isimanifestout as i, 
				manifestout as m,master_smu as s  
				where m.idmanifestout=i.idmanifestout AND i.idmanifestout='$_GET[idm]' AND
				i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND
				m.statusvoid='0' AND s.iddestination='$p[iddestination]' AND 
				m.statuscancel='0' AND m.statusconfirm='1' GROUP BY i.nould");*/
				$uld=mysql_query("SELECT i.nould FROM isimanifestout as i, 
				manifestout as m,master_smu as s  
				where m.idmanifestout=i.idmanifestout AND i.idmanifestout='$_GET[idm]' AND
				i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND
				m.statusvoid='0' AND s.iddestination='$p[iddestination]' AND 
				m.statuscancel='0' AND i.nould not like '%bulk%' GROUP BY i.nould");
				while ($r=mysql_fetch_array($uld))
				{
					$no_uld=$r[nould];
					$pdf->SetFont('Arial','',10);
					$pdf->Ln();
					$pdf->Cell(40,8,format_uld($r[nould]),0,0,'L',1);		
					$pdf->Ln();
$jbr=0;$jkl=0;
$smu=mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	 AND m.idmanifestout='$_GET[idm]' AND i.nould='$no_uld' AND d.dest_code='$p[dest_code]'"); 
			while ($x=mysql_fetch_array($smu))
				{
/*
					$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_GET[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0' AND m.statusconfirm='1' AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
*/
$of=mysql_fetch_array(mysql_query("select s.koli from isimanifestout as i, manifestout as m, master_smu as s 
WHERE i.idmanifestout=m.idmanifestout AND i.idmastersmu=s.idmastersmu AND
m.statuscancel='0' AND m.statusvoid='0'  AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
/*$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_GET[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0' AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
*/
				$pdf->SetX(20);
				$pdf->Cell(40,5,format_awb($x[nosmu]),0,0,'L',1);
				$pdf->SetX(45);				
				$pdf->Cell(10,5,$x[koli],0,0,'R',1);
				if($of[0]<=$x[koli])
				{
					$pdf->Cell(8,5,'',0,0,'L',1);}else
					{
						$pdf->Cell(8,5,'/'. $of[0],0,0,'L',1);}
						
				$pdf->Cell(50,5,$x[commodityap],0,0,'L',1);
if($x[commodity]<>'GEN')
				{$pdf->Cell(10,5,$x[commodity],0,0,'C',1);}
				else
				{$pdf->Cell(10,5,'',0,0,'C',1);}
				$pdf->Cell(12,5,$x[berat],0,0,'R',1);
				$pdf->SetX(140);				
				$pdf->Cell(10,5,$x[origin_code],0,0,'C',1);
				$pdf->Cell(10,5,$x[dest_code],0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln();
				$jbr+=$x[berat];
				$jkl+=$x[koli];
				}				
				$totberat+=$jbr;$totkoli+=$jkl;
				$beratuld=mysql_fetch_array(mysql_query("
					select berat as beratuld from beratuld where uld='$no_uld' AND idmanifestout='$_GET[idm]'"));
			 
				$pdf->Cell(35,1,'',0,0,'L',1);
				$pdf->Cell(10,1,'---------',0,0,'L',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(20,1,'---------',0,0,'R',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Ln();				 	
				//$grossweight=$jbr+ $beratuld[beratuld];	
				$grossweight=$jbr;//ndk jadi pake gross, pake nett ajah
				$pdf->SetX(20);
				$pdf->Cell(40,5,'',0,0,'L',1);
				$pdf->SetX(45);				
				$pdf->Cell(10,5,$jkl,0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,$grossweight,0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln(5);
				//$totberat+=$beratuld[beratuld];
				//$totkoli+=$y[jum];
				//}							

			$no+=1;
			

			}
//BULK			

$jmlbulk=mysql_num_rows(mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	 AND m.idmanifestout='$_GET[idm]' AND i.nould like '%bulk%' AND d.dest_code='$p[dest_code]'"));
if($jmlbulk>0){
						$no_uld=$r[nould];
					$pdf->SetFont('Arial','',10);
					$pdf->Ln();
					$pdf->Cell(40,8,'BULK',0,0,'L',1);		
					$pdf->Ln();
$jbr=0;$jkl=0;
$smu=mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	 AND m.idmanifestout='$_GET[idm]' AND i.nould like '%bulk%' AND d.dest_code='$p[dest_code]'"); 
			while ($x=mysql_fetch_array($smu))
				{
/*
					$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_GET[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0' AND m.statusconfirm='1' AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
*/
$of=mysql_fetch_array(mysql_query("select s.koli from isimanifestout as i, manifestout as m, master_smu as s 
WHERE i.idmanifestout=m.idmanifestout AND i.idmastersmu=s.idmastersmu AND
m.statuscancel='0' AND m.statusvoid='0'  AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
/*
$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_GET[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0' AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
*/
				$pdf->SetX(20);
				$pdf->Cell(40,5,format_awb($x[nosmu]),0,0,'L',1);
				$pdf->SetX(45);				
				$pdf->Cell(10,5,$x[koli],0,0,'R',1);
				if($of[0]<=$x[koli])
				{
					$pdf->Cell(8,5,'',0,0,'L',1);}else
					{
						$pdf->Cell(8,5,'/'. $of[0],0,0,'L',1);}
						
				$pdf->Cell(50,5,$x[commodityap],0,0,'L',1);
if($x[commodity]<>'GEN')
				{$pdf->Cell(10,5,$x[commodity],0,0,'C',1);}
				else
				{$pdf->Cell(10,5,'',0,0,'C',1);}

				$pdf->Cell(12,5,$x[berat],0,0,'R',1);
				$pdf->SetX(140);				
				$pdf->Cell(10,5,$x[origin_code],0,0,'C',1);
				$pdf->Cell(10,5,$x[dest_code],0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln();
				$jbr+=$x[berat];
				$jkl+=$x[koli];
				}				
				$totberat+=$jbr;$totkoli+=$jkl;
				$beratuld=mysql_fetch_array(mysql_query("
					select sum(berat) as beratuld from beratuld where uld like '%bulk%' AND idmanifestout='$_GET[idm]'"));
			 
				$pdf->Cell(35,1,'',0,0,'L',1);
				$pdf->Cell(10,1,'---------',0,0,'L',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(20,1,'---------',0,0,'R',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Ln();				 	
				//$grossweight=$jbr+ $beratuld[beratuld];	
				$grossweight=$jbr;//ndk jadi pake gross, pake nett ajah
				$pdf->SetX(20);
				$pdf->Cell(40,5,'',0,0,'L',1);
				$pdf->SetX(45);				
				$pdf->Cell(10,5,$jkl,0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,$grossweight,0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln(5);
				//$totberat+=$beratuld[beratuld];
				//$totkoli+=$y[jum];
				//}							

			$no+=1;
			}

			
			
			
 
$pdf->Ln(10);
				$pdf->SetX(20);
				$pdf->Cell(40,5,'TOTAL',0,0,'L',1);
				$pdf->SetX(45);				
				$pdf->Cell(10,5,$totkoli,0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,$totberat,0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln();		
		$pdf->Ln(10);
		
	$pdf->Cell(40,8,'PREPARED BY : ',0,0,'C',1);
//2. print yang tdk sama dgn destination 
//utk destinasi 1
$no=1;
$totberat=0;$totkoli=0;$grossweight=0;
$tampil=mysql_query("SELECT m.idmanifestout,m.acregister,m.flightdate,m.pointofloading,m.pointul,m.statusnil,m.iddestination,
f.flight,o.origin_code, d.dest_code,m.statusconfirm,m.statuscancel,c.bendera,c.cus_desc
FROM manifestout as m,origin as o,destination as d,flight as f, customer as c
WHERE m.idorigin=o.idorigin AND m.iddestination=d.iddestination AND m.idflight=f.idflight AND m.statusvoid='0' AND f.idcustomer=c.idcustomer AND m.idmanifestout='$_GET[idm]'"); 
	
$p=mysql_fetch_array($tampil);
    $pdf->AddPage();

 	//bikin halaman baru
			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(50,5,'OWNER/OPERATOR',0,0,'L',1);
			$pdf->Cell(50,5,'A/C REGISTRATION',0,0,'L',1);
			$pdf->Cell(50,5,'FLIGHT NO',0,0,'L',1);
			$pdf->Cell(50,5,'DATE',0,0,'L',1);
			$pdf->Ln();			
			$pdf->Cell(50,5,$p[cus_desc],0,0,'L',1);
			$pdf->Cell(50,5,$p[acregister],0,0,'L',1);
			$pdf->Cell(50,5,$p[flight],0,0,'L',1);
			$pdf->Cell(50,5,ymd2dmy($p[flightdate]),0,0,'L',1);$pdf->Ln();			
			$pdf->Cell(50,5,'',0,0,'L',1);
			$pdf->Cell(50,5,'',0,0,'L',1);
			$pdf->Cell(50,5,'',0,0,'L',1);
			$pdf->Cell(50,5,'WEIGHT IN KG',0,0,'L',1);
			$pdf->Ln(10);			
			$pdf->Cell(100,5,'POINT OF LOADING : '.$p[pointofloading],0,0,'L',1);
			$pdf->Cell(100,5,'POINT OF UNLOADING : '.$p[pointul],0,0,'L',1);
			$pdf->Ln(15);							
			$pdf->Cell(40,5,'AWB NUMBER',0,0,'L',1);
			$pdf->Cell(15,5,'NO',0,0,'L',1);
			$pdf->Cell(50,5,'NATURE OF GOODS',0,0,'L',1);
			$pdf->Cell(5,5,'',0,0,'L',1);
			$pdf->Cell(20,5,'WEIGHT',0,0,'C',1);
			$pdf->Cell(10,5,'EX',0,0,'C',1);
			$pdf->Cell(10,5,'TO',0,0,'C',1);
			$pdf->Cell(50,5,'FOR OFFICIAL',0,0,'L',1);
			$pdf->Ln();					
			$pdf->Cell(40,5,'',0,0,'L',1);
			$pdf->Cell(10,5,'PKG',0,0,'L',1);
			$pdf->Cell(50,5,'',0,0,'L',1);
			$pdf->Cell(10,5,'',0,0,'L',1);
			$pdf->Cell(20,5,'KGS',0,0,'C',1);
			$pdf->Cell(10,5,'',0,0,'L',1);
			$pdf->Cell(10,5,'',0,0,'L',1);
			$pdf->Cell(50,5,'USE ONLY',0,0,'L',1);
		//	$pdf->Ln();					
			
			//siapkan data
			$jbr=0;$jkl=0;
/*
			  $uld=mysql_query("SELECT i.nould FROM isimanifestout as i, 
				manifestout as m,master_smu as s  
				where m.idmanifestout=i.idmanifestout AND i.idmanifestout='$_GET[idm]' AND
				i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND
				m.statusvoid='0' AND s.iddestination<>'$p[iddestination]' AND 
				m.statuscancel='0' AND m.statusconfirm='1' GROUP BY i.nould");
*/

$uld=mysql_query("SELECT i.nould FROM isimanifestout as i, 
				manifestout as m,master_smu as s  
				where m.idmanifestout=i.idmanifestout AND i.idmanifestout='$_GET[idm]' AND
				i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND
				m.statusvoid='0' AND s.iddestination<>'$p[iddestination]' AND 
				m.statuscancel='0' AND  i.nould not like '%bulk%' GROUP BY i.nould");
				while ($r=mysql_fetch_array($uld))
				{
					$no_uld=$r[nould];
					$pdf->SetFont('Arial','',10);
					$pdf->Ln();
					$pdf->Cell(40,8,format_uld($r[nould]),0,0,'L',1);		
					$pdf->Ln();
$jbr=0;$jkl=0;
$smu=mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	 AND m.idmanifestout='$_GET[idm]' AND i.nould='$no_uld' AND d.dest_code<>'$p[dest_code]'"); 
			while ($x=mysql_fetch_array($smu))
				{
/*
					$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_GET[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0' AND m.statusconfirm='1' AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
*/
$of=mysql_fetch_array(mysql_query("select s.koli from isimanifestout as i, manifestout as m, master_smu as s 
WHERE i.idmanifestout=m.idmanifestout AND i.idmastersmu=s.idmastersmu AND
m.statuscancel='0' AND m.statusvoid='0'  AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
/*$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_GET[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0' AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
*/
				$pdf->SetX(20);
				$pdf->Cell(40,5,format_awb($x[nosmu]),0,0,'L',1);
				$pdf->SetX(45);				
				$pdf->Cell(10,5,$x[koli],0,0,'R',1);
				if($of[0]<=$x[koli])
				{
					$pdf->Cell(8,5,'',0,0,'L',1);}else
					{
						$pdf->Cell(8,5,'/'. $of[0],0,0,'L',1);}
						
				$pdf->Cell(50,5,$x[commodityap],0,0,'L',1);
if($x[commodity]<>'GEN')
				{$pdf->Cell(10,5,$x[commodity],0,0,'C',1);}
				else
				{$pdf->Cell(10,5,'',0,0,'C',1);}
				

				$pdf->Cell(12,5,$x[berat],0,0,'R',1);
				$pdf->SetX(140);				
				$pdf->Cell(10,5,$x[origin_code],0,0,'C',1);
				$pdf->Cell(10,5,$x[dest_code],0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln();
				$jbr+=$x[berat];
				$jkl+=$x[koli];
				}				
				$totberat+=$jbr;$totkoli+=$jkl;
				$beratuld=mysql_fetch_array(mysql_query("
					select sum(berat) as beratuld from beratuld where uld like '%bulk%' AND idmanifestout='$_GET[idm]'"));
			 
				$pdf->Cell(35,1,'',0,0,'L',1);
				$pdf->Cell(10,1,'---------',0,0,'L',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(20,1,'---------',0,0,'R',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Ln();				 	
				//$grossweight=$jbr+ $beratuld[beratuld];	
				$grossweight=$jbr;
				$pdf->SetX(20);
				$pdf->Cell(40,5,'',0,0,'L',1);
				$pdf->SetX(45);				
				$pdf->Cell(10,5,$jkl,0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,$grossweight,0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln(5);
				//$totberat+=$beratuld[beratuld];
				//}							

			$no+=1;
			

			}
			

//BULK			

$jmlbulk=mysql_num_rows(mysql_query("SELECT i.nould FROM isimanifestout as i, 
				manifestout as m,master_smu as s  
				where m.idmanifestout=i.idmanifestout AND i.idmanifestout='$_GET[idm]' AND
				i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND
				m.statusvoid='0' AND s.iddestination<>'$p[iddestination]' AND 
				m.statuscancel='0' AND i.nould like '%bulk%' GROUP BY i.nould"));
if($jmlbulk>0){
						$no_uld=$r[nould];
					$pdf->SetFont('Arial','',10);
					$pdf->Ln();
					$pdf->Cell(40,8,'BULK',0,0,'L',1);		
					$pdf->Ln();
$jbr=0;$jkl=0;
$smu=mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	 AND m.idmanifestout='$_GET[idm]' AND i.nould like '%bulk%' AND d.dest_code<>'$p[dest_code]'"); 
			while ($x=mysql_fetch_array($smu))
				{
/*
					$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_GET[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0' AND m.statusconfirm='1' AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
*/
$of=mysql_fetch_array(mysql_query("select s.koli from isimanifestout as i, manifestout as m, master_smu as s 
WHERE i.idmanifestout=m.idmanifestout AND i.idmastersmu=s.idmastersmu AND
m.statuscancel='0' AND m.statusvoid='0'  AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
/*
$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_GET[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0' AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
*/
				$pdf->SetX(20);
				$pdf->Cell(40,5,format_awb($x[nosmu]),0,0,'L',1);
				$pdf->SetX(45);				
				$pdf->Cell(10,5,$x[koli],0,0,'R',1);
				if($of[0]<=$x[koli])
				{
					$pdf->Cell(8,5,'',0,0,'L',1);}else
					{
						$pdf->Cell(8,5,'/'. $of[0],0,0,'L',1);}
						
				$pdf->Cell(50,5,$x[commodityap],0,0,'L',1);
if($x[commodity]<>'GEN')
				{$pdf->Cell(10,5,$x[commodity],0,0,'C',1);}
				else
				{$pdf->Cell(10,5,'',0,0,'C',1);}
				$pdf->Cell(12,5,$x[berat],0,0,'R',1);
				$pdf->SetX(140);				
				$pdf->Cell(10,5,$x[origin_code],0,0,'C',1);
				$pdf->Cell(10,5,$x[dest_code],0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln();
				$jbr+=$x[berat];
				$jkl+=$x[koli];
				}				
				$totberat+=$jbr;$totkoli+=$jkl;
				$beratuld=mysql_fetch_array(mysql_query("
					select sum(berat) as beratuld from beratuld where uld like '%bulk%' AND idmanifestout='$_GET[idm]'"));
			 
				$pdf->Cell(35,1,'',0,0,'L',1);
				$pdf->Cell(10,1,'---------',0,0,'L',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(20,1,'---------',0,0,'R',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Ln();				 	
				//$grossweight=$jbr+ $beratuld[beratuld];	
				$grossweight=$jbr;//ndk jadi pake gross, pake nett ajah
				$pdf->SetX(20);
				$pdf->Cell(40,5,'',0,0,'L',1);
				$pdf->SetX(45);				
				$pdf->Cell(10,5,$jkl,0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,$grossweight,0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln(5);
				//$totberat+=$beratuld[beratuld];
				//$totkoli+=$y[jum];
											

			$no+=1;
			}
			

$pdf->Ln(10);
				$pdf->SetX(20);
				$pdf->Cell(40,5,'TOTAL',0,0,'L',1);
				$pdf->SetX(45);				
				$pdf->Cell(10,5,$totkoli,0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,$totberat,0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln();		
		$pdf->Ln(10);
		
	$pdf->Cell(40,8,'PREPARED BY : ',0,0,'C',1);

//*********
//sama dengan destinasi 2
$no=1;$totberat=0;$totkoli=0;$grossweight=0;
$tampil=mysql_query("SELECT m.idmanifestout,m.iddestination2,m.acregister,m.flightdate,m.pointofloading,m.pointul,m.statusnil,m.iddestination2,
f.flight,o.origin_code, d.dest_code,m.statusconfirm,m.statuscancel,c.bendera,c.cus_desc
FROM manifestout as m,origin as o,destination as d,flight as f, customer as c
WHERE m.idorigin=o.idorigin AND m.iddestination2=d.iddestination AND m.idflight=f.idflight AND m.statusvoid='0' AND f.idcustomer=c.idcustomer AND m.idmanifestout='$_GET[idm]'"); 
	
$p=mysql_fetch_array($tampil);
    $pdf->AddPage();

 	//bikin halaman baru
			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(50,5,'OWNER/OPERATOR',0,0,'L',1);
			$pdf->Cell(50,5,'A/C REGISTRATION',0,0,'L',1);
			$pdf->Cell(50,5,'FLIGHT NO',0,0,'L',1);
			$pdf->Cell(50,5,'DATE',0,0,'L',1);
			$pdf->Ln();			
			$pdf->Cell(50,5,$p[cus_desc],0,0,'L',1);
			$pdf->Cell(50,5,$p[acregister],0,0,'L',1);
			$pdf->Cell(50,5,$p[flight],0,0,'L',1);
			$pdf->Cell(50,5,ymd2dmy($p[flightdate]),0,0,'L',1);$pdf->Ln();			
			$pdf->Cell(50,5,'',0,0,'L',1);
			$pdf->Cell(50,5,'',0,0,'L',1);
			$pdf->Cell(50,5,'',0,0,'L',1);
			$pdf->Cell(50,5,'WEIGHT IN KG',0,0,'L',1);
			$pdf->Ln(10);			
			$pdf->Cell(100,5,'POINT OF LOADING : '.$p[pointofloading],0,0,'L',1);
			$pdf->Cell(100,5,'POINT OF UNLOADING : '.$p[pointul],0,0,'L',1);
			$pdf->Ln(15);							
			$pdf->Cell(40,5,'AWB NUMBER',0,0,'L',1);
			$pdf->Cell(15,5,'NO',0,0,'L',1);
			$pdf->Cell(50,5,'NATURE OF GOODS',0,0,'L',1);
			$pdf->Cell(5,5,'',0,0,'L',1);
			$pdf->Cell(20,5,'WEIGHT',0,0,'C',1);
			$pdf->Cell(10,5,'EX',0,0,'C',1);
			$pdf->Cell(10,5,'TO',0,0,'C',1);
			$pdf->Cell(50,5,'FOR OFFICIAL',0,0,'L',1);
			$pdf->Ln();					
			$pdf->Cell(40,5,'',0,0,'L',1);
			$pdf->Cell(10,5,'PKG',0,0,'L',1);
			$pdf->Cell(50,5,'',0,0,'L',1);
			$pdf->Cell(10,5,'',0,0,'L',1);
			$pdf->Cell(20,5,'KGS',0,0,'C',1);
			$pdf->Cell(10,5,'',0,0,'L',1);
			$pdf->Cell(10,5,'',0,0,'L',1);
			$pdf->Cell(50,5,'USE ONLY',0,0,'L',1);
		//	$pdf->Ln();					
			
			//siapkan data
			$jbr=0;$jkl=0;
/*
			  $uld=mysql_query("SELECT i.nould FROM isimanifestout as i, 
				manifestout as m,master_smu as s  
				where m.idmanifestout=i.idmanifestout AND i.idmanifestout='$_GET[idm]' AND
				i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND
				m.statusvoid='0' AND s.iddestination='$p[iddestination2]' AND 
				m.statuscancel='0' AND m.statusconfirm='1' GROUP BY i.nould");*/
				$uld=mysql_query("SELECT i.nould FROM isimanifestout as i, 
				manifestout as m,master_smu as s  
				where m.idmanifestout=i.idmanifestout AND i.idmanifestout='$_GET[idm]' AND
				i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND
				m.statusvoid='0' AND s.iddestination='$p[iddestination2]' AND 
				m.statuscancel='0' AND i.nould not like '%bulk%' GROUP BY i.nould");
				while ($r=mysql_fetch_array($uld))
				{
					$no_uld=$r[nould];
					$pdf->SetFont('Arial','',8);
					$pdf->Ln();
					$pdf->Cell(40,8,format_uld($r[nould]),0,0,'L',1);		
					$pdf->Ln();
$jbr=0;$jkl=0;
$smu=mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	 AND m.idmanifestout='$_GET[idm]' AND i.nould='$no_uld' AND d.dest_code='$p[dest_code]'"); 
			while ($x=mysql_fetch_array($smu))
				{
/*
					$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_GET[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0' AND m.statusconfirm='1' AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
*/
$of=mysql_fetch_array(mysql_query("select s.koli from isimanifestout as i, manifestout as m, master_smu as s 
WHERE i.idmanifestout=m.idmanifestout AND i.idmastersmu=s.idmastersmu AND
m.statuscancel='0' AND m.statusvoid='0'  AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
/*$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_GET[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0' AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
*/
				$pdf->SetX(20);
				$pdf->Cell(40,5,format_awb($x[nosmu]),0,0,'L',1);
				$pdf->SetX(45);				
				$pdf->Cell(10,5,$x[koli],0,0,'R',1);
				if($of[0]<=$x[koli])
				{
					$pdf->Cell(8,5,'',0,0,'L',1);}else
					{
						$pdf->Cell(8,5,'/'. $of[0],0,0,'L',1);}
						
				$pdf->Cell(50,5,$x[commodityap],0,0,'L',1);
if($x[commodity]<>'GEN')
				{$pdf->Cell(10,5,$x[commodity],0,0,'C',1);}
				else
				{$pdf->Cell(10,5,'',0,0,'C',1);}
				$pdf->Cell(12,5,$x[berat],0,0,'R',1);
				$pdf->SetX(140);				
				$pdf->Cell(10,5,$x[origin_code],0,0,'C',1);
				$pdf->Cell(10,5,$x[dest_code],0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln();
				$jbr+=$x[berat];
				$jkl+=$x[koli];
				}				
				$totberat+=$jbr;$totkoli+=$jkl;
				$beratuld=mysql_fetch_array(mysql_query("
					select berat as beratuld from beratuld where uld='$no_uld' AND idmanifestout='$_GET[idm]'"));
			 
				$pdf->Cell(35,1,'',0,0,'L',1);
				$pdf->Cell(10,1,'---------',0,0,'L',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(20,1,'---------',0,0,'R',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Ln();				 	
				//$grossweight=$jbr+ $beratuld[beratuld];	
				$grossweight=$jbr;//ndk jadi pake gross, pake nett ajah
				$pdf->SetX(20);
				$pdf->Cell(40,5,'',0,0,'L',1);
				$pdf->SetX(45);				
				$pdf->Cell(10,5,$jkl,0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,$grossweight,0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln(5);
				//$totberat+=$beratuld[beratuld];
				//$totkoli+=$y[jum];
				//}							

			$no+=1;
			

			}

//BULK			

$jmlbulk=mysql_num_rows(mysql_query("SELECT i.nould FROM isimanifestout as i, 
				manifestout as m,master_smu as s  
				where m.idmanifestout=i.idmanifestout AND i.idmanifestout='$_GET[idm]' AND
				i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND
				m.statusvoid='0' AND s.iddestination='$p[iddestination2]' AND 
				m.statuscancel='0' AND i.nould like '%bulk%' GROUP BY i.nould"));
if($jmlbulk>0){
						$no_uld=$r[nould];
					$pdf->SetFont('Arial','',8);
					$pdf->Ln();
					$pdf->Cell(40,8,'BULK',0,0,'L',1);		
					$pdf->Ln();
$jbr=0;$jkl=0;
$smu=mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	 AND m.idmanifestout='$_GET[idm]' AND i.nould like '%bulk%' AND d.dest_code='$p[dest_code]'"); 
			while ($x=mysql_fetch_array($smu))
				{
/*
					$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_GET[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0' AND m.statusconfirm='1' AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
*/
/*
$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_GET[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0' AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
*/
				$pdf->SetX(20);
				$pdf->Cell(40,5,format_awb($x[nosmu]),0,0,'L',1);
				$pdf->SetX(45);				
				$pdf->Cell(10,5,$x[koli],0,0,'R',1);
				if($of[0]<=$x[koli])
				{
					$pdf->Cell(8,5,'',0,0,'L',1);}else
					{
						$pdf->Cell(8,5,'/'. $of[0],0,0,'L',1);}
						
				$pdf->Cell(50,5,$x[commodityap],0,0,'L',1);
if($x[commodity]<>'GEN')
				{$pdf->Cell(10,5,$x[commodity],0,0,'C',1);}
				else
				{$pdf->Cell(10,5,'',0,0,'C',1);}
				

				$pdf->Cell(12,5,$x[berat],0,0,'R',1);
				$pdf->SetX(140);				
				$pdf->Cell(10,5,$x[origin_code],0,0,'C',1);
				$pdf->Cell(10,5,$x[dest_code],0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln();
				$jbr+=$x[berat];
				$jkl+=$x[koli];
				}				
				$totberat+=$jbr;$totkoli+=$jkl;
				$beratuld=mysql_fetch_array(mysql_query("
					select sum(berat) as beratuld from beratuld where uld like '%bulk%' AND idmanifestout='$_GET[idm]'"));
			 
				$pdf->Cell(35,1,'',0,0,'L',1);
				$pdf->Cell(10,1,'---------',0,0,'L',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(20,1,'---------',0,0,'R',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Ln();				 	
				//$grossweight=$jbr+ $beratuld[beratuld];	
				$grossweight=$jbr;//ndk jadi pake gross, pake nett ajah
				$pdf->SetX(20);
				$pdf->Cell(40,5,'',0,0,'L',1);
				$pdf->SetX(45);				
				$pdf->Cell(10,5,$jkl,0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,$grossweight,0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln(5);
				//$totberat+=$beratuld[beratuld];
				//$totkoli+=$y[jum];
				//}							

			$no+=1;
			}
 //BULK			

$jmlbulk=mysql_num_rows(mysql_query("SELECT i.nould FROM isimanifestout as i, 
				manifestout as m,master_smu as s  
				where m.idmanifestout=i.idmanifestout AND i.idmanifestout='$_GET[idm]' AND
				i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND
				m.statusvoid='0' AND s.iddestination<>'$p[iddestination]' AND 
				m.statuscancel='0' AND i.nould not like '%bulk%' GROUP BY i.nould"));
if($jmlbulk>0){
						$no_uld=$r[nould];
					$pdf->SetFont('Arial','',8);
					$pdf->Ln();
					$pdf->Cell(40,8,'BULK',0,0,'L',1);		
					$pdf->Ln();
$jbr=0;$jkl=0;
$smu=mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	 AND m.idmanifestout='$_GET[idm]' AND i.nould like '%bulk%' AND d.dest_code<>'$p[dest_code]'"); 
			while ($x=mysql_fetch_array($smu))
				{
/*
					$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_GET[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0' AND m.statusconfirm='1' AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
*/
$of=mysql_fetch_array(mysql_query("select s.koli from isimanifestout as i, manifestout as m, master_smu as s 
WHERE i.idmanifestout=m.idmanifestout AND i.idmastersmu=s.idmastersmu AND
m.statuscancel='0' AND m.statusvoid='0'  AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
/*$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_GET[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0' AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
*/
				$pdf->SetX(20);
				$pdf->Cell(40,5,format_awb($x[nosmu]),0,0,'L',1);
				$pdf->SetX(45);				
				$pdf->Cell(10,5,$x[koli],0,0,'R',1);
				if($of[0]<=$x[koli])
				{
					$pdf->Cell(8,5,'',0,0,'L',1);}else
					{
						$pdf->Cell(8,5,'/'. $of[0],0,0,'L',1);}
						
				$pdf->Cell(50,5,$x[commodityap],0,0,'L',1);
if($x[commodity]<>'GEN')
				{$pdf->Cell(10,5,$x[commodity],0,0,'C',1);}
				else
				{$pdf->Cell(10,5,'',0,0,'C',1);}
				$pdf->Cell(12,5,$x[berat],0,0,'R',1);
				$pdf->SetX(140);				
				$pdf->Cell(10,5,$x[origin_code],0,0,'C',1);
				$pdf->Cell(10,5,$x[dest_code],0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln();
				$jbr+=$x[berat];
				$jkl+=$x[koli];
				}				
				$totberat+=$jbr;$totkoli+=$jkl;
				$beratuld=mysql_fetch_array(mysql_query("
					select sum(berat) as beratuld from beratuld where uld like '%bulk%' AND idmanifestout='$_GET[idm]'"));
			 
				$pdf->Cell(35,1,'',0,0,'L',1);
				$pdf->Cell(10,1,'---------',0,0,'L',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(20,1,'---------',0,0,'R',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Ln();				 	
				//$grossweight=$jbr+ $beratuld[beratuld];	
				$grossweight=$jbr;//ndk jadi pake gross, pake nett ajah
				$pdf->SetX(20);
				$pdf->Cell(40,5,'',0,0,'L',1);
				$pdf->SetX(45);				
				$pdf->Cell(10,5,$jkl,0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,$grossweight,0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln(5);
				//$totberat+=$beratuld[beratuld];
				//$totkoli+=$y[jum];
				//}							

			$no+=1;
			}

				$pdf->Ln(10);
				$pdf->SetX(20);
				$pdf->Cell(40,5,'TOTAL',0,0,'L',1);
				$pdf->SetX(45);				
				$pdf->Cell(10,5,$totkoli,0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,$totberat,0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln();		
		$pdf->Ln(10);
		
	$pdf->Cell(40,8,'PREPARED BY : ',0,0,'C',1);	
	
//utk destinasi 2
$no=1;
$totberat=0;$totkoli=0;$grossweight=0;
$tampil=mysql_query("SELECT m.idmanifestout,m.acregister,m.flightdate,m.pointofloading,m.pointul,m.statusnil,m.iddestination2,
f.flight,o.origin_code, d.dest_code,m.statusconfirm,m.statuscancel,c.bendera,c.cus_desc
FROM manifestout as m,origin as o,destination as d,flight as f, customer as c
WHERE m.idorigin=o.idorigin AND m.iddestination2=d.iddestination AND m.idflight=f.idflight AND m.statusvoid='0' AND f.idcustomer=c.idcustomer AND m.idmanifestout='$_GET[idm]'"); 
	
$p=mysql_fetch_array($tampil);
    $pdf->AddPage();

 	//bikin halaman baru
			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(50,5,'OWNER/OPERATOR',0,0,'L',1);
			$pdf->Cell(50,5,'A/C REGISTRATION',0,0,'L',1);
			$pdf->Cell(50,5,'FLIGHT NO',0,0,'L',1);
			$pdf->Cell(50,5,'DATE',0,0,'L',1);
			$pdf->Ln();			
			$pdf->Cell(50,5,$p[cus_desc],0,0,'L',1);
			$pdf->Cell(50,5,$p[acregister],0,0,'L',1);
			$pdf->Cell(50,5,$p[flight],0,0,'L',1);
			$pdf->Cell(50,5,ymd2dmy($p[flightdate]),0,0,'L',1);$pdf->Ln();			
			$pdf->Cell(50,5,'',0,0,'L',1);
			$pdf->Cell(50,5,'',0,0,'L',1);
			$pdf->Cell(50,5,'',0,0,'L',1);
			$pdf->Cell(50,5,'WEIGHT IN KG',0,0,'L',1);
			$pdf->Ln(10);			
			$pdf->Cell(100,5,'POINT OF LOADING : '.$p[pointofloading],0,0,'L',1);
			$pdf->Cell(100,5,'POINT OF UNLOADING : '.$p[pointul],0,0,'L',1);
			$pdf->Ln(15);							
			$pdf->Cell(40,5,'AWB NUMBER',0,0,'L',1);
			$pdf->Cell(15,5,'NO',0,0,'L',1);
			$pdf->Cell(50,5,'NATURE OF GOODS',0,0,'L',1);
			$pdf->Cell(5,5,'',0,0,'L',1);
			$pdf->Cell(20,5,'WEIGHT',0,0,'C',1);
			$pdf->Cell(10,5,'EX',0,0,'C',1);
			$pdf->Cell(10,5,'TO',0,0,'C',1);
			$pdf->Cell(50,5,'FOR OFFICIAL',0,0,'L',1);
			$pdf->Ln();					
			$pdf->Cell(40,5,'',0,0,'L',1);
			$pdf->Cell(10,5,'PKG',0,0,'L',1);
			$pdf->Cell(50,5,'',0,0,'L',1);
			$pdf->Cell(10,5,'',0,0,'L',1);
			$pdf->Cell(20,5,'KGS',0,0,'C',1);
			$pdf->Cell(10,5,'',0,0,'L',1);
			$pdf->Cell(10,5,'',0,0,'L',1);
			$pdf->Cell(50,5,'USE ONLY',0,0,'L',1);
		//	$pdf->Ln();					
			
			//siapkan data
			$jbr=0;$jkl=0;
/*
			  $uld=mysql_query("SELECT i.nould FROM isimanifestout as i, 
				manifestout as m,master_smu as s  
				where m.idmanifestout=i.idmanifestout AND i.idmanifestout='$_GET[idm]' AND
				i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND
				m.statusvoid='0' AND s.iddestination<>'$p[iddestination2]' AND 
				m.statuscancel='0' AND m.statusconfirm='1' GROUP BY i.nould");
*/

$uld=mysql_query("SELECT i.nould FROM isimanifestout as i, 
				manifestout as m,master_smu as s  
				where m.idmanifestout=i.idmanifestout AND i.idmanifestout='$_GET[idm]' AND
				i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND
				m.statusvoid='0' AND s.iddestination<>'$p[iddestination2]' AND 
				m.statuscancel='0' AND i.nould not like '%bulk%' GROUP BY i.nould");
				while ($r=mysql_fetch_array($uld))
				{
					$no_uld=$r[nould];
					$pdf->SetFont('Arial','',8);
					$pdf->Ln();
					$pdf->Cell(40,8,format_uld($r[nould]),0,0,'L',1);		
					$pdf->Ln();
$jbr=0;$jkl=0;
$smu=mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	 AND m.idmanifestout='$_GET[idm]' AND i.nould='$no_uld' AND d.dest_code<>'$p[dest_code]'"); 
			while ($x=mysql_fetch_array($smu))
				{
/*
					$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_GET[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0' AND m.statusconfirm='1' AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
*/
/*$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_GET[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0' AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
*/
$of=mysql_fetch_array(mysql_query("select s.koli from isimanifestout as i, manifestout as m, master_smu as s 
WHERE i.idmanifestout=m.idmanifestout AND i.idmastersmu=s.idmastersmu AND
m.statuscancel='0' AND m.statusvoid='0'  AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
				$pdf->SetX(20);
				$pdf->Cell(40,5,format_awb($x[nosmu]),0,0,'L',1);
				$pdf->SetX(45);				
				$pdf->Cell(10,5,$x[koli],0,0,'R',1);
				if($of[0]<=$x[koli])
				{
					$pdf->Cell(8,5,'',0,0,'L',1);}else
					{
						$pdf->Cell(8,5,'/'. $of[0],0,0,'L',1);}
						
				$pdf->Cell(50,5,$x[commodityap],0,0,'L',1);
if($x[commodity]<>'GEN')
				{$pdf->Cell(10,5,$x[commodity],0,0,'C',1);}
				else
				{$pdf->Cell(10,5,'',0,0,'C',1);}
				$pdf->Cell(12,5,$x[berat],0,0,'R',1);
				$pdf->SetX(140);				
				$pdf->Cell(10,5,$x[origin_code],0,0,'C',1);
				$pdf->Cell(10,5,$x[dest_code],0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln();
				$jbr+=$x[berat];
				$jkl+=$x[koli];
				}				
				$totberat+=$jbr;$totkoli+=$jkl;
				$beratuld=mysql_fetch_array(mysql_query("
					select berat as beratuld from beratuld where uld='$no_uld' AND idmanifestout='$_GET[idm]'"));
			 
				$pdf->Cell(35,1,'',0,0,'L',1);
				$pdf->Cell(10,1,'---------',0,0,'L',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(20,1,'---------',0,0,'R',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Ln();				 	
				//$grossweight=$jbr+ $beratuld[beratuld];	
				$grossweight=$jbr;
				$pdf->SetX(20);
				$pdf->Cell(40,5,'',0,0,'L',1);
				$pdf->SetX(45);				
				$pdf->Cell(10,5,$jkl,0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,$grossweight,0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln(5);
				//$totberat+=$beratuld[beratuld];
				//}							

			$no+=1;
			

			}
			
			
//BULK			

$jmlbulk=mysql_num_rows(mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	 AND m.idmanifestout='$_GET[idm]' AND i.nould='$no_uld' AND d.dest_code<>'$p[dest_code]'"));
if($jmlbulk>0){
						$no_uld=$r[nould];
					$pdf->SetFont('Arial','',8);
					$pdf->Ln();
					$pdf->Cell(40,8,'BULK',0,0,'L',1);		
					$pdf->Ln();
$jbr=0;$jkl=0;
$smu=mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,
o.origin_code,d.dest_code,p.commodityap,c.commodity
 FROM origin as o,isimanifestout as i,manifestout as m,destination as d,commodity_ap as p, 
master_smu as s, commodity as c 
WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND
s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND p.idcommodity = c.idcommodity
	 AND m.idmanifestout='$_GET[idm]' AND i.nould like '%bulk%' AND d.dest_code<>'$p[dest_code]'"); 
			while ($x=mysql_fetch_array($smu))
				{
/*
					$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_GET[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0' AND m.statusconfirm='1' AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
*/

/*$of=mysql_fetch_array(mysql_query("select sum(i.koli) from isimanifestout as i, manifestout as m
WHERE i.idmanifestout=m.idmanifestout AND m.idmanifestout='$_GET[idm]' AND 
m.statuscancel='0' AND m.statusvoid='0' AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));
*/
$of=mysql_fetch_array(mysql_query("select s.koli from isimanifestout as i, manifestout as m, master_smu as s 
WHERE i.idmanifestout=m.idmanifestout AND i.idmastersmu=s.idmastersmu AND
m.statuscancel='0' AND m.statusvoid='0'  AND i.statusvoid='0' AND i.statuscancel='0' AND i.idmastersmu='$x[idmastersmu]'"));

$pdf->SetX(20);
				$pdf->Cell(40,5,format_awb($x[nosmu]),0,0,'L',1);
				$pdf->SetX(45);				
				$pdf->Cell(10,5,$x[koli],0,0,'R',1);
				if($of[0]<=$x[koli])
				{
					$pdf->Cell(8,5,'',0,0,'L',1);}else
					{
						$pdf->Cell(8,5,'/'. $of[0],0,0,'L',1);}
						
				$pdf->Cell(50,5,$x[commodityap],0,0,'L',1);
if($x[commodity]<>'GEN')
				{$pdf->Cell(10,5,$x[commodity],0,0,'C',1);}
				else
				{$pdf->Cell(10,5,'',0,0,'C',1);}
				
				$pdf->Cell(12,5,$x[berat],0,0,'R',1);
				$pdf->SetX(140);				
				$pdf->Cell(10,5,$x[origin_code],0,0,'C',1);
				$pdf->Cell(10,5,$x[dest_code],0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln();
				$jbr+=$x[berat];
				$jkl+=$x[koli];
				}				
				$totberat+=$jbr;$totkoli+=$jkl;
				$beratuld=mysql_fetch_array(mysql_query("
					select sum(berat) as beratuld from beratuld where uld like '%bulk%' AND idmanifestout='$_GET[idm]'"));
			 
				$pdf->Cell(35,1,'',0,0,'L',1);
				$pdf->Cell(10,1,'---------',0,0,'L',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(20,1,'---------',0,0,'R',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Ln();				 	
				//$grossweight=$jbr+ $beratuld[beratuld];	
				$grossweight=$jbr;//ndk jadi pake gross, pake nett ajah
				$pdf->SetX(20);
				$pdf->Cell(40,5,'',0,0,'L',1);
				$pdf->SetX(45);				
				$pdf->Cell(10,5,$jkl,0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,$grossweight,0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln(5);
				//$totberat+=$beratuld[beratuld];
				//$totkoli+=$y[jum];
				//}							

			$no+=1;
			}			
 	$pdf->Ln(10);
				$pdf->SetX(20);
				$pdf->Cell(40,5,'TOTAL',0,0,'L',1);
				$pdf->SetX(45);				
				$pdf->Cell(10,5,$totkoli,0,0,'R',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,$totberat,0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln();		
		$pdf->Ln(10);
		
	$pdf->Cell(40,8,'PREPARED BY : ',0,0,'C',1);

//***********

}
}//end of else nil
$pdf->Output();
	
}
//-------------- enf of cetak manifest export


//----------------------- Cetak Stockopname Export ------------------------------
if ($module=='cetakstockopnameout')
{
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
			$this->Cell(0,10,'GAPURA BALI WMS INTER - Page '.$this->PageNo().'/{nb}',0,0,'C');
		}
		
	}
	

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
AND o.origin_code='DPS' order by d.dest_code ASC");
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
AND o.origin_code<>'DPS' order by d.dest_code ASC");
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
	$pdf->Cell(40,8,'CHECKED : ',0,0,'C',1);			
	$pdf->Output();
	
}
//-------------------End of Mencetak Stockopanem Export -------------------------------
//----------------------- Cetak Handover Export ------------------------------
if ($module=='cetakhandoverexport')
{
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

$nama=mysql_fetch_array(mysql_query("SELECT nama_lengkap, code, nipp from user 
where id_user= '$_SESSION[namauser]'"));

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
$pdf->Cell(120,5,$nama[nama_lengkap].'/DPSKFXH',0,0,'L',1);
$pdf->Cell(70,5,'',0,0,'L',1);$pdf->Ln(5);
$pdf->Cell(120,1,'----------------------------',0,0,'L',1);
$pdf->Cell(70,1,'----------------------------',0,0,'L',1);$pdf->Ln();
$pdf->Cell(120,5,'ID NBR. '.$nama[nipp],0,0,'L',1);
$pdf->Cell(70,5,'ID NBR',0,0,'L',1);$pdf->Ln();
	
	$pdf->Output();
	
}
//-------------------End of Mencetak  Cetak Handover Export  -------------------------------
//----------------------- Cetak Delivery Cargo dan Post ------------------------------
if ($module=='cetakdeliverycargo')
{
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

$nama=mysql_fetch_array(mysql_query("SELECT nama_lengkap, code, nipp from user 
where id_user= '$_SESSION[namauser]'"));

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
	$pdf->Cell(20,5,'',0,0,'L',1);$pdf->Cell(40,5,': DPSKFXH',0,0,'L',1);	
	$pdf->Cell(10,5,'',0,0,'L',1);$pdf->Cell(40,5,': DPSKRXH',0,0,'L',1);$pdf->Ln();
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
$pdf->Cell(120,5,$nama[nama_lengkap].'/DPSKFXH',0,0,'L',1);$pdf->Ln(6);
$pdf->Cell(100,5,'            '.$nama[nipp],0,0,'L',1);
	
	$pdf->Output();
	
}
//-------------------End of Mencetak  Cetak Delivery Cargo  -------------------------------
//---------------Menghapus Data AWB di Manifest Export -------------------------------------------------
if ($module=='isimanifestexport' AND $act=='hapus')
{
  mysql_query("DELETE FROM isimanifestout WHERE idisimanifestout  = '$_GET[idi]'");
  header('location:media.php?module='.$module.'&idm='.$_GET[idm].
  '&r='.$_GET[r].'&f='.$_GET[f].'&d='.$_GET[d].'&idi='.$r[i.idisimanifestout] );
}
//---------------End of Menghapus Data AWB di Manifest Export -------------------------------------------------
//------------------------------- start of isi manifest export----------------------------
if ($module=='isimanifestexport' AND $act=='tambah')
{
 $ceksmu=mysql_num_rows(mysql_query("select m.nosmu from master_smu as m where m.nosmu='$_POST[requiredawb]'"));
 if($ceksmu<=0)
 {
  $e=1;
  header('location:media.php?act=tambah_isimanifestexport&idm='.$_POST[idm].'&r='.$_POST[r].'&f='.$_POST[f].'&d='.$_POST[d].'&e='.$e);	
 }
 else
 {
 
	if($_POST[tombolcek])
	{
		$str=mysql_query("select m.idmastersmu,m.nosmu,m.berat,m.koli from master_smu as m where m.nosmu='$_POST[requiredawb]'");
		$ada=mysql_num_rows($str);
		$ids=mysql_fetch_array($str);
		header('location:media.php?act=tambah_isimanifestexport&idm='.$_POST[idm].'&r='.$_POST[r].'&f='.$_POST[f].'&d='.$_POST[d].'
		&av='.$ada.'&awb='.$_POST[requiredawb].'&ids='.$ids[idmastersmu]);	
	}
	elseif($_POST[tombolkirim])
	{
		if(($_POST[kg]>$_POST[brt]) OR ($_POST[koli]>$_POST[koli]))
		{
			  $e=2;
			  
  header('location:media.php?act=tambah_isimanifestexport&idm='.$_POST[idm].'&r='.$_POST[r].'&f='.$_POST[f].'&d='.$_POST[d].'&e='.$e.'$olduld='.$_POST[uld]);	
		}
		else
		{
		if(($_POST[kg]!='0') AND ($_POST[koli]!='0') AND ($_POST[uld]!=''))
		{
			mysql_query("INSERT INTO isimanifestout (idmanifestout ,idmastersmu ,nould ,
			berat ,koli ,statuscancel ,statusvoid ,keterangan) 
			VALUES ('$_POST[idm]', '$_POST[ids]', '$_POST[uld]', '$_POST[kg]', '$_POST[koli]', '0', '0', '0')");
			mysql_query("INSERT INTO beratuld   (uld,berat,idmanifestout) VALUES('$_POST[uld]','0','$_POST[idm]')");
		}
		  header('location:media.php?act=tambah_isimanifestexport&idm='.$_POST[idm].'&r='.$_POST[r].'&f='.$_POST[f].'&d='.$_POST[d].'&e='.$e.'&olduld='.$_POST[uld]);
		//header('location:media.php?module=isimanifestexport&idm='.$_POST[idm].'&r='.$_POST[r].'&f='.$_POST[f].'&d='.$_POST[d].'&olduld='.$_POST[uld]);	
		}
	}
 }
	
}
//--------------------------- end of input manifest export -----------------------------------------
//---------------Menambah Data Manifest Export---------------------------------------------------------
if ($module=='manifestexport' AND $act=='tambah')
{
$a=my2date($_POST[tglawal]);
  mysql_query("INSERT INTO manifestout (idflight ,idorigin ,iddestination ,iddestination2,acregister ,
  flightdate ,etd,pointofloading ,pointul ,username ,statusnil ,statusconfirm ,statuscancel ,statusvoid ,keterangan)
  VALUES ('$_POST[flight]', '$_POST[origin]', '$_POST[destination]','$_POST[destination2]', '$_POST[requiredacregister]',
  '$a','$_POST[etd]','$_POST[requiredpointofloading]', '$_POST[requiredpointul]', '$_SESSION[namauser]', '$_POST[statusnil]', '0','0', '0', '')");
if($_POST[statusnil]=='on')
{
	header('location:media.php?module=carimanifestexport&d='.$a);
}
else
{
$lst=mysql_fetch_array(mysql_query("select idmanifestout from manifestout order by idmanifestout DESC limit 1"));  
	$dt=mysql_fetch_array(mysql_query("SELECT m.idmanifestout,m.acregister,
	f.flight,m.flightdate FROM manifestout as m,flight as f, customer as c
	WHERE m.idflight=f.idflight  AND f.idcustomer=c.idcustomer AND m.idmanifestout=$lst[idmanifestout]")); 
 header('location:media.php?module=isimanifestexport&idm='.$dt[idmanifestout].'&r='.$dt[acregister].'&f='.$dt[flight].'&d='.ymd2dmy($dt[flightdate]));
} 
} 
//---------------End of Menambah Data Manifest Export --------------------------------------------------

//---------------Mengedit Data Manifest Export---------------------------------------------------------
if ($module=='manifestexport' AND $act=='edit')
{
$a=my2date($_POST[tglawal]);
  mysql_query("UPDATE manifestout set idflight='$_POST[flight]' ,idorigin='$_POST[origin]' ,iddestination='$_POST[destination]' ,iddestination2='$_POST[destination2]' ,acregister='$_POST[requiredacregister]' , flightdate = '$a',pointofloading='$_POST[requiredpointofloading]' ,pointul= '$_POST[requiredpointul]' ,username='$_SESSION[namauser]' ,statusnil='$_POST[statusnil]',etd='$_POST[etd]' WHERE idmanifestout='$_POST[idm]'");
if($_POST[statusnil]=='on')
{
	header('location:media.php?module=carimanifestexport&d='.$a);
}
else
{
$lst=mysql_fetch_array(mysql_query("select idmanifestout from manifestout order by idmanifestout DESC limit 1"));  
	$dt=mysql_fetch_array(mysql_query("SELECT m.idmanifestout,m.acregister,
	f.flight,m.flightdate FROM manifestout as m,flight as f, customer as c
	WHERE m.idflight=f.idflight  AND f.idcustomer=c.idcustomer AND m.idmanifestout=$lst[idmanifestout]")); 
 header('location:media.php?module=isimanifestexport&idm='.$dt[idmanifestout].'&r='.$dt[acregister].'&f='.$dt[flight].'&d='.ymd2dmy($dt[flightdate]));
} 
} 
//---------------End of Mengedit Data Manifest Export --------------------------------------------------

//*********************************END OF EXPORT *******************************************


//******************************START OF BTB ********************************************
//---------------Menambah Data AWB Today---------------------------------------------------------
if ($module=='awbtoday' AND $act=='tambah')
{
	$tgl=my2date($_POST[tglawal]);
  mysql_query("INSERT INTO master_smu (nosmu ,idcommodityap ,idorigin ,iddestination ,berat ,koli ,
  isvoid,status_transit ,user ,tglsmu ,shipper ,consignee ,idagent) VALUES ('$_POST[requiredawb]' ,'$_POST[commodity]','$_POST[origin]', '$_POST[destination]', '$_POST[requiredkg]','$_POST[requiredkoli]', '0', '$_POST[transit]' , '$_SESSION[namauser]', '$tgl' , '$_POST[shipper]', '$_POST[consignee]' , '$_POST[agent]')");
 header('location:media.php?module='.$module);
} 
//---------------End of Menambah Data  AWB--------------------------------------------------
//---------------Menghapus Data AWB-------------------------------------------------
else if ($module=='carismu' AND $act=='hapus')
{
 mysql_query("DELETE FROM master_smu WHERE idmastersmu='$_GET[ids]'");
 header('location:media.php?module=carismu&cari='.$_POST[requiredawb]);
}
//---------------End of Menghapus Data AWB-------------------------------------------------
//---------------MengeditData AWB Today---------------------------------------------------------
if ($module=='awbtoday' AND $act=='edit')
{
  mysql_query("UPDATE master_smu  set 
nosmu='$_POST[requiredawb]' ,idcommodityap='$_POST[commodity]' ,idorigin='$_POST[origin]' ,iddestination ='$_POST[destination]',berat='$_POST[requiredkg]' ,koli='$_POST[requiredkoli]' ,
user='$_SESSION[namauser]' ,tglsmu='$_POST[tglsmu]' ,shipper= '$_POST[shipper]' ,consignee= '$_POST[consignee]' ,idagent='$_POST[agent]' WHERE idmastersmu='$_POST[ids]'"); 
 header('location:media.php?module=carismu&cari='.$_POST[requiredawb]);
} 
//---------------End of Menngedit AWB--------------------------------------------------
//***************************************************************************************

//******************************START OF SUPERVISOR *************************************
//---------------Menghapus Data Agent-------------------------------------------------
if ($module=='dataagent' AND $act=='hapus')
{
  mysql_query("DELETE FROM Agent WHERE idagent  = '$_GET[id]'");
  header('location:media.php?module='.$module);
}
//---------------End of Menghapus Data Agent-------------------------------------------------

//---------------Menambah Data Agent---------------------------------------------------------
if ($module=='dataagent' AND $act=='tambah')
{
  mysql_query("INSERT INTO agent(agent,agentfullname,address,phone,fax,contactperson) 
	                       VALUES('$_POST[requiredcode]','$_POST[requiredagent]',
						   '$_POST[address]','$_POST[phone]',
						   '$_POST[fax]','$_POST[contact]')");
  header('location:media.php?module='.$module);
} 
//---------------End of Menambah Data Agent--------------------------------------------------

//---------------Edit Data Agent---------------------------------------------------------
if ($module=='dataagent' AND $act=='edit')
{
 mysql_query("UPDATE agent SET agent = '$_POST[requiredcode]',
 		agentfullname = '$_POST[requiredagent]',address = '$_POST[address]',
		phone = '$_POST[phone]',fax= '$_POST[fax]',contactperson = '$_POST[contact]'
				WHERE idagent      = '$_POST[id]'");
  header('location:media.php?module='.$module);
} 
//---------------End of Edit Data Agent--------------------------------------------------


//---------------Menghapus Data Region-------------------------------------------------
if ($module=='dataregion' AND $act=='hapus')
{
  mysql_query("DELETE FROM region WHERE idregion  = '$_GET[id]'");
  header('location:media.php?module='.$module);
}
//---------------End of Menghapus Data Region-------------------------------------------------

//---------------Menambah Data Region---------------------------------------------------------
if ($module=='dataregion' AND $act=='tambah')
{
  mysql_query("INSERT INTO region(region, dest_desc) 
	                       VALUES('$_POST[requiredregion]','$_POST[requireddescription]')");
  header('location:media.php?module='.$module);
} 
//---------------End of Menambah Data Region--------------------------------------------------

//---------------Edit Data Region---------------------------------------------------------
if ($module=='dataregion' AND $act=='edit')
{
 mysql_query("UPDATE region SET region = '$_POST[requiredregion]',
 				dest_desc= '$_POST[requireddescription]' 
				WHERE idregion      = '$_POST[id]'");
  header('location:media.php?module='.$module);
} 
//---------------End of Edit Data Region--------------------------------------------------

//---------------Menghapus Data Commocity -------------------------------------------------
if ($module=='datacommodity' AND $act=='hapus')
{
  mysql_query("DELETE FROM commodity WHERE idcommodity  = '$_GET[id]'");
  header('location:media.php?module='.$module);
}
//---------------End of Menghapus Data Commodity -------------------------------------------------

//---------------Menambah Data commodity---------------------------------------------------------
if ($module=='datacommodity' AND $act=='tambah')
{
  mysql_query("INSERT INTO commodity(commodity, com_desc) 
	                       VALUES('$_POST[requiredcommodity]','$_POST[requireddescription]')");
  header('location:media.php?module='.$module);
} 
//---------------End of Menambah Data commodity--------------------------------------------------

//---------------Edit Data commodity---------------------------------------------------------
if ($module=='datacommodity' AND $act=='edit')
{
 mysql_query("UPDATE commodity SET commodity = '$_POST[requiredcommodity]',
 				com_desc= '$_POST[requireddescription]' 
				WHERE idcommodity      = '$_POST[id]'");
  header('location:media.php?module='.$module);
} 
//---------------End of Edit Data commodity--------------------------------------------------
//---------------Menghapus Data Commocity -------------------------------------------------
if ($module=='datacommodity_ap' AND $act=='hapus')
{
  mysql_query("DELETE FROM commodity_ap WHERE idcommodityap  = '$_GET[id]'");
  header('location:media.php?module='.$module);
}
//---------------End of Menghapus Data Commodity -------------------------------------------------

//---------------Menambah Data commodity---------------------------------------------------------
if ($module=='datacommodity_ap' AND $act=='tambah')
{
  mysql_query("INSERT INTO commodity_ap(commodityap,idcommodity) 
	                       VALUES('$_POST[requiredsubcodecommodity]','$_POST[commodity]')");
  header('location:media.php?module='.$module);
} 
//---------------End of Menambah Data commodity--------------------------------------------------

//---------------Edit Data commodity---------------------------------------------------------
if ($module=='datacommodity_ap' AND $act=='edit')
{
mysql_query("UPDATE commodity_ap SET commodityap = '$_POST[requiredsubcodecommodity]',
 				
				idcommodity= '$_POST[commodity]' 
				WHERE idcommodityap      = '$_POST[id]'");
header('location:media.php?module='.$module);
} 
//---------------End of Edit Data commodity--------------------------------------------------

//---------------Menghapus Data customer-------------------------------------------------
if ($module=='datacustomer' AND $act=='hapus')
{
  mysql_query("DELETE FROM customer WHERE idcustomer  = '$_GET[id]'");
  header('location:media.php?module='.$module);
}
//---------------End of Menghapus Data customer-------------------------------------------------

//---------------Menambah Data customer---------------------------------------------------------
if ($module=='datacustomer' AND $act=='tambah')
{
  mysql_query("INSERT INTO customer(customer, cus_desc,bendera) 
	                       VALUES('$_POST[requiredcustomer]','$_POST[requireddescription]','$_POST[requiredbendera]')");
  header('location:media.php?module='.$module);
} 
//---------------End of Menambah Data customer--------------------------------------------------

//---------------Edit Data customer---------------------------------------------------------
if ($module=='datacustomer' AND $act=='edit')
{
 mysql_query("UPDATE customer SET customer = '$_POST[requiredcustomer]',
 				cus_desc= '$_POST[requireddescription]',bendera= '$_POST[requiredbendera]' 
				WHERE idcustomer      = '$_POST[id]'");
  header('location:media.php?module='.$module);
} 
//---------------End of Edit Data customer--------------------------------------------------
//---------------Menghapus Data Flight  -------------------------------------------------
if ($module=='dataflightno' AND $act=='hapus')
{
  mysql_query("DELETE FROM flight WHERE idflight  = '$_GET[id]'");
  header('location:media.php?module='.$module);
}
//---------------End of Menghapus Data flight -------------------------------------------------

//---------------Menambah Data flight---------------------------------------------------------
if ($module=='dataflightno' AND $act=='tambah')
{
  mysql_query("INSERT INTO flight(flight, idcustomer) 
	                       VALUES('$_POST[requiredflight]','$_POST[customer]')");
  header('location:media.php?module='.$module);
} 
//---------------End of Menambah Data flight--------------------------------------------------

//---------------Edit Data flight---------------------------------------------------------
if ($module=='dataflightno' AND $act=='edit')
{
 mysql_query("UPDATE flight SET flight = '$_POST[requiredflight]',
 				idcustomer= '$_POST[customer]' 
				WHERE idflight      = '$_POST[id]'");
  header('location:media.php?module='.$module);
} 
//---------------End of Edit Data flight--------------------------------------------------

//---------------VOID Data Manifest Export  -------------------------------------------------
if ($module=='carimanifestexport' AND $act=='void')
{
  mysql_query("UPDATE manifestout set statusvoid='1' WHERE idmanifestout  = '$_GET[idm]'");
  mysql_query("UPDATE isimanifestout set statusvoid='1' WHERE idmanifestout  = '$_GET[idm]'"); 
 header('location:media.php?module='.$module);
}
//---------------End of VOID Data Manifest Export -------------------------------------------------

//---------------RELEASE Data Manifest Export  -------------------------------------------------
if ($module=='carimanifestexport' AND $act=='release')
{
  mysql_query("UPDATE manifestout set statusconfirm='0' WHERE idmanifestout  = '$_GET[idm]'");
  header('location:media.php?module='.$module);
}
//---------------End of VOID Data Manifest Export -------------------------------------------------


//---------------Menghapus Data destination  -------------------------------------------------
if ($module=='datadestinasi' AND $act=='hapus')
{
  mysql_query("DELETE FROM destination WHERE iddestination  = '$_GET[id]'");
  header('location:media.php?module='.$module);
}
//---------------End of Menghapus Data destination -------------------------------------------------

//---------------Menambah Data destination---------------------------------------------------------
if ($module=='datadestinasi' AND $act=='tambah')
{
  mysql_query("INSERT INTO destination(dest_code, idregion) 
	                       VALUES('$_POST[requiredcode]','$_POST[region]')");
  header('location:media.php?module='.$module);
} 
//---------------End of Menambah Data destination--------------------------------------------------

//---------------Edit Data destination---------------------------------------------------------
if ($module=='datadestinasi' AND $act=='edit')
{
 mysql_query("UPDATE destination SET dest_code = '$_POST[requiredcode]',
 				idregion= '$_POST[region]' 
				WHERE iddestination      = '$_POST[id]'");
  header('location:media.php?module='.$module);
} 
//---------------End of Edit Data destination--------------------------------------------------


//******************************END OF SUPERVISOR *************************************
/*
//******************************START OF EXPORT *************************************
//---------------Menghapus Data AWB Internasional  -------------------------------------------------
/*
TIDAK BOLEH TERHAPUS !!!
if ($module=='datasmuinter' AND $act=='hapus')
{
  mysql_query("DELETE FROM flight WHERE idflight  = '$_GET[id]'");
  header('location:media.php?module='.$module);
}

//---------------End of Menghapus Data AWB Internasional -------------------------------------------------

//---------------Menambah Data AWB Internasional---------------------------------------------------------
if ($module=='datasmuinter' AND $act=='tambah')
{
INSERT INTO wms_inter.mastersmu (nosmu, idcommodityap, idorigin, iddestination, berat, koli, 
						isvoid, status_transit, user, tglsmu, shipper, consignee, idagent) 
						VALUES ('$_POST[requiredawb]','$_POST[commodity]',
						'$_POST[origin]','$_POST[destination]', NULL, NULL, NULL, NULL, '0.0', NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL);
  mysql_query("INSERT INTO flight(flight, cust_code) 
	                       VALUES('$_POST[requiredflight]','$_POST[requiredcustomer]')");
  header('location:media.php?module='.$module);
} 
//---------------End of Menambah Data AWB Internasional--------------------------------------------------

//---------------Edit Data AWB Internasional---------------------------------------------------------
if ($module=='datasmuinter' AND $act=='edit')
{
 mysql_query("UPDATE flight SET flight = '$_POST[requiredflight]',
 				cust_code= '$_POST[requiredcustomer]' 
				WHERE idflight      = '$_POST[id]'");
  header('location:media.php?module='.$module);
} 
//---------------End of Edit Data AWB Internasional--------------------------------------------------

//---------------Menghapus Data destination  -------------------------------------------------
if ($module=='datadestinasi' AND $act=='hapus')
{
  mysql_query("DELETE FROM destination WHERE iddestination  = '$_GET[id]'");
  header('location:media.php?module='.$module);
}
//---------------End of Menghapus Data destination -------------------------------------------------

//---------------Menambah Data destination---------------------------------------------------------
if ($module=='datadestinasi' AND $act=='tambah')
{
  mysql_query("INSERT INTO destination(dest_code, region) 
	                       VALUES('$_POST[requiredcode]','$_POST[requiredregion]')");
  header('location:media.php?module='.$module);
} 
//---------------End of Menambah Data destination--------------------------------------------------

//---------------Edit Data destination---------------------------------------------------------
if ($module=='datadestinasi' AND $act=='edit')
{
 mysql_query("UPDATE destination SET dest_code = '$_POST[requiredcode]',
 				region= '$_POST[requiredregion]' 
				WHERE iddestination      = '$_POST[id]'");
  header('location:media.php?module='.$module);
} 
//---------------End of Edit Data destination--------------------------------------------------

//******************************END OF EXPORT *************************************
*/



/*
// Menghapus data
if (isset($module) AND $act=='hapus'){
  mysql_query("DELETE FROM ".$module." WHERE id_".$module."='$_GET[id]'");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
}
*/

// Input user
if ($module=='user' AND $act=='input')
{
  if ((!empty($_POST[id_user])) AND (!empty($_POST[nama_lengkap])))
  {
	$pass=md5($_POST[password]);
	mysql_query("INSERT INTO user(id_user,password,nama_lengkap,nipp,telpon,level) 
							VALUES('$_POST[id_user]','$pass','$_POST[nama_lengkap]','$_POST[nipp]',
									'$_POST[no_telpon]','$_POST[level]')");
  }
  header('location:media.php?module='.$module);
}  


//update user by admin
elseif ($module=='user' AND $act=='update'){
  // Apabila password tidak diubah
 if (empty($_POST[password])) {
    mysql_query("UPDATE user SET 
			nama_lengkap = '$_POST[nama_lengkap]',
			nipp = '$_POST[nipp]',
			telpon    = '$_POST[no_telpon]',
level='$_POST[level]'
			WHERE id_user = '$_POST[id]'");
  }
  // Apabila password diubah
  else{
    $pass=md5($_POST[password]);
   mysql_query("UPDATE user SET 
			nama_lengkap = '$_POST[nama_lengkap]',
			nipp = '$_POST[nipp]',
			password='$pass',
			telpon    = '$_POST[no_telpon]',level='$_POST[level]'
			WHERE id_user = '$_POST[id]'");
  }
  header('location:media.php?module=home');
}

// Hapus user
elseif ($module=='user' AND $act=='hapus')
{
  mysql_query("DELETE FROM ".$module." WHERE id_".$module."='$_GET[id]' AND logon='0'");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
}


// Update user
elseif ($act=='user_update'){
  // Apabila password tidak diubah
 if (empty($_POST[password])) {
    mysql_query("UPDATE user SET 
			nama_lengkap = '$_POST[nama_lengkap]',
			nipp = '$_POST[nipp]',
			telpon    = '$_POST[no_telpon]',
			code='$_POST[code]'
			WHERE id_user = '$_SESSION[namauser]'");
  }
  // Apabila password diubah
  else{
    $pass=md5($_POST[password]);
    mysql_query("UPDATE user SET 
			nama_lengkap = '$_POST[nama_lengkap]',
			nipp = '$_POST[nipp]',
			password='$pass',
			telpon    = '$_POST[no_telpon]',
			code='$_POST[code]'
			WHERE id_user = '$_SESSION[namauser]'");
  }
  header('location:media.php?module=home');
}


// Input modul
elseif ($module=='modul' AND $act=='input'){
  mysql_query("INSERT INTO modul(nama_modul,
                                 link,
                                 publish,
                                 aktif,
                                 status,
                                 urutan) 
	                       VALUES('$_POST[nama_modul]',
                                '$_POST[link]',
                                '$_POST[publish]',
                                '$_POST[aktif]',
                                '$_POST[status]',
                                '$_POST[urutan]')");
  header('location:media.php?module='.$module);
}

// Update modul
elseif ($module=='modul' AND $act=='update'){
  mysql_query("UPDATE modul SET nama_modul = '$_POST[nama_modul]',
                                link       = '$_POST[link]',
                                publish    = '$_POST[publish]',
                                aktif      = '$_POST[aktif]',
                                status     = '$_POST[status]',
                                urutan     = '$_POST[urutan]'  
                          WHERE id_modul   = '$_POST[id]'");
  header('location:media.php?module='.$module);
}


// Input agenda
elseif ($module=='agenda' AND $act=='input'){
  $mulai=sprintf("%02d%02d%02d",$_POST[thn_mulai],$_POST[bln_mulai],$_POST[tgl_mulai]);
  $selesai=sprintf("%02d%02d%02d",$_POST[thn_selesai],$_POST[bln_selesai],$_POST[tgl_selesai]);
  
  mysql_query("INSERT INTO agenda(tema,
                                  isi_agenda,
                                  tempat,
                                  tgl_mulai,
                                  tgl_selesai,
                                  tgl_posting,
                                  id_user) 
					                VALUES('$_POST[tema]',
                                 '$_POST[isi_agenda]',
                                 '$_POST[tempat]',
                                 '$mulai',
                                 '$selesai',
                                 '$tgl_sekarang',
                                 '$_SESSION[namauser]')");
  header('location:media.php?module='.$module);
}

// Update agenda
elseif ($module=='agenda' AND $act=='update'){
  $mulai=sprintf("%02d%02d%02d",$_POST[thn_mulai],$_POST[bln_mulai],$_POST[tgl_mulai]);
  $selesai=sprintf("%02d%02d%02d",$_POST[thn_selesai],$_POST[bln_selesai],$_POST[tgl_selesai]);

  mysql_query("UPDATE agenda SET tema        = '$_POST[tema]',
                                 isi_agenda  = '$_POST[isi_agenda]',
                                 tgl_mulai   = '$mulai',
                                 tgl_selesai = '$selesai',
                                 tempat      = '$_POST[tempat]'  
                           WHERE id_agenda   = '$_POST[id]'");
  header('location:media.php?module='.$module);
}


// Input pengumuman
elseif ($module=='pengumuman' AND $act=='input'){
  $tanggal=sprintf("%02d%02d%02d",$_POST[thn],$_POST[bln],$_POST[tgl]);
  
  mysql_query("INSERT INTO pengumuman(judul,
                                      isi,
                                      tanggal,
                                      tgl_posting,
                                      id_user) 
					                   VALUES('$_POST[judul]',
                                    '$_POST[isi_pengumuman]',
                                    '$tanggal',
                                    '$tgl_sekarang',
                                    '$_SESSION[namauser]')");
  header('location:media.php?module='.$module);
}

// Update pengumuman
elseif ($module=='pengumuman' AND $act=='update'){
  $tanggal=sprintf("%02d%02d%02d",$_POST[thn],$_POST[bln],$_POST[tgl]);

  mysql_query("UPDATE pengumuman SET judul         = '$_POST[judul]',
                                     isi           = '$_POST[isi_pengumuman]',
                                     tanggal       = '$tanggal'
                               WHERE id_pengumuman = '$_POST[id]'");
  header('location:media.php?module='.$module);
}


// Input berita
elseif ($module=='berita' AND $act=='input'){
  $lokasi_file = $_FILES['fupload']['tmp_name'];
  $nama_file   = $_FILES['fupload']['name'];

  // Apabila ada gambar yang diupload
  if (!empty($lokasi_file)){
    move_uploaded_file($lokasi_file,"foto_berita/$nama_file");
    mysql_query("INSERT INTO berita(judul,
                                    id_kategori,
                                    isi_berita,
                                    id_user,
                                    jam,
                                    tanggal,
                                    hari,
                                    gambar) 
                            VALUES('$_POST[judul]',
                                   '$_POST[kategori]',
                                   '$_POST[isi_berita]',
                                   '$_SESSION[namauser]',
                                   '$jam_sekarang',
                                   '$tgl_sekarang',
                                   '$hari_ini',
                                   '$nama_file')");
  }
  else{
    mysql_query("INSERT INTO berita(judul,
                                    id_kategori,
                                    isi_berita,
                                    id_user,
                                    jam,
                                    tanggal,
                                    hari) 
                            VALUES('$_POST[judul]',
                                   '$_POST[kategori]',
                                   '$_POST[isi_berita]',
                                   '$_SESSION[namauser]',
                                   '$jam_sekarang',
                                   '$tgl_sekarang',
                                   '$hari_ini')");
  }
  header('location:media.php?module='.$module);
}


// Update berita
elseif ($module=='berita' AND $act=='update'){
  $lokasi_file = $_FILES['fupload']['tmp_name'];
  $nama_file   = $_FILES['fupload']['name'];

  // Apabila gambar tidak diganti
  if (empty($lokasi_file)){
    mysql_query("UPDATE berita SET judul       = '$_POST[judul]',
                                   id_kategori = '$_POST[kategori]',
                                   isi_berita  = '$_POST[isi_berita]'  
                             WHERE id_berita   = '$_POST[id]'");
  }
  else{
    move_uploaded_file($lokasi_file,"foto_berita/$nama_file");
    mysql_query("UPDATE berita SET judul       = '$_POST[judul]',
                                   id_kategori = '$_POST[kategori]',
                                   isi_berita  = '$_POST[isi_berita]',
                                   gambar      = '$nama_file'   
                             WHERE id_berita   = '$_POST[id]'");
  }
  header('location:media.php?module='.$module);
}


// Input banner
elseif ($module=='banner' AND $act=='input'){
  $lokasi_file = $_FILES['fupload']['tmp_name'];
  $nama_file   = $_FILES['fupload']['name'];

  // Apabila ada gambar yang diupload
  if (!empty($lokasi_file)){
    move_uploaded_file($lokasi_file,"foto_berita/$nama_file");
    mysql_query("INSERT INTO banner(judul,
                                    url,
                                    tgl_posting,
                                    gambar) 
                            VALUES('$_POST[judul]',
                                   '$_POST[link]',
                                   '$tgl_sekarang',
                                   '$nama_file')");
  }
  else{
    mysql_query("INSERT INTO banner(judul,
                                    tgl_posting,
                                    url) 
                            VALUES('$_POST[judul]',
                                   '$tgl_sekarang',
                                   '$_POST[link]')");
  }
  header('location:media.php?module='.$module);
}

// Update banner
elseif ($module=='banner' AND $act=='update'){
  $lokasi_file = $_FILES['fupload']['tmp_name'];
  $nama_file   = $_FILES['fupload']['name'];

  // Apabila gambar tidak diganti
  if (empty($lokasi_file)){
    mysql_query("UPDATE banner SET judul     = '$_POST[judul]',
                                   url       = '$_POST[link]'
                             WHERE id_banner = '$_POST[id]'");
  }
  else{
    move_uploaded_file($lokasi_file,"foto_berita/$nama_file");
    mysql_query("UPDATE banner SET judul     = '$_POST[judul]',
                                   url       = '$_POST[link]',
                                   gambar    = '$nama_file'   
                             WHERE id_banner = '$_POST[id]'");
  }
  header('location:media.php?module='.$module);
}

//****************************************************************************************
//OUTBOUND
//****************************************************************************************
// Input carabayar
elseif ($module=='carabayar' AND $act=='input'){
  mysql_query("INSERT INTO carabayar(carabayar)VALUES('$_POST[cara_bayar]')");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
}

// Update carabayar
elseif ($module=='carabayar' AND $act=='update'){
  mysql_query("UPDATE carabayar SET carabayar = '$_POST[cara_bayar]' WHERE id_carabayar = '$_POST[id]'");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
}

// Input jenis ULD
elseif ($module=='jenisuld' AND $act=='input'){
  mysql_query("INSERT INTO jenisuld(jenisuld,kodeuld)VALUES('$_POST[jenisuld]','$_POST[kodeuld]')");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
}

// Update jenis ULD
elseif ($module=='jenisuld' AND $act=='update'){
  mysql_query("UPDATE jenisuld SET jenisuld = '$_POST[jenisuld]',kodeuld='$_POST[kodeuld]' WHERE id_jenisuld = '$_POST[id]'");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
}

// Input Operator Airlines
elseif ($module=='operatorairline' AND $act=='input'){
  mysql_query("INSERT INTO operatorairline(operatorairline,kodeoperator)VALUES('$_POST[operatorairline]','$_POST[kodeoperator]')");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
}

// Update Operator Airlines
elseif ($module=='operatorairline' AND $act=='update'){
  mysql_query("UPDATE operatorairline SET operatorairline = '$_POST[operatorairline]',kodeoperator='$_POST[kodeoperator]' WHERE id_operatorairline = '$_POST[id]'");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
}

// Input jenis barang
elseif ($module=='jenisbarang' AND $act=='input'){
  mysql_query("INSERT INTO jenisbarang(jenisbarang,keterangan)VALUES('$_POST[jenisbarang]','$_POST[keterangan]')");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
}

// Update jenis barang
elseif ($module=='jenisbarang' AND $act=='update'){
  mysql_query("UPDATE jenisbarang SET jenisbarang = '$_POST[jenisbarang]',keterangan='$_POST[keterangan]' WHERE id_jenisbarang = '$_POST[id]'");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
}

// Input komoditi
elseif ($module=='komoditi' AND $act=='input'){
  mysql_query("INSERT INTO komoditi(kodekomoditi,keterangan)VALUES('$_POST[kodekomoditi]','$_POST[keterangan]')");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
}

// Update komoditi
elseif ($module=='komoditi' AND $act=='update'){
  mysql_query("UPDATE komoditi SET kodekomoditi = '$_POST[kodekomoditi]',keterangan='$_POST[keterangan]' WHERE id_komoditi = '$_POST[id]'");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
}

// Input Kota Tujuan
elseif ($module=='kotatujuan' AND $act=='input'){
  mysql_query("INSERT INTO kotatujuan(kode,keterangan,status)VALUES('$_POST[kode]','$_POST[keterangan]','$_POST[status]')");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
}

// Update Kota Tujuan
elseif ($module=='kotatujuan' AND $act=='update'){
  mysql_query("UPDATE kotatujuan SET kode = '$_POST[kode]',keterangan='$_POST[keterangan]',status='$_POST[status]' WHERE id_kotatujuan = '$_POST[id]'");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
}

// Input ULD
elseif ($module=='uld' AND $act=='input'){
  mysql_query("INSERT INTO uld(id_jenisuld,nould)VALUES('$_POST[id_jenisuld]','$_POST[nould]')");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
}

// Update ULD
elseif ($module=='uld' AND $act=='update'){
  mysql_query("UPDATE uld SET id_jenisuld = '$_POST[id_jenisuld]',nould='$_POST[nould]' WHERE id_uld = '$_POST[id]'");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
}

// Input Pelanggan
elseif ($module=='pelanggan' AND $act=='input'){
  if($_POST[noktp]<>'')
  {
  $ceknoktp=mysql_query("select * from pelanggan where noktp='$_POST[noktp]'");
  $ada=mysql_num_rows($ceknoktp);
  	if($ada > 0)
  		{
  		header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
  		}
  	else
  		{  
			mysql_query("INSERT INTO 		pelanggan(nama,alamat,notelpon,noktp,nonpwp,id_carabayar,id_kotatujuan)VALUES('$_POST[nama]','$_POST[alamat]','$_POST[notelpon]','$_POST[noktp]','$_POST[nonpwp]','$_POST[id_carabayar]','$_POST[id_kotatujuan]')");
			header('location:media.php?module='.$module.'&l='.$_SESSION[level]);}
  
  }
  else
	{
   	mysql_query("INSERT INTO pelanggan(nama,alamat,notelpon,noktp,nonpwp,id_carabayar,id_kotatujuan)VALUES('$_POST[nama]','$_POST[alamat]','$_POST[notelpon]','$_POST[noktp]','$_POST[nonpwp]','$_POST[id_carabayar]','$_POST[id_kotatujuan]')");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
 }
}

// Update Pelanggan
elseif ($module=='pelanggan' AND $act=='update'){
 if($_POST[noktp]<>'')
  {
  $ceknoktp=mysql_query("select * from pelanggan where noktp='$_POST[noktp]' AND id_pelanggan<>'$_POST[id]'");
  $ada=mysql_num_rows($ceknoktp);
  	if($ada > 0)
  		{
  		header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
  		}
  	else
  		{  
   	mysql_query("UPDATE pelanggan SET  nama='$_POST[nama]',alamat='$_POST[alamat]',notelpon='$_POST[notelpon]',noktp='$_POST[noktp]',nonpwp='$_POST[nonpwp]',id_carabayar='$_POST[id_carabayar]',id_kotatujuan='$_POST[id_kotatujuan]' WHERE id_pelanggan='$_POST[id]'");
			header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
			}
  
  }
  else
	{
   	mysql_query("UPDATE pelanggan SET  nama='$_POST[nama]',alamat='$_POST[alamat]',notelpon='$_POST[notelpon]',noktp='$_POST[noktp]',nonpwp='$_POST[nonpwp]',id_carabayar='$_POST[id_carabayar]',id_kotatujuan='$_POST[id_kotatujuan]' WHERE id_pelanggan='$_POST[id]'");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
 }
}

// Input SMU --> no belum diset duplikat
elseif ($module=='smu' AND $act=='input'){
$tgl=my2date($_POST[tglbtb]);
  mysql_query("INSERT INTO smu(nobtb,nosmu,idpengirim,idtujuan,idairline,idjenisbarang,idkomoditi,tglbtb,statuskirim,user,statusbayar)VALUES('$_POST[nobtb]','$_POST[nosmu]','$_POST[idpengirim]','$_POST[idpenerima]','$_POST[idairline]','$_POST[idjenisbarang]','$_POST[idkomoditi]','$tgl','0','$_SESSION[namauser]','0')");
 header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
}

// Update SMU
elseif ($module=='smu' AND $act=='update'){
$tgl=my2date($_POST[tglbtb]);
//  mysql_query("UPDATE smu SET nobtb='$_POST[nobtb]',nosmu='$_POST[nosmu]',idpengirim='$_POST[idpengirim]',idtujuan'$_POST[idtujuan]',idairline='$_POST[idairline]',idjenisbarang='$_POST[idjenisbarang]',idkomoditi='$_POST[idkomoditi]',tglbtb='$tgl',status='$_POST[status]' WHERE id_smu = '$_POST[id]'");
  mysql_query("UPDATE smu SET idairline='$_POST[idairline]',idjenisbarang='$_POST[idjenisbarang]',idkomoditi='$_POST[idkomoditi]' WHERE id_smu = '$_POST[id]'");

  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
}

// Input BarangOutbound 
elseif ($module=='barangoutbound' AND $act=='input'){
  mysql_query("INSERT INTO 
  barangoutbound(id_smu,penjelasan,koli,kg)VALUES('$_POST[idsmu]','$_POST[penjelasan]','$_POST[koli]','$_POST[kg]')");
  $t=mysql_query("select sum(kg)AS totalkg, sum(koli) AS totalkoli from barangoutbound where id_smu='$_POST[idsmu]'");
  $tot=mysql_fetch_array($t);
 mysql_query("UPDATE smu SET beratdibayar='$tot[totalkg]',beratkoli='$tot[totalkoli]' where id_smu='$_POST[idsmu]'");
//echo($tot[total]);
header('location:media.php?act='.$module.'&id='.$_POST[idsmu]);
}


//************************START OF KASIR***************************************************
elseif ($module=='voiddb'){
$tgl=date("Y-m-d");
$tgl1=my2date($_POST[tgl]);
if($_POST[s]=='1'){

  mysql_query("UPDATE deliverybill set isvoid='1',tglvoid='$tgl',voidby='$_SESSION[namauser]',
	keterangan='$_POST[keterangan]',document='0',storage='0',lain='0',overtime='0',hari='0',diskon='0'
	 where no_smubtb='$_POST[i]' AND status='1'");
  mysql_query("UPDATE out_dtbarang_h set status_bayar='no' where btb_nobtb='$_POST[i]'");
 header('location:media.php?module=dboutgoing');
  }
  else if($_POST[s]=='0'){
   mysql_query("UPDATE deliverybill set isvoid='1',tglvoid='$tgl',voidby='$_SESSION[namauser]',keterangan='$_POST[keterangan]',
	 keterangan='$_POST[keterangan]',document='0',storage='0',lain='0',overtime='0',hari='0',diskon='0' 
	  where nosmu='$_POST[i]' AND status='0' AND idbreakdown='$_POST[b]'");
  mysql_query("UPDATE breakdown set status_bayar='no' where id_breakdown='$_POST[b]'");
 header('location:media.php?module=dbincoming');
  }

}



elseif ($module=='dailyreport')
{
	class PDF extends FPDF
	{
		function Header(){	
		$this->SetLeftMargin(10);			
		$this->SetFont('Arial','B',14);
		$this->Ln();
		$this->Cell(190,20,'PENDAPATAN SEWA CARGO INTERNATIONAL',0,0,'L');
		$this->Ln();				
		}
		function Footer(){
		//Position at 1.5 cm from bottom
		$this->SetY(-15);
		//Arial italic 8
		$this->SetFont('Arial','I',8);
		//Page number
		$this->Cell(0,10,'GAPURA BALI WMS INTER - Page '.$this->PageNo().'/{nb}',0,0,'C');
		}
	}
//Instanciation of inherited class
$pdf=new PDF('P','mm','legal');
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


$tglawal=my2date($_POST[tglawal]);
$str=mysql_query("SELECT * FROM user WHERE id_user='$_SESSION[namauser]'");
		$p=mysql_fetch_array($str);
		$kasir=$p[nama_lengkap];

if($_POST[pilih]=='CETAK Per Airline Per SMU')
{

//set nama-nama airline yang ada waktu itu
if($_POST[outin]=='0'){
$str_airline=mysql_query("SELECT 
			a.airlinename,a.airlinecode
			FROM 
			airline as a,deliverybill as b,typebarang as c,btb_agent as d,isimanifestin as e,manifestin as f,breakdown as g 
			WHERE 
			g.id_breakdown=b.idbreakdown AND b.id_carabayar like '%$_POST[cara_bayar]%' AND b.status like '%$_POST[outin]%' AND 
			d.btb_agent like '%$_POST[agent]%' AND 
			c.kategori like '%$_POST[komoditi]%' AND b.tglbayar='$tglawal' AND a.airlinecode like '%$_POST[airline]%' AND 
			b.no_smubtb=e.no_smu AND e.agent=d.btb_agent AND e.id_manifestin=f.id_manifestin 
			AND f.airline=a.airlinecode AND e.jenisbarang=c.typebarang GROUP BY a.airlinecode");	
}
else 
{			
$str_airline=mysql_query("SELECT f.airlinename,f.airlinecode 
			FROM deliverybill as b,out_dtbarang_h as e,airline as f 
			WHERE b.nosmu=e.btb_smu AND b.tglbayar='$tglawal' AND b.status like '%$_POST[outin]%' AND b.isvoid='0' 
			AND e.airline=f.airlinecode GROUP By f.airlinecode");
}					

			$pdf->AddPage();
 	//bikin halaman baru
	if($_POST[outin]=='1'){$outin='EXPORT';}else {$outin='IMPORT';}
			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(200,8,$outin.' '.$_POST[cara_bayar],1,0,'L',1);
			$pdf->Ln(10);
			$pdf->SetFont('Arial','BI',8);
			$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal],0,0,'L',1);
			$pdf->Ln();			
			//siapkan data
		
			$g_berat=0;
			$g_sewagudang=0;
			$g_adm=0;
			$g_ppn=0;
			$g_hari=0;
			$g_total=0;
			$g_diskon=0;
			while ($p=mysql_fetch_array($str_airline)){
			$no=1;


			
			$s_berat=0;$s_sewagudang=0;
			$s_adm=0;$s_ppn=0;$s_hari=0;$s_total=0;$s_diskon=0;			
			$pdf->Ln(5);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(170,8,$p[0],0,0,'L',1);
			$pdf->Ln();
			$pdf->SetFont('Arial','',8);			
			$pdf->Cell(10,8,'No',1,0,'C',1);
			$pdf->Cell(35,8,'NO.SMU/AWB',1,0,'C',1);
			$pdf->Cell(20,8,'Berat(Kg)',1,0,'C',1);
			$pdf->Cell(10,8,'Hari',1,0,'C',1);
			$pdf->Cell(20,8,'Sewa Gudang',1,0,'C',1);
			$pdf->Cell(15,8,'Diskon',1,0,'C',1);			
			
			if($_POST[untuk]=='gp')
			{
			$pdf->Cell(15,8,'Adm',1,0,'C',1);
			$pdf->Cell(15,8,'PPn',1,0,'C',1);
			$pdf->Cell(30,8,'Total',1,0,'C',1);			
			$pdf->Cell(25,5,'No. DB',1,0,'C',1);
			$pdf->Ln();
			$pdf->SetFont('Arial','',8);	
			}
			else
			{
			$pdf->Cell(15,8,'PPn',1,0,'C',1);
			$pdf->Cell(30,8,'Total',1,0,'C',1);			
			$pdf->Cell(25,5,'No. DB',1,0,'C',1);
			$pdf->Ln();
			$pdf->SetFont('Arial','',8);	
			}
if($_POST[outin]=='0'){ //INCOMING
$str=mysql_query("SELECT 
			a.airlinename,b.id_carabayar,b.tglbayar,c.kategori,d.btb_agent,b.nosmu, 
			b.document,b.storage,b.lain,b.overtime,b.hari,b.isvoid,b.diskon,g.beratdatang,b.id_deliverybill    
			FROM 
			airline as a,deliverybill as b,typebarang as c,btb_agent as d,isimanifestin as e,manifestin as f,breakdown as g 
			WHERE 
			g.id_breakdown=b.idbreakdown AND b.id_carabayar like '%$_POST[cara_bayar]%' AND b.status like '%$_POST[outin]%' AND 
			d.btb_agent like '%$_POST[agent]%' AND 
			c.kategori like '%$_POST[komoditi]%' AND b.tglbayar='$tglawal' AND a.airlinecode ='$p[1]' AND 
			b.nosmu=e.no_smu AND e.agent=d.btb_agent AND e.id_manifestin=f.id_manifestin 
			AND f.airline=a.airlinecode AND e.jenisbarang=c.typebarang");
			}
			else
			{//OUTGOING
$str=mysql_query("SELECT 
			a.airlinename,b.id_carabayar,b.tglbayar,c.kategori,d.btb_agent,b.nosmu, 
			b.document,b.storage,b.lain,b.overtime,b.hari,b.isvoid,b.diskon,e.btb_totalberatbayar,b.id_deliverybill    
			FROM 
			airline as a,deliverybill as b,typebarang as c,btb_agent as d,out_dtbarang_h as e,out_dtbarang as f 
			WHERE 
			b.id_carabayar like '%$_POST[cara_bayar]%' AND b.status like '%$_POST[outin]%' AND 
			d.btb_agent like '%$_POST[agent]%' AND 
			c.kategori like '%$_POST[komoditi]%' AND b.tglbayar='$tglawal' AND a.airlinecode ='$p[1]' AND 
			b.nosmu=e.btb_smu AND e.btb_agent=d.btb_agent AND e.id=f.id_h 
			AND e.airline=a.airlinecode AND f.dtBarang_type=c.typebarang");			
			}
			while ($r=mysql_fetch_array($str)){
			
if($_POST[outin]=='0'){ //INCOMING			
$brt=$r[13];
if($r[14]<10){$nodb='I000000'.$r[14];}
else if($r[14]>=10 AND $r[14]<100){$nodb='I00000'.$r[14];}
else if($r[14]>=100 AND $r[14]<1000){$nodb='I0000'.$r[14];}
else if($r[14]>=1000 AND $r[14]<10000){$nodb='I000'.$r[14];}
else if($r[14]>=10000 AND $r[14]<100000){$nodb='I00'.$r[14];}
else if($r[14]>=100000 AND $r[14]<1000000){$nodb='I0'.$r[14];}
else if($r[14]>=1000000 AND $r[14]<10000000){$nodb='I'.$r[14];}
}
else{ //OUTGOING
$brt=$r[btb_totalberatbayar];
if($r[id_deliverybill]<10){$nodb='O000000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10 AND $r[id_deliverybill]<100){$nodb='O00000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100 AND $r[id_deliverybill]<1000){$nodb='O0000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000 AND $r[id_deliverybill]<10000){$nodb='O000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10000 AND $r[id_deliverybill]<100000){$nodb='O00'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100000 AND $r[id_deliverybill]<1000000){$nodb='O0'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000000 AND $r[id_deliverybill]<10000000){$nodb='O'.$r[id_deliverybill];}
}
	
$total=$r[9]+$r[6]+$r[8]-$r[12];
	
			$pdf->Cell(10,5,$no,1,0,'R',1);		
			$pdf->Cell(35,5,$r[5],1,0,'C',1);
			$pdf->Cell(20,5,number_format($brt, 1, ',', '.'),1,0,'R',1);
			$pdf->Cell(10,5,$r[10],1,0,'R',1);
			$pdf->Cell(20,5,number_format($r[9], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(15,5,number_format($r[12], 0, '.', '.'),1,0,'R',1);			
			if($_POST[untuk]=='gp')
			{
			$pdf->Cell(15,5,number_format($r[6], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(15,5,number_format($r[8], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,$nodb,1,0,'R',1);				
			$pdf->Ln();
			}
			else
			{
			$pdf->Cell(15,5,number_format($r[8], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,$nodb,1,0,'R',1);				
			$pdf->Ln();
			}
			$s_berat=$s_berat+$brt;
			$s_sewagudang=$s_sewagudang+$r[9];
			$s_adm=$s_adm+$r[6];
			$s_ppn=$s_ppn+$r[8];
			$s_hari=$s_hari+$r[10];
			$s_total=$s_total+$total;
			$s_diskon=$s_diskon+$r[12];


			}
						//subtotal
							$pdf->SetFont('Arial','B',8);			
			$pdf->Ln(1);
			$pdf->Cell(15,5,'',0,0,'R',1);		
			$pdf->Cell(35,5,'SUB TOTAL :',0,0,'C',1);
										$pdf->SetFont('Arial','',8);		
			$pdf->Cell(20,5,$s_berat,1,0,'R',1);
			$pdf->Cell(10,5,$s_hari,1,0,'R',1);
			$pdf->Cell(20,5,number_format($s_sewagudang, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(15,5,number_format($s_diskon, 0, '.', '.'),1,0,'R',1);			
			if($_POST[untuk]=='gp')
			{
			$pdf->Cell(15,5,number_format($s_adm, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(15,5,number_format($s_ppn, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,5,number_format($s_total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,'',1,0,'R',1);				
			$pdf->Ln();			
			}
			else
			{
			$pdf->Cell(15,5,number_format($s_ppn, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,5,number_format($s_total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,'',1,0,'R',1);				
			$pdf->Ln();
			}
			$g_berat=$g_berat+$s_berat;
			$g_sewagudang=$g_sewagudang+$s_sewagudang;
			$g_adm=$g_adm+$s_adm;
			$g_ppn=$g_ppn+$s_ppn;
			$g_hari=$g_hari+$s_hari;;
			$g_total=$g_total+$s_total;
			$g_diskon=$g_diskon+$s_diskon;

			
			}
			
			
			//grandtotal
			$pdf->SetFont('Arial','B',8);				
			$pdf->Ln(8);
			$pdf->Cell(15,5,'',0,0,'R',1);		
			$pdf->Cell(35,5,'TOTAL :',0,0,'C',1);
			$pdf->Cell(20,5,$g_berat,1,0,'R',1);
			$pdf->Cell(10,5,$g_hari,1,0,'R',1);
			$pdf->Cell(20,5,number_format($g_sewagudang, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(15,5,number_format($g_diskon, 0, '.', '.'),1,0,'R',1);			
			if($_POST[untuk]=='gp')
			{
			$pdf->Cell(15,5,number_format($g_adm, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(15,5,number_format($g_ppn, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,5,number_format($g_total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,'',1,0,'R',1);				
			$pdf->Ln();
			}
			else
			{
			$pdf->Cell(15,5,number_format($g_ppn, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,5,number_format($g_total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,'',1,0,'R',1);				
			$pdf->Ln();
			}
			//
			
	$pdf->Output();
}//end of Cetak Per Airline Per SMU!
else if($_POST[pilih]=='CETAK Per Airline Per Komoditi')
{

//set nama-nama airline yang ada waktu itu
$str_airline=mysql_query("SELECT 
			a.airlinename,a.airlinecode
			FROM 
			airline as a,deliverybill as b,typebarang as c,btb_agent as d,isimanifestin as e,manifestin as f,breakdown as g 
			WHERE 
			g.id_breakdown=b.idbreakdown AND b.id_carabayar like '%$_POST[cara_bayar]%' AND b.status like '%$_POST[outin]%' AND 
			d.btb_agent like '%$_POST[agent]%' AND 
			c.kategori like '%$_POST[komoditi]%' AND b.tglbayar='$tglawal' AND a.airlinecode like '%$_POST[airline]%' AND 
			b.no_smubtb=e.no_smu AND e.agent=d.btb_agent AND e.id_manifestin=f.id_manifestin 
			AND f.airline=a.airlinecode AND e.jenisbarang=c.typebarang GROUP BY a.airlinecode");	

	

			$pdf->AddPage();
 	//bikin halaman baru
	if($_POST[outin]=='1'){$outin='EXPORT';}else {$outin='IMPORT';}
			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(200,8,$outin.' '.$_POST[cara_bayar],1,0,'L',1);
			$pdf->Ln(10);
			$pdf->SetFont('Arial','BI',8);
			$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal],0,0,'L',1);
			$pdf->Ln();			
			//siapkan data
		
			$g_berat=0;
			$g_sewagudang=0;
			$g_adm=0;
			$g_ppn=0;
			$g_hari=0;
			$g_total=0;
			$g_diskon=0;
			while ($p=mysql_fetch_array($str_airline)){
			$no=1;


			
			$s_berat=0;$s_sewagudang=0;
			$s_adm=0;$s_ppn=0;$s_hari=0;$s_total=0;$s_diskon=0;			
			$pdf->Ln(5);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(170,8,$p[0],0,0,'L',1);
			$pdf->Ln();
			$pdf->SetFont('Arial','',8);			
			$pdf->Cell(35,5,'KOMODITI',1,0,'C',1);
			$pdf->Cell(20,8,'Berat(Kg)',1,0,'C',1);
			$pdf->Cell(10,8,'Hari',1,0,'C',1);
			$pdf->Cell(20,8,'Sewa Gudang',1,0,'C',1);
			$pdf->Cell(15,8,'Diskon',1,0,'C',1);			
			
			if($_POST[untuk]=='gp')
			{
			$pdf->Cell(15,8,'Adm',1,0,'C',1);
			$pdf->Cell(15,8,'PPn',1,0,'C',1);
			$pdf->Cell(30,8,'Total',1,0,'C',1);			
			$pdf->Cell(25,5,'No. DB',1,0,'C',1);
			$pdf->Ln();
			$pdf->SetFont('Arial','',8);	
			}
			else
			{
			$pdf->Cell(15,8,'PPn',1,0,'C',1);
			$pdf->Cell(30,8,'Total',1,0,'C',1);			
			$pdf->Cell(25,5,'No. DB',1,0,'C',1);
			$pdf->Ln();
			$pdf->SetFont('Arial','',8);	
			}
if($_POST[outin]=='0'){ //INCOMING
$str=mysql_query("SELECT 
			a.airlinename,b.id_carabayar,b.tglbayar,c.kategori,d.btb_agent,b.no_smubtb, 
			SUM(b.document),SUM(b.storage),SUM(b.lain),SUM(b.overtime),b.hari,b.isvoid,SUM(b.diskon),SUM(g.beratdatang),b.id_deliverybill    
			FROM 
			airline as a,deliverybill as b,typebarang as c,btb_agent as d,isimanifestin as e,manifestin as f,breakdown as g 
			WHERE 
			g.id_breakdown=b.idbreakdown AND b.id_carabayar like '%$_POST[cara_bayar]%' AND b.status like '%$_POST[outin]%' AND 
			d.btb_agent like '%$_POST[agent]%' AND 
			c.kategori like '%$_POST[komoditi]%' AND b.tglbayar='$tglawal' AND a.airlinecode ='$p[1]' AND 
			b.no_smubtb=e.no_smu AND e.agent=d.btb_agent AND e.id_manifestin=f.id_manifestin 
			AND f.airline=a.airlinecode AND e.jenisbarang=c.typebarang GROUP BY c.kategori");
			}
			else
			{
			}
			while ($r=mysql_fetch_array($str)){
			
if($_POST[outin]=='0'){ //INCOMING			
$brt=$r[13];
if($r[14]<10){$nodb='I000000'.$r[14];}
else if($r[14]>=10 AND $r[14]<100){$nodb='I00000'.$r[14];}
else if($r[14]>=100 AND $r[14]<1000){$nodb='I0000'.$r[14];}
else if($r[14]>=1000 AND $r[14]<10000){$nodb='I000'.$r[14];}
else if($r[14]>=10000 AND $r[14]<100000){$nodb='I00'.$r[14];}
else if($r[14]>=100000 AND $r[14]<1000000){$nodb='I0'.$r[14];}
else if($r[14]>=1000000 AND $r[14]<10000000){$nodb='I'.$r[14];}
}
else{ //OUTGOING
$brt=$r[btb_totalberatbayar];
if($r[id_deliverybill]<10){$nodb='O000000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10 AND $r[id_deliverybill]<100){$nodb='O00000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100 AND $r[id_deliverybill]<1000){$nodb='O0000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000 AND $r[id_deliverybill]<10000){$nodb='O000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10000 AND $r[id_deliverybill]<100000){$nodb='O00'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100000 AND $r[id_deliverybill]<1000000){$nodb='O0'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000000 AND $r[id_deliverybill]<10000000){$nodb='O'.$r[id_deliverybill];}
}
	
$total=$r[9]+$r[6]+$r[8]-$r[12];
	
			$pdf->Cell(35,5,$r[3],1,0,'C',1);
			$pdf->Cell(20,5,number_format($brt, 1, ',', '.'),1,0,'R',1);
			$pdf->Cell(10,5,$r[10],1,0,'R',1);
			$pdf->Cell(20,5,number_format($r[9], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(15,5,number_format($r[12], 0, '.', '.'),1,0,'R',1);			
			if($_POST[untuk]=='gp')
			{
			$pdf->Cell(15,5,number_format($r[6], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(15,5,number_format($r[8], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,$nodb,1,0,'R',1);				
			$pdf->Ln();
			}
			else
			{
			$pdf->Cell(15,5,number_format($r[8], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,$nodb,1,0,'R',1);				
			$pdf->Ln();
			}
			$s_berat=$s_berat+$brt;
			$s_sewagudang=$s_sewagudang+$r[9];
			$s_adm=$s_adm+$r[6];
			$s_ppn=$s_ppn+$r[8];
			$s_hari=$s_hari+$r[10];
			$s_total=$s_total+$total;
			$s_diskon=$s_diskon+$r[12];

				$no+=1;

			}
						//subtotal
							$pdf->SetFont('Arial','B',8);			
			$pdf->Ln(1);
			$pdf->Cell(35,5,'SUB TOTAL :',0,0,'C',1);
										$pdf->SetFont('Arial','',8);		
			$pdf->Cell(20,5,$s_berat,1,0,'R',1);
			$pdf->Cell(10,5,$s_hari,1,0,'R',1);
			$pdf->Cell(20,5,number_format($s_sewagudang, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(15,5,number_format($s_diskon, 0, '.', '.'),1,0,'R',1);			
			if($_POST[untuk]=='gp')
			{
			$pdf->Cell(15,5,number_format($s_adm, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(15,5,number_format($s_ppn, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,5,number_format($s_total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,'',1,0,'R',1);				
			$pdf->Ln();			
			}
			else
			{
			$pdf->Cell(15,5,number_format($s_ppn, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,5,number_format($s_total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,'',1,0,'R',1);				
			$pdf->Ln();
			}
			$g_berat=$g_berat+$s_berat;
			$g_sewagudang=$g_sewagudang+$s_sewagudang;
			$g_adm=$g_adm+$s_adm;
			$g_ppn=$g_ppn+$s_ppn;
			$g_hari=$g_hari+$s_hari;;
			$g_total=$g_total+$s_total;
			$g_diskon=$g_diskon+$s_diskon;

			
			}
			
			
			//grandtotal
			$pdf->SetFont('Arial','B',8);				
			$pdf->Ln(8);
			$pdf->Cell(35,5,'TOTAL :',0,0,'C',1);
			$pdf->Cell(20,5,$g_berat,1,0,'R',1);
			$pdf->Cell(10,5,$g_hari,1,0,'R',1);
			$pdf->Cell(20,5,number_format($g_sewagudang, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(15,5,number_format($g_diskon, 0, '.', '.'),1,0,'R',1);			
			if($_POST[untuk]=='gp')
			{
			$pdf->Cell(15,5,number_format($g_adm, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(15,5,number_format($g_ppn, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,5,number_format($g_total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,'',1,0,'R',1);				
			$pdf->Ln();
			}
			else
			{
			$pdf->Cell(15,5,number_format($g_ppn, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,5,number_format($g_total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,'',1,0,'R',1);				
			$pdf->Ln();
			}
			//
			
	
	$pdf->Output();
}//end of Cetak Per Airline Per Komoditi!

else if($_POST[pilih]=='CETAK Per Agent Per Komoditi')
{

//set Agent yang ada waktu itu
$str_airline=mysql_query("SELECT 
			d.btb_agent
			FROM 
			deliverybill as b,typebarang as c,btb_agent as d,isimanifestin as e,manifestin as f,breakdown as g 
			WHERE 
			g.id_breakdown=b.idbreakdown AND b.id_carabayar like '%$_POST[cara_bayar]%' AND b.status like '%$_POST[outin]%' AND 
			d.btb_agent like '%$_POST[agent]%' AND 
			c.kategori like '%$_POST[komoditi]%' AND b.tglbayar='$tglawal' AND 
			b.no_smubtb=e.no_smu AND e.agent=d.btb_agent AND e.id_manifestin=f.id_manifestin 
			AND e.jenisbarang=c.typebarang GROUP BY d.btb_agent");	

	

			$pdf->AddPage();
 	//bikin halaman baru
	if($_POST[outin]=='1'){$outin='EXPORT';}else {$outin='IMPORT';}
			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(200,8,$outin.' '.$_POST[cara_bayar],1,0,'L',1);
			$pdf->Ln(10);
			$pdf->SetFont('Arial','BI',8);
			$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal],0,0,'L',1);
			$pdf->Ln();			
			//siapkan data
		
			$g_berat=0;
			$g_sewagudang=0;
			$g_adm=0;
			$g_ppn=0;
			$g_hari=0;
			$g_total=0;
			$g_diskon=0;
			while ($p=mysql_fetch_array($str_airline)){
			$no=1;


			
			$s_berat=0;$s_sewagudang=0;
			$s_adm=0;$s_ppn=0;$s_hari=0;$s_total=0;$s_diskon=0;			
			$pdf->Ln(5);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(170,8,$p[0],0,0,'L',1);
			$pdf->Ln();
			$pdf->SetFont('Arial','',8);			
			$pdf->Cell(35,5,'KOMODITI',1,0,'C',1);
			$pdf->Cell(20,8,'Berat(Kg)',1,0,'C',1);
			$pdf->Cell(10,8,'Hari',1,0,'C',1);
			$pdf->Cell(20,8,'Sewa Gudang',1,0,'C',1);
			$pdf->Cell(15,8,'Diskon',1,0,'C',1);			
			
			if($_POST[untuk]=='gp')
			{
			$pdf->Cell(15,8,'Adm',1,0,'C',1);
			$pdf->Cell(15,8,'PPn',1,0,'C',1);
			$pdf->Cell(30,8,'Total',1,0,'C',1);			
			$pdf->Cell(25,5,'No. DB',1,0,'C',1);
			$pdf->Ln();
			$pdf->SetFont('Arial','',8);	
			}
			else
			{
			$pdf->Cell(15,8,'PPn',1,0,'C',1);
			$pdf->Cell(30,8,'Total',1,0,'C',1);			
			$pdf->Cell(25,5,'No. DB',1,0,'C',1);
			$pdf->Ln();
			$pdf->SetFont('Arial','',8);	
			}
if($_POST[outin]=='0'){ //INCOMING
$str=mysql_query("SELECT 
			f.id_manifestin,b.id_carabayar,b.tglbayar,c.kategori,d.btb_agent,b.no_smubtb, 
			SUM(b.document),SUM(b.storage),SUM(b.lain),SUM(b.overtime),b.hari,b.isvoid,SUM(b.diskon),SUM(g.beratdatang),b.id_deliverybill    
			FROM 
			deliverybill as b,typebarang as c,btb_agent as d,isimanifestin as e,manifestin as f,breakdown as g 
			WHERE 
			g.id_breakdown=b.idbreakdown AND b.id_carabayar like '%$_POST[cara_bayar]%' AND b.status like '%$_POST[outin]%' AND 
			d.btb_agent like '%$_POST[agent]%' AND 
			c.kategori like '%$_POST[komoditi]%' AND b.tglbayar='$tglawal' AND d.btb_agent ='$p[0]' AND 
			b.no_smubtb=e.no_smu AND e.agent=d.btb_agent AND e.id_manifestin=f.id_manifestin 
			AND e.jenisbarang=c.typebarang GROUP BY c.kategori");
			}
			else
			{
			}
			while ($r=mysql_fetch_array($str)){
			
if($_POST[outin]=='0'){ //INCOMING			
$brt=$r[13];
if($r[14]<10){$nodb='I000000'.$r[14];}
else if($r[14]>=10 AND $r[14]<100){$nodb='I00000'.$r[14];}
else if($r[14]>=100 AND $r[14]<1000){$nodb='I0000'.$r[14];}
else if($r[14]>=1000 AND $r[14]<10000){$nodb='I000'.$r[14];}
else if($r[14]>=10000 AND $r[14]<100000){$nodb='I00'.$r[14];}
else if($r[14]>=100000 AND $r[14]<1000000){$nodb='I0'.$r[14];}
else if($r[14]>=1000000 AND $r[14]<10000000){$nodb='I'.$r[14];}
}
else{ //OUTGOING
$brt=$r[btb_totalberatbayar];
if($r[id_deliverybill]<10){$nodb='O000000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10 AND $r[id_deliverybill]<100){$nodb='O00000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100 AND $r[id_deliverybill]<1000){$nodb='O0000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000 AND $r[id_deliverybill]<10000){$nodb='O000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10000 AND $r[id_deliverybill]<100000){$nodb='O00'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100000 AND $r[id_deliverybill]<1000000){$nodb='O0'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000000 AND $r[id_deliverybill]<10000000){$nodb='O'.$r[id_deliverybill];}
}
	
$total=$r[9]+$r[6]+$r[8]-$r[12];
	
			$pdf->Cell(35,5,$r[3],1,0,'C',1);
			$pdf->Cell(20,5,number_format($brt, 1, ',', '.'),1,0,'R',1);
			$pdf->Cell(10,5,$r[10],1,0,'R',1);
			$pdf->Cell(20,5,number_format($r[9], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(15,5,number_format($r[12], 0, '.', '.'),1,0,'R',1);			
			if($_POST[untuk]=='gp')
			{
			$pdf->Cell(15,5,number_format($r[6], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(15,5,number_format($r[8], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,$nodb,1,0,'R',1);				
			$pdf->Ln();
			}
			else
			{
			$pdf->Cell(15,5,number_format($r[8], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,$nodb,1,0,'R',1);				
			$pdf->Ln();
			}
			$s_berat=$s_berat+$brt;
			$s_sewagudang=$s_sewagudang+$r[9];
			$s_adm=$s_adm+$r[6];
			$s_ppn=$s_ppn+$r[8];
			$s_hari=$s_hari+$r[10];
			$s_total=$s_total+$total;
			$s_diskon=$s_diskon+$r[12];


				$no+=1;

			}
						//subtotal
							$pdf->SetFont('Arial','B',8);			
			$pdf->Ln(1);
			$pdf->Cell(35,5,'SUB TOTAL :',0,0,'C',1);
										$pdf->SetFont('Arial','',8);		
			$pdf->Cell(20,5,$s_berat,1,0,'R',1);
			$pdf->Cell(10,5,$s_hari,1,0,'R',1);
			$pdf->Cell(20,5,number_format($s_sewagudang, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(15,5,number_format($s_diskon, 0, '.', '.'),1,0,'R',1);			
			if($_POST[untuk]=='gp')
			{
			$pdf->Cell(15,5,number_format($s_adm, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(15,5,number_format($s_ppn, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,5,number_format($s_total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,'',1,0,'R',1);				
			$pdf->Ln();			
			}
			else
			{
			$pdf->Cell(15,5,number_format($s_ppn, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,5,number_format($s_total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,'',1,0,'R',1);				
			$pdf->Ln();
			}
			$g_berat=$g_berat+$s_berat;
			$g_sewagudang=$g_sewagudang+$s_sewagudang;
			$g_adm=$g_adm+$s_adm;
			$g_ppn=$g_ppn+$s_ppn;
			$g_hari=$g_hari+$s_hari;;
			$g_total=$g_total+$s_total;
			$g_diskon=$g_diskon+$s_diskon;

			
			}
			
			
			//grandtotal
			$pdf->SetFont('Arial','B',8);				
			$pdf->Ln(8);
			$pdf->Cell(35,5,'TOTAL :',0,0,'C',1);
			$pdf->Cell(20,5,$g_berat,1,0,'R',1);
			$pdf->Cell(10,5,$g_hari,1,0,'R',1);
			$pdf->Cell(20,5,number_format($g_sewagudang, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(15,5,number_format($g_diskon, 0, '.', '.'),1,0,'R',1);			
			if($_POST[untuk]=='gp')
			{
			$pdf->Cell(15,5,number_format($g_adm, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(15,5,number_format($g_ppn, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,5,number_format($g_total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,'',1,0,'R',1);				
			$pdf->Ln();
			}
			else
			{
			$pdf->Cell(15,5,number_format($g_ppn, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,5,number_format($g_total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,'',1,0,'R',1);				
			$pdf->Ln();
			}
			//
			
		
	$pdf->Output();
}//end of Cetak Per Agent Per Komoditi!


}	

//===============================begin of kasirlapcetakk
elseif ($module=='kasirlapcetakk')
{
$tglawal=my2date($_POST[tglawal]);
$tglakhir=my2date($_POST[tglakhir]);

$k=mysql_query("SELECT nama_lengkap,nipp FROM user where id_user='$_SESSION[namauser]'");
$ka=mysql_fetch_array($k);
$kasir=$ka[0];$nipp=$ka[1];
/*
//pisahkan dulu table outbarang dan outbarang_h dulu biar cepet
mysql_query("DELETE FROM deliverybill_tmp");
mysql_query("INSERT INTO deliverybill_tmp 
SELECT deliverybill.* FROM deliverybill 
where deliverybill.tglbayar BETWEEN '$tglawal' AND '$tglakhir'");

mysql_query("DELETE FROM out_dtbarang_h_tmp");
mysql_query("INSERT INTO out_dtbarang_h_tmp SELECT out_dtbarang_h.* FROM out_dtbarang_h,deliverybill_tmp where out_dtbarang_h.isvoid='0' AND out_dtbarang_h.btb_nobtb=deliverybill_tmp.no_smubtb");

mysql_query("DELETE FROM out_dtbarang_tmp");
mysql_query("INSERT INTO out_dtbarang_tmp SELECT out_dtbarang.* FROM out_dtbarang,out_dtbarang_h_tmp,deliverybill_tmp where out_dtbarang_h_tmp.btb_nobtb=deliverybill_tmp.no_smubtb AND out_dtbarang_h_tmp.id=out_dtbarang.id_h");

mysql_query("DELETE FROM isimanifestin_tmp");
mysql_query("INSERT INTO isimanifestin_tmp SELECT isimanifestin.* FROM isimanifestin,deliverybill_tmp where isimanifestin.isvoid='0' AND isimanifestin.no_smu=deliverybill_tmp.nosmu");

mysql_query("DELETE FROM breakdown_tmp");
mysql_query("INSERT INTO breakdown_tmp 
SELECT breakdown.* FROM breakdown,deliverybill_tmp
where deliverybill_tmp.idbreakdown=breakdown.id_breakdown
AND breakdown.b_iscancel='0'");


mysql_query("DELETE FROM manifestin_tmp");
mysql_query("INSERT INTO manifestin_tmp
select manifestin.* from deliverybill_tmp,breakdown_tmp,manifestin
where deliverybill_tmp.idbreakdown=breakdown_tmp.id_breakdown
AND breakdown_tmp.id_manifestin=manifestin.id_manifestin
GROUP by id_manifestin");
*/
	class PDF extends FPDF
	{
		//Page header
		function Header()
		{	
		//$this->SetLeftMargin(10);		
			$this->SetFillColor(255,255,255);	
//			$this->SetX(100);
			$this->SetFont('Arial','B',14);
			//$this->Ln();
			$this->Cell(190,20,'LAPORAN PENDAPATAN SEWA CARGO INTERNATIONAL',0,0,'L');
			$this->Ln();			
			$this->SetFont('Times','I',11);
			$this->Cell(190,8,'Tanggal : '.$_POST[tglawal].' s/d '.$_POST[tglakhir],0,0,'L',1);						$this->Ln();
			$this->Cell(50,8,'Tipe Bayar : '.$_POST[cara_bayar],0,0,'L',1);
			$this->Cell(50,8,''.$_POST[bt_preview],0,0,'L',1);
			
			$this->Ln(10);		
				
		}
		
		//Page footer
		function Footer()
		{
			$k=mysql_query("SELECT nama_lengkap,nipp FROM user where id_user='$_SESSION[namauser]'");
			$ka=mysql_fetch_array($k);
			$kasir=$ka[0];$nipp=$ka[1];
			$this->SetY(-80);
			$this->SetFont('Arial','',10);
			$this->Ln(7);
			$this->Cell(60,8,'Diperiksa oleh : ',0,0,'C',1);
			$this->Cell(60,8,'',0,0,'C',1);	
			$this->Cell(60,8,'Dibuat oleh : ',0,0,'C',1);
			$this->Ln(15);
			$this->Cell(60,8,'',0,0,'C',1);				
			$this->Cell(60,8,'',0,0,'C',1);			
			$this->Cell(60,8,$kasir,0,0,'C',1);	
			$this->Ln(10);
		}
	}
	
	//Instanciation of inherited class
	$pdf=new PDF('P','mm','A4');
//	$pdf->SetMargins(5,1,5);	
		$pdf->SetMargins(15,10,5);	
	
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



//cek untuk pebayarannya
if($_POST[cara_bayar]=='CASH')
{$carabayar='CASH';} 
else if($_POST[cara_bayar]=='PERIODICAL') 
{$carabayar='PERIODICAL';}
else if($_POST[cara_bayar]=='SEMUA')
{$carabayar='';}

//cek utk prosesnya
if($_POST[outin]=='EXPORT')
{$outin=1;} 
else if($_POST[outin]=='IMPORT') 
{$outin=0;}
else if($_POST[outin]=='SEMUA')
{$outin=2;}


if($_POST[bt_preview]=='per Tanggal')
{
//proses dulu jika ingin incoming dan outgoing (SEMUA)
if($outin=='2')
{
			$gberat=0;
			$gkoli=0;			
			$gsewagudang=0;
			$gadm=0;
			$gppn=0;
			$gtotal=0;
			

//==================UTK INCOMING DULU
mysql_query("delete from periodtmp"); 
mysql_query("insert into periodtmp 
select a.tglbayar,b.kolidatang,b.beratdatang,a.overtime,a.document,a.lain,a.id_carabayar,c.agent,d.airline,a.isvoid,a.keterangan,a.tglvoid,a.diskon
from deliverybill as a,breakdown as b,isimanifestin as c,manifestin as d where 
a.idbreakdown=b.id_breakdown AND
b.id_isimanifestin=c.id_isimanifestin AND
c.id_manifestin = d.id_manifestin AND a.tglbayar BETWEEN '$tglawal' AND '$tglakhir' AND 
b.isvoid='0' AND a.isvoid='0' group by b.id_isimanifestin");

//=========utk semua agent
if($_POST[agent]=='SEMUA')
{
	//
	$str=mysql_query("select tgl,sum(koli),sum(berat),sum(sewagudang),sum(adm),sum(ppn),sum(diskon) from periodtmp where carabayar like '%$carabayar%' 
group by tgl");

	$pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(170,8,'IMPORT',0,0,'L',1);	
		$pdf->Ln();
//		$pdf->SetFont('Times','I',11);
//		$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal].' s/d '.$_POST[tglakhir],0,0,'L',1);
//		$pdf->Ln();
		$pdf->SetFont('Arial','B',9);			
		$pdf->Cell(25,8,'Tanggal',1,0,'C',1);
		$pdf->Cell(20,8,'Koli',1,0,'C',1);
		$pdf->Cell(20,8,'(Kg)',1,0,'C',1);
		$pdf->Cell(25,8,'S_Gudang(Rp)',1,0,'C',1);
		
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{
			$pdf->Cell(15,8,'HF',1,0,'C',1);
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}
		else//jika untuk Angkasa Pura
		{
			//$pdf->Cell(20,8,'PPn',1,0,'C',1);
			//$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}				
		$berat=0;$sewagudang=0;$koli=0;
		$adm=0;$ppn=0;$total1=0;	
		
	while($r=mysql_fetch_array($str))//
	{
		$no=1;
			$total=$r[3]+$r[4]+$r[5]-$r[6];		
			$pdf->Cell(25,5,ymd2dmy($r[0]),1,0,'C',1);	
			$pdf->Cell(20,5,number_format($r[1], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,5,number_format($r[2], 1, ',', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,number_format($r[3]-$r[6], 0, '.', '.'),1,0,'R',1);
					
		
			if($_POST[untuk]=='gp')
			{$pdf->Cell(15,5,'0',1,0,'C',1);	
				$pdf->Cell(20,5,number_format($r[4], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			else
			{
				//$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				//$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			$berat=$berat+$r[2];
			$koli=$koli+$r[1];			
			$sewagudang=$sewagudang+$r[3]-$r[6];
			$adm=$adm+$r[4];
			$ppn=$ppn+$r[5];
			$total1=$total1+$total;
			
			
				$no+=1;
		} //AKHIR DARI ISI TABEL
	//totalnya
			$gberat=$gberat+$berat;
			$gkoli=$gkoli+$koli;			
			$gsewagudang=$gsewagudang+$sewagudang;
			$gadm=$gadm+$adm;
			$gppn=$gppn+$ppn;
			$gtotal=$gtotal+$total1;	
			
	$pdf->Ln(2);
	$pdf->Cell(25,5,'TOTAL',1,0,'R',1);		
	$pdf->Cell(20,5,number_format($koli, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(25,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(15,5,'0',1,0,'C',1);
		$pdf->Cell(20,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		//$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		//$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}			
			

 }
//===========jika agent-aget ACS, GMFAA dan POST
else if(($_POST[agent]<>'SEMUA') AND ($_POST[agent]<>'OTHERS'))
{
	//
	$str=mysql_query("select tgl,sum(koli),sum(berat),sum(sewagudang),sum(adm),sum(ppn),sum(diskon) from periodtmp where carabayar like '%$carabayar%' AND agent like '%$_POST[agent]%' 
group by tgl");

	$pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(170,8,'IMPORT',0,0,'L',1);	
//		$pdf->Ln();
//		$pdf->SetFont('Times','I',11);
//		$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal].' s/d '.$_POST[tglakhir],0,0,'L',1);
		$pdf->Ln();
		$pdf->SetFont('Arial','B',9);			
		$pdf->Cell(25,8,$_POST[agent],1,0,'C',1);
		$pdf->Cell(20,8,'Koli',1,0,'C',1);
		$pdf->Cell(20,8,'(Kg)',1,0,'C',1);
		$pdf->Cell(25,8,'S_Gudang(Rp)',1,0,'C',1);
		
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{$pdf->Cell(15,8,'HF',1,0,'C',1);
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}
		else//jika untuk Angkasa Pura
		{
			//$pdf->Cell(20,8,'PPn',1,0,'C',1);
			//$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}				
		$berat=0;$sewagudang=0;$koli=0;
		$adm=0;$ppn=0;$total1=0;	
		
	while($r=mysql_fetch_array($str))//
	{
		$no=1;
			$total=$r[3]+$r[4]+$r[5]-$r[6];		
			$pdf->Cell(25,5,ymd2dmy($r[0]),1,0,'C',1);	
			$pdf->Cell(20,5,number_format($r[1], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,5,number_format($r[2], 1, ',', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,number_format($r[3]-$r[6], 0, '.', '.'),1,0,'R',1);
					
		
			if($_POST[untuk]=='gp')
			{$pdf->Cell(15,5,'0',1,0,'C',1);	
				$pdf->Cell(20,5,number_format($r[4], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			else
			{
				//$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				//$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			$berat=$berat+$r[2];
			$koli=$koli+$r[1];			
			$sewagudang=$sewagudang+$r[3]-$r[6];
			$adm=$adm+$r[4];
			$ppn=$ppn+$r[5];
			$total1=$total1+$total;
			

				$no+=1;
		} //AKHIR DARI ISI TABEL
	//totalnya
			$gberat=$gberat+$berat;
			$gkoli=$gkoli+$koli;			
			$gsewagudang=$gsewagudang+$sewagudang;
			$gadm=$gadm+$adm;
			$gppn=$gppn+$ppn;
			$gtotal=$gtotal+$total1;	
	$pdf->Ln(2);
	$pdf->Cell(25,5,'TOTAL',1,0,'R',1);		
	$pdf->Cell(20,5,number_format($koli, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(25,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(15,5,'0',1,0,'C',1);
		$pdf->Cell(20,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		//$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		//$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}			
	

		

		}

//=================UNTUK OUTGOING
mysql_query("delete from periodtmp"); 
mysql_query("insert into periodtmp 
select a.tglbayar,b.btb_totalkoli,b.btb_totalberat,
a.overtime,a.document,a.lain,a.id_carabayar,b.btb_agent,b.airline,
a.isvoid,a.keterangan,a.tglvoid,a.diskon from deliverybill as a,
out_dtbarang_h as b  
where a.no_smubtb=b.btb_nobtb AND b.isvoid='0' AND a.tglbayar BETWEEN '$tglawal' AND '$tglakhir' AND a.isvoid='0'");

//=========utk semua agent
if($_POST[agent]=='SEMUA')
{
	//
	$str=mysql_query("select tgl,sum(koli),sum(berat),sum(sewagudang),sum(adm),sum(ppn),sum(diskon) from periodtmp where carabayar like '%$carabayar%' 
group by tgl");

	$pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(170,8,'EXPORT',0,0,'L',1);	
//		$pdf->Ln();
//		$pdf->SetFont('Times','I',11);
//		$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal].' s/d '.$_POST[tglakhir],0,0,'L',1);
		$pdf->Ln();
		$pdf->SetFont('Arial','B',9);			
		$pdf->Cell(25,8,'Tanggal',1,0,'C',1);
		$pdf->Cell(20,8,'Koli',1,0,'C',1);
		$pdf->Cell(20,8,'(Kg)',1,0,'C',1);
		$pdf->Cell(25,8,'S_Gudang(Rp)',1,0,'C',1);
		
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{$pdf->Cell(15,8,'HF',1,0,'C',1);
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}
		else//jika untuk Angkasa Pura
		{
			//$pdf->Cell(20,8,'PPn',1,0,'C',1);
			//$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}				
		$berat=0;$sewagudang=0;$koli=0;
		$adm=0;$ppn=0;$total1=0;	
		
	while($r=mysql_fetch_array($str))//
	{
		$no=1;
			$total=$r[3]+$r[4]+$r[5]-$r[6];		
			$pdf->Cell(25,5,ymd2dmy($r[0]),1,0,'C',1);	
			$pdf->Cell(20,5,number_format($r[1], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,5,number_format($r[2], 1, ',', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,number_format($r[3]-$r[6], 0, '.', '.'),1,0,'R',1);
					
		
			if($_POST[untuk]=='gp')
			{$pdf->Cell(15,5,'0',1,0,'C',1);	
				$pdf->Cell(20,5,number_format($r[4], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			else
			{
				//$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				//$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			$berat=$berat+$r[2];
			$koli=$koli+$r[1];			
			$sewagudang=$sewagudang+$r[3]-$r[6];
			$adm=$adm+$r[4];
			$ppn=$ppn+$r[5];
			$total1=$total1+$total;
			

				$no+=1;
		} //AKHIR DARI ISI TABEL
	//totalnya
			$gberat=$gberat+$berat;
			$gkoli=$gkoli+$koli;			
			$gsewagudang=$gsewagudang+$sewagudang;
			$gadm=$gadm+$adm;
			$gppn=$gppn+$ppn;
			$gtotal=$gtotal+$total1;	
	$pdf->Ln(2);
	$pdf->Cell(25,5,'TOTAL',1,0,'R',1);		
	$pdf->Cell(20,5,number_format($koli, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(25,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(15,5,'0',1,0,'C',1);
		$pdf->Cell(20,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		//$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		//$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}			

//====GRAND TOTALNYA
	$pdf->Ln(2);
	$pdf->Cell(25,5,'GRAND TOTAL ',1,0,'R',1);		
	$pdf->Cell(20,5,number_format($gkoli, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(20,5,number_format($gberat, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(25,5,number_format($gsewagudang, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(15,5,'0',1,0,'C',1);
	if($_POST[untuk]=='gp')
	{
		$pdf->Cell(20,5,number_format($gadm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($gppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($gtotal, 0, '.', '.'),1,0,'R',1);			
					
		$pdf->Ln();
	}
	else
	{//$pdf->Cell(30,5,'',0,0,'R',0);	
		//$pdf->Cell(20,5,number_format($gppn, 0, '.', '.'),1,0,'R',1);
		//$pdf->Cell(25,5,number_format($gtotal, 0, '.', '.'),1,0,'R',1);			
	//	$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}				
			

 }
//===========jika agent-aget ACS, GMFAA dan POST
else if(($_POST[agent]<>'SEMUA') AND ($_POST[agent]<>'OTHERS'))
{
	//
	$str=mysql_query("select tgl,sum(koli),sum(berat),sum(sewagudang),sum(adm),sum(ppn),sum(diskon) from periodtmp where carabayar like '%$carabayar%' AND agent like '%$_POST[agent]%' 
group by tgl");

	$pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(170,8,'EXPORT',0,0,'L',1);	
		$pdf->Ln();
//		$pdf->SetFont('Times','I',11);
//		$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal].' s/d '.$_POST[tglakhir],0,0,'L',1);
//		$pdf->Ln();
		$pdf->SetFont('Arial','B',9);			
		$pdf->Cell(25,8,$_POST[agent],1,0,'C',1);
		$pdf->Cell(20,8,'Koli',1,0,'C',1);
		$pdf->Cell(20,8,'(Kg)',1,0,'C',1);
		$pdf->Cell(25,8,'S_Gudang(Rp)',1,0,'C',1);
		
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{$pdf->Cell(15,8,'HF',1,0,'C',1);
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}
		else//jika untuk Angkasa Pura
		{
			//$pdf->Cell(20,8,'PPn',1,0,'C',1);
			//$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}				
		$berat=0;$sewagudang=0;$koli=0;
		$adm=0;$ppn=0;$total1=0;	
		
	while($r=mysql_fetch_array($str))//
	{
		$no=1;
			$total=$r[3]+$r[4]+$r[5]-$r[6];		
			$pdf->Cell(25,5,ymd2dmy($r[0]),1,0,'C',1);	
			$pdf->Cell(20,5,number_format($r[1], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,5,number_format($r[2], 1, ',', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,number_format($r[3]-$r[6], 0, '.', '.'),1,0,'R',1);
					
		
			if($_POST[untuk]=='gp')
			{$pdf->Cell(15,5,'0',1,0,'C',1);	
				$pdf->Cell(20,5,number_format($r[4], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			else
			{
				//$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				//$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			$berat=$berat+$r[2];
			$koli=$koli+$r[1];			
			$sewagudang=$sewagudang+$r[3]-$r[6];
			$adm=$adm+$r[4];
			$ppn=$ppn+$r[5];
			$total1=$total1+$total;
			

				$no+=1;
		} //AKHIR DARI ISI TABEL
	//totalnya
			$gberat=$gberat+$berat;
			$gkoli=$gkoli+$koli;			
			$gsewagudang=$gsewagudang+$sewagudang;
			$gadm=$gadm+$adm;
			$gppn=$gppn+$ppn;
			$gtotal=$gtotal+$total1;	
	$pdf->Ln(2);
	$pdf->Cell(25,5,'TOTAL',1,0,'R',1);		
	$pdf->Cell(20,5,number_format($koli, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(25,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(15,5,'0',1,0,'C',1);
		$pdf->Cell(20,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		//$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		//$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}


//====GRAND TOTALNYA
	$pdf->Ln(2);
	$pdf->Cell(25,5,'GRAND TOTAL ',1,0,'R',1);		
	$pdf->Cell(20,5,number_format($gkoli, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(20,5,number_format($gberat, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(25,5,number_format($gsewagudang, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(15,5,'0',1,0,'C',1);
		$pdf->Cell(20,5,number_format($gadm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($gppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($gtotal, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(20,5,number_format($gppn, 0, '.', '.'),1,0,'R',1);
		//$pdf->Cell(25,5,number_format($gtotal, 0, '.', '.'),1,0,'R',1);			
		//$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}	
					

	}	
// jika selain agent-agent diatas :

else if($_POST[agent]=='OTHERS')
{
	//
	$str=mysql_query("select tgl,sum(koli),sum(berat),sum(sewagudang),sum(adm),sum(ppn),sum(diskon) from periodtmp where carabayar like '%$carabayar%' AND 
(agent <> 'ACS' AND agent<>'GMFAA' AND agent<>'QATAR' AND agent<>'POST' AND agent<>'POS')  
group by tgl");

	$pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(170,8,'EXPORT',0,0,'L',1);	
		$pdf->Ln();
	//	$pdf->SetFont('Times','I',11);
	//	$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal].' s/d '.$_POST[tglakhir],0,0,'L',1);
	//	$pdf->Ln();
		$pdf->SetFont('Arial','B',9);			
		$pdf->Cell(25,8,$_POST[agent],1,0,'C',1);
		$pdf->Cell(20,8,'Koli',1,0,'C',1);
		$pdf->Cell(20,8,'(Kg)',1,0,'C',1);
		$pdf->Cell(25,8,'S_Gudang(Rp)',1,0,'C',1);
	
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{	$pdf->Cell(15,8,'HF',1,0,'C',1);
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}
		else//jika untuk Angkasa Pura
		{
			//$pdf->Cell(20,8,'PPn',1,0,'C',1);
			//$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}				
		$berat=0;$sewagudang=0;$koli=0;
		$adm=0;$ppn=0;$total1=0;	
		
	while($r=mysql_fetch_array($str))//
	{
		$no=1;
			$total=$r[3]+$r[4]+$r[5]-$r[6];		
			$pdf->Cell(25,5,ymd2dmy($r[0]),1,0,'C',1);	
			$pdf->Cell(20,5,number_format($r[1], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,5,number_format($r[2], 1, ',', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,number_format($r[3]-$r[6], 0, '.', '.'),1,0,'R',1);
				
		
			if($_POST[untuk]=='gp')
			{	$pdf->Cell(15,5,'0',1,0,'C',1);	
				$pdf->Cell(20,5,number_format($r[4], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			else
			{
				//$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				//$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			$berat=$berat+$r[2];
			$koli=$koli+$r[1];			
			$sewagudang=$sewagudang+$r[3]-$r[6];
			$adm=$adm+$r[4];
			$ppn=$ppn+$r[5];
			$total1=$total1+$total;
			

				$no+=1;
		} //AKHIR DARI ISI TABEL
	//totalnya
			$gberat=$gberat+$berat;
			$gkoli=$gkoli+$koli;			
			$gsewagudang=$gsewagudang+$sewagudang;
			$gadm=$gadm+$adm;
			$gppn=$gppn+$ppn;
			$gtotal=$gtotal+$total1;	
	$pdf->Ln(2);
	$pdf->Cell(25,5,'TOTAL',1,0,'R',1);		
	$pdf->Cell(20,5,number_format($koli, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(25,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);

	if($_POST[untuk]=='gp')
	{	$pdf->Cell(15,5,'0',1,0,'C',1);
		$pdf->Cell(20,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
	//	$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
	//	$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		//$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}			

//====GRAND TOTALNYA
	$pdf->Ln(2);
	$pdf->Cell(25,5,'GRAND TOTAL ',1,0,'R',1);		
	$pdf->Cell(20,5,number_format($gkoli, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(20,5,number_format($gberat, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(25,5,number_format($gsewagudang, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(15,5,'0',1,0,'C',1);
		$pdf->Cell(20,5,number_format($gadm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($gppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($gtotal, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(20,5,number_format($gppn, 0, '.', '.'),1,0,'R',1);
		//$pdf->Cell(25,5,number_format($gtotal, 0, '.', '.'),1,0,'R',1);			
		//$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}	
			

	}
}
else if($outin=='0')//jika ada pilihan incoming per tanggal
{
mysql_query("delete from periodtmp"); 
mysql_query("insert into periodtmp 
select a.tglbayar,b.kolidatang,b.beratdatang,a.overtime,a.document,a.lain,a.id_carabayar,c.agent,d.airline,a.isvoid,a.keterangan,a.tglvoid,a.diskon
from deliverybill as a,breakdown as b,isimanifestin as c,manifestin as d where 
a.idbreakdown=b.id_breakdown AND
b.id_isimanifestin=c.id_isimanifestin AND
c.id_manifestin = d.id_manifestin AND a.tglbayar BETWEEN '$tglawal' AND '$tglakhir' AND 
b.isvoid='0' AND a.isvoid='0' group by b.id_isimanifestin");

//=========utk semua agent
if($_POST[agent]=='SEMUA')
{
	//
	$str=mysql_query("select tgl,sum(koli),sum(berat),sum(sewagudang),sum(adm),sum(ppn),sum(diskon) from periodtmp where carabayar like '%$carabayar%' 
group by tgl");

	$pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(170,8,'IMPORT',0,0,'L',1);	
		$pdf->Ln();
		$pdf->SetFont('Times','I',11);
		$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal].' s/d '.$_POST[tglakhir],0,0,'L',1);
		$pdf->Ln();
		$pdf->SetFont('Arial','B',9);			
		$pdf->Cell(25,8,'Tanggal',1,0,'C',1);
		$pdf->Cell(20,8,'Koli',1,0,'C',1);
		$pdf->Cell(20,8,'(Kg)',1,0,'C',1);
		$pdf->Cell(25,8,'S_Gudang(Rp)',1,0,'C',1);
		
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{$pdf->Cell(15,8,'HF',1,0,'C',1);
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}
		else//jika untuk Angkasa Pura
		{
			//$pdf->Cell(20,8,'PPn',1,0,'C',1);
			//$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}				
		$berat=0;$sewagudang=0;$koli=0;
		$adm=0;$ppn=0;$total1=0;	
		
	while($r=mysql_fetch_array($str))//
	{
		$no=1;
			$total=$r[3]+$r[4]+$r[5]-$r[6];		
			$pdf->Cell(25,5,ymd2dmy($r[0]),1,0,'C',1);	
			$pdf->Cell(20,5,number_format($r[1], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,5,number_format($r[2], 1, ',', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,number_format($r[3]-$r[6], 0, '.', '.'),1,0,'R',1);
					
		
			if($_POST[untuk]=='gp')
			{
				$pdf->Cell(15,5,'0',1,0,'C',1);	
				$pdf->Cell(20,5,number_format($r[4], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			else
			{
				//$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				//$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			$berat=$berat+$r[2];
			$koli=$koli+$r[1];			
			$sewagudang=$sewagudang+$r[3]-$r[6];
			$adm=$adm+$r[4];
			$ppn=$ppn+$r[5];
			$total1=$total1+$total;
			
	
				$no+=1;
		} //AKHIR DARI ISI TABEL
	//totalnya
	$pdf->Ln(2);
	$pdf->Cell(25,5,'Total',1,0,'R',1);		
	$pdf->Cell(20,5,number_format($koli, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(25,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(15,5,'0',1,0,'C',1);
		$pdf->Cell(20,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		//$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
	//	$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}			

 }
//===========jika agent-aget ACS, GMFAA dan POST
else if(($_POST[agent]<>'SEMUA') AND ($_POST[agent]<>'OTHERS'))
{
	//
	$str=mysql_query("select tgl,sum(koli),sum(berat),sum(sewagudang),sum(adm),sum(ppn),sum(diskon) from periodtmp where carabayar like '%$carabayar%' AND agent like '%$_POST[agent]%' 
group by tgl");

	$pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(170,8,'IMPORT',0,0,'L',1);	
		$pdf->Ln();
		$pdf->SetFont('Times','I',11);
		$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal].' s/d '.$_POST[tglakhir],0,0,'L',1);
		$pdf->Ln();
		$pdf->SetFont('Arial','B',9);			
		$pdf->Cell(25,8,$_POST[agent],1,0,'C',1);
		$pdf->Cell(20,8,'Koli',1,0,'C',1);
		$pdf->Cell(20,8,'(Kg)',1,0,'C',1);
		$pdf->Cell(25,8,'S_Gudang(Rp)',1,0,'C',1);
		
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{$pdf->Cell(15,8,'HF',1,0,'C',1);
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}
		else//jika untuk Angkasa Pura
		{
			//$pdf->Cell(20,8,'PPn',1,0,'C',1);
			//$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}				
		$berat=0;$sewagudang=0;$koli=0;
		$adm=0;$ppn=0;$total1=0;	
		
	while($r=mysql_fetch_array($str))//
	{
		$no=1;
			$total=$r[3]+$r[4]+$r[5]-$r[6];		
			$pdf->Cell(25,5,ymd2dmy($r[0]),1,0,'C',1);	
			$pdf->Cell(20,5,number_format($r[1], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,5,number_format($r[2], 1, ',', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,number_format($r[3]-$r[6], 0, '.', '.'),1,0,'R',1);
					
		
			if($_POST[untuk]=='gp')
			{$pdf->Cell(15,5,'0',1,0,'C',1);	
				$pdf->Cell(20,5,number_format($r[4], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			else
			{
				//$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				//$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			$berat=$berat+$r[2];
			$koli=$koli+$r[1];			
			$sewagudang=$sewagudang+$r[3]-$r[6];
			$adm=$adm+$r[4];
			$ppn=$ppn+$r[5];
			$total1=$total1+$total;
			
				$no+=1;
		} //AKHIR DARI ISI TABEL
	//totalnya
	$pdf->Ln(2);
	$pdf->Cell(25,5,'Total',1,0,'R',1);		
	$pdf->Cell(20,5,number_format($koli, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(25,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(15,5,'0',1,0,'C',1);
		$pdf->Cell(20,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		//$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
	//	$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}			

	}	
// jika selain agent-agent diatas :

else if($_POST[agent]=='OTHERS')
{
	//
	$str=mysql_query("select tgl,sum(koli),sum(berat),sum(sewagudang),sum(adm),sum(ppn),sum(diskon) from periodtmp where carabayar like '%$carabayar%' AND 
(agent <> 'ACS' AND agent<>'GMFAA' AND agent<>'QATAR' AND agent<>'POST' AND agent<>'POS')  
group by tgl");

	$pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(170,8,'IMPORT',0,0,'L',1);	
		$pdf->Ln();
		$pdf->SetFont('Times','I',11);
		$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal].' s/d '.$_POST[tglakhir],0,0,'L',1);
		$pdf->Ln();
		$pdf->SetFont('Arial','B',9);			
		$pdf->Cell(25,8,$_POST[agent],1,0,'C',1);
		$pdf->Cell(20,8,'Koli',1,0,'C',1);
		$pdf->Cell(20,8,'(Kg)',1,0,'C',1);
		$pdf->Cell(25,8,'S_Gudang(Rp)',1,0,'C',1);
		
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{$pdf->Cell(15,8,'HF',1,0,'C',1);
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}
		else//jika untuk Angkasa Pura
		{
			//$pdf->Cell(20,8,'PPn',1,0,'C',1);
			//$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}				
		$berat=0;$sewagudang=0;$koli=0;
		$adm=0;$ppn=0;$total1=0;	
		
	while($r=mysql_fetch_array($str))//
	{
		$no=1;
			$total=$r[3]+$r[4]+$r[5]-$r[6];		
			$pdf->Cell(25,5,ymd2dmy($r[0]),1,0,'C',1);	
			$pdf->Cell(20,5,number_format($r[1], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,5,number_format($r[2], 1, ',', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,number_format($r[3]-$r[6], 0, '.', '.'),1,0,'R',1);
					
		
			if($_POST[untuk]=='gp')
			{$pdf->Cell(15,5,'0',1,0,'C',1);	
				$pdf->Cell(20,5,number_format($r[4], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			else
			{
				//$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				//$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			$berat=$berat+$r[2];
			$koli=$koli+$r[1];			
			$sewagudang=$sewagudang+$r[3]-$r[6];
			$adm=$adm+$r[4];
			$ppn=$ppn+$r[5];
			$total1=$total1+$total;
			

				$no+=1;
		} //AKHIR DARI ISI TABEL
	//totalnya
	$pdf->Ln(2);
	$pdf->Cell(25,5,'Total',1,0,'R',1);		
	$pdf->Cell(20,5,number_format($koli, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(25,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(15,5,'0',1,0,'C',1);
		$pdf->Cell(20,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		//$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
	//	$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}			

	}	
	
}	
else if($outin=='1') //jika outgoing per tanggal
{
mysql_query("delete from periodtmp"); 
mysql_query("insert into periodtmp 
select a.tglbayar,b.btb_totalkoli,b.btb_totalberat,
a.overtime,a.document,a.lain,a.id_carabayar,b.btb_agent,b.airline,
a.isvoid,a.keterangan,a.tglvoid,a.diskon from deliverybill_tmp as a,
out_dtbarang_h_tmp as b  
where a.no_smubtb=b.btb_nobtb AND b.isvoid='0' AND a.tglbayar BETWEEN '$tglawal' AND '$tglakhir' AND a.isvoid='0'");

//=========utk semua agent
if($_POST[agent]=='SEMUA')
{
	//
	$str=mysql_query("select tgl,sum(koli),sum(berat),sum(sewagudang),sum(adm),sum(ppn),sum(diskon) from periodtmp where carabayar like '%$carabayar%' 
group by tgl");

	$pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(170,8,'EXPORT',0,0,'L',1);	
		$pdf->Ln();
		$pdf->SetFont('Times','I',11);
		$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal].' s/d '.$_POST[tglakhir],0,0,'L',1);
		$pdf->Ln();
		$pdf->SetFont('Arial','B',9);			
		$pdf->Cell(25,8,'Tanggal',1,0,'C',1);
		$pdf->Cell(20,8,'Koli',1,0,'C',1);
		$pdf->Cell(20,8,'(Kg)',1,0,'C',1);
		$pdf->Cell(25,8,'S_Gudang(Rp)',1,0,'C',1);
		
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{$pdf->Cell(15,8,'HF',1,0,'C',1);
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}
		else//jika untuk Angkasa Pura
		{
			//$pdf->Cell(20,8,'PPn',1,0,'C',1);
			//$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}				
		$berat=0;$sewagudang=0;$koli=0;
		$adm=0;$ppn=0;$total1=0;	
		
	while($r=mysql_fetch_array($str))//
	{
		$no=1;
			$total=$r[3]+$r[4]+$r[5]-$r[6];		
			$pdf->Cell(25,5,ymd2dmy($r[0]),1,0,'C',1);	
			$pdf->Cell(20,5,number_format($r[1], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,5,number_format($r[2], 1, ',', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,number_format($r[3]-$r[6], 0, '.', '.'),1,0,'R',1);
				
		
			if($_POST[untuk]=='gp')
			{	$pdf->Cell(15,5,'0',1,0,'C',1);	
				$pdf->Cell(20,5,number_format($r[4], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			else
			{
				//$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				//$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			$berat=$berat+$r[2];
			$koli=$koli+$r[1];			
			$sewagudang=$sewagudang+$r[3]-$r[6];
			$adm=$adm+$r[4];
			$ppn=$ppn+$r[5];
			$total1=$total1+$total;
			

				$no+=1;
		} //AKHIR DARI ISI TABEL
	//totalnya
	$pdf->Ln(2);
	$pdf->Cell(25,5,'Total',1,0,'R',1);		
	$pdf->Cell(20,5,number_format($koli, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(25,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(15,5,'0',1,0,'C',1);
		$pdf->Cell(20,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		//$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
	//	$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}			

 }
//===========jika agent-aget ACS, GMFAA dan POST
else if(($_POST[agent]<>'SEMUA') AND ($_POST[agent]<>'OTHERS'))
{
	//
	$str=mysql_query("select tgl,sum(koli),sum(berat),sum(sewagudang),sum(adm),sum(ppn),sum(diskon) from periodtmp where carabayar like '%$carabayar%' AND agent like '%$_POST[agent]%' 
group by tgl");

	$pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(170,8,'EXPORT',0,0,'L',1);	
		$pdf->Ln();
		$pdf->SetFont('Times','I',11);
		$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal].' s/d '.$_POST[tglakhir],0,0,'L',1);
		$pdf->Ln();
		$pdf->SetFont('Arial','B',9);			
		$pdf->Cell(25,8,$_POST[agent],1,0,'C',1);
		$pdf->Cell(20,8,'Koli',1,0,'C',1);
		$pdf->Cell(20,8,'(Kg)',1,0,'C',1);
		$pdf->Cell(25,8,'S_Gudang(Rp)',1,0,'C',1);
		
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{$pdf->Cell(15,8,'HF',1,0,'C',1);
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}
		else//jika untuk Angkasa Pura
		{
			//$pdf->Cell(20,8,'PPn',1,0,'C',1);
			//$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}				
		$berat=0;$sewagudang=0;$koli=0;
		$adm=0;$ppn=0;$total1=0;	
		
	while($r=mysql_fetch_array($str))//
	{
		$no=1;
			$total=$r[3]+$r[4]+$r[5]-$r[6];		
			$pdf->Cell(25,5,ymd2dmy($r[0]),1,0,'C',1);	
			$pdf->Cell(20,5,number_format($r[1], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,5,number_format($r[2], 1, ',', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,number_format($r[3]-$r[6], 0, '.', '.'),1,0,'R',1);
						
		
			if($_POST[untuk]=='gp')
			{$pdf->Cell(15,5,'0',1,0,'C',1);
				$pdf->Cell(20,5,number_format($r[4], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			else
			{
				//$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				//$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			$berat=$berat+$r[2];
			$koli=$koli+$r[1];			
			$sewagudang=$sewagudang+$r[3]-$r[6];
			$adm=$adm+$r[4];
			$ppn=$ppn+$r[5];
			$total1=$total1+$total;
			

				$no+=1;
		} //AKHIR DARI ISI TABEL
	//totalnya
	$pdf->Ln(2);
	$pdf->Cell(25,5,'Total',1,0,'R',1);		
	$pdf->Cell(20,5,number_format($koli, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(25,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(15,5,'0',1,0,'C',1);
		$pdf->Cell(20,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		//$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
	//	$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}			

	}	
// jika selain agent-agent diatas :

else if($_POST[agent]=='OTHERS')
{
	//
	$str=mysql_query("select tgl,sum(koli),sum(berat),sum(sewagudang),sum(adm),sum(ppn),sum(diskon) from periodtmp where carabayar like '%$carabayar%' AND 
(agent <> 'ACS' AND agent<>'GMFAA' AND agent<>'QATAR' AND agent<>'POST' AND agent<>'POS')  
group by tgl");

	$pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(170,8,'EXPORT',0,0,'L',1);	
		$pdf->Ln();
		$pdf->SetFont('Times','I',11);
		$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal].' s/d '.$_POST[tglakhir],0,0,'L',1);
		$pdf->Ln();
		$pdf->SetFont('Arial','B',9);			
		$pdf->Cell(25,8,$_POST[agent],1,0,'C',1);
		$pdf->Cell(20,8,'Koli',1,0,'C',1);
		$pdf->Cell(20,8,'(Kg)',1,0,'C',1);
		$pdf->Cell(25,8,'S_Gudang(Rp)',1,0,'C',1);
		
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{$pdf->Cell(15,8,'HF',1,0,'C',1);
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}
		else//jika untuk Angkasa Pura
		{
		//	$pdf->Cell(20,8,'PPn',1,0,'C',1);
		//	$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}				
		$berat=0;$sewagudang=0;$koli=0;
		$adm=0;$ppn=0;$total1=0;	
		
	while($r=mysql_fetch_array($str))//
	{
		$no=1;
			$total=$r[3]+$r[4]+$r[5]-$r[6];		
			$pdf->Cell(25,5,ymd2dmy($r[0]),1,0,'C',1);	
			$pdf->Cell(20,5,number_format($r[1], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,5,number_format($r[2], 1, ',', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,number_format($r[3]-$r[6], 0, '.', '.'),1,0,'R',1);
					
		
			if($_POST[untuk]=='gp')
			{$pdf->Cell(15,5,'0',1,0,'C',1);	
				$pdf->Cell(20,5,number_format($r[4], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			else
			{
				//$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				//$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			$berat=$berat+$r[2];
			$koli=$koli+$r[1];			
			$sewagudang=$sewagudang+$r[3]-$r[6];
			$adm=$adm+$r[4];
			$ppn=$ppn+$r[5];
			$total1=$total1+$total;
			

				$no+=1;
		} //AKHIR DARI ISI TABEL
	//totalnya
	$pdf->Ln(2);
	$pdf->Cell(25,5,'Total',1,0,'R',1);		
	$pdf->Cell(20,5,number_format($koli, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(25,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(15,5,'0',1,0,'C',1);
		$pdf->Cell(20,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		//$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
	//	$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}			

	}	
}
}

//=======================================PER CUSTOMER
elseif($_POST[bt_preview]=='per Customer')
{
//proses dulu jika ingin incoming dan outgoing (SEMUA)
if($outin=='2')
{
			$gberat=0;
			$gkoli=0;			
			$gsewagudang=0;
			$gadm=0;
			$gppn=0;
			$gtotal=0;
			

//==================UTK INCOMING DULU
mysql_query("delete from periodtmp"); 
mysql_query("insert into periodtmp 
select a.tglbayar,b.kolidatang,b.beratdatang,a.overtime,a.document,a.lain,a.id_carabayar,c.agent,d.airline,a.isvoid,a.keterangan,a.tglvoid,a.diskon
from deliverybill as a,breakdown as b,isimanifestin as c,manifestin as d where 
a.idbreakdown=b.id_breakdown AND
b.id_isimanifestin=c.id_isimanifestin AND
c.id_manifestin = d.id_manifestin AND
b.isvoid='0' AND a.tglbayar BETWEEN '$tglawal' AND '$tglakhir' AND a.isvoid='0' group by b.id_isimanifestin");

//=========utk semua agent
if($_POST[agent]=='SEMUA')
{
	$pdf->AddPage();
		$pdf->SetFillColor(255,255,255);

//		$pdf->SetFont('Times','I',11);
	//	$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal].' s/d '.$_POST[tglakhir],0,0,'L',1);
	//	$pdf->Ln();	
	
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(170,8,'IMPORT',0,0,'L',1);	
		$pdf->Ln();

	$air=mysql_query("select airline from periodtmp
	where (agent<>'GMFAA' AND agent<>'POST' AND agent<>'POS' AND agent<>'QATAR' AND agent<>'ACS') GROUP by airline");

		$sberat=0;$ssewagudang=0;$skoli=0;
		$sadm=0;$sppn=0;$stotal1=0;
			
		while($ar=mysql_fetch_array($air))//utk airlne dulu	
	{//
	$str=mysql_query("select tgl,sum(koli),sum(berat),sum(sewagudang),sum(adm),sum(ppn),sum(diskon) from periodtmp where carabayar like '%$carabayar%' AND airline='$ar[0]' AND (agent<>'GMFAA' AND agent<>'QATAR' AND agent<>'POST' AND agent<>'POS' AND agent<>'ACS')
group by tgl");


		$pdf->Ln(2);	
		$pdf->SetFont('Arial','B',9);			
		$pdf->Cell(35,8,$ar[0],0,0,'C',1);
		$pdf->Ln();		
		$pdf->Cell(35,8,'Tanggal',1,0,'C',1);
		$pdf->Cell(20,8,'Koli',1,0,'C',1);
		$pdf->Cell(20,8,'(Kg)',1,0,'C',1);
		$pdf->Cell(25,8,'S_Gudang(Rp)',1,0,'C',1);
		
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{
			$pdf->Cell(15,8,'HF',1,0,'C',1);$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(25,8,'Sub Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}
		else//jika untuk Angkasa Pura
		{
			//$pdf->Cell(20,8,'PPn',1,0,'C',1);
			//$pdf->Cell(25,8,'Sub Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}				
		$berat=0;$sewagudang=0;$koli=0;
		$adm=0;$ppn=0;$total1=0;	
		
	while($r=mysql_fetch_array($str))//
	{
		$no=1;
			$total=$r[3]+$r[4]+$r[5]-$r[6];		
			$pdf->Cell(35,5,ymd2dmy($r[0]),1,0,'C',1);	
			$pdf->Cell(20,5,number_format($r[1], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,5,number_format($r[2], 1, ',', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,number_format($r[3]-$r[6], 0, '.', '.'),1,0,'R',1);
					
		
			if($_POST[untuk]=='gp')
			{$pdf->Cell(15,5,'0',1,0,'C',1);	
				$pdf->Cell(20,5,number_format($r[4], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			else
			{
				//$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				//$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			$berat=$berat+$r[2];
			$koli=$koli+$r[1];			
			$sewagudang=$sewagudang+$r[3]-$r[6];
			$adm=$adm+$r[4];
			$ppn=$ppn+$r[5];
			$total1=$total1+$total;
		} //AKHIR DARI ISI TABEL
	//totalnya
			$sberat=$sberat+$berat;
			$skoli=$skoli+$koli;			
			$ssewagudang=$ssewagudang+$sewagudang;
			$sadm=$sadm+$adm;
			$sppn=$sppn+$ppn;
			$stotal1=$stotal1+$total1;	
				
			$gberat=$gberat+$berat;
			$gkoli=$gkoli+$koli;			
			$gsewagudang=$gsewagudang+$sewagudang;
			$gadm=$gadm+$adm;
			$gppn=$gppn+$ppn;
			$gtotal=$gtotal+$total1;	
			
	$pdf->Cell(35,5,'Sub Total ('.$ar[0].')',1,0,'R',1);		
	$pdf->Cell(20,5,number_format($koli, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(25,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(15,5,'0',1,0,'C',1);
		$pdf->Cell(20,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		//$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		//$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}			
 }
 // agent :
	$age=mysql_query("select agent from periodtmp
	where (agent='GMFAA' OR agent='POST' OR agent='POS' OR agent='ACS' OR agent='QATAR') GROUP by agent");
		while($ag=mysql_fetch_array($age))//utk airlne dulu	
	{//
	$str=mysql_query("select tgl,sum(koli),sum(berat),sum(sewagudang),sum(adm),sum(ppn),sum(diskon) from periodtmp where carabayar like '%$carabayar%' AND 
agent='$ag[0]' group by tgl");


		$pdf->Ln(2);	
		$pdf->SetFont('Arial','B',9);			
		$pdf->Cell(35,8,$ag[0],0,0,'C',1);
		$pdf->Ln();		
		$pdf->Cell(35,8,'Tanggal',1,0,'C',1);
		$pdf->Cell(20,8,'Koli',1,0,'C',1);
		$pdf->Cell(20,8,'(Kg)',1,0,'C',1);
		$pdf->Cell(25,8,'S_Gudang(Rp)',1,0,'C',1);
		
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{$pdf->Cell(15,8,'HF',1,0,'C',1);
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(25,8,'Sub Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}
		else//jika untuk Angkasa Pura
		{
			//$pdf->Cell(20,8,'PPn',1,0,'C',1);
			//$pdf->Cell(25,5,'Sub Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}				
		$berat=0;$sewagudang=0;$koli=0;
		$adm=0;$ppn=0;$total1=0;	
		
	while($r=mysql_fetch_array($str))//
	{
		$no=1;
			$total=$r[3]+$r[4]+$r[5]-$r[6];		
			$pdf->Cell(35,5,ymd2dmy($r[0]),1,0,'C',1);	
			$pdf->Cell(20,5,number_format($r[1], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,5,number_format($r[2], 1, ',', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,number_format($r[3]-$r[6], 0, '.', '.'),1,0,'R',1);
					
		
			if($_POST[untuk]=='gp')
			{$pdf->Cell(15,5,'0',1,0,'C',1);	
				$pdf->Cell(20,5,number_format($r[4], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			else
			{
				//$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
			//	$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			$berat=$berat+$r[2];
			$koli=$koli+$r[1];			
			$sewagudang=$sewagudang+$r[3]-$r[6];
			$adm=$adm+$r[4];
			$ppn=$ppn+$r[5];
			$total1=$total1+$total;
		} //AKHIR DARI ISI TABEL
	//totalnya
			$sberat=$sberat+$berat;
			$skoli=$skoli+$koli;			
			$ssewagudang=$ssewagudang+$sewagudang;
			$sadm=$sadm+$adm;
			$sppn=$sppn+$ppn;
			$stotal1=$stotal1+$total1;	
			
			$gberat=$gberat+$berat;
			$gkoli=$gkoli+$koli;			
			$gsewagudang=$gsewagudang+$sewagudang;
			$gadm=$gadm+$adm;
			$gppn=$gppn+$ppn;
			$gtotal=$gtotal+$total1;	
			
	$pdf->Cell(35,5,'Sub Total ('.$ag[0].')',1,0,'R',1);		
	$pdf->Cell(20,5,number_format($koli, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(25,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);

	if($_POST[untuk]=='gp')
	{	$pdf->Cell(15,5,'0',1,0,'C',1);
		$pdf->Cell(20,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		//$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		//$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}			
 }
  
//====TOTALNYA
	$pdf->Ln(2);
	$pdf->Cell(35,5,'TOTAL INCOMING',1,0,'R',1);		
	$pdf->Cell(20,5,number_format($skoli, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(20,5,number_format($sberat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(25,5,number_format($ssewagudang, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(15,5,'0',1,0,'C',1);
		$pdf->Cell(20,5,number_format($sadm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($sppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($stotal1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(20,5,number_format($sppn, 0, '.', '.'),1,0,'R',1);
		//$pdf->Cell(25,5,number_format($stotal1, 0, '.', '.'),1,0,'R',1);			
		//$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}			
 }
 
//===========jika agent-aget ACS, GMFAA dan POST
else if(($_POST[agent]<>'SEMUA') AND ($_POST[agent]<>'OTHERS'))
{
	//
	$str=mysql_query("select tgl,sum(koli),sum(berat),sum(sewagudang),sum(adm),sum(ppn),sum(diskon) from periodtmp where carabayar like '%$carabayar%' AND agent like '%$_POST[agent]%' 
group by tgl");

	$pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(170,8,'IMPORT',0,0,'L',1);	
		$pdf->Ln();
//		$pdf->SetFont('Times','I',11);
//		$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal].' s/d '.$_POST[tglakhir],0,0,'L',1);
//		$pdf->Ln();
		$pdf->SetFont('Arial','B',9);			
		$pdf->Cell(25,8,$_POST[agent],1,0,'C',1);
		$pdf->Cell(20,8,'Koli',1,0,'C',1);
		$pdf->Cell(20,8,'(Kg)',1,0,'C',1);
		$pdf->Cell(25,8,'S_Gudang(Rp)',1,0,'C',1);
		
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{$pdf->Cell(15,8,'HF',1,0,'C',1);
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}
		else//jika untuk Angkasa Pura
		{
		//	$pdf->Cell(20,8,'PPn',1,0,'C',1);
		//	$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}				
		$berat=0;$sewagudang=0;$koli=0;
		$adm=0;$ppn=0;$total1=0;	
		
	while($r=mysql_fetch_array($str))//
	{
		$no=1;
			$total=$r[3]+$r[4]+$r[5]-$r[6];		
			$pdf->Cell(25,5,ymd2dmy($r[0]),1,0,'C',1);	
			$pdf->Cell(20,5,number_format($r[1], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,5,number_format($r[2], 1, ',', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,number_format($r[3]-$r[6], 0, '.', '.'),1,0,'R',1);
					
		
			if($_POST[untuk]=='gp')
			{$pdf->Cell(15,5,'0',1,0,'C',1);	
				$pdf->Cell(20,5,number_format($r[4], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			else
			{
				//$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				//$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			$berat=$berat+$r[2];
			$koli=$koli+$r[1];			
			$sewagudang=$sewagudang+$r[3]-$r[6];
			$adm=$adm+$r[4];
			$ppn=$ppn+$r[5];
			$total1=$total1+$total;
			
			

				$no+=1;
		} //AKHIR DARI ISI TABEL
	//totalnya
			$gberat=$gberat+$berat;
			$gkoli=$gkoli+$koli;			
			$gsewagudang=$gsewagudang+$sewagudang;
			$gadm=$gadm+$adm;
			$gppn=$gppn+$ppn;
			$gtotal=$gtotal+$total1;	
	$pdf->Ln(2);
	$pdf->Cell(25,5,'TOTAL',1,0,'R',1);		
	$pdf->Cell(20,5,number_format($koli, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(25,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(15,5,'0',1,0,'C',1);
		$pdf->Cell(20,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		//$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		//$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}			
	


		}

//=================UNTUK OUTGOING
mysql_query("delete from periodtmp"); 
mysql_query("insert into periodtmp 
select a.tglbayar,b.btb_totalkoli,b.btb_totalberat,
a.overtime,a.document,a.lain,a.id_carabayar,b.btb_agent,b.airline,
a.isvoid,a.keterangan,a.tglvoid,a.diskon from deliverybill as a,
out_dtbarang_h as b  
where a.no_smubtb=b.btb_nobtb AND a.tglbayar BETWEEN '$tglawal' AND '$tglakhir' AND b.isvoid='0' AND a.isvoid='0'");

//=========utk semua agent
if($_POST[agent]=='SEMUA')
{
			$sberat=0;
			$skoli=0;
			$ssewagudang=0;
			$sadm=0;
			$sppn=0;
			$stotal1=0;
		$pdf->Ln();	
	$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(170,8,'EXPORT',0,0,'L',1);	
		$pdf->Ln();	
	$air=mysql_query("select airline from periodtmp
	where (agent<>'GMFAA' AND agent<>'POST' AND agent<>'POS' AND agent<>'ACS' AND agent<>'QATAR') GROUP by airline");
		while($ar=mysql_fetch_array($air))//utk airlne dulu	
	{//
	$str=mysql_query("select tgl,sum(koli),sum(berat),sum(sewagudang),sum(adm),sum(ppn),sum(diskon) from periodtmp where carabayar like '%$carabayar%' AND airline='$ar[0]' AND (agent<>'GMFAA' AND agent<>'QATAR' AND agent<>'POST' AND agent<>'POS' AND agent<>'ACS')
group by tgl");


		$pdf->Ln(2);	
		$pdf->SetFont('Arial','B',9);			
		$pdf->Cell(35,8,$ar[0],0,0,'C',1);
		$pdf->Ln();		
		$pdf->Cell(35,8,'Tanggal',1,0,'C',1);
		$pdf->Cell(20,8,'Koli',1,0,'C',1);
		$pdf->Cell(20,8,'(Kg)',1,0,'C',1);
		$pdf->Cell(25,8,'S_Gudang(Rp)',1,0,'C',1);
		
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{$pdf->Cell(15,8,'HF',1,0,'C',1);
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(25,8,'Sub Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}
		else//jika untuk Angkasa Pura
		{
		//	$pdf->Cell(20,8,'PPn',1,0,'C',1);
			//$pdf->Cell(25,5,'Sub Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}				
		$berat=0;$sewagudang=0;$koli=0;
		$adm=0;$ppn=0;$total1=0;	
		
	while($r=mysql_fetch_array($str))//
	{
		$no=1;
			$total=$r[3]+$r[4]+$r[5]-$r[6];		
			$pdf->Cell(35,5,ymd2dmy($r[0]),1,0,'C',1);	
			$pdf->Cell(20,5,number_format($r[1], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,5,number_format($r[2], 1, ',', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,number_format($r[3]-$r[6], 0, '.', '.'),1,0,'R',1);
				
		
			if($_POST[untuk]=='gp')
			{$pdf->Cell(15,5,'0',1,0,'C',1);		
				$pdf->Cell(20,5,number_format($r[4], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			else
			{
			//	$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
			//	$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			$berat=$berat+$r[2];
			$koli=$koli+$r[1];			
			$sewagudang=$sewagudang+$r[3]-$r[6];
			$adm=$adm+$r[4];
			$ppn=$ppn+$r[5];
			$total1=$total1+$total;
			

		} //AKHIR DARI ISI TABEL
	//totalnya
			$sberat=$sberat+$berat;
			$skoli=$skoli+$koli;			
			$ssewagudang=$ssewagudang+$sewagudang;
			$sadm=$sadm+$adm;
			$sppn=$sppn+$ppn;
			$stotal1=$stotal1+$total1;	
				
			$gberat=$gberat+$berat;
			$gkoli=$gkoli+$koli;			
			$gsewagudang=$gsewagudang+$sewagudang;
			$gadm=$gadm+$adm;
			$gppn=$gppn+$ppn;
			$gtotal=$gtotal+$total1;	
	$pdf->Cell(35,5,'Sub Total ('.$ar[0].')',1,0,'R',1);		
	$pdf->Cell(20,5,number_format($koli, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(25,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(15,5,'0',1,0,'C',1);
		$pdf->Cell(20,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		//$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		//$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}			
}
//agent :
	$age=mysql_query("select agent from periodtmp
	where (agent='GMFAA' OR agent='POST' OR agent='POS' OR agent='ACS' OR agent='QATAR') GROUP by agent");
		while($ag=mysql_fetch_array($age))//utk airlne dulu	
	{//
	$str=mysql_query("select tgl,sum(koli),sum(berat),sum(sewagudang),sum(adm),sum(ppn),sum(diskon) from periodtmp where carabayar like '%$carabayar%' AND 
agent='$ag[0]' group by tgl");


		$pdf->Ln(2);	
		$pdf->SetFont('Arial','B',9);			
		$pdf->Cell(35,8,$ag[0],0,0,'C',1);
		$pdf->Ln();		
		$pdf->Cell(35,8,'Tanggal',1,0,'C',1);
		$pdf->Cell(20,8,'Koli',1,0,'C',1);
		$pdf->Cell(20,8,'(Kg)',1,0,'C',1);
		$pdf->Cell(25,8,'S_Gudang(Rp)',1,0,'C',1);
		
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{$pdf->Cell(15,8,'HF',1,0,'C',1);
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(25,8,'Sub Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}
		else//jika untuk Angkasa Pura
		{
			//$pdf->Cell(20,8,'PPn',1,0,'C',1);
			//$pdf->Cell(25,8,'Sub Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}				
		$berat=0;$sewagudang=0;$koli=0;
		$adm=0;$ppn=0;$total1=0;	
		
	while($r=mysql_fetch_array($str))//
	{
		$no=1;
			$total=$r[3]+$r[4]+$r[5]-$r[6];		
			$pdf->Cell(35,5,ymd2dmy($r[0]),1,0,'C',1);	
			$pdf->Cell(20,5,number_format($r[1], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,5,number_format($r[2], 1, ',', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,number_format($r[3]-$r[6], 0, '.', '.'),1,0,'R',1);
					
		
			if($_POST[untuk]=='gp')
			{$pdf->Cell(15,5,'0',1,0,'C',1);	
				$pdf->Cell(20,5,number_format($r[4], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			else
			{
				//$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				//$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			$berat=$berat+$r[2];
			$koli=$koli+$r[1];			
			$sewagudang=$sewagudang+$r[3]-$r[6];
			$adm=$adm+$r[4];
			$ppn=$ppn+$r[5];
			$total1=$total1+$total;
			

		} //AKHIR DARI ISI TABEL
	//totalnya
			$sberat=$sberat+$berat;
			$skoli=$skoli+$koli;			
			$ssewagudang=$ssewagudang+$sewagudang;
			$sadm=$sadm+$adm;
			$sppn=$sppn+$ppn;
			$stotal1=$stotal1+$total1;	
				
			$gberat=$gberat+$berat;
			$gkoli=$gkoli+$koli;			
			$gsewagudang=$gsewagudang+$sewagudang;
			$gadm=$gadm+$adm;
			$gppn=$gppn+$ppn;
			$gtotal=$gtotal+$total1;	
	$pdf->Cell(35,5,'Sub Total ('.$ag[0].')',1,0,'R',1);		
	$pdf->Cell(20,5,number_format($koli, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(25,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(15,5,'0',1,0,'C',1);
		$pdf->Cell(20,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		//$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		//$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}			
}
//====TOTAL OUTGOING
	$pdf->Ln(2);
	$pdf->Cell(35,5,'TOTAL OUTGOING ',1,0,'R',1);		
	$pdf->Cell(20,5,number_format($skoli, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(20,5,number_format($sberat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(25,5,number_format($ssewagudang, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(15,5,'0',1,0,'C',1);
		$pdf->Cell(20,5,number_format($sadm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($sppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($stotal1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(20,5,number_format($sppn, 0, '.', '.'),1,0,'R',1);
		//$pdf->Cell(25,5,number_format($stotal1, 0, '.', '.'),1,0,'R',1);			
		//$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}				
//====GRAND TOTALNYA
	$pdf->Ln(2);
	$pdf->Cell(35,5,'GRAND TOTAL ',1,0,'R',1);		
	$pdf->Cell(20,5,number_format($gkoli, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(20,5,number_format($gberat, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(25,5,number_format($gsewagudang, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(15,5,'0',1,0,'C',1);
		$pdf->Cell(20,5,number_format($gadm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($gppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($gtotal, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(20,5,number_format($gppn, 0, '.', '.'),1,0,'R',1);
		//$pdf->Cell(25,5,number_format($gtotal, 0, '.', '.'),1,0,'R',1);			
		//$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}				

 }
//===========jika agent-aget ACS, GMFAA dan POST
else if(($_POST[agent]<>'SEMUA') AND ($_POST[agent]<>'OTHERS'))
{
	//
	$str=mysql_query("select tgl,sum(koli),sum(berat),sum(sewagudang),sum(adm),sum(ppn),sum(diskon) from periodtmp where carabayar like '%$carabayar%' AND agent like '%$_POST[agent]%' 
group by tgl");

	$pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(170,8,'EXPORT',0,0,'L',1);	
		$pdf->Ln();
	//	$pdf->SetFont('Times','I',11);
	//	$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal].' s/d '.$_POST[tglakhir],0,0,'L',1);
	//	$pdf->Ln();
		$pdf->SetFont('Arial','B',9);			
		$pdf->Cell(25,8,$_POST[agent],1,0,'C',1);
		$pdf->Cell(20,8,'Koli',1,0,'C',1);
		$pdf->Cell(20,8,'(Kg)',1,0,'C',1);
		$pdf->Cell(25,8,'S_Gudang(Rp)',1,0,'C',1);
		
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{$pdf->Cell(15,8,'HF',1,0,'C',1);
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}
		else//jika untuk Angkasa Pura
		{
			//$pdf->Cell(20,8,'PPn',1,0,'C',1);
			//$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}				
		$berat=0;$sewagudang=0;$koli=0;
		$adm=0;$ppn=0;$total1=0;	
		
	while($r=mysql_fetch_array($str))//
	{
		$no=1;
			$total=$r[3]+$r[4]+$r[5]-$r[6];		
			$pdf->Cell(25,5,ymd2dmy($r[0]),1,0,'C',1);	
			$pdf->Cell(20,5,number_format($r[1], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,5,number_format($r[2], 1, ',', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,number_format($r[3]-$r[6], 0, '.', '.'),1,0,'R',1);
					
		
			if($_POST[untuk]=='gp')
			{$pdf->Cell(15,5,'0',1,0,'C',1);	
				$pdf->Cell(20,5,number_format($r[4], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			else
			{
				//$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				//$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			$berat=$berat+$r[2];
			$koli=$koli+$r[1];			
			$sewagudang=$sewagudang+$r[3]-$r[6];
			$adm=$adm+$r[4];
			$ppn=$ppn+$r[5];
			$total1=$total1+$total;
			
			

				$no+=1;
		} //AKHIR DARI ISI TABEL
	//totalnya
			$gberat=$gberat+$berat;
			$gkoli=$gkoli+$koli;			
			$gsewagudang=$gsewagudang+$sewagudang;
			$gadm=$gadm+$adm;
			$gppn=$gppn+$ppn;
			$gtotal=$gtotal+$total1;	
	$pdf->Ln(2);
	$pdf->Cell(25,5,'TOTAL',1,0,'R',1);		
	$pdf->Cell(20,5,number_format($koli, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(25,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(15,5,'0',1,0,'C',1);
		$pdf->Cell(20,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		//$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		//$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}


//====GRAND TOTALNYA
	$pdf->Ln(2);
	$pdf->Cell(25,5,'GRAND TOTAL ',1,0,'R',1);		
	$pdf->Cell(20,5,number_format($gkoli, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(20,5,number_format($gberat, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(25,5,number_format($gsewagudang, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(15,5,'0',1,0,'C',1);
		$pdf->Cell(20,5,number_format($gadm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($gppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($gtotal, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(20,5,number_format($gppn, 0, '.', '.'),1,0,'R',1);
		//$pdf->Cell(25,5,number_format($gtotal, 0, '.', '.'),1,0,'R',1);			
		//$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}	
	}	
// jika selain agent-agent diatas :

else if($_POST[agent]=='OTHERS')
{
	//
	$str=mysql_query("select tgl,sum(koli),sum(berat),sum(sewagudang),sum(adm),sum(ppn),sum(diskon) from periodtmp where carabayar like '%$carabayar%' AND 
(agent <> 'ACS' AND agent<>'GMFAA' AND agent<>'POST' AND agent<>'POS' AND agent<>'QATAR')  
group by tgl");

	$pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(170,8,'EXPORT',0,0,'L',1);	
		$pdf->Ln();
	//	$pdf->SetFont('Times','I',11);
	//	$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal].' s/d '.$_POST[tglakhir],0,0,'L',1);
	//	$pdf->Ln();
		$pdf->SetFont('Arial','B',9);			
		$pdf->Cell(25,8,$_POST[agent],1,0,'C',1);
		$pdf->Cell(20,8,'Koli',1,0,'C',1);
		$pdf->Cell(20,8,'(Kg)',1,0,'C',1);
		$pdf->Cell(25,8,'S_Gudang(Rp)',1,0,'C',1);
		
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{$pdf->Cell(15,8,'HF',1,0,'C',1);
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}
		else//jika untuk Angkasa Pura
		{
		//	$pdf->Cell(20,8,'PPn',1,0,'C',1);
		//	$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}				
		$berat=0;$sewagudang=0;$koli=0;
		$adm=0;$ppn=0;$total1=0;	
		
	while($r=mysql_fetch_array($str))//
	{
		$no=1;
			$total=$r[3]+$r[4]+$r[5]-$r[6];		
			$pdf->Cell(25,5,ymd2dmy($r[0]),1,0,'C',1);	
			$pdf->Cell(20,5,number_format($r[1], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,5,number_format($r[2], 1, ',', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,number_format($r[3]-$r[6], 0, '.', '.'),1,0,'R',1);
				
		
			if($_POST[untuk]=='gp')
			{	$pdf->Cell(15,5,'0',1,0,'C',1);	
				$pdf->Cell(20,5,number_format($r[4], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			else
			{
				//$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				//$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			$berat=$berat+$r[2];
			$koli=$koli+$r[1];			
			$sewagudang=$sewagudang+$r[3]-$r[6];
			$adm=$adm+$r[4];
			$ppn=$ppn+$r[5];
			$total1=$total1+$total;
			
			
	
				$no+=1;
		} //AKHIR DARI ISI TABEL
	//totalnya
			$gberat=$gberat+$berat;
			$gkoli=$gkoli+$koli;			
			$gsewagudang=$gsewagudang+$sewagudang;
			$gadm=$gadm+$adm;
			$gppn=$gppn+$ppn;
			$gtotal=$gtotal+$total1;	
	$pdf->Ln(2);
	$pdf->Cell(25,5,'TOTAL',1,0,'R',1);		
	$pdf->Cell(20,5,number_format($koli, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(25,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);

	if($_POST[untuk]=='gp')
	{	$pdf->Cell(15,5,'0',1,0,'C',1);
		$pdf->Cell(20,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
	//	$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		//$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}			

//====GRAND TOTALNYA
	$pdf->Ln(2);
	$pdf->Cell(25,5,'GRAND TOTAL ',1,0,'R',1);		
	$pdf->Cell(20,5,number_format($gkoli, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(20,5,number_format($gberat, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(25,5,number_format($gsewagudang, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(15,5,'0',1,0,'C',1);
		$pdf->Cell(20,5,number_format($gadm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($gppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($gtotal, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(20,5,number_format($gppn, 0, '.', '.'),1,0,'R',1);
		//$pdf->Cell(25,5,number_format($gtotal, 0, '.', '.'),1,0,'R',1);			
		//$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}	
			
	}
}
else if($outin=='0')//jika ada pilihan incoming per tanggal
{
mysql_query("delete from periodtmp"); 
mysql_query("insert into periodtmp 
select a.tglbayar,b.kolidatang,b.beratdatang,a.overtime,a.document,a.lain,a.id_carabayar,c.agent,d.airline,a.isvoid,a.keterangan,a.tglvoid,a.diskon
from deliverybill as a,breakdown as b,isimanifestin as c,manifestin as d where 
a.idbreakdown=b.id_breakdown AND
b.id_isimanifestin=c.id_isimanifestin AND
c.id_manifestin = d.id_manifestin AND
b.isvoid='0' AND a.tglbayar BETWEEN '$tglawal' AND '$tglakhir' AND a.isvoid='0' group by b.id_isimanifestin");

//=========utk semua agent
if($_POST[agent]=='SEMUA')
{
	//
	$str=mysql_query("select tgl,sum(koli),sum(berat),sum(sewagudang),sum(adm),sum(ppn),sum(diskon) from periodtmp where carabayar like '%$carabayar%' 
group by tgl");

	$pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(170,8,'IMPORT',0,0,'L',1);	
		$pdf->Ln();
//		$pdf->SetFont('Times','I',11);
//		$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal].' s/d '.$_POST[tglakhir],0,0,'L',1);
	//	$pdf->Ln();
		$pdf->SetFont('Arial','B',9);			
		$pdf->Cell(25,8,'Tanggal',1,0,'C',1);
		$pdf->Cell(20,8,'Koli',1,0,'C',1);
		$pdf->Cell(20,8,'(Kg)',1,0,'C',1);
		$pdf->Cell(25,8,'S_Gudang(Rp)',1,0,'C',1);
		
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{$pdf->Cell(15,8,'HF',1,0,'C',1);
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}
		else//jika untuk Angkasa Pura
		{
		//	$pdf->Cell(20,8,'PPn',1,0,'C',1);
		//	$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}				
		$berat=0;$sewagudang=0;$koli=0;
		$adm=0;$ppn=0;$total1=0;	
		
	while($r=mysql_fetch_array($str))//
	{
		$no=1;
			$total=$r[3]+$r[4]+$r[5]-$r[6];		
			$pdf->Cell(25,5,ymd2dmy($r[0]),1,0,'C',1);	
			$pdf->Cell(20,5,number_format($r[1], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,5,number_format($r[2], 1, ',', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,number_format($r[3]-$r[6], 0, '.', '.'),1,0,'R',1);
					
		
			if($_POST[untuk]=='gp')
			{$pdf->Cell(15,5,'0',1,0,'C',1);	
				$pdf->Cell(20,5,number_format($r[4], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			else
			{
			//	$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
			//	$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			$berat=$berat+$r[2];
			$koli=$koli+$r[1];			
			$sewagudang=$sewagudang+$r[3]-$r[6];
			$adm=$adm+$r[4];
			$ppn=$ppn+$r[5];
			$total1=$total1+$total;
			

				$no+=1;
		} //AKHIR DARI ISI TABEL
	//totalnya
	$pdf->Ln(2);
	$pdf->Cell(25,5,'Total',1,0,'R',1);		
	$pdf->Cell(20,5,number_format($koli, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(25,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);

	if($_POST[untuk]=='gp')
	{	$pdf->Cell(15,5,'0',1,0,'C',1);
		$pdf->Cell(20,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
	//	$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		//$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}			

 }
//===========jika agent-aget ACS, GMFAA dan POST
else if(($_POST[agent]<>'SEMUA') AND ($_POST[agent]<>'OTHERS'))
{
	//
	$str=mysql_query("select tgl,sum(koli),sum(berat),sum(sewagudang),sum(adm),sum(ppn),sum(diskon) from periodtmp where carabayar like '%$carabayar%' AND agent like '%$_POST[agent]%' 
group by tgl");

	$pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(170,8,'IMPORT',0,0,'L',1);	
		$pdf->Ln();
//		$pdf->SetFont('Times','I',11);
//		$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal].' s/d '.$_POST[tglakhir],0,0,'L',1);
//		$pdf->Ln();
		$pdf->SetFont('Arial','B',9);			
		$pdf->Cell(25,8,$_POST[agent],1,0,'C',1);
		$pdf->Cell(20,8,'Koli',1,0,'C',1);
		$pdf->Cell(20,8,'(Kg)',1,0,'C',1);
		$pdf->Cell(25,8,'S_Gudang(Rp)',1,0,'C',1);
	
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{	$pdf->Cell(15,8,'HF',1,0,'C',1);
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}
		else//jika untuk Angkasa Pura
		{
			//$pdf->Cell(20,8,'PPn',1,0,'C',1);
			//$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}				
		$berat=0;$sewagudang=0;$koli=0;
		$adm=0;$ppn=0;$total1=0;	
		
	while($r=mysql_fetch_array($str))//
	{
		$no=1;
			$total=$r[3]+$r[4]+$r[5]-$r[6];		
			$pdf->Cell(25,5,ymd2dmy($r[0]),1,0,'C',1);	
			$pdf->Cell(20,5,number_format($r[1], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,5,number_format($r[2], 1, ',', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,number_format($r[3]-$r[6], 0, '.', '.'),1,0,'R',1);
					
		
			if($_POST[untuk]=='gp')
			{$pdf->Cell(15,5,'0',1,0,'C',1);	
				$pdf->Cell(20,5,number_format($r[4], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			else
			{
				//$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				//$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			$berat=$berat+$r[2];
			$koli=$koli+$r[1];			
			$sewagudang=$sewagudang+$r[3]-$r[6];
			$adm=$adm+$r[4];
			$ppn=$ppn+$r[5];
			$total1=$total1+$total;
			

				$no+=1;
		} //AKHIR DARI ISI TABEL
	//totalnya
	$pdf->Ln(2);
	$pdf->Cell(25,5,'Total',1,0,'R',1);		
	$pdf->Cell(20,5,number_format($koli, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(25,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(15,5,'0',1,0,'C',1);
		$pdf->Cell(20,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		//$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		//$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}			

	}	
// jika selain agent-agent diatas :

else if($_POST[agent]=='OTHERS')
{
	//
	$str=mysql_query("select tgl,sum(koli),sum(berat),sum(sewagudang),sum(adm),sum(ppn),sum(diskon) from periodtmp where carabayar like '%$carabayar%' AND 
(agent <> 'ACS' AND agent<>'GMFAA' AND agent<>'POST' AND agent<>'POS' AND agent<>'QATAR')  
group by tgl");

	$pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(170,8,'IMPORT',0,0,'L',1);	
		$pdf->Ln();
	//	$pdf->SetFont('Times','I',11);
	//	$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal].' s/d '.$_POST[tglakhir],0,0,'L',1);
	//	$pdf->Ln();
		$pdf->SetFont('Arial','B',9);			
		$pdf->Cell(25,8,$_POST[agent],1,0,'C',1);
		$pdf->Cell(20,8,'Koli',1,0,'C',1);
		$pdf->Cell(20,8,'(Kg)',1,0,'C',1);
		$pdf->Cell(25,8,'S_Gudang(Rp)',1,0,'C',1);
		
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{$pdf->Cell(15,8,'HF',1,0,'C',1);
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}
		else//jika untuk Angkasa Pura
		{
			//$pdf->Cell(20,8,'PPn',1,0,'C',1);
			//$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}				
		$berat=0;$sewagudang=0;$koli=0;
		$adm=0;$ppn=0;$total1=0;	
		
	while($r=mysql_fetch_array($str))//
	{
		$no=1;
			$total=$r[3]+$r[4]+$r[5]-$r[6];		
			$pdf->Cell(25,5,ymd2dmy($r[0]),1,0,'C',1);	
			$pdf->Cell(20,5,number_format($r[1], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,5,number_format($r[2], 1, ',', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,number_format($r[3]-$r[6], 0, '.', '.'),1,0,'R',1);
					
		
			if($_POST[untuk]=='gp')
			{$pdf->Cell(15,5,'0',1,0,'C',1);	
				$pdf->Cell(20,5,number_format($r[4], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			else
			{
				//$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				//$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			$berat=$berat+$r[2];
			$koli=$koli+$r[1];			
			$sewagudang=$sewagudang+$r[3]-$r[6];
			$adm=$adm+$r[4];
			$ppn=$ppn+$r[5];
			$total1=$total1+$total;
			
			

				$no+=1;
		} //AKHIR DARI ISI TABEL
	//totalnya
	$pdf->Ln(2);
	$pdf->Cell(25,5,'Total',1,0,'R',1);		
	$pdf->Cell(20,5,number_format($koli, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(25,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);

	if($_POST[untuk]=='gp')
	{	$pdf->Cell(15,5,'0',1,0,'C',1);
		$pdf->Cell(20,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		//$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		//$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}			

	}	
	
}	
else if($outin=='1') //jika outgoing per tanggal
{
mysql_query("delete from periodtmp"); 
mysql_query("insert into periodtmp 
select a.tglbayar,b.btb_totalkoli,b.btb_totalberat,
a.overtime,a.document,a.lain,a.id_carabayar,b.btb_agent,b.airline,
a.isvoid,a.keterangan,a.tglvoid,a.diskon from deliverybill as a,
out_dtbarang_h as b  
where a.no_smubtb=b.btb_nobtb AND a.tglbayar BETWEEN '$tglawal' AND '$tglakhir' AND b.isvoid='0' AND a.isvoid='0'");

//=========utk semua agent
if($_POST[agent]=='SEMUA')
{
	//
	$str=mysql_query("select tgl,sum(koli),sum(berat),sum(sewagudang),sum(adm),sum(ppn),sum(diskon) from periodtmp where carabayar like '%$carabayar%' 
group by tgl");

	$pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(170,8,'EXPORT',0,0,'L',1);	
		$pdf->Ln();
//		$pdf->SetFont('Times','I',11);
//		$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal].' s/d '.$_POST[tglakhir],0,0,'L',1);
	//	$pdf->Ln();
		$pdf->SetFont('Arial','B',9);			
		$pdf->Cell(25,8,'Tanggal',1,0,'C',1);
		$pdf->Cell(20,8,'Koli',1,0,'C',1);
		$pdf->Cell(20,8,'(Kg)',1,0,'C',1);
		$pdf->Cell(25,8,'S_Gudang(Rp)',1,0,'C',1);
		
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{$pdf->Cell(15,8,'HF',1,0,'C',1);
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}
		else//jika untuk Angkasa Pura
		{
			//$pdf->Cell(20,8,'PPn',1,0,'C',1);
			//$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}				
		$berat=0;$sewagudang=0;$koli=0;
		$adm=0;$ppn=0;$total1=0;	
		
	while($r=mysql_fetch_array($str))//
	{
		$no=1;
			$total=$r[3]+$r[4]+$r[5]-$r[6];		
			$pdf->Cell(25,5,ymd2dmy($r[0]),1,0,'C',1);	
			$pdf->Cell(20,5,number_format($r[1], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,5,number_format($r[2], 1, ',', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,number_format($r[3]-$r[6], 0, '.', '.'),1,0,'R',1);
					
		
			if($_POST[untuk]=='gp')
			{$pdf->Cell(15,5,'0',1,0,'C',1);	
				$pdf->Cell(20,5,number_format($r[4], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			else
			{
				//$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				//$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			$berat=$berat+$r[2];
			$koli=$koli+$r[1];			
			$sewagudang=$sewagudang+$r[3]-$r[6];
			$adm=$adm+$r[4];
			$ppn=$ppn+$r[5];
			$total1=$total1+$total;
			
			

				$no+=1;
		} //AKHIR DARI ISI TABEL
	//totalnya
	$pdf->Ln(2);
	$pdf->Cell(25,5,'Total',1,0,'R',1);		
	$pdf->Cell(20,5,number_format($koli, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(25,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(15,5,'0',1,0,'C',1);
		$pdf->Cell(20,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		//$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		//$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}			

 }
//===========jika agent-aget ACS, GMFAA dan POST
else if(($_POST[agent]<>'SEMUA') AND ($_POST[agent]<>'OTHERS'))
{
	//
	$str=mysql_query("select tgl,sum(koli),sum(berat),sum(sewagudang),sum(adm),sum(ppn),sum(diskon) from periodtmp where carabayar like '%$carabayar%' AND agent like '%$_POST[agent]%' 
group by tgl");

	$pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(170,8,'EXPORT',0,0,'L',1);	
	//	$pdf->Ln();
	//	$pdf->SetFont('Times','I',11);
	//	$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal].' s/d '.$_POST[tglakhir],0,0,'L',1);
		$pdf->Ln();
		$pdf->SetFont('Arial','B',9);			
		$pdf->Cell(25,8,$_POST[agent],1,0,'C',1);
		$pdf->Cell(20,8,'Koli',1,0,'C',1);
		$pdf->Cell(20,8,'(Kg)',1,0,'C',1);
		$pdf->Cell(25,8,'S_Gudang(Rp)',1,0,'C',1);
		
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{$pdf->Cell(15,8,'HF',1,0,'C',1);
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}
		else//jika untuk Angkasa Pura
		{
			//$pdf->Cell(20,8,'PPn',1,0,'C',1);
			//$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}				
		$berat=0;$sewagudang=0;$koli=0;
		$adm=0;$ppn=0;$total1=0;	
		
	while($r=mysql_fetch_array($str))//
	{
		$no=1;
			$total=$r[3]+$r[4]+$r[5]-$r[6];		
			$pdf->Cell(25,5,ymd2dmy($r[0]),1,0,'C',1);	
			$pdf->Cell(20,5,number_format($r[1], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,5,number_format($r[2], 1, ',', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,number_format($r[3]-$r[6], 0, '.', '.'),1,0,'R',1);
					
		
			if($_POST[untuk]=='gp')
			{$pdf->Cell(15,5,'0',1,0,'C',1);	
				$pdf->Cell(20,5,number_format($r[4], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			else
			{
				//$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				//$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			$berat=$berat+$r[2];
			$koli=$koli+$r[1];			
			$sewagudang=$sewagudang+$r[3]-$r[6];
			$adm=$adm+$r[4];
			$ppn=$ppn+$r[5];
			$total1=$total1+$total;
			
			

				$no+=1;
		} //AKHIR DARI ISI TABEL
	//totalnya
	$pdf->Ln(2);
	$pdf->Cell(25,5,'Total',1,0,'R',1);		
	$pdf->Cell(20,5,number_format($koli, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(25,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);

	if($_POST[untuk]=='gp')
	{	$pdf->Cell(15,5,'0',1,0,'C',1);
		$pdf->Cell(20,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		//$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		//$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}			
		}	
// jika selain agent-agent diatas :

else if($_POST[agent]=='OTHERS')
{
	//
	$str=mysql_query("select tgl,sum(koli),sum(berat),sum(sewagudang),sum(adm),sum(ppn),sum(diskon) from periodtmp where carabayar like '%$carabayar%' AND 
(agent <> 'ACS' AND agent<>'GMFAA' AND agent<>'POST' AND agent<>'POS' AND agent<>'QATAR')  
group by tgl");

	$pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(170,8,'EXPORT',0,0,'L',1);	
	//	$pdf->Ln();
	//	$pdf->SetFont('Times','I',11);
	//	$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal].' s/d '.$_POST[tglakhir],0,0,'L',1);
		$pdf->Ln();
		$pdf->SetFont('Arial','B',9);			
		$pdf->Cell(25,8,$_POST[agent],1,0,'C',1);
		$pdf->Cell(20,8,'Koli',1,0,'C',1);
		$pdf->Cell(20,8,'(Kg)',1,0,'C',1);
		$pdf->Cell(25,8,'S_Gudang(Rp)',1,0,'C',1);
		
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{$pdf->Cell(15,8,'HF',1,0,'C',1);
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}
		else//jika untuk Angkasa Pura
		{
			//$pdf->Cell(20,8,'PPn',1,0,'C',1);
			//$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);	
		}				

		$berat=0;$sewagudang=0;$koli=0;
		$adm=0;$ppn=0;$total1=0;	
		
	while($r=mysql_fetch_array($str))//
	{
		$no=1;
			$total=$r[3]+$r[4]+$r[5]-$r[6];		
			$pdf->Cell(25,5,ymd2dmy($r[0]),1,0,'C',1);	
			$pdf->Cell(20,5,number_format($r[1], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,5,number_format($r[2], 1, ',', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,number_format($r[3]-$r[6], 0, '.', '.'),1,0,'R',1);
				
		
			if($_POST[untuk]=='gp')
			{	$pdf->Cell(15,5,'0',1,0,'C',1);	
				$pdf->Cell(20,5,number_format($r[4], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			else
			{
				//$pdf->Cell(20,5,number_format($r[5], 0, '.', '.'),1,0,'R',1);
				//$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
		
				$pdf->Ln();
			}
			$berat=$berat+$r[2];
			$koli=$koli+$r[1];			
			$sewagudang=$sewagudang+$r[3]-$r[6];
			$adm=$adm+$r[4];
			$ppn=$ppn+$r[5];
			$total1=$total1+$total;
			
	
				$no+=1;
		} //AKHIR DARI ISI TABEL
	//totalnya
	$pdf->Ln(2);
	$pdf->Cell(25,5,'Total',1,0,'R',1);		
	$pdf->Cell(20,5,number_format($koli, 0, '.', '.'),1,0,'R',1);
	$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(25,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(15,5,'0',1,0,'C',1);
		$pdf->Cell(20,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		//$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		//$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}			

	}	
}
}
//================================== END OF PER CUSTOMER

$pdf->Output();
}//end of if SMU !	


// CARI btb/smu UTK Delivery Bill
elseif ($module=='deliverybill' AND $act=='caribtbsmu')
{
	$tgl=date("Y-m-d");
  $cek=mysql_query("SELECT * from out_dtbarang_h where btb_nobtb ='$_POST[nobtbsmu]' AND 
				status_bayar='no' AND isvoid='0' AND posted='1'");
  $ada=mysql_num_rows($cek);  
  if($ada<=0)
  {
		$cek1=mysql_query("SELECT * from breakdown,isimanifestin 
where breakdown.id_isimanifestin=isimanifestin.id_isimanifestin AND  breakdown.status_ambil='INSTORE' 
AND isimanifestin.no_smu ='$_POST[nobtbsmu]' 
AND breakdown.status_bayar='no' AND isimanifestin.status_transit='DPS' 
AND breakdown.isvoid='0' AND breakdown.status_check='confirm'");
$p=mysql_fetch_array($cek1);

  	$ada1=mysql_num_rows($cek1);  
  	if($ada1<=0)
		{
				$cek2=mysql_query("SELECT * from breakdown,isimanifestin,manifestin 
where breakdown.id_isimanifestin=isimanifestin.id_isimanifestin AND isimanifestin.id_manifestin=manifestin.id_manifestin AND isimanifestin.no_smu ='$_POST[nobtbsmu]' AND breakdown.isvoid='0'");
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
}

// Input Deliverybillz
elseif ($module=='deliverybill' AND $act=='input'){
$tgl=date("Y-m-d");
	$thn = substr($tgl,0,4);
  //echo($thn);
	$a=mysql_query("select nodb,tglbayar from deliverybill order by id_deliverybill DESC limit 1");
	$b=mysql_fetch_array($a);
	$cthn = substr($b[1],0,4);
	if($cthn<>$thn){$nodb=$thn.'0000000';}
	else {	$nodb=$b[0]+1;}

  if($_POST[id]=='1'){//outgoing
mysql_query("INSERT INTO deliverybill(no_smubtb,document,storage,id_carabayar,lain,tglbayar,user,overtime,hari,status,diskon,keterangan,nosmu,nodb)
  VALUES('$_POST[nosmubtb]','$_POST[document1]','$_POST[storage1]','$_POST[id_carabayar]',
  '$_POST[ppn1]','$tgl','$_SESSION[namauser]','$_POST[overtime1]','$_POST[hari]','1',
	'$_POST[afterdiskon]','$_POST[keterangan]','$_POST[nosmu]','$nodb')");
  
mysql_query("UPDATE out_dtbarang_h set status_bayar='yes',btb_smu='$_POST[nosmu]' where btb_nobtb='$_POST[nosmubtb]'");}
    else { //incoming
mysql_query("INSERT INTO deliverybill(no_smubtb,document,storage,id_carabayar,lain,tglbayar,user,overtime,hari,status,idbreakdown,nosmu,
diskon,keterangan,nodb)
 VALUES('$_POST[nosmubtb]','$_POST[document1]','$_POST[storage1]','$_POST[id_carabayar]',
	'$_POST[ppn1]','$tgl','$_SESSION[namauser]','$_POST[overtime1]','$_POST[hari]','0',
	'$_POST[id_breakdown]','$_POST[nosmu]','$_POST[afterdiskon]','$_POST[keterangan]','$nodb')");
    mysql_query("UPDATE isimanifestin set penerima='$_POST[penerima]',alamatpenerima='$_POST[penerima]' where no_smu='$_POST[nosmubtb]'");
		    mysql_query("UPDATE breakdown set status_bayar='yes' where id_breakdown='$_POST[id_breakdown]'");
				}


    $t=mysql_query("select * from deliverybill order by id_deliverybill DESC limit 1");
		$r=mysql_fetch_array($t);


  header('location:media.php?module=cetakdb&n='.$r[id_deliverybill]);
}


elseif ($module=='cetakdb')
{

$t=mysql_query("SELECT * FROM deliverybill where id_deliverybill='$_GET[n]'");
$r=mysql_fetch_array($t);

if($r[status]=='0')
{
$t=mysql_query("SELECT * FROM deliverybill,isimanifestin,user,breakdown where deliverybill.nosmu=isimanifestin.no_smu AND deliverybill.user=user.id_user AND id_deliverybill='$_GET[n]' AND deliverybill.idbreakdown=breakdown.id_breakdown");
$r=mysql_fetch_array($t);
$nodb='No.DBI-'.$r[nodb];
}
else if($r[status]=='1')
{
$t=mysql_query("SELECT * FROM deliverybill,out_dtbarang_h,out_dtbarang,user where deliverybill.no_smubtb=out_dtbarang_h.btb_nobtb AND out_dtbarang_h.id=out_dtbarang.id_h AND deliverybill.user=user.id_user AND id_deliverybill='$_GET[n]'");
$r=mysql_fetch_array($t);
$nodb='No.DBO-'.$r[nodb];
}		
$totalbayar=$r[overtime]+$r[document]+$r[lain]-$r[diskon];
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

			$pdf->SetFont('times','B',10);
			$pdf->Ln(2);
			$pdf->Cell(60,10,$nodb,0,0,'R',1);
			$pdf->Ln();
			$pdf->SetFont('times','',9);			
			$pdf->Cell(60,4,'PT. GAPURA ANGKASA',0,0,'C',1);$pdf->Ln();
			$pdf->Cell(60,4,'CAB.NGURAH RAI-BALI',0,0,'C',1);$pdf->Ln();
			$pdf->Cell(60,4,'KARGO INTERNATIONAL',0,0,'C',1);$pdf->Ln();
			$pdf->Cell(60,4,'----------------------------------------------------------',0,0,'C',1);$pdf->Ln();						
			$pdf->Cell(60,4,'BUKTI PEMBAYARAN SEWA GUDANG',0,0,'C',1);$pdf->Ln();
			$pdf->Cell(60,4,'----------------------------------------------------------',0,0,'C',1);$pdf->Ln();									
			$pdf->Cell(60,6,'DATA BARANG',0,0,'C',1);$pdf->Ln();
		if($r[status]=='1')
	  { $smu=$r[btb_smu];} 
		else if($r[status=='0'])
		{ $smu=$r[nosmu];}

			$pdf->Cell(30,4,'No.SMU',0,0,'L',1);
//			$pdf->Cell(30,4,': '.$smu,0,0,'L',1);
     		 $pdf->MultiCell(30,4,': '.$smu,0,'L',0);				
	//		$pdf->Ln();	
	if($r[status]=='1')
		{
			$pdf->Cell(30,4,'Tujuan Airport',0,0,'L',1);
			$pdf->Cell(30,4,': '.$r[btb_tujuan],0,0,'L',1);	$pdf->Ln();
		} 
		 else 
		{
			$pdf->Cell(30,4,'Asal Airport',0,0,'L',1);
			$pdf->Cell(30,4,': '.$r[asal],0,0,'L',1);$pdf->Ln();
		}		
			$pdf->Cell(30,4,'Tanggal',0,0,'L',1);
			$pdf->Cell(30,4,': '.ymd2dmy($r[tglbayar]),0,0,'L',1);$pdf->Ln();	
			$pdf->Cell(30,4,'Koli/Berat Aktual',0,0,'L',1);
		if($r[status]=='1')
		 {$pdf->Cell(30,4,': '.$r[btb_totalkoli].' Koli / '.$r[btb_totalberat].' Kg',0,0,'L',1);$pdf->Ln();} 
		 else 
		 {$pdf->Cell(30,4,': '.$r[kolidatang].' Koli / '.$r[beratdatang].' Kg',0,0,'L',1);$pdf->Ln();}	
		$pdf->Cell(30,4,'Berat yang dibayar',0,0,'L',1);
		if($r[status]=='1')
		 {
		 $pdf->Cell(30,4,': '.$r[btb_totalberatbayar].' Kg',0,0,'L',1);;$pdf->Ln();	
			}
		 else if($r[status=='0'])
		 {
 		 $pdf->Cell(30,4,': '.$r[beratbayar].' Kg',0,0,'L',1);;$pdf->Ln();	
		 }				 
		 	 
			$pdf->Cell(30,4,'Komoditi',0,0,'L',1);
		if($r[status]=='1')
		 {$pdf->Cell(30,4,': '.$r[dtBarang_type],0,0,'L',1);$pdf->Ln();} 
		 else 
		 {$pdf->Cell(30,4,': '.$r[jenisbarang],0,0,'L',1);$pdf->Ln();} 	
	 if($r[status]=='1')
		 {			
		 $pdf->Cell(30,4,'Pengirim/Agent',0,0,'L',1);
  		 $pdf->MultiCell(40,4,': '.$r[btb_agent],0,'L',0);		 
		 //$pdf->Cell(40,4,': '.$r[btb_agent],0,0,'L',1);
		 } 
		 else 
 		 {
		 $pdf->Cell(30,4,'Penerima',0,0,'L',1);
  		 $pdf->MultiCell(40,4,': '.$r[penerima],0,'L',0);		 
		// $pdf->Cell(40,4,': '.$r[penerima],0,0,'L',1);$pdf->Ln();
		 }		 
		 		 			$pdf->Cell(60,6,'PERINCIAN BIAYA',0,0,'C',1);$pdf->Ln();
		 		
			$pdf->Cell(30,4,'Jumlah Hari',0,0,'L',1);
			$pdf->Cell(30,4,': '.$r[hari],0,0,'L',1);				
			$pdf->Ln();
	 			
			$pdf->Cell(30,4,'Sewa Gudang',0,0,'L',1);
			$pdf->Cell(30,4,': Rp. '.number_format($r[overtime], 0, '.', '.'),0,0,'L',1);						
			$pdf->Ln();
 
			$pdf->Cell(30,4,'Administrasi',0,0,'L',1);
			$pdf->Cell(40,4,': Rp. '.number_format($r[document], 0, '.', '.'),0,0,'L',1);				
			$pdf->Ln();
		$pdf->Cell(30,4,'Diskon',0,0,'L',1);
			$pdf->Cell(40,4,': Rp. '.number_format($r[diskon], 0, '.', '.'),0,0,'L',1);				
			$pdf->Ln();
	 

			$pdf->Cell(30,4,'PPn(10%)',0,0,'L',1);
			$pdf->Cell(40,4,': Rp. '.number_format($r[lain], 0, '.', '.'),0,0,'L',1);				
			$pdf->Ln();
						
			$pdf->Cell(30,4,'TOTAL ',0,0,'R',1);
			$pdf->Cell(30,4,': Rp. '.number_format($totalbayar, 0, '.', '.'),0,0,'L',1);								
			$pdf->Ln();
			$bilang=terbilang($totalbayar,1);
			$pdf->MultiCell(60,4,'Terbilang : ' .$bilang.' RUPIAH',0,'J',0);				
												
						
			
			$pdf->Ln(5);			

  

		//bikin halaman baru
			
			//siapkan data
		$pdf->SetFont('times','',8);
	$pdf->Cell(30,5,'PT GAPURA ANGKASA',0,0,'L',0);
	$pdf->Cell(30,5,'PENERIMA :',0,0,'C',0);
	$pdf->Ln(15);	
	$pdf->Cell(30,4,$r[nama_lengkap],0,0,'L',0);	
	$pdf->Ln(1);	
	$pdf->Cell(30,4,'--------------------------',0,0,'L',0);	
	$pdf->Cell(30,4,'--------------------------',0,0,'R',0);	

	$pdf->Ln(3);	
	
	$pdf->Cell(30,4,'NIPP. '.$r[nipp],0,0,'C',0);

/*$file = $nodb;
$file .= '.pdf';
//Save PDF to file
$pdf->Output($file, 'F');
//Redirect
header('Location: '.$file);*/
$pdf->Output();
}




elseif ($module=='cetakstockopnamein')
{

	class PDF extends FPDF
	{
		//Page header
		function Header()
		{
			$tglnya=date("Y-m-d");
			$tgl='Kondisi Tanggal : '.ymd2dmy($tglnya);
			$this->SetFont('Arial','B',12);
			$this->Ln(3);
			$this->Cell(180,20,'STOCK OPNAME INCOMING',0,0,'C');
			$this->Ln(10);		
 			$this->SetFont('Arial','B',11);
			$this->Cell(170,20,$tgl,0,0,'C');			
			$this->Ln();
			$this->SetFillColor(255,255,255);
			$this->SetFont('Arial','B',11);
			$this->SetX(10);
			$this->Cell(10,9,'No',1,0,'C',1);
			$this->Cell(50,9,'No.SMU/AWB',1,0,'C',1);
			$this->Cell(20,9,'KOLI',1,0,'C',1);
			$this->Cell(20,9,'KILO',1,0,'C',1);			
			$this->Cell(25,9,'TGL DTNG',1,0,'C',1);			
			$this->Cell(20,9,'FLIGHT',1,0,'C',1);			
			$this->Cell(40,9,'REMARK',1,0,'C',1);
			$this->Ln();			
				
		}
		
		//Page footer
		function Footer()
		{
			//Position at 1.5 cm from bottom
			$this->SetY(-50);
			//Arial italic 8
			$this->SetFont('Arial','I',10);
			//Page number
			$this->Cell(0,10,'GAPURA BALI GAPURA BALI WMS INTER - Page '.$this->PageNo().'/{nb}',0,0,'C');
		}
	}
	
	//Instanciation of inherited class
	$pdf=new PDF('P','mm','A4');
//	$pdf->SetMargins(5,1,5);	
		$pdf->SetMargins(5,10,5);	
	
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
$no=1;

		$tampil=mysql_query("SELECT * FROM breakdown,isimanifestin,manifestin where 
		breakdown.id_isimanifestin=isimanifestin.id_isimanifestin AND isimanifestin.id_manifestin=manifestin.id_manifestin AND
		breakdown.isvoid='0' AND 
		breakdown.status_ambil='INSTORE' AND breakdown.b_iscancel='0' 
		AND breakdown.status_check='confirm' GROUP BY isimanifestin.id_isimanifestin");
   $pdf->Header($tgl);
    $pdf->AddPage();

  

		//bikin halaman baru
			
			//siapkan data
			$koli=0;$berat=0;
			  while ($r=mysql_fetch_array($tampil)){
				$no_smu = $r['no_smu'];
				$berat_datang = $r['beratdatang'];
				$koli_datang = $r['kolidatang'];
				$tgldatang = ymd2dmy($r['tgldatang']);		
				$pdf->SetFillColor(255,255,255);
				$pdf->SetFont('Arial','',12);
				$pdf->SetX(10);
				$pdf->Cell(10,5,$no,1,0,'L',1);
				$pdf->Cell(50,5,$no_smu,1,0,'L',1);	
				$pdf->Cell(20,5,$koli_datang,1,0,'C',1);					
				$pdf->Cell(20,5,$berat_datang,1,0,'C',1);	
				$pdf->Cell(25,5,$tgldatang,1,0,'C',1);	
				$pdf->Cell(20,5,$r['noflight'],1,0,'C',1);									
				$pdf->Cell(40,5,'',1,0,'C',1);	
				$koli=$koli+$koli_datang;
				$berat=$berat+$berat_datang;
				
				$pdf->Ln();
				$no+=1;

			}
							$pdf->Ln(2);	
				$pdf->SetX(10);		
				$pdf->Cell(10,5,'',0,0,'L',0);
				$pdf->Cell(50,5,'TOTAL : ',0,0,'R',1);	
				$pdf->Cell(20,5,$koli,1,0,'C',1);					
				$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'C',1);	
				$pdf->Cell(25,5,'',0,0,'C',0);					
				$pdf->Cell(20,5,'',0,0,'C',0);									
				$pdf->Cell(40,5,'',0,0,'C',0);	
				$pdf->Ln(30);			
	$pdf->Cell(40,8,'CHECKED : ',0,0,'C',1);			
	$pdf->Output();


}
//===============================end of kasirlapcetakk


elseif($module=='putus')
{
while($i<=2521)
  {
	$nodb=20089999999+$i;
	mysql_query("update deliverybill set nodb='$nodb' where id_deliverybill='$i'");
  $i++;
  }

}

elseif ($module=='kasirlapcetak')
{
$tglawal=my2date($_POST[tglawal]);

/*utk nambah no DB
while($i<=1148)
  {
	$nodb=20089999999+$i;
	mysql_query("update deliverybill set nodb='$nodb' where id_deliverybill='$i'");
  $i++;
  }
*/
//TUTUP DULU
//pisahkan dulu table outbarang dan outbarang_h dulu biar cepet
mysql_query("DELETE FROM out_dtbarang_h_tmp");
mysql_query("INSERT INTO out_dtbarang_h_tmp SELECT out_dtbarang_h.* FROM out_dtbarang_h,deliverybill where out_dtbarang_h.isvoid='0' AND out_dtbarang_h.btb_nobtb=deliverybill.no_smubtb AND deliverybill.tglbayar='$tglawal'");

mysql_query("DELETE FROM out_dtbarang_tmp");
mysql_query("INSERT INTO out_dtbarang_tmp SELECT out_dtbarang.* FROM out_dtbarang,out_dtbarang_h_tmp,deliverybill where out_dtbarang_h_tmp.btb_nobtb=deliverybill.no_smubtb AND deliverybill.tglbayar='$tglawal'  AND out_dtbarang_h_tmp.id=out_dtbarang.id_h");

mysql_query("DELETE FROM isimanifestin_tmp");
mysql_query("INSERT INTO isimanifestin_tmp SELECT isimanifestin.* FROM isimanifestin,deliverybill where isimanifestin.isvoid='0' AND isimanifestin.no_smu=deliverybill.nosmu AND deliverybill.tglbayar='$tglawal'");

mysql_query("DELETE FROM breakdown_tmp");
mysql_query("INSERT INTO breakdown_tmp 
SELECT breakdown.* FROM breakdown,deliverybill
where deliverybill.idbreakdown=breakdown.id_breakdown
AND deliverybill.tglbayar='$tglawal' AND breakdown.b_iscancel='0'");

mysql_query("DELETE FROM deliverybill_tmp");
mysql_query("INSERT INTO deliverybill_tmp 
SELECT deliverybill.* FROM deliverybill 
where deliverybill.tglbayar='$tglawal'");

mysql_query("DELETE FROM manifestin_tmp");
mysql_query("INSERT INTO manifestin_tmp
select manifestin.* from deliverybill,breakdown_tmp,manifestin
where deliverybill.idbreakdown=breakdown_tmp.id_breakdown
AND deliverybill.tglbayar='$tglawal'
AND breakdown_tmp.id_manifestin=manifestin.id_manifestin
GROUP by id_manifestin");


	class PDF extends FPDF
	{
		//Page header
		function Header()
		{	
		//$this->SetLeftMargin(10);		
			$this->SetFillColor(255,255,255);	
//			$this->SetX(100);
			$this->SetFont('Arial','B',14);
			//$this->Ln();
			$this->Cell(190,20,'LAPORAN PENDAPATAN SEWA CARGO INTERNATIONAL',0,0,'L');
			$this->Ln();			
			$this->SetFont('Times','I',11);
			$this->Cell(190,8,'Tanggal : '.$_POST[tglawal],0,0,'L',1);
			$this->Ln();						
			$this->Cell(190,8,'Tipe Bayar : '.$_POST[cara_bayar],0,0,'L',1);			
			$this->Ln(10);			
				
		}
		
		//Page footer
		function Footer()
		{
			//Position at 1.5 cm from bottom
			$k=mysql_query("SELECT nama_lengkap,nipp FROM user where id_user='$_SESSION[namauser]'");
			$ka=mysql_fetch_array($k);
			$kasir=$ka[0];$nipp=$ka[1];
			$this->SetY(-105);
			$this->SetFont('Arial','',10);
			$this->Ln(7);
			$this->Cell(60,8,'Diperiksa oleh : ',0,0,'C',1);
			$this->Cell(60,8,'',0,0,'C',1);	
			$this->Cell(60,8,'Dibuat oleh : ',0,0,'C',1);
			$this->Ln(15);
			$this->Cell(60,8,'',0,0,'C',1);				
			$this->Cell(60,8,'',0,0,'C',1);			
			$this->Cell(60,8,$kasir,0,0,'C',1);	
			$this->Ln(5);
				
			$this->SetFont('Arial','I',9);
			//Page number
			$this->Cell(0,10,'GAPURA BALI WMS INTER - Page '.$this->PageNo().'/{nb}',0,0,'C');
		}
	}
	
	//Instanciation of inherited class
	$pdf=new PDF('P','mm','A4');
//	$pdf->SetMargins(5,1,5);	
		$pdf->SetMargins(5,1,5);	
	
	$pdf->AliasNbPages();
	//buka file
	$pdf->Open();
	
	//Disable automatic page break
	$pdf->SetAutoPageBreak(on,100);
	
	//set nilai posisi y pada setiap halaman
	$y_axis_initial = 32;
	$y_axis1 = 32;
	//tinggi baris
	$row_height = 6;	
	
	$y_axis = 32; // $y_axis_initial + $row_height;



//cek untuk pebayarannya
if($_POST[cara_bayar]=='CASH')
{$carabayar='CASH';} 
else if($_POST[cara_bayar]=='PERIODICAL') 
{$carabayar='PERIODICAL';}
else if($_POST[cara_bayar]=='SEMUA')
{$carabayar='';}

//cek utk prosesnya
if($_POST[outin]=='EXPORT')
{$outin=1;} 
else if($_POST[outin]=='IMPORT') 
{$outin=0;}
else if($_POST[outin]=='SEMUA')
{$outin=2;}


if($_POST[bt_preview]=='DETIL')
{
//ambil dulu data airline yang ada
$a1='select airlinecode,airlinename from airline order by airlinename';


//proses dulu jika ingin incoming dan outgoing (SEMUA)
if($outin=='2')
{
//============== incoming===============
/*mysql_query("DELETE FROM dailytmp");
mysql_query("INSERT INTO dailytmp 
select deliverybill_tmp.nosmu,breakdown_tmp.beratdatang, deliverybill_tmp.hari,deliverybill_tmp.overtime,
deliverybill_tmp.document,deliverybill_tmp.lain,deliverybill_tmp.id_deliverybill, 
deliverybill_tmp.id_carabayar,
manifestin_tmp.airline,isimanifestin_tmp.agent,deliverybill_tmp.isvoid,deliverybill_tmp.keterangan,
deliverybill_tmp.tglvoid,deliverybill_tmp.nodb,deliverybill_tmp.diskon
from breakdown_tmp,deliverybill_tmp,isimanifestin_tmp,manifestin_tmp
where deliverybill_tmp.idbreakdown=breakdown_tmp.id_breakdown 
AND deliverybill_tmp.status='0' 
AND breakdown_tmp.id_isimanifestin=isimanifestin_tmp.id_isimanifestin
AND isimanifestin_tmp.id_manifestin=manifestin_tmp.id_manifestin AND 
deliverybill_tmp.id_carabayar like '%$carabayar%'
GROUP by deliverybill_tmp.nodb");	*/
mysql_query("DELETE FROM dailytmp");
mysql_query("INSERT INTO dailytmp 
select deliverybill.nosmu,breakdown.beratdatang, deliverybill.hari,deliverybill.overtime,
deliverybill.document,deliverybill.lain,deliverybill.id_deliverybill, 
deliverybill.id_carabayar,
manifestin.airline,isimanifestin.agent,deliverybill.isvoid,deliverybill.keterangan,
deliverybill.tglvoid,deliverybill.nodb,deliverybill.diskon
from breakdown,deliverybill,isimanifestin,manifestin
where deliverybill.idbreakdown=breakdown.id_breakdown 
AND deliverybill.status='0' 
AND breakdown.id_isimanifestin=isimanifestin.id_isimanifestin
AND isimanifestin.id_manifestin=manifestin.id_manifestin AND deliverybill.id_carabayar like '%$carabayar%'
AND deliverybill.tglbayar='$tglawal' GROUP by deliverybill.nodb");	

	//cek dulu jenis2x airline yang ada pada incoming
	$air1=mysql_query("select airline from dailytmp where agent='' GROUP by airline");
	while($airline=mysql_fetch_array($air1))//mulai utk masing-masing airline
	{
		$no=1;
		//incoming dulu
		$str=mysql_query("select * from dailytmp where airline='$airline[0]' AND agent='' 
		ORDER BY id_deliverybill ASC");		
		$pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',12);$pdf->Cell(170,8,'IMPORT',0,0,'L',1);	
		$pdf->Ln();
		$pdf->SetFont('Arial','B',10);			
		$pdf->Cell(15,8,$airline[0],1,0,'C',1);
		$pdf->Cell(35,8,'NO.SMU/AWB',1,0,'C',1);
		$pdf->Cell(20,8,'Berat(Kg)',1,0,'C',1);
		$pdf->Cell(10,8,'Hari',1,0,'C',1);
		$pdf->Cell(25,8,'S_Gudang',1,0,'C',1);
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Cell(30,8,'No. DB',1,0,'C',1);
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);	
		}
		else//jika untuk Angkasa Pura
		{
			//$pdf->Cell(20,8,'PPn',1,0,'C',1);
			//$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Cell(30,8,'No. DB',1,0,'C',1);
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);	
		}				
		$berat=0;$sewagudang=0;
		$adm=0;$ppn=0;$hari=0;$total1=0;	
			
		//mulai query untuk incoming
		while ($r=mysql_fetch_array($str))
		{
		$nodb='I-'.$r[nodb];
				if($r[isvoid]=='1')
				{$brt=0;$hr=0;} else {$brt=$r[berat];$hr=$r[hari];}


			$total=$r[sewagudang]+$r[adm]+$r[ppn]-$r[diskon];				
			$pdf->Cell(15,5,$no,1,0,'R',1);			
			$pdf->Cell(35,5,$r[nosmu],1,0,'C',1);	
			if($r[isvoid]=='1')
				{
			$pdf->Cell(20,5,'0',1,0,'R',1);
			$pdf->Cell(10,5,'0',1,0,'R',1);				
				}
				else
				{
			$pdf->Cell(20,5,number_format($brt, 1, ',', '.'),1,0,'R',1);
			$pdf->Cell(10,5,$hr,1,0,'R',1);
				}			


			$pdf->Cell(25,5,number_format($r[sewagudang]-$r[diskon], 0, '.', '.'),1,0,'R',1);
		
			if($_POST[untuk]=='gp')
			{
				
				$pdf->Cell(20,5,number_format($r[adm], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(20,5,number_format($r[ppn], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
				if($r[isvoid]=='1'){$pdf->Cell(30,5,'(V)'.$nodb,1,0,'R',1);}	
				else {$pdf->Cell(30,5,$nodb,1,0,'R',1);}				
				$pdf->Ln();
			}
			else
			{
				//$pdf->Cell(20,5,number_format($r[ppn], 0, '.', '.'),1,0,'R',1);
				//$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
				if($r[isvoid]=='1'){$pdf->Cell(30,5,'(V)'.$nodb,1,0,'R',1);}	
				else {$pdf->Cell(30,5,$nodb,1,0,'R',1);}					
				$pdf->Ln();
			}
			$berat=$berat+$brt;
			$sewagudang=$sewagudang+$r[sewagudang];
			$adm=$adm+$r[adm];
			$ppn=$ppn+$r[ppn];
			$hari=$hari+$hr;
			$total1=$total1+$total;
			
			
			$no+=1;
		} //AKHIR DARI ISI TABEL
	//totalnya
	$pdf->Ln(2);
	$pdf->Cell(15,5,'',0,0,'R',1);		
	$pdf->Cell(35,5,'TOTAL :',0,0,'C',1);
	$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(10,5,$hari,1,0,'R',1);
	$pdf->Cell(25,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);
	if($_POST[untuk]=='gp')
	{
		$pdf->Cell(20,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		//$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}			
	}
	//
	//cek dulu jenis2x agent yang ada pada incoming
	$str1=mysql_query("select agent from dailytmp 
	where agent<>'' GROUP by agent");
	while ($ag=mysql_fetch_array($str1))
	{
	$no=1;
	$str=mysql_query("select * from dailytmp where 
	agent='$ag[0]' 
	ORDER BY id_deliverybill ASC");	
	$pdf->AddPage();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',12);$pdf->Cell(170,8,'IMPORT',0,0,'L',1);	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);			
	$pdf->Cell(15,8,$ag[0],1,0,'C',1);
	$pdf->Cell(35,8,'NO.SMU/AWB',1,0,'C',1);
	$pdf->Cell(20,8,'Berat(Kg)',1,0,'C',1);
	$pdf->Cell(10,8,'Hari',1,0,'C',1);
	$pdf->Cell(25,8,'S_Gudang',1,0,'C',1);
		
	if($_POST[untuk]=='gp')//jikauntuk internal Gapura
	{
		$pdf->Cell(20,8,'Adm',1,0,'C',1);
		$pdf->Cell(20,8,'PPn',1,0,'C',1);
		$pdf->Cell(25,8,'Total',1,0,'C',1);			
		$pdf->Cell(30,8,'No. DB',1,0,'C',1);
		$pdf->Ln();
		$pdf->SetFont('Arial','',10);	
	}
	else//jika untuk Angkasa Pura
	{
		//$pdf->Cell(20,8,'PPn',1,0,'C',1);
		//$pdf->Cell(25,8,'Total',1,0,'C',1);			
		$pdf->Cell(30,8,'No. DB',1,0,'C',1);
		$pdf->Ln();
		$pdf->SetFont('Arial','',10);	
	}				
	$berat=0;$sewagudang=0;
	$adm=0;$ppn=0;$hari=0;$total1=0;	
		
	//mulai query untuk incoming
	while ($r=mysql_fetch_array($str))
	{
	$nodb='I-'.$r[nodb];
		if($r[isvoid]=='1'){$brt=0;$total=0;$hr=0;}
		else {
		$total=$r[sewagudang]+$r[adm]+$r[ppn]-$r[diskon];	
		$brt=$r[berat];
		$hr=$r[hari];			
		}
		$pdf->Cell(15,5,$no,1,0,'R',1);			
		$pdf->Cell(35,5,$r[nosmu],1,0,'C',1);
		$pdf->Cell(20,5,number_format($brt, 1, ',', '.'),1,0,'R',1);
		$pdf->Cell(10,5,$r[hari],1,0,'R',1);
		$pdf->Cell(25,5,number_format($r[sewagudang]-$r[diskon], 0, '.', '.'),1,0,'R',1);
		if($_POST[untuk]=='gp')
		{
			
			$pdf->Cell(20,5,number_format($r[adm], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,5,number_format($r[ppn], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);		
			if($r[isvoid]=='1'){$pdf->Cell(30,5,'(V)'.$nodb,1,0,'R',1);}	
			else {$pdf->Cell(30,5,$nodb,1,0,'R',1);}								
			$pdf->Ln();
		}
		else
		{
		//	$pdf->Cell(20,5,number_format($r[ppn], 0, '.', '.'),1,0,'R',1);
			//$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
			if($r[isvoid]=='1'){$pdf->Cell(30,5,'(V)'.$nodb,1,0,'R',1);}	
			else {$pdf->Cell(30,5,$nodb,1,0,'R',1);}		
			$pdf->Ln();
		}
		$berat=$berat+$brt;
		$sewagudang=$sewagudang+$r[sewagudang];
		$adm=$adm+$r[adm];
		$ppn=$ppn+$r[ppn];
		$hari=$hari+$r[hari];
		$total1=$total1+$total;

		$no+=1;
	}
	//totalnya
	$pdf->Ln(2);
	$pdf->Cell(15,5,'',0,0,'R',1);		
	$pdf->Cell(35,5,'TOTAL :',0,0,'C',1);
	$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(10,5,$hari,1,0,'R',1);
	$pdf->Cell(25,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);
	if($_POST[untuk]=='gp')
	{
		$pdf->Cell(20,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);						
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		//$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);						
		$pdf->Ln();
	}			

	}
//============== outgoing ==============
/*mysql_query("DELETE FROM dailytmp");
mysql_query("INSERT INTO dailytmp 
select out_dtbarang_h_tmp.btb_smu,out_dtbarang_h_tmp.btb_totalberat, 
deliverybill_tmp.hari,deliverybill_tmp.overtime,deliverybill_tmp.document,
deliverybill_tmp.lain,deliverybill_tmp.id_deliverybill, 
deliverybill_tmp.id_carabayar,out_dtbarang_h_tmp.airline,out_dtbarang_h_tmp.btb_agent,
deliverybill_tmp.isvoid,deliverybill_tmp.keterangan,deliverybill_tmp.tglvoid,
deliverybill_tmp.nodb,deliverybill_tmp.diskon
from out_dtbarang_h_tmp,deliverybill_tmp 
where deliverybill_tmp.no_smubtb=out_dtbarang_h_tmp.btb_nobtb AND deliverybill_tmp.status='1' AND 
deliverybill_tmp.id_carabayar like '%$carabayar%'
group by deliverybill_tmp.nodb");	*/
mysql_query("DELETE FROM dailytmp");
mysql_query("INSERT INTO dailytmp 
select out_dtbarang_h.btb_smu,out_dtbarang_h.btb_totalberat, 
deliverybill.hari,deliverybill.overtime,deliverybill.document,
deliverybill.lain,deliverybill.id_deliverybill, 
deliverybill.id_carabayar,out_dtbarang_h.airline,out_dtbarang_h.btb_agent,
deliverybill.isvoid,deliverybill.keterangan,deliverybill.tglvoid,
deliverybill.nodb,deliverybill.diskon
from out_dtbarang_h,deliverybill 
where deliverybill.no_smubtb=out_dtbarang_h.btb_nobtb AND deliverybill.id_carabayar like '%$carabayar%' AND deliverybill.status='1' AND deliverybill.tglbayar='$tglawal' group by deliverybill.nodb");	


	//cek dulu jenis2x airline yang ada pada incoming
$air1=mysql_query("select airline from dailytmp 
	where ((agent<>'GMFAA') AND (agent<>'ACS') AND (agent<>'POST') AND(agent<>'POS') AND (agent<>'QATAR')) 	GROUP by airline");
	while($airline=mysql_fetch_array($air1))//mulai utk masing-masing airline
	{
		$no=1;
		//outgoing
		$str=mysql_query("select * from dailytmp where airline='$airline[0]' 
		and ((agent<>'GMFAA') AND (agent<>'ACS') AND (agent<>'POST') AND(agent<>'POS') AND (agent<>'QATAR')) ORDER BY id_deliverybill ASC");
	
		$pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',12);$pdf->Cell(170,8,'EXPORT',0,0,'L',1);	
		$pdf->Ln();
		$pdf->SetFont('Arial','B',10);			
		$pdf->Cell(15,8,$airline[0],1,0,'C',1);
		$pdf->Cell(35,8,'NO.SMU/AWB',1,0,'C',1);
		$pdf->Cell(20,8,'Berat(Kg)',1,0,'C',1);
		$pdf->Cell(10,8,'Hari',1,0,'C',1);
		$pdf->Cell(25,8,'S_Gudang',1,0,'C',1);
		
		
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Cell(30,8,'No. DB',1,0,'C',1);
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);	
		}
		else//jika untuk Angkasa Pura
		{
		//	$pdf->Cell(20,8,'PPn',1,0,'C',1);
		//	$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Cell(30,8,'No. DB',1,0,'C',1);
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);	
		}				
		$berat=0;$sewagudang=0;
		$adm=0;$ppn=0;$hari=0;$total1=0;	
			
		//mulai query untuk outgoing
		while ($r=mysql_fetch_array($str))
		{
		$nodb='O-'.$r[nodb];
		if($r[isvoid]=='1'){$brt=0;$total=0;$hr=0;}
		else {
		$total=$r[sewagudang]+$r[adm]+$r[ppn]-$r[diskon];
		$brt=$r[berat];
		$hr=$r[hari];			
		}		
		
			$total=$r[sewagudang]+$r[adm]+$r[ppn]-$r[diskon];			
			$pdf->Cell(15,5,$no,1,0,'R',1);			
			$pdf->Cell(35,5,$r[nosmu],1,0,'C',1);	
			if($r[isvoid]=='1')
				{
			$pdf->Cell(20,5,'0',1,0,'R',1);
			$pdf->Cell(10,5,'0',1,0,'R',1);				
				}
				else
				{
			$pdf->Cell(20,5,number_format($brt, 1, ',', '.'),1,0,'R',1);
			$pdf->Cell(10,5,$hr,1,0,'R',1);
				}			


			$pdf->Cell(25,5,number_format($r[sewagudang]-$r[diskon], 0, '.', '.'),1,0,'R',1);
		
			if($_POST[untuk]=='gp')
			{
				$pdf->Cell(20,5,number_format($r[adm], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(20,5,number_format($r[ppn], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
				if($r[isvoid]=='1'){$pdf->Cell(30,5,'(V)'.$nodb,1,0,'R',1);}	
				else {$pdf->Cell(30,5,$nodb,1,0,'R',1);}				
				$pdf->Ln();
			}
			else
			{
			//	$pdf->Cell(20,5,number_format($r[lain], 0, '.', '.'),1,0,'R',1);
			//	$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
				if($r[isvoid]=='1'){$pdf->Cell(30,5,'(V)'.$nodb,1,0,'R',1);}	
				else {$pdf->Cell(30,5,$nodb,1,0,'R',1);}					
				$pdf->Ln();
			}
			$berat=$berat+$brt;
			$sewagudang=$sewagudang+$r[sewagudang];
			$adm=$adm+$r[adm];
			$ppn=$ppn+$r[ppn];
			$hari=$hari+$hr;
			$total1=$total1+$total;
			
			
			
				$no+=1;
		} //AKHIR DARI ISI TABEL
	//totalnya
	$pdf->Ln(2);
	$pdf->Cell(15,5,'',0,0,'R',1);		
	$pdf->Cell(35,5,'TOTAL :',0,0,'C',1);
	$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(10,5,$hari,1,0,'R',1);
	$pdf->Cell(25,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);
	if($_POST[untuk]=='gp')
	{
		$pdf->Cell(20,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
	//	$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
	//	$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}			
	}
	//
	//cek dulu jenis2x agent yang ada pada outgoing
	$str1=mysql_query("select agent from dailytmp 
	where ((agent='GMFAA')OR(agent='ACS')OR(agent='POST')OR(agent='POS') OR (agent='QATAR')) GROUP by agent");

	while ($ag=mysql_fetch_array($str1))
	{
	
	$no=1;

	$str=mysql_query("select * from dailytmp where 
	agent='$ag[0]' ORDER BY id_deliverybill ASC");

	$pdf->AddPage();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',12);$pdf->Cell(170,8,'EXPORT',0,0,'L',1);	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);			
	$pdf->Cell(15,8,$ag[0],1,0,'C',1);
	$pdf->Cell(35,8,'NO.SMU/AWB',1,0,'C',1);
	$pdf->Cell(20,8,'Berat(Kg)',1,0,'C',1);
	$pdf->Cell(10,8,'Hari',1,0,'C',1);
	$pdf->Cell(25,8,'S_Gudang',1,0,'C',1);
		
	if($_POST[untuk]=='gp')//jikauntuk internal Gapura
	{
		$pdf->Cell(20,8,'Adm',1,0,'C',1);
		$pdf->Cell(20,8,'PPn',1,0,'C',1);
		$pdf->Cell(25,8,'Total',1,0,'C',1);			
		$pdf->Cell(30,8,'No. DB',1,0,'C',1);
		$pdf->Ln();
		$pdf->SetFont('Arial','',10);	
	}
	else//jika untuk Angkasa Pura
	{
	//	$pdf->Cell(20,8,'PPn',1,0,'C',1);
	//	$pdf->Cell(25,8,'Total',1,0,'C',1);			
		$pdf->Cell(30,8,'No. DB',1,0,'C',1);
		$pdf->Ln();
		$pdf->SetFont('Arial','',10);	
	}				
	$berat=0;$sewagudang=0;
	$adm=0;$ppn=0;$hari=0;$total1=0;	
		
	//mulai query untuk incoming
	while ($r=mysql_fetch_array($str))
	{
	$nodb='O-'.$r[nodb];
		$kasir=$r[nama_lengkap];
		if($r[isvoid]=='1'){$brt=0;$total=0;$hr=0;}
		else {
		$total=$r[sewagudang]+$r[adm]+$r[ppn]-$r[diskon];
		$brt=$r[berat];
		$hr=$r[hari];			
		}
		$pdf->Cell(15,5,$no,1,0,'R',1);			
		$pdf->Cell(35,5,$r[nosmu],1,0,'C',1);
		$pdf->Cell(20,5,number_format($brt, 1, ',', '.'),1,0,'R',1);
		$pdf->Cell(10,5,$r[hari],1,0,'R',1);
		$pdf->Cell(25,5,number_format($r[sewagudang]-$r[diskon], 0, '.', '.'),1,0,'R',1);
		if($_POST[untuk]=='gp')
		{
			
			$pdf->Cell(20,5,number_format($r[adm], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,5,number_format($r[ppn], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);		
			if($r[isvoid]=='1'){$pdf->Cell(30,5,'(V)'.$nodb,1,0,'R',1);}	
			else {$pdf->Cell(30,5,$nodb,1,0,'R',1);}								
			$pdf->Ln();
		}
		else
		{
	//		$pdf->Cell(20,5,number_format($r[ppn], 0, '.', '.'),1,0,'R',1);
	//		$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
			if($r[isvoid]=='1'){$pdf->Cell(30,5,'(V)'.$nodb,1,0,'R',1);}	
			else {$pdf->Cell(30,5,$nodb,1,0,'R',1);}		
			$pdf->Ln();
		}
		$berat=$berat+$brt;
		$sewagudang=$sewagudang+$r[sewagudang];
		$adm=$adm+$r[adm];
		$ppn=$ppn+$r[ppn];
		$hari=$hari+$r[hari];
		$total1=$total1+$total;

		$no+=1;
	}
	//totalnya
	$pdf->Ln(2);
	$pdf->Cell(15,5,'',0,0,'R',1);		
	$pdf->Cell(35,5,'TOTAL :',0,0,'C',1);
	$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(10,5,$hari,1,0,'R',1);
	$pdf->Cell(25,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);
	if($_POST[untuk]=='gp')
	{
		$pdf->Cell(20,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);						
		$pdf->Ln();
	}
	else
	{
	//	$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
	//	$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);						
		$pdf->Ln();
	}			
	}
	
	
}
else if($outin=='0')////incoming daily
{
mysql_query("DELETE FROM dailytmp");
mysql_query("INSERT INTO dailytmp 
select deliverybill.nosmu,breakdown.beratdatang, deliverybill.hari,deliverybill.overtime,
deliverybill.document,deliverybill.lain,deliverybill.id_deliverybill, 
deliverybill.id_carabayar,
manifestin.airline,isimanifestin.agent,deliverybill.isvoid,deliverybill.keterangan,
deliverybill.tglvoid,deliverybill.nodb,deliverybill.diskon
from breakdown,deliverybill,isimanifestin,manifestin
where deliverybill.idbreakdown=breakdown.id_breakdown 
AND deliverybill.status='0' 
AND breakdown.id_isimanifestin=isimanifestin.id_isimanifestin
AND isimanifestin.id_manifestin=manifestin.id_manifestin AND deliverybill.id_carabayar like '%$carabayar%' 
AND deliverybill.tglbayar='$tglawal'
GROUP by deliverybill.nodb");	

	//cek dulu jenis2x airline yang ada pada incoming
	$air1=mysql_query("select airline from dailytmp where agent='' GROUP by airline");
	while($airline=mysql_fetch_array($air1))//mulai utk masing-masing airline
	{
		$no=1;
		//incoming dulu
		$str=mysql_query("select * from dailytmp where 
		airline='$airline[0]' AND agent='' 
		ORDER BY id_deliverybill ASC");		
		$pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',12);$pdf->Cell(170,8,'IMPORT',0,0,'L',1);	
		$pdf->Ln();
		$pdf->SetFont('Arial','B',10);			
		$pdf->Cell(15,8,$airline[0],1,0,'C',1);
		$pdf->Cell(35,8,'NO.SMU/AWB',1,0,'C',1);
		$pdf->Cell(20,8,'Berat(Kg)',1,0,'C',1);
		$pdf->Cell(10,8,'Hari',1,0,'C',1);
		$pdf->Cell(25,8,'S_Gudang',1,0,'C',1);
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Cell(30,8,'No. DB',1,0,'C',1);
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);	
		}
		else//jika untuk Angkasa Pura
		{
		//	$pdf->Cell(20,8,'PPn',1,0,'C',1);
		//	$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Cell(30,8,'No. DB',1,0,'C',1);
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);	
		}				
		$berat=0;$sewagudang=0;
		$adm=0;$ppn=0;$hari=0;$total1=0;	
			
		//mulai query untuk incoming
		while ($r=mysql_fetch_array($str))
		{
				$nodb='I-'.$r[nodb];
				if($r[isvoid]=='1')
				{$brt=0;$hr=0;} else {$brt=$r[berat];$hr=$r[hari];}


			$total=$r[sewagudang]+$r[adm]+$r[ppn]-$r[diskon];			
			$pdf->Cell(15,5,$no,1,0,'R',1);			
			$pdf->Cell(35,5,$r[nosmu],1,0,'C',1);	
			if($r[isvoid]=='1')
				{
			$pdf->Cell(20,5,'0',1,0,'R',1);
			$pdf->Cell(10,5,'0',1,0,'R',1);				
				}
				else
				{
			$pdf->Cell(20,5,number_format($brt, 1, ',', '.'),1,0,'R',1);
			$pdf->Cell(10,5,$hr,1,0,'R',1);
				}			


			$pdf->Cell(25,5,number_format($r[sewagudang]-$r[diskon], 0, '.', '.'),1,0,'R',1);
		
			if($_POST[untuk]=='gp')
			{
				
				$pdf->Cell(20,5,number_format($r[adm], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(20,5,number_format($r[ppn], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
				if($r[isvoid]=='1'){$pdf->Cell(30,5,'(V)'.$nodb,1,0,'R',1);}	
				else {$pdf->Cell(30,5,$nodb,1,0,'R',1);}				
				$pdf->Ln();
			}
			else
			{
		//		$pdf->Cell(20,5,number_format($r[ppn], 0, '.', '.'),1,0,'R',1);
		//		$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
				if($r[isvoid]=='1'){$pdf->Cell(30,5,'(V)'.$nodb,1,0,'R',1);}	
				else {$pdf->Cell(30,5,$nodb,1,0,'R',1);}					
				$pdf->Ln();
			}
			$berat=$berat+$brt;
			$sewagudang=$sewagudang+$r[sewagudang];
			$adm=$adm+$r[adm];
			$ppn=$ppn+$r[ppn];
			$hari=$hari+$hr;
			$total1=$total1+$total;
			
			

				$no+=1;
		} //AKHIR DARI ISI TABEL
	//totalnya
	$pdf->Ln(2);
	$pdf->Cell(15,5,'',0,0,'R',1);		
	$pdf->Cell(35,5,'TOTAL :',0,0,'C',1);
	$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(10,5,$hari,1,0,'R',1);
	$pdf->Cell(25,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);
	if($_POST[untuk]=='gp')
	{
		$pdf->Cell(20,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
	//	$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
	//	$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}			
	}
	//
	//cek dulu jenis2x agent yang ada pada incoming
	$str1=mysql_query("select agent from dailytmp 
	where agent<>'' GROUP by agent");
	while ($ag=mysql_fetch_array($str1))
	{
	$no=1;
	$str=mysql_query("select * from dailytmp where 
	agent='$ag[0]' 
	ORDER BY id_deliverybill ASC");	
	$pdf->AddPage();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',12);$pdf->Cell(170,8,'IMPORT',0,0,'L',1);	
	$pdf->Ln();
	$pdf->SetFont('Times','I',11);$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal],0,0,'L',1);
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);			
	$pdf->Cell(15,8,$ag[0],1,0,'C',1);
	$pdf->Cell(35,8,'NO.SMU/AWB',1,0,'C',1);
	$pdf->Cell(20,8,'Berat(Kg)',1,0,'C',1);
	$pdf->Cell(10,8,'Hari',1,0,'C',1);
	$pdf->Cell(25,8,'S_Gudang',1,0,'C',1);
		
	if($_POST[untuk]=='gp')//jikauntuk internal Gapura
	{
		$pdf->Cell(20,8,'Adm',1,0,'C',1);
		$pdf->Cell(20,8,'PPn',1,0,'C',1);
		$pdf->Cell(25,8,'Total',1,0,'C',1);			
		$pdf->Cell(30,8,'No. DB',1,0,'C',1);
		$pdf->Ln();
		$pdf->SetFont('Arial','',10);	
	}
	else//jika untuk Angkasa Pura
	{
	//	$pdf->Cell(20,8,'PPn',1,0,'C',1);
	//	$pdf->Cell(25,8,'Total',1,0,'C',1);			
		$pdf->Cell(30,8,'No. DB',1,0,'C',1);
		$pdf->Ln();
		$pdf->SetFont('Arial','',10);	
	}				
	$berat=0;$sewagudang=0;
	$adm=0;$ppn=0;$hari=0;$total1=0;	
		
	//mulai query untuk incoming
	while ($r=mysql_fetch_array($str))
	{
			$nodb='I-'.$r[nodb];
		if($r[isvoid]=='1'){$brt=0;$total=0;$hr=0;}
		else {
		$total=$r[sewagudang]+$r[adm]+$r[ppn]-$r[diskon];
		$brt=$r[berat];
		$hr=$r[hari];			
		}
		$pdf->Cell(15,5,$no,1,0,'R',1);	$pdf->Cell(35,5,$r[nosmu],1,0,'C',1);
		$pdf->Cell(20,5,number_format($brt, 1, ',', '.'),1,0,'R',1);
		$pdf->Cell(10,5,$r[hari],1,0,'R',1);
		$pdf->Cell(25,5,number_format($r[sewagudang]-$r[diskon], 0, '.', '.'),1,0,'R',1);
		if($_POST[untuk]=='gp')
		{
			$pdf->Cell(20,5,number_format($r[adm], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,5,number_format($r[ppn], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);		
			if($r[isvoid]=='1'){$pdf->Cell(30,5,'(V)'.$nodb,1,0,'R',1);}	
			else {$pdf->Cell(30,5,$nodb,1,0,'R',1);}								
			$pdf->Ln();
		}
		else
		{
		//	$pdf->Cell(20,5,number_format($r[ppn], 0, '.', '.'),1,0,'R',1);
	//		$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
			if($r[isvoid]=='1'){$pdf->Cell(30,5,'(V)'.$nodb,1,0,'R',1);}	
			else {$pdf->Cell(30,5,$nodb,1,0,'R',1);}		
			$pdf->Ln();
		}
		$berat=$berat+$brt;
		$sewagudang=$sewagudang+$r[sewagudang];
		$adm=$adm+$r[adm];
		$ppn=$ppn+$r[ppn];
		$hari=$hari+$r[hari];
		$total1=$total1+$total;

		$no+=1;
	}
	//totalnya
	$pdf->Ln(2);
	$pdf->Cell(15,5,'',0,0,'R',1);		
	$pdf->Cell(35,5,'TOTAL :',0,0,'C',1);
	$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(10,5,$hari,1,0,'R',1);
	$pdf->Cell(25,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);
	if($_POST[untuk]=='gp')
	{
		$pdf->Cell(20,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);						
		$pdf->Ln();
	}
	else
	{
	//	$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
	//	$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Cell(30,5,'',0,0,'R',0);						
		$pdf->Ln();
	}			
	}
}
else if($outin=='1')//outgoing daily
{
mysql_query("DELETE FROM dailytmp");
mysql_query("INSERT INTO dailytmp 
select out_dtbarang_h.btb_smu,out_dtbarang_h.btb_totalberat, 
deliverybill.hari,deliverybill.overtime,deliverybill.document,
deliverybill.lain,deliverybill.id_deliverybill, 
deliverybill.id_carabayar,out_dtbarang_h.airline,out_dtbarang_h.btb_agent,
deliverybill.isvoid,deliverybill.keterangan,deliverybill.tglvoid,
deliverybill.nodb,deliverybill.diskon
from out_dtbarang_h,deliverybill 
where deliverybill.no_smubtb=out_dtbarang_h.btb_nobtb AND deliverybill.id_carabayar like '%$carabayar%' AND deliverybill.status='1' 
AND deliverybill.tglbayar='$tglawal' group by deliverybill.nodb");	

	//cek dulu jenis2x airline yang ada pada incoming
$air1=mysql_query("select airline from dailytmp 
	where ((agent<>'GMFAA') AND (agent<>'ACS') AND (agent<>'POST') AND(agent<>'POS') AND(agent<>'QATAR')) 
	GROUP by airline");
	while($airline=mysql_fetch_array($air1))//mulai utk masing-masing airline
	{
		$no=1;
		//outgoing
		$str=mysql_query("select * from dailytmp where airline='$airline[0]' 
		and ((agent<>'GMFAA') AND (agent<>'ACS') AND (agent<>'POST') AND(agent<>'POS') AND (agent<>'QATAR')) 
		ORDER BY id_deliverybill ASC");
	
		$pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',12);$pdf->Cell(170,8,'EXPORT',0,0,'L',1);	
		$pdf->Ln();
		$pdf->SetFont('Arial','B',10);			
		$pdf->Cell(15,8,$airline[0],1,0,'C',1);
		$pdf->Cell(35,8,'NO.SMU/AWB',1,0,'C',1);
		$pdf->Cell(20,8,'Berat(Kg)',1,0,'C',1);
		$pdf->Cell(10,8,'Hari',1,0,'C',1);
		$pdf->Cell(25,8,'S_Gudang',1,0,'C',1);
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Cell(30,8,'No. DB',1,0,'C',1);
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);	
		}
		else//jika untuk Angkasa Pura
		{
		//	$pdf->Cell(20,8,'PPn',1,0,'C',1);
		//	$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Cell(30,8,'No. DB',1,0,'C',1);
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);	
		}				
		$berat=0;$sewagudang=0;
		$adm=0;$ppn=0;$hari=0;$total1=0;	
			
		//mulai query untuk outgoing
		while ($r=mysql_fetch_array($str))
		{
				$nodb='O-'.$r[nodb];
		if($r[isvoid]=='1'){$brt=0;$total=0;$hr=0;}
		else {
		$total=$r[sewagudang]+$r[adm]+$r[ppn]-$r[diskon];	
		$brt=$r[berat];
		$hr=$r[hari];			
		}		
		
			$total=$r[sewagudang]+$r[adm]+$r[ppn]-$r[diskon];				
			$pdf->Cell(15,5,$no,1,0,'R',1);	$pdf->Cell(35,5,$r[nosmu],1,0,'C',1);	
			if($r[isvoid]=='1')
				{
			$pdf->Cell(20,5,'0',1,0,'R',1);
			$pdf->Cell(10,5,'0',1,0,'R',1);	}
				else
				{
			$pdf->Cell(20,5,number_format($brt, 1, ',', '.'),1,0,'R',1);
			$pdf->Cell(10,5,$hr,1,0,'R',1);
				}			


			$pdf->Cell(25,5,number_format($r[sewagudang]-$r[diskon], 0, '.', '.'),1,0,'R',1);
		
			if($_POST[untuk]=='gp')
			{
				$pdf->Cell(20,5,number_format($r[adm], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(20,5,number_format($r[ppn], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
				if($r[isvoid]=='1'){$pdf->Cell(30,5,'(V)'.$nodb,1,0,'R',1);}	
				else {$pdf->Cell(30,5,$nodb,1,0,'R',1);}				
				$pdf->Ln();
			}
			else
			{
		//		$pdf->Cell(20,5,number_format($r[lain], 0, '.', '.'),1,0,'R',1);
		//		$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
				if($r[isvoid]=='1'){$pdf->Cell(30,5,'(V)'.$nodb,1,0,'R',1);}	
				else {$pdf->Cell(30,5,$nodb,1,0,'R',1);}					
				$pdf->Ln();
			}
			$berat=$berat+$brt;
			$sewagudang=$sewagudang+$r[sewagudang];
			$adm=$adm+$r[adm];
			$ppn=$ppn+$r[ppn];
			$hari=$hari+$hr;
			$total1=$total1+$total;
			

				$no+=1;
		} //AKHIR DARI ISI TABEL
	//totalnya
	$pdf->Ln(2);
	$pdf->Cell(15,5,'',0,0,'R',1);		
	$pdf->Cell(35,5,'TOTAL :',0,0,'C',1);
	$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(10,5,$hari,1,0,'R',1);
	$pdf->Cell(25,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);
	if($_POST[untuk]=='gp')
	{
		$pdf->Cell(20,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);	$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}
	else
	{
	//	$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
	//	$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);	$pdf->Cell(30,5,'',0,0,'R',0);				
		$pdf->Ln();
	}			
	}
	//
	//cek dulu jenis2x agent yang ada pada outgoing
	$str1=mysql_query("select agent from dailytmp 
	where ((agent='GMFAA')OR(agent='ACS')OR(agent='POST')OR(agent='POS') OR (agent='QATAR')) GROUP by agent");

	while ($ag=mysql_fetch_array($str1))
	{
	
	$no=1;

	$str=mysql_query("select * from dailytmp where 
	agent='$ag[0]' ORDER BY id_deliverybill ASC");

	$pdf->AddPage();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',12);$pdf->Cell(170,8,'EXPORT',0,0,'L',1);	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);			
	$pdf->Cell(15,8,$ag[0],1,0,'C',1);
		$pdf->Cell(35,8,'NO.SMU/AWB',1,0,'C',1);
		$pdf->Cell(20,8,'Berat(Kg)',1,0,'C',1);
		$pdf->Cell(10,8,'Hari',1,0,'C',1);
		$pdf->Cell(25,8,'S_Gudang',1,0,'C',1);
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Cell(30,8,'No. DB',1,0,'C',1);
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);	
		}
		else//jika untuk Angkasa Pura
		{
		//	$pdf->Cell(20,8,'PPn',1,0,'C',1);
	//		$pdf->Cell(25,8,'Total',1,0,'C',1);			
			$pdf->Cell(30,8,'No. DB',1,0,'C',1);
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);	
		}				
		$berat=0;$sewagudang=0;
		$adm=0;$ppn=0;$hari=0;$total1=0;	
		
	//mulai query untuk incoming
	while ($r=mysql_fetch_array($str))
	{
			$nodb='O-'.$r[nodb];
		$kasir=$r[nama_lengkap];
		if($r[isvoid]=='1'){$brt=0;$total=0;$hr=0;}
		else {
		$total=$r[sewagudang]+$r[adm]+$r[ppn]-$r[diskon];	
		$brt=$r[berat];
		$hr=$r[hari];			
		}
		$pdf->Cell(15,5,$no,1,0,'R',1);	$pdf->Cell(35,5,$r[nosmu],1,0,'C',1);
		$pdf->Cell(20,5,number_format($brt, 1, ',', '.'),1,0,'R',1);
		$pdf->Cell(10,5,$r[hari],1,0,'R',1);
		$pdf->Cell(25,5,number_format($r[sewagudang]-$r[diskon], 0, '.', '.'),1,0,'R',1);
		if($_POST[untuk]=='gp')
		{
			$pdf->Cell(20,5,number_format($r[adm], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,5,number_format($r[ppn], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);		
			if($r[isvoid]=='1'){$pdf->Cell(30,5,'(V)'.$nodb,1,0,'R',1);}	
			else {$pdf->Cell(30,5,$nodb,1,0,'R',1);}								
			$pdf->Ln();
		}
		else
		{
	//		$pdf->Cell(20,5,number_format($r[ppn], 0, '.', '.'),1,0,'R',1);
	//		$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
			if($r[isvoid]=='1'){$pdf->Cell(30,5,'(V)'.$nodb,1,0,'R',1);}	
			else {$pdf->Cell(30,5,$nodb,1,0,'R',1);}		
			$pdf->Ln();
		}
		$berat=$berat+$brt;
		$sewagudang=$sewagudang+$r[sewagudang];
		$adm=$adm+$r[adm];
		$ppn=$ppn+$r[ppn];
		$hari=$hari+$r[hari];
		$total1=$total1+$total;

		$no+=1;
	}
	//totalnya
	$pdf->Ln(2);
	$pdf->Cell(15,5,'',0,0,'R',1);		
	$pdf->Cell(35,5,'TOTAL :',0,0,'C',1);
	$pdf->Cell(20,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(10,5,$hari,1,0,'R',1);
	$pdf->Cell(25,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);
	if($_POST[untuk]=='gp')
	{
		$pdf->Cell(20,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);	$pdf->Cell(30,5,'',0,0,'R',0);						
		$pdf->Ln();
	}
	else
	{
	//	$pdf->Cell(20,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
	//	$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);	$pdf->Cell(30,5,'',0,0,'R',0);						
		$pdf->Ln();
	}			

	}

}
}
//==========================================================================
else if($_POST[bt_preview]=='SUMMARY')
{
if($outin=='1')//utk outgoing dulu
{

mysql_query("DELETE FROM summarytmp");
mysql_query("
INSERT INTO summarytmp
select out_dtbarang_h_tmp.btb_nobtb,out_dtbarang_h_tmp.btb_totalberat,deliverybill_tmp.overtime,
deliverybill_tmp.document,deliverybill_tmp.lain,btb_agent,kategori,id_carabayar,airline,deliverybill_tmp.diskon
from out_dtbarang_h_tmp,out_dtbarang_tmp,deliverybill_tmp,typebarang where 
deliverybill_tmp.no_smubtb=out_dtbarang_h_tmp.btb_nobtb
AND out_dtbarang_h_tmp.id=out_dtbarang_tmp.id_h
AND out_dtbarang_tmp.dtBarang_type=typebarang.typebarang AND deliverybill_tmp.status='1' AND deliverybill_tmp.isvoid='0' AND deliverybill_tmp.id_carabayar like '%$carabayar%' AND deliverybill_tmp.tglbayar='$tglawal'
group by deliverybill_tmp.nodb");

			$totalnya=0;
			$beratnya=0;
			$sewagudangnya=0;
			$admnya=0;
			$ppnnya=0;	

		$pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',12);$pdf->Cell(170,8,'EXPORT',0,0,'L',1);	
		$pdf->Ln();
		$pdf->SetFont('Times','I',11);$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal],0,0,'L',1);
		$pdf->Ln();

	//cek dulu jenis2x airline yang ada pada incoming
	$air1=mysql_query("select airline.airlinecode,airline.airlinename from airline,out_dtbarang_h_tmp,deliverybill_tmp 
	where deliverybill_tmp.no_smubtb=out_dtbarang_h_tmp.btb_nobtb AND
	out_dtbarang_h_tmp.airline=airline.airlinecode AND 
	((out_dtbarang_h_tmp.btb_agent<>'GMFAA') AND (out_dtbarang_h_tmp.btb_agent<>'QATAR') AND(out_dtbarang_h_tmp.btb_agent<>'ACS')AND(out_dtbarang_h_tmp.btb_agent<>'POST')
	AND(out_dtbarang_h_tmp.btb_agent<>'POS')) GROUP by airline.airlinecode");
	while($airline=mysql_fetch_array($air1))//mulai utk masing-masing airline
	{
		//cek dulu komoditi apa saja yang ada
	$str=mysql_query("select typebarang.kategori from deliverybill_tmp,out_dtbarang_h_tmp,
		typebarang,out_dtbarang_tmp where out_dtbarang_h_tmp.id=out_dtbarang_tmp.id_h AND
		deliverybill_tmp.no_smubtb=out_dtbarang_h_tmp.btb_nobtb AND
		out_dtbarang_tmp.dtBarang_type=typebarang.typebarang AND 
		deliverybill_tmp.status='1' AND  
	((out_dtbarang_h_tmp.btb_agent<>'GMFAA')AND(out_dtbarang_h_tmp.btb_agent<>'ACS') AND (out_dtbarang_h_tmp.btb_agent<>'QATAR') AND(out_dtbarang_h_tmp.btb_agent<>'POST')
	AND(out_dtbarang_h_tmp.btb_agent<>'POS'))AND out_dtbarang_h_tmp.airline='$airline[0]' 
		GROUP BY typebarang.kategori");
  	$pdf->SetFont('Arial','B',9);			
		$pdf->Cell(35,5,$airline[1],1,0,'L',1);
		$pdf->Cell(25,5,'Berat(Kg)',1,0,'C',1);
		$pdf->Cell(30,5,'Sewa Gudang',1,0,'C',1);
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{
		$pdf->Cell(20,5,'HF',1,0,'C',1);
			$pdf->Cell(25,5,'Adm',1,0,'C',1);
			$pdf->Cell(25,5,'PPn',1,0,'C',1);
			$pdf->Cell(30,5,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);	
		}
		else//jika untuk Angkasa Pura
		{
		//	$pdf->Cell(25,5,'PPn',1,0,'C',1);
		//	$pdf->Cell(30,5,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);	
		}				
			$berat=0;$sewagudang=0;
		$adm=0;$ppn=0;$hari=0;$total1=0;			
	while($kom=mysql_fetch_array($str))//mulai utk masing-masing airline
	{
	
		$str1=mysql_query("select sum(totalberat),sum(overtime),
		sum(document),sum(lain),sum(diskon) from summarytmp
		where kategori='$kom[0]' AND airline='$airline[0]' AND
((agent<>'GMFAA')AND(agent<>'ACS')AND(agent<>'POST') AND(agent<>'POS') AND (agent<>'QATAR'))		
		group by kategori");
	
			
		//mulai query untuk incoming
		while ($r=mysql_fetch_array($str1))
		{
			$brt=$r[0];
			$hr=$r[hari];
			$total=$r[1]+$r[2]+$r[3]-$r[4];				
			$pdf->Cell(35,5,$kom[0],1,0,'L',1);		
			$pdf->Cell(25,5,number_format($brt, 1, ',', '.'),1,0,'R',1);
			$pdf->Cell(30,5,number_format($r[1]-$r[4], 0, '.', '.'),1,0,'R',1);
			
			if($_POST[untuk]=='gp')
			{$pdf->Cell(20,5,'0',1,0,'R',1);	
				$pdf->Cell(25,5,number_format($r[2], 1, ',', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($r[3], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(30,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
				$pdf->Ln();
			}
			else
			{
			//	$pdf->Cell(25,5,number_format($r[3], 0, '.', '.'),1,0,'R',1);
			//	$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);						
				$pdf->Ln();
			}
			$berat=$berat+$brt;
			$sewagudang=$sewagudang+$r[1]-$r[4];
			$adm=$adm+$r[2];
			$ppn=$ppn+$r[3];
			$total1=$total1+$total;
		} //AKHIR DARI ISI TABEL
	}	
	//subtotalnya
			$totalnya=$totalnya+$total1;
			$beratnya=$beratnya+$berat;
			$sewagudangnya=$sewagudangnya+$sewagudang;
			$admnya=$admnya+$adm;
			$ppnnya=$ppnnya+$ppn;			
	$pdf->Cell(35,5,'Sub Total',1,0,'R',1);		
	$pdf->Cell(25,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(30,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(20,5,'0',1,0,'R',1);
		$pdf->Cell(25,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(30,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(25,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		//$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Ln();
	}		
	$pdf->Ln(2);	
	}
	
//============utk yan agent2x
  //cek dulu agen pada outgoing
	
	$str1=mysql_query("select agent from summarytmp where 
	(agent='POST' OR agent='POS' OR agent='GMFAA' or agent='ACS' OR agent='QATAR') GROUP by agent");

	while ($ag=mysql_fetch_array($str1))//mulai utk masing-masing agent
	{
		//cek dulu komoditi apa saja yang ada
		$str=mysql_query("select kategori from summarytmp where carabayar like '%$carabayar%' 
		AND (agent='POST' OR agent='POS' OR agent='GMFAA' or agent='ACS' OR agent='QATAR') 
		GROUP BY kategori");
  	$pdf->SetFont('Arial','B',9);			
		$pdf->Cell(35,5,$ag[0],1,0,'L',1);
		$pdf->Cell(25,5,'Berat(Kg)',1,0,'C',1);
		$pdf->Cell(30,5,'Sewa Gudang',1,0,'C',1);
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{$pdf->Cell(20,5,'HF',1,0,'C',1);
			$pdf->Cell(25,5,'Adm',1,0,'C',1);
			$pdf->Cell(25,5,'PPn',1,0,'C',1);
			$pdf->Cell(30,5,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);	
		}
		else//jika untuk Angkasa Pura
		{
		//	$pdf->Cell(25,5,'PPn',1,0,'C',1);
		//	$pdf->Cell(30,5,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);	
		}				
			$berat=0;$sewagudang=0;
		$adm=0;$ppn=0;$hari=0;$total1=0;			
	while($kom=mysql_fetch_array($str))//mulai utk masing-masing agent
	{
			$str2=mysql_query("select sum(totalberat),sum(overtime),
		sum(document),sum(lain),sum(diskon) from summarytmp
		where kategori='$kom[0]' AND
		agent='$ag[0]' 		
		group by kategori");
		
		
		//mulai query untuk incoming
		while ($r=mysql_fetch_array($str2))
		{
			$brt=$r[0];
			$hr=$r[hari];
			$total=$r[1]+$r[2]+$r[3]-$r[4];				
			$pdf->Cell(35,5,$kom[0],1,0,'L',1);		
			$pdf->Cell(25,5,number_format($brt, 1, ',', '.'),1,0,'R',1);
			$pdf->Cell(30,5,number_format($r[1]-$r[4], 0, '.', '.'),1,0,'R',1);
			
			if($_POST[untuk]=='gp')
			{$pdf->Cell(20,5,'0',1,0,'R',1);	
				$pdf->Cell(25,5,number_format($r[2], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($r[3], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(30,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
				$pdf->Ln();
			}
			else
			{
			//	$pdf->Cell(25,5,number_format($r[3], 0, '.', '.'),1,0,'R',1);
			//	$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);						
				$pdf->Ln();
			}
			$berat=$berat+$brt;
			$sewagudang=$sewagudang+$r[1]-$r[4];
			$adm=$adm+$r[2];
			$ppn=$ppn+$r[3];
			$total1=$total1+$total;
		} //AKHIR DARI ISI TABEL
	}	
	//subtotalnya
					$totalnya=$totalnya+$total1;
			$beratnya=$beratnya+$berat;
			$sewagudangnya=$sewagudangnya+$sewagudang;
			$admnya=$admnya+$adm;
			$ppnnya=$ppnnya+$ppn;			
	$pdf->Cell(35,5,'Sub Total',1,0,'R',1);		
	$pdf->Cell(25,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(30,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);

	if($_POST[untuk]=='gp')
	{	$pdf->Cell(20,5,'0',1,0,'R',1);
		$pdf->Cell(25,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(30,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(25,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
	//	$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Ln();
	}		
	$pdf->Ln(2);	
	}
//total dari subtotal
	$pdf->Cell(35,5,'Total',1,0,'R',1);		
	$pdf->Cell(25,5,number_format($beratnya, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(30,5,number_format($sewagudangnya, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(20,5,'0',1,0,'R',1);
		$pdf->Cell(25,5,number_format($admnya, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($ppnnya, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(30,5,number_format($totalnya, 0, '.', '.'),1,0,'R',1);			
		$pdf->Ln();
	}
	else
	{
	//	$pdf->Cell(25,5,number_format($ppnnya, 0, '.', '.'),1,0,'R',1);
	//	$pdf->Cell(25,5,number_format($totalnya, 0, '.', '.'),1,0,'R',1);			
		$pdf->Ln();
	}		
	$pdf->Ln(2);		
	
//====================

}//akhir dari outgoing
else if($outin=='0')//utk incoming summary
{
mysql_query("DELETE FROM summarytmp");
/*
mysql_query("
INSERT INTO summarytmp
select deliverybill_tmp.nosmu,breakdown_tmp.beratdatang,deliverybill_tmp.overtime,
		deliverybill_tmp.document,deliverybill_tmp.lain,agent,kategori,id_carabayar,airline,deliverybill_tmp.diskon
        from breakdown_tmp,isimanifestin_tmp,deliverybill_tmp,typebarang,manifestin_tmp where 
deliverybill_tmp.idbreakdown=breakdown_tmp.id_breakdown
AND breakdown_tmp.id_isimanifestin=isimanifestin_tmp.id_isimanifestin 
AND isimanifestin_tmp.jenisbarang=typebarang.typebarang AND 
isimanifestin_tmp.id_manifestin=manifestin_tmp.id_manifestin AND deliverybill_tmp.status='0' AND deliverybill_tmp.isvoid='0'  AND deliverybill_tmp.id_carabayar like '%$carabayar%' AND deliverybill.tglbayar='$tglawal'
group by isimanifestin_tmp.id_isimanifestin");*/
mysql_query("
INSERT INTO summarytmp
select deliverybill.nosmu,breakdown.beratdatang,deliverybill.overtime,
		deliverybill.document,deliverybill.lain,agent,kategori,id_carabayar,airline,deliverybill.diskon
        from breakdown,isimanifestin,deliverybill,typebarang,manifestin where 
deliverybill.idbreakdown=breakdown.id_breakdown
AND breakdown.id_isimanifestin=isimanifestin.id_isimanifestin 
AND isimanifestin.jenisbarang=typebarang.typebarang AND 
isimanifestin.id_manifestin=manifestin.id_manifestin AND deliverybill.status='0' AND deliverybill.isvoid='0'  AND deliverybill.id_carabayar like '%$carabayar%' AND deliverybill.tglbayar='$tglawal'
group by isimanifestin.id_isimanifestin");

$totalnya=0;
$beratnya=0;
$sewagudangnya=0;
$admnya=0;
$ppnnya=0;			
	
		$pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',12);$pdf->Cell(170,8,'IMPORT',0,0,'L',1);	
		$pdf->Ln();
		$pdf->SetFont('Times','I',11);$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal],0,0,'L',1);
		$pdf->Ln();

	//cek dulu jenis2x airline yang ada pada incoming
	$air1=mysql_query("select airline.airlinecode,airline.airlinename from airline,isimanifestin,manifestin,breakdown,deliverybill 
	where deliverybill.idbreakdown=breakdown.id_breakdown AND
	breakdown.id_isimanifestin=isimanifestin.id_isimanifestin 
	AND isimanifestin.id_manifestin=manifestin.id_manifestin AND manifestin.airline=airline.airlinecode AND
isimanifestin.agent='' GROUP by airline.airlinecode");

	while($airline=mysql_fetch_array($air1))//mulai utk masing-masing airline
	{
		//cek dulu komoditi apa saja yang ada
		$str=mysql_query("select typebarang.kategori from deliverybill,breakdown,
		typebarang,isimanifestin,manifestin where deliverybill.idbreakdown=breakdown.id_breakdown AND
		breakdown.id_isimanifestin=isimanifestin.id_isimanifestin AND
		isimanifestin.jenisbarang=typebarang.typebarang AND isimanifestin.id_manifestin=manifestin.id_manifestin AND
		deliverybill.status='0' AND  
		((isimanifestin.agent<>'POS') AND (isimanifestin.agent<>'GMFAA') AND (isimanifestin.agent<>'QATAR') AND(isimanifestin.agent<>'ACS'))AND
		deliverybill.id_carabayar like '%$carabayar%' 
		AND manifestin.airline='$airline[0]' 
		GROUP BY typebarang.kategori");
  	$pdf->SetFont('Arial','B',9);			
		$pdf->Cell(35,5,$airline[1],1,0,'L',1);
		$pdf->Cell(25,5,'Berat(Kg)',1,0,'C',1);
		$pdf->Cell(30,5,'Sewa Gudang',1,0,'C',1);
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{$pdf->Cell(20,5,'HF',1,0,'C',1);
			$pdf->Cell(25,5,'Adm',1,0,'C',1);
			$pdf->Cell(25,5,'PPn',1,0,'C',1);
			$pdf->Cell(30,5,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);	
		}
		else//jika untuk Angkasa Pura
		{
		//	$pdf->Cell(25,5,'PPn',1,0,'C',1);
		//	$pdf->Cell(30,5,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);	
		}				
			$berat=0;$sewagudang=0;
		$adm=0;$ppn=0;$hari=0;$total1=0;			
	while($kom=mysql_fetch_array($str))//mulai utk masing-masing airline
	{
		$str1=mysql_query("select sum(totalberat),sum(overtime),
		sum(document),sum(lain),sum(diskon)  from summarytmp
		where kategori='$kom[0]' AND airline='$airline[0]' AND
((agent<>'GMFAA')AND(agent<>'ACS')AND(agent<>'POST') AND(agent<>'POS') AND (agent<>'QATAR'))		
		group by kategori");
	
			
		//mulai query untuk incoming
		while ($r=mysql_fetch_array($str1))
		{
			$brt=$r[0];
			$hr=$r[hari];
			$total=$r[1]+$r[2]+$r[3]-$r[4];;				
			$pdf->Cell(35,5,$kom[0],1,0,'L',1);		
			$pdf->Cell(25,5,number_format($brt, 1, ',', '.'),1,0,'R',1);
			$pdf->Cell(30,5,number_format($r[1]-$r[4], 0, '.', '.'),1,0,'R',1);
			
			if($_POST[untuk]=='gp')
			{$pdf->Cell(20,5,'0',1,0,'R',1);	
				$pdf->Cell(25,5,number_format($r[2], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($r[3], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(30,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
				$pdf->Ln();
			}
			else
			{
			//	$pdf->Cell(25,5,number_format($r[3], 0, '.', '.'),1,0,'R',1);
			//	$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);						
				$pdf->Ln();
			}
			$berat=$berat+$brt;
			$sewagudang=$sewagudang+$r[1]-$r[4];
			$adm=$adm+$r[2];
			$ppn=$ppn+$r[3];
			$total1=$total1+$total;
	
		} //AKHIR DARI ISI TABEL
	}	

			$totalnya=$totalnya+$total1;
			$beratnya=$beratnya+$berat;
			$sewagudangnya=$sewagudangnya+$sewagudang;
			$admnya=$admnya+$adm;
			$ppnnya=$ppnnya+$ppn;				
	//subtotalnya
	$pdf->Cell(35,5,'Sub Total',1,0,'R',1);		
	$pdf->Cell(25,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(30,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(20,5,'0',1,0,'R',1);
		$pdf->Cell(25,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(30,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Ln();
	}
	else
	{
	//	$pdf->Cell(25,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
	//	$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Ln();
	}		
	$pdf->Ln(2);	
	}

	
//============utk yan agent2x
  //cek dulu agen 
		$str1=mysql_query("select agent from summarytmp where  
		((agent='POS') OR (agent='POST') OR
		(agent='GMFAA')OR(agent='ACS') OR (agent='QATAR'))AND
		carabayar like '%$carabayar%'
		GROUP BY agent");
			
	while ($ag=mysql_fetch_array($str1))//mulai utk masing-masing agent
	{
		//cek dulu komoditi apa saja yang ada
		$str2=mysql_query("select typebarang.kategori from deliverybill,breakdown,
		typebarang,isimanifestin,manifestin where deliverybill.idbreakdown=breakdown.id_breakdown AND
		breakdown.id_isimanifestin=isimanifestin.id_isimanifestin AND
		isimanifestin.jenisbarang=typebarang.typebarang AND isimanifestin.id_manifestin=manifestin.id_manifestin AND
		deliverybill.status='0' AND 
		isimanifestin.agent='$ag[0]' AND
		deliverybill.id_carabayar like '%$carabayar%'
		GROUP BY typebarang.kategori");
  	$pdf->SetFont('Arial','B',9);			
		$pdf->Cell(35,5,$ag[0],1,0,'L',1);
		$pdf->Cell(25,5,'Berat(Kg)',1,0,'C',1);
		$pdf->Cell(30,5,'Sewa Gudang',1,0,'C',1);
	
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{	$pdf->Cell(20,5,'HF',1,0,'C',1);
			$pdf->Cell(25,5,'Adm',1,0,'C',1);
			$pdf->Cell(25,5,'PPn',1,0,'C',1);
			$pdf->Cell(30,5,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);	
		}
		else//jika untuk Angkasa Pura
		{
		//	$pdf->Cell(25,5,'PPn',1,0,'C',1);
		//	$pdf->Cell(30,5,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);	
		}				
			$berat=0;$sewagudang=0;
		$adm=0;$ppn=0;$hari=0;$total1=0;			
	while($kom=mysql_fetch_array($str2))//mulai utk masing-masing agent
	{
		$str3=mysql_query("select sum(totalberat),sum(overtime),
		sum(document),sum(lain),sum(diskon) from summarytmp
		where kategori='$kom[0]' AND agent='$ag[0]'
		group by kategori");
			

			
		//mulai query untuk incoming
		while ($r=mysql_fetch_array($str3))
		{
			$brt=$r[0];
			$hr=$r[hari];
			$total=$r[1]+$r[2]+$r[3]-$r[4];;				
			$pdf->Cell(35,5,$kom[0],1,0,'L',1);		
			$pdf->Cell(25,5,number_format($brt, 1, ',', '.'),1,0,'R',1);
			$pdf->Cell(30,5,number_format($r[1]-$r[4], 0, '.', '.'),1,0,'R',1);
			
			if($_POST[untuk]=='gp')
			{$pdf->Cell(20,5,'0',1,0,'R',1);	
				$pdf->Cell(25,5,number_format($r[2], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($r[3], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(30,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
				$pdf->Ln();
			}
			else
			{
		//		$pdf->Cell(25,5,number_format($r[3], 0, '.', '.'),1,0,'R',1);
		//		$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);						
				$pdf->Ln();
			}
			$berat=$berat+$brt;
			$sewagudang=$sewagudang+$r[1]-$r[4];
			$adm=$adm+$r[2];
			$ppn=$ppn+$r[3];
			$total1=$total1+$total;			
		
		} //AKHIR DARI ISI TABEL
	}	
	
	//subtotalnya
	$pdf->Cell(35,5,'Sub Total',1,0,'R',1);		
	$pdf->Cell(25,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(30,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(20,5,'0',1,0,'R',1);
		$pdf->Cell(25,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(30,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Ln();
	}
	else
	{
	//	$pdf->Cell(25,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
	//	$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Ln();
	}		
	$pdf->Ln(2);	
			$totalnya=$totalnya+$total1;
			$beratnya=$beratnya+$berat;
			$sewagudangnya=$sewagudangnya+$sewagudang;
			$admnya=$admnya+$adm;
			$ppnnya=$ppnnya+$ppn;			
	}
	
//total dari subtotal
	$pdf->Cell(35,5,'Total',1,0,'R',1);		
	$pdf->Cell(25,5,number_format($beratnya, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(30,5,number_format($sewagudangnya, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(20,5,'0',1,0,'R',1);
		$pdf->Cell(25,5,number_format($admnya, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($ppnnya, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(30,5,number_format($totalnya, 0, '.', '.'),1,0,'R',1);			
		$pdf->Ln();
	}
	else
	{
	//	$pdf->Cell(25,5,number_format($ppnnya, 0, '.', '.'),1,0,'R',1);
	//	$pdf->Cell(25,5,number_format($totalnya, 0, '.', '.'),1,0,'R',1);			
		$pdf->Ln();
	}		
	$pdf->Ln(2);	
	
//====================

}//akhir dari incoming
else if($outin=='2')//utk semua summary
{
//===================== incoming ================
mysql_query("DELETE FROM summarytmp");

mysql_query("
INSERT INTO summarytmp
select deliverybill.nosmu,breakdown.beratdatang,deliverybill.overtime,
		deliverybill.document,deliverybill.lain,agent,kategori,id_carabayar,airline,deliverybill.diskon
        from breakdown,isimanifestin,deliverybill,typebarang,manifestin where 
deliverybill.idbreakdown=breakdown.id_breakdown
AND breakdown.id_isimanifestin=isimanifestin.id_isimanifestin 
AND isimanifestin.jenisbarang=typebarang.typebarang AND 
isimanifestin.id_manifestin=manifestin.id_manifestin AND deliverybill.status='0' AND deliverybill.isvoid='0' AND deliverybill.id_carabayar like '%$carabayar%' AND deliverybill.tglbayar='$tglawal'
group by isimanifestin.id_isimanifestin");

$totalnya=0;
$beratnya=0;
$sewagudangnya=0;
$admnya=0;
$ppnnya=0;			
	
		$pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',12);$pdf->Cell(170,8,'IMPORT',0,0,'L',1);	
		$pdf->Ln();

	//cek dulu jenis2x airline yang ada pada incoming
	$air1=mysql_query("select airline.airlinecode,airline.airlinename from airline,isimanifestin,manifestin,breakdown,deliverybill 
	where deliverybill.idbreakdown=breakdown.id_breakdown AND
	breakdown.id_isimanifestin=isimanifestin.id_isimanifestin 
	AND isimanifestin.id_manifestin=manifestin.id_manifestin AND manifestin.airline=airline.airlinecode AND
isimanifestin.agent='' GROUP by airline.airlinecode");

	while($airline=mysql_fetch_array($air1))//mulai utk masing-masing airline
	{
		//cek dulu komoditi apa saja yang ada
		$str=mysql_query("select typebarang.kategori from deliverybill,breakdown,
		typebarang,isimanifestin,manifestin where deliverybill.idbreakdown=breakdown.id_breakdown AND
		breakdown.id_isimanifestin=isimanifestin.id_isimanifestin AND
		isimanifestin.jenisbarang=typebarang.typebarang AND isimanifestin.id_manifestin=manifestin.id_manifestin AND
		deliverybill.status='0' AND  
		((isimanifestin.agent<>'POS') AND (isimanifestin.agent<>'GMFAA')AND (isimanifestin.agent<>'QATAR') AND(isimanifestin.agent<>'ACS'))AND
		deliverybill.id_carabayar like '%$carabayar%' 
		AND manifestin.airline='$airline[0]' 
		GROUP BY typebarang.kategori");
  	$pdf->SetFont('Arial','B',9);			
		$pdf->Cell(35,5,$airline[1],1,0,'L',1);
		$pdf->Cell(25,5,'Berat(Kg)',1,0,'C',1);
		$pdf->Cell(30,5,'Sewa Gudang',1,0,'C',1);
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{$pdf->Cell(20,5,'HF',1,0,'C',1);
			$pdf->Cell(25,5,'Adm',1,0,'C',1);
			$pdf->Cell(25,5,'PPn',1,0,'C',1);
			$pdf->Cell(30,5,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);	
		}
		else//jika untuk Angkasa Pura
		{
	//		$pdf->Cell(25,5,'PPn',1,0,'C',1);
	//		$pdf->Cell(30,5,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);	
		}				
			$berat=0;$sewagudang=0;
		$adm=0;$ppn=0;$hari=0;$total1=0;			
	while($kom=mysql_fetch_array($str))//mulai utk masing-masing airline
	{
		$str1=mysql_query("select sum(totalberat),sum(overtime),
		sum(document),sum(lain),sum(diskon)  from summarytmp
		where kategori='$kom[0]' AND airline='$airline[0]' AND
((agent<>'GMFAA')AND(agent<>'ACS')AND(agent<>'POST') AND(agent<>'POS') AND (agent<>'QATAR'))		
		group by kategori");
	
			
		//mulai query untuk incoming
		while ($r=mysql_fetch_array($str1))
		{
			$brt=$r[0];
			$hr=$r[hari];
			$total=$r[1]+$r[2]+$r[3]-$r[4];;				
			$pdf->Cell(35,5,$kom[0],1,0,'L',1);		
			$pdf->Cell(25,5,number_format($brt, 1, ',', '.'),1,0,'R',1);
			$pdf->Cell(30,5,number_format($r[1]-$r[4], 0, '.', '.'),1,0,'R',1);
		
			if($_POST[untuk]=='gp')
			{	$pdf->Cell(20,5,'0',1,0,'R',1);	
				$pdf->Cell(25,5,number_format($r[2], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($r[3], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(30,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
				$pdf->Ln();
			}
			else
			{
		//		$pdf->Cell(25,5,number_format($r[3], 0, '.', '.'),1,0,'R',1);
		//		$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);						
				$pdf->Ln();
			}
			$berat=$berat+$brt;
			$sewagudang=$sewagudang+$r[1]-$r[4];
			$adm=$adm+$r[2];
			$ppn=$ppn+$r[3];
			$total1=$total1+$total;
	
		} //AKHIR DARI ISI TABEL
	}	
					$totalnya=$totalnya+$total1;
			$beratnya=$beratnya+$berat;
			$sewagudangnya=$sewagudangnya+$sewagudang;
			$admnya=$admnya+$adm;
			$ppnnya=$ppnnya+$ppn;		

			
	//subtotalnya
	$pdf->Cell(35,5,'Sub Total',1,0,'R',1);		
	$pdf->Cell(25,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(30,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(20,5,'0',1,0,'R',1);
		$pdf->Cell(25,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(30,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Ln();
	}
	else
	{
	//	$pdf->Cell(25,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
	//	$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Ln();
	}		
	$pdf->Ln(2);	
	}
	
//============utk yan agent2x
  //cek dulu agen 
		$str1=mysql_query("select agent from summarytmp where  
		((agent='POS') OR (agent='POST') OR
		(agent='GMFAA')OR(agent='ACS') OR (agent='QATAR'))AND
		carabayar like '%$carabayar%'
		GROUP BY agent");
			
	while ($ag=mysql_fetch_array($str1))//mulai utk masing-masing agent
	{
		//cek dulu komoditi apa saja yang ada
		$str2=mysql_query("select typebarang.kategori from deliverybill,breakdown,
		typebarang,isimanifestin,manifestin where deliverybill.idbreakdown=breakdown.id_breakdown AND
		breakdown.id_isimanifestin=isimanifestin.id_isimanifestin AND
		isimanifestin.jenisbarang=typebarang.typebarang AND isimanifestin.id_manifestin=manifestin.id_manifestin AND
		deliverybill.status='0' AND 
		isimanifestin.agent='$ag[0]' AND
		deliverybill.id_carabayar like '%$carabayar%'
		GROUP BY typebarang.kategori");
  	$pdf->SetFont('Arial','B',9);			
		$pdf->Cell(35,5,$ag[0],1,0,'L',1);
		$pdf->Cell(25,5,'Berat(Kg)',1,0,'C',1);
		$pdf->Cell(30,5,'Sewa Gudang',1,0,'C',1);
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{$pdf->Cell(20,5,'HF',1,0,'C',1);
			$pdf->Cell(25,5,'Adm',1,0,'C',1);
			$pdf->Cell(25,5,'PPn',1,0,'C',1);
			$pdf->Cell(30,5,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);	
		}
		else//jika untuk Angkasa Pura
		{
	//	$pdf->Cell(25,5,'PPn',1,0,'C',1);
	//		$pdf->Cell(30,5,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);	
		}				
			$berat=0;$sewagudang=0;
		$adm=0;$ppn=0;$hari=0;$total1=0;			
	while($kom=mysql_fetch_array($str2))//mulai utk masing-masing agent
	{
		$str3=mysql_query("select sum(totalberat),sum(overtime),
		sum(document),sum(lain),sum(diskon) from summarytmp
		where kategori='$kom[0]' AND agent='$ag[0]'
		group by kategori");
			

			
		//mulai query untuk incoming
		while ($r=mysql_fetch_array($str3))
		{
			$brt=$r[0];
			$hr=$r[hari];
			$total=$r[1]+$r[2]+$r[3]-$r[4];;				
			$pdf->Cell(35,5,$kom[0],1,0,'L',1);		
			$pdf->Cell(25,5,number_format($brt, 1, ',', '.'),1,0,'R',1);
			$pdf->Cell(30,5,number_format($r[1]-$r[4], 0, '.', '.'),1,0,'R',1);
			
			if($_POST[untuk]=='gp')
			{$pdf->Cell(20,5,'0',1,0,'R',1);	
				$pdf->Cell(25,5,number_format($r[2], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($r[3], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(30,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
				$pdf->Ln();
			}
			else
			{
			//	$pdf->Cell(25,5,number_format($r[3], 0, '.', '.'),1,0,'R',1);
		//		$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);						
				$pdf->Ln();
			}
			$berat=$berat+$brt;
			$sewagudang=$sewagudang+$r[1]-$r[4];
			$adm=$adm+$r[2];
			$ppn=$ppn+$r[3];
			$total1=$total1+$total;			
		
		} //AKHIR DARI ISI TABEL
	}	
				$totalnya=$totalnya+$total1;
			$beratnya=$beratnya+$berat;
			$sewagudangnya=$sewagudangnya+$sewagudang;
			$admnya=$admnya+$adm;
			$ppnnya=$ppnnya+$ppn;		

			

		
	//subtotalnya
	$pdf->Cell(35,5,'Sub Total',1,0,'R',1);		
	$pdf->Cell(25,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(30,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(20,5,'0',1,0,'R',1);
		$pdf->Cell(25,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(30,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Ln();
	}
	else
	{
	//	$pdf->Cell(25,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
	//	$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Ln();
	}		
	$pdf->Ln(2);	
	}
			$gtotalnya=$gtotalnya+$totalnya;
			$gberatnya=$gberatnya+$beratnya;
			$gsewagudangnya=$gsewagudangnya+$sewagudangnya;
			$gadmnya=$gadmnya+$admnya;
			$gppnnya=$gppnnya+$ppnnya;		
//total dari subtotal
	$pdf->Cell(35,5,'Total',1,0,'R',1);		
	$pdf->Cell(25,5,number_format($beratnya, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(30,5,number_format($sewagudangnya, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(20,5,'0',1,0,'R',1);
		$pdf->Cell(25,5,number_format($admnya, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($ppnnya, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(30,5,number_format($totalnya, 0, '.', '.'),1,0,'R',1);			
		$pdf->Ln();
	}
	else
	{
	//	$pdf->Cell(25,5,number_format($ppnnya, 0, '.', '.'),1,0,'R',1);
	//	$pdf->Cell(25,5,number_format($totalnya, 0, '.', '.'),1,0,'R',1);			
		$pdf->Ln();
	}		
	$pdf->Ln(2);	
	
/*====================

*/
//===================== outgoing=================
mysql_query("DELETE FROM summarytmp");
mysql_query("
INSERT INTO summarytmp
select out_dtbarang_h_tmp.btb_nobtb,out_dtbarang_h_tmp.btb_totalberat,deliverybill_tmp.overtime,
deliverybill_tmp.document,deliverybill_tmp.lain,btb_agent,kategori,id_carabayar,airline,deliverybill_tmp.diskon
from out_dtbarang_h_tmp,out_dtbarang_tmp,deliverybill_tmp,typebarang where 
deliverybill_tmp.no_smubtb=out_dtbarang_h_tmp.btb_nobtb
AND out_dtbarang_h_tmp.id=out_dtbarang_tmp.id_h
AND out_dtbarang_tmp.dtBarang_type=typebarang.typebarang AND deliverybill_tmp.status='1' AND deliverybill_tmp.isvoid='0' AND deliverybill_tmp.id_carabayar like '%$carabayar%' AND deliverybill_tmp.tglbayar='$tglawal'
group by deliverybill_tmp.nodb");

			$totalnya=0;
			$beratnya=0;
			$sewagudangnya=0;
			$admnya=0;
			$ppnnya=0;	

//		$pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',12);$pdf->Cell(170,8,'EXPORT',0,0,'L',1);	
		$pdf->Ln();
		$pdf->SetFont('Times','I',11);$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal],0,0,'L',1);
		$pdf->Ln();

	//cek dulu jenis2x airline yang ada pada incoming
	$air1=mysql_query("select airline.airlinecode,airline.airlinename from airline,out_dtbarang_h_tmp,deliverybill_tmp 
	where deliverybill_tmp.no_smubtb=out_dtbarang_h_tmp.btb_nobtb AND
	out_dtbarang_h_tmp.airline=airline.airlinecode AND 
	((out_dtbarang_h_tmp.btb_agent<>'GMFAA') AND (out_dtbarang_h_tmp.btb_agent<>'QATAR') AND(out_dtbarang_h_tmp.btb_agent<>'ACS')AND(out_dtbarang_h_tmp.btb_agent<>'POST')
	AND(out_dtbarang_h_tmp.btb_agent<>'POS')) GROUP by airline.airlinecode");
	while($airline=mysql_fetch_array($air1))//mulai utk masing-masing airline
	{
		//cek dulu komoditi apa saja yang ada
	$str=mysql_query("select typebarang.kategori from deliverybill_tmp,out_dtbarang_h_tmp,
		typebarang,out_dtbarang_tmp where out_dtbarang_h_tmp.id=out_dtbarang_tmp.id_h AND
		deliverybill_tmp.no_smubtb=out_dtbarang_h_tmp.btb_nobtb AND
		out_dtbarang_tmp.dtBarang_type=typebarang.typebarang AND 
		deliverybill_tmp.status='1' AND  
	((out_dtbarang_h_tmp.btb_agent<>'GMFAA')AND(out_dtbarang_h_tmp.btb_agent<>'ACS') AND (out_dtbarang_h_tmp.btb_agent<>'QATAR') AND(out_dtbarang_h_tmp.btb_agent<>'POST')
	AND(out_dtbarang_h_tmp.btb_agent<>'POS'))AND out_dtbarang_h_tmp.airline='$airline[0]' 
		GROUP BY typebarang.kategori");
  	$pdf->SetFont('Arial','B',9);			
		$pdf->Cell(35,5,$airline[1],1,0,'L',1);
		$pdf->Cell(25,5,'Berat(Kg)',1,0,'C',1);
		$pdf->Cell(30,5,'Sewa Gudang',1,0,'C',1);
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{
$pdf->Cell(20,5,'HF',1,0,'C',1);
			$pdf->Cell(25,5,'Adm',1,0,'C',1);
			$pdf->Cell(25,5,'PPn',1,0,'C',1);
			$pdf->Cell(30,5,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);	
		}
		else//jika untuk Angkasa Pura
		{
		//	$pdf->Cell(25,5,'PPn',1,0,'C',1);
		//	$pdf->Cell(30,5,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);	
		}				
			$berat=0;$sewagudang=0;
		$adm=0;$ppn=0;$hari=0;$total1=0;			
	while($kom=mysql_fetch_array($str))//mulai utk masing-masing airline
	{
	
		$str1=mysql_query("select sum(totalberat),sum(overtime),
		sum(document),sum(lain),sum(diskon)  from summarytmp
		where kategori='$kom[0]' AND airline='$airline[0]' AND
((agent<>'GMFAA')AND(agent<>'ACS')AND(agent<>'POST')  AND (agent<>'QATAR') AND(agent<>'POS'))		
		group by kategori");
	
			
		//mulai query untuk incoming
		while ($r=mysql_fetch_array($str1))
		{
			$brt=$r[0];
			$hr=$r[hari];
			$total=$r[1]+$r[2]+$r[3]-$r[4];;				
			$pdf->Cell(35,5,$kom[0],1,0,'L',1);		
			$pdf->Cell(25,5,number_format($brt, 1, ',', '.'),1,0,'R',1);
			$pdf->Cell(30,5,number_format($r[1]-$r[4], 0, '.', '.'),1,0,'R',1);
			
			if($_POST[untuk]=='gp')
			{$pdf->Cell(20,5,'0',1,0,'R',1);	
				$pdf->Cell(25,5,number_format($r[2], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($r[3], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(30,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
				$pdf->Ln();
			}
			else
			{
		//		$pdf->Cell(25,5,number_format($r[3], 0, '.', '.'),1,0,'R',1);
		//		$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);						
				$pdf->Ln();
			}
			$berat=$berat+$brt;
			$sewagudang=$sewagudang+$r[1]-$r[4];
			$adm=$adm+$r[2];
			$ppn=$ppn+$r[3];
			$total1=$total1+$total;
		} //AKHIR DARI ISI TABEL
	}	
	//subtotalnya
			$totalnya=$totalnya+$total1;
			$beratnya=$beratnya+$berat;
			$sewagudangnya=$sewagudangnya+$sewagudang;
			$admnya=$admnya+$adm;
			$ppnnya=$ppnnya+$ppn;		
			
							
	$pdf->Cell(35,5,'Sub Total',1,0,'R',1);		
	$pdf->Cell(25,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(30,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(20,5,'0',1,0,'R',1);
		$pdf->Cell(25,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(30,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(25,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
	//	$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Ln();
	}		
	$pdf->Ln(2);	
	}
	
//============utk yan agent2x
  //cek dulu agen pada outgoing
	
	$str1=mysql_query("select agent from summarytmp where carabayar like '%$carabayar%' 
	AND (agent='POST' OR agent='POS' OR agent='GMFAA' or agent='ACS' OR agent='QATAR' ) GROUP by agent");

	while ($ag=mysql_fetch_array($str1))//mulai utk masing-masing agent
	{
		//cek dulu komoditi apa saja yang ada
		$str=mysql_query("select kategori from summarytmp where carabayar like '%$carabayar%' 
		AND (agent='POST' OR agent='POS' OR agent='GMFAA' or agent='ACS' or agent='QATAR') 
		GROUP BY kategori");
  	$pdf->SetFont('Arial','B',9);			
		$pdf->Cell(35,5,$ag[0],1,0,'L',1);
		$pdf->Cell(25,5,'Berat(Kg)',1,0,'C',1);
		$pdf->Cell(30,5,'Sewa Gudang',1,0,'C',1);
		
		if($_POST[untuk]=='gp')//jikauntuk internal Gapura
		{$pdf->Cell(20,5,'HF',1,0,'C',1);
			$pdf->Cell(25,5,'Adm',1,0,'C',1);
			$pdf->Cell(25,5,'PPn',1,0,'C',1);
			$pdf->Cell(30,5,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);	
		}
		else//jika untuk Angkasa Pura
		{
		//	$pdf->Cell(25,5,'PPn',1,0,'C',1);
	//		$pdf->Cell(30,5,'Total',1,0,'C',1);			
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);	
		}				
			$berat=0;$sewagudang=0;
		$adm=0;$ppn=0;$hari=0;$total1=0;			
	while($kom=mysql_fetch_array($str))//mulai utk masing-masing agent
	{
			$str2=mysql_query("select sum(totalberat),sum(overtime),
		sum(document),sum(lain),sum(diskon) from summarytmp
		where kategori='$kom[0]' AND carabayar like '%$carabayar%' AND
		agent='$ag[0]' 		
		group by kategori");
		
		
		//mulai query untuk incoming
		while ($r=mysql_fetch_array($str2))
		{
			$brt=$r[0];
			$hr=$r[hari];
			$total=$r[1]+$r[2]+$r[3]-$r[4];;				
			$pdf->Cell(35,5,$kom[0],1,0,'L',1);		
			$pdf->Cell(25,5,number_format($brt, 1, ',', '.'),1,0,'R',1);
			$pdf->Cell(30,5,number_format($r[1]-$r[4], 0, '.', '.'),1,0,'R',1);
			
			if($_POST[untuk]=='gp')
			{$pdf->Cell(20,5,'0',1,0,'R',1);	
				$pdf->Cell(25,5,number_format($r[2], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($r[3], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(30,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
				$pdf->Ln();
			}
			else
			{
		//		$pdf->Cell(25,5,number_format($r[3], 0, '.', '.'),1,0,'R',1);
		//		$pdf->Cell(25,5,number_format($total, 0, '.', '.'),1,0,'R',1);						
				$pdf->Ln();
			}
			$berat=$berat+$brt;
			$sewagudang=$sewagudang+$r[1]-$r[4];
			$adm=$adm+$r[2];
			$ppn=$ppn+$r[3];
			$total1=$total1+$total;
		} //AKHIR DARI ISI TABEL
	}	
	//subtotalnya
					$totalnya=$totalnya+$total1;
			$beratnya=$beratnya+$berat;
			$sewagudangnya=$sewagudangnya+$sewagudang;
			$admnya=$admnya+$adm;
			$ppnnya=$ppnnya+$ppn;	


								
	$pdf->Cell(35,5,'Sub Total',1,0,'R',1);		
	$pdf->Cell(25,5,number_format($berat, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(30,5,number_format($sewagudang, 0, '.', '.'),1,0,'R',1);

	if($_POST[untuk]=='gp')
	{	$pdf->Cell(20,5,'0',1,0,'R',1);
		$pdf->Cell(25,5,number_format($adm, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(30,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Ln();
	}
	else
	{
	//	$pdf->Cell(25,5,number_format($ppn, 0, '.', '.'),1,0,'R',1);
	//	$pdf->Cell(25,5,number_format($total1, 0, '.', '.'),1,0,'R',1);			
		$pdf->Ln();
	}		
	$pdf->Ln(2);	
	}
			$gtotalnya=$gtotalnya+$totalnya;
			$gberatnya=$gberatnya+$beratnya;
			$gsewagudangnya=$gsewagudangnya+$sewagudangnya;
			$gadmnya=$gadmnya+$admnya;
			$gppnnya=$gppnnya+$ppnnya;		
//total dari subtotal
	$pdf->Cell(35,5,'Total',1,0,'R',1);		
	$pdf->Cell(25,5,number_format($beratnya, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(30,5,number_format($sewagudangnya, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(20,5,'0',1,0,'R',1);
		$pdf->Cell(25,5,number_format($admnya, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($ppnnya, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(30,5,number_format($totalnya, 0, '.', '.'),1,0,'R',1);			
		$pdf->Ln();
	}
	else
	{
	//	$pdf->Cell(25,5,number_format($ppnnya, 0, '.', '.'),1,0,'R',1);
	//	$pdf->Cell(25,5,number_format($totalnya, 0, '.', '.'),1,0,'R',1);			
		$pdf->Ln();
	}		
	$pdf->Ln(2);		

//grand total dari total
	$pdf->Cell(35,5,'GRAND TOTAL',1,0,'R',1);		
	$pdf->Cell(25,5,number_format($gberatnya, 1, ',', '.'),1,0,'R',1);
	$pdf->Cell(30,5,number_format($gsewagudangnya, 0, '.', '.'),1,0,'R',1);
	
	if($_POST[untuk]=='gp')
	{$pdf->Cell(20,5,'0',1,0,'R',1);
		$pdf->Cell(25,5,number_format($gadmnya, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($gppnnya, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(30,5,number_format($gtotalnya, 0, '.', '.'),1,0,'R',1);			
		$pdf->Ln();
	}
	else
	{
		//$pdf->Cell(25,5,number_format($gppnnya, 0, '.', '.'),1,0,'R',1);
	//	$pdf->Cell(25,5,number_format($gtotalnya, 0, '.', '.'),1,0,'R',1);			
		$pdf->Ln();
	}		
	$pdf->Ln(2);	
	
	
//====================

}

}//akhir dari summary
$pdf->Output();
}//end of if SMU !	


// CARI btb/smu UTK Delivery Bill
elseif ($module=='deliverybill' AND $act=='caribtbsmu')
{
	$tgl=date("Y-m-d");
  $cek=mysql_query("SELECT * from out_dtbarang_h where btb_nobtb ='$_POST[nobtbsmu]' AND 
				status_bayar='no' AND isvoid='0' AND posted='1'");
  $ada=mysql_num_rows($cek);  
  if($ada<=0)
  {
		$cek1=mysql_query("SELECT * from breakdown,isimanifestin 
where breakdown.id_isimanifestin=isimanifestin.id_isimanifestin AND  breakdown.status_ambil='INSTORE' 
AND isimanifestin.no_smu ='$_POST[nobtbsmu]' 
AND breakdown.status_bayar='no' AND isimanifestin.status_transit='DPS' 
AND breakdown.isvoid='0' AND breakdown.status_check='confirm'");
$p=mysql_fetch_array($cek1);

  	$ada1=mysql_num_rows($cek1);  
  	if($ada1<=0)
		{
				$cek2=mysql_query("SELECT * from breakdown,isimanifestin,manifestin 
where breakdown.id_isimanifestin=isimanifestin.id_isimanifestin AND isimanifestin.id_manifestin=manifestin.id_manifestin AND isimanifestin.no_smu ='$_POST[nobtbsmu]' AND breakdown.isvoid='0'");
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
}

// Input Deliverybill
elseif ($module=='deliverybill' AND $act=='input'){
$tgl=date("Y-m-d");
  if($_POST[id]=='1'){//outgoing
  mysql_query("INSERT INTO deliverybill(no_smubtb,document,storage,id_carabayar,lain,tglbayar,user,overtime,hari,status,diskon,keterangan,nosmu)
  VALUES('$_POST[nosmubtb]','$_POST[document1]','$_POST[storage1]','$_POST[id_carabayar]',
  '$_POST[ppn1]','$tgl','$_SESSION[namauser]','$_POST[overtime1]','$_POST[hari]','1',
	'$_POST[afterdiskon]','$_POST[keterangan]','$_POST[nosmu]')");
  
	mysql_query("UPDATE out_dtbarang_h set status_bayar='yes',btb_smu='$_POST[nosmu]' where btb_nobtb='$_POST[nosmubtb]'");}
    else { //incoming
mysql_query("INSERT INTO deliverybill(no_smubtb,document,storage,id_carabayar,lain,tglbayar,user,overtime,hari,status,idbreakdown,nosmu,
diskon,keterangan)
 VALUES('$_POST[nosmubtb]','$_POST[document1]','$_POST[storage1]','$_POST[id_carabayar]',
	'$_POST[ppn1]','$tgl','$_SESSION[namauser]','$_POST[overtime1]','$_POST[hari]','0',
	'$_POST[id_breakdown]','$_POST[nosmu]','$_POST[afterdiskon]','$_POST[keterangan]')");
    mysql_query("UPDATE isimanifestin set penerima='$_POST[penerima]',alamatpenerima='$_POST[penerima]' where no_smu='$_POST[nosmubtb]'");
		    mysql_query("UPDATE breakdown set status_bayar='yes' where id_breakdown='$_POST[id_breakdown]'");
				}


    $t=mysql_query("select * from deliverybill order by id_deliverybill DESC limit 1");
		$r=mysql_fetch_array($t);


  header('location:media.php?module=cetakdb&n='.$r[id_deliverybill]);
}


elseif ($module=='cetakstockopnamein')
{

	class PDF extends FPDF
	{
		//Page header
		function Header()
		{
			$tglnya=date("Y-m-d");
			$tgl='Kondisi Tanggal : '.ymd2dmy($tglnya);
			$this->SetFont('Arial','B',14);
			$this->Ln(10);
			$this->Cell(180,20,'STOCK OPNAME OUTGOING',0,0,'C');
			$this->Ln(10);		
 			$this->SetFont('Arial','B',12);
			$this->Cell(170,20,$tgl,0,0,'C');			
			$this->Ln();
			$this->SetFillColor(255,255,255);
			$this->SetFont('Arial','B',12);
			$this->SetX(20);
			$this->Cell(10,9,'No',1,0,'C',1);
			$this->Cell(50,9,'No.SMU/AWB',1,0,'C',1);
			$this->Cell(20,9,'KOLI',1,0,'C',1);
			$this->Cell(30,9,'BERAT(Kg)',1,0,'C',1);			
			$this->Cell(25,9,'Tgl Datang',1,0,'C',1);			
			$this->Cell(50,9,'REMARK',1,0,'C',1);
			$this->Ln();			
				
		}
		
		//Page footer
		function Footer()
		{
			//Position at 1.5 cm from bottom
			$this->SetY(-15);
			//Arial italic 8
			$this->SetFont('Arial','I',10);
			//Page number
			$this->Cell(0,10,'GAPURA BALI GAPURA BALI WMS INTER - Page '.$this->PageNo().'/{nb}',0,0,'C');
		}
	}
	
	//Instanciation of inherited class
	$pdf=new PDF('P','mm','A4');
	
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

		$tampil=mysql_query("SELECT * FROM breakdown,isimanifestin where 
		breakdown.id_isimanifestin=isimanifestin.id_isimanifestin AND 
		breakdown.isvoid='0' AND 
		breakdown.status_ambil='INSTORE' AND breakdown.b_iscancel='0' 
		AND breakdown.status_check='confirm' AND isimanifestin.status_transit='DPS'");
   $pdf->Header($tgl);
    $pdf->AddPage();

  

		//bikin halaman baru
			
			//siapkan data
			$koli=0;$berat=0;
			  while ($r=mysql_fetch_array($tampil)){
				$no_smu = $r['no_smu'];
				$berat_datang = $r['beratdatang'];
				$koli_datang = $r['kolidatang'];
				$tgldatang = ymd2dmy($r['tgldatang']);		
				$pdf->SetFillColor(255,255,255);
				$pdf->SetFont('Arial','',12);
				$pdf->SetX(20);
				$pdf->Cell(10,9,$no,1,0,'L',1);
				$pdf->Cell(50,9,$no_smu,1,0,'L',1);	
				$pdf->Cell(20,9,$koli_datang,1,0,'C',1);					
				$pdf->Cell(30,9,$berat_datang,1,0,'C',1);	
				$pdf->Cell(25,9,$tgldatang,1,0,'C',1);					
				$pdf->Cell(50,9,'',1,0,'C',1);	
				$koli=$koli+$koli_datang;
				$berat=$berat+$berat_datang;
				
				$pdf->Ln();
				if($no % 25<=0)
				{
				 $pdf->AddPage();
				}
				$no+=1;

			}
							$pdf->Ln(2);	
				$pdf->SetX(20);		
				$pdf->Cell(10,9,'',0,0,'L',0);
				$pdf->Cell(50,9,'TOTAL : ',0,0,'R',1);	
				$pdf->Cell(20,9,$koli,1,0,'C',1);					
				$pdf->Cell(30,9,number_format($berat, 1, ',', '.'),1,0,'C',1);	
				$pdf->Cell(25,9,'',0,0,'C',0);					
				$pdf->Cell(50,9,'',0,0,'C',0);
				$pdf->Ln(30);			
	$pdf->Cell(40,8,'CHECKED : ',0,0,'C',1);			
	$pdf->Output();


}


elseif ($module=='cetaklap')
{
if($_GET[i]=='1'){
$tgl=date("Y-m-d");$tgl1=ymd2dmy($tgl);

  echo "<link href='config/printstyle.css' rel='stylesheet' type='text/css'>";
  echo "<h2>Laporan Sewa CARGO INTERNATIONAL - CASH OUTGOING</h2>";
  echo "<h3>Tanggal $tgl1</h3>";
  
$tampil=mysql_query("SELECT * FROM deliverybill,out_dtbarang_h where deliverybill.no_smubtb=out_dtbarang_h.btb_nobtb AND tglbayar =  '$tgl' AND id_carabayar='1' AND deliverybill.isVoid='0' ORDER BY id_deliverybill DESC");
$no=1;
echo "<table border=1>         <tr><th>NO</th><th>No. BTB</th><th>No. SMU</th><th>Agent</th><th>No. DB</th><th>Berat (KG)</th><th>Hari</th><th>Admin (Rp.)</th><th>Sewa (Rp.)</th><th>PPn (Rp.)</th><th>TOTAL (Rp.)</th></tr>";

$fdokumen=0;
$fstorage=0;
$flain=0;
$ftotal=0;
  while ($r=mysql_fetch_array($tampil)){
$total=$r[document]+$r[overtime]+$r[lain]+$r[storage];
$tgl=ymd2dmy($r[tglbayar]);
//if($r[id_carabayar]=='1'){$stb='CASH';}else{$stb='PERIODICAL';}
$formatdokumen=number_format($r[document], 0, '.', '.');   
$formatstorage=number_format($r[storage], 0, '.', '.');   
$formatlain=number_format($r[lain], 0, '.', '.');   
$formattotal=number_format($total, 0, '.', '.');   
$fdokumen=$fdokumen+$r[document];
$fstorage=$fstorage+$r[storage];
$flain=$flain+$r[lain];
$ftotal=$ftotal+$total;
if($r[id_deliverybill]<10){$nodb='O000000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10 AND $r[id_deliverybill]<100){$nodb='O00000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100 AND $r[id_deliverybill]<1000){$nodb='O0000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000 AND $r[id_deliverybill]<10000){$nodb='O000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10000 AND $r[id_deliverybill]<100000){$nodb='O00'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100000 AND $r[id_deliverybill]<1000000){$nodb='O0'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000000 AND $r[id_deliverybill]<10000000){$nodb='O'.$r[id_deliverybill];}
     echo "<tr><td>$no</td>
          <td>$r[no_smubtb]</td><td>$r[btb_smu]</td><td>$r[btb_agent]</td><td>$nodb</td><td>$r[btb_totalberatbayar]</td><td>$r[hari]</td><td>$formatdokumen</td><td>$formatstorage</td><td>$formatlain</td><td> $formattotal</td>
         </tr>";
     $no++;
  }
  $fdokumen=number_format($fdokumen, 0, '.', '.');
$fstorage=number_format($fstorage, 0, '.', '.');
$flain=number_format($flain, 0, '.', '.');
$ftotal=number_format($ftotal, 0, '.', '.');
      echo "<tr><td colspan=6 align=right><B>TOTAL : </B></td><td><B>$fdokumen</B></td><td><B>$fstorage</B></td><td><B>$flain</B></td><td><B> $ftotal</B></td>
         </tr>";

  echo "</table>";
}
//2 itu utk INCOMING CASH
else if($_GET[i]=='2'){
$tgl=date("Y-m-d");$tgl1=ymd2dmy($tgl);

  echo "<link href='config/printstyle.css' rel='stylesheet' type='text/css'>";
  echo "<h2>Laporan Sewa CARGO INTERNATIONAL - CASH INCOMING</h2>";
  echo "<h3>Tanggal $tgl1</h3>";
  
$tampil=mysql_query("SELECT * FROM deliverybill,in_dtbarang_h where deliverybill.no_smubtb=in_dtbarang_h.no_smu AND tglbayar =  '$tgl' AND id_carabayar='1' AND deliverybill.isVoid='0' ORDER BY id_deliverybill DESC");
$no=1;
echo "<table border=1>         <tr><th>NO</th><th>No. BTB</th><th>Agent</th><th>No. DB</th><th>Berat (KG)</th><th>Hari</th><th>Admin (Rp.)</th><th>Sewa (Rp.)</th><th>PPn (Rp.)</th><th>TOTAL (Rp.)</th></tr>";

$fdokumen=0;
$fstorage=0;
$flain=0;
$ftotal=0;
  while ($r=mysql_fetch_array($tampil)){
$total=$r[document]+$r[overtime]+$r[lain]+$r[storage];
$tgl=ymd2dmy($r[tglbayar]);
//if($r[id_carabayar]=='1'){$stb='CASH';}else{$stb='PERIODICAL';}
$formatdokumen=number_format($r[document], 0, '.', '.');   
$formatstorage=number_format($r[storage], 0, '.', '.');   
$formatlain=number_format($r[lain], 0, '.', '.');   
$formattotal=number_format($total, 0, '.', '.');   
$fdokumen=$fdokumen+$r[document];
$fstorage=$fstorage+$r[storage];
$flain=$flain+$r[lain];
$ftotal=$ftotal+$total;
if($r[id_deliverybill]<10){$nodb='I000000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10 AND $r[id_deliverybill]<100){$nodb='I00000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100 AND $r[id_deliverybill]<1000){$nodb='I0000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000 AND $r[id_deliverybill]<10000){$nodb='I000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10000 AND $r[id_deliverybill]<100000){$nodb='I00'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100000 AND $r[id_deliverybill]<1000000){$nodb='I0'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000000 AND $r[id_deliverybill]<10000000){$nodb='I'.$r[id_deliverybill];}

     echo "<tr><td>$no</td>
          <td>$r[no_smubtb]</td><td></td><td>$nodb</td><td>$r[totalberat]</td><td>$r[hari]</td><td>$formatdokumen</td><td>$formatstorage</td><td>$formatlain</td><td> $formattotal</td>
         </tr>";
     $no++;
  }
  $fdokumen=number_format($fdokumen, 0, '.', '.');
$fstorage=number_format($fstorage, 0, '.', '.');
$flain=number_format($flain, 0, '.', '.');
$ftotal=number_format($ftotal, 0, '.', '.');
      echo "<tr><td colspan=6 align=right><B>TOTAL : </B></td><td><B>$fdokumen</B></td><td><B>$fstorage</B></td><td><B>$flain</B></td><td><B> $ftotal</B></td>
         </tr>";

  echo "</table>";
}




}



// edit no.smu
elseif ($module=='editnosmu'){
if(empty($_POST[nosmu]))
{
	mysql_query("update out_dtbarang_h set btb_smu='$_POST[nosmu]' where id='$_POST[no]'");

}
else
{
	$str=mysql_query("select * from out_dtbarang_h where btb_smu='$_POST[nosmu]'");
	$ada=mysql_num_rows($str);
	if($ada<=0)
	{
		mysql_query("update out_dtbarang_h set btb_smu='$_POST[nosmu]' where id='$_POST[no]'");	mysql_query("update deliverybill set nosmu='$_POST[nosmu]' where no_smubtb='$_POST[nobtb]'");
	}
}	
header('location:media.php?module=dboutgoing');
}


elseif ($module=='release_ambil'){
$tgl=date("Y-m-d");
$tgl1=my2date($_POST[tgl]);
 mysql_query("UPDATE breakdown set status_ambil='INSTORE' where id_breakdown='$_GET[b]'");
 header('location:media.php?module=data');
}
elseif ($module=='release_confirm'){
$tgl=date("Y-m-d");
$tgl1=my2date($_POST[tgl]);
 mysql_query("UPDATE breakdown set status_check='waiting' where id_breakdown='$_GET[b]'");
 header('location:media.php?module=data');
  }







//********************************************

//BTBLEVEL
//cetak BTB
elseif (($module=='btb') AND ($act=='cetak'))
{


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
			$pdf->Cell(60,4,'CAB NGURAH RAI',0,0,'C',1);$pdf->Ln();
			$pdf->Cell(60,4,'KARGO INTERNATIONAL',0,0,'C',1);$pdf->Ln();

			$pdf->Cell(60,4,'-------------------------------------------------------------',0,0,'C',1);			
			$pdf->Ln();		
			$pdf->Cell(60,4,'BUKTI TIMBANG BARANG',0,0,'C',1);$pdf->Ln(5);
			$pdf->Cell(20,4,'No.BTB',0,0,'L',1);
			$pdf->Cell(40,4,': '.$d[btb_nobtb],0,0,'L',1);$pdf->Ln(4);
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

}
//hapus isi BTB
elseif ($module=='isibtb' AND $act=='hapus')
{
			$n1=mysql_query("select * from out_dtbarang where id='$_GET[i]'");
			$q=mysql_fetch_array($n1);

 mysql_query("DELETE FROM out_dtbarang WHERE id='$_GET[i]'");
	

			
			$n2=mysql_query("select * from out_dtbarang_h where id='$_GET[h]'");
			$p=mysql_fetch_array($n2);

;
$pberat=$p[btb_totalberat]-$q[dtBarang_berat];
$pkoli=$p[btb_totalkoli]-$q[dtBarang_koli];
$pvol=$p[btb_totalvolume]-$q[dtBarang_luasdimensi];
$pbayar=$p[btb_totalberatbayar]-$q[dtBarang_brtdibayar];

  		mysql_query("UPDATE out_dtbarang_h
			set btb_totalberat='$pberat',btb_totalkoli='$pkoli',btb_totalvolume='$pvol',
			btb_totalberatbayar='$pbayar' where id='$_GET[h]'");
				
  header('location:media.php?module=btbinput&i='.$_GET[h]);
}
// Input Isi BTB
else if(($module=='isibtb') AND ($act=='input'))
{

  	if(!empty($_POST[berat]))
  	{	
		if($_POST[panjang]==''){$panjang=0;} else{$panjang=$_POST[panjang];} 
		if($_POST[lebar]==''){$lebar=0;} else{$lebar=$_POST[lebar];}
		if($_POST[tinggi]==''){$tinggi=0;}else{$tinggi=$_POST[tinggi];} 				
		if($_POST[koli]==''){$koli=1;} else{$koli=$_POST[koli];}		
		
			$n=mysql_query("select * from out_dtbarang_h where id='$_POST[i]'");
			$p=mysql_fetch_array($n);
		
$luas=($_POST[lebar]*$_POST[panjang]*$_POST[tinggi])/6000;

if($luas>=$_POST[berat]){$beratdibayar=$luas;}else{$beratdibayar=$_POST[berat];}
			mysql_query("INSERT INTO out_dtbarang(dtBarang_berat,dtBarang_panjang,dtBarang_lebar,dtBarang_tinggi,
			dtBarang_luasdimensi,dtBarang_brtdibayar,id_h,dtBarang_koli,dtBarang_type) 
		VALUES('$_POST[berat]','$panjang','$lebar','$tinggi',
			'$luas','$beratdibayar','$_POST[i]','$koli','$_GET[j]') ");
	
$pberat=$p[btb_totalberat]+$_POST[berat];
$pkoli=$p[btb_totalkoli]+$_POST[koli];
$pvol=$p[btb_totalvolume]+$luas;
$pbayar=$p[btb_totalberatbayar]+$beratdibayar;
if($pbayar<=10) { $pbayar=10;}

			mysql_query("UPDATE out_dtbarang_h
			set btb_totalberat='$pberat',btb_totalkoli='$pkoli',btb_totalvolume='$pvol',
			btb_totalberatbayar='$pbayar',posted='1' where id='$_POST[i]'");

		}
		header('location:media.php?module=btbinput&i='.$_POST[i].'&j='.$_GET[j]);
}
// input BTB
elseif ($module=='btb' AND $act=='input')
{
	$tgl=my2date($_POST[tglbtb]);
	$thn = substr($tgl,0,4);
	$a=mysql_query("select btb_nobtb,btb_date from out_dtbarang_h order by id DESC limit 1");
	$b=mysql_fetch_array($a);
	$cthn = substr($b[1],0,4);

	if($cthn<>$thn){$nobtb=$thn.'0000000';}
	else {	$nobtb=$b[0]+1;}
	mysql_query("INSERT INTO out_dtbarang_h(btb_smu,airline,btb_nobtb,btb_date,btb_by,
	isvoid,createdby,createdate,btb_agent,btb_tujuan)
  VALUES('$_POST[nosmu]','$_POST[airline]','$nobtb','$tgl',
	'$_SESSION[namauser]','0','$_SESSION[namauser]', 
	'$tgl','$_POST[agent]','$_POST[tujuan]')") ;
	
$s=mysql_query("select * from out_dtbarang_h order by id DESC limit 1") ;			
$last=mysql_fetch_array($s);
header('location:media.php?module=btbinput&airline='.$_POST[airline].'&i='.$last[0].'&j='.$_POST[jenisbarang]);
//header('location:media.php?module=manifestininput&airline='.$_POST[airline].'&i='.$last[0]);

}

elseif ($module=='btb' AND $act=='hapus')
{
  mysql_query("UPDATE out_dtbarang_h set isvoid='1',editedby='$_SESSION[namauser]' WHERE id='$_GET[i]'");
  header('location:media.php?module=btb');
}
//edit smu btb
elseif ($module=='btb' AND $act=='edit')
{
	$tgl=my2date($_POST[tglbtb]);
	  		mysql_query("UPDATE out_dtbarang_h,out_dtbarang SET out_dtbarang_h.airline='$_POST[airline]',out_dtbarang_h.btb_agent='$_POST[agent]',
out_dtbarang_h.btb_date='$tgl',out_dtbarang_h.btb_tujuan='$_POST[tujuan]',
out_dtbarang_h.btb_smu='$_POST[nosmu]',out_dtbarang.dtBarang_type='$_POST[jenisbarang]' WHERE out_dtbarang_h.id='$_POST[id]'
			AND out_dtbarang_h.id=out_dtbarang.id_h AND out_dtbarang_h.isvoid='0'");
header('location:media.php?module=btb');

}







//END OF BTB LEVEL

//INCOMING LEVEL
// Input manifest incoming
elseif ($module=='manifestin' AND $act=='input')
{
	$tgl=my2date($_POST[tglmanifest]);
  if((!empty($_POST[noflight])) AND (!empty($_POST[acregistration])))
  {
		/*$cek=mysql_query("select * from manifestin where noflight='$_POST[noflight]'
    AND acregistration='$_POST[acregistration]'AND tglmanifest='$tgl' AND isvoid='0'");
 		$ada=mysql_num_rows($cek);
  	if($ada > 0)
  	{
 			header('location:media.php?module=manifestin&p=e');
  	}
  	else
  	{*/
   		mysql_query("INSERT INTO manifestin(airline,noflight,tglmanifest,acregistration,user,isvoid,nil)
      VALUES('$_POST[airline]','$_POST[noflight]','$tgl', '$_POST[acregistration]',
      '$_SESSION[namauser]','0','$_POST[nil]')") ;
$s=mysql_query("select * from manifestin order by id_manifestin DESC limit 1") ;			
$last=mysql_fetch_array($s);
			if(empty($_POST[nil])) //jika manifest NIL
			header('location:media.php?module=manifestininput&airline='.$_POST[airline].'&i='.$last[0]);
			else
			header('location:media.php?module=manifestin');
		//}
	}
	else
	{
		header('location:media.php?module=manifestin');
	}
}







//edit Manifestin
elseif ($module=='manifestin' AND $act=='edit')
{
	$tgl=my2date($_POST[tglmanifest]);
  if((!empty($_POST[noflight])) AND (!empty($_POST[acregistration])))
  {
		$cek=mysql_query("select * from manifestin where noflight='$_POST[noflight]'
    AND acregistration='$_POST[acregistration]'AND tglmanifest='$tgl' AND isvoid='0' 
  	 AND id_manifestin<>'$_POST[i]'");
 		$ada=mysql_num_rows($cek);
  	if($ada > 0)
  	{
 		header('location:media.php?module=manifestin&p=e');
  	}
  	else
  	{
   		mysql_query("UPDATE manifestin SET airline='$_POST[airline]',noflight='$_POST[noflight]',tglmanifest='$tgl',
			acregistration='$_POST[acregistration]',user='$_SESSION[namauser]',nil='$_POST[nil]' WHERE id_manifestin='$_POST[i]' AND status='waiting'");
			header('location:media.php?module=manifestin');
		}
	}
	else {header('location:media.php?module=manifestin');
	}
}
// Input Isi Manifest In
else if(($module=='isimanifestin') AND ($act=='input'))
{
	$tgl=date("Y-m-d");
	$jam = date("H:i:s");
	$thn1 = substr($tgl,2,2);
	$bln1 = substr($tgl,5,2);
	$tgl1= substr($tgl,8,2);
	$jam1 = substr($jam,0,1);
	$jam2 = substr($jam,1,1);
	$men1 = substr($jam,3,2);
	$h=trimString($_POST[nosmu],'-');
	$my="POS-$thn1$bln1 $tgl1$jam1 $jam2$men1 $h";
	if($_POST[agent]=='POST')
	{
	$nosmu=$my;
	}
	else
	{
	$nosmu=$_POST[nosmu];
	}
  $tgl=date("Y-m-d");
  $tgl1=my2date($_POST[tgl]);

//jika cek
	if($_POST[tombol]=='Cek')
	{
	 $str=mysql_query("select SUM(kolidatang),SUM(beratdatang) from 
	 isimanifestin,breakdown where isimanifestin.id_isimanifestin=breakdown.id_isimanifestin 
	 AND isimanifestin.no_smu='$_POST[nosmu]' AND breakdown.b_iscancel='0' GROUP BY isimanifestin.no_smu");
	 $bt_datang=mysql_fetch_array($str);
	 $str=mysql_query("select totalkoli,totalberat from isimanifestin where no_smu='$_POST[nosmu]'");
	 $bt_smu=mysql_fetch_array($str);
	 $sisakoli=$bt_smu[0]-$bt_datang[0];	 
	 $sisaberat=$bt_smu[1]-$bt_datang[1];
	 if($bt_datang[0]<>$bt_smu[0]){$a=1;$k=$sisakoli;$b=$sisaberat;}else {$a=0;$k=$sisakoli;$b=$sisaberat;}
	 header('location:media.php?module=manifestininput&i='.$_POST[idman].'&a='.$a.'&k='.$k.'&b='.$b.'&n='.$_POST[nosmu]);
  }
//jika tidak pake cek	
	else
	{ 
		if($_POST[a]==''){$a='0';} else {$a=$_POST[a];}
  	if((!empty($_POST[nosmu])) AND (!empty($_POST[totalkg])) AND (!empty($_POST[totalkoli])))
  	{	
		if($_POST[totalkg]<=10){$bayar='10';} else {$bayar=$_POST[totalkg];}	
		if($a=='0')
		{
			mysql_query("INSERT INTO isimanifestin(no_smu,user,totalberat,totalkoli,isvoid,
			jenisbarang,status_transit,asal,tujuan,id_manifestin,
			totalberatbayar,status_out,tglmanifest,agent) 
			VALUES('$nosmu','$_SESSION[namauser]','$_POST[totalkg]','$_POST[totalkoli]',
			'0','$_POST[jenisbarang]','$_POST[transit]','$_POST[asal]','$_POST[tujuan]',
			'$_POST[idman]','$bayar','INSTORE','$_POST[tglmanifest]','$_POST[agent]')");
		}
		else 
		{  
			if((!empty($_POST[nosmu])) AND ($_POST[totalkg]<=$_POST[b]) AND ($_POST[totalkoli]<=$_POST[k]))
			mysql_query("INSERT INTO breakdown(kolidatang,beratdatang,tgldatang,id_isimanifestin,
			id_manifestin,beratbayar) 
			VALUES('$_POST[totalkoli]','$_POST[totalkg]','$_POST[tglmanifest]','$_POST[idisiman]',
			'$_POST[idman]','$bayar')");
	//				header('location:media.php?module=splitsmu&n='.$_POST[n].'&i='.$_POST[i]);
		}
		}
		header('location:media.php?module=manifestininput&i='.$_POST[idman].'&airline='.$_POST[airline]);
	}

}

// Hapus isi manifest
elseif ($module=='isimanifestin' AND $act=='hapus')
{
//cek dulu apakah SMU ini tersplit
$cek=mysql_query("select count(*) from breakdown WHERE id_isimanifestin='$_GET[i]'");
$ada=mysql_fetch_array($cek);

	if($ada[0]>1)//berarti sudah ada barang lain yang menggunakan smu yang sama (split)
	{
	mysql_query("DELETE FROM breakdown WHERE id_breakdown='$_GET[b]'");
	}
	else
	{
  mysql_query("DELETE FROM isimanifestin WHERE id_isimanifestin='$_GET[i]'");
	mysql_query("DELETE FROM breakdown WHERE id_isimanifestin='$_GET[i]'");	
	}
  header('location:media.php?module=manifestininput&i='.$_GET[i]);
}
// CANCEL SMU YANG SUDAH ADA DI MANIFEST 
elseif ($module=='isimanifestin' AND $act=='cancel')
{
//jika SMU tersebut belum ada split, artinya bahwa SMU yang sudah 
//diketik ternyata tidak jadi datang maka
//no smu nya perlu ditambahkan parameter unik yaitu tglwaktu
	$tgl=date("Y-m-d");
	$jam = date("H:i:s");
	$thn1 = substr($tgl,0,4);
	$bln1 = substr($tgl,5,2);
	$tgl1= substr($tgl,8,2);
	$jam1 = substr($jam,0,2);
	$men1 = substr($jam,3,2);
	$det1= substr($jam,6,2);
	$my="$_POST[nosmu](CANCEL)";
	//$thn1$bln1$tgl1$jam1$men1$det1";
	

//cek dulu apakah SMU ini tersplit
$cek=mysql_query("select count(*) from breakdown WHERE id_isimanifestin='$_POST[n]'");
$ada=mysql_fetch_array($cek);

	if($ada[0]>1)//berarti sudah ada barang lain yang menggunakan smu yang sama (split)
	{
  mysql_query("UPDATE breakdown set b_iscancel='1',voidby='$_SESSION[namauser]',
	tglvoid='$tgl',keteranganvoid='$_POST[keterangan_void]', beratdatang='0',
	kolidatang='0',beratbayar='0' WHERE id_breakdown='$_POST[b]'");
	}
	else //kalau ternyata tidak ada
	{
  mysql_query("UPDATE isimanifestin set no_smu='$my',iscancel='1',
	editedby='$_SESSION[namauser]',
	editdate='$jam',keterangan_void='$_POST[keterangan_void]'
	WHERE id_isimanifestin='$_POST[n]'");
  mysql_query("UPDATE breakdown set 
	b_iscancel='1',voidby='$_SESSION[namauser]',
	tglvoid='$tgl',keteranganvoid='$_POST[keterangan_void]',beratdatang='0',kolidatang='0', 
	beratbayar='0' WHERE id_breakdown='$_POST[b]'");	
	}
  header('location:media.php?module=barangdatang&n='.$_POST[n].'&i='.$_POST[i]);

}

// Hapus data manifest 
elseif ($module=='manifestin' AND $act=='hapus')
{
  mysql_query("DELETE FROM manifestin WHERE id_manifestin='$_GET[i]'");
  header('location:media.php?module=manifestin');
}

// Hapus data breakdown 
elseif ($module=='breakdown' AND $act=='hapus')
{
  $cek=mysql_query("select * from breakdown where id_isimanifestin='$_GET[n]'");
	$ada=mysql_num_rows($cek);
	if($ada>1){ mysql_query("DELETE FROM breakdown WHERE id_breakdown='$_GET[id]'");}
  header('location:media.php?module=splitsmu&n='.$_GET[n].'&i='.$_GET[i]);
}

// CHECKED Manifest Incoming
elseif (($module=='manifestin') AND ($act=='checked')){
  mysql_query("UPDATE manifestin SET status='checked' WHERE id_manifestin='$_GET[i]'");
  header('location:media.php?module=manifestin');
}
// CHECKED SMU!-confirm
elseif (($module=='manifestin') AND ($act=='smuchecked')){
  mysql_query("UPDATE breakdown SET status_check='confirm' WHERE id_breakdown='$_GET[b]'");
  header('location:media.php?module=barangdatang&i='.$_GET[i]);
}

// keluarkan barang
elseif ($module=='keluarbarangin'){
$tgl=date("Y-m-d");
  mysql_query("UPDATE breakdown SET status_ambil='OUT', tglambil='$tgl' WHERE id_breakdown='$_GET[i]' AND isvoid='0' AND status_bayar='yes'");
  header('location:media.php?module=stockopnamein');
}


// edit isi manifest / breakdown
elseif ($module=='isimanifestin' AND $act=='edit')
{
if((!empty($_POST[totalberat])) AND (!empty($_POST[totalkoli])) AND 
(!empty($_POST[totalberatdatang])) AND (!empty($_POST[totalkolidatang])) 
AND (!empty($_POST[no_smu])) )
{
	//jika berat aktual/datang dibawah dari 10, maka 
	//berat dibayar diubah menjadi 10
	if(($_POST[totalberatdatang]<=10)AND($_POST[totalberatbayar]<=10))
	{$bayar='10';} else 
	{$bayar=$_POST[totalberatbayar];}
//jika tidak ada split atau belum ada confirm utk barang split
if($_POST[adacek]=='0')
{	

//lakukan hanya jika koli datang < koli di SMU , juga berat
if(($_POST[totalkolidatang]<=$_POST[totalkoli])AND ($_POST[totalberatdatang]<=$_POST[totalberat]))
	{
	mysql_query("update breakdown set beratdatang='$_POST[totalberatdatang]',
	kolidatang='$_POST[totalkolidatang]',beratbayar='$bayar'  WHERE id_breakdown='$_POST[b]'");
	}
}
//jika sudah ada yang confirm,
else
{
	//harus dicek dulu berapa total yang sudah datang dari SMU splitannya
 $str=mysql_query("select SUM(kolidatang),SUM(beratdatang) from 
 isimanifestin,breakdown where 
 isimanifestin.id_isimanifestin=breakdown.id_isimanifestin 
 AND isimanifestin.id_isimanifestin='$_POST[n]' GROUP BY isimanifestin.id_isimanifestin");
	$bt_datang=mysql_fetch_array($str);
	$str=mysql_query("select totalkoli,totalberatbayar from isimanifestin where 
	id_isimanifestin='$_POST[n]'");
	$bt_smu=mysql_fetch_array($str);
	//sampai dapat berapa sisanya
	$sisakoli=$bt_smu[0]-$bt_datang[0];	 $sisaberat=$bt_smu[1]-$bt_datang[1];
	 //jika yang datang diinput melebih sisa, tidak bisa !
	 if(($_POST[totalkolidatang]<=$sisakoli) AND ($_POST[totalberatdatang]<=$sisaberat))
	 {
	 mysql_query("update breakdown set beratdatang='$_POST[totalberatdatang]',
	 kolidatang='$_POST[totalkolidatang]',beratbayar='$bayar' WHERE 
	 id_breakdown='$_POST[b]'");
	 }
}
//setelah updating data SMU breakdown, data induknya harus diedit di isimanifestin
mysql_query("update isimanifestin set no_smu='$_POST[no_smu]',totalberat='$_POST[totalberat]', 
totalkoli='$_POST[totalkoli]',jenisbarang='$_POST[jenisbarang]',
status_transit='$_POST[transit]',asal='$_POST[asal]',tujuan='$_POST[tujuan]',
agent='$_POST[agent]' WHERE id_isimanifestin='$_POST[n]'");		
}
header('location:media.php?module=barangdatang&i='.$_POST[i]);
}

// Input breakdown
elseif ($module=='breakdown' AND $act=='input')
{
  $tgl=my2date($_POST[tgldatang]);
if((($_POST[kolidatang]+$_POST[tkolidatang])>$_POST[totalkoli]) OR (($_POST[beratdatang]+$_POST[tberatdatang])>$_POST[totalberat]))
	{
	//echo('location:media.php?module=splitsmu&n='.$_POST[n].'&i='.$_POST[i].'&p=e');
		header('location:media.php?module=splitsmu&n='.$_POST[n].'&i='.$_POST[i].'&p=e');
	}
	else
	{
	 if((!empty($_POST[kolidatang])) AND (!empty($_POST[beratdatang])))
 			 {
	  			mysql_query("INSERT INTO breakdown(kolidatang,beratdatang,tgldatang,id_isimanifestin)
				VALUES('$_POST[kolidatang]','$_POST[beratdatang]','$tgl','$_POST[n]')");
				header('location:media.php?module=splitsmu&n='.$_POST[n].'&i='.$_POST[i]);
			}
 	header('location:media.php?module=splitsmu&n='.$_POST[n].'&i='.$_POST[i]);

	}
	
	
}


//******************* LEVEL OUTGOING

// batal manifest out
elseif ($module=='batalmo'){
if(!empty($_POST[keterangan]))
{
$str=mysql_query("SELECT * FROM manifestout where id_manifestout='$_POST[i]'");
$r=mysql_fetch_array($str);
mysql_query("$_POST[i] INSERT INTO manifestout (airline,noflight,user,tglmanifest,acregistration,
isvoid,voidby,keterangan,status) VALUES ('$r[airline]','$r[noflight]','$r[user]','$r[tglmanifest]','$r[acregistration]',
'1','$_SESSION[namauser]','$_POST[keterangan]','checked')");
mysql_query("UPDATE manifestout SET status='waiting' WHERE id_manifestout='$_POST[i]'");
mysql_query("UPDATE buildup set status_keluar='INSTORE',tglkeluar='' where id_manifestout='$_POST[i]'");
mysql_query("UPDATE out_dtbarang_h,buildup set out_dtbarang_h.status_keluar='INSTORE' where buildup.id_manifestout='$_POST[i]' AND buildup.nosmu=out_dtbarang_h.btb_smu");

mysql_query("UPDATE breakdown,isimanifestin,buildup set breakdown.status_ambil='INSTORE', tglambil='$tgl' where buildup.id_manifestout='$_POST[i]' AND  buildup.nosmu=isimanifestin.no_smu AND 
isimanifestin.id_isimanifestin=breakdown.id_isimanifestin");

  header('location:media.php?module=manifestout');
}
else
header('location:media.php?module=manifestout');
}

// Input manifest outgoing
elseif ($module=='manifestout' AND $act=='input')
{
	$tgl=my2date($_POST[tglmanifest]);
  if((!empty($_POST[noflight])) AND (!empty($_POST[acregistration])))
  {
		$cek=mysql_query("select * from manifestout where noflight='$_POST[noflight]'
    AND acregistration='$_POST[acregistration]'AND tglmanifest='$tgl' AND isvoid='0'");
 		$ada=mysql_num_rows($cek);
  	if($ada > 0)
  	{
 			header('location:media.php?module=manifestout&p=e');
  	}
  	else
  	{
   		mysql_query("INSERT INTO manifestout(airline,noflight,tglmanifest,acregistration,user,isvoid,nil)
      VALUES('$_POST[airline]','$_POST[noflight]','$tgl', '$_POST[acregistration]',
      '$_SESSION[namauser]','0','$_POST[nil]')") ;
	   if(empty($_POST[nil]))
			header('location:media.php?module=manifestoutinput');
		else header('location:media.php?module=manifestout');	
		}
	}
	else
	{
		header('location:media.php?module=manifestout');
	}
}

//edit manifestout
elseif ($module=='manifestout' AND $act=='edit')
{
	$tgl=my2date($_POST[tglmanifest]);
  if((!empty($_POST[noflight])) AND (!empty($_POST[acregistration])))
  {
		$cek=mysql_query("select * from manifestout where noflight='$_POST[noflight]'
    AND acregistration='$_POST[acregistration]'AND tglmanifest='$tgl' AND isvoid='0' 
  	 AND id_manifestout<>'$_POST[i]'");
 		$ada=mysql_num_rows($cek);
  	if($ada > 0)
  	{
 		header('location:media.php?module=manifestout&p=e');
  	}
  	else
  	{
   		mysql_query("UPDATE manifestout SET airline='$_POST[airline]',noflight='$_POST[noflight]',tglmanifest='$tgl',
			acregistration='$_POST[acregistration]',user='$_SESSION[namauser]',nil='$_POST[nil]' WHERE id_manifestout='$_POST[i]' AND status='waiting'");
			header('location:media.php?module=manifestout');
		}
	}
	else {header('location:media.php?module=manifestout');
	}
}
// Input Isi Manifest In
elseif ($module=='isimanifestout' AND $act=='input')
{

if($_POST[tombolcek])
{
$str=mysql_query("SELECT * FROM out_dtbarang_h,out_dtbarang where out_dtbarang_h.id=out_dtbarang.id_h AND out_dtbarang_h.btb_smu='$_POST[nosmu]' AND out_dtbarang_h.status_bayar='yes' GROUP BY out_dtbarang_h.id");
$ada=mysql_num_rows($str);
}
else if($_POST[tombolsimpan])
{
  if((!empty($_POST[nould])) AND (!empty($_POST[nosmu])) AND(!empty($_POST[koli])) AND 
	(!empty($_POST[berat])) AND (!empty($_POST[idman])))
	{
	$cekkoli=$_POST[koli]+$_POST[totalkolibuildup];
	$cekberat=$_POST[berat]+$_POST[totalberatbuildup];	
	if(($cekkoli>$_POST[totalkolismu]) OR ($cekberat>$_POST[totalberatsmu]))

		{
				$e=1;
		}
		else
		{
  	mysql_query("INSERT INTO buildup(nould,id_out_dtbarang_h,koli,berat,id_manifestout,nosmu,status_transit,asal,tujuan,jenisbarang) 
		VALUES('$_POST[nould]','$_POST[idoutdata]','$_POST[koli]','$_POST[berat]','$_POST[idman]','$_POST[nosmu]',
		'$_POST[transit]','$_POST[asal]','$_POST[tujuan]','$_POST[jenisbarang]')");
		 			
		}
	}
}

header('location:media.php?module=manifestoutinput&a='.$ada.'&n='.$_POST[nosmu].'&e='.$e.'&i='.$_POST[idman]);
}

// Hapus isi manifest
elseif ($module=='isimanifestout' AND $act=='hapus')
{
  mysql_query("DELETE FROM buildup WHERE id_buildup='$_GET[n]' AND status_keluar='INSTORE'");
  header('location:media.php?module=manifestoutinput&i='.$_GET[i]);
}
// CANCEL SMU YANG SUDAH ADA DI MANIFEST 
elseif ($module=='isimanifestout' AND $act=='cancel')
{
$tgl=date("Y-m-d");
	$cek=mysql_query("select * from isimanifestout,breakdown WHERE isimanifestout.id_isimanifestout=breakdown.id_isimanifestout AND 
	isimanifestout.id_isimanifestout='$_POST[n]' AND breakdown.status_bayar='yes'");
	$ada=mysql_num_rows($cek);
	if($ada<1)
	{
  mysql_query("UPDATE isimanifestout set isvoid='1',editedby='$_SESSION[namauser]',editdate='$tgl',keterangan_void='$_POST[keterangan_void]'
	WHERE id_isimanifestout='$_POST[n]'");
	}
  header('location:media.php?module=barangdatang&n='.$_POST[n].'&i='.$_POST[i]);

}

// Hapus data manifest 
elseif ($module=='manifestout' AND $act=='hapus')
{
  mysql_query("DELETE FROM manifestout WHERE id_manifestout='$_GET[i]'");
  header('location:media.php?module=manifestout');
}

// Hapus data breakdown 
elseif ($module=='breakdown' AND $act=='hapus')
{
  $cek=mysql_query("select * from breakdown where id_isimanifestout='$_GET[n]'");
	$ada=mysql_num_rows($cek);
	if($ada>1){ mysql_query("DELETE FROM breakdown WHERE id_breakdown='$_GET[id]'");}
  header('location:media.php?module=splitsmu&n='.$_GET[n].'&i='.$_GET[i]);
}

// CHECKED Manifest Outgoing
elseif (($module=='manifestout') AND ($act=='checked')){
$tgl=date("Y-m-d");

mysql_query("UPDATE manifestout SET status='checked' WHERE id_manifestout='$_GET[i]'");
mysql_query("UPDATE buildup set status_keluar='OUT',tglkeluar='$tgl' where id_manifestout='$_GET[i]'");
mysql_query("UPDATE out_dtbarang_h,buildup set out_dtbarang_h.status_keluar='OUT' where buildup.id_manifestout='$_GET[i]' AND buildup.nosmu=out_dtbarang_h.btb_smu");

mysql_query("UPDATE breakdown,isimanifestin,buildup set breakdown.status_ambil='OUT', tglambil='$tgl' where buildup.id_manifestout='$_GET[i]' AND  buildup.nosmu=isimanifestin.no_smu AND 
isimanifestin.id_isimanifestin=breakdown.id_isimanifestin");
  header('location:media.php?module=manifestout');
}

// keluarkan barang
elseif ($module=='keluarbarangin'){
$tgl=date("Y-m-d");
  mysql_query("UPDATE breakdown SET status_ambil='OUT', tglambil='$tgl' WHERE id_breakdown='$_GET[i]' AND isvoid='0' AND status_bayar='yes'");
  header('location:media.php?module=stockopnamein');
}


// edit isi manifest / breakdown
elseif ($module=='isimanifestout' AND $act=='edit')
{
if((!empty($_POST[totalberat])) AND (!empty($_POST[totalkoli])) AND 
(!empty($_POST[totalberatdatang])) AND (!empty($_POST[totalkolidatang])) 
AND (!empty($_POST[no_smu])) )
{
mysql_query("update isimanifestout set 
no_smu='$_POST[no_smu]',totalberat='$_POST[totalberat]',
totalkoli='$_POST[totalkoli]',jenisbarang='$_POST[jenisbarang]',status_transit='$_POST[transit]',
asal='$_POST[asal]',tujuan='$_POST[tujuan]',status_update='yes' WHERE id_isimanifestout='$_POST[n]'");
mysql_query("update breakdown set beratdatang='$_POST[totalberatdatang]',
kolidatang='$_POST[totalkolidatang]' WHERE id_isimanifestout='$_POST[n]'");
}
header('location:media.php?module=barangdatang&i='.$_POST[i]);
}

// Input breakdownb-tidak dipake
elseif ($module=='breakdown' AND $act=='input')
{
  $tgl=my2date($_POST[tgldatang]);
if((($_POST[kolidatang]+$_POST[tkolidatang])>$_POST[totalkoli]) OR (($_POST[beratdatang]+$_POST[tberatdatang])>$_POST[totalberat]))
	{
	//echo('location:media.php?module=splitsmu&n='.$_POST[n].'&i='.$_POST[i].'&p=e');
		header('location:media.php?module=splitsmu&n='.$_POST[n].'&i='.$_POST[i].'&p=e');
	}
	else
	{
	 if((!empty($_POST[kolidatang])) AND (!empty($_POST[beratdatang])))
 			 {
	  			mysql_query("INSERT INTO breakdown(kolidatang,beratdatang,tgldatang,id_isimanifestout)
				VALUES('$_POST[kolidatang]','$_POST[beratdatang]','$tgl','$_POST[n]')");
				header('location:media.php?module=splitsmu&n='.$_POST[n].'&i='.$_POST[i]);
			}
 	header('location:media.php?module=splitsmu&n='.$_POST[n].'&i='.$_POST[i]);

	}
	
	
}




// CARI SMU utk TRACING
elseif ($module=='tracing' AND $act=='caribtbsmu')
{
}

elseif ($module=='flown_ga')
{
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
			$this->Cell(0,10,'GAPURA BALI WMS INTER - Page '.$this->PageNo().'/{nb}',0,0,'C');
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
				
		$str_data=mysql_query("SELECT s.nosmu,f.flight,m.flightdate,d.dest_code,a.agent FROM manifestout as m, master_smu as s,flight as f, origin as o, destination as d,agent as a,customer as c,isimanifestout as i WHERE m.idmanifestout=i.idmanifestout AND m.idflight=f.idflight AND m.statusconfirm='1' AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND o.origin_code='DPS' AND s.idagent=a.idagent AND f.idcustomer=c.idcustomer AND a.agent<>'RPX' AND a.agent<>'POST' AND a.agent<>'GMFAA' AND a.agent<>'GARUDA' AND c.customer='GA' AND i.idmastersmu=s.idmastersmu AND  m.flightdate='$tglawal' 
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
	
	$pdf->Output();
}

elseif ($module=='summary_cargo')
{
$tglawal=my2date($_POST[tglawal]);
$tglakhir=my2date($_POST[tglakhir]);

$k=mysql_query("SELECT nama_lengkap,nipp FROM user where id_user='$_SESSION[namauser]'");
$ka=mysql_fetch_array($k);
$kasir=$ka[0];$nipp=$ka[1];

	class PDF extends FPDF
	{
		//Page header
		function Header()
		{	
			$this->SetFillColor(255,255,255);
			$this->SetFont('Arial','',12);
			$this->Cell(0,8,'PT. GAPURA ANGKASA',0,0,'L');$this->Ln();
			$this->Cell(0,8,'SUMMARY INTERNATIONAL CARGO REPORT',0,0,'L');$this->Ln();
			$this->Cell(0,8,'AIRLINE HANDLING BY GAPURA',0,0,'L');$this->Ln();
			$this->SetFont('Times','I',11);
			$this->Cell(170,8,'Periode : '.$_POST[tglawal].' s/d '.$_POST[tglakhir],0,0,'L',1);
			$this->Ln();$this->Cell(170,8,$_POST[filter],0,0,'L',1);
			$this->Ln(10);
		}
		
		//Page footer
		function Footer()
		{
			$this->SetY(-30);
			$this->SetFont('Arial','I',9);
			$this->Cell(0,10,'GAPURA BALI WMS INTER - Page '.$this->PageNo().'/{nb}',0,0,'C');
		}
	}
	
	$pdf=new PDF('L','mm','A4');
	$pdf->SetMargins(10,10,5);	
	$pdf->AliasNbPages();
	$pdf->Open();
	$pdf->SetAutoPageBreak(on,35);
	$y_axis_initial = 32;
	$y_axis1 = 32;
	$row_height = 6;	
	$y_axis = 32; 
	$pdf->AddPage();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(20,8,'',1,0,'C',1);
	$pdf->Cell(240,8,'BULAN',1,0,'C',1);
	$pdf->CEll(20,8,'',1,0,'C',1);
	$pdf->Ln();
	$pdf->Cell(20,8,'AIRLINE',1,0,'C',1);
	$pdf->Cell(20,8,'JAN',1,0,'C',1);
	$pdf->Cell(20,8,'FEB',1,0,'C',1);	
	$pdf->Cell(20,8,'MAR',1,0,'C',1);
	$pdf->Cell(20,8,'APR',1,0,'C',1);		
	$pdf->Cell(20,8,'MAY',1,0,'C',1);
	$pdf->Cell(20,8,'JUN',1,0,'C',1);	
	$pdf->Cell(20,8,'JUL',1,0,'C',1);
	$pdf->Cell(20,8,'AUG',1,0,'C',1);	
	$pdf->Cell(20,8,'SEP',1,0,'C',1);
	$pdf->Cell(20,8,'OCT',1,0,'C',1);	
	$pdf->Cell(20,8,'NOP',1,0,'C',1);
	$pdf->Cell(20,8,'DEC',1,0,'C',1);	
	$pdf->CEll(20,8,'TOTAL',1,0,'C',1);	
	$pdf->Ln();		
	

//cek utk prosesnya
if($_POST[outin]=='EXPORT')
{$outin=1;} 
else if($_POST[outin]=='IMPORT') 
{$outin=0;}
else if($_POST[outin]=='SEMUA')
{$outin=2;}
else if($_POST[outin]=='TRANSIT')
{$outin=3;}

IF($_POST[filter]=='PER TONASE')
{
if($outin=='2')//SEMUA PROSES SUMMARY CARGO
{
}
else if($outin=='1')//EXPORT PROSES SUMMARY CARGO
{
	if($_POST[airline]=='SEMUA')
	{
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestout as i,manifestout as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND m.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND o.origin_code='DPS' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
	}
	else if($_POST[airline]<>'SEMUA')   
	{
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestout as i,manifestout as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND m.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND cs.customer='$_POST[airline]' AND
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND o.origin_code='DPS' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");		
	}	
		$pdf->SetFont('Arial','BI',9);
		$pdf->Cell(280,8,'EXPORT',0,0,'L',0);
		$pdf->Ln();	 
		$str_airline=mysql_query("select airline from super_daily group by airline");
		while($r1=mysql_fetch_array($str_airline))  
		{
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='01' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$jan=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='02' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$feb=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='03' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$mar=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='04' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$apr=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='05' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$may=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='06' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$jun=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='07' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$jul=$r[0];			
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='08' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$aug=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='09' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$sep=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='10' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$oct=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='11' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$nop=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='12' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$dec=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			WHERE airline='$r1[0]'"));
			$tot=$r[0];			
		
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(20,8,$r1[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,8,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}	
}
else if($outin=='0')//INCOMINGPROSES SUMMARY CARGO
{
}
else if($outin=='3')// TRANSIT PROSES SUMMARY CARGO
{
}

} //END OF PER TONASE
	
ELSE IF($_POST[filter]=='PER KOLI')
{
if($outin=='2')//SEMUA PROSES SUMMARY CARGO - PER KOLI
{
}
else if($outin=='1')//EXPORT PROSES SUMMARY CARGO - PER KOLI
{
	if($_POST[airline]=='SEMUA')
	{
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestout as i,manifestout as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND m.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND o.origin_code='DPS' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
	}
	else if($_POST[airline]<>'SEMUA')   
	{
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestout as i,manifestout as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND m.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND cs.customer='$_POST[airline]' AND
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND o.origin_code='DPS' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");		
	}	
		$pdf->SetFont('Arial','BI',9);
		$pdf->Cell(280,8,'EXPORT',0,0,'L',0);
		$pdf->Ln();	 
		$str_airline=mysql_query("select airline from super_daily group by airline");
		while($r1=mysql_fetch_array($str_airline))  
		{
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='01' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$jan=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='02' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$feb=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='03' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$mar=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='04' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$apr=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='05' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$may=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='06' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$jun=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='07' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$jul=$r[0];			
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='08' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$aug=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='09' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$sep=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='10' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$oct=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='11' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$nop=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='12' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$dec=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			WHERE airline='$r1[0]'"));
			$tot=$r[0];			
		
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(20,8,$r1[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,8,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}	
}
else if($outin=='0')//INCOMING PROSES SUMMARY CARGO - PER KOLI
{
}
else if($outin=='3')// TRANSIT PROSES SUMMARY CARGO -PER KOLI
{
}	

}//END OF PER KOLI

ELSE IF($_POST[filter]=='PER JML SMU')
{
if($outin=='2')//SEMUA PROSES SUMMARY CARGO - PER JML SMU
{
}
else if($outin=='1')//EXPORT PROSES SUMMARY CARGO - PER JML SMU
{
	if($_POST[airline]=='SEMUA')
	{
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestout as i,manifestout as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND m.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND o.origin_code='DPS' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
	}
	else if($_POST[airline]<>'SEMUA')   
	{
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestout as i,manifestout as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND m.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND cs.customer='$_POST[airline]' AND
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND o.origin_code='DPS' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");		
	}	
		$pdf->SetFont('Arial','BI',9);
		$pdf->Cell(280,8,'EXPORT',0,0,'L',0);
		$pdf->Ln();	 
		$str_airline=mysql_query("select airline from super_daily group by airline");
		while($r1=mysql_fetch_array($str_airline))  
		{
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='01' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$jan=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='02' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$feb=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='03' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$mar=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='04' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$apr=$r[0];		
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='05' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$may=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='06' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$jun=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='07' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$jul=$r[0];			
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='08' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$aug=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='09' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$sep=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='10' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$oct=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='11' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$nop=$r[0];		
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='12' AND airline='$r1[0]' group by MONTH(flightdate)"));
			$dec=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			WHERE airline='$r1[0]'"));
			$tot=$r[0];			
		
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(20,8,$r1[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,8,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}	
}
else if($outin=='0')//INCOMING PROSES SUMMARY CARGO - PER JML SMU
{
}
else if($outin=='3')// TRANSIT PROSES SUMMARY CARGO -PER KOLI
{
}	
}// END OF PER JML SMU


ELSE IF($_POST[filter]=='PER COMMODITY')
{
if($outin=='2')//SEMUA PROSES SUMMARY CARGO
{ 
}
else if($outin=='1')//OUTGOIN PROSES SUMMARY CARGO
{
	if($_POST[airline]=='SEMUA')
	{
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestout as i,manifestout as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND m.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND o.origin_code='DPS' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
	}
	else if($_POST[airline]<>'SEMUA')   
	{
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestout as i,manifestout as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND m.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND cs.customer='$_POST[airline]' AND
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND o.origin_code='DPS' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");		
	}	

	
	$pdf->SetFont('Arial','BI',9);
	$pdf->Cell(280,8,'EXPORT',0,0,'L',0);
	$pdf->Ln();	 
  	$str_airline=mysql_query("select airline from super_daily group by airline");
  	while($r1=mysql_fetch_array($str_airline))  
  	{
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(280,8,$r1[0],0,0,'L',0);$pdf->Ln();$pdf->SetFont('Arial','',9);
		$str_data=mysql_query("select commodity from super_daily where flightdate
		BETWEEN '$tglawal' AND '$tglakhir' AND airline='$r1[0]' group by commodity");
		while($r2=mysql_fetch_array($str_data))  
		{
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='01' AND airline='$r1[0]'  AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$jan=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='02' AND airline='$r1[0]'  AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$feb=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='03' AND airline='$r1[0]'  AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$mar=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='04' AND airline='$r1[0]'  AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$apr=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='05' AND airline='$r1[0]'  AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$may=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='06' AND airline='$r1[0]'  AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$jun=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='07' AND airline='$r1[0]'  AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$jul=$r[0];			
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='08' AND airline='$r1[0]'  AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$aug=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='09' AND airline='$r1[0]'  AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$sep=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='10' AND airline='$r1[0]'  AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$oct=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='11' AND airline='$r1[0]'  AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$nop=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='12' AND airline='$r1[0]'  AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$dec=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			WHERE airline='$r1[0]' AND commodity='$r2[0]' "));
			$tot=$r[0];			

			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(20,8,$r2[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,8,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}	
	}
}

} //END OF PER COMMODITY

ELSE IF($_POST[filter]=='PER AIRPORT')
{
if($outin=='2')//SEMUA PROSES SUMMARY CARGO - PER AIRPORT
{ 
}
else if($outin=='1')//EXPORT PROSES SUMMARY CARGO - PER AIRPORT
{
	if($_POST[airline]=='SEMUA')
	{
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestout as i,manifestout as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND m.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND o.origin_code='DPS' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
	}
	else if($_POST[airline]<>'SEMUA')   
	{
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestout as i,manifestout as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND m.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND cs.customer='$_POST[airline]' AND
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND o.origin_code='DPS' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");		
	}	

	$pdf->SetFont('Arial','BI',9);
	$pdf->Cell(280,8,'EXPORT',0,0,'L',0);
	$pdf->Ln();	 
  	$str_airline=mysql_query("select airline from super_daily group by airline");
  	while($r1=mysql_fetch_array($str_airline))  
  	{
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(280,8,$r1[0],0,0,'L',0);$pdf->Ln(8);
		$str_airport=mysql_query("select destination from super_daily 
		where flightdate BETWEEN '$tglawal' AND '$tglakhir' AND airline='$r1[0]' group by destination");
		
		while($ra=mysql_fetch_array($str_airport))  
		{
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(20,8,$ra[0],0,0,'C',0);$pdf->Ln(8);

		$str_data=mysql_query("select commodity from super_daily 
		where flightdate BETWEEN '$tglawal' AND '$tglakhir' AND airline='$r1[0]' AND 
		destination='$ra[0]' group by commodity");
		while($r2=mysql_fetch_array($str_data))  
		{
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='01' AND airline='$r1[0]'  AND commodity='$r2[0]' 
			AND destination='$ra[0]' group by MONTH(flightdate)"));
			$jan=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='02' AND airline='$r1[0]'  AND commodity='$r2[0]' AND destination='$ra[0]' group by MONTH(flightdate)"));
			$feb=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='03' AND airline='$r1[0]'  AND commodity='$r2[0]' AND destination='$ra[0]' group by MONTH(flightdate)"));
			$mar=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='04' AND airline='$r1[0]'  AND commodity='$r2[0]' AND destination='$ra[0]' group by MONTH(flightdate)"));
			$apr=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='05' AND airline='$r1[0]'  AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$may=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='06' AND airline='$r1[0]'  AND commodity='$r2[0]' AND destination='$ra[0]' group by MONTH(flightdate)"));
			$jun=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='07' AND airline='$r1[0]'  AND commodity='$r2[0]' AND destination='$ra[0]' group by MONTH(flightdate)"));
			$jul=$r[0];			
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='08' AND airline='$r1[0]'  AND commodity='$r2[0]' AND destination='$ra[0]' group by MONTH(flightdate)"));
			$aug=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='09' AND airline='$r1[0]'  AND commodity='$r2[0]' AND destination='$ra[0]' group by MONTH(flightdate)"));
			$sep=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='10' AND airline='$r1[0]'  AND commodity='$r2[0]' AND destination='$ra[0]' group by MONTH(flightdate)"));
			$oct=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='11' AND airline='$r1[0]'  AND commodity='$r2[0]' AND destination='$ra[0]' group by MONTH(flightdate)"));
			$nop=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='12' AND airline='$r1[0]'  AND commodity='$r2[0]' AND destination='$ra[0]' group by MONTH(flightdate)"));
			$dec=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			WHERE airline='$r1[0]' AND commodity='$r2[0]' AND destination='$ra[0]' "));
			$tot=$r[0];		
			
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(20,8,$r2[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,8,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,8,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,8,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}	
		}
	}
} // end of export - PER AIRPORT
else if($outin=='0')//IMPORT PROSES SUMMARY CARGO - PER AIRPORT
{
} // END OF IMPORT PER AIRPORT

} // END OF PER AIRPORT
//*************************		
	$pdf->Output();
}

elseif ($module=='daily_cargo')
{
$tglawal=my2date($_POST[tglawal]);

$k=mysql_query("SELECT nama_lengkap,code,nipp FROM user where id_user='$_SESSION[namauser]'");
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
			$this->Cell(0,8,'LAPORAN HARIAN CARGO INTERNATIONAL',0,0,'L');
			$this->Ln();
			$this->SetFont('Times','I',11);
			$this->Cell(170,8,'Tanggal : '.$_POST[tglawal],0,0,'L',1);

	$this->Ln(10);
				
		}
		
		//Page footer
		function Footer()
		{
			//Position at 1.5 cm from bottom
			$this->SetY(-80);
			//Arial italic 8
			$this->SetFont('Arial','I',9);
			//Page number
			$this->Cell(0,10,'GAPURA BALI WMS INTER - Page '.$this->PageNo().'/{nb}',0,0,'R');
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


//cek utk prosesnya
if($_POST[outin]=='EXPORT')
{$outin=1;} 
else if($_POST[outin]=='IMPORT') 
{$outin=0;}
else if($_POST[outin]=='SEMUA')
{$outin=2;}
else if($_POST[outin]=='TRANSIT')
{$outin=3;}


	    $pdf->AddPage();
					$pdf->SetFillColor(255,255,255);


$no=0;
if($outin=='2') //START OF SEMUA DAILY
{
}//END OF SEMUA DAILY
else if($outin=='0') //START OF IMPORT DAILY
{
}
if($outin=='1')//START OF EXPORT DAILY
{
mysql_query("delete from super_daily"); 
mysql_query("insert into super_daily 
SELECT 
s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
d.dest_code,d.dest_code  
FROM isimanifestout as i,manifestout as m, master_smu as s,flight as f,
commodity_ap as cp, commodity as c,origin as o, destination as d WHERE 
i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND m.idflight=f.idflight AND m.statusconfirm='1' AND s.idcommodityap=cp.idcommodityap AND 
cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND m.flightdate='$tglawal' AND o.origin_code='DPS'
");
	$pdf->SetFont('Arial','I',12);
	$pdf->Cell(170,8,'EXPORT',0,0,'L',1);	
	$pdf->Ln();
	$str_kategori=mysql_query("select commodity from super_daily 
	where statusnil='' group by commodity 
	order by commodity ASC");
	$tbrt=0;$tkol=0;$tqty=0;
	$brt=0;$kol=0;$qty=0;	
	$no+=1;
  	while($rr=mysql_fetch_array($str_kategori))  
  	{
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(25,5,$rr[commodity],1,0,'C',1);
		$pdf->Cell(30,5,'KG',1,0,'C',1);
		$pdf->Cell(30,5,'COLLIE',1,0,'C',1);
		$pdf->Cell(25,5,'AWB QTY',1,0,'C',1);
		$pdf->Ln();
		$str_data=mysql_query("select flight,sum(berat) as sumberat,sum(koli) as sumkoli,count(noawb) as jsmu from super_daily where commodity='$rr[commodity]' 
AND statusnil='' GROUP BY flight");
			$no+=1;
  			while($rrr=mysql_fetch_array($str_data))  
  			{   
			$pdf->SetFont('Arial','',9);

				$pdf->Cell(25,5,$rrr[flight],1,0,'L',1);
				$pdf->Cell(30,5,number_format($rrr[sumberat],1, ',', '.'),1,0,'R',1);
				$pdf->Cell(30,5,number_format($rrr[sumkoli], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($rrr[jsmu], 0, '.', '.'),1,0,'R',1);
				$pdf->Ln();
				$brt=$rrr[sumberat]+$brt;$kol=$kol+$rrr[sumkoli];$qty=$qty+$rrr[jsmu];
				$no+=1;

		}		
						$pdf->Ln(2);$no+=1;
		
}
//utk yang NIL export

		$ni=mysql_query("select flight,sum(berat) as sumberat,sum(koli) as sumkoli,count(noawb) as jsmu from super_daily where commodity='$rr[commodity]' 
AND statusnil='1' GROUP BY flight");

if(mysql_num_rows($ni)>0){

	$pdf->SetFont('Arial','',12);

			$pdf->Cell(25,5,'NIL',1,0,'C',1);
			$pdf->Cell(30,5,'KG',1,0,'C',1);
			$pdf->Cell(30,5,'COLLIE',1,0,'C',1);
			$pdf->Cell(25,5,'AWB QTY',1,0,'C',1);
			$pdf->Ln();$no+=1;
  			while($rrr=mysql_fetch_array($ni))  
  			{   
			$pdf->SetFont('Arial','',9);

				$pdf->Cell(25,5,$rrr[flight],1,0,'L',1);
				$pdf->Cell(30,5,'0',1,0,'R',1);
				$pdf->Cell(30,5,'0',1,0,'R',1);
				$pdf->Cell(25,5,'0',1,0,'R',1);
				$pdf->Ln();
				$brt=$rrr[sumberat]+$brt;$kol=$kol+$rrr[sumkoli];$qty=$qty+$rrr[jsmu];
				$no+=1;

		}

				$pdf->Ln(2);$no+=1;
}
$pdf->SetFont('Arial','',12);
				$pdf->Cell(25,5,'TOTAL',1,0,'R',1);
				$pdf->Cell(30,5,number_format($brt, 1, ',', '.'),1,0,'R',1);
				$pdf->Cell(30,5,number_format($kol, 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($qty, 0, '.', '.'),1,0,'R',1);
				$pdf->Ln(15);	$no+=1;

}//END OF EXPORT
else if($outin=='3') //START OF EXPORT
{
mysql_query("delete from super_daily"); 
mysql_query("insert into super_daily 
SELECT 
s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
d.dest_code,d.dest_code  
FROM isimanifestout as i,manifestout as m, master_smu as s,flight as f,
commodity_ap as cp, commodity as c,origin as o, destination as d WHERE 
i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND m.idflight=f.idflight AND m.statusconfirm='1' AND s.idcommodityap=cp.idcommodityap AND 
cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND m.flightdate='$tglawal' AND o.origin_code<>'DPS'
");
	$pdf->SetFont('Arial','I',12);
	$pdf->Cell(170,8,'EXPORT',0,0,'L',1);	
	$pdf->Ln();
	$str_kategori=mysql_query("select commodity from super_daily 
where statusnil='' group by commodity 
	order by commodity ASC");
	$tbrt=0;$tkol=0;$tqty=0;
	$brt=0;$kol=0;$qty=0;	
	$no+=1;
  	while($rr=mysql_fetch_array($str_kategori))  
  	{
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(25,5,$rr[commodity],1,0,'C',1);
		$pdf->Cell(30,5,'KG',1,0,'C',1);
		$pdf->Cell(30,5,'COLLIE',1,0,'C',1);
		$pdf->Cell(25,5,'AWB QTY',1,0,'C',1);
		$pdf->Ln();
		$str_data=mysql_query("select flight,sum(berat) as sumberat,sum(koli) as sumkoli,count(noawb) as jsmu from super_daily where commodity='$rr[commodity]' 
AND statusnil='' GROUP BY flight");
			$no+=1;
  			while($rrr=mysql_fetch_array($str_data))  
  			{   
			$pdf->SetFont('Arial','',9);

				$pdf->Cell(25,5,$rrr[flight],1,0,'L',1);
				$pdf->Cell(30,5,number_format($rrr[sumberat],1, ',', '.'),1,0,'R',1);
				$pdf->Cell(30,5,number_format($rrr[sumkoli], 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($rrr[jsmu], 0, '.', '.'),1,0,'R',1);
				$pdf->Ln();
				$brt=$rrr[sumberat]+$brt;$kol=$kol+$rrr[sumkoli];$qty=$qty+$rrr[jsmu];
				$no+=1;

		}		
						$pdf->Ln(2);$no+=1;
		
}
//utk yang NIL export/transit

		$ni=mysql_query("select flight,sum(berat) as sumberat,sum(koli) as sumkoli,count(noawb) as jsmu from super_daily where commodity='$rr[commodity]' 
AND statusnil='1' GROUP BY flight");

if(mysql_num_rows($ni)>0){

	$pdf->SetFont('Arial','',12);

			$pdf->Cell(25,5,'NIL',1,0,'C',1);
			$pdf->Cell(30,5,'KG',1,0,'C',1);
			$pdf->Cell(30,5,'COLLIE',1,0,'C',1);
			$pdf->Cell(25,5,'AWB QTY',1,0,'C',1);
			$pdf->Ln();$no+=1;
  			while($rrr=mysql_fetch_array($ni))  
  			{   
			$pdf->SetFont('Arial','',9);

				$pdf->Cell(25,5,$rrr[flight],1,0,'L',1);
				$pdf->Cell(30,5,'0',1,0,'R',1);
				$pdf->Cell(30,5,'0',1,0,'R',1);
				$pdf->Cell(25,5,'0',1,0,'R',1);
				$pdf->Ln();
				$brt=$rrr[sumberat]+$brt;$kol=$kol+$rrr[sumkoli];$qty=$qty+$rrr[jsmu];
				$no+=1;

		}

				$pdf->Ln(2);$no+=1;
}//END OF TRANSIT DAILY
$pdf->SetFont('Arial','',12);
				$pdf->Cell(25,5,'TOTAL',1,0,'R',1);
				$pdf->Cell(30,5,number_format($brt, 1, ',', '.'),1,0,'R',1);
				$pdf->Cell(30,5,number_format($kol, 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($qty, 0, '.', '.'),1,0,'R',1);
				$pdf->Ln(15);	$no+=1;
}
//end of incoming,outgoing dan transit

  				$pdf->Cell(50,6,'Yang Menyerahkan',0,0,'C',1);
				 $pdf->Cell(15,6,'',0,0,'C',1);

				 $pdf->Cell(50,6,'Mengetahui',0,0,'C',1);
				$pdf->Ln(20);	
  				$pdf->Cell(50,6,'( ..................................... )',0,0,'C',1); 
  				$pdf->Cell(15,6,'',0,0,'C',1); 				
				$pdf->Cell(50,6,'( ..................................... )',0,0,'C',1);
				$pdf->Ln(15);		

	$pdf->Output();
}

// periodic cargo
elseif ($module=='period_cargo')
{
$tglawal=my2date($_POST[tglawal]);
$tglakhir=my2date($_POST[tglakhir]);

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
			$this->Cell(0,8,'LAPORAN CARGO CARGO INTERNATIONAL',0,0,'L');
			$this->Ln();
			$this->SetFont('Times','I',11);
			$this->Cell(170,8,'Tanggal : '.$_POST[tglawal].' until '.$_POST[tglakhir],0,0,'L',1);

	$this->Ln(10);
				
		}
		
		//Page footer
		function Footer()
		{
			//Position at 1.5 cm from bottom
			$this->SetY(-80);
			//Arial italic 8
			$this->SetFont('Arial','I',9);
			//Page number
			$this->Cell(0,10,'GAPURA BALI WMS INTER - Page '.$this->PageNo().'/{nb}',0,0,'R');
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

		
if($_POST[bt_preview]=='Per Airport')
{
	if($_POST[outin]=='EXPORT'){$outin=1;} 
	else if($_POST[outin]=='IMPORT') {$outin=0;}
	else if($_POST[outin]=='SEMUA'){$outin=2;}
	else if($_POST[outin]=='TRANSIT'){$outin=3;}
	$pdf->AddPage();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Times','I',11);
	//********************
	$ggtbrt=0;$ggtkol=0;$ggtqty=0;
	mysql_query("delete from super_daily"); 

	// filtering SQL
	if($outin=='1') //START OF EXPORT
	{
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestout as i,manifestout as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND m.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND o.origin_code='DPS' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
		
		$pdf->SetFont('Arial','I',12);
		$pdf->Cell(170,8,'EXPORT',0,0,'L',1);	
		$pdf->Ln();
		$gtbrt=0;$gtkol=0;$gtqty=0;		
			
		//filtering airline
		 if($_POST[airline]=='SEMUA') //SEMUA AIRLINE
		{
			$str_airline_nonil=mysql_query("select airline from super_daily 
			WHERE statusnil='' group by airline order by airline ASC");
			$str_airline_nil=mysql_query("select airline from super_daily 
			WHERE statusnil='1' group by airline order by airline ASC");
		}
		else
		{
			$str_airline_nonil=mysql_query("select airline from super_daily 
			WHERE statusnil='' AND airline='$_POST[airline]' group by airline order by airline ASC");
			$str_airline_nil=mysql_query("select airline from super_daily 
			WHERE statusnil='1' AND airline='$_POST[airline]' group by airline order by airline ASC");
		}
		
		//untuk yang tidak nil dulu
		while($r=mysql_fetch_array($str_airline_nonil))  
		{
			$pdf->SetFont('Arial','',12);
			$pdf->Cell(25,8,$r[airline],0,0,'C',0);
			$pdf->Ln();
			
			$str_airport=mysql_query("select destination from super_daily where airline='$r[airline]' 
			AND statusnil='' group by destination");
			while($rs=mysql_fetch_array($str_airport))  
			{
			$pdf->SetFont('Arial','',12);
			$pdf->Cell(25,8,$rs[destination],0,0,'C',0);
			$pdf->Ln();
			
			$str_kategori=mysql_query("select commodity from super_daily where airline='$r[airline]' 
			AND statusnil='' AND destination='$rs[destination]' group by commodity");
			$tbrt=0;$tkol=0;$tqty=0;
			
			while($rr=mysql_fetch_array($str_kategori))  
			{
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(35,5,$rr[commodity],1,0,'C',1);
				$pdf->Cell(35,5,'BERAT(KG)',1,0,'C',1);
				$pdf->Cell(35,5,'COLLIE',1,0,'C',1);
				$pdf->Cell(25,5,'AWB QTY',1,0,'C',1);
				$pdf->Ln();
				$brt=0;$kol=0;$qty=0;
				$str_data=mysql_query("select flight,sum(berat) as sumberat,
				sum(koli) as sumkoli,count(noawb) as jsmu from super_daily where 
				commodity='$rr[commodity]' AND airline='$r[airline]' AND statusnil='' GROUP BY flight");
				while($rrr=mysql_fetch_array($str_data))  			
				{   
					$pdf->SetFont('Arial','',9);
					$pdf->Cell(35,5,$rrr[flight],1,0,'L',1);
					$pdf->Cell(35,5,number_format($rrr[sumberat],1, ',', '.'),1,0,'R',1);
					$pdf->Cell(35,5,number_format($rrr[sumkoli], 0, '.', '.'),1,0,'R',1);
					$pdf->Cell(25,5,number_format($rrr[jsmu], 0, '.', '.'),1,0,'R',1);
					$pdf->Ln();
					$brt=$brt+$rrr[sumberat];$kol=$kol+$rrr[sumkoli];$qty=$qty+$rrr[jsmu];
				}		
				$tbrt=$tbrt+$brt;$tkol=$tkol+$kol;$tqty=$tqty+$qty;
			}	
				$pdf->Cell(35,0,'',1,0,'C',1);
				$pdf->Cell(35,5,number_format($tbrt, 1, ',', '.'),1,0,'R',1);
				$pdf->Cell(35,5,number_format($tkol, 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($tqty, 0, '.', '.'),1,0,'R',1);
				$pdf->Ln(8);
				$gtbrt=$gtbrt+$tbrt;$gtkol=$gtkol+$tkol;$gtqty=$tqty+$gtqty;		
		}	
		}

//untuk NIL
		if(mysql_num_rows($str_airline_nil)>0)
		{
			while($rr=mysql_fetch_array($str_airline_nil))  
			{
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(35,5,'NIL',1,0,'C',1);
				$pdf->Cell(35,5,'BERAT(KG)',1,0,'C',1);
				$pdf->Cell(35,5,'COLLIE',1,0,'C',1);
				$pdf->Cell(25,5,'AWB QTY',1,0,'C',1);
				$pdf->Ln();
				$brt=0;$kol=0;$qty=0;
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(35,5,$rrr[flight],1,0,'L',1);
				$pdf->Cell(35,5,number_format(0,1, ',', '.'),1,0,'R',1);
				$pdf->Cell(35,5,number_format(0, 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format(0, 0, '.', '.'),1,0,'R',1);
				$pdf->Ln();
			}	
		}
		
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',12);	
		$pdf->Cell(35,5,'TOTAL',1,0,'C',1);
		$pdf->Cell(35,5,number_format($gtbrt, 1, ',', '.'),1,0,'R',1);
		$pdf->Cell(35,5,number_format($gtkol, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($gtqty, 0, '.', '.'),1,0,'R',1);
		$pdf->Ln(10);		
	}//END OF EXPORT
	else if($outin=='0') // START OF IMPORT
	{
	}//END OF PERIOD IMPORT
	else if($outin=='2') // START OF SEMUA
	{
	}//END OF PERIOD SEMUA
	else if($outin=='3') // START OF TRANSIT
	{
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestout as i,manifestout as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND m.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND o.origin_code<>'DPS' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
		
		$pdf->SetFont('Arial','I',12);
		$pdf->Cell(170,8,'EXPORT',0,0,'L',1);	
		$pdf->Ln();
		$gtbrt=0;$gtkol=0;$gtqty=0;		
			
		//filtering airline
		 if($_POST[airline]=='SEMUA') //SEMUA AIRLINE
		{
			$str_airline_nonil=mysql_query("select airline from super_daily 
			WHERE statusnil='' group by airline order by airline ASC");
			$str_airline_nil=mysql_query("select airline from super_daily 
			WHERE statusnil='1' group by airline order by airline ASC");
		}
		else
		{
			$str_airline_nonil=mysql_query("select airline from super_daily 
			WHERE statusnil='' AND airline='$_POST[airline]' group by airline order by airline ASC");
			$str_airline_nil=mysql_query("select airline from super_daily 
			WHERE statusnil='1' AND airline='$_POST[airline]' group by airline order by airline ASC");
		}
		
		//untuk yang tidak nil dulu
		while($r=mysql_fetch_array($str_airline_nonil))  
		{
			$pdf->SetFont('Arial','',12);
			$pdf->Cell(25,8,$r[airline],0,0,'C',0);
			$pdf->Ln();
			
			$str_airport=mysql_query("select destination from super_daily where airline='$r[airline]' 
			AND statusnil='' group by destination");
			while($rs=mysql_fetch_array($str_airport))  
			{
			$pdf->SetFont('Arial','',12);
			$pdf->Cell(25,8,$rs[destination],0,0,'C',0);
			$pdf->Ln();
			
			$str_kategori=mysql_query("select commodity from super_daily where airline='$r[airline]' 
			AND statusnil='' AND destination='$rs[destination]' group by commodity");
			$tbrt=0;$tkol=0;$tqty=0;
			
			while($rr=mysql_fetch_array($str_kategori))  
			{
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(35,5,$rr[commodity],1,0,'C',1);
				$pdf->Cell(35,5,'BERAT(KG)',1,0,'C',1);
				$pdf->Cell(35,5,'COLLIE',1,0,'C',1);
				$pdf->Cell(25,5,'AWB QTY',1,0,'C',1);
				$pdf->Ln();
				$brt=0;$kol=0;$qty=0;
				$str_data=mysql_query("select flight,sum(berat) as sumberat,
				sum(koli) as sumkoli,count(noawb) as jsmu from super_daily where 
				commodity='$rr[commodity]' AND airline='$r[airline]' AND statusnil='' GROUP BY flight");
				while($rrr=mysql_fetch_array($str_data))  			
				{   
					$pdf->SetFont('Arial','',9);
					$pdf->Cell(35,5,$rrr[flight],1,0,'L',1);
					$pdf->Cell(35,5,number_format($rrr[sumberat],1, ',', '.'),1,0,'R',1);
					$pdf->Cell(35,5,number_format($rrr[sumkoli], 0, '.', '.'),1,0,'R',1);
					$pdf->Cell(25,5,number_format($rrr[jsmu], 0, '.', '.'),1,0,'R',1);
					$pdf->Ln();
					$brt=$brt+$rrr[sumberat];$kol=$kol+$rrr[sumkoli];$qty=$qty+$rrr[jsmu];
				}		
				$tbrt=$tbrt+$brt;$tkol=$tkol+$kol;$tqty=$tqty+$qty;
			}	
				$pdf->Cell(35,0,'',1,0,'C',1);
				$pdf->Cell(35,5,number_format($tbrt, 1, ',', '.'),1,0,'R',1);
				$pdf->Cell(35,5,number_format($tkol, 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($tqty, 0, '.', '.'),1,0,'R',1);
				$pdf->Ln(8);
				$gtbrt=$gtbrt+$tbrt;$gtkol=$gtkol+$tkol;$gtqty=$tqty+$gtqty;		
		}	
		}

//untuk NIL
		if(mysql_num_rows($str_airline_nil)>0)
		{
			while($rr=mysql_fetch_array($str_airline_nil))  
			{
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(35,5,'NIL',1,0,'C',1);
				$pdf->Cell(35,5,'BERAT(KG)',1,0,'C',1);
				$pdf->Cell(35,5,'COLLIE',1,0,'C',1);
				$pdf->Cell(25,5,'AWB QTY',1,0,'C',1);
				$pdf->Ln();
				$brt=0;$kol=0;$qty=0;
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(35,5,$rrr[flight],1,0,'L',1);
				$pdf->Cell(35,5,number_format(0,1, ',', '.'),1,0,'R',1);
				$pdf->Cell(35,5,number_format(0, 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format(0, 0, '.', '.'),1,0,'R',1);
				$pdf->Ln();
			}	
		}
		
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',12);	
		$pdf->Cell(35,5,'TOTAL',1,0,'C',1);
		$pdf->Cell(35,5,number_format($gtbrt, 1, ',', '.'),1,0,'R',1);
		$pdf->Cell(35,5,number_format($gtkol, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($gtqty, 0, '.', '.'),1,0,'R',1);
		$pdf->Ln(10);			

	}//END OF PERIOD TRANSIT	
	
}
else if($_POST[bt_preview]=='Preview')
{
	if($_POST[outin]=='EXPORT'){$outin=1;} 
	else if($_POST[outin]=='IMPORT') {$outin=0;}
	else if($_POST[outin]=='SEMUA'){$outin=2;}
	else if($_POST[outin]=='TRANSIT'){$outin=3;}
	$pdf->AddPage();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Times','I',11);
	//********************
	$ggtbrt=0;$ggtkol=0;$ggtqty=0;
	mysql_query("delete from super_daily"); 

	// filtering SQL
	if($outin=='1') //START OF EXPORT
	{
		mysql_query("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestout as i,manifestout as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND m.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND o.origin_code='DPS' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
		
		$pdf->SetFont('Arial','I',12);
		$pdf->Cell(170,8,'EXPORT',0,0,'L',1);	
		$pdf->Ln();
		$gtbrt=0;$gtkol=0;$gtqty=0;		
			
		//filtering airline
		 if($_POST[airline]=='SEMUA') //SEMUA AIRLINE
		{
			$str_airline_nonil=mysql_query("select airline from super_daily 
			WHERE statusnil='' group by airline order by airline ASC");
			$str_airline_nil=mysql_query("select airline from super_daily 
			WHERE statusnil='1' group by airline order by airline ASC");
		}
		else
		{
			$str_airline_nonil=mysql_query("select airline from super_daily 
			WHERE statusnil='' AND airline='$_POST[airline]' group by airline order by airline ASC");
			$str_airline_nil=mysql_query("select airline from super_daily 
			WHERE statusnil='1' AND airline='$_POST[airline]' group by airline order by airline ASC");
		}
		
		//untuk yang tidak nil dulu
		while($r=mysql_fetch_array($str_airline_nonil))  
		{
			$pdf->SetFont('Arial','',12);
			$pdf->Cell(25,8,$r[airline],0,0,'C',0);
			$pdf->Ln();
			$str_kategori=mysql_query("select commodity from super_daily where airline='$r[airline]' 
			AND statusnil='' group by commodity");
			$tbrt=0;$tkol=0;$tqty=0;
			
			while($rr=mysql_fetch_array($str_kategori))  
			{
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(35,5,$rr[commodity],1,0,'C',1);
				$pdf->Cell(35,5,'BERAT(KG)',1,0,'C',1);
				$pdf->Cell(35,5,'COLLIE',1,0,'C',1);
				$pdf->Cell(25,5,'AWB QTY',1,0,'C',1);
				$pdf->Ln();
				$brt=0;$kol=0;$qty=0;
				$str_data=mysql_query("select flight,sum(berat) as sumberat,
				sum(koli) as sumkoli,count(noawb) as jsmu from super_daily where 
				commodity='$rr[commodity]' AND airline='$r[airline]' AND statusnil='' GROUP BY flight");
				while($rrr=mysql_fetch_array($str_data))  			
				{   
					$pdf->SetFont('Arial','',9);
					$pdf->Cell(35,5,$rrr[flight],1,0,'L',1);
					$pdf->Cell(35,5,number_format($rrr[sumberat],1, ',', '.'),1,0,'R',1);
					$pdf->Cell(35,5,number_format($rrr[sumkoli], 0, '.', '.'),1,0,'R',1);
					$pdf->Cell(25,5,number_format($rrr[jsmu], 0, '.', '.'),1,0,'R',1);
					$pdf->Ln();
					$brt=$brt+$rrr[sumberat];$kol=$kol+$rrr[sumkoli];$qty=$qty+$rrr[jsmu];
				}		
				$pdf->Cell(35,0,'',1,0,'C',1);
				$pdf->Cell(35,5,number_format($brt, 1, ',', '.'),1,0,'R',1);
				$pdf->Cell(35,5,number_format($kol, 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($qty, 0, '.', '.'),1,0,'R',1);
				$pdf->Ln(8);
				$tbrt=$tbrt+$brt;$tkol=$tkol+$kol;$tqty=$tqty+$qty;
			}	
			$gtbrt=$gtbrt+$tbrt;$gtkol=$gtkol+$tkol;$gtqty=$tqty+$gtqty;	
		}
		
		//untuk yang NIL
		if(mysql_num_rows($str_airline_nil)>0)
		{
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(35,5,'NIL',1,0,'C',1);
			$pdf->Cell(35,5,'BERAT(KG)',1,0,'C',1);
			$pdf->Cell(35,5,'COLLIE',1,0,'C',1);
			$pdf->Cell(25,5,'AWB QTY',1,0,'C',1);
			$pdf->Ln();
			while($rrr=mysql_fetch_array($str_airline_nil))  			
			{   
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(35,5,$rrr[flight],1,0,'L',1);
				$pdf->Cell(35,5,'0',1,0,'R',1);
				$pdf->Cell(35,5,'0',1,0,'R',1);
				$pdf->Cell(25,5,'0',1,0,'R',1);
				$pdf->Ln();
				$brt=$rrr[sumberat]+$brt;$kol=$kol+$rrr[sumkoli];$qty=$qty+$rrr[jsmu];
			}		
			$pdf->Ln();
			$gtbrt=$gtbrt+$tbrt;$gtkol=$gtkol+$tkol;$gtqty=$tqty+$gtqty;
			$pdf->Cell(35,5,'TOTAL '.$r[airline],1,0,'C',1);
			$pdf->Cell(35,5,number_format($tbrt, 1, ',', '.'),1,0,'R',1);
			$pdf->Cell(35,5,number_format($tkol, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(25,5,number_format($tqty, 0, '.', '.'),1,0,'R',1);
			$pdf->Ln(10);									
		}
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',12);	
		$pdf->Cell(35,5,'TOTAL EXPORT',1,0,'C',1);
		$pdf->Cell(35,5,number_format($gtbrt, 1, ',', '.'),1,0,'R',1);
		$pdf->Cell(35,5,number_format($gtkol, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($gtqty, 0, '.', '.'),1,0,'R',1);
		$pdf->Ln(10);		
	}//END OF EXPORT
	else if($outin=='0') // START OF IMPORT
	{
	}//END OF PERIOD IMPORT
	else if($outin=='2') // START OF SEMUA
	{
	}//END OF PERIOD SEMUA
	else if($outin=='3') // START OF TRANSIT
	{
		mysql_query("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestout as i,manifestout as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND m.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND o.origin_code<>'DPS' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
		
		$pdf->SetFont('Arial','I',12);
		$pdf->Cell(170,8,'TRANSIT',0,0,'L',1);	
		$pdf->Ln();
		$gtbrt=0;$gtkol=0;$gtqty=0;		
			
		//filtering airline
		 if($_POST[airline]=='SEMUA') //SEMUA AIRLINE
		{
			$str_airline_nonil=mysql_query("select airline from super_daily 
			WHERE statusnil='' group by airline order by airline ASC");
			$str_airline_nil=mysql_query("select airline from super_daily 
			WHERE statusnil='1' group by airline order by airline ASC");
		}
		else
		{
			$str_airline_nonil=mysql_query("select airline from super_daily 
			WHERE statusnil='' AND airline='$_POST[airline]' group by airline order by airline ASC");
			$str_airline_nil=mysql_query("select airline from super_daily 
			WHERE statusnil='1' AND airline='$_POST[airline]' group by airline order by airline ASC");
		}
		
		//untuk yang tidak nil dulu
		while($r=mysql_fetch_array($str_airline_nonil))  
		{
			$pdf->SetFont('Arial','',12);
			$pdf->Cell(25,8,$r[airline],0,0,'C',0);
			$pdf->Ln();
			$str_kategori=mysql_query("select commodity from super_daily where airline='$r[airline]' 
			AND statusnil='' group by commodity");
			$tbrt=0;$tkol=0;$tqty=0;
			
			while($rr=mysql_fetch_array($str_kategori))  
			{
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(35,5,$rr[commodity],1,0,'C',1);
				$pdf->Cell(35,5,'BERAT(KG)',1,0,'C',1);
				$pdf->Cell(35,5,'COLLIE',1,0,'C',1);
				$pdf->Cell(25,5,'AWB QTY',1,0,'C',1);
				$pdf->Ln();
				$brt=0;$kol=0;$qty=0;
				$str_data=mysql_query("select flight,sum(berat) as sumberat,
				sum(koli) as sumkoli,count(noawb) as jsmu from super_daily where 
				commodity='$rr[commodity]' AND airline='$r[airline]' AND statusnil='' GROUP BY flight");
				while($rrr=mysql_fetch_array($str_data))  			
				{   
					$pdf->SetFont('Arial','',9);
					$pdf->Cell(35,5,$rrr[flight],1,0,'L',1);
					$pdf->Cell(35,5,number_format($rrr[sumberat],1, ',', '.'),1,0,'R',1);
					$pdf->Cell(35,5,number_format($rrr[sumkoli], 0, '.', '.'),1,0,'R',1);
					$pdf->Cell(25,5,number_format($rrr[jsmu], 0, '.', '.'),1,0,'R',1);
					$pdf->Ln();
					$brt=$brt+$rrr[sumberat];$kol=$kol+$rrr[sumkoli];$qty=$qty+$rrr[jsmu];
				}		
				$pdf->Cell(35,0,'',1,0,'C',1);
				$pdf->Cell(35,5,number_format($brt, 1, ',', '.'),1,0,'R',1);
				$pdf->Cell(35,5,number_format($kol, 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($qty, 0, '.', '.'),1,0,'R',1);
				$pdf->Ln(8);
				$tbrt=$tbrt+$brt;$tkol=$tkol+$kol;$tqty=$tqty+$qty;
			}	
			$gtbrt=$gtbrt+$tbrt;$gtkol=$gtkol+$tkol;$gtqty=$tqty+$gtqty;	
		}
		
		//untuk yang NIL
		if(mysql_num_rows($str_airline_nil)>0)
		{
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(35,5,'NIL',1,0,'C',1);
			$pdf->Cell(35,5,'BERAT(KG)',1,0,'C',1);
			$pdf->Cell(35,5,'COLLIE',1,0,'C',1);
			$pdf->Cell(25,5,'AWB QTY',1,0,'C',1);
			$pdf->Ln();
			while($rrr=mysql_fetch_array($str_airline_nil))  			
			{   
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(35,5,$rrr[flight],1,0,'L',1);
				$pdf->Cell(35,5,'0',1,0,'R',1);
				$pdf->Cell(35,5,'0',1,0,'R',1);
				$pdf->Cell(25,5,'0',1,0,'R',1);
				$pdf->Ln();
				$brt=$rrr[sumberat]+$brt;$kol=$kol+$rrr[sumkoli];$qty=$qty+$rrr[jsmu];
			}		
			$pdf->Ln();
			$gtbrt=$gtbrt+$tbrt;$gtkol=$gtkol+$tkol;$gtqty=$tqty+$gtqty;
			$pdf->Cell(35,5,'TOTAL '.$r[airline],1,0,'C',1);
			$pdf->Cell(35,5,number_format($tbrt, 1, ',', '.'),1,0,'R',1);
			$pdf->Cell(35,5,number_format($tkol, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(25,5,number_format($tqty, 0, '.', '.'),1,0,'R',1);
			$pdf->Ln(10);									
		}
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',12);	
		$pdf->Cell(35,5,'TOTAL TRANSIT',1,0,'C',1);
		$pdf->Cell(35,5,number_format($gtbrt, 1, ',', '.'),1,0,'R',1);
		$pdf->Cell(35,5,number_format($gtkol, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($gtqty, 0, '.', '.'),1,0,'R',1);
		$pdf->Ln(10);				
	}//END OF PERIOD TRANSIT
}// END OF PERIIODICAL REPORT - PREVIEW
	$pdf->Cell(50,6,'Yang Menyerahkan',0,0,'C',1);
	$pdf->Cell(15,6,'',0,0,'C',1);
	$pdf->Cell(50,6,'Mengetahui',0,0,'C',1);
	$pdf->Ln(20);	
  	$pdf->Cell(50,6,'( ..................................... )',0,0,'C',1); 
  	$pdf->Cell(15,6,'',0,0,'C',1); 				
	$pdf->Cell(50,6,'( ..................................... )',0,0,'C',1);
	$pdf->Ln(15);		
	$pdf->Output();
}


//utk fligh data
elseif ($module=='flightdata')
{
$tglawal=my2date($_POST[tglawal]);
$tglakhir=my2date($_POST[tglakhir]);

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
			$this->Cell(0,8,'LAPORAN CARGO CARGO INTERNATIONAL',0,0,'L');
			$this->Ln();
			$this->SetFont('Times','I',11);
			$this->Cell(170,8,'Tanggal : '.$_POST[tglawal].' until '.$_POST[tglakhir],0,0,'L',1);

	$this->Ln(10);
				
		}
		
		//Page footer
		function Footer()
		{
			//Position at 1.5 cm from bottom
			$this->SetY(-80);
			//Arial italic 8
			$this->SetFont('Arial','I',9);
			//Page number
			$this->Cell(0,10,'GAPURA BALI WMS INTER - Page '.$this->PageNo().'/{nb}',0,0,'R');
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

	    $pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Times','I',11);	

//INCOMING AFTER
mysql_query("delete from flightdata"); 
mysql_query("insert into flightdata 
select i.tglmanifest,b.kolidatang,i.no_smu,b.beratdatang,t.kategori,m.airline,i.tujuan,i.asal from breakdown as b,isimanifestin as i,manifestin as m,typebarang as t where b.id_isimanifestin=i.id_isimanifestin AND i.id_manifestin = m.id_manifestin AND i.jenisbarang = t.typebarang AND i.status_transit='DPS' AND b.status_check='confirm' AND m.nil='' AND b.isvoid='0' AND m.noflight='$_POST[airline]' 
 AND m.tglmanifest BETWEEN '$tglawal' AND '$tglakhir' group by b.id_isimanifestin
");


	$pdf->SetFont('Arial','',12);
	$pdf->Cell(170,8,$_POST[airline],0,0,'L',1);	
	$pdf->Ln();	
	$pdf->SetFont('Arial','I',12);
	$pdf->Cell(170,8,'IMPORT',0,0,'L',1);	
	$pdf->Ln();
	$gtbrt=0;$gtkol=0;$gtqty=0;			
				$pdf->SetFont('Arial','',12);
				$pdf->Cell(35,5,'TANGGAL',1,0,'C',1);
				$pdf->Cell(35,5,'BERAT(KG)',1,0,'C',1);
				$pdf->Cell(35,5,'COLLIE',1,0,'C',1);
				$pdf->Cell(25,5,'AWB QTY',1,0,'C',1);
				$pdf->Ln();
				$brt=0;$kol=0;$qty=0;
				$str_data=mysql_query("select tgl,sum(berat) as sumberat,sum(koli) as sumkoli,
				count(nosmu) as jsmu from flightdata group by tgl");
 				while($rrr=mysql_fetch_array($str_data))  
  				{   
					$pdf->SetFont('Arial','',12);
					$pdf->Cell(35,5,ymd2dmy($rrr[tgl]),1,0,'C',1);
					$pdf->Cell(35,5,number_format($rrr[sumberat],1, ',', '.'),1,0,'R',1);
					$pdf->Cell(35,5,number_format($rrr[sumkoli], 0, '.', '.'),1,0,'R',1);
					$pdf->Cell(25,5,number_format($rrr[jsmu], 0, '.', '.'),1,0,'R',1);
					$pdf->Ln();
					$brt=$brt+$rrr[sumberat];$kol=$kol+$rrr[sumkoli];$qty=$qty+$rrr[jsmu];
				}
				
				$pdf->SetFont('Arial','',12);		
				$pdf->Cell(35,5,'TOTAL',1,0,'L',1);
				$pdf->Cell(35,5,number_format($brt, 1, ',', '.'),1,0,'R',1);
				$pdf->Cell(35,5,number_format($kol, 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($qty, 0, '.', '.'),1,0,'R',1);
				$pdf->Ln(8);

				
//INCOMING TRASNIT
mysql_query("delete from flightdata"); 
mysql_query("insert into flightdata 
select i.tglmanifest,b.kolidatang,i.no_smu,b.beratdatang,t.kategori,m.airline,i.tujuan,i.asal from breakdown as b,isimanifestin as i,manifestin as m,typebarang as t where b.id_isimanifestin=i.id_isimanifestin AND i.id_manifestin = m.id_manifestin AND i.jenisbarang = t.typebarang AND i.status_transit<>'DPS' AND b.status_check='confirm' AND m.nil='' AND b.isvoid='0' AND m.noflight='$_POST[airline]' 
 AND m.tglmanifest BETWEEN '$tglawal' AND '$tglakhir' group by b.id_isimanifestin
");


		$pdf->SetFont('Arial','I',12);
	$pdf->Cell(170,8,'INCOMING TRANSIT',0,0,'L',1);	
	$pdf->Ln();
	$gtbrt=0;$gtkol=0;$gtqty=0;			
				$pdf->SetFont('Arial','',12);
				$pdf->Cell(35,5,'TANGGAL',1,0,'C',1);
				$pdf->Cell(35,5,'BERAT(KG)',1,0,'C',1);
				$pdf->Cell(35,5,'COLLIE',1,0,'C',1);
				$pdf->Cell(25,5,'AWB QTY',1,0,'C',1);
				$pdf->Ln();
				$brt=0;$kol=0;$qty=0;
				$str_data=mysql_query("select tgl,sum(berat) as sumberat,sum(koli) as sumkoli,
				count(nosmu) as jsmu from flightdata group by tgl");
 				while($rrr=mysql_fetch_array($str_data))  
  				{   
					$pdf->SetFont('Arial','',12);
					$pdf->Cell(35,5,ymd2dmy($rrr[tgl]),1,0,'C',1);
					$pdf->Cell(35,5,number_format($rrr[sumberat],1, ',', '.'),1,0,'R',1);
					$pdf->Cell(35,5,number_format($rrr[sumkoli], 0, '.', '.'),1,0,'R',1);
					$pdf->Cell(25,5,number_format($rrr[jsmu], 0, '.', '.'),1,0,'R',1);
					$pdf->Ln();
					$brt=$brt+$rrr[sumberat];$kol=$kol+$rrr[sumkoli];$qty=$qty+$rrr[jsmu];
				}$pdf->SetFont('Arial','',12);		
				$pdf->Cell(35,5,'TOTAL',1,0,'L',1);
				$pdf->Cell(35,5,number_format($brt, 1, ',', '.'),1,0,'R',1);
				$pdf->Cell(35,5,number_format($kol, 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($qty, 0, '.', '.'),1,0,'R',1);
				$pdf->Ln(8);
								
mysql_query("delete from flightdata"); 
mysql_query("insert into flightdata 
select m.tglmanifest,b.koli,o.btb_smu,b.berat,t.kategori,m.airline,o.btb_tujuan,o.btb_tujuan  from buildup as b,manifestout as m,typebarang as t,out_dtbarang_h as o where b.id_out_dtbarang_h=o.id AND b.id_manifestout=m.id_manifestout AND b.jenisbarang = t.typebarang AND m.nil='' AND status='checked' AND m.noflight='$_POST[airline]' AND m.tglmanifest BETWEEN '$tglawal' AND '$tglakhir'  AND m.isvoid='0' AND b.status_transit='DPS' AND b.isvoid='0' group by b.id_out_dtbarang_h 
");


		$pdf->SetFont('Arial','I',12);
	$pdf->Cell(170,8,'EXPORT',0,0,'L',1);	
	$pdf->Ln();
	$gtbrt=0;$gtkol=0;$gtqty=0;			
				$pdf->SetFont('Arial','',12);
				$pdf->Cell(35,5,'TANGGAL',1,0,'C',1);
				$pdf->Cell(35,5,'BERAT(KG)',1,0,'C',1);
				$pdf->Cell(35,5,'COLLIE',1,0,'C',1);
				$pdf->Cell(25,5,'AWB QTY',1,0,'C',1);
				$pdf->Ln();
				$brt=0;$kol=0;$qty=0;
				$str_data=mysql_query("select tgl,sum(berat) as sumberat,sum(koli) as sumkoli,
				count(nosmu) as jsmu from flightdata group by tgl");
 				while($rrr=mysql_fetch_array($str_data))  
  				{   
					$pdf->SetFont('Arial','',12);
					$pdf->Cell(35,5,ymd2dmy($rrr[tgl]),1,0,'C',1);
					$pdf->Cell(35,5,number_format($rrr[sumberat],1, ',', '.'),1,0,'R',1);
					$pdf->Cell(35,5,number_format($rrr[sumkoli], 0, '.', '.'),1,0,'R',1);
					$pdf->Cell(25,5,number_format($rrr[jsmu], 0, '.', '.'),1,0,'R',1);
					$pdf->Ln();
					$brt=$brt+$rrr[sumberat];$kol=$kol+$rrr[sumkoli];$qty=$qty+$rrr[jsmu];
				}$pdf->SetFont('Arial','',12);		
				$pdf->Cell(35,5,'TOTAL',1,0,'L',1);
				$pdf->Cell(35,5,number_format($brt, 1, ',', '.'),1,0,'R',1);
				$pdf->Cell(35,5,number_format($kol, 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($qty, 0, '.', '.'),1,0,'R',1);
				$pdf->Ln(8);
mysql_query("delete from flightdata"); 
mysql_query("insert into flightdata 
select m.tglmanifest,b.koli,o.btb_smu,b.berat,t.kategori,m.airline,o.btb_tujuan,o.btb_tujuan  from buildup as b,manifestout as m,typebarang as t,out_dtbarang_h as o where b.id_out_dtbarang_h=o.id AND b.id_manifestout=m.id_manifestout AND b.jenisbarang = t.typebarang AND m.nil='' AND status='checked' AND m.noflight='$_POST[airline]' AND m.tglmanifest BETWEEN '$tglawal' AND '$tglakhir'  AND m.isvoid='0' AND b.status_transit<>'DPS' AND b.isvoid='0' group by b.id_out_dtbarang_h 
");


		$pdf->SetFont('Arial','I',12);
	$pdf->Cell(170,8,'OUTGOING TRANSIT',0,0,'L',1);	
	$pdf->Ln();
	$gtbrt=0;$gtkol=0;$gtqty=0;			
				$pdf->SetFont('Arial','',12);
				$pdf->Cell(35,5,'TANGGAL',1,0,'C',1);
				$pdf->Cell(35,5,'BERAT(KG)',1,0,'C',1);
				$pdf->Cell(35,5,'COLLIE',1,0,'C',1);
				$pdf->Cell(25,5,'AWB QTY',1,0,'C',1);
				$pdf->Ln();
				$brt=0;$kol=0;$qty=0;
				$str_data=mysql_query("select tgl,sum(berat) as sumberat,sum(koli) as sumkoli,
				count(nosmu) as jsmu from flightdata group by tgl");
 				while($rrr=mysql_fetch_array($str_data))  
  				{   
					$pdf->SetFont('Arial','',12);
					$pdf->Cell(35,5,ymd2dmy($rrr[tgl]),1,0,'C',1);
					$pdf->Cell(35,5,number_format($rrr[sumberat],1, ',', '.'),1,0,'R',1);
					$pdf->Cell(35,5,number_format($rrr[sumkoli], 0, '.', '.'),1,0,'R',1);
					$pdf->Cell(25,5,number_format($rrr[jsmu], 0, '.', '.'),1,0,'R',1);
					$pdf->Ln();
					$brt=$brt+$rrr[sumberat];$kol=$kol+$rrr[sumkoli];$qty=$qty+$rrr[jsmu];
				}$pdf->SetFont('Arial','',12);		
				$pdf->Cell(35,5,'TOTAL',1,0,'L',1);
				$pdf->Cell(35,5,number_format($brt, 1, ',', '.'),1,0,'R',1);
				$pdf->Cell(35,5,number_format($kol, 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(25,5,number_format($qty, 0, '.', '.'),1,0,'R',1);
				$pdf->Ln(8);					
			
		
				

  				 $pdf->Cell(50,6,'Yang Menyerahkan',0,0,'C',1);
				 $pdf->Cell(15,6,'',0,0,'C',1);
				 $pdf->Cell(50,6,'Mengetahui',0,0,'C',1);
				$pdf->Ln(20);	
  				$pdf->Cell(50,6,'( ..................................... )',0,0,'C',1); 
  				$pdf->Cell(15,6,'',0,0,'C',1); 				
				$pdf->Cell(50,6,'( ..................................... )',0,0,'C',1);
				$pdf->Ln(15);	
					
	$pdf->Output();
}

//************************************


?>
