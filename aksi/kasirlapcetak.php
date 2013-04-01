<?php
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
			$this->Cell(0,10,'GAPURA MEDAN WMS INTER - Page '.$this->PageNo().'/{nb}',0,0,'C');
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
	AND isimanifestin.id_manifestin=manifestin.idmanifestin AND manifestin.airline=airline.airlinecode AND
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
?>