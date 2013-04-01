<?php
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
		$this->Cell(0,10,'GAPURA MEDAN WMS INTER - Page '.$this->PageNo().'/{nb}',0,0,'C');
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
?>