<?php
session_start();
	require('fpdf.php');
include "config/koneksi.php";
include "config/library.php";
$module=$_GET['module'];
$act=$_GET['act'];

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

// Hapus user
elseif ($module=='user' AND $act=='hapus')
{
  mysql_query("DELETE FROM ".$module." WHERE id_".$module."='$_GET[id]' AND logon='0'");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
}


// Update user
elseif ($module=='user' AND $act=='update'){
  // Apabila password tidak diubah
  if (empty($_POST[password])) {
    mysql_query("UPDATE user SET id_user      = '$_POST[id_user]',
                                 nama_lengkap = '$_POST[nama_lengkap]',
																 nipp = '$_POST[nipp]',
                                 telpon    = '$_POST[no_telpon]',								 								 								 level		  = '$_POST[level]'
					 
								   
                           WHERE id_user      = '$_POST[id]'");
						   
					
  }
  // Apabila password diubah
  else{
    $pass=md5($_POST[password]);
    mysql_query("UPDATE user SET id_user      = '$_POST[id_user]',
                                 password     = '$pass',
                                 nama_lengkap = '$_POST[nama_lengkap]',
																 nipp = '$_POST[nipp]',
                                 telpon        = '$_POST[no_telpon]',										
								 level = '$_POST[level]' 
                          
					 
								   
                           WHERE id_user      = '$_POST[id]'");
  }
  header('location:media.php?module='.$module);
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
elseif ($module=='dailyreport')
{
	class PDF extends FPDF
	{
		function Header(){	
		$this->SetLeftMargin(10);			
		$this->SetFont('Arial','B',14);
		$this->Ln();
		$this->Cell(190,20,'PENDAPATAN SEWA GUDANG DOMESTIK',0,0,'L');
		$this->Ln();				
		}
		function Footer(){
		//Position at 1.5 cm from bottom
		$this->SetY(-15);
		//Arial italic 8
		$this->SetFont('Arial','I',8);
		//Page number
		$this->Cell(0,10,'WMS 1.0 - Page '.$this->PageNo().'/{nb}',0,0,'C');
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
	if($_POST[outin]=='1'){$outin='OUTGOING';}else {$outin='INCOMING';}
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
			$pdf->Cell(25,8,'No. DB',1,0,'C',1);
			$pdf->Ln();
			$pdf->SetFont('Arial','',8);	
			}
			else
			{
			$pdf->Cell(15,8,'PPn',1,0,'C',1);
			$pdf->Cell(30,8,'Total',1,0,'C',1);			
			$pdf->Cell(25,8,'No. DB',1,0,'C',1);
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
			$pdf->Cell(20,5,$brt,1,0,'R',1);
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

				if($no % 40<=0)
				{
				 $pdf->AddPage();
			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(10,8,'No',1,0,'C',1);
			$pdf->Cell(35,8,'NO.SMU/AWB',1,0,'C',1);
			$pdf->Cell(20,8,'Berat(Kg)',1,0,'C',1);
			$pdf->Cell(10,8,'Hari',1,0,'C',1);
			$pdf->Cell(30,8,'Sewa Gudang',1,0,'C',1);
			$pdf->Cell(15,8,'Diskon',1,0,'C',1);			
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(30,8,'Total',1,0,'C',1);			
			$pdf->Cell(25,8,'No. DB',1,0,'C',1); 
			$pdf->Ln();
				}
				$no+=1;

			}
						//subtotal
							$pdf->SetFont('Arial','B',8);			
			$pdf->Ln(1);
			$pdf->Cell(10,5,'',0,0,'R',1);		
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
			$pdf->Cell(10,5,'',0,0,'R',1);		
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
			
		$pdf->Ln(10);
		$pdf->Cell(60,8,'Diperiksa oleh : ',0,0,'C',1);
			$pdf->Cell(60,8,'',0,0,'C',1);	
	$pdf->Cell(60,8,'Dibuat oleh : ',0,0,'C',1);
				$pdf->Ln(15);
		$pdf->Cell(60,8,'',0,0,'C',1);				$pdf->Cell(60,8,'',0,0,'C',1);			
		$pdf->Cell(60,8,$kasir,0,0,'C',1);			
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
	if($_POST[outin]=='1'){$outin='OUTGOING';}else {$outin='INCOMING';}
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
			$pdf->Cell(35,8,'KOMODITI',1,0,'C',1);
			$pdf->Cell(20,8,'Berat(Kg)',1,0,'C',1);
			$pdf->Cell(10,8,'Hari',1,0,'C',1);
			$pdf->Cell(20,8,'Sewa Gudang',1,0,'C',1);
			$pdf->Cell(15,8,'Diskon',1,0,'C',1);			
			
			if($_POST[untuk]=='gp')
			{
			$pdf->Cell(15,8,'Adm',1,0,'C',1);
			$pdf->Cell(15,8,'PPn',1,0,'C',1);
			$pdf->Cell(30,8,'Total',1,0,'C',1);			
			$pdf->Cell(25,8,'No. DB',1,0,'C',1);
			$pdf->Ln();
			$pdf->SetFont('Arial','',8);	
			}
			else
			{
			$pdf->Cell(15,8,'PPn',1,0,'C',1);
			$pdf->Cell(30,8,'Total',1,0,'C',1);			
			$pdf->Cell(25,8,'No. DB',1,0,'C',1);
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
			$pdf->Cell(20,5,$brt,1,0,'R',1);
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

				if($no % 40<=0)
				{
				 $pdf->AddPage();
			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(35,8,'KOMODITI',1,0,'C',1);
			$pdf->Cell(20,8,'Berat(Kg)',1,0,'C',1);
			$pdf->Cell(10,8,'Hari',1,0,'C',1);
			$pdf->Cell(30,8,'Sewa Gudang',1,0,'C',1);
			$pdf->Cell(15,8,'Diskon',1,0,'C',1);			
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(30,8,'Total',1,0,'C',1);			
			$pdf->Cell(25,8,'No. DB',1,0,'C',1); 
			$pdf->Ln();
				}
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
			
		$pdf->Ln(10);
		$pdf->Cell(60,8,'Diperiksa oleh : ',0,0,'C',1);
			$pdf->Cell(60,8,'',0,0,'C',1);	
	$pdf->Cell(60,8,'Dibuat oleh : ',0,0,'C',1);
				$pdf->Ln(15);
		$pdf->Cell(60,8,'',0,0,'C',1);				$pdf->Cell(60,8,'',0,0,'C',1);			
		$pdf->Cell(60,8,$kasir,0,0,'C',1);			
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
	if($_POST[outin]=='1'){$outin='OUTGOING';}else {$outin='INCOMING';}
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
			$pdf->Cell(35,8,'KOMODITI',1,0,'C',1);
			$pdf->Cell(20,8,'Berat(Kg)',1,0,'C',1);
			$pdf->Cell(10,8,'Hari',1,0,'C',1);
			$pdf->Cell(20,8,'Sewa Gudang',1,0,'C',1);
			$pdf->Cell(15,8,'Diskon',1,0,'C',1);			
			
			if($_POST[untuk]=='gp')
			{
			$pdf->Cell(15,8,'Adm',1,0,'C',1);
			$pdf->Cell(15,8,'PPn',1,0,'C',1);
			$pdf->Cell(30,8,'Total',1,0,'C',1);			
			$pdf->Cell(25,8,'No. DB',1,0,'C',1);
			$pdf->Ln();
			$pdf->SetFont('Arial','',8);	
			}
			else
			{
			$pdf->Cell(15,8,'PPn',1,0,'C',1);
			$pdf->Cell(30,8,'Total',1,0,'C',1);			
			$pdf->Cell(25,8,'No. DB',1,0,'C',1);
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
			$pdf->Cell(20,5,$brt,1,0,'R',1);
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

				if($no % 40<=0)
				{
				 $pdf->AddPage();
			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(35,8,'KOMODITI',1,0,'C',1);
			$pdf->Cell(20,8,'Berat(Kg)',1,0,'C',1);
			$pdf->Cell(10,8,'Hari',1,0,'C',1);
			$pdf->Cell(30,8,'Sewa Gudang',1,0,'C',1);
			$pdf->Cell(15,8,'Diskon',1,0,'C',1);			
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(30,8,'Total',1,0,'C',1);			
			$pdf->Cell(25,8,'No. DB',1,0,'C',1); 
			$pdf->Ln();
				}
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
			
		$pdf->Ln(10);
		$pdf->Cell(60,8,'Diperiksa oleh : ',0,0,'C',1);
			$pdf->Cell(60,8,'',0,0,'C',1);	
	$pdf->Cell(60,8,'Dibuat oleh : ',0,0,'C',1);
				$pdf->Ln(15);
		$pdf->Cell(60,8,'',0,0,'C',1);				$pdf->Cell(60,8,'',0,0,'C',1);			
		$pdf->Cell(60,8,$kasir,0,0,'C',1);			
	$pdf->Output();
}//end of Cetak Per Agent Per Komoditi!


}	





elseif ($module=='kasirlapcetak')
{


	class PDF extends FPDF
	{
		//Page header
		function Header()
		{	
		$this->SetLeftMargin(10);			
//			$this->SetX(100);
			$this->SetFont('Arial','B',14);
			$this->Ln();
			$this->Cell(190,20,'PENDAPATAN SEWA GUDANG DOMESTIK',0,0,'L');
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
			$this->Cell(0,10,'WMS 1.0 - Page '.$this->PageNo().'/{nb}',0,0,'C');
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
$no=1;

$tglawal=my2date($_POST[tglawal]);$tglakhir=my2date($_POST[tglakhir]);
$carabayar=$_POST[cara_bayar];
if($_POST[outin]=='OUTGOING')
{
	$outin=1;

} 
else 
{
	$outin=0;
}


if($_POST[tipe_laporan]=='per_smu')
{
if($outin=='1')
{
	if($carabayar=='SEMUA'){
 	$str=mysql_query("select * from deliverybill,out_dtbarang_h,user where deliverybill.status='$outin' 
	AND deliverybill.isvoid='0' AND deliverybill.nosmu=out_dtbarang_h.btb_smu 
	AND deliverybill.tglbayar>='$tglawal' 
	AND deliverybill.tglbayar<='$tglakhir' AND deliverybill.user=user.id_user 
	ORDER BY deliverybill.id_deliverybill ASC");
	}
	else{
	$str=mysql_query("select * from deliverybill,out_dtbarang_h,user where deliverybill.status='$outin' 
	AND deliverybill.isvoid='0' AND deliverybill.nosmu=out_dtbarang_h.btb_smu AND 
	deliverybill.id_carabayar='$carabayar' AND deliverybill.tglbayar>='$tglawal' 
	AND deliverybill.tglbayar<='$tglakhir' AND deliverybill.user=user.id_user 
	ORDER BY deliverybill.id_deliverybill ASC");
	}
}	 
else 
{

 		if($carabayar=='SEMUA'){
		$str=mysql_query("select * from deliverybill,breakdown,user where deliverybill.status='$outin' AND 
		deliverybill.isvoid='0' AND deliverybill.idbreakdown=breakdown.id_breakdown AND 
		deliverybill.tglbayar>='$tglawal' AND 
		deliverybill.tglbayar<='$tglakhir' AND deliverybill.user=user.id_user 
		ORDER BY deliverybill.id_deliverybill ASC");
		}
		else{
		$str=mysql_query("select * from deliverybill,breakdown,user where deliverybill.status='$outin' AND 
		deliverybill.isvoid='0' AND deliverybill.idbreakdown=breakdown.id_breakdown AND 
		deliverybill.id_carabayar='$carabayar' AND deliverybill.tglbayar>='$tglawal' AND 
		deliverybill.tglbayar<='$tglakhir' AND deliverybill.user=user.id_user 
		ORDER BY deliverybill.id_deliverybill ASC");
		}
}
    $pdf->AddPage();

 	//bikin halaman baru
			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(200,8,$_POST[outin].' - Cara Pembayaran : '.$_POST[cara_bayar],1,0,'L',1);
			$pdf->Ln(10);
			$pdf->SetFont('Arial','I',10);
			if($tglawal==$tglakhir)
			{$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal],0,0,'L',1);}
			else
			{$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal].' s/d '.$_POST[tglakhir],0,0,'L',1);}
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);			
			$pdf->Cell(10,8,'No',1,0,'C',1);
			$pdf->Cell(35,8,'NO.SMU/AWB',1,0,'C',1);
			$pdf->Cell(20,8,'Berat(Kg)',1,0,'C',1);
			$pdf->Cell(10,8,'Hari',1,0,'C',1);
			$pdf->Cell(30,8,'Sewa Gudang',1,0,'C',1);
			if($_POST[untuk]=='gp')
			{
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(30,8,'Total',1,0,'C',1);			
			$pdf->Cell(25,8,'No. DB',1,0,'C',1);
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);	
			}
			else
			{
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(30,8,'Total',1,0,'C',1);			
			$pdf->Cell(25,8,'No. DB',1,0,'C',1);
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);	
			}
			//siapkan data
			$g_berat=0;$g_sewagudang=0;
			$g_adm=0;$g_ppn=0;$g_hari=0;$g_total=0;
			  while ($r=mysql_fetch_array($str)){
				$kasir=$r[nama_lengkap];
if($r[status]=='0')
{
$brt=$r[beratdatang];
if($r[id_deliverybill]<10){$nodb='I000000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10 AND $r[id_deliverybill]<100){$nodb='I00000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100 AND $r[id_deliverybill]<1000){$nodb='I0000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000 AND $r[id_deliverybill]<10000){$nodb='I000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10000 AND $r[id_deliverybill]<100000){$nodb='I00'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100000 AND $r[id_deliverybill]<1000000){$nodb='I0'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000000 AND $r[id_deliverybill]<10000000){$nodb='I'.$r[id_deliverybill];}
}
else if($r[status]=='1')
{
$brt=$r[btb_totalberatbayar];
if($r[id_deliverybill]<10){$nodb='O000000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10 AND $r[id_deliverybill]<100){$nodb='O00000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100 AND $r[id_deliverybill]<1000){$nodb='O0000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000 AND $r[id_deliverybill]<10000){$nodb='O000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10000 AND $r[id_deliverybill]<100000){$nodb='O00'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100000 AND $r[id_deliverybill]<1000000){$nodb='O0'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000000 AND $r[id_deliverybill]<10000000){$nodb='O'.$r[id_deliverybill];}
}
	
$total=$r[overtime]+$r[document]+$r[lain];				
			$pdf->Cell(10,5,$no,1,0,'R',1);		
			$pdf->Cell(35,5,$r[nosmu],1,0,'C',1);
			$pdf->Cell(20,5,$brt,1,0,'R',1);
			$pdf->Cell(10,5,$r[hari],1,0,'R',1);
			$pdf->Cell(30,5,number_format($r[overtime], 0, '.', '.'),1,0,'R',1);
			if($_POST[untuk]=='gp')
			{
			$pdf->Cell(20,5,number_format($r[document], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,5,number_format($r[lain], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,$nodb,1,0,'R',1);				
			$pdf->Ln();
			}
			else
			{
			$pdf->Cell(20,5,number_format($r[lain], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,5,number_format($total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,$nodb,1,0,'R',1);				
			$pdf->Ln();
			}
			$g_berat=$g_berat+$brt;
			$g_sewagudang=$g_sewagudang+$r[overtime];
			$g_adm=$g_adm+$r[document];
			$g_ppn=$g_ppn+$r[lain];
			$g_hari=$g_hari+$r[hari];
			$g_total=$g_total+$total;

				if($no % 40<=0)
				{
				 $pdf->AddPage();
			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(10,8,'No',1,0,'C',1);
			$pdf->Cell(35,8,'NO.SMU/AWB',1,0,'C',1);
			$pdf->Cell(20,8,'Berat(Kg)',1,0,'C',1);
			$pdf->Cell(10,8,'Hari',1,0,'C',1);
			$pdf->Cell(30,8,'Sewa Gudang',1,0,'C',1);
			$pdf->Cell(20,8,'Adm',1,0,'C',1);
			$pdf->Cell(20,8,'PPn',1,0,'C',1);
			$pdf->Cell(30,8,'Total',1,0,'C',1);			
			$pdf->Cell(25,8,'No. DB',1,0,'C',1); 
			$pdf->Ln();
				}
				$no+=1;

			}
			
			
			//grandtotal
			$pdf->Ln(8);
			$pdf->Cell(10,5,'',0,0,'R',1);		
			$pdf->Cell(35,5,'TOTAL :',0,0,'C',1);
			$pdf->Cell(20,5,$g_berat,1,0,'R',1);
			$pdf->Cell(10,5,$g_hari,1,0,'R',1);
			$pdf->Cell(30,5,number_format($g_sewagudang, 0, '.', '.'),1,0,'R',1);
			if($_POST[untuk]=='gp')
			{
			$pdf->Cell(20,5,number_format($g_adm, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,5,number_format($g_ppn, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,5,number_format($g_total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,'',1,0,'R',1);				
			$pdf->Ln();
			}
			else
			{
			$pdf->Cell(20,5,number_format($g_ppn, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,5,number_format($g_total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Cell(25,5,'',1,0,'R',1);				
			$pdf->Ln();
			}
			//
			
		$pdf->Ln(10);
		$pdf->Cell(60,8,'Diperiksa oleh : ',0,0,'C',1);
			$pdf->Cell(60,8,'',0,0,'C',1);	
	$pdf->Cell(60,8,'Dibuat oleh : ',0,0,'C',1);
				$pdf->Ln(15);
		$pdf->Cell(60,8,'',0,0,'C',1);				$pdf->Cell(60,8,'',0,0,'C',1);			
		$pdf->Cell(60,8,$kasir,0,0,'C',1);			
	$pdf->Output();
}//end of if SMU !	

else if($_POST[tipe_laporan]=='per_agent')
{
if($outin=='1')
{
	$str=mysql_query("select out_dtbarang_h.btb_agent,user.nama_lengkap FROM deliverybill,out_dtbarang_h,user  
WHERE deliverybill.no_smubtb=out_dtbarang_h.btb_nobtb 
AND deliverybill.status='1' AND out_dtbarang_h.isvoid='0' AND out_dtbarang_h.posted='1' 
AND deliverybill.user=user.id_user 
AND deliverybill.tglbayar>='$tglawal' AND deliverybill.tglbayar<='$tglakhir' 
GROUP by out_dtbarang_h.btb_agent"); 
	
}	 
else 
{
	$str=mysql_query("select isimanifestin.agent,user.nama_lengkap FROM deliverybill,isimanifestin,user  
WHERE deliverybill.no_smubtb=isimanifestin.no_smu  
AND deliverybill.status='0' AND deliverybill.isvoid='0' AND isimanifestin.isvoid='0' 
AND deliverybill.user=user.id_user 
AND deliverybill.tglbayar>='$tglawal' AND deliverybill.tglbayar<='$tglakhir' 
GROUP by isimanifestin.agent"); 
	 
}
    $pdf->AddPage();
		$pdf->SetLeftMargin(20);

 	//bikin halaman baru
			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(155,8,$_POST[outin].' - '.$_POST[cara_bayar],1,0,'L',1);
			$pdf->Ln(10);
			$pdf->SetFont('Arial','I',10);			
			if($tglawal==$tglakhir)
			{$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal],0,0,'L',1);}
			else
			{$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal].' s/d '.$_POST[tglakhir],0,0,'L',1);}			
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);	
			//siapkan data
			$no=0;
			$g_berat=0;
			$g_sewagudang=0;
			$g_adm=0;
			$g_ppn=0;
			$g_total=0;		
			 while ($r=mysql_fetch_array($str))
			 {
			 $kasir=$r[1];
			 			if($tglawal==$tglakhir)
			{
				if($outin=='1')
				{
				$str1=mysql_query("select typebarang.kategori, sum(deliverybill.document), 
sum(deliverybill.storage), sum(deliverybill.lain), sum(deliverybill.overtime),sum(out_dtbarang_h.btb_totalberatbayar),
sum(deliverybill.hari) FROM deliverybill,out_dtbarang_h,out_dtbarang,typebarang 
where deliverybill.no_smubtb=out_dtbarang_h.btb_nobtb 
AND out_dtbarang_h.id=out_dtbarang.id_h 
AND out_dtbarang.dtBarang_type=typebarang.typebarang 
AND deliverybill.status='1' 
AND deliverybill.isvoid='0' 
AND deliverybill.id_carabayar='$carabayar' 
AND out_dtbarang_h.btb_agent='$r[0]' 
AND deliverybill.tglbayar>='$tglawal' 
AND deliverybill.tglbayar<='$tglakhir'
group by typebarang.kategori");
				}
				else
				{
				$str1=mysql_query("select typebarang.kategori, sum(deliverybill.document), 
sum(deliverybill.storage), sum(deliverybill.lain), sum(deliverybill.overtime),sum(breakdown.beratdatang),
sum(deliverybill.hari) FROM deliverybill,breakdown,isimanifestin,typebarang 
where deliverybill.no_smubtb=isimanifestin.no_smu  
AND breakdown.id_isimanifestin=isimanifestin.id_isimanifestin 
AND isimanifestin.jenisbarang=typebarang.typebarang 
AND deliverybill.status='0' 
AND deliverybill.isvoid='0' 
AND deliverybill.id_carabayar='$carabayar' 
AND isimanifestin.agent='$r[0]' 
AND deliverybill.tglbayar>='$tglawal' 
AND deliverybill.tglbayar<='$tglakhir'
group by typebarang.kategori");
				
				}
} 
else
{
				if($outin=='1')
				{
				$str1=mysql_query("select deliverybill.tglbayar, sum(deliverybill.document), 
sum(deliverybill.storage), sum(deliverybill.lain), sum(deliverybill.overtime),sum(out_dtbarang_h.btb_totalberatbayar),
sum(deliverybill.hari) FROM deliverybill,out_dtbarang_h 
where deliverybill.no_smubtb=out_dtbarang_h.btb_nobtb 
AND deliverybill.status='1' 
AND deliverybill.isvoid='0' 
AND deliverybill.id_carabayar='$carabayar' 
AND out_dtbarang_h.btb_agent='$r[0]' 
AND deliverybill.tglbayar>='$tglawal' 
AND deliverybill.tglbayar<='$tglakhir'
group by deliverybill.tglbayar"); }
else
{
				$str1=mysql_query("select deliverybill.tglbayar, sum(deliverybill.document), 
sum(deliverybill.storage), sum(deliverybill.lain), sum(deliverybill.overtime),sum(breakdown.beratdatang),
sum(deliverybill.hari) FROM deliverybill,breakdown,isimanifestin
where deliverybill.no_smubtb=isimanifestin.no_smu  
AND breakdown.id_isimanifestin=isimanifestin.id_isimanifestin 
AND deliverybill.status='0' 
AND deliverybill.isvoid='0' 
AND deliverybill.id_carabayar='$carabayar' 
AND isimanifestin.agent='$r[0]' 
AND deliverybill.tglbayar>='$tglawal' 
AND deliverybill.tglbayar<='$tglakhir'
group by deliverybill.tglbayar");

}
}
			$pdf->Ln(6);
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(35,8,$r[0],1,0,'L',1);		
			$pdf->Cell(20,8,'Berat(Kg)',1,0,'C',1);
			$pdf->Cell(30,8,'Sewa Gudang',1,0,'C',1);
				if($_POST[untuk]=='gp')
				{
				$pdf->Cell(20,8,'Adm',1,0,'C',1);
				$pdf->Cell(20,8,'PPn',1,0,'C',1);
				$pdf->Cell(30,8,'Total',1,0,'C',1);			
				$pdf->Ln();
				}
				else
				{
				$pdf->Cell(20,8,'PPn',1,0,'C',1);
				$pdf->Cell(30,8,'Total',1,0,'C',1);			
				$pdf->Ln();
				}						
			$pdf->SetFont('Arial','',10);	
			$sub_berat=0;$sub_sewagudang=0;	
			$sub_adm=0;$sub_ppn=0;$sub_total=0;		
		  while($p=mysql_fetch_array($str1))
			{
						if($tglawal==$tglakhir){$abc=$p[0];}
			else $abc=ymd2dmy($p[0]);
			$total=$p[1]+$p[2]+$p[4];				
			$pdf->Cell(35,8,$abc,1,0,'L',1);		
			$pdf->Cell(20,8,$p[5],1,0,'R',1);
			$pdf->Cell(30,8,number_format($p[4], 0, '.', '.'),1,0,'R',1);
			if($_POST[untuk]=='gp')
			{
			$pdf->Cell(20,8,number_format($p[1], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,8,number_format($p[3], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,8,number_format($total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Ln();
			}
			else
			{
			$pdf->Cell(20,8,number_format($p[3], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,8,number_format($total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Ln();
			}
			$sub_berat=$sub_berat+$p[5];
			$sub_sewagudang=$sub_sewagudang+$p[4];
			$sub_adm=$sub_adm+$p[1];
			$sub_ppn=$sub_ppn+$p[3];
			$sub_total=$sub_total+$total;		
			$g_berat=$g_berat+$sub_berat;
			$g_sewagudang=$g_sewagudang+$sub_sewagudang;
			$g_adm=$g_adm+$sub_adm;
			$g_ppn=$g_ppn+$sub_ppn;
			$g_total=$g_total+$sub_total;					
			
			}
//sub totalnya
			$pdf->Cell(35,8,'  SUB TOTAL :',1,0,'R',1);		
			$pdf->Cell(20,8,$sub_berat,1,0,'R',1);
			$pdf->Cell(30,8,number_format($sub_sewagudang, 0, '.', '.'),1,0,'R',1);
			if($_POST[untuk]=='gp')
			{
			$pdf->Cell(20,8,number_format($sub_adm, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,8,number_format($sub_ppn, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,8,number_format($sub_total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Ln();
			}
			else
			{
			$pdf->Cell(20,8,number_format($sub_ppn, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,8,number_format($sub_total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Ln();
			}


			/*	if($no % 10<=0)
				{
				 $pdf->AddPage();
				}
				$no+=1;
*/
			}
		$pdf->Ln(6);
			$pdf->SetFont('Arial','B',10);			
			$pdf->Cell(35,8,'TOTAL :',1,0,'R',1);		
			$pdf->Cell(20,8,number_format($g_berat, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,8,number_format($g_sewagudang, 0, '.', '.'),1,0,'R',1);
			if($_POST[untuk]=='gp')
			{
			$pdf->Cell(20,8,number_format($g_adm, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,8,number_format($g_ppn, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,8,number_format($g_total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Ln();
			}
			else
			{
			$pdf->Cell(20,8,number_format($g_ppn, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,8,number_format($g_total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Ln();
			}
		$pdf->Ln(10);					
		$pdf->Cell(60,8,'Diperiksa oleh : ',0,0,'C',1);			$pdf->Cell(60,8,'',0,0,'C',1);	
	$pdf->Cell(60,8,'Dibuat oleh : ',0,0,'C',1);
				$pdf->Ln(15);
		$pdf->Cell(60,8,'',0,0,'C',1);			$pdf->Cell(60,8,'',0,0,'C',1);			
		$pdf->Cell(60,8,$kasir,0,0,'C',1);	

	$pdf->Output();
}//end of if agent !	
else if($_POST[tipe_laporan]=='per_tipebarang')
{
if($outin=='1')
{
 	$str=mysql_query("select typebarang.kategori 
FROM buildup,out_dtbarang_h,out_dtbarang,typebarang 
WHERE buildup.id_out_dtbarang_h = out_dtbarang_h.id AND out_dtbarang_h.id=out_dtbarang.id_h 
AND out_dtbarang.dtBarang_type=typebarang.typebarang 
AND buildup.tglkeluar>='$tglawal' AND buildup.tglkeluar<='$tglakhir' 
GROUP by typebarang.kategori");

}	 
else 
{
 	$str=mysql_query("select typebarang.kategori FROM manifestin,isimanifestin,breakdown,typebarang 
	WHERE breakdown.id_isimanifestin=isimanifestin.id_isimanifestin AND 
	isimanifestin.jenisbarang=typebarang.typebarang AND 
	isimanifestin.id_manifestin = manifestin.id_manifestin AND 
	manifestin.status='checked' AND
	breakdown.tgldatang>='$tglawal' AND 
	breakdown.tgldatang<='$tglakhir' AND breakdown.isvoid=0 AND manifestin.isvoid=0 
	GROUP by typebarang.kategori");
}

    $pdf->AddPage();
		$pdf->SetLeftMargin(20);

 	//bikin halaman baru
			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(170,10,$_POST[outin],0,0,'L',1);
			$pdf->Ln();
			$pdf->SetFont('Arial','B',10);			
			$pdf->Cell(170,10,'Tanggal : '.$_POST[tglawal].' s/d '.$_POST[tglakhir],0,0,'L',1);
			$pdf->Ln();

			//siapkan data
			 while ($r=mysql_fetch_array($str))
			 {
			 $ty=$r[0];
					if($outin=='1')
					{$str1=mysql_query("select manifestout.noflight,sum(buildup.berat),sum(buildup.koli) 
FROM buildup,out_dtbarang_h,out_dtbarang,typebarang,manifestout 
WHERE buildup.id_out_dtbarang_h = out_dtbarang_h.id AND out_dtbarang_h.id=out_dtbarang.id_h 
AND out_dtbarang.dtBarang_type=typebarang.typebarang AND buildup.id_manifestout=manifestout.id_manifestout 
AND typebarang.kategori='$ty' AND out_dtbarang_h.btb_date>='$tglawal' AND out_dtbarang_h.btb_date<='$tglakhir' 
AND out_dtbarang_h.isvoid=0  
GROUP BY manifestout.noflight");}
else
{
$str1=mysql_query("select manifestin.noflight,sum(breakdown.beratdatang),sum(breakdown.kolidatang) 
FROM manifestin,isimanifestin,breakdown,typebarang 
	WHERE breakdown.id_isimanifestin=isimanifestin.id_isimanifestin AND 
	isimanifestin.jenisbarang=typebarang.typebarang AND 
	isimanifestin.id_manifestin = manifestin.id_manifestin AND 
	manifestin.status='checked' AND
	breakdown.tgldatang>='$tglawal' AND typebarang.kategori='$ty' AND 
	breakdown.tgldatang<='$tglakhir' AND breakdown.isvoid=0 AND manifestin.isvoid=0 
	GROUP by manifestin.noflight");
}

			$pdf->Ln(6);
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(35,8,$r[0],0,0,'L',1);		
			$pdf->Cell(20,8,'',0,0,'C',1);
			$pdf->Cell(30,8,'',0,0,'C',1);
			$pdf->SetFont('Arial','',10);	
			$pdf->Ln();
			$pdf->Cell(35,8,'FLIGHT NO',1,0,'C',1);		
			$pdf->Cell(20,8,'KG',1,0,'C',1);
			$pdf->Cell(30,8,'KOLI',1,0,'C',1);
			$pdf->SetFont('Arial','',10);				
			$pdf->Ln();			
		  while($p=mysql_fetch_array($str1))
			{
			$pdf->Cell(35,8,$p[0],1,0,'L',1);		
			$pdf->Cell(20,8,$p[1],1,0,'R',1);
			$pdf->Cell(30,8,$p[2],1,0,'R',1);
			$pdf->Ln();			
			}

			/*	if($no % 10<=0)
				{
				 $pdf->AddPage();
				}
				$no+=1;
*/
			}

		$pdf->Ln(20);					
		$pdf->Cell(60,8,'Diperiksa oleh : ',0,0,'C',1);			$pdf->Cell(60,8,'',0,0,'C',1);	
	$pdf->Cell(60,8,'Dibuat oleh : ',0,0,'C',1);
				$pdf->Ln(15);
		$pdf->Cell(60,8,'',0,0,'C',1);			$pdf->Cell(60,8,'',0,0,'C',1);			
		$pdf->Cell(60,8,$kasir,0,0,'C',1);	

	$pdf->Output();
}//end of if SMU !	
else if($_POST[tipe_laporan]=='per_airline')
{
if($outin=='1')
{
	$str=mysql_query("select out_dtbarang_h.airline,user.nama_lengkap,airline.airlinename FROM deliverybill,out_dtbarang_h,airline,user    
WHERE deliverybill.no_smubtb=out_dtbarang_h.btb_nobtb 
AND deliverybill.status='1' AND out_dtbarang_h.isvoid='0' AND out_dtbarang_h.posted='1' 
AND out_dtbarang_h.airline=airline.airlinecode AND deliverybill.user=user.id_user 
AND deliverybill.tglbayar>='$tglawal' AND deliverybill.tglbayar<='$tglakhir'  
GROUP by out_dtbarang_h.airline"); 
	
}	 
else 
{
	$str=mysql_query("select manifestin.airline,user.nama_lengkap,airline.airlinename FROM deliverybill,manifestin,isimanifestin,breakdown,airline,user   
WHERE deliverybill.idbreakdown=breakdown.id_breakdown 
AND breakdown.id_isimanifestin=isimanifestin.id_isimanifestin 
AND isimanifestin.id_manifestin=manifestin.id_manifestin  
AND deliverybill.status='0' AND deliverybill.isvoid='0'  
AND manifestin.airline=airline.airlinecode 
AND deliverybill.tglbayar>='$tglawal' AND deliverybill.tglbayar<='$tglakhir' 
AND deliverybill.user=user.id_user   
GROUP by manifestin.airline"); 
	 
}
    $pdf->AddPage();
		$pdf->SetLeftMargin(20);

 	//bikin halaman baru
			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(155,8,$_POST[outin].' - '.$_POST[cara_bayar],1,0,'L',1);
			$pdf->Ln(10);
			$pdf->SetFont('Arial','I',10);			
			if($tglawal==$tglakhir)
			{$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal],0,0,'L',1);
			}
			else
			{
			$pdf->Cell(170,8,'Tanggal : '.$_POST[tglawal].' s/d '.$_POST[tglakhir],0,0,'L',1);
			}			
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);	
			//siapkan data
			$no=0;
			$g_berat=0;
			$g_sewagudang=0;
			$g_adm=0;
			$g_ppn=0;
			$g_total=0;		
			 while ($r=mysql_fetch_array($str))
			 {
			 $kasir=$r[1];
			 			if($tglawal==$tglakhir){
						if($outin=='1'){

				$str1=mysql_query("select typebarang.kategori, sum(deliverybill.document), 
sum(deliverybill.storage), sum(deliverybill.lain), sum(deliverybill.overtime),sum(out_dtbarang_h.btb_totalberatbayar),
sum(deliverybill.hari) FROM deliverybill,out_dtbarang_h,out_dtbarang,typebarang 
where deliverybill.no_smubtb=out_dtbarang_h.btb_nobtb 
AND out_dtbarang_h.id=out_dtbarang.id_h 
AND out_dtbarang.dtBarang_type=typebarang.typebarang 
AND deliverybill.status='1' 
AND deliverybill.isvoid='0' 
AND deliverybill.id_carabayar='$carabayar' 
AND out_dtbarang_h.airline='$r[0]' 
AND deliverybill.tglbayar>='$tglawal' 
AND deliverybill.tglbayar<='$tglakhir'
group by typebarang.kategori"); }
else{
				$str1=mysql_query("select typebarang.kategori, sum(deliverybill.document), 
sum(deliverybill.storage), sum(deliverybill.lain), sum(deliverybill.overtime),sum(breakdown.beratdatang),
sum(deliverybill.hari) FROM deliverybill,breakdown,isimanifestin,manifestin,typebarang 
WHERE deliverybill.idbreakdown=breakdown.id_breakdown 
AND breakdown.id_isimanifestin=isimanifestin.id_isimanifestin 
AND isimanifestin.id_manifestin=manifestin.id_manifestin  
AND isimanifestin.jenisbarang=typebarang.typebarang 
AND deliverybill.status='0' 
AND deliverybill.isvoid='0' 
AND deliverybill.id_carabayar='$carabayar' 
AND manifestin.airline='$r[0]' 
AND deliverybill.tglbayar>='$tglawal' 
AND deliverybill.tglbayar<='$tglakhir'
group by typebarang.kategori");
}
}
else
{

						if($outin=='1'){

				$str1=mysql_query("select deliverybill.tglbayar, sum(deliverybill.document), 
sum(deliverybill.storage), sum(deliverybill.lain), sum(deliverybill.overtime),sum(out_dtbarang_h.btb_totalberatbayar),
sum(deliverybill.hari) FROM deliverybill,out_dtbarang_h 
where deliverybill.no_smubtb=out_dtbarang_h.btb_nobtb 
AND deliverybill.status='1' 
AND deliverybill.isvoid='0' 
AND deliverybill.id_carabayar='$carabayar' 
AND out_dtbarang_h.airline='$r[0]' 
AND deliverybill.tglbayar>='$tglawal' 
AND deliverybill.tglbayar<='$tglakhir'
group by deliverybill.tglbayar"); 
} else
{
				$str1=mysql_query("select deliverybill.tglbayar, sum(deliverybill.document), 
sum(deliverybill.storage), sum(deliverybill.lain), sum(deliverybill.overtime),sum(breakdown.beratdatang),
sum(deliverybill.hari) FROM deliverybill,breakdown,isimanifestin,manifestin,typebarang 
WHERE deliverybill.idbreakdown=breakdown.id_breakdown 
AND breakdown.id_isimanifestin=isimanifestin.id_isimanifestin 
AND isimanifestin.id_manifestin=manifestin.id_manifestin  
AND isimanifestin.jenisbarang=typebarang.typebarang 
AND deliverybill.status='0' 
AND deliverybill.isvoid='0' 
AND deliverybill.id_carabayar='$carabayar' 
AND manifestin.airline='$r[0]' 
AND deliverybill.tglbayar>='$tglawal' 
AND deliverybill.tglbayar<='$tglakhir'
group by deliverybill.tglbayar");
}
}



			$pdf->Ln(6);
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(35,8,$r[2],1,0,'L',1);		
			$pdf->Cell(20,8,'Berat(Kg)',1,0,'C',1);
			$pdf->Cell(30,8,'Sewa Gudang',1,0,'C',1);
				if($_POST[untuk]=='gp')
				{
				$pdf->Cell(20,8,'Adm',1,0,'C',1);
				$pdf->Cell(20,8,'PPn',1,0,'C',1);
				$pdf->Cell(30,8,'Total',1,0,'C',1);			
				$pdf->Ln();
				}
				else
				{
				$pdf->Cell(20,8,'PPn',1,0,'C',1);
				$pdf->Cell(30,8,'Total',1,0,'C',1);			
				$pdf->Ln();
				}						
			$pdf->SetFont('Arial','',10);	
			$sub_berat=0;$sub_sewagudang=0;	
			$sub_adm=0;$sub_ppn=0;$sub_total=0;	
				
		  while($p=mysql_fetch_array($str1))
			{
			if($tglawal==$tglakhir){$abc=$p[0];}
			else $abc=ymd2dmy($p[0]);
			$total=$p[1]+$p[2]+$p[4];				
			$pdf->Cell(35,8,$abc,1,0,'L',1);		
			$pdf->Cell(20,8,$p[5],1,0,'R',1);
			$pdf->Cell(30,8,number_format($p[4], 0, '.', '.'),1,0,'R',1);
			if($_POST[untuk]=='gp')
			{
			$pdf->Cell(20,8,number_format($p[1], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,8,number_format($p[3], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,8,number_format($total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Ln();
			}
			else
			{
			$pdf->Cell(20,8,number_format($p[3], 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,8,number_format($total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Ln();
			}
			$sub_berat=$sub_berat+$p[5];
			$sub_sewagudang=$sub_sewagudang+$p[4];
			$sub_adm=$sub_adm+$p[1];
			$sub_ppn=$sub_ppn+$p[3];
			$sub_total=$sub_total+$total;		
			$g_berat=$g_berat+$sub_berat;
			$g_sewagudang=$g_sewagudang+$sub_sewagudang;
			$g_adm=$g_adm+$sub_adm;
			$g_ppn=$g_ppn+$sub_ppn;
			$g_total=$g_total+$sub_total;					
			
			}
//sub totalnya
			$pdf->Cell(35,8,'  SUB TOTAL :',1,0,'R',1);		
			$pdf->Cell(20,8,$sub_berat,1,0,'R',1);
			$pdf->Cell(30,8,number_format($sub_sewagudang, 0, '.', '.'),1,0,'R',1);
			if($_POST[untuk]=='gp')
			{
			$pdf->Cell(20,8,number_format($sub_adm, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,8,number_format($sub_ppn, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,8,number_format($sub_total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Ln();
			}
			else
			{
			$pdf->Cell(20,8,number_format($sub_ppn, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,8,number_format($sub_total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Ln();
			}


			/*	if($no % 10<=0)
				{
				 $pdf->AddPage();
				}
				$no+=1;
*/
			}
		$pdf->Ln(6);
			$pdf->SetFont('Arial','B',10);			
			$pdf->Cell(35,8,'TOTAL :',1,0,'R',1);		
			$pdf->Cell(20,8,number_format($g_berat, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,8,number_format($g_sewagudang, 0, '.', '.'),1,0,'R',1);
			if($_POST[untuk]=='gp')
			{
			$pdf->Cell(20,8,number_format($g_adm, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(20,8,number_format($g_ppn, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,8,number_format($g_total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Ln();
			}
			else
			{
			$pdf->Cell(20,8,number_format($g_ppn, 0, '.', '.'),1,0,'R',1);
			$pdf->Cell(30,8,number_format($g_total, 0, '.', '.'),1,0,'R',1);			
			$pdf->Ln();
			}
		$pdf->Ln(10);					
		$pdf->Cell(60,8,'Diperiksa oleh : ',0,0,'C',1);			$pdf->Cell(60,8,'',0,0,'C',1);	
	$pdf->Cell(60,8,'Dibuat oleh : ',0,0,'C',1);
				$pdf->Ln(15);
		$pdf->Cell(60,8,'',0,0,'C',1);			$pdf->Cell(60,8,'',0,0,'C',1);			
		$pdf->Cell(60,8,$kasir,0,0,'C',1);	

	$pdf->Output();
}//end of if airline !


}
// CARI btb/smu UTK Delivery Bill
elseif ($module=='deliverybill' AND $act=='caribtbsmu')
{
	$tgl=date("Y-m-d");
  $cek=mysql_query("SELECT * from out_dtbarang_h where btb_nobtb ='$_POST[nobtbsmu]' AND 
				status_bayar='no' AND isvoid='0' AND posted='1'");
  $ada=mysql_num_rows($cek);  
  if($ada<=0)
  {
		$cek1=mysql_query("SELECT * from breakdown,isimanifestin,manifestin 
where breakdown.id_isimanifestin=isimanifestin.id_isimanifestin AND isimanifestin.id_manifestin=manifestin.id_manifestin 
AND breakdown.status_ambil='INSTORE' 
AND isimanifestin.no_smu ='$_POST[nobtbsmu]' 
AND breakdown.status_bayar='no' AND isimanifestin.status_transit='DPS' 
AND breakdown.isvoid='0' AND manifestin.status='checked'");
$p=mysql_fetch_array($cek1);

  	$ada1=mysql_num_rows($cek1);  
  	if($ada1<=0)
		{
				$cek2=mysql_query("SELECT * from breakdown,isimanifestin,manifestin 
where breakdown.id_isimanifestin=isimanifestin.id_isimanifestin AND isimanifestin.id_manifestin=manifestin.id_manifestin AND isimanifestin.no_smu ='$_POST[nobtbsmu]' AND breakdown.isvoid='0'");
$c=mysql_fetch_array($cek2);
   		if($c[23]=='TRANSIT'){header('location:media.php?module='.$module.'&psn=t');}
			elseif($c[41]=='waiting'){header('location:media.php?module='.$module.'&psn=w');}
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


elseif ($module=='cetakdb')
{

$t=mysql_query("SELECT * FROM deliverybill where id_deliverybill='$_GET[n]'");
$r=mysql_fetch_array($t);

if($r[status]=='0')
{
$t=mysql_query("SELECT * FROM deliverybill,isimanifestin,user,breakdown where deliverybill.nosmu=isimanifestin.no_smu AND deliverybill.user=user.id_user AND id_deliverybill='$_GET[n]' AND deliverybill.idbreakdown=breakdown.id_breakdown");
$r=mysql_fetch_array($t);
if($r[id_deliverybill]<10){$nodb='I000000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10 AND $r[id_deliverybill]<100){$nodb='I00000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100 AND $r[id_deliverybill]<1000){$nodb='I0000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000 AND $r[id_deliverybill]<10000){$nodb='I000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10000 AND $r[id_deliverybill]<100000){$nodb='I00'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100000 AND $r[id_deliverybill]<1000000){$nodb='I0'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000000 AND $r[id_deliverybill]<10000000){$nodb='I'.$r[id_deliverybill];}
}
else if($r[status]=='1')
{
$t=mysql_query("SELECT * FROM deliverybill,out_dtbarang_h,out_dtbarang,user where deliverybill.no_smubtb=out_dtbarang_h.btb_nobtb AND out_dtbarang_h.id=out_dtbarang.id_h AND deliverybill.user=user.id_user AND id_deliverybill='$_GET[n]'");
$r=mysql_fetch_array($t);
if($r[id_deliverybill]<10){$nodb='O000000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10 AND $r[id_deliverybill]<100){$nodb='O00000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100 AND $r[id_deliverybill]<1000){$nodb='O0000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000 AND $r[id_deliverybill]<10000){$nodb='O000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10000 AND $r[id_deliverybill]<100000){$nodb='O00'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100000 AND $r[id_deliverybill]<1000000){$nodb='O0'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000000 AND $r[id_deliverybill]<10000000){$nodb='O'.$r[id_deliverybill];}
}		
$totalbayar=$r[overtime]+$r[document]+$r[lain]-$r[diskon];
		
  echo "<title>Delivery Bill - WMS Gapura</title>";
	echo "<link href='config/printstyle.css' rel='stylesheet' type='text/css'>";
  echo "
	<table border=1>
	<tr>
	 <td colspan=5 align=right><B>No DB :$nodb</B></td>
	</tr>
	<tr>
	 <td colspan=5><CENTER><h2>BUKTI PEMBAYARAN SEWA GUDANG</h2></CENTER></td>
	</tr>
	<tr>
	 <td width=150>PENGUSAHA KENA PAJAK </td>
	 <td colspan=4>:</td>
	</tr>
	<tr>
	 <td>Nama </td>
	 <td colspan=4>: PT. GAPURA ANGKASA</td>
	</tr>
	 <td>NPWP </td>
	 <td colspan=4>: 01.061.170.5.051.000</td>
	</tr>
	<tr>
	 <td>No Pengukuhan PKP </td>
	 <td colspan=4>: 01.061.170.5.051.000 / Tanggal 02 Februari 1998</td>
	</tr>	
	<tr>
	 <td colspan=5>-Pasal 1 Keputusan Direktur Jenderal Pajak No. Kep-54/PJ/1994 Tgl. 29 Desember 1998<BR>
	 -Surat No.S-1744/PJ.531/1996 Tanggal 23 Juli 1996<BR>
	 -Surat Edaran No.SE-39/PJ.531/1996 Tanggal 2 Oktober 1996</td>
	</tr>
	<tr>
    <td colspan=2 align=center><B>DATA BARANG</B></td>
    <td width=10 rowspan=9>&nbsp;</td>
    <td colspan=2 align=center><B>RINCIAN BIAYA</B></td>
	</tr>
  <tr>
    <td>No.SMU</td>";
		if($r[status]=='1')
		 {echo "<td>: $r[btb_smu]</td>";} 
		 else if($r[status=='0']){echo "<td>: $r[nosmu]</td>";}

    echo "<td width=150>Jumlah Hari</td>
    <td width=150>: $r[hari]</td>
  </tr>
  <tr>
    <td>";
		if($r[status]=='1')
		 {echo "Tujuan Airport</td><td>: $r[btb_tujuan]</td>";} 
		 else if($r[status=='0']){echo "Asal Airport </td><td>: $r[asal]</td>";}

    echo "<td>Sewa Gudang</td>
    <td>: Rp.".number_format($r[overtime], 0, '.', '.')."</td>
  </tr>
  <tr>
    <td>Tanggal</td>
    <td>: ".ymd2dmy($r[tglbayar])."</td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>Jml Pcs/Berat actual</td>";
		if($r[status]=='1')
		 {echo "<td>: $r[btb_totalkoli] Koli / $r[btb_totalberat] Kg</td>";} 
		 else if($r[status=='0'])
		 {echo "<td>: $r[kolidatang] Koli / $r[beratdatang] Kg</td>";}

    echo "<td>Administrasi</td>
    <td>: Rp.".number_format($r[document], 0, '.', '.')."</td>
  </tr>
  <tr>
    <td>Berat yang dibayar</td>";
		if($r[status]=='1')
		 {echo "<td>: $r[btb_totalberatbayar] Kg</td>";} 
		 else if($r[status=='0'])
		 {echo "<td>: $r[beratdatang] Kg</td>";}		
    echo "<td>Diskon</td>
    <td>: Rp.".number_format($r[diskon], 0, '.', '.')."</td>
  </tr>
  <tr>
    <td>Jenis Barang</td>";
		if($r[status]=='1')
		 {echo "<td>: $r[dtBarang_type]</td>";} 
		 else if($r[status=='0'])
		 {echo "<td>: $r[jenisbarang]</td>";}		
    
    echo "<td>PPN 10%</td>
    <td>: Rp.".number_format($r[lain], 0, '.', '.')."</td>
  </tr>
  <tr><td>";
	 if($r[status]=='1')
		 {echo "Pengirim/Agent</td>";} else {echo "Penerima</td>";}
	 if($r[status]=='1')
		 {echo "<td>: $r[btb_agent]</td>";} else {echo "<td>: $r[penerima]</td>";}		 
     echo "<td>TOTAL</td>
    <td>: Rp.".number_format($totalbayar, 0, '.', '.')."</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan=2>Terbilang:<BR>"; echo terbilang($totalbayar,1);  echo " RUPIAH</td>
  </tr>
 		
		
</table>

	<table class=noline>
	<tr>
		<td width=300>PT GAPURA ANGKASA</td><td width=300></td>
	</tr>
	<tr>
		<td>&nbsp;</td><td></td>
	</tr>
	<tr>
		<td>&nbsp;</td><td></td>
	</tr>
	<tr>
		<td>&nbsp;</td><td></td>
	</tr>
	<tr>
		<td>&nbsp;</td><td></td>
	</tr>
	<tr>
		<td>&nbsp;</td><td></td>
	</tr>			
	<tr>
		<td>$r[nama_lengkap]<BR>NIPP.$r[nipp]</td><td class=ttd>Nama Pengirim/Penerima</td>
	</tr>		

	</table>";

}


elseif ($module=='cetakstockopnameout')
{


	class PDF extends FPDF
	{
		//Page header
		function Header()
		{
			$tglnya=date("Y-m-d");
			$tgl='Kondisi Tanggal : '.ymd2dmy($tglnya);
			$this->SetFont('Arial','B',20);
			$this->Ln(10);
			$this->Cell(170,20,'STOCK OPNAME OUTGOING',0,0,'C');
			$this->Ln(10);		
 			$this->SetFont('Arial','B',13);
			$this->Cell(170,20,$tgl,0,0,'C');			
			$this->Ln();
			$this->SetFillColor(232,232,232);
			$this->SetFont('Arial','B',12);
			$this->SetX(20);
			$this->Cell(10,12,'No',1,0,'C',1);
			$this->Cell(40,12,'No.SMU/AWB',1,0,'C',1);
			$this->Cell(40,12,'JUMLAH KOLI',1,0,'C',1);
			$this->Cell(80,12,'REMARK',1,0,'C',1);
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
			$this->Cell(0,10,'WMS 1.0 - Page '.$this->PageNo().'/{nb}',0,0,'C');
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
$no=1;

$tampil=mysql_query("SELECT * FROM stockopnameout");
   $pdf->Header($tgl);
    $pdf->AddPage();

  

		//bikin halaman baru
			
			//siapkan data
			  while ($r=mysql_fetch_array($tampil)){
				$no_smu = $r['nosmu'];
				$sisa_koli = $r['sisakoli'];
				$pdf->SetFillColor(255,255,255);
				$pdf->SetFont('Arial','',10);
				$pdf->SetX(20);
				$pdf->Cell(10,8,$no,1,0,'C',1);
				$pdf->Cell(40,8,$no_smu,1,0,'C',1);
				$pdf->Cell(40,8,$sisa_koli,1,0,'C',1);	
				$pdf->Cell(80,8,'',1,0,'C',1);	
				
				$pdf->Ln();
				if($no % 30<=0)
				{
				 $pdf->AddPage();
				}
				$no+=1;

			}
		$pdf->Ln(10);
	$pdf->Cell(40,8,'CHECKED : ',0,0,'C',1);			
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
			$this->SetFont('Arial','B',20);
			$this->Ln(10);
			$this->Cell(170,20,'STOCK OPNAME OUTGOING',0,0,'C');
			$this->Ln(10);		
 			$this->SetFont('Arial','B',13);
			$this->Cell(170,20,$tgl,0,0,'C');			
			$this->Ln();
			$this->SetFillColor(232,232,232);
			$this->SetFont('Arial','B',12);
			$this->SetX(20);
			$this->Cell(10,12,'No',1,0,'C',1);
			$this->Cell(40,12,'No.SMU/AWB',1,0,'C',1);
			$this->Cell(40,12,'JUMLAH KOLI',1,0,'C',1);
			$this->Cell(80,12,'REMARK',1,0,'C',1);
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
			$this->Cell(0,10,'GAPURA BALI WMS 1.0 - Page '.$this->PageNo().'/{nb}',0,0,'C');
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
$no=1;

		$tampil=mysql_query("SELECT * FROM breakdown,isimanifestin,manifestin where 
		breakdown.id_isimanifestin=isimanifestin.id_isimanifestin AND breakdown.isvoid='0' AND 
		breakdown.status_ambil='INSTORE' AND isimanifestin.id_manifestin=manifestin.id_manifestin AND manifestin.status='checked' AND isimanifestin.status_transit='DPS'");
   $pdf->Header($tgl);
    $pdf->AddPage();

  

		//bikin halaman baru
			
			//siapkan data
			  while ($r=mysql_fetch_array($tampil)){
				$no_smu = $r['no_smu'];
				$koli_datang = $r['kolidatang'];
				$pdf->SetFillColor(255,255,255);
				$pdf->SetFont('Arial','',10);
				$pdf->SetX(20);
				$pdf->Cell(10,8,$no,1,0,'L',1);
				$pdf->Cell(40,8,$no_smu,1,0,'L',1);
				$pdf->Cell(40,8,$koli_datang,1,0,'C',1);	
				$pdf->Cell(80,8,'',1,0,'C',1);	
				
				$pdf->Ln();
				if($no % 30<=0)
				{
				 $pdf->AddPage();
				}
				$no+=1;

			}
		$pdf->Ln(10);
	$pdf->Cell(40,8,'CHECKED : ',0,0,'C',1);			
	$pdf->Output();


}


elseif ($module=='cetaklap')
{
if($_GET[i]=='1'){
$tgl=date("Y-m-d");$tgl1=ymd2dmy($tgl);

  echo "<link href='config/printstyle.css' rel='stylesheet' type='text/css'>";
  echo "<h2>Laporan Sewa Gudang Domestik - CASH OUTGOING</h2>";
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
  echo "<h2>Laporan Sewa Gudang Domestik - CASH INCOMING</h2>";
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

// void by supervisor
elseif ($module=='voiddb'){
$tgl=date("Y-m-d");
$tgl1=my2date($_POST[tgl]);
if($_POST[s]=='1'){

  mysql_query("UPDATE deliverybill set isvoid='1',tglvoid='$tgl',voidby='$_SESSION[namauser]',keterangan='$_POST[keterangan]' where no_smubtb='$_POST[i]' AND status='1'");
  mysql_query("UPDATE out_dtbarang_h set status_bayar='no' where btb_nobtb='$_POST[i]'");

  }
  else if($_POST[s]=='0'){
   mysql_query("UPDATE deliverybill set isvoid='1',tglvoid='$tgl',voidby='$_SESSION[namauser]',keterangan='$_POST[keterangan]'
	  where nosmu='$_POST[i]' AND status='0' AND idbreakdown='$_POST[b]'");
  mysql_query("UPDATE breakdown set status_bayar='no' where id_breakdown='$_POST[b]'");

  }
 header('location:media.php?module=dbincoming');
}



//********************************************

//BTBLEVEL
// Hapus data manifest 
elseif ($module=='btb' AND $act=='hapus')
{
  mysql_query("UPDATE out_dtbarang_h set isvoid='1' WHERE id='$_GET[i]'");
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
   		mysql_query("INSERT INTO manifestin(airline,noflight,tglmanifest,acregistration,user,isvoid)
      VALUES('$_POST[airline]','$_POST[noflight]','$tgl', '$_POST[acregistration]',
      '$_SESSION[namauser]','0')") ;
			header('location:media.php?module=manifestininput');
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
			acregistration='$_POST[acregistration]',user='$_SESSION[namauser]' WHERE id_manifestin='$_POST[i]' AND status='waiting'");
			header('location:media.php?module=manifestin');
		}
	}
	else {header('location:media.php?module=manifestin');
	}
}
// Input Isi Manifest In
elseif ($module=='isimanifestin' AND $act=='input')
{
  $tgl=date("Y-m-d");
  $tgl1=my2date($_POST[tgl]);
//jika cek
	if($_POST[tombolcek])
	{
	 $str=mysql_query("select SUM(kolidatang),SUM(beratdatang) from 
	 isimanifestin,breakdown where isimanifestin.id_isimanifestin=breakdown.id_isimanifestin 	 AND isimanifestin.no_smu='$_POST[nosmu]' GROUP BY isimanifestin.no_smu");
	 $bt_datang=mysql_fetch_array($str);
	 $str=mysql_query("select totalkoli,totalberatbayar from isimanifestin where no_smu='$_POST[nosmu]'");
	 $bt_smu=mysql_fetch_array($str);
	 $sisakoli=$bt_smu[0]-$bt_datang[0];	 $sisaberat=$bt_smu[1]-$bt_datang[1];
	 if($bt_datang[0]<>$bt_smu[0])
	 {$a=1;$k=$sisakoli;$b=$sisaberat;}else {$a=0;$k=$sisakoli;$b=$sisaberat;}
	 	header('location:media.php?module=manifestininput&i='.$_POST[idman].'&a='.$a.'&k='.$k.'&b='.$b.'&n='.$_POST[nosmu]);
  }
//jika tidak pake cek	
	else if($_POST[tombolsimpan])
	{ if($_POST[a]==''){$a='0';} else {$a=$_POST[a];}
  if((!empty($_POST[nosmu])) AND (!empty($_POST[totalkg])) AND 
	(!empty($_POST[totalkoli])))
  {
	if($a=='0'){
	mysql_query("INSERT INTO isimanifestin(no_smu,user,totalberat,totalkoli,isvoid,
	jenisbarang,status_transit,asal,tujuan,id_manifestin,
	totalberatbayar,status_out,tglmanifest,agent) 
	VALUES('$_POST[nosmu]','$_SESSION[namauser]','$_POST[totalkg]','$_POST[totalkoli]',
	'0','$_POST[jenisbarang]','$_POST[transit]','$_POST[asal]','$_POST[tujuan]',
	'$_POST[idman]','$_POST[totalkg]','INSTORE','$_POST[tglmanifest]','$_POST[agent]')");}
	else {  if((!empty($_POST[nosmu])) AND ($_POST[totalkg]<=$_POST[b]) AND 
	($_POST[totalkoli]<=$_POST[k]))
		  			mysql_query("INSERT INTO breakdown(kolidatang,beratdatang,tgldatang,id_isimanifestin,id_manifestin)
				VALUES('$_POST[totalkoli]','$_POST[totalkg]','$_POST[tglmanifest]','$_POST[idisiman]','$_POST[idman]')");
//				header('location:media.php?module=splitsmu&n='.$_POST[n].'&i='.$_POST[i]);
	}
	}
		header('location:media.php?module=manifestininput&i='.$_POST[idisiman]);
	}


}

// Hapus isi manifest
elseif ($module=='isimanifestin' AND $act=='hapus')
{
if($_GET[a]=='1')
{
  mysql_query("DELETE FROM breakdown WHERE id_breakdown='$_GET[d]' AND status_ambil='INSTORE'");
}
else
{
  mysql_query("DELETE FROM isimanifestin WHERE id_isimanifestin='$_GET[i]' AND status_out='INSTORE'");
	}
  header('location:media.php?module=manifestininput&i='.$_GET[i]);
}
// CANCEL SMU YANG SUDAH ADA DI MANIFEST 
elseif ($module=='isimanifestin' AND $act=='cancel')
{
$tgl=date("Y-m-d");
if($_GET[a]=='1')
{
  mysql_query("UPDATE breakdown set iscancel='1',voidby='$_SESSION[namauser]',tglvoid='$tgl',keteranganvoid='$_POST[keterangan_void]',beratdatang='0',kolidatang='0' 
	WHERE id_breakdown='$_POST[b]'");
}
else
{
	$cek=mysql_query("select * from isimanifestin,breakdown WHERE isimanifestin.id_isimanifestin=breakdown.id_isimanifestin AND 
	isimanifestin.id_isimanifestin='$_POST[n]' AND breakdown.status_bayar='yes'");
	$ada=mysql_num_rows($cek);
	if($ada<1)
	{
  mysql_query("UPDATE isimanifestin set iscancel='1',editedby='$_SESSION[namauser]',editdate='$tgl',keterangan_void='$_POST[keterangan_void]'
	WHERE id_isimanifestin='$_POST[n]'");
  mysql_query("UPDATE breakdown set iscancel='1',voidby='$_SESSION[namauser]',tglvoid='$tgl',keteranganvoid='$_POST[keterangan_void]',beratdatang='0',kolidatang='0' 
	WHERE id_breakdown='$_POST[b]'");	
	}
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
if($_POST[a]=='0')
{
mysql_query("update isimanifestin set 
no_smu='$_POST[no_smu]',totalberat='$_POST[totalberat]',
totalkoli='$_POST[totalkoli]',jenisbarang='$_POST[jenisbarang]',status_transit='$_POST[transit]',
asal='$_POST[asal]',tujuan='$_POST[tujuan]',status_update='yes',agent='$_POST[agent]' WHERE id_isimanifestin='$_POST[n]'");
mysql_query("update breakdown set beratdatang='$_POST[totalberatdatang]',
kolidatang='$_POST[totalkolidatang]' WHERE id_isimanifestin='$_POST[n]'");
}
else
{
$str=mysql_query("select SUM(kolidatang),SUM(beratdatang) from 
	 isimanifestin,breakdown where isimanifestin.id_isimanifestin=breakdown.id_isimanifestin 	 AND isimanifestin.id_isimanifestin='$_POST[n]' GROUP BY isimanifestin.id_isimanifestin");
	 $bt_datang=mysql_fetch_array($str);
	 $str=mysql_query("select totalkoli,totalberatbayar from isimanifestin where id_isimanifestin='$_POST[n]'");
	 $bt_smu=mysql_fetch_array($str);
	 $sisakoli=$bt_smu[0]-$bt_datang[0];	 $sisaberat=$bt_smu[1]-$bt_datang[1];
	 if(($_POST[totalkolidatang]<=$sisakoli) AND ($_POST[totalberatdatang]<=$sisaberat))
	 {
	 mysql_query("update breakdown set beratdatang='$_POST[totalberatdatang]',
kolidatang='$_POST[totalkolidatang]' WHERE id_breakdown='$_POST[b]'");
	 
	 }

}

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
   		mysql_query("INSERT INTO manifestout(airline,noflight,tglmanifest,acregistration,user,isvoid)
      VALUES('$_POST[airline]','$_POST[noflight]','$tgl', '$_POST[acregistration]',
      '$_SESSION[namauser]','0')") ;
			header('location:media.php?module=manifestoutinput');
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
			acregistration='$_POST[acregistration]',user='$_SESSION[namauser]' WHERE id_manifestout='$_POST[i]' AND status='waiting'");
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

elseif ($module=='cetakmanifestout')
{


	class PDF extends FPDF
	{
		//Page header
		function Header()
		{	
		$this->SetLeftMargin(10);			
//			$this->SetX(100);
			$this->SetFont('Arial','B',20);
			$this->Ln(10);
			$this->Cell(190,20,'C A R G O   M A N I F E S T',0,0,'C');
			$this->Ln(10);
			$this->Cell(190,20,'ICAO ANNEX 9 APPENDIX 2',0,0,'C');
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
			$this->Cell(0,10,'WMS 1.0 - Page '.$this->PageNo().'/{nb}',0,0,'C');
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

$tampil=mysql_query("SELECT * FROM manifestout,airline where 
manifestout.airline=airline.airlinecode AND id_manifestout='$_GET[i]'");
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
			$pdf->Cell(50,5,$p[airlinename],0,0,'L',1);
			$pdf->Cell(50,5,$p[acregistration],0,0,'L',1);
			$pdf->Cell(50,5,$p[noflight],0,0,'L',1);
			$pdf->Cell(50,5,ymd2dmy($p[tglmanifest]),0,0,'L',1);
			$pdf->Ln(10);			
			$pdf->Cell(100,5,'POINT OF LOADING : DENPASAR BALI',0,0,'L',1);
			$pdf->Cell(100,5,'POINT OF UNLOADING : AS BELOW',0,0,'L',1);
			$pdf->Ln(15);							
			$pdf->Cell(40,5,'AWB NUMBER',0,0,'L',1);
			$pdf->Cell(10,5,'NO',0,0,'L',1);
			$pdf->Cell(50,5,'NATURE OF GOODS',0,0,'L',1);
			$pdf->Cell(10,5,'',0,0,'L',1);
			$pdf->Cell(20,5,'WEIGHT',0,0,'C',1);
			$pdf->Cell(10,5,'EX',0,0,'C',1);
			$pdf->Cell(10,5,'TO',0,0,'C',1);
			$pdf->Cell(50,5,'FOR OFFICIAL',0,0,'L',1);
			$pdf->Ln();					
			$pdf->Cell(40,5,'',0,0,'L',1);
			$pdf->Cell(10,5,'PKG',0,0,'L',1);
			$pdf->Cell(50,5,'',0,0,'L',1);
			$pdf->Cell(10,5,'',0,0,'L',1);
			$pdf->Cell(20,5,'',0,0,'L',1);
			$pdf->Cell(10,5,'',0,0,'L',1);
			$pdf->Cell(10,5,'',0,0,'L',1);
			$pdf->Cell(50,5,'USE ONLY',0,0,'L',1);
		//	$pdf->Ln();					
			
			//siapkan data
			  $uld=mysql_query("SELECT * FROM buildup where id_manifestout='$_GET[i]' 
				AND isvoid='0' GROUP By nould");
			  while ($r=mysql_fetch_array($uld)){
				$no_uld=$r[nould];
							$pdf->SetFont('Arial','',8);
				$pdf->Ln();
				$pdf->Cell(40,8,$r[nould],0,0,'L',1);		
				$pdf->Ln(5);
				$smu=mysql_query("SELECT * FROM buildup,typebarang where 
				buildup.jenisbarang=typebarang.typebarang AND id_manifestout='$_GET[i]' 
				AND nould='$no_uld' AND buildup.isvoid='0' ORDER BY nosmu");
			  while ($x=mysql_fetch_array($smu))
				{
				$pdf->SetX(20);
				$pdf->Cell(40,5,$x[nosmu],0,0,'L',1);
				$pdf->SetX(50);				
				$pdf->Cell(10,5,$x[koli],0,0,'L',1);
				$pdf->Cell(50,5,$x[jenisbarang],0,0,'L',1);
				$pdf->Cell(10,5,$x[kategori],0,0,'C',1);
				$pdf->Cell(20,5,$x[berat],0,0,'R',1);
				$pdf->Cell(10,5,'DPS',0,0,'C',1);
				$pdf->Cell(10,5,$x[tujuan],0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln();
				}				
				$jml=mysql_query("SELECT SUM(koli) AS jum FROM buildup WHERE id_manifestout='$_GET[i]' 
				 AND isvoid='0' AND nould='$no_uld'");
				$pdf->Cell(40,1,'',0,0,'L',1);
				$pdf->Cell(10,1,'---------',0,0,'L',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(20,1,'',0,0,'R',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(10,1,'',0,0,'C',1);
				$pdf->Cell(50,1,'',0,0,'L',1);
				$pdf->Ln();				 	
			  while ($y=mysql_fetch_array($jml))
				{
				$pdf->SetX(20);
				$pdf->Cell(40,5,'',0,0,'L',1);
				$pdf->SetX(50);				
				$pdf->Cell(10,5,$y[jum],0,0,'L',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(20,5,'',0,0,'R',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(10,5,'',0,0,'C',1);
				$pdf->Cell(50,5,'',0,0,'L',1);
				$pdf->Ln();
				}							

				if($no % 7<=0)
				{
				 $pdf->AddPage();
			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(50,5,'OWNER/OPERATOR',0,0,'L',1);
			$pdf->Cell(50,5,'A/C REGISTRATION',0,0,'L',1);
			$pdf->Cell(50,5,'FLIGHT NO',0,0,'L',1);
			$pdf->Cell(50,5,'DATE',0,0,'L',1);
			$pdf->Ln();			
			$pdf->Cell(50,5,$p[airlinename],0,0,'L',1);
			$pdf->Cell(50,5,$p[acregistration],0,0,'L',1);
			$pdf->Cell(50,5,$p[noflight],0,0,'L',1);
			$pdf->Cell(50,5,$p[tglmanifest],0,0,'L',1);
			$pdf->Ln(10);			
			$pdf->Cell(100,5,'POINT OF LOADING : DENPASAR BALI',0,0,'L',1);
			$pdf->Cell(100,5,'POINT OF UNLOADING : AS BELOW',0,0,'L',1);
			$pdf->Ln(15);							
			$pdf->Cell(40,5,'AWB NUMBER',0,0,'L',1);
			$pdf->Cell(10,5,'NO',0,0,'L',1);
			$pdf->Cell(50,5,'NATURE OF GOODS',0,0,'L',1);
			$pdf->Cell(10,5,'',0,0,'L',1);
			$pdf->Cell(20,5,'WEIGHT',0,0,'C',1);
			$pdf->Cell(10,5,'EX',0,0,'C',1);
			$pdf->Cell(10,5,'TO',0,0,'C',1);
			$pdf->Cell(50,5,'FOR OFFICIAL',0,0,'L',1);
			$pdf->Ln();					
			$pdf->Cell(40,5,'',0,0,'L',1);
			$pdf->Cell(10,5,'PKG',0,0,'L',1);
			$pdf->Cell(50,5,'',0,0,'L',1);
			$pdf->Cell(10,5,'',0,0,'L',1);
			$pdf->Cell(20,5,'',0,0,'L',1);
			$pdf->Cell(10,5,'',0,0,'L',1);
			$pdf->Cell(10,5,'',0,0,'L',1);
			$pdf->Cell(50,5,'USE ONLY',0,0,'L',1);					 
				}
				$no+=1;

			}
		$pdf->Ln(10);
	$pdf->Cell(40,8,'PREPARED BY : ',0,0,'C',1);			
	$pdf->Output();
	
}


// CARI SMU utk TRACING
elseif ($module=='tracing' AND $act=='caribtbsmu')
{
}


//************************************


?>
