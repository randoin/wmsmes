<?php
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
?>