<?php
session_start();
require "fpdf.php";
include "config/koneksi.php";
include "config/library.php";
$module=$_GET['module'];
$act=$_GET['act'];

function showAlert($text,$url) { ?>
<script language="javascript">
alert("<?php echo $text; ?>")
window.location.href = "<?php echo $url;?>";
</script> 
<?php } 

//******************************START OF EXPORT ********************************************

//---------------------------UPDATE Berat ULD-------------------------------------------------
if ($module=='beratuld' AND $act=='update')
{
	include "aksi/update-beratuld.php";
}
//---------------End of UPDATE BERAT ULD -------------------------------------------------


//---------------Confirm AWB Manifest Export -------------------------------------------------
//---------------End of Confirm AWB Manifest Export -------------------------------------------------
if ($module=='carimanifestexport' AND $act=='pnbpconfirm')
{
	include "aksi/carimanifestexport-pnbpconfirm.php";
}	

if ($module=='carimanifestimport' AND $act=='pnbpconfirm')
{
	include "aksi/carimanifestimport-pnbpconfirm.php";
}		
//------------- Mencetak Manifest Export ---------
if ($module=='cetakmanifestout')
{
	include "aksi/cetakmanifestout.php";
}
//-------------- enf of cetak manifest export


//----------------------- Cetak Stockopname Export ------------------------------
if ($module=='cetakstockopnameout')
{
	include "aksi/cetakstockopnameout.php";
}
//-------------------End of Mencetak Stockopanem Export -------------------------------


//----------------------- Cetak Handover Export ------------------------------
if ($module=='cetakhandoverexport')
{
	include "aksi/cetakhandoverexport.php";
}
//-------------------End of Mencetak  Cetak Handover Export  -------------------------------


//----------------------- Cetak Delivery Cargo dan Post ------------------------------
if ($module=='cetakdeliverycargo')
{
	include "aksi/cetakdeliverycargo.php";
}
//-------------------End of Mencetak  Cetak Delivery Cargo  -------------------------------


//---------------Menghapus Data AWB di Manifest Export -------------------------------------------------
if ($module=='isimanifestexport' AND $act=='hapus')
{
 include "aksi/isimanifestexport-hapus.php";
}
//---------------End of Menghapus Data AWB di Manifest Export -------------------------------------------------


//------------------------------- start of isi manifest export----------------------------
if ($module=='isimanifestexport' AND $act=='tambah')
{
	include "aksi/isimanifestexport-tambah.php";
}
//--------------------------- end of input manifest export -----------------------------------------


//---------------Menambah Data Manifest Export---------------------------------------------------------
if ($module=='manifestexport' AND $act=='tambah')
{
	include "aksi/manifestexport-tambah.php";
} 
//---------------End of Menambah Data Manifest Export --------------------------------------------------


//---------------Mengedit Data Manifest Export---------------------------------------------------------
if ($module=='manifestexport' AND $act=='edit')
{
	include "aksi/manifestexport-edit.php";
} 
//---------------End of Mengedit Data Manifest Export --------------------------------------------------

//*********************************END OF EXPORT *******************************************


//******************************START OF BTB ********************************************
//---------------Menambah Data AWB Today---------------------------------------------------------
if ($module=='awbtoday' AND $act=='tambah')
{
	include "aksi/awbtoday-tambah.php";
} 
//---------------End of Menambah Data  AWB--------------------------------------------------


//---------------Menghapus Data AWB-------------------------------------------------
else if ($module=='carismu' AND $act=='hapus')
{
	include "aksi/carismu-hapus.php";
}
//---------------End of Menghapus Data AWB-------------------------------------------------


//---------------Menghapus Data AWB-------------------------------------------------
else if ($module=='carismu' AND $act=='hapusi')
{
	include "aksi/carismu-hapusi.php";
}
//---------------End of Menghapus Data AWB-------------------------------------------------


//---------------MengeditData AWB Today---------------------------------------------------------
if ($module=='awbtoday' AND $act=='edit')
{
	include "aksi/awbtoday-edit.php";
} 
//---------------End of Menngedit AWB--------------------------------------------------
//***************************************************************************************


//******************************START OF SUPERVISOR *************************************
//---------------Menghapus Data Agent-------------------------------------------------
if ($module=='dataagent' AND $act=='hapus')
{
	include "aksi/dataagent-hapus.php";
}
//---------------End of Menghapus Data Agent-------------------------------------------------


//---------------Menambah Data Agent---------------------------------------------------------
if ($module=='dataagent' AND $act=='tambah')
{
	include "aksi/dataagent-tambah.php";
} 
//---------------End of Menambah Data Agent--------------------------------------------------


//---------------Edit Data Agent---------------------------------------------------------
if ($module=='dataagent' AND $act=='edit')
{
	include "aksi/dataagent-edit.php";
} 
//---------------End of Edit Data Agent--------------------------------------------------


//---------------Menghapus Data Region-------------------------------------------------
if ($module=='dataregion' AND $act=='hapus')
{
	include "aksi/dataregion-hapus.php";
}
//---------------End of Menghapus Data Region-------------------------------------------------


//---------------Menambah Data Region---------------------------------------------------------
if ($module=='dataregion' AND $act=='tambah')
{
	include "aksi/dataregion-tambah.php";
} 
//---------------End of Menambah Data Region--------------------------------------------------


//---------------Edit Data Region---------------------------------------------------------
if ($module=='dataregion' AND $act=='edit')
{
	include "aksi/dataregion-edit.php";
} 
//---------------End of Edit Data Region--------------------------------------------------


//---------------Menghapus Data Commocity -------------------------------------------------
if ($module=='datacommodity' AND $act=='hapus')
{
	include "aksi/datacommodity-hapus.php";
}
//---------------End of Menghapus Data Commodity -------------------------------------------------


//---------------Menambah Data commodity---------------------------------------------------------
if ($module=='datacommodity' AND $act=='tambah')
{
	include "aksi/datacommodity-tambah.php";
} 
//---------------End of Menambah Data commodity--------------------------------------------------


//---------------Edit Data commodity---------------------------------------------------------
if ($module=='datacommodity' AND $act=='edit')
{
	include "aksi/datacommodity-edit.php";
} 
//---------------End of Edit Data commodity--------------------------------------------------


//---------------Menghapus Data Commocity -------------------------------------------------
if ($module=='datacommodity_ap' AND $act=='hapus')
{
	include "aksi/datacommodity_ap-hapus.php";
}
//---------------End of Menghapus Data Commodity -------------------------------------------------


//---------------Menambah Data commodity---------------------------------------------------------
if ($module=='datacommodity_ap' AND $act=='tambah')
{
	include "aksi/datacommodity_ap-tambah.php";
} 
//---------------End of Menambah Data commodity--------------------------------------------------


//---------------Edit Data commodity---------------------------------------------------------
if ($module=='datacommodity_ap' AND $act=='edit')
{
	include "aksi/datacommodity_ap-edit.php";
} 
//---------------End of Edit Data commodity--------------------------------------------------


//---------------Menghapus Data customer-------------------------------------------------
if ($module=='datacustomer' AND $act=='hapus')
{
	include "aksi/datacustomer-hapus.php";
}
//---------------End of Menghapus Data customer-------------------------------------------------


//---------------Menambah Data customer---------------------------------------------------------
if ($module=='datacustomer' AND $act=='tambah')
{
	include "aksi/datacustomer-tambah.php";
} 
//---------------End of Menambah Data customer--------------------------------------------------


//---------------Edit Data customer---------------------------------------------------------
if ($module=='datacustomer' AND $act=='edit')
{
	include "aksi/datacustomer-edit.php";
} 
//---------------End of Edit Data customer--------------------------------------------------


//---------------Menghapus Data Flight  -------------------------------------------------
if ($module=='dataflightno' AND $act=='hapus')
{
	include "aksi/dataflightno-hapus.php";
}
//---------------End of Menghapus Data flight -------------------------------------------------


//---------------Menambah Data flight---------------------------------------------------------
if ($module=='dataflightno' AND $act=='tambah')
{
	include "aksi/dataflightno-tambah.php";
} 
//---------------End of Menambah Data flight--------------------------------------------------


//---------------Edit Data flight---------------------------------------------------------
if ($module=='dataflightno' AND $act=='edit')
{
	include "aksi/dataflightno-edit.php";
} 
//---------------End of Edit Data flight--------------------------------------------------


//---------------VOID Data Manifest Export  -------------------------------------------------
if ($module=='carimanifestexport' AND $act=='void')
{
	include "aksi/carimanifestexport-void.php";
}
//---------------End of VOID Data Manifest Export -------------------------------------------------


//---------------RELEASE Data Manifest Export  -------------------------------------------------
if ($module=='carimanifestexport' AND $act=='release')
{
	include "aksi/carimanifestexport-release.php";
}
//---------------End of VOID Data Manifest Export -------------------------------------------------


//---------------RELEASE AWB Import -------------------------------------------------
if ($module=='cariawbimport' AND $act=='release')
{
	include "aksi/cariawbimport-release.php";
}
//----------------END OF RELEASE AWB IMPORT------------------------------


if ($module=='cariawbimport' AND $act=='voiddb')
{
	include "aksi/cariawbimport-voiddb.php";
}
//---------------End of VOID Data Manifest Export -------------------------------------------------


//---------------Menghapus Data destination  -------------------------------------------------
if ($module=='datadestinasi' AND $act=='hapus')
{
	include "aksi/datadestinasi-hapus.php";
}
//---------------End of Menghapus Data destination -------------------------------------------------


//---------------Menambah Data destination---------------------------------------------------------
if ($module=='datadestinasi' AND $act=='tambah')
{
	include "aksi/datadestinasi-tambah.php";
} 
//---------------End of Menambah Data destination--------------------------------------------------


//---------------Edit Data destination---------------------------------------------------------
if ($module=='datadestinasi' AND $act=='edit')
{
	include "aksi/datadestinasi-edit.php";
} 
//---------------End of Edit Data destination--------------------------------------------------


//---------------Menghapus Data origin  -------------------------------------------------
if ($module=='dataorigin' AND $act=='hapus')
{
	include "aksi/dataorigin-hapus.php";
}
//---------------End of Menghapus Data origin -------------------------------------------------


//---------------Menambah Data origin---------------------------------------------------------
if ($module=='dataorigin' AND $act=='tambah')
{
	include "aksi/dataorigin-tambah.php";
} 
//---------------End of Menambah Data origin--------------------------------------------------


//---------------Edit Data origin---------------------------------------------------------
if ($module=='dataorigin' AND $act=='edit')
{
	include "aksi/dataorigin-edit.php";
} 
//---------------End of Edit Data origin--------------------------------------------------

//******************************END OF SUPERVISOR *************************************


// Input user
if ($module=='user' AND $act=='input')
{
	include "aksi/user-input.php";
}  


//update user by admin
elseif ($module=='user' AND $act=='update')
{
	include "aksi/user-updatebyadmin.php";
}

// Hapus user
elseif ($module=='user' AND $act=='hapus')
{
	include "aksi/user-hapus.php";
}


// Update user
elseif ($act=='user_update')
{
	include "aksi/user_update.php";
}


// Input modul
elseif ($module=='modul' AND $act=='input')
{
	include "aksi/modul-input.php";
}

// Update modul
elseif ($module=='modul' AND $act=='update')
{
	include "aksi/modul-update.php";
}


// Input agenda
elseif ($module=='agenda' AND $act=='input')
{
	include "aksi/agenda-input.php";
}


// Update agenda
elseif ($module=='agenda' AND $act=='update')
{
	include "aksi/agenda-update.php";
}


// Input pengumuman
elseif ($module=='pengumuman' AND $act=='input')
{
	include "aksi/pengumuman-input.php";
}


// Update pengumuman
elseif ($module=='pengumuman' AND $act=='update')
{
	include "aksi/pengumuman-update.php";
}


// Input berita
elseif ($module=='berita' AND $act=='input')
{
	include "aksi/berita-input.php";
}


// Update berita
elseif ($module=='berita' AND $act=='update')
{
	include "aksi/berita-update.php";
}


// Input banner
elseif ($module=='banner' AND $act=='input')
{
	include "aksi/banner-input.php";
}

// Update banner
elseif ($module=='banner' AND $act=='update')
{
	include "aksi/banner-update.php";
}

//****************************************************************************************
//OUTBOUND
//****************************************************************************************
// Input carabayar
elseif ($module=='carabayar' AND $act=='input')
{
	include "aksi/carabayar-input.php";
}

// Update carabayar
elseif ($module=='carabayar' AND $act=='update')
{
	include "aksi/carabayar-update.php";
}

// Input jenis ULD
elseif ($module=='jenisuld' AND $act=='input')
{
	include "aksi/jenisuld-input.php";
}

// Update jenis ULD
elseif ($module=='jenisuld' AND $act=='update')
{
	include "aksi/jenisuld-update.php";
}

// Input Operator Airlines
elseif ($module=='operatorairline' AND $act=='input')
{
	include "aksi/operatorairline-input.php";
}

// Update Operator Airlines
elseif ($module=='operatorairline' AND $act=='update')
{
	include "aksi/operatorairline-update.php";
}

// Input jenis barang
elseif ($module=='jenisbarang' AND $act=='input')
{
	include "aksi/jenisbarang-input.php";
}

// Update jenis barang
elseif ($module=='jenisbarang' AND $act=='update')
{
	include "aksi/jenisbarang-update.php";
}

// Input komoditi
elseif ($module=='komoditi' AND $act=='input')
{
	include "aksi/komoditi-input.php";
}

// Update komoditi
elseif ($module=='komoditi' AND $act=='update')
{
	include "aksi/komoditi-update.php";
}

// Input Kota Tujuan
elseif ($module=='kotatujuan' AND $act=='input')
{
	include "aksi/kotatujuan-input.php";
}

// Update Kota Tujuan
elseif ($module=='kotatujuan' AND $act=='update')
{
	include "aksi/kotatujuan-update.php";
}

// Input ULD
elseif ($module=='uld' AND $act=='input')
{
	include "aksi/uld-input.php";
}

// Update ULD
elseif ($module=='uld' AND $act=='update')
{
	include "aksi/uld-update.php";
}

// Input Pelanggan
elseif ($module=='pelanggan' AND $act=='input')
{
	include "aksi/pelanggan-input.php";
}

// Update Pelanggan
elseif ($module=='pelanggan' AND $act=='update')
{
	include "aksi/pelanggan-update.php";
}

// Input SMU --> no belum diset duplikat
elseif ($module=='smu' AND $act=='input')
{
	include "aksi/smu-input.php";
}

// Update SMU
elseif ($module=='smu' AND $act=='update')
{
	include "aksi/smu-update.php";
}

// Input BarangOutbound 
elseif ($module=='barangoutbound' AND $act=='input')
{
	include "aksi/barangoutbound-input.php";
}


//************************START OF KASIR***************************************************
elseif ($module=='voiddb')
{
	include "aksi/voiddb.php";
}

elseif ($module=='dailyreport')
{
	include "aksi/dailyreport.php";
}	

//===============================begin of kasirlapcetakk
elseif ($module=='kasirlapcetakk')
{
	include "aksi/kasirlapcetakk.php";
}//end of if SMU !	


// CARI btb/smu UTK Delivery Bill
elseif ($module=='deliverybill' AND $act=='caribtbsmu')
{
	include "aksi/deliverybill-caribtbsmu.php";
}

// Input Deliverybillz
elseif ($module=='deliverybill' AND $act=='input')
{
	include "aksi/deliverybill-input.php";
}


elseif ($module=='cetakdb')
{
	include "aksi/cetakdb.php";
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
	include "aksi/kasirlapcetak.php";
}//end of if SMU !	


// CARI btb/smu UTK Delivery Bill
elseif ($module=='deliverybill' AND $act=='caribtbsmu')
{
	include "aksi/deliverybill-caribtbsmu1.php";
}

// Input Deliverybill
elseif ($module=='deliverybill' AND $act=='input')
{
	include "aksi/deliverybill-input1.php";
}


elseif ($module=='cetaklap')
{
	include "aksi/cetaklap.php";
}


// edit no.smu
elseif ($module=='editnosmu')
{
	include "aksi/editnosmu.php";
}


elseif ($module=='release_ambil')
{
	include "aksi/release_ambil.php";
}

elseif ($module=='release_confirm')
{
	include "aksi/release_confirm.php";
}



//********************************************

//BTBLEVEL
//cetak BTB
elseif (($module=='btb') AND ($act=='cetak'))
{
	include "aksi/btb-cetak.php";
}


//hapus isi BTB
elseif ($module=='isibtb' AND $act=='hapus')
{
	include "aksi/isibtb-hapus.php";
}


// Input Isi BTB
else if(($module=='isibtb') AND ($act=='input'))
{
	include "aksi/isibtb-input.php";
}


// input BTB
elseif ($module=='btb' AND $act=='input')
{
	include "aksi/btb-input.php";
}

elseif ($module=='btb' AND $act=='hapus')
{
	include "aksi/btb-hapus.php";
}


//edit smu btb
elseif ($module=='btb' AND $act=='edit')
{
	include "aksi/btb-edit.php";
}


//END OF BTB LEVEL



//INCOMING LEVEL
// Input manifest incoming
elseif ($module=='manifestin' AND $act=='input')
{
	include "aksi/manifestin-input.php";
}


//edit Manifestin
elseif ($module=='manifestin' AND $act=='edit')
{
	include "aksi/manifestin-edit.php";
}


// Input Isi Manifest In
else if(($module=='isimanifestin') AND ($act=='input'))
{
	include "aksi/isimanifestin-input.php";
}


// Hapus isi manifest
elseif ($module=='isimanifestin' AND $act=='hapus')
{
	include "aksi/isimanifestin-hapus.php";
}


// CANCEL SMU YANG SUDAH ADA DI MANIFEST 
elseif ($module=='isimanifestin' AND $act=='cancel')
{
	include "aksi/isimanifestin-cancel.php";
}

// Hapus data manifest 
elseif ($module=='manifestin' AND $act=='hapus')
{
	include "aksi/manifestin-hapus.php";
}


// Hapus data breakdown 
elseif ($module=='breakdown' AND $act=='hapus')
{
	include "aksi/breakdown-hapus.php";
}


// CHECKED Manifest Incoming
elseif (($module=='manifestin') AND ($act=='checked'))
{
	include "aksi/manifestin-checked.php";
}


// CHECKED SMU!-confirm
elseif (($module=='manifestin') AND ($act=='smuchecked'))
{
	include "aksi/manifestin-smuchecked.php";
}


// keluarkan barang
elseif ($module=='keluarbarangin')
{
	include "aksi/keluarbarangin.php";
}


// edit isi manifest / breakdown
elseif ($module=='isimanifestin' AND $act=='edit')
{
	include "aksi/isimanifestin-edit.php";
}


// Input breakdown
elseif ($module=='breakdown' AND $act=='input')
{
	include "aksi/breakdown-input.php";
}


//******************* LEVEL OUTGOING

// batal manifest out
elseif ($module=='batalmo')
{
	include "aksi/batalmo.php";
}


// Input manifest outgoing
elseif ($module=='manifestout' AND $act=='input')
{
	include "aksi/manifestout-input.php";
}


//edit manifestout
elseif ($module=='manifestout' AND $act=='edit')
{
	include "aksi/manifestout-edit.php";
}


// Input Isi Manifest In
elseif ($module=='isimanifestout' AND $act=='input')
{
	include "aksi/isimanifestout-input.php";
}

// Hapus isi manifest
elseif ($module=='isimanifestout' AND $act=='hapus')
{
	include "aksi/isimanifestout-hapus.php";
}
// CANCEL SMU YANG SUDAH ADA DI MANIFEST 
elseif ($module=='isimanifestout' AND $act=='cancel')
{
	include "aksi/isimanifestout-cancel.php";
}


// Hapus data manifest 
elseif ($module=='manifestout' AND $act=='hapus')
{
	include "aksi/manifestout-hapus.php";
}


// Hapus data breakdown 
elseif ($module=='breakdown' AND $act=='hapus')
{
	include "aksi/breakdown-hapus1.php";
}


// CHECKED Manifest Outgoing
elseif (($module=='manifestout') AND ($act=='checked'))
{
	include "aksi/manifestout-checked.php";
}


// keluarkan barang
elseif ($module=='keluarbarangin')
{
	include "aksi/keluarbarangin1.php";
}


// edit isi manifest / breakdown
elseif ($module=='isimanifestout' AND $act=='edit')
{
	include "aksi/isimanifestout-edit.php";
}

// Input breakdownb-tidak dipake
elseif ($module=='breakdown' AND $act=='input')
{
 	include "aksi/breakdown-input1.php";	
}




// CARI SMU utk TRACING
elseif ($module=='tracing' AND $act=='caribtbsmu')
{
}

elseif ($module=='flown_ga')
{
	include "aksi/flown_ga.php";
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
			$this->Cell(0,6,'PT. GAPURA ANGKASA',0,0,'L');$this->Ln();
			$this->Cell(0,6,'SUMMARY INTERNATIONAL CARGO REPORT',0,0,'L');$this->Ln();
			$this->Cell(0,6,'AIRLINE HANDLING BY GAPURA',0,0,'L');$this->Ln();
			$this->SetFont('Times','I',11);
			$this->Cell(170,6,'Periode : '.$_POST[tglawal].' s/d '.$_POST[tglakhir],0,0,'L',1);
			$this->Ln();$this->Cell(170,5,$_POST[filter],0,0,'L',1);
			$this->Ln(10);
		}
		
		//Page footer
		function Footer()
		{
			$this->SetY(-30);
			$this->SetFont('Arial','I',9);
			$this->Cell(0,5,'PT. GAPURA ANGKASA - BALI - WMS Page '.$this->PageNo().'/{nb}',0,0,'C');
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
	$pdf->Cell(20,5,'',1,0,'C',1);
	$pdf->Cell(240,5,'BULAN',1,0,'C',1);
	$pdf->CEll(20,5,'',1,0,'C',1);
	$pdf->Ln();
	$pdf->Cell(20,5,'AIRLINE',1,0,'C',1);
	$pdf->Cell(20,5,'JAN',1,0,'C',1);
	$pdf->Cell(20,5,'FEB',1,0,'C',1);	
	$pdf->Cell(20,5,'MAR',1,0,'C',1);
	$pdf->Cell(20,5,'APR',1,0,'C',1);		
	$pdf->Cell(20,5,'MAY',1,0,'C',1);
	$pdf->Cell(20,5,'JUN',1,0,'C',1);	
	$pdf->Cell(20,5,'JUL',1,0,'C',1);
	$pdf->Cell(20,5,'AUG',1,0,'C',1);	
	$pdf->Cell(20,5,'SEP',1,0,'C',1);
	$pdf->Cell(20,5,'OCT',1,0,'C',1);	
	$pdf->Cell(20,5,'NOP',1,0,'C',1);
	$pdf->Cell(20,5,'DEC',1,0,'C',1);	
	$pdf->CEll(20,5,'TOTAL',1,0,'C',1);	
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
	$jan0=0;
$feb0=0;
$mar0=0;
$apr0=0;
$may0=0;
$jun0=0;
$jul0=0;
$aug0=0;
$sep0=0;
$oct0=0;
$nop0=0;
$dec0=0;
$tot0=0;

	$jan1=0;
$feb1=0;
$mar1=0;
$apr1=0;
$may1=0;
$jun1=0;
$jul1=0;
$aug1=0;
$sep1=0;
$oct1=0;
$nop1=0;
$dec1=0;
$tot1=0;
	//export duluan 
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
		AND o.origin_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
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
		AND o.origin_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");		
	}	
		$pdf->SetFont('Arial','BI',9);
		$pdf->Cell(280,5,'EXPORT',0,0,'L',0);$pdf->SetFont('Arial','',9);
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

				$jan0+=$jan;
				$feb0+=$feb;
				$mar0+=$mar;
				$apr0+=$apr;
				$may0+=$may;
				$jun0+=$jun;
				$jul0+=$jul;
				$aug0+=$aug;
				$sep0+=$sep;
				$oct0+=$oct;
				$nop0+=$nop;
				$dec0+=$dec;	
				$tot0+=$tot;		
				
		
			$pdf->Cell(20,5,$r1[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();
			
		}	
$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,'Total',1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan0, 1, ',', '.'),1,0,'R',1);}
			if($feb0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb0, 1, ',', '.'),1,0,'R',1);}
			if($mar0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar0, 1, ',', '.'),1,0,'R',1);}
			if($apr0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr0, 1, ',', '.'),1,0,'R',1);}
			if($may0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may0, 1, ',', '.'),1,0,'R',1);}
			if($jun0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun0, 1, ',', '.'),1,0,'R',1);}
			if($jul0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul0, 1, ',', '.'),1,0,'R',1);}
			if($aug0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug0, 1, ',', '.'),1,0,'R',1);}
			if($sep0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep0, 1, ',', '.'),1,0,'R',1);}
			if($oct0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct0, 1, ',', '.'),1,0,'R',1);}
			if($nop0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop0, 1, ',', '.'),1,0,'R',1);}
			if($dec0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec0, 1, ',', '.'),1,0,'R',1);}
			if($tot0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot0, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 		
				$jan1+=$jan0;
				$feb1+=$feb0;
				$mar1+=$mar0;
				$apr1+=$apr0;
				$may1+=$may0;
				$jun1+=$jun0;
				$jul1+=$jul0;
				$aug1+=$aug0;
				$sep1+=$sep0;
				$oct1+=$oct0;
				$nop1+=$nop0;
				$dec1+=$dec0;	
				$tot1+=$tot0;				
			
//import:
	$jan0=0;
$feb0=0;
$mar0=0;
$apr0=0;
$may0=0;
$jun0=0;
$jul0=0;
$aug0=0;
$sep0=0;
$oct0=0;
$nop0=0;
$dec0=0;
$tot0=0;
		if($_POST[airline]=='SEMUA')
	{
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestin= m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND d.dest_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
	}
	else if($_POST[airline]<>'SEMUA')   
	{
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestin= m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND cs.customer='$_POST[airline]' AND
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND d.dest_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");		
	}	
		$pdf->SetFont('Arial','BI',9);
		$pdf->Cell(280,5,'IMPORT',0,0,'L',0);$pdf->SetFont('Arial','',9);
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
		
			$pdf->Cell(20,5,$r1[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
							$jan0+=$jan;
				$feb0+=$feb;
				$mar0+=$mar;
				$apr0+=$apr;
				$may0+=$may;
				$jun0+=$jun;
				$jul0+=$jul;
				$aug0+=$aug;
				$sep0+=$sep;
				$oct0+=$oct;
				$nop0+=$nop;
				$dec0+=$dec;	
				$tot0+=$tot;		
		}	
						$jan1+=$jan0;
				$feb1+=$feb0;
				$mar1+=$mar0;
				$apr1+=$apr0;
				$may1+=$may0;
				$jun1+=$jun0;
				$jul1+=$jul0;
				$aug1+=$aug0;
				$sep1+=$sep0;
				$oct1+=$oct0;
				$nop1+=$nop0;
				$dec1+=$dec0;	
				$tot1+=$tot0;			
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,'Total',1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan0, 1, ',', '.'),1,0,'R',1);}
			if($feb0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb0, 1, ',', '.'),1,0,'R',1);}
			if($mar0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar0, 1, ',', '.'),1,0,'R',1);}
			if($apr0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr0, 1, ',', '.'),1,0,'R',1);}
			if($may0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may0, 1, ',', '.'),1,0,'R',1);}
			if($jun0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun0, 1, ',', '.'),1,0,'R',1);}
			if($jul0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul0, 1, ',', '.'),1,0,'R',1);}
			if($aug0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug0, 1, ',', '.'),1,0,'R',1);}
			if($sep0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep0, 1, ',', '.'),1,0,'R',1);}
			if($oct0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct0, 1, ',', '.'),1,0,'R',1);}
			if($nop0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop0, 1, ',', '.'),1,0,'R',1);}
			if($dec0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec0, 1, ',', '.'),1,0,'R',1);}
			if($tot0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot0, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 		
//end of import
//transit mulai :
	$jan0=0;
$feb0=0;
$mar0=0;
$apr0=0;
$may0=0;
$jun0=0;
$jul0=0;
$aug0=0;
$sep0=0;
$oct0=0;
$nop0=0;
$dec0=0;
$tot0=0;
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
		AND o.origin_code<>'MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
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
		AND o.origin_code<>'MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");		
	}	
		$pdf->SetFont('Arial','BI',9);
		$pdf->Cell(280,5,'TRANSIT',0,0,'L',0);$pdf->SetFont('Arial','',9);
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
		
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r1[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
							$jan0+=$jan;
				$feb0+=$feb;
				$mar0+=$mar;
				$apr0+=$apr;
				$may0+=$may;
				$jun0+=$jun;
				$jul0+=$jul;
				$aug0+=$aug;
				$sep0+=$sep;
				$oct0+=$oct;
				$nop0+=$nop;
				$dec0+=$dec;	
				$tot0+=$tot;		
		}	
						$jan1+=$jan0;
				$feb1+=$feb0;
				$mar1+=$mar0;
				$apr1+=$apr0;
				$may1+=$may0;
				$jun1+=$jun0;
				$jul1+=$jul0;
				$aug1+=$aug0;
				$sep1+=$sep0;
				$oct1+=$oct0;
				$nop1+=$nop0;
				$dec1+=$dec0;	
				$tot1+=$tot0;			
//enf transit		
$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,'Total',1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan0, 1, ',', '.'),1,0,'R',1);}
			if($feb0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb0, 1, ',', '.'),1,0,'R',1);}
			if($mar0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar0, 1, ',', '.'),1,0,'R',1);}
			if($apr0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr0, 1, ',', '.'),1,0,'R',1);}
			if($may0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may0, 1, ',', '.'),1,0,'R',1);}
			if($jun0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun0, 1, ',', '.'),1,0,'R',1);}
			if($jul0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul0, 1, ',', '.'),1,0,'R',1);}
			if($aug0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug0, 1, ',', '.'),1,0,'R',1);}
			if($sep0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep0, 1, ',', '.'),1,0,'R',1);}
			if($oct0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct0, 1, ',', '.'),1,0,'R',1);}
			if($nop0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop0, 1, ',', '.'),1,0,'R',1);}
			if($dec0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec0, 1, ',', '.'),1,0,'R',1);}
			if($tot0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot0, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
			
			//grandtotal
					
			$pdf->Ln(3);	 $pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,'Grand Total',1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan1, 1, ',', '.'),1,0,'R',1);}
			if($feb1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb1, 1, ',', '.'),1,0,'R',1);}
			if($mar1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar1, 1, ',', '.'),1,0,'R',1);}
			if($apr1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr1, 1, ',', '.'),1,0,'R',1);}
			if($may1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may1, 1, ',', '.'),1,0,'R',1);}
			if($jun1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun1, 1, ',', '.'),1,0,'R',1);}
			if($jul1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul1, 1, ',', '.'),1,0,'R',1);}
			if($aug1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug1, 1, ',', '.'),1,0,'R',1);}
			if($sep1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep1, 1, ',', '.'),1,0,'R',1);}
			if($oct1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct1, 1, ',', '.'),1,0,'R',1);}
			if($nop1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop1, 1, ',', '.'),1,0,'R',1);}
			if($dec1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec1, 1, ',', '.'),1,0,'R',1);}
			if($tot0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot1, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 			
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
		AND o.origin_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");


		$pdf->SetFont('Arial','BI',9);
		$pdf->Cell(280,5,'EXPORT',0,0,'L',0);
		$pdf->Ln();	 
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='01' group by MONTH(flightdate)"));
			$jan=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='02' group by MONTH(flightdate)"));
			$feb=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='03' group by MONTH(flightdate)"));
			$mar=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='04' group by MONTH(flightdate)"));
			$apr=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='05' group by MONTH(flightdate)"));
			$may=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='06' group by MONTH(flightdate)"));
			$jun=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='07' group by MONTH(flightdate)"));
			$jul=$r[0];			
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='08' group by MONTH(flightdate)"));
			$aug=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='09' group by MONTH(flightdate)"));
			$sep=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='10' group by MONTH(flightdate)"));
			$oct=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='11' group by MONTH(flightdate)"));
			$nop=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='12' group by MONTH(flightdate)"));
			$dec=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily"));
			$tot=$r[0];			
		$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,'ALL',1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}	
else
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
		AND o.origin_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");		
		
		$pdf->SetFont('Arial','BI',9);
		$pdf->Cell(280,5,'EXPORT',0,0,'L',0);
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
		$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r1[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}	
}
		

}
else if($outin=='0')//INCOMINGPROSES SUMMARY CARGO
{
		if($_POST[airline]=='SEMUA')
	{
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestin= m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND d.dest_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");


		$pdf->SetFont('Arial','BI',9);
		$pdf->Cell(280,5,'IMPORT',0,0,'L',0);
		$pdf->Ln();	 
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='01' group by MONTH(flightdate)"));
			$jan=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='02' group by MONTH(flightdate)"));
			$feb=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='03' group by MONTH(flightdate)"));
			$mar=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='04' group by MONTH(flightdate)"));
			$apr=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='05' group by MONTH(flightdate)"));
			$may=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='06' group by MONTH(flightdate)"));
			$jun=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='07' group by MONTH(flightdate)"));
			$jul=$r[0];			
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='08' group by MONTH(flightdate)"));
			$aug=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='09' group by MONTH(flightdate)"));
			$sep=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='10' group by MONTH(flightdate)"));
			$oct=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='11' group by MONTH(flightdate)"));
			$nop=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='12' group by MONTH(flightdate)"));
			$dec=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily"));
			$tot=$r[0];			
		$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,'ALL',1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}	
else
{
			mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestin= m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND cs.customer='$_POST[airline]' AND
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND d.dest_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");		
		
		$pdf->SetFont('Arial','BI',9);
		$pdf->Cell(280,5,'IMPORT',0,0,'L',0);
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
		$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r1[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}	
}
		
}
else if($outin=='3')// TRANSIT PROSES SUMMARY CARGO
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
		AND o.origin_code<>'MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");


		$pdf->SetFont('Arial','BI',9);
		$pdf->Cell(280,5,'TRANSIT',0,0,'L',0);
		$pdf->Ln();	 
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='01' group by MONTH(flightdate)"));
			$jan=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='02' group by MONTH(flightdate)"));
			$feb=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='03' group by MONTH(flightdate)"));
			$mar=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='04' group by MONTH(flightdate)"));
			$apr=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='05' group by MONTH(flightdate)"));
			$may=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='06' group by MONTH(flightdate)"));
			$jun=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='07' group by MONTH(flightdate)"));
			$jul=$r[0];			
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='08' group by MONTH(flightdate)"));
			$aug=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='09' group by MONTH(flightdate)"));
			$sep=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='10' group by MONTH(flightdate)"));
			$oct=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='11' group by MONTH(flightdate)"));
			$nop=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='12' group by MONTH(flightdate)"));
			$dec=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily"));
			$tot=$r[0];			
		$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,'ALL',1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}	
else
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
		AND o.origin_code<>'MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");		
		
		$pdf->SetFont('Arial','BI',9);
		$pdf->Cell(280,5,'TRANSIT',0,0,'L',0);
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
		$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r1[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}	
}
		
} //END OF TRANSIT TONASE

} //END OF PER TONASE
	
ELSE IF($_POST[filter]=='PER KOLI')
{
if($outin=='2')//SEMUA PROSES SUMMARY CARGO - PER KOLI
{
		$jan1=0;
$feb1=0;
$mar1=0;
$apr1=0;
$may1=0;
$jun1=0;
$jul1=0;
$aug1=0;
$sep1=0;
$oct1=0;
$nop1=0;
$dec1=0;
$tot1=0;

$jan0=0;
$feb0=0;
$mar0=0;
$apr0=0;
$may0=0;
$jun0=0;
$jul0=0;
$aug0=0;
$sep0=0;
$oct0=0;
$nop0=0;
$dec0=0;
$tot0=0;
	//export :
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
		AND o.origin_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
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
		AND o.origin_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");		
	}	
		$pdf->SetFont('Arial','BI',9);
		$pdf->Cell(280,5,'EXPORT',0,0,'L',0);
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
		
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r1[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
							$jan0+=$jan;
				$feb0+=$feb;
				$mar0+=$mar;
				$apr0+=$apr;
				$may0+=$may;
				$jun0+=$jun;
				$jul0+=$jul;
				$aug0+=$aug;
				$sep0+=$sep;
				$oct0+=$oct;
				$nop0+=$nop;
				$dec0+=$dec;	
				$tot0+=$tot;	
		}		
						$jan1+=$jan0;
				$feb1+=$feb0;
				$mar1+=$mar0;
				$apr1+=$apr0;
				$may1+=$may0;
				$jun1+=$jun0;
				$jul1+=$jul0;
				$aug1+=$aug0;
				$sep1+=$sep0;
				$oct1+=$oct0;
				$nop1+=$nop0;
				$dec1+=$dec0;	
				$tot1+=$tot0;		
			$pdf->Ln(3);	 $pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,'Total',1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan0, 1, ',', '.'),1,0,'R',1);}
			if($feb0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb0, 1, ',', '.'),1,0,'R',1);}
			if($mar0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar0, 1, ',', '.'),1,0,'R',1);}
			if($apr0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr0, 1, ',', '.'),1,0,'R',1);}
			if($may0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may0, 1, ',', '.'),1,0,'R',1);}
			if($jun0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun0, 1, ',', '.'),1,0,'R',1);}
			if($jul0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul0, 1, ',', '.'),1,0,'R',1);}
			if($aug0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug0, 1, ',', '.'),1,0,'R',1);}
			if($sep0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep0, 1, ',', '.'),1,0,'R',1);}
			if($oct0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct0, 1, ',', '.'),1,0,'R',1);}
			if($nop0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop0, 1, ',', '.'),1,0,'R',1);}
			if($dec0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec0, 1, ',', '.'),1,0,'R',1);}
			if($tot0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot0, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 		
	//end ecport
	//import :
	$jan0=0;
$feb0=0;
$mar0=0;
$apr0=0;
$may0=0;
$jun0=0;
$jul0=0;
$aug0=0;
$sep0=0;
$oct0=0;
$nop0=0;
$dec0=0;
$tot0=0;
	if($_POST[airline]=='SEMUA')
	{
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestin= m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND d.dest_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
		
	}
	else if($_POST[airline]<>'SEMUA')   
	{
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestin= m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND cs.customer='$_POST[airline]' AND
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND d.dest_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");	
	}	
		$pdf->SetFont('Arial','BI',9);
		$pdf->Cell(280,5,'IMPORT',0,0,'L',0);
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
		
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r1[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
							$jan0+=$jan;
				$feb0+=$feb;
				$mar0+=$mar;
				$apr0+=$apr;
				$may0+=$may;
				$jun0+=$jun;
				$jul0+=$jul;
				$aug0+=$aug;
				$sep0+=$sep;
				$oct0+=$oct;
				$nop0+=$nop;
				$dec0+=$dec;	
				$tot0+=$tot;	
		}			
						$jan1+=$jan0;
				$feb1+=$feb0;
				$mar1+=$mar0;
				$apr1+=$apr0;
				$may1+=$may0;
				$jun1+=$jun0;
				$jul1+=$jul0;
				$aug1+=$aug0;
				$sep1+=$sep0;
				$oct1+=$oct0;
				$nop1+=$nop0;
				$dec1+=$dec0;	
				$tot1+=$tot0;		
			$pdf->Ln(3);	 $pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,'Total',1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan0, 1, ',', '.'),1,0,'R',1);}
			if($feb0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb0, 1, ',', '.'),1,0,'R',1);}
			if($mar0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar0, 1, ',', '.'),1,0,'R',1);}
			if($apr0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr0, 1, ',', '.'),1,0,'R',1);}
			if($may0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may0, 1, ',', '.'),1,0,'R',1);}
			if($jun0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun0, 1, ',', '.'),1,0,'R',1);}
			if($jul0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul0, 1, ',', '.'),1,0,'R',1);}
			if($aug0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug0, 1, ',', '.'),1,0,'R',1);}
			if($sep0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep0, 1, ',', '.'),1,0,'R',1);}
			if($oct0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct0, 1, ',', '.'),1,0,'R',1);}
			if($nop0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop0, 1, ',', '.'),1,0,'R',1);}
			if($dec0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec0, 1, ',', '.'),1,0,'R',1);}
			if($tot0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot0, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 		
	//end import
	//transit:
$jan0=0;
$feb0=0;
$mar0=0;
$apr0=0;
$may0=0;
$jun0=0;
$jul0=0;
$aug0=0;
$sep0=0;
$oct0=0;
$nop0=0;
$dec0=0;
$tot0=0;
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
		AND o.origin_code<>'MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
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
		AND o.origin_code<>'MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");		
	}	
		$pdf->SetFont('Arial','BI',9);
		$pdf->Cell(280,5,'TRANSIT',0,0,'L',0);
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
		
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r1[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
							$jan0+=$jan;
				$feb0+=$feb;
				$mar0+=$mar;
				$apr0+=$apr;
				$may0+=$may;
				$jun0+=$jun;
				$jul0+=$jul;
				$aug0+=$aug;
				$sep0+=$sep;
				$oct0+=$oct;
				$nop0+=$nop;
				$dec0+=$dec;	
				$tot0+=$tot;	
		}		
	//end transit
					$jan1+=$jan0;
				$feb1+=$feb0;
				$mar1+=$mar0;
				$apr1+=$apr0;
				$may1+=$may0;
				$jun1+=$jun0;
				$jul1+=$jul0;
				$aug1+=$aug0;
				$sep1+=$sep0;
				$oct1+=$oct0;
				$nop1+=$nop0;
				$dec1+=$dec0;	
				$tot1+=$tot0;		
			$pdf->Ln(3);	 $pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,'Total',1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan0, 1, ',', '.'),1,0,'R',1);}
			if($feb0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb0, 1, ',', '.'),1,0,'R',1);}
			if($mar0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar0, 1, ',', '.'),1,0,'R',1);}
			if($apr0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr0, 1, ',', '.'),1,0,'R',1);}
			if($may0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may0, 1, ',', '.'),1,0,'R',1);}
			if($jun0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun0, 1, ',', '.'),1,0,'R',1);}
			if($jul0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul0, 1, ',', '.'),1,0,'R',1);}
			if($aug0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug0, 1, ',', '.'),1,0,'R',1);}
			if($sep0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep0, 1, ',', '.'),1,0,'R',1);}
			if($oct0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct0, 1, ',', '.'),1,0,'R',1);}
			if($nop0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop0, 1, ',', '.'),1,0,'R',1);}
			if($dec0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec0, 1, ',', '.'),1,0,'R',1);}
			if($tot0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot0, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
			
			
						//grandtotal
					
			$pdf->Ln(3);	 $pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,'Grand Total',1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan1, 1, ',', '.'),1,0,'R',1);}
			if($feb1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb1, 1, ',', '.'),1,0,'R',1);}
			if($mar1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar1, 1, ',', '.'),1,0,'R',1);}
			if($apr1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr1, 1, ',', '.'),1,0,'R',1);}
			if($may1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may1, 1, ',', '.'),1,0,'R',1);}
			if($jun1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun1, 1, ',', '.'),1,0,'R',1);}
			if($jul1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul1, 1, ',', '.'),1,0,'R',1);}
			if($aug1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug1, 1, ',', '.'),1,0,'R',1);}
			if($sep1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep1, 1, ',', '.'),1,0,'R',1);}
			if($oct1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct1, 1, ',', '.'),1,0,'R',1);}
			if($nop1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop1, 1, ',', '.'),1,0,'R',1);}
			if($dec1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec1, 1, ',', '.'),1,0,'R',1);}
			if($tot0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot1, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 		
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
		AND o.origin_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");

		$pdf->SetFont('Arial','BI',9);
		$pdf->Cell(280,5,'EXPORT',0,0,'L',0);
		$pdf->Ln();	 
		$str_airline=mysql_query("select airline from super_daily group by airline");

			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='01' group by MONTH(flightdate)"));
			$jan=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='02' group by MONTH(flightdate)"));
			$feb=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='03' group by MONTH(flightdate)"));
			$mar=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='04' group by MONTH(flightdate)"));
			$apr=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='05' group by MONTH(flightdate)"));
			$may=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='06' group by MONTH(flightdate)"));
			$jun=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='07' group by MONTH(flightdate)"));
			$jul=$r[0];			
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='08' group by MONTH(flightdate)"));
			$aug=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='09' group by MONTH(flightdate)"));
			$sep=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='10' group by MONTH(flightdate)"));
			$oct=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='11' group by MONTH(flightdate)"));
			$nop=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='12' group by MONTH(flightdate)"));
			$dec=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily"));
			$tot=$r[0];			
		
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,'ALL',1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}	
	else
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
		AND o.origin_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");	
		$pdf->SetFont('Arial','BI',9);
		$pdf->Cell(280,5,'EXPORT',0,0,'L',0);
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
		
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r1[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}			
		
	}	
}
else if($outin=='0')//INCOMING PROSES SUMMARY CARGO - PER KOLI
{
	if($_POST[airline]=='SEMUA')
	{
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestin= m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND d.dest_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");

		$pdf->SetFont('Arial','BI',9);
		$pdf->Cell(280,5,'IMPORT',0,0,'L',0);
		$pdf->Ln();	 
		$str_airline=mysql_query("select airline from super_daily group by airline");

			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='01' group by MONTH(flightdate)"));
			$jan=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='02' group by MONTH(flightdate)"));
			$feb=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='03' group by MONTH(flightdate)"));
			$mar=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='04' group by MONTH(flightdate)"));
			$apr=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='05' group by MONTH(flightdate)"));
			$may=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='06' group by MONTH(flightdate)"));
			$jun=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='07' group by MONTH(flightdate)"));
			$jul=$r[0];			
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='08' group by MONTH(flightdate)"));
			$aug=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='09' group by MONTH(flightdate)"));
			$sep=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='10' group by MONTH(flightdate)"));
			$oct=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='11' group by MONTH(flightdate)"));
			$nop=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='12' group by MONTH(flightdate)"));
			$dec=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily"));
			$tot=$r[0];			
		
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,'ALL',1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}	
	else
	{
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestin= m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND cs.customer='$_POST[airline]' AND
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND d.dest_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");	
		$pdf->SetFont('Arial','BI',9);
		$pdf->Cell(280,5,'IMPORT',0,0,'L',0);
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
		
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r1[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}			
		
	}	
}
else if($outin=='3')// TRANSIT PROSES SUMMARY CARGO -PER KOLI
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
		AND o.origin_code<>'MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");

		$pdf->SetFont('Arial','BI',9);
		$pdf->Cell(280,5,'TRANSIT',0,0,'L',0);
		$pdf->Ln();	 
		$str_airline=mysql_query("select airline from super_daily group by airline");

			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='01' group by MONTH(flightdate)"));
			$jan=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='02' group by MONTH(flightdate)"));
			$feb=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='03' group by MONTH(flightdate)"));
			$mar=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='04' group by MONTH(flightdate)"));
			$apr=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='05' group by MONTH(flightdate)"));
			$may=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='06' group by MONTH(flightdate)"));
			$jun=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='07' group by MONTH(flightdate)"));
			$jul=$r[0];			
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='08' group by MONTH(flightdate)"));
			$aug=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='09' group by MONTH(flightdate)"));
			$sep=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='10' group by MONTH(flightdate)"));
			$oct=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='11' group by MONTH(flightdate)"));
			$nop=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily 
			where MONTH(flightdate)='12' group by MONTH(flightdate)"));
			$dec=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(koli) from super_daily"));
			$tot=$r[0];			
		
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,'ALL',1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}	
	else
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
		AND o.origin_code<>'MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
		$pdf->SetFont('Arial','BI',9);
		$pdf->Cell(280,5,'TRANSIT',0,0,'L',0);
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
		
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r1[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}			
		
	}	
}// END TRANSIT KOLI	

}//END OF PER KOLI

ELSE IF($_POST[filter]=='PER JML SMU')
{
if($outin=='2')//SEMUA PROSES SUMMARY CARGO - PER JML SMU
{
	$jan1=0;
$feb1=0;
$mar1=0;
$apr1=0;
$may1=0;
$jun1=0;
$jul1=0;
$aug1=0;
$sep1=0;
$oct1=0;
$nop1=0;
$dec1=0;
$tot1=0;

$jan0=0;
$feb0=0;
$mar0=0;
$apr0=0;
$may0=0;
$jun0=0;
$jul0=0;
$aug0=0;
$sep0=0;
$oct0=0;
$nop0=0;
$dec0=0;
$tot0=0;	
	//export:
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
		AND o.origin_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
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
		AND o.origin_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");		
	}	
		$pdf->SetFont('Arial','BI',9);
		$pdf->Cell(280,5,'EXPORT',0,0,'L',0);
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
		
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r1[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
							$jan0+=$jan;
				$feb0+=$feb;
				$mar0+=$mar;
				$apr0+=$apr;
				$may0+=$may;
				$jun0+=$jun;
				$jul0+=$jul;
				$aug0+=$aug;
				$sep0+=$sep;
				$oct0+=$oct;
				$nop0+=$nop;
				$dec0+=$dec;	
				$tot0+=$tot;	
		}		
									$pdf->Ln(3);	 $pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,'Total',1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan0, 1, ',', '.'),1,0,'R',1);}
			if($feb0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb0, 1, ',', '.'),1,0,'R',1);}
			if($mar0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar0, 1, ',', '.'),1,0,'R',1);}
			if($apr0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr0, 1, ',', '.'),1,0,'R',1);}
			if($may0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may0, 1, ',', '.'),1,0,'R',1);}
			if($jun0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun0, 1, ',', '.'),1,0,'R',1);}
			if($jul0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul0, 1, ',', '.'),1,0,'R',1);}
			if($aug0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug0, 1, ',', '.'),1,0,'R',1);}
			if($sep0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep0, 1, ',', '.'),1,0,'R',1);}
			if($oct0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct0, 1, ',', '.'),1,0,'R',1);}
			if($nop0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop0, 1, ',', '.'),1,0,'R',1);}
			if($dec0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec0, 1, ',', '.'),1,0,'R',1);}
			if($tot0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot0, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
						
						$jan1+=$jan0;
				$feb1+=$feb0;
				$mar1+=$mar0;
				$apr1+=$apr0;
				$may1+=$may0;
				$jun1+=$jun0;
				$jul1+=$jul0;
				$aug1+=$aug0;
				$sep1+=$sep0;
				$oct1+=$oct0;
				$nop1+=$nop0;
				$dec1+=$dec0;	
				$tot1+=$tot0;		
	//end export
	//import :
	$jan0=0;
$feb0=0;
$mar0=0;
$apr0=0;
$may0=0;
$jun0=0;
$jul0=0;
$aug0=0;
$sep0=0;
$oct0=0;
$nop0=0;
$dec0=0;
$tot0=0;	
			if($_POST[airline]=='SEMUA')
	{
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestin= m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND d.dest_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
	}
	else if($_POST[airline]<>'SEMUA')   
	{
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestin= m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND cs.customer='$_POST[airline]' AND
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND d.dest_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");		
	}	
		$pdf->SetFont('Arial','BI',9);
		$pdf->Cell(280,5,'IMPORT',0,0,'L',0);
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
		
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r1[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
							$jan0+=$jan;
				$feb0+=$feb;
				$mar0+=$mar;
				$apr0+=$apr;
				$may0+=$may;
				$jun0+=$jun;
				$jul0+=$jul;
				$aug0+=$aug;
				$sep0+=$sep;
				$oct0+=$oct;
				$nop0+=$nop;
				$dec0+=$dec;	
				$tot0+=$tot;	
		}		
						
									$pdf->Ln(3);	 $pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,'Total',1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan0, 1, ',', '.'),1,0,'R',1);}
			if($feb0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb0, 1, ',', '.'),1,0,'R',1);}
			if($mar0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar0, 1, ',', '.'),1,0,'R',1);}
			if($apr0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr0, 1, ',', '.'),1,0,'R',1);}
			if($may0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may0, 1, ',', '.'),1,0,'R',1);}
			if($jun0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun0, 1, ',', '.'),1,0,'R',1);}
			if($jul0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul0, 1, ',', '.'),1,0,'R',1);}
			if($aug0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug0, 1, ',', '.'),1,0,'R',1);}
			if($sep0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep0, 1, ',', '.'),1,0,'R',1);}
			if($oct0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct0, 1, ',', '.'),1,0,'R',1);}
			if($nop0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop0, 1, ',', '.'),1,0,'R',1);}
			if($dec0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec0, 1, ',', '.'),1,0,'R',1);}
			if($tot0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot0, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
			$jan1+=$jan0;
				$feb1+=$feb0;
				$mar1+=$mar0;
				$apr1+=$apr0;
				$may1+=$may0;
				$jun1+=$jun0;
				$jul1+=$jul0;
				$aug1+=$aug0;
				$sep1+=$sep0;
				$oct1+=$oct0;
				$nop1+=$nop0;
				$dec1+=$dec0;	
				$tot1+=$tot0;		
	//end import
	
$jan0=0;
$feb0=0;
$mar0=0;
$apr0=0;
$may0=0;
$jun0=0;
$jul0=0;
$aug0=0;
$sep0=0;
$oct0=0;
$nop0=0;
$dec0=0;
$tot0=0;	
	//transit:
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
		AND o.origin_code<>'MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
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
		AND o.origin_code<>'MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");		
	}	
		$pdf->SetFont('Arial','BI',9);
		$pdf->Cell(280,5,'TRANSIT',0,0,'L',0);
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
		
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r1[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
							$jan0+=$jan;
				$feb0+=$feb;
				$mar0+=$mar;
				$apr0+=$apr;
				$may0+=$may;
				$jun0+=$jun;
				$jul0+=$jul;
				$aug0+=$aug;
				$sep0+=$sep;
				$oct0+=$oct;
				$nop0+=$nop;
				$dec0+=$dec;	
				$tot0+=$tot;	
		}		
	//end transit
					$jan1+=$jan0;
				$feb1+=$feb0;
				$mar1+=$mar0;
				$apr1+=$apr0;
				$may1+=$may0;
				$jun1+=$jun0;
				$jul1+=$jul0;
				$aug1+=$aug0;
				$sep1+=$sep0;
				$oct1+=$oct0;
				$nop1+=$nop0;
				$dec1+=$dec0;	
				$tot1+=$tot0;		
			$pdf->Ln(3);	 $pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,'Total',1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan0, 1, ',', '.'),1,0,'R',1);}
			if($feb0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb0, 1, ',', '.'),1,0,'R',1);}
			if($mar0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar0, 1, ',', '.'),1,0,'R',1);}
			if($apr0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr0, 1, ',', '.'),1,0,'R',1);}
			if($may0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may0, 1, ',', '.'),1,0,'R',1);}
			if($jun0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun0, 1, ',', '.'),1,0,'R',1);}
			if($jul0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul0, 1, ',', '.'),1,0,'R',1);}
			if($aug0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug0, 1, ',', '.'),1,0,'R',1);}
			if($sep0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep0, 1, ',', '.'),1,0,'R',1);}
			if($oct0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct0, 1, ',', '.'),1,0,'R',1);}
			if($nop0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop0, 1, ',', '.'),1,0,'R',1);}
			if($dec0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec0, 1, ',', '.'),1,0,'R',1);}
			if($tot0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot0, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
			
			
						//grandtotal
					
			$pdf->Ln(3);	 $pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,'Grand Total',1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan1, 1, ',', '.'),1,0,'R',1);}
			if($feb1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb1, 1, ',', '.'),1,0,'R',1);}
			if($mar1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar1, 1, ',', '.'),1,0,'R',1);}
			if($apr1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr1, 1, ',', '.'),1,0,'R',1);}
			if($may1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may1, 1, ',', '.'),1,0,'R',1);}
			if($jun1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun1, 1, ',', '.'),1,0,'R',1);}
			if($jul1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul1, 1, ',', '.'),1,0,'R',1);}
			if($aug1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug1, 1, ',', '.'),1,0,'R',1);}
			if($sep1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep1, 1, ',', '.'),1,0,'R',1);}
			if($oct1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct1, 1, ',', '.'),1,0,'R',1);}
			if($nop1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop1, 1, ',', '.'),1,0,'R',1);}
			if($dec1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec1, 1, ',', '.'),1,0,'R',1);}
			if($tot0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot1, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 					
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
		AND o.origin_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");

		$pdf->SetFont('Arial','BI',9);
		$pdf->Cell(280,5,'EXPORT',0,0,'L',0);
		$pdf->Ln();	 
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='01' group by MONTH(flightdate)"));
			$jan=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='02' group by MONTH(flightdate)"));
			$feb=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='03' group by MONTH(flightdate)"));
			$mar=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='04' group by MONTH(flightdate)"));
			$apr=$r[0];		
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='05' group by MONTH(flightdate)"));
			$may=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='06' group by MONTH(flightdate)"));
			$jun=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='07' group by MONTH(flightdate)"));
			$jul=$r[0];			
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='08' group by MONTH(flightdate)"));
			$aug=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='09' group by MONTH(flightdate)"));
			$sep=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='10' group by MONTH(flightdate)"));
			$oct=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='11' group by MONTH(flightdate)"));
			$nop=$r[0];		
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='12' group by MONTH(flightdate)"));
			$dec=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily"));
			$tot=$r[0];			
		
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,'ALL',1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}	
else
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
		AND o.origin_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");	
				$pdf->SetFont('Arial','BI',9);
		$pdf->Cell(280,5,'EXPORT',0,0,'L',0);
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
		
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r1[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}	
}	
		
}
else if($outin=='0')//INCOMING PROSES SUMMARY CARGO - PER JML SMU
{
	if($_POST[airline]=='SEMUA')
	{
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestin= m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND d.dest_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");

		$pdf->SetFont('Arial','BI',9);
		$pdf->Cell(280,5,'IMPORT',0,0,'L',0);
		$pdf->Ln();	 
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='01' group by MONTH(flightdate)"));
			$jan=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='02' group by MONTH(flightdate)"));
			$feb=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='03' group by MONTH(flightdate)"));
			$mar=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='04' group by MONTH(flightdate)"));
			$apr=$r[0];		
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='05' group by MONTH(flightdate)"));
			$may=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='06' group by MONTH(flightdate)"));
			$jun=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='07' group by MONTH(flightdate)"));
			$jul=$r[0];			
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='08' group by MONTH(flightdate)"));
			$aug=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='09' group by MONTH(flightdate)"));
			$sep=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='10' group by MONTH(flightdate)"));
			$oct=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='11' group by MONTH(flightdate)"));
			$nop=$r[0];		
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='12' group by MONTH(flightdate)"));
			$dec=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily"));
			$tot=$r[0];			
		
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,'ALL',1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}	
else
{
			mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestin= m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND cs.customer='$_POST[airline]' AND
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND d.dest_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");	
				$pdf->SetFont('Arial','BI',9);
		$pdf->Cell(280,5,'IMPORT',0,0,'L',0);
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
		
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r1[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}	
}	
		
}
else if($outin=='3')// TRANSIT PROSES SUMMARY CARGO -PER KOLI
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
		AND o.origin_code<>'MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");

		$pdf->SetFont('Arial','BI',9);
		$pdf->Cell(280,5,'TRANSIT',0,0,'L',0);
		$pdf->Ln();	 
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='01' group by MONTH(flightdate)"));
			$jan=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='02' group by MONTH(flightdate)"));
			$feb=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='03' group by MONTH(flightdate)"));
			$mar=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='04' group by MONTH(flightdate)"));
			$apr=$r[0];		
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='05' group by MONTH(flightdate)"));
			$may=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='06' group by MONTH(flightdate)"));
			$jun=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='07' group by MONTH(flightdate)"));
			$jul=$r[0];			
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='08' group by MONTH(flightdate)"));
			$aug=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='09' group by MONTH(flightdate)"));
			$sep=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='10' group by MONTH(flightdate)"));
			$oct=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='11' group by MONTH(flightdate)"));
			$nop=$r[0];		
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily 
			where MONTH(flightdate)='12' group by MONTH(flightdate)"));
			$dec=$r[0];
			$r=mysql_fetch_array(mysql_query("select count(noawb) from super_daily"));
			$tot=$r[0];			
		
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,'ALL',1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}	
else
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
		AND o.origin_code<>'MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");	
				$pdf->SetFont('Arial','BI',9);
		$pdf->Cell(280,5,'TRANSIT',0,0,'L',0);
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
		
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r1[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}	
}	
		
}	
}// END OF PER JML SMU


ELSE IF($_POST[filter]=='PER COMMODITY')
{
	
if($outin=='2')//SEMUA PROSES SUMMARY CARGO
{ 
	$jan1=0;
$feb1=0;
$mar1=0;
$apr1=0;
$may1=0;
$jun1=0;
$jul1=0;
$aug1=0;
$sep1=0;
$oct1=0;
$nop1=0;
$dec1=0;
$tot1=0;

$jan0=0;
$feb0=0;
$mar0=0;
$apr0=0;
$may0=0;
$jun0=0;
$jul0=0;
$aug0=0;
$sep0=0;
$oct0=0;
$nop0=0;
$dec0=0;
$tot0=0;
//export:
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
		AND o.origin_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
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
		AND o.origin_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");		
	}	

	
	$pdf->SetFont('Arial','BI',9);
	$pdf->Cell(280,5,'EXPORT',0,0,'L',0);
	$pdf->Ln();	 
  	$str_airline=mysql_query("select airline from super_daily group by airline");
  	while($r1=mysql_fetch_array($str_airline))  
  	{
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(280,5,$r1[0],0,0,'L',0);$pdf->Ln();$pdf->SetFont('Arial','',9);
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

			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r2[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
							$jan0+=$jan;
				$feb0+=$feb;
				$mar0+=$mar;
				$apr0+=$apr;
				$may0+=$may;
				$jun0+=$jun;
				$jul0+=$jul;
				$aug0+=$aug;
				$sep0+=$sep;
				$oct0+=$oct;
				$nop0+=$nop;
				$dec0+=$dec;	
				$tot0+=$tot;	
		}	

	}
	
							$jan1+=$jan0;
				$feb1+=$feb0;
				$mar1+=$mar0;
				$apr1+=$apr0;
				$may1+=$may0;
				$jun1+=$jun0;
				$jul1+=$jul0;
				$aug1+=$aug0;
				$sep1+=$sep0;
				$oct1+=$oct0;
				$nop1+=$nop0;
				$dec1+=$dec0;	
				$tot1+=$tot0;	
				
				$pdf->Ln(3);	 $pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,'Total',1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan0, 1, ',', '.'),1,0,'R',1);}
			if($feb0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb0, 1, ',', '.'),1,0,'R',1);}
			if($mar0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar0, 1, ',', '.'),1,0,'R',1);}
			if($apr0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr0, 1, ',', '.'),1,0,'R',1);}
			if($may0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may0, 1, ',', '.'),1,0,'R',1);}
			if($jun0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun0, 1, ',', '.'),1,0,'R',1);}
			if($jul0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul0, 1, ',', '.'),1,0,'R',1);}
			if($aug0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug0, 1, ',', '.'),1,0,'R',1);}
			if($sep0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep0, 1, ',', '.'),1,0,'R',1);}
			if($oct0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct0, 1, ',', '.'),1,0,'R',1);}
			if($nop0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop0, 1, ',', '.'),1,0,'R',1);}
			if($dec0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec0, 1, ',', '.'),1,0,'R',1);}
			if($tot0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot0, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
//end export
//import :
$jan0=0;
$feb0=0;
$mar0=0;
$apr0=0;
$may0=0;
$jun0=0;
$jul0=0;
$aug0=0;
$sep0=0;
$oct0=0;
$nop0=0;
$dec0=0;
$tot0=0;
	if($_POST[airline]=='SEMUA')
	{
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestin = m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND d.dest_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
	}
	else if($_POST[airline]<>'SEMUA')   
	{
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestin = m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND cs.customer='$_POST[airline]' AND
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND d.dest_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");		
	}	

	
	$pdf->SetFont('Arial','BI',9);
	$pdf->Cell(280,5,'IMPORT',0,0,'L',0);
	$pdf->Ln();	 
  	$str_airline=mysql_query("select airline from super_daily group by airline");
  	while($r1=mysql_fetch_array($str_airline))  
  	{
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(280,5,$r1[0],0,0,'L',0);$pdf->Ln();$pdf->SetFont('Arial','',9);
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

			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r2[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
							$jan0+=$jan;
				$feb0+=$feb;
				$mar0+=$mar;
				$apr0+=$apr;
				$may0+=$may;
				$jun0+=$jun;
				$jul0+=$jul;
				$aug0+=$aug;
				$sep0+=$sep;
				$oct0+=$oct;
				$nop0+=$nop;
				$dec0+=$dec;	
				$tot0+=$tot;	
		}	

	}
//end import 
						$jan1+=$jan0;
				$feb1+=$feb0;
				$mar1+=$mar0;
				$apr1+=$apr0;
				$may1+=$may0;
				$jun1+=$jun0;
				$jul1+=$jul0;
				$aug1+=$aug0;
				$sep1+=$sep0;
				$oct1+=$oct0;
				$nop1+=$nop0;
				$dec1+=$dec0;	
				$tot1+=$tot0;	
			$pdf->Ln(3);	 $pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,'Total',1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan0, 1, ',', '.'),1,0,'R',1);}
			if($feb0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb0, 1, ',', '.'),1,0,'R',1);}
			if($mar0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar0, 1, ',', '.'),1,0,'R',1);}
			if($apr0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr0, 1, ',', '.'),1,0,'R',1);}
			if($may0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may0, 1, ',', '.'),1,0,'R',1);}
			if($jun0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun0, 1, ',', '.'),1,0,'R',1);}
			if($jul0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul0, 1, ',', '.'),1,0,'R',1);}
			if($aug0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug0, 1, ',', '.'),1,0,'R',1);}
			if($sep0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep0, 1, ',', '.'),1,0,'R',1);}
			if($oct0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct0, 1, ',', '.'),1,0,'R',1);}
			if($nop0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop0, 1, ',', '.'),1,0,'R',1);}
			if($dec0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec0, 1, ',', '.'),1,0,'R',1);}
			if($tot0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot0, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
//trasnti :
$jan0=0;
$feb0=0;
$mar0=0;
$apr0=0;
$may0=0;
$jun0=0;
$jul0=0;
$aug0=0;
$sep0=0;
$oct0=0;
$nop0=0;
$dec0=0;
$tot0=0;
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
		AND o.origin_code<>'MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
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
		AND o.origin_code<>'MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");		
	}	

	
	$pdf->SetFont('Arial','BI',9);
	$pdf->Cell(280,8,'TRANSIT',0,0,'L',0);
	$pdf->Ln();	 
  	$str_airline=mysql_query("select airline from super_daily group by airline");
  	while($r1=mysql_fetch_array($str_airline))  
  	{
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(280,5,$r1[0],0,0,'L',0);$pdf->Ln();$pdf->SetFont('Arial','',9);
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

			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r2[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
							$jan0+=$jan;
				$feb0+=$feb;
				$mar0+=$mar;
				$apr0+=$apr;
				$may0+=$may;
				$jun0+=$jun;
				$jul0+=$jul;
				$aug0+=$aug;
				$sep0+=$sep;
				$oct0+=$oct;
				$nop0+=$nop;
				$dec0+=$dec;	
				$tot0+=$tot;	
		}	

	}
//end trasnit
						$jan1+=$jan0;
				$feb1+=$feb0;
				$mar1+=$mar0;
				$apr1+=$apr0;
				$may1+=$may0;
				$jun1+=$jun0;
				$jul1+=$jul0;
				$aug1+=$aug0;
				$sep1+=$sep0;
				$oct1+=$oct0;
				$nop1+=$nop0;
				$dec1+=$dec0;	
				$tot1+=$tot0;	
			$pdf->Ln(3);	 $pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,'Total',1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan0, 1, ',', '.'),1,0,'R',1);}
			if($feb0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb0, 1, ',', '.'),1,0,'R',1);}
			if($mar0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar0, 1, ',', '.'),1,0,'R',1);}
			if($apr0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr0, 1, ',', '.'),1,0,'R',1);}
			if($may0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may0, 1, ',', '.'),1,0,'R',1);}
			if($jun0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun0, 1, ',', '.'),1,0,'R',1);}
			if($jul0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul0, 1, ',', '.'),1,0,'R',1);}
			if($aug0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug0, 1, ',', '.'),1,0,'R',1);}
			if($sep0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep0, 1, ',', '.'),1,0,'R',1);}
			if($oct0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct0, 1, ',', '.'),1,0,'R',1);}
			if($nop0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop0, 1, ',', '.'),1,0,'R',1);}
			if($dec0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec0, 1, ',', '.'),1,0,'R',1);}
			if($tot0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot0, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
			
			
						//grandtotal
					
			$pdf->Ln(3);	 $pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,'Grand Total',1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan1, 1, ',', '.'),1,0,'R',1);}
			if($feb1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb1, 1, ',', '.'),1,0,'R',1);}
			if($mar1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar1, 1, ',', '.'),1,0,'R',1);}
			if($apr1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr1, 1, ',', '.'),1,0,'R',1);}
			if($may1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may1, 1, ',', '.'),1,0,'R',1);}
			if($jun1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun1, 1, ',', '.'),1,0,'R',1);}
			if($jul1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul1, 1, ',', '.'),1,0,'R',1);}
			if($aug1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug1, 1, ',', '.'),1,0,'R',1);}
			if($sep1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep1, 1, ',', '.'),1,0,'R',1);}
			if($oct1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct1, 1, ',', '.'),1,0,'R',1);}
			if($nop1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop1, 1, ',', '.'),1,0,'R',1);}
			if($dec1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec1, 1, ',', '.'),1,0,'R',1);}
			if($tot0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot1, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 	
}
else if($outin=='0')//INCOMING PROSES SUMMARY CARGO
{ 
	if($_POST[airline]=='SEMUA')
	{
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestin = m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND d.dest_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
	
	$pdf->SetFont('Arial','BI',9);
	$pdf->Cell(280,5,'IMPORT',0,0,'L',0);
	$pdf->Ln();	 
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(280,5,'ALL',0,0,'L',0);$pdf->Ln();$pdf->SetFont('Arial','',9);
		$str_data=mysql_query("select commodity from super_daily where flightdate
		BETWEEN '$tglawal' AND '$tglakhir' group by commodity");
		while($r2=mysql_fetch_array($str_data))  
		{
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='01' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$jan=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='02' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$feb=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='03' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$mar=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='04' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$apr=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='05' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$may=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='06' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$jun=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='07' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$jul=$r[0];			
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='08' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$aug=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='09' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$sep=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='10' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$oct=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='11' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$nop=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='12' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$dec=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			WHERE airline='$r1[0]' AND commodity='$r2[0]' "));
			$tot=$r[0];			

			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r2[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}	
	}
else
{
			mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestin = m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND
		s.idcommodityap=cp.idcommodityap AND cs.customer='$_POST[airline]' AND
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND d.dest_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");	
		$pdf->SetFont('Arial','BI',9);
	$pdf->Cell(280,5,'IMPORT',0,0,'L',0);
	$pdf->Ln();	 
  	$str_airline=mysql_query("select airline from super_daily group by airline");
  	while($r1=mysql_fetch_array($str_airline))  
  	{
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(280,5,$r1[0],0,0,'L',0);$pdf->Ln();$pdf->SetFont('Arial','',9);
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

			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r2[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}		
}	
}
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
		AND o.origin_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
	$pdf->SetFont('Arial','BI',9);
	$pdf->Cell(280,5,'EXPORT',0,0,'L',0);
	$pdf->Ln();	 
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(280,5,'ALL',0,0,'L',0);$pdf->Ln();$pdf->SetFont('Arial','',9);
		$str_data=mysql_query("select commodity from super_daily where flightdate
		BETWEEN '$tglawal' AND '$tglakhir' group by commodity");
		while($r2=mysql_fetch_array($str_data))  
		{
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='01' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$jan=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='02' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$feb=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='03' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$mar=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='04' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$apr=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='05' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$may=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='06' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$jun=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='07' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$jul=$r[0];			
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='08' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$aug=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='09' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$sep=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='10' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$oct=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='11' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$nop=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='12' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$dec=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			WHERE airline='$r1[0]' AND commodity='$r2[0]' "));
			$tot=$r[0];			

			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r2[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}	
	}
else
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
		AND o.origin_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
		$pdf->SetFont('Arial','BI',9);
	$pdf->Cell(280,5,'EXPORT',0,0,'L',0);
	$pdf->Ln();	 
  	$str_airline=mysql_query("select airline from super_daily group by airline");
  	while($r1=mysql_fetch_array($str_airline))  
  	{
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(280,5,$r1[0],0,0,'L',0);$pdf->Ln();$pdf->SetFont('Arial','',9);
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

			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r2[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}		
}	
}
}

else if($outin=='3')//transit PROSES SUMMARY CARGO
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
		AND o.origin_code<>'MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
	$pdf->SetFont('Arial','BI',9);
	$pdf->Cell(280,5,'TRANSIT',0,0,'L',0);
	$pdf->Ln();	 
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(280,5,'ALL',0,0,'L',0);$pdf->Ln();$pdf->SetFont('Arial','',9);
		$str_data=mysql_query("select commodity from super_daily where flightdate
		BETWEEN '$tglawal' AND '$tglakhir' group by commodity");
		while($r2=mysql_fetch_array($str_data))  
		{
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='01' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$jan=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='02' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$feb=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='03' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$mar=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='04' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$apr=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='05' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$may=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='06' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$jun=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='07' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$jul=$r[0];			
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='08' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$aug=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='09' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$sep=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='10' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$oct=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='11' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$nop=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			where MONTH(flightdate)='12' AND commodity='$r2[0]' group by MONTH(flightdate)"));
			$dec=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_daily 
			WHERE airline='$r1[0]' AND commodity='$r2[0]' "));
			$tot=$r[0];			

			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r2[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}	
	}
else
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
		AND o.origin_code<>'MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");	
		$pdf->SetFont('Arial','BI',9);
	$pdf->Cell(280,5,'TRANSIT',0,0,'L',0);
	$pdf->Ln();	 
  	$str_airline=mysql_query("select airline from super_daily group by airline");
  	while($r1=mysql_fetch_array($str_airline))  
  	{
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(280,5,$r1[0],0,0,'L',0);$pdf->Ln();$pdf->SetFont('Arial','',9);
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

			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r2[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}		
}	
}
}



} //END OF PER COMMODITY
// PER REGION
//***************************************
ELSE IF($_POST[filter]=='PER REGION')
{
	
if($outin=='2')//SEMUA PROSES SUMMARY CARGO
{ 
$jan1=0;
$feb1=0;
$mar1=0;
$apr1=0;
$may1=0;
$jun1=0;
$jul1=0;
$aug1=0;
$sep1=0;
$oct1=0;
$nop1=0;
$dec1=0;
$tot1=0;

$jan0=0;
$feb0=0;
$mar0=0;
$apr0=0;
$may0=0;
$jun0=0;
$jul0=0;
$aug0=0;
$sep0=0;
$oct0=0;
$nop0=0;
$dec0=0;
$tot0=0;
//export:
	if($_POST[airline]=='SEMUA')
	{
		mysql_query("delete from super_dailyregion"); 
		mysql_query ("insert into super_dailyregion 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer,cp.commodityap,r.region 
		FROM isimanifestout as i,manifestout as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs,region as r WHERE 
		i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND m.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND o.origin_code='MES' AND f.idcustomer=cs.idcustomer AND d.idregion =r.idregion AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
	}
	else if($_POST[airline]<>'SEMUA')   
	{
		mysql_query("delete from super_dailyregion"); 
		mysql_query ("insert into super_dailyregion 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer,cp.commodityap,r.region 
		FROM isimanifestout as i,manifestout as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs,region as r WHERE 
		i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND m.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND o.origin_code='MES' AND f.idcustomer=cs.idcustomer AND d.idregion =r.idregion 
		AND  cs.customer='$_POST[airline]' AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");		
	}	

	
	$pdf->SetFont('Arial','BI',9);
	$pdf->Cell(280,5,'EXPORT',0,0,'L',0);
	$pdf->Ln();	 
  	$str_airline=mysql_query("select region from super_dailyregion group by region");
  	while($r1=mysql_fetch_array($str_airline))  
  	{
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(280,5,$r1[0],0,0,'L',0);$pdf->Ln();$pdf->SetFont('Arial','',9);
		$str_data=mysql_query("select jenisbarang from super_dailyregion where flightdate
		BETWEEN '$tglawal' AND '$tglakhir' AND region='$r1[0]' group by jenisbarang");
		while($r2=mysql_fetch_array($str_data))  
		{
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='01' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$jan=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='02' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$feb=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='03' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$mar=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='04' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$apr=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='05' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$may=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='06' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$jun=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='07' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$jul=$r[0];			
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='08' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$aug=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='09' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$sep=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='10' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$oct=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='11' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$nop=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='12' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$dec=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			WHERE region='$r1[0]' AND jenisbarang='$r2[0]' "));
			$tot=$r[0];			

			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r2[0],1,0,'L',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
							$jan0+=$jan;
				$feb0+=$feb;
				$mar0+=$mar;
				$apr0+=$apr;
				$may0+=$may;
				$jun0+=$jun;
				$jul0+=$jul;
				$aug0+=$aug;
				$sep0+=$sep;
				$oct0+=$oct;
				$nop0+=$nop;
				$dec0+=$dec;	
				$tot0+=$tot;	
		}	

	}
	
							$jan1+=$jan0;
				$feb1+=$feb0;
				$mar1+=$mar0;
				$apr1+=$apr0;
				$may1+=$may0;
				$jun1+=$jun0;
				$jul1+=$jul0;
				$aug1+=$aug0;
				$sep1+=$sep0;
				$oct1+=$oct0;
				$nop1+=$nop0;
				$dec1+=$dec0;	
				$tot1+=$tot0;	
				
				$pdf->Ln(3);	 $pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,'Total',1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan0, 1, ',', '.'),1,0,'R',1);}
			if($feb0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb0, 1, ',', '.'),1,0,'R',1);}
			if($mar0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar0, 1, ',', '.'),1,0,'R',1);}
			if($apr0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr0, 1, ',', '.'),1,0,'R',1);}
			if($may0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may0, 1, ',', '.'),1,0,'R',1);}
			if($jun0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun0, 1, ',', '.'),1,0,'R',1);}
			if($jul0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul0, 1, ',', '.'),1,0,'R',1);}
			if($aug0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug0, 1, ',', '.'),1,0,'R',1);}
			if($sep0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep0, 1, ',', '.'),1,0,'R',1);}
			if($oct0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct0, 1, ',', '.'),1,0,'R',1);}
			if($nop0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop0, 1, ',', '.'),1,0,'R',1);}
			if($dec0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec0, 1, ',', '.'),1,0,'R',1);}
			if($tot0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot0, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
//end export
//import :
$jan0=0;
$feb0=0;
$mar0=0;
$apr0=0;
$may0=0;
$jun0=0;
$jul0=0;
$aug0=0;
$sep0=0;
$oct0=0;
$nop0=0;
$dec0=0;
$tot0=0;
	if($_POST[airline]=='SEMUA')
	{
		mysql_query("delete from super_dailyregion"); 
		mysql_query ("insert into super_dailyregion 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer,cp.commodityap,r.region 
		FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs,region as r WHERE 
		i.idmanifestin = m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND d.dest_code='MES' AND f.idcustomer=cs.idcustomer AND 
		d.idregion=r.idregion AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
	}
	else if($_POST[airline]<>'SEMUA')   
	{
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer,cp.commodityap,r.region 
		FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestin = m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND cs.customer='$_POST[airline]' AND
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		d.idregion=r.idregion AND d.dest_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");		
	}	

	
	$pdf->SetFont('Arial','BI',9);
	$pdf->Cell(280,5,'IMPORT',0,0,'L',0);
	$pdf->Ln();	 
  	$str_airline=mysql_query("select region from super_dailyregion group by region");
  	while($r1=mysql_fetch_array($str_airline))  
  	{
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(280,5,$r1[0],0,0,'L',0);$pdf->Ln();$pdf->SetFont('Arial','',9);
		$str_data=mysql_query("select jenisbarang from super_dailyregion where flightdate
		BETWEEN '$tglawal' AND '$tglakhir' AND region='$r1[0]' group by jenisbarang");
		while($r2=mysql_fetch_array($str_data))  
		{
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='01' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$jan=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='02' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$feb=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='03' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$mar=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='04' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$apr=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='05' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$may=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='06' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$jun=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='07' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$jul=$r[0];			
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='08' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$aug=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='09' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$sep=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='10' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$oct=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='11' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$nop=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='12' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$dec=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			WHERE region='$r1[0]' AND jenisbarang='$r2[0]' "));
			$tot=$r[0];			

			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r2[0],1,0,'L',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
							$jan0+=$jan;
				$feb0+=$feb;
				$mar0+=$mar;
				$apr0+=$apr;
				$may0+=$may;
				$jun0+=$jun;
				$jul0+=$jul;
				$aug0+=$aug;
				$sep0+=$sep;
				$oct0+=$oct;
				$nop0+=$nop;
				$dec0+=$dec;	
				$tot0+=$tot;	
		}	

	}
//end import 
						$jan1+=$jan0;
				$feb1+=$feb0;
				$mar1+=$mar0;
				$apr1+=$apr0;
				$may1+=$may0;
				$jun1+=$jun0;
				$jul1+=$jul0;
				$aug1+=$aug0;
				$sep1+=$sep0;
				$oct1+=$oct0;
				$nop1+=$nop0;
				$dec1+=$dec0;	
				$tot1+=$tot0;	
			$pdf->Ln(3);	 $pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,'Total',1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan0, 1, ',', '.'),1,0,'R',1);}
			if($feb0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb0, 1, ',', '.'),1,0,'R',1);}
			if($mar0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar0, 1, ',', '.'),1,0,'R',1);}
			if($apr0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr0, 1, ',', '.'),1,0,'R',1);}
			if($may0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may0, 1, ',', '.'),1,0,'R',1);}
			if($jun0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun0, 1, ',', '.'),1,0,'R',1);}
			if($jul0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul0, 1, ',', '.'),1,0,'R',1);}
			if($aug0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug0, 1, ',', '.'),1,0,'R',1);}
			if($sep0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep0, 1, ',', '.'),1,0,'R',1);}
			if($oct0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct0, 1, ',', '.'),1,0,'R',1);}
			if($nop0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop0, 1, ',', '.'),1,0,'R',1);}
			if($dec0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec0, 1, ',', '.'),1,0,'R',1);}
			if($tot0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot0, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
//trasnti :
$jan0=0;
$feb0=0;
$mar0=0;
$apr0=0;
$may0=0;
$jun0=0;
$jul0=0;
$aug0=0;
$sep0=0;
$oct0=0;
$nop0=0;
$dec0=0;
$tot0=0;
	if($_POST[airline]=='SEMUA')
	{
		mysql_query("delete from super_dailyregion"); 
		mysql_query ("insert into super_dailyregion 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer,cp.commodityap,r.region 
		FROM isimanifestout as i,manifestout as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs,region as r WHERE 
		i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND m.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND o.origin_code<>'MES' AND f.idcustomer=cs.idcustomer AND 
		d.idregion=r.idregion AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
	}
	else if($_POST[airline]<>'SEMUA')   
	{
		mysql_query("delete from super_dailyregion"); 
		mysql_query ("insert into super_dailyregion 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer,cp.commodityap,r.region 
		FROM isimanifestout as i,manifestout as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND m.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND cs.customer='$_POST[airline]' AND
		d.idregion=r.idregion AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND o.origin_code<>'MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");		
	}	

	
	$pdf->SetFont('Arial','BI',9);
	$pdf->Cell(280,8,'TRANSIT',0,0,'L',0);
	$pdf->Ln();	 
  	$str_airline=mysql_query("select region from super_dailyregion group by region");
  	while($r1=mysql_fetch_array($str_airline))  
  	{
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(280,5,$r1[0],0,0,'L',0);$pdf->Ln();$pdf->SetFont('Arial','',9);
		$str_data=mysql_query("select jenisbarang from super_dailyregion where flightdate
		BETWEEN '$tglawal' AND '$tglakhir' AND region='$r1[0]' group by jenisbarang");
		while($r2=mysql_fetch_array($str_data))  
		{
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='01' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$jan=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='02' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$feb=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='03' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$mar=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='04' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$apr=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='05' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$may=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='06' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$jun=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='07' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$jul=$r[0];			
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='08' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$aug=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='09' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$sep=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='10' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$oct=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='11' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$nop=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='12' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$dec=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			WHERE region='$r1[0]' AND jenisbarang='$r2[0]' "));
			$tot=$r[0];			

			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r2[0],1,0,'L',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
							$jan0+=$jan;
				$feb0+=$feb;
				$mar0+=$mar;
				$apr0+=$apr;
				$may0+=$may;
				$jun0+=$jun;
				$jul0+=$jul;
				$aug0+=$aug;
				$sep0+=$sep;
				$oct0+=$oct;
				$nop0+=$nop;
				$dec0+=$dec;	
				$tot0+=$tot;	
		}	

	}
//end trasnit
						$jan1+=$jan0;
				$feb1+=$feb0;
				$mar1+=$mar0;
				$apr1+=$apr0;
				$may1+=$may0;
				$jun1+=$jun0;
				$jul1+=$jul0;
				$aug1+=$aug0;
				$sep1+=$sep0;
				$oct1+=$oct0;
				$nop1+=$nop0;
				$dec1+=$dec0;	
				$tot1+=$tot0;	
			$pdf->Ln(3);	 $pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,'Total',1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan0, 1, ',', '.'),1,0,'R',1);}
			if($feb0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb0, 1, ',', '.'),1,0,'R',1);}
			if($mar0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar0, 1, ',', '.'),1,0,'R',1);}
			if($apr0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr0, 1, ',', '.'),1,0,'R',1);}
			if($may0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may0, 1, ',', '.'),1,0,'R',1);}
			if($jun0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun0, 1, ',', '.'),1,0,'R',1);}
			if($jul0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul0, 1, ',', '.'),1,0,'R',1);}
			if($aug0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug0, 1, ',', '.'),1,0,'R',1);}
			if($sep0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep0, 1, ',', '.'),1,0,'R',1);}
			if($oct0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct0, 1, ',', '.'),1,0,'R',1);}
			if($nop0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop0, 1, ',', '.'),1,0,'R',1);}
			if($dec0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec0, 1, ',', '.'),1,0,'R',1);}
			if($tot0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot0, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
			
			
						//grandtotal
					
			$pdf->Ln(3);	 $pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,'Grand Total',1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan1, 1, ',', '.'),1,0,'R',1);}
			if($feb1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb1, 1, ',', '.'),1,0,'R',1);}
			if($mar1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar1, 1, ',', '.'),1,0,'R',1);}
			if($apr1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr1, 1, ',', '.'),1,0,'R',1);}
			if($may1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may1, 1, ',', '.'),1,0,'R',1);}
			if($jun1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun1, 1, ',', '.'),1,0,'R',1);}
			if($jul1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul1, 1, ',', '.'),1,0,'R',1);}
			if($aug1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug1, 1, ',', '.'),1,0,'R',1);}
			if($sep1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep1, 1, ',', '.'),1,0,'R',1);}
			if($oct1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct1, 1, ',', '.'),1,0,'R',1);}
			if($nop1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop1, 1, ',', '.'),1,0,'R',1);}
			if($dec1=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec1, 1, ',', '.'),1,0,'R',1);}
			if($tot0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot1, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 	
}
else if($outin=='0')//IIMPORT PER REGION
{ 
$jan0=0;
$feb0=0;
$mar0=0;
$apr0=0;
$may0=0;
$jun0=0;
$jul0=0;
$aug0=0;
$sep0=0;
$oct0=0;
$nop0=0;
$dec0=0;
$tot0=0;
	if($_POST[airline]=='SEMUA')
	{
		mysql_query("delete from super_dailyregion"); 
		mysql_query ("insert into super_dailyregion 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer,cp.commodityap,r.region 
		FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs,region as r WHERE 
		i.idmanifestin = m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND d.dest_code='MES' AND f.idcustomer=cs.idcustomer AND 
		d.idregion=r.idregion AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
	}
	else if($_POST[airline]<>'SEMUA')   
	{
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer,cp.commodityap,r.region 
		FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestin = m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND cs.customer='$_POST[airline]' AND
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		d.idregion=r.idregion AND d.dest_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");		
	}	

	
	$pdf->SetFont('Arial','BI',9);
	$pdf->Cell(280,5,'IMPORT',0,0,'L',0);
	$pdf->Ln();	 
  	$str_airline=mysql_query("select region from super_dailyregion group by region");
  	while($r1=mysql_fetch_array($str_airline))  
  	{
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(280,5,$r1[0],0,0,'L',0);$pdf->Ln();$pdf->SetFont('Arial','',9);
		$str_data=mysql_query("select jenisbarang from super_dailyregion where flightdate
		BETWEEN '$tglawal' AND '$tglakhir' AND region='$r1[0]' group by jenisbarang");
		while($r2=mysql_fetch_array($str_data))  
		{
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='01' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$jan=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='02' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$feb=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='03' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$mar=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='04' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$apr=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='05' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$may=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='06' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$jun=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='07' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$jul=$r[0];			
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='08' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$aug=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='09' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$sep=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='10' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$oct=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='11' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$nop=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='12' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$dec=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			WHERE region='$r1[0]' AND jenisbarang='$r2[0]' "));
			$tot=$r[0];			

			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r2[0],1,0,'L',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
							$jan0+=$jan;
				$feb0+=$feb;
				$mar0+=$mar;
				$apr0+=$apr;
				$may0+=$may;
				$jun0+=$jun;
				$jul0+=$jul;
				$aug0+=$aug;
				$sep0+=$sep;
				$oct0+=$oct;
				$nop0+=$nop;
				$dec0+=$dec;	
				$tot0+=$tot;	
		}	

	}
						//grandtotal
					
			$pdf->Ln(3);	 $pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,'Grand Total',1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan0, 1, ',', '.'),1,0,'R',1);}
			if($feb0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb0, 1, ',', '.'),1,0,'R',1);}
			if($mar0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar0, 1, ',', '.'),1,0,'R',1);}
			if($apr0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr0, 1, ',', '.'),1,0,'R',1);}
			if($may0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may0, 1, ',', '.'),1,0,'R',1);}
			if($jun0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun0, 1, ',', '.'),1,0,'R',1);}
			if($jul0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul0, 1, ',', '.'),1,0,'R',1);}
			if($aug0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug0, 1, ',', '.'),1,0,'R',1);}
			if($sep0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep0, 1, ',', '.'),1,0,'R',1);}
			if($oct0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct0, 1, ',', '.'),1,0,'R',1);}
			if($nop0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop0, 1, ',', '.'),1,0,'R',1);}
			if($dec0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec0, 1, ',', '.'),1,0,'R',1);}
			if($tot0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot0, 1, ',', '.'),1,0,'R',1);}		
	
}
else if($outin=='1')//OUTGOIN PROSES SUMMARY CARGO
{
$jan0=0;
$feb0=0;
$mar0=0;
$apr0=0;
$may0=0;
$jun0=0;
$jul0=0;
$aug0=0;
$sep0=0;
$oct0=0;
$nop0=0;
$dec0=0;
$tot0=0;
//export:
	if($_POST[airline]=='SEMUA')
	{
		mysql_query("delete from super_dailyregion"); 
		mysql_query ("insert into super_dailyregion 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer,cp.commodityap,r.region 
		FROM isimanifestout as i,manifestout as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs,region as r WHERE 
		i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND m.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND o.origin_code='MES' AND f.idcustomer=cs.idcustomer AND d.idregion =r.idregion AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
	}
	else if($_POST[airline]<>'SEMUA')   
	{
		mysql_query("delete from super_dailyregion"); 
		mysql_query ("insert into super_dailyregion 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer,cp.commodityap,r.region 
		FROM isimanifestout as i,manifestout as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs,region as r WHERE 
		i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND m.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND o.origin_code='MES' AND f.idcustomer=cs.idcustomer AND d.idregion =r.idregion 
		AND  cs.customer='$_POST[airline]' AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");		
	}	

	
	$pdf->SetFont('Arial','BI',9);
	$pdf->Cell(280,5,'EXPORT',0,0,'L',0);
	$pdf->Ln();	 
  	$str_airline=mysql_query("select region from super_dailyregion group by region");
  	while($r1=mysql_fetch_array($str_airline))  
  	{
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(280,5,$r1[0],0,0,'L',0);$pdf->Ln();$pdf->SetFont('Arial','',9);
		$str_data=mysql_query("select jenisbarang from super_dailyregion where flightdate
		BETWEEN '$tglawal' AND '$tglakhir' AND region='$r1[0]' group by jenisbarang");
		while($r2=mysql_fetch_array($str_data))  
		{
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='01' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$jan=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='02' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$feb=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='03' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$mar=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='04' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$apr=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='05' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$may=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='06' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$jun=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='07' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$jul=$r[0];			
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='08' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$aug=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='09' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$sep=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='10' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$oct=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='11' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$nop=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='12' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$dec=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			WHERE region='$r1[0]' AND jenisbarang='$r2[0]' "));
			$tot=$r[0];			

			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r2[0],1,0,'L',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
							$jan0+=$jan;
				$feb0+=$feb;
				$mar0+=$mar;
				$apr0+=$apr;
				$may0+=$may;
				$jun0+=$jun;
				$jul0+=$jul;
				$aug0+=$aug;
				$sep0+=$sep;
				$oct0+=$oct;
				$nop0+=$nop;
				$dec0+=$dec;	
				$tot0+=$tot;	
		}	
		}
		$pdf->Ln(3);	 $pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,'Grand Total',1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan0, 1, ',', '.'),1,0,'R',1);}
			if($feb0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb0, 1, ',', '.'),1,0,'R',1);}
			if($mar0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar0, 1, ',', '.'),1,0,'R',1);}
			if($apr0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr0, 1, ',', '.'),1,0,'R',1);}
			if($may0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may0, 1, ',', '.'),1,0,'R',1);}
			if($jun0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun0, 1, ',', '.'),1,0,'R',1);}
			if($jul0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul0, 1, ',', '.'),1,0,'R',1);}
			if($aug0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug0, 1, ',', '.'),1,0,'R',1);}
			if($sep0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep0, 1, ',', '.'),1,0,'R',1);}
			if($oct0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct0, 1, ',', '.'),1,0,'R',1);}
			if($nop0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop0, 1, ',', '.'),1,0,'R',1);}
			if($dec0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec0, 1, ',', '.'),1,0,'R',1);}
			if($tot0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot0, 1, ',', '.'),1,0,'R',1);}			
}

else if($outin=='3')//transit PROSES SUMMARY CARGO
{
	$jan0=0;
$feb0=0;
$mar0=0;
$apr0=0;
$may0=0;
$jun0=0;
$jul0=0;
$aug0=0;
$sep0=0;
$oct0=0;
$nop0=0;
$dec0=0;
$tot0=0;
	if($_POST[airline]=='SEMUA')
	{
		mysql_query("delete from super_dailyregion"); 
		mysql_query ("insert into super_dailyregion 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer,cp.commodityap,r.region 
		FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs,region as r WHERE 
		i.idmanifestin = m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND d.dest_code<>'MES' AND f.idcustomer=cs.idcustomer AND 
		d.idregion=r.idregion AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
	}
	else if($_POST[airline]<>'SEMUA')   
	{
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer,cp.commodityap,r.region 
		FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestin = m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND cs.customer='$_POST[airline]' AND
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		d.idregion=r.idregion AND d.dest_code<>'MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");		
	}	

	
	$pdf->SetFont('Arial','BI',9);
	$pdf->Cell(280,5,'TRANSIT',0,0,'L',0);
	$pdf->Ln();	 
  	$str_airline=mysql_query("select region from super_dailyregion group by region");
  	while($r1=mysql_fetch_array($str_airline))  
  	{
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(280,5,$r1[0],0,0,'L',0);$pdf->Ln();$pdf->SetFont('Arial','',9);
		$str_data=mysql_query("select jenisbarang from super_dailyregion where flightdate
		BETWEEN '$tglawal' AND '$tglakhir' AND region='$r1[0]' group by jenisbarang");
		while($r2=mysql_fetch_array($str_data))  
		{
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='01' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$jan=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='02' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$feb=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='03' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$mar=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='04' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$apr=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='05' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$may=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='06' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$jun=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='07' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$jul=$r[0];			
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='08' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$aug=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='09' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$sep=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='10' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$oct=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='11' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$nop=$r[0];		
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			where MONTH(flightdate)='12' AND region='$r1[0]'  AND jenisbarang='$r2[0]' group by MONTH(flightdate)"));
			$dec=$r[0];
			$r=mysql_fetch_array(mysql_query("select sum(berat) from super_dailyregion 
			WHERE region='$r1[0]' AND jenisbarang='$r2[0]' "));
			$tot=$r[0];			

			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r2[0],1,0,'L',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
							$jan0+=$jan;
				$feb0+=$feb;
				$mar0+=$mar;
				$apr0+=$apr;
				$may0+=$may;
				$jun0+=$jun;
				$jul0+=$jul;
				$aug0+=$aug;
				$sep0+=$sep;
				$oct0+=$oct;
				$nop0+=$nop;
				$dec0+=$dec;	
				$tot0+=$tot;	
		}	

	}
						//grandtotal
					
			$pdf->Ln(3);	 $pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,'Grand Total',1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan0, 1, ',', '.'),1,0,'R',1);}
			if($feb0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb0, 1, ',', '.'),1,0,'R',1);}
			if($mar0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar0, 1, ',', '.'),1,0,'R',1);}
			if($apr0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr0, 1, ',', '.'),1,0,'R',1);}
			if($may0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may0, 1, ',', '.'),1,0,'R',1);}
			if($jun0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun0, 1, ',', '.'),1,0,'R',1);}
			if($jul0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul0, 1, ',', '.'),1,0,'R',1);}
			if($aug0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug0, 1, ',', '.'),1,0,'R',1);}
			if($sep0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep0, 1, ',', '.'),1,0,'R',1);}
			if($oct0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct0, 1, ',', '.'),1,0,'R',1);}
			if($nop0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop0, 1, ',', '.'),1,0,'R',1);}
			if($dec0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec0, 1, ',', '.'),1,0,'R',1);}
			if($tot0=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot0, 1, ',', '.'),1,0,'R',1);}		

	
}//end of transit



} //END OF PER REGION



//***************************************


ELSE IF($_POST[filter]=='PER AIRPORT')
{
if($outin=='2')//SEMUA PROSES SUMMARY CARGO - PER AIRPORT
{ 
//export:
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
		AND o.origin_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
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
		AND o.origin_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");		
	}	

	$pdf->SetFont('Arial','BI',9);
	$pdf->Cell(280,5,'EXPORT',0,0,'L',0);
	$pdf->Ln();	 
  	$str_airline=mysql_query("select airline from super_daily group by airline");
  	while($r1=mysql_fetch_array($str_airline))  
  	{
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(280,5,$r1[0],0,0,'L',0);$pdf->Ln(5);
		$str_airport=mysql_query("select destination from super_daily 
		where flightdate BETWEEN '$tglawal' AND '$tglakhir' AND airline='$r1[0]' group by destination");
		
		while($ra=mysql_fetch_array($str_airport))  
		{
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(20,5,$ra[0],0,0,'C',0);$pdf->Ln(5);

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
			
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r2[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}	
		}
	}
//end export
//import:
		if($_POST[airline]=='SEMUA')
	{
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestin = m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND i.statuskeluar<>'' AND 
		s.idcommodityap=cp.idcommodityap AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND d.dest_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
	}
	else if($_POST[airline]<>'SEMUA')   
	{
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestin = m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND i.statuskeluar<>'' AND 
		s.idcommodityap=cp.idcommodityap AND cs.customer='$_POST[airline]' AND
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND d.dest_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");		
	}	

	$pdf->SetFont('Arial','BI',9);
	$pdf->Cell(280,5,'IMPORT',0,0,'L',0);
	$pdf->Ln();	 
  	$str_airline=mysql_query("select airline from super_daily group by airline");
  	while($r1=mysql_fetch_array($str_airline))  
  	{
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(280,5,$r1[0],0,0,'L',0);$pdf->Ln(5);
		$str_airport=mysql_query("select destination from super_daily 
		where flightdate BETWEEN '$tglawal' AND '$tglakhir' AND airline='$r1[0]' group by destination");
		
		while($ra=mysql_fetch_array($str_airport))  
		{
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(20,5,$ra[0],0,0,'C',0);$pdf->Ln(5);

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
			
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r2[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}	
		}
	}
//end import
//trasnit:
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
		AND o.origin_code<>'MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
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
		AND o.origin_code<>'MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");		
	}	

	$pdf->SetFont('Arial','BI',9);
	$pdf->Cell(280,8,'TRANSIT',0,0,'L',0);
	$pdf->Ln();	 
  	$str_airline=mysql_query("select airline from super_daily group by airline");
  	while($r1=mysql_fetch_array($str_airline))  
  	{
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(280,5,$r1[0],0,0,'L',0);$pdf->Ln(5);
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
			
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r2[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}	
		}
	}
//end transit
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
		AND o.origin_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
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
		AND o.origin_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");		
	}	

	$pdf->SetFont('Arial','BI',9);
	$pdf->Cell(280,5,'EXPORT',0,0,'L',0);
	$pdf->Ln();	 
  	$str_airline=mysql_query("select airline from super_daily group by airline");
  	while($r1=mysql_fetch_array($str_airline))  
  	{
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(280,5,$r1[0],0,0,'L',0);$pdf->Ln(5);
		$str_airport=mysql_query("select destination from super_daily 
		where flightdate BETWEEN '$tglawal' AND '$tglakhir' AND airline='$r1[0]' group by destination");
		
		while($ra=mysql_fetch_array($str_airport))  
		{
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(20,5,$ra[0],0,0,'C',0);$pdf->Ln(5);

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
			
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r2[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}	
		}
	}
} // end of export - PER AIRPORT
else if($outin=='0')//IMPORT PROSES SUMMARY CARGO - PER AIRPORT
{
		if($_POST[airline]=='SEMUA')
	{
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestin = m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND i.statuskeluar<>'' AND 
		s.idcommodityap=cp.idcommodityap AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND d.dest_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
	}
	else if($_POST[airline]<>'SEMUA')   
	{
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestin = m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND i.statuskeluar<>'' AND 
		s.idcommodityap=cp.idcommodityap AND cs.customer='$_POST[airline]' AND
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND d.dest_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");		
	}	

	$pdf->SetFont('Arial','BI',9);
	$pdf->Cell(280,5,'IMPORT',0,0,'L',0);
	$pdf->Ln();	 
  	$str_airline=mysql_query("select airline from super_daily group by airline");
  	while($r1=mysql_fetch_array($str_airline))  
  	{
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(280,5,$r1[0],0,0,'L',0);$pdf->Ln(5);
		$str_airport=mysql_query("select destination from super_daily 
		where flightdate BETWEEN '$tglawal' AND '$tglakhir' AND airline='$r1[0]' group by destination");
		
		while($ra=mysql_fetch_array($str_airport))  
		{
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(20,5,$ra[0],0,0,'C',0);$pdf->Ln(5);

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
			
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r2[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}	
		}
	}
} // END OF IMPORT PER AIRPORT
else if($outin=='3')//TRANSIT PROSES SUMMARY CARGO - PER AIRPORT
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
		AND o.origin_code<>'MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
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
		AND o.origin_code<>'MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");		
	}	

	$pdf->SetFont('Arial','BI',9);
	$pdf->Cell(280,8,'TRANSIT',0,0,'L',0);
	$pdf->Ln();	 
  	$str_airline=mysql_query("select airline from super_daily group by airline");
  	while($r1=mysql_fetch_array($str_airline))  
  	{
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(280,5,$r1[0],0,0,'L',0);$pdf->Ln(5);
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
			
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5,$r2[0],1,0,'C',1);$pdf->SetFont('Arial','',9);
			if($jan=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} else 
			{$pdf->Cell(20,5,number_format($jan, 1, ',', '.'),1,0,'R',1);}
			if($feb=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($feb, 1, ',', '.'),1,0,'R',1);}
			if($mar=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($mar, 1, ',', '.'),1,0,'R',1);}
			if($apr=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($apr, 1, ',', '.'),1,0,'R',1);}
			if($may=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($may, 1, ',', '.'),1,0,'R',1);}
			if($jun=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jun, 1, ',', '.'),1,0,'R',1);}
			if($jul=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($jul, 1, ',', '.'),1,0,'R',1);}
			if($aug=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($aug, 1, ',', '.'),1,0,'R',1);}
			if($sep=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($sep, 1, ',', '.'),1,0,'R',1);}
			if($oct=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($oct, 1, ',', '.'),1,0,'R',1);}
			if($nop=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($nop, 1, ',', '.'),1,0,'R',1);}
			if($dec=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($dec, 1, ',', '.'),1,0,'R',1);}
			if($tot=='') {$pdf->Cell(20,5,'-',1,0,'C',1);} 
			else {$pdf->Cell(20,5,number_format($tot, 1, ',', '.'),1,0,'R',1);}		
			$pdf->Ln();	 
		}	
		}
	}
} // end of TRANSIT - PER AIRPORT


} // END OF PER AIRPORT
//*************************		
	$pdf->Output('summaryreport.pdf','I');
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
			$this->Cell(0,10,'GAPURA MEDAN WMS INTER - Page '.$this->PageNo().'/{nb}',0,0,'R');
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
	//export dulu
mysql_query("delete from super_daily"); 
mysql_query("insert into super_daily 
SELECT 
s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
d.dest_code,d.dest_code  
FROM isimanifestout as i,manifestout as m, master_smu as s,flight as f,
commodity_ap as cp, commodity as c,origin as o, destination as d WHERE 
i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND m.idflight=f.idflight AND m.statusconfirm='1' AND s.idcommodityap=cp.idcommodityap AND 
cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND m.flightdate='$tglawal' AND o.origin_code='MES'
");
//utk nil
mysql_query("insert into super_daily 
SELECT m.idmanifestout,f.flight,m.idmanifestout,m.idmanifestout,m.idmanifestout,m.flightdate,m.statusnil,o.origin_code, d.dest_code,d.dest_code FROM manifestout as m,flight as f,origin as o, destination as d WHERE m.idflight=f.idflight AND m.statusconfirm='1' AND m.idorigin=o.idorigin AND m.iddestination=d.iddestination AND o.origin_code='MES' AND m.statusnil='on' AND m.flightdate='$tglawal' ");
//
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

		$ni=mysql_query("select flight from super_daily where statusnil='on' group by flight");

if(mysql_num_rows($ni)>0){

	$pdf->SetFont('Arial','',9);

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
//import dulu
mysql_query("delete from super_daily"); 
mysql_query("insert into super_daily 
SELECT 
s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
d.dest_code,d.dest_code  
FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
commodity_ap as cp, commodity as c,origin as o, destination as d WHERE 
i.idmanifestin= m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND i.statuskeluar<>'' AND s.idcommodityap=cp.idcommodityap AND 
cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND m.flightdate='$tglawal' AND d.dest_code='MES'
");
//utk nil
mysql_query("insert into super_daily 
SELECT m.idmanifestin,f.flight,m.idmanifestin,m.idmanifestin,m.idmanifestin,m.flightdate,m.statusnil,o.origin_code, d.dest_code,d.dest_code FROM manifestin as m,flight as f,origin as o, destination as d WHERE m.idflight=f.idflight AND m.idorigin=o.idorigin AND m.iddestination=d.iddestination AND d.dest_code='MES' AND m.statusnil='on' AND m.flightdate='$tglawal' ");
//
	$pdf->SetFont('Arial','I',12);
	$pdf->Cell(170,8,'IMPORT',0,0,'L',1);	
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

		$ni=mysql_query("select flight from super_daily where statusnil='on' group by flight");

if(mysql_num_rows($ni)>0){

	$pdf->SetFont('Arial','',9);

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
//baru transit
mysql_query("delete from super_daily"); 
mysql_query("insert into super_daily 
SELECT 
s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
d.dest_code,d.dest_code  
FROM isimanifestout as i,manifestout as m, master_smu as s,flight as f,
commodity_ap as cp, commodity as c,origin as o, destination as d WHERE 
i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND m.idflight=f.idflight AND m.statusconfirm='1' AND s.idcommodityap=cp.idcommodityap AND 
cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND m.flightdate='$tglawal' AND o.origin_code<>'MES'
");
	$pdf->SetFont('Arial','I',12);
	$pdf->Cell(170,8,'TRANSIT',0,0,'L',1);	
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
//utk yang NIL transit

		$ni=mysql_query("select flight from super_daily where statusnil='on' group by flight");

if(mysql_num_rows($ni)>0){

	$pdf->SetFont('Arial','',9);

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

}//END OF SEMUA DAILY
else if($outin=='0') //START OF IMPORT DAILY
{
mysql_query("delete from super_daily"); 
mysql_query("insert into super_daily 
SELECT 
s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
d.dest_code,d.dest_code  
FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
commodity_ap as cp, commodity as c,origin as o, destination as d WHERE 
i.idmanifestin= m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND s.idcommodityap=cp.idcommodityap AND 
cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND m.flightdate='$tglawal' AND d.dest_code='MES'
");
//utk nil
mysql_query("insert into super_daily 
SELECT m.idmanifestin,f.flight,m.idmanifestin,m.idmanifestin,m.idmanifestin,m.flightdate,m.statusnil,o.origin_code, d.dest_code,d.dest_code FROM manifestin as m,flight as f,origin as o, destination as d WHERE m.idflight=f.idflight AND m.idorigin=o.idorigin AND m.iddestination1=d.iddestination AND d.dest_code='MES' AND m.statusnil='on' AND m.flightdate='$tglawal' ");
//
	$pdf->SetFont('Arial','I',12);
	$pdf->Cell(170,8,'IMPORT',0,0,'L',1);	
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
//utk yang NIL import

		$ni=mysql_query("select flight from super_daily where statusnil='on' group by flight");

if(mysql_num_rows($ni)>0){

	$pdf->SetFont('Arial','',9);

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

//angkut lanjut :
mysql_query("delete from super_daily"); 
mysql_query("insert into super_daily 
SELECT 
s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
d.dest_code,d.dest_code  
FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
commodity_ap as cp, commodity as c,origin as o, destination as d WHERE 
i.idmanifestin= m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND s.idcommodityap=cp.idcommodityap AND 
cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND m.flightdate='$tglawal' AND d.dest_code<>'MES'
");
//utk nil
mysql_query("insert into super_daily 
SELECT m.idmanifestin,f.flight,m.idmanifestin,m.idmanifestin,m.idmanifestin,m.flightdate,m.statusnil,o.origin_code, d.dest_code,d.dest_code FROM manifestin as m,flight as f,origin as o, destination as d WHERE m.idflight=f.idflight AND m.idorigin=o.idorigin AND m.iddestination=d.iddestination AND d.dest_code<>'MES' AND m.statusnil='on' AND m.flightdate='$tglawal' ");
//
	$pdf->SetFont('Arial','I',12);
	$pdf->Cell(170,8,'ANGKUT LANJUT',0,0,'L',1);	
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
//utk yang NIL import

		$ni=mysql_query("select flight from super_daily where statusnil='on' group by flight");

if(mysql_num_rows($ni)>0){

	$pdf->SetFont('Arial','',9);

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
//END OF ANGKUT LANJUT				



}
else if($outin=='1')//START OF EXPORT DAILY
{
mysql_query("delete from super_daily"); 
mysql_query("insert into super_daily 
SELECT 
s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
d.dest_code,d.dest_code  
FROM isimanifestout as i,manifestout as m, master_smu as s,flight as f,
commodity_ap as cp, commodity as c,origin as o, destination as d WHERE 
i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND m.idflight=f.idflight AND m.statusconfirm='1' AND s.idcommodityap=cp.idcommodityap AND 
cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND m.flightdate='$tglawal' AND o.origin_code='MES'
");
//utk nil
mysql_query("insert into super_daily 
SELECT m.idmanifestout,f.flight,m.idmanifestout,m.idmanifestout,m.idmanifestout,m.flightdate,m.statusnil,o.origin_code, d.dest_code,d.dest_code FROM manifestout as m,flight as f,origin as o, destination as d WHERE m.idflight=f.idflight AND m.statusconfirm='1' AND m.idorigin=o.idorigin AND m.iddestination=d.iddestination AND o.origin_code='MES' AND m.statusnil='on' AND m.flightdate='$tglawal' ");
//
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

		$ni=mysql_query("select flight from super_daily where statusnil='on' group by flight");

if(mysql_num_rows($ni)>0){

	$pdf->SetFont('Arial','',9);

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
else if($outin=='3') //START OF TRANSIT
{
mysql_query("delete from super_daily"); 
mysql_query("insert into super_daily 
SELECT 
s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
d.dest_code,d.dest_code  
FROM isimanifestout as i,manifestout as m, master_smu as s,flight as f,
commodity_ap as cp, commodity as c,origin as o, destination as d WHERE 
i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND m.idflight=f.idflight AND m.statusconfirm='1' AND s.idcommodityap=cp.idcommodityap AND 
cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND m.flightdate='$tglawal' AND o.origin_code<>'MES'
");
	$pdf->SetFont('Arial','I',12);
	$pdf->Cell(170,8,'TRANSIT',0,0,'L',1);	
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
//utk yang NIL transit

		$ni=mysql_query("select flight from super_daily where statusnil='on' group by flight");

if(mysql_num_rows($ni)>0){

	$pdf->SetFont('Arial','',9);

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

	$pdf->Output('dailyreport.pdf','I');
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
			$this->Cell(0,10,'GAPURA MEDAN WMS INTER - Page '.$this->PageNo().'/{nb}',0,0,'R');
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
		AND o.origin_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
//utk nil
mysql_query("insert into super_daily 
SELECT m.idmanifestout,f.flight,m.idmanifestout,m.idmanifestout,m.idmanifestout,m.flightdate,m.statusnil,o.origin_code, d.dest_code,cs.customer  FROM customer as cs ,manifestout as m,flight as f,origin as o, destination as d WHERE m.idflight=f.idflight AND m.statusconfirm='1' AND m.idorigin=o.idorigin AND m.iddestination=d.iddestination AND o.origin_code='MES' AND m.statusnil='on' 
AND f.idcustomer=cs.idcustomer AND m.flightdate 
	BETWEEN '$tglawal' AND '$tglakhir' ");		

			
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
			WHERE statusnil='on' order by airline ASC");
		}
		else
		{
			$str_airline_nonil=mysql_query("select airline from super_daily 
			WHERE statusnil='' AND airline='$_POST[airline]' group by airline order by airline ASC");
			$str_airline_nil=mysql_query("select airline from super_daily 
			WHERE statusnil='on' AND airline='$_POST[airline]' group by airline order by airline ASC");
		}
		
		//untuk yang tidak nil dulu
		while($r=mysql_fetch_array($str_airline_nonil))  
		{
			$pdf->SetFont('Arial','',12);
			$pdf->Cell(25,5,$r[airline],0,0,'C',0);
			$pdf->Ln();
			
			$str_airport=mysql_query("select destination from super_daily where airline='$r[airline]' 
			AND statusnil='' group by destination");
			while($rs=mysql_fetch_array($str_airport))  
			{
			$pdf->SetFont('Arial','',12);
			$pdf->Cell(25,5,$rs[destination],0,0,'C',0);
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
				commodity='$rr[commodity]' AND airline='$r[airline]' AND statusnil='' 
				AND destination='$rs[destination]'  GROUP BY flight");
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
							$str_data=mysql_query("select flight from super_daily where 
				statusnil='on' and airline='$_POST[airline]' group by flight");
								$pdf->SetFont('Arial','',9);
				$pdf->Cell(35,5,'NIL',1,0,'C',1);
				$pdf->Cell(35,5,'BERAT(KG)',1,0,'C',1);
				$pdf->Cell(35,5,'COLLIE',1,0,'C',1);
				$pdf->Cell(25,5,'AWB QTY',1,0,'C',1);
				$pdf->Ln();
			while($rr=mysql_fetch_array($str_data))  
			{

				$brt=0;$kol=0;$qty=0;
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(35,5,$rr[flight],1,0,'L',1);
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
	if($outin=='0') //START OF IMPORT
	{
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
				SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestin = m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND d.dest_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
				
		
//utk nil
mysql_query("insert into super_daily 
	SELECT m.idmanifestin,f.flight,m.idmanifestin,m.idmanifestin,m.idmanifestin,m.flightdate,m.statusnil,o.origin_code, d.dest_code,cs.customer  FROM customer as cs ,manifestin as m,flight as f,origin as o, destination as d WHERE m.idflight=f.idflight AND m.idorigin=o.idorigin AND m.iddestination1=d.iddestination AND d.dest_code='MES' AND m.statusnil='on' 
AND f.idcustomer=cs.idcustomer AND m.flightdate 
	BETWEEN '$tglawal' AND '$tglakhir' ");	

			
		$pdf->SetFont('Arial','I',12);
		$pdf->Cell(170,8,'IMPORT',0,0,'L',1);	
		$pdf->Ln();
		$gtbrt=0;$gtkol=0;$gtqty=0;		
			
		//filtering airline
		 if($_POST[airline]=='SEMUA') //SEMUA AIRLINE
		{
			$str_airline_nonil=mysql_query("select airline from super_daily 
			WHERE statusnil='' group by airline order by airline ASC");
			$str_airline_nil=mysql_query("select airline from super_daily 
			WHERE statusnil='on' order by airline ASC");
		}
		else
		{
			$str_airline_nonil=mysql_query("select airline from super_daily 
			WHERE statusnil='' AND airline='$_POST[airline]' group by airline order by airline ASC");
			$str_airline_nil=mysql_query("select airline from super_daily 
			WHERE statusnil='on' AND airline='$_POST[airline]' order by airline ASC");
		}
		
		//untuk yang tidak nil dulu
		while($r=mysql_fetch_array($str_airline_nonil))  
		{
			$pdf->SetFont('Arial','',12);
			$pdf->Cell(25,5,$r[airline],0,0,'C',0);
			$pdf->Ln();
			
			$str_airport=mysql_query("select destination from super_daily where airline='$r[airline]' 
			AND statusnil='' group by destination");
			while($rs=mysql_fetch_array($str_airport))  
			{
			$pdf->SetFont('Arial','',12);
			$pdf->Cell(25,5,$rs[destination],0,0,'C',0);
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
				commodity='$rr[commodity]' AND airline='$r[airline]' AND statusnil='' 
				AND destination='$rs[destination]'  GROUP BY flight");
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
				$pdf->Ln(5);
				$gtbrt=$gtbrt+$tbrt;$gtkol=$gtkol+$tkol;$gtqty=$tqty+$gtqty;		
		}	
		}

//untuk NIL
		if(mysql_num_rows($str_airline_nil)>0)
		{
							$str_data=mysql_query("select flight from super_daily where 
				statusnil='on' AND airline='$_POST[airline]' group by flight");
								$pdf->SetFont('Arial','',9);
				$pdf->Cell(35,5,'NIL',1,0,'C',1);
				$pdf->Cell(35,5,'BERAT(KG)',1,0,'C',1);
				$pdf->Cell(35,5,'COLLIE',1,0,'C',1);
				$pdf->Cell(25,5,'AWB QTY',1,0,'C',1);
				$pdf->Ln();
			while($rr=mysql_fetch_array($str_data))  
			{

				$brt=0;$kol=0;$qty=0;
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(35,5,$rr[flight],1,0,'L',1);
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
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
				SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestin = m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND d.dest_code<>'MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
				
		
//utk nil
mysql_query("insert into super_daily 
	SELECT m.idmanifestin,f.flight,m.idmanifestin,m.idmanifestin,m.idmanifestin,m.flightdate,m.statusnil,o.origin_code, d.dest_code,cs.customer  FROM customer as cs ,manifestin as m,flight as f,origin as o, destination as d WHERE m.idflight=f.idflight AND m.idorigin=o.idorigin AND m.iddestination=d.iddestination AND d.dest_code<>'MES' AND m.statusnil='on' 
AND f.idcustomer=cs.idcustomer AND m.flightdate 
	BETWEEN '$tglawal' AND '$tglakhir' ");	

			
		$pdf->SetFont('Arial','I',12);
		$pdf->Cell(170,8,'ANGKUT LANJUT',0,0,'L',1);	
		$pdf->Ln();
		$gtbrt=0;$gtkol=0;$gtqty=0;		
			
		//filtering airline
		 if($_POST[airline]=='SEMUA') //SEMUA AIRLINE
		{
			$str_airline_nonil=mysql_query("select airline from super_daily 
			WHERE statusnil='' group by airline order by airline ASC");
			$str_airline_nil=mysql_query("select airline from super_daily 
			WHERE statusnil='on' order by airline ASC");
		}
		else
		{
			$str_airline_nonil=mysql_query("select airline from super_daily 
			WHERE statusnil='' AND airline='$_POST[airline]' group by airline order by airline ASC");
			$str_airline_nil=mysql_query("select airline from super_daily 
			WHERE statusnil='on' AND airline='$_POST[airline]' order by airline ASC");
		}
		
		//untuk yang tidak nil dulu
		while($r=mysql_fetch_array($str_airline_nonil))  
		{
			$pdf->SetFont('Arial','',12);
			$pdf->Cell(25,5,$r[airline],0,0,'C',0);
			$pdf->Ln();
			
			$str_airport=mysql_query("select destination from super_daily where airline='$r[airline]' 
			AND statusnil='' group by destination");
			while($rs=mysql_fetch_array($str_airport))  
			{
			$pdf->SetFont('Arial','',12);
			$pdf->Cell(25,5,$rs[destination],0,0,'C',0);
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
				commodity='$rr[commodity]' AND airline='$r[airline]' AND statusnil='' 
				AND destination='$rs[destination]'  GROUP BY flight");
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
				$pdf->Ln(5);
				$gtbrt=$gtbrt+$tbrt;$gtkol=$gtkol+$tkol;$gtqty=$tqty+$gtqty;		
		}	
		}

//untuk NIL
		if(mysql_num_rows($str_airline_nil)>0)
		{
							$str_data=mysql_query("select flight from super_daily where 
				statusnil='on' group by flight");
								$pdf->SetFont('Arial','',9);
				$pdf->Cell(35,5,'NIL',1,0,'C',1);
				$pdf->Cell(35,5,'BERAT(KG)',1,0,'C',1);
				$pdf->Cell(35,5,'COLLIE',1,0,'C',1);
				$pdf->Cell(25,5,'AWB QTY',1,0,'C',1);
				$pdf->Ln();
			while($rr=mysql_fetch_array($str_data))  
			{

				$brt=0;$kol=0;$qty=0;
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(35,5,$rr[flight],1,0,'L',1);
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
		
	}//END OF IMPORT
	else if($outin=='2') // START OF SEMUA
	{
		mysql_query("delete from super_daily"); 
//EXPORT DULUAN 
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
		AND o.origin_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
//utk nil
mysql_query("insert into super_daily 
SELECT m.idmanifestout,f.flight,m.idmanifestout,m.idmanifestout,m.idmanifestout,m.flightdate,m.statusnil,o.origin_code, d.dest_code,cs.customer  FROM customer as cs ,manifestout as m,flight as f,origin as o, destination as d WHERE m.idflight=f.idflight AND m.statusconfirm='1' AND m.idorigin=o.idorigin AND m.iddestination=d.iddestination AND o.origin_code='MES' AND m.statusnil='on' 
AND f.idcustomer=cs.idcustomer AND m.flightdate 
	BETWEEN '$tglawal' AND '$tglakhir' ");		

			
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
			WHERE statusnil='on' order by airline ASC");
		}
		else
		{
			$str_airline_nonil=mysql_query("select airline from super_daily 
			WHERE statusnil='' AND airline='$_POST[airline]' group by airline order by airline ASC");
			$str_airline_nil=mysql_query("select airline from super_daily 
			WHERE statusnil='on' AND airline='$_POST[airline]' order by airline ASC");
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
				commodity='$rr[commodity]' AND airline='$r[airline]' AND statusnil='' 
				AND destination='$rs[destination]'  GROUP BY flight");
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
							$str_data=mysql_query("select flight from super_daily where 
				statusnil='on' group by flight");
								$pdf->SetFont('Arial','',9);
				$pdf->Cell(35,5,'NIL',1,0,'C',1);
				$pdf->Cell(35,5,'BERAT(KG)',1,0,'C',1);
				$pdf->Cell(35,5,'COLLIE',1,0,'C',1);
				$pdf->Cell(25,5,'AWB QTY',1,0,'C',1);
				$pdf->Ln();
			while($rr=mysql_fetch_array($str_data))  
			{

				$brt=0;$kol=0;$qty=0;
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(35,5,$rr[flight],1,0,'L',1);
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

//IMPORTNYA
		mysql_query("delete from super_daily"); 
		mysql_query ("insert into super_daily 
				SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestin = m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND i.statuskeluar<>'' AND 
		s.idcommodityap=cp.idcommodityap AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND d.dest_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
				
		
//utk nil
mysql_query("insert into super_daily 
	SELECT m.idmanifestin,f.flight,m.idmanifestin,m.idmanifestin,m.idmanifestin,m.flightdate,m.statusnil,o.origin_code, d.dest_code,cs.customer  FROM customer as cs ,manifestin as m,flight as f,origin as o, destination as d WHERE m.idflight=f.idflight AND m.idorigin=o.idorigin AND m.iddestination=d.iddestination AND d.dest_code='MES' AND m.statusnil='on' 
AND f.idcustomer=cs.idcustomer AND m.flightdate 
	BETWEEN '$tglawal' AND '$tglakhir' ");	

			
		$pdf->SetFont('Arial','I',12);
		$pdf->Cell(170,8,'IMPORT',0,0,'L',1);	
		$pdf->Ln();
		$gtbrt=0;$gtkol=0;$gtqty=0;		
			
		//filtering airline
		 if($_POST[airline]=='SEMUA') //SEMUA AIRLINE
		{
			$str_airline_nonil=mysql_query("select airline from super_daily 
			WHERE statusnil='' group by airline order by airline ASC");
			$str_airline_nil=mysql_query("select airline from super_daily 
			WHERE statusnil='on' order by airline ASC");
		}
		else
		{
			$str_airline_nonil=mysql_query("select airline from super_daily 
			WHERE statusnil='' AND airline='$_POST[airline]' group by airline order by airline ASC");
			$str_airline_nil=mysql_query("select airline from super_daily 
			WHERE statusnil='on' AND airline='$_POST[airline]' order by airline ASC");
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
				commodity='$rr[commodity]' AND airline='$r[airline]' AND statusnil='' 
				AND destination='$rs[destination]'  GROUP BY flight");
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
							$str_data=mysql_query("select flight from super_daily where 
				statusnil='on' group by flight");
								$pdf->SetFont('Arial','',9);
				$pdf->Cell(35,5,'NIL',1,0,'C',1);
				$pdf->Cell(35,5,'BERAT(KG)',1,0,'C',1);
				$pdf->Cell(35,5,'COLLIE',1,0,'C',1);
				$pdf->Cell(25,5,'AWB QTY',1,0,'C',1);
				$pdf->Ln();
			while($rr=mysql_fetch_array($str_data))  
			{

				$brt=0;$kol=0;$qty=0;
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(35,5,$rr[flight],1,0,'L',1);
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
		
//TRANSITNYA :
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
		AND o.origin_code<>'MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
//utk nil
mysql_query("insert into super_daily 
SELECT m.idmanifestout,f.flight,m.idmanifestout,m.idmanifestout,m.idmanifestout,m.flightdate,m.statusnil,o.origin_code, d.dest_code,cs.customer  FROM customer as cs ,manifestout as m,flight as f,origin as o, destination as d WHERE m.idflight=f.idflight AND m.statusconfirm='1' AND m.idorigin=o.idorigin AND m.iddestination=d.iddestination AND o.origin_code='MES' AND m.statusnil='on' 
AND f.idcustomer=cs.idcustomer AND m.flightdate 
	BETWEEN '$tglawal' AND '$tglakhir' ");		

			
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
			WHERE statusnil='on' order by airline ASC");
		}
		else
		{
			$str_airline_nonil=mysql_query("select airline from super_daily 
			WHERE statusnil='' AND airline='$_POST[airline]' group by airline order by airline ASC");
			$str_airline_nil=mysql_query("select airline from super_daily 
			WHERE statusnil='on' AND airline='$_POST[airline]' order by airline ASC");
		}
		
		//untuk yang tidak nil dulu
		while($r=mysql_fetch_array($str_airline_nonil))  
		{
			$pdf->SetFont('Arial','',12);
			$pdf->Cell(25,5,$r[airline],0,0,'C',0);
			$pdf->Ln();
			
			$str_airport=mysql_query("select destination from super_daily where airline='$r[airline]' 
			AND statusnil='' group by destination");
			while($rs=mysql_fetch_array($str_airport))  
			{
			$pdf->SetFont('Arial','',12);
			$pdf->Cell(25,5,$rs[destination],0,0,'C',0);
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
				commodity='$rr[commodity]' AND airline='$r[airline]' AND statusnil='' 
				AND destination='$rs[destination]'  GROUP BY flight");
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
							$str_data=mysql_query("select flight from super_daily where 
				statusnil='on' group by flight");
								$pdf->SetFont('Arial','',9);
				$pdf->Cell(35,5,'NIL',1,0,'C',1);
				$pdf->Cell(35,5,'BERAT(KG)',1,0,'C',1);
				$pdf->Cell(35,5,'COLLIE',1,0,'C',1);
				$pdf->Cell(25,5,'AWB QTY',1,0,'C',1);
				$pdf->Ln();
			while($rr=mysql_fetch_array($str_data))  
			{

				$brt=0;$kol=0;$qty=0;
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(35,5,$rr[flight],1,0,'L',1);
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
		cp.idcommodity=c.idcommodity AND m.idorigin=o.idorigin AND m.iddestination=d.iddestination 
		AND o.origin_code<>'MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
//utk nil
mysql_query("insert into super_daily 
SELECT m.idmanifestout,f.flight,m.idmanifestout,m.idmanifestout,m.idmanifestout,m.flightdate,m.statusnil,o.origin_code, d.dest_code,cs.customer  FROM customer as cs ,manifestout as m,flight as f,origin as o, destination as d WHERE m.idflight=f.idflight AND m.statusconfirm='1' AND m.idorigin=o.idorigin AND m.iddestination=d.iddestination AND o.origin_code='MES' AND m.statusnil='on' 
AND f.idcustomer=cs.idcustomer AND m.flightdate 
	BETWEEN '$tglawal' AND '$tglakhir' ");		

			
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
			WHERE statusnil='on' order by airline ASC");
		}
		else
		{
			$str_airline_nonil=mysql_query("select airline from super_daily 
			WHERE statusnil='' AND airline='$_POST[airline]' group by airline order by airline ASC");
			$str_airline_nil=mysql_query("select airline from super_daily 
			WHERE statusnil='on' AND airline='$_POST[airline]' order by airline ASC");
		}
		
		//untuk yang tidak nil dulu
		while($r=mysql_fetch_array($str_airline_nonil))  
		{
			$pdf->SetFont('Arial','',12);
			$pdf->Cell(25,5,$r[airline],0,0,'C',0);
			$pdf->Ln();
			
			$str_airport=mysql_query("select destination,origin from super_daily where airline='$r[airline]' 
			AND statusnil='' group by destination");
			while($rs=mysql_fetch_array($str_airport))  
			{
			$pdf->SetFont('Arial','',12);
			$pdf->Cell(25,5,$rs[origin].'-'.$rs[destination],0,0,'C',0);
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
				commodity='$rr[commodity]' AND airline='$r[airline]' AND statusnil='' 
				AND destination='$rs[destination]'  GROUP BY flight");
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
							$str_data=mysql_query("select flight from super_daily where 
				statusnil='on' group by flight");
								$pdf->SetFont('Arial','',9);
				$pdf->Cell(35,5,'NIL',1,0,'C',1);
				$pdf->Cell(35,5,'BERAT(KG)',1,0,'C',1);
				$pdf->Cell(35,5,'COLLIE',1,0,'C',1);
				$pdf->Cell(25,5,'AWB QTY',1,0,'C',1);
				$pdf->Ln();
			while($rr=mysql_fetch_array($str_data))  
			{

				$brt=0;$kol=0;$qty=0;
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(35,5,$rr[flight],1,0,'L',1);
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


	// filtering SQL
	if($outin=='1') //START OF EXPORT
	{
			mysql_query("delete from super_daily"); 
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
		AND o.origin_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
//utk nil
mysql_query("insert into super_daily 
SELECT m.idmanifestout,f.flight,m.idmanifestout,m.idmanifestout,m.idmanifestout,m.flightdate,m.statusnil,o.origin_code, d.dest_code,cs.customer  FROM customer as cs ,manifestout as m,flight as f,origin as o, destination as d WHERE m.idflight=f.idflight AND m.statusconfirm='1' AND m.idorigin=o.idorigin AND m.iddestination=d.iddestination AND o.origin_code='MES' AND m.statusnil='on' 
AND f.idcustomer=cs.idcustomer AND m.flightdate 
	BETWEEN '$tglawal' AND '$tglakhir' ");				
		
		$pdf->SetFont('Arial','I',12);
		$pdf->Cell(170,8,'EXPORT',0,0,'L',1);	
		$pdf->Ln();
		$gtbrt=0;$gtkol=0;$gtqty=0;		
			
		//filtering airline
		 if($_POST[airline]=='SEMUA') //SEMUA AIRLINE
		{
			$str_airline_nonil=mysql_query("select airline from super_daily 
			WHERE statusnil='' group by airline order by airline ASC");
			$str_airline_nil=mysql_query("select flight from super_daily 
			WHERE statusnil='on' group by airline order by airline ASC");
		}
		else
		{
			$str_airline_nonil=mysql_query("select airline from super_daily 
			WHERE statusnil='' AND airline='$_POST[airline]' group by airline order by airline ASC");
			$str_airline_nil=mysql_query("select flight from super_daily 
			WHERE statusnil='on' AND airline='$_POST[airline]' group by airline order by airline ASC");
		}
		
		//untuk yang tidak nil dulu
		while($r=mysql_fetch_array($str_airline_nonil))  
		{
			$pdf->SetFont('Arial','',12);
			$pdf->Cell(25,5,$r[airline],0,0,'C',0);
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
				$pdf->Cell(35,5,$rrr[0],1,0,'L',1);
				$pdf->Cell(35,5,'0',1,0,'R',1);
				$pdf->Cell(35,5,'0',1,0,'R',1);
				$pdf->Cell(25,5,'0',1,0,'R',1);
				$pdf->Ln();
				$brt=$rrr[sumberat]+$brt;$kol=$kol+$rrr[sumkoli];$qty=$qty+$rrr[jsmu];
			}		
			$pdf->Ln();
			//$gtbrt=$gtbrt+$tbrt;$gtkol=$gtkol+$tkol;$gtqty=$tqty+$gtqty;
							
		}
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',12);	
		$pdf->Cell(35,5,'TOTAL EXPORT',1,0,'C',1);
		$pdf->Cell(35,5,number_format($gtbrt, 1, ',', '.'),1,0,'R',1);
		$pdf->Cell(35,5,number_format($gtkol, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($gtqty, 0, '.', '.'),1,0,'R',1);
		$pdf->Ln(10);		
	}//END OF EXPORT
	else if($outin=='0') //START OF IMPORT
	{
			mysql_query("delete from super_daily"); 
		mysql_query("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestin = m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND d.dest_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
//utk nil
mysql_query("insert into super_daily 
SELECT m.idmanifestin,f.flight,m.idmanifestin,m.idmanifestin,m.idmanifestin,m.flightdate,m.statusnil,o.origin_code, d.dest_code,cs.customer  FROM customer as cs ,manifestin as m,flight as f,origin as o, destination as d WHERE m.idflight=f.idflight AND m.idorigin=o.idorigin AND m.iddestination1=d.iddestination AND d.dest_code='MES' AND m.statusnil='on' 
AND f.idcustomer=cs.idcustomer AND m.flightdate 
	BETWEEN '$tglawal' AND '$tglakhir' ");				
		
		$pdf->SetFont('Arial','I',12);
		$pdf->Cell(170,8,'IMPORT',0,0,'L',1);	
		$pdf->Ln();
		$gtbrt=0;$gtkol=0;$gtqty=0;		
			
		//filtering airline
		 if($_POST[airline]=='SEMUA') //SEMUA AIRLINE
		{
			$str_airline_nonil=mysql_query("select airline from super_daily 
			WHERE statusnil='' group by airline order by airline ASC");
			$str_airline_nil=mysql_query("select flight from super_daily 
			WHERE statusnil='on' group by airline order by airline ASC");
		}
		else
		{
			$str_airline_nonil=mysql_query("select airline from super_daily 
			WHERE statusnil='' AND airline='$_POST[airline]' group by airline order by airline ASC");
			$str_airline_nil=mysql_query("select flight from super_daily 
			WHERE statusnil='on' AND airline='$_POST[airline]'  group by airline order by airline ASC");
		}
		
		//untuk yang tidak nil dulu
		while($r=mysql_fetch_array($str_airline_nonil))  
		{
			$pdf->SetFont('Arial','',12);
			$pdf->Cell(25,5,$r[airline],0,0,'C',0);
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
				$pdf->Cell(35,5,$rrr[0],1,0,'L',1);
				$pdf->Cell(35,5,'0',1,0,'R',1);
				$pdf->Cell(35,5,'0',1,0,'R',1);
				$pdf->Cell(25,5,'0',1,0,'R',1);
				$pdf->Ln();
				$brt=$rrr[sumberat]+$brt;$kol=$kol+$rrr[sumkoli];$qty=$qty+$rrr[jsmu];
			}		
			$pdf->Ln();
			//$gtbrt=$gtbrt+$tbrt;$gtkol=$gtkol+$tkol;$gtqty=$tqty+$gtqty;
							
		}
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',12);	
		$pdf->Cell(35,5,'TOTAL IMPORT',1,0,'C',1);
		$pdf->Cell(35,5,number_format($gtbrt, 1, ',', '.'),1,0,'R',1);
		$pdf->Cell(35,5,number_format($gtkol, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($gtqty, 0, '.', '.'),1,0,'R',1);
		$pdf->Ln(10);		
	}//END OF IMPORT
	
	
	
	else if($outin=='2') // START OF SEMUA
	{
			mysql_query("delete from super_daily"); 
//EXPORT
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
		AND o.origin_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
//utk nil
mysql_query("insert into super_daily 
SELECT m.idmanifestout,f.flight,m.idmanifestout,m.idmanifestout,m.idmanifestout,m.flightdate,m.statusnil,o.origin_code, d.dest_code,cs.customer  FROM customer as cs ,manifestout as m,flight as f,origin as o, destination as d WHERE m.idflight=f.idflight AND m.statusconfirm='1' AND m.idorigin=o.idorigin AND m.iddestination=d.iddestination AND o.origin_code='MES' AND m.statusnil='on' 
AND f.idcustomer=cs.idcustomer AND m.flightdate 
	BETWEEN '$tglawal' AND '$tglakhir' ");				
		
		$pdf->SetFont('Arial','I',12);
		$pdf->Cell(170,8,'EXPORT',0,0,'L',1);	
		$pdf->Ln();
		$gtbrt=0;$gtkol=0;$gtqty=0;		
			
		//filtering airline
		 if($_POST[airline]=='SEMUA') //SEMUA AIRLINE
		{
			$str_airline_nonil=mysql_query("select airline from super_daily 
			WHERE statusnil='' group by airline order by airline ASC");
			$str_airline_nil=mysql_query("select flight from super_daily 
			WHERE statusnil='on' group by airline order by airline ASC");
		}
		else
		{
			$str_airline_nonil=mysql_query("select airline from super_daily 
			WHERE statusnil='' AND airline='$_POST[airline]' group by airline order by airline ASC");
			$str_airline_nil=mysql_query("select flight from super_daily 
			WHERE statusnil='on' AND airline='$_POST[airline]' group by airline order by airline ASC");
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
				$pdf->Cell(35,5,$rrr[0],1,0,'L',1);
				$pdf->Cell(35,5,'0',1,0,'R',1);
				$pdf->Cell(35,5,'0',1,0,'R',1);
				$pdf->Cell(25,5,'0',1,0,'R',1);
				$pdf->Ln();
				$brt=$rrr[sumberat]+$brt;$kol=$kol+$rrr[sumkoli];$qty=$qty+$rrr[jsmu];
			}		
			$pdf->Ln();
			//$gtbrt=$gtbrt+$tbrt;$gtkol=$gtkol+$tkol;$gtqty=$tqty+$gtqty;
							
		}
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',12);	
		$pdf->Cell(35,5,'TOTAL EXPORT',1,0,'C',1);
		$pdf->Cell(35,5,number_format($gtbrt, 1, ',', '.'),1,0,'R',1);
		$pdf->Cell(35,5,number_format($gtkol, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($gtqty, 0, '.', '.'),1,0,'R',1);
		$pdf->Ln(10);	
//IMPORT
	mysql_query("delete from super_daily"); 
		mysql_query("insert into super_daily 
		SELECT 
		s.nosmu,f.flight,i.koli,i.berat,c.commodity,m.flightdate,m.statusnil,o.origin_code,
		d.dest_code,cs.customer 
		FROM isimanifestin as i,manifestin as m, master_smu as s,flight as f,
		commodity_ap as cp, commodity as c,origin as o, destination as d,customer as cs WHERE 
		i.idmanifestin = m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' 
		AND i.statuscancel='0' AND m.idflight=f.idflight AND i.statusconfirm='1' AND 
		s.idcommodityap=cp.idcommodityap AND i.statuskeluar<>'' AND 
		cp.idcommodity=c.idcommodity AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination 
		AND d.dest_code='MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
		BETWEEN '$tglawal' AND '$tglakhir'");
//utk nil
mysql_query("insert into super_daily 
SELECT m.idmanifestin,f.flight,m.idmanifestin,m.idmanifestin,m.idmanifestin,m.flightdate,m.statusnil,o.origin_code, d.dest_code,cs.customer  FROM customer as cs ,manifestin as m,flight as f,origin as o, destination as d WHERE m.idflight=f.idflight AND m.idorigin=o.idorigin AND m.iddestination=d.iddestination AND d.dest_code='MES' AND m.statusnil='on' 
AND f.idcustomer=cs.idcustomer AND m.flightdate 
	BETWEEN '$tglawal' AND '$tglakhir' ");				
		
		$pdf->SetFont('Arial','I',12);
		$pdf->Cell(170,8,'IMPORT',0,0,'L',1);	
		$pdf->Ln();
		$gtbrt=0;$gtkol=0;$gtqty=0;		
			
		//filtering airline
		 if($_POST[airline]=='SEMUA') //SEMUA AIRLINE
		{
			$str_airline_nonil=mysql_query("select airline from super_daily 
			WHERE statusnil='' group by airline order by airline ASC");
			$str_airline_nil=mysql_query("select flight from super_daily 
			WHERE statusnil='on' group by airline order by airline ASC");
		}
		else
		{
			$str_airline_nonil=mysql_query("select airline from super_daily 
			WHERE statusnil='' AND airline='$_POST[airline]' group by airline order by airline ASC");
			$str_airline_nil=mysql_query("select flight from super_daily 
			WHERE statusnil='on' AND airline='$_POST[airline]'  group by airline order by airline ASC");
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
				$pdf->Cell(35,5,$rrr[0],1,0,'L',1);
				$pdf->Cell(35,5,'0',1,0,'R',1);
				$pdf->Cell(35,5,'0',1,0,'R',1);
				$pdf->Cell(25,5,'0',1,0,'R',1);
				$pdf->Ln();
				$brt=$rrr[sumberat]+$brt;$kol=$kol+$rrr[sumkoli];$qty=$qty+$rrr[jsmu];
			}		
			$pdf->Ln();
			//$gtbrt=$gtbrt+$tbrt;$gtkol=$gtkol+$tkol;$gtqty=$tqty+$gtqty;
							
		}
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',12);	
		$pdf->Cell(35,5,'TOTAL IMPORT',1,0,'C',1);
		$pdf->Cell(35,5,number_format($gtbrt, 1, ',', '.'),1,0,'R',1);
		$pdf->Cell(35,5,number_format($gtkol, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($gtqty, 0, '.', '.'),1,0,'R',1);
		$pdf->Ln(10);		
//TRANSIT
	mysql_query("delete from super_daily"); 
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
		AND o.origin_code<>'MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
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
			WHERE statusnil='on' group by airline order by airline ASC");
		}
		else
		{
			$str_airline_nonil=mysql_query("select airline from super_daily 
			WHERE statusnil='' AND airline='$_POST[airline]' group by airline order by airline ASC");
			$str_airline_nil=mysql_query("select airline from super_daily 
			WHERE statusnil='on' AND airline='$_POST[airline]' group by airline order by airline ASC");
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
		//	$gtbrt=$gtbrt+$tbrt;$gtkol=$gtkol+$tkol;$gtqty=$tqty+$gtqty;
								
		}
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',12);	
		$pdf->Cell(35,5,'TOTAL TRANSIT',1,0,'C',1);
		$pdf->Cell(35,5,number_format($gtbrt, 1, ',', '.'),1,0,'R',1);
		$pdf->Cell(35,5,number_format($gtkol, 0, '.', '.'),1,0,'R',1);
		$pdf->Cell(25,5,number_format($gtqty, 0, '.', '.'),1,0,'R',1);
		$pdf->Ln(10);		
				
	}//END OF PERIOD SEMUA
	else if($outin=='3') // START OF TRANSIT
	{
			mysql_query("delete from super_daily"); 
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
		AND o.origin_code<>'MES' AND f.idcustomer=cs.idcustomer AND m.flightdate 
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
			WHERE statusnil='on' group by airline order by airline ASC");
		}
		else
		{
			$str_airline_nonil=mysql_query("select airline from super_daily 
			WHERE statusnil='' AND airline='$_POST[airline]' group by airline order by airline ASC");
			$str_airline_nil=mysql_query("select airline from super_daily 
			WHERE statusnil='on' AND airline='$_POST[airline]' group by airline order by airline ASC");
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
		//	$gtbrt=$gtbrt+$tbrt;$gtkol=$gtkol+$tkol;$gtqty=$tqty+$gtqty;
								
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
	$pdf->Output('periodicalreport.pdf','I');
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
			$this->Cell(0,10,'GAPURA MEDAN WMS INTER - Page '.$this->PageNo().'/{nb}',0,0,'R');
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
select i.tglmanifest,b.kolidatang,i.no_smu,b.beratdatang,t.kategori,m.airline,i.tujuan,i.asal from breakdown as b,isimanifestin as i,manifestin as m,typebarang as t where b.id_isimanifestin=i.id_isimanifestin AND i.id_manifestin = m.id_manifestin AND i.jenisbarang = t.typebarang AND i.status_transit='MES' AND b.status_check='confirm' AND m.nil='' AND b.isvoid='0' AND m.noflight='$_POST[airline]' 
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
select i.tglmanifest,b.kolidatang,i.no_smu,b.beratdatang,t.kategori,m.airline,i.tujuan,i.asal from breakdown as b,isimanifestin as i,manifestin as m,typebarang as t where b.id_isimanifestin=i.id_isimanifestin AND i.id_manifestin = m.id_manifestin AND i.jenisbarang = t.typebarang AND i.status_transit<>'MES' AND b.status_check='confirm' AND m.nil='' AND b.isvoid='0' AND m.noflight='$_POST[airline]' 
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
select m.tglmanifest,b.koli,o.btb_smu,b.berat,t.kategori,m.airline,o.btb_tujuan,o.btb_tujuan  from buildup as b,manifestout as m,typebarang as t,out_dtbarang_h as o where b.id_out_dtbarang_h=o.id AND b.id_manifestout=m.id_manifestout AND b.jenisbarang = t.typebarang AND m.nil='' AND status='checked' AND m.noflight='$_POST[airline]' AND m.tglmanifest BETWEEN '$tglawal' AND '$tglakhir'  AND m.isvoid='0' AND b.status_transit='MES' AND b.isvoid='0' group by b.id_out_dtbarang_h 
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
select m.tglmanifest,b.koli,o.btb_smu,b.berat,t.kategori,m.airline,o.btb_tujuan,o.btb_tujuan  from buildup as b,manifestout as m,typebarang as t,out_dtbarang_h as o where b.id_out_dtbarang_h=o.id AND b.id_manifestout=m.id_manifestout AND b.jenisbarang = t.typebarang AND m.nil='' AND status='checked' AND m.noflight='$_POST[airline]' AND m.tglmanifest BETWEEN '$tglawal' AND '$tglakhir'  AND m.isvoid='0' AND b.status_transit<>'MES' AND b.isvoid='0' group by b.id_out_dtbarang_h 
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
//IMPORT !
//---------------Menambah Data Manifest Import---------------------------------------------------------
if ($module=='manifestimport' AND $act=='tambah')
{
$a=my2date($_POST[tglawal]);
  mysql_query("INSERT INTO manifestin(idflight ,idorigin ,iddestination1 ,iddestination2,iddestination3 ,acregister ,
  flightdate ,etd,pointofloading ,pointul ,username ,statusnil ,statusconfirm ,statuscancel ,statusvoid ,keterangan)
  VALUES ('$_POST[flight]', '$_POST[origin]', '$_POST[destination1]','$_POST[destination2]','$_POST[destination3]', '$_POST[requiredacregister]',
  '$a','$_POST[etd]','$_POST[requiredpointofloading]', '$_POST[requiredpointul]', '$_SESSION[namauser]', '$_POST[statusnil]', '0','0', '0', '')");
if($_POST[statusnil]=='on')
{
	header('location:media.php?module=carimanifestimport&d='.$_POST[tglawal]);
}
else
{
$lst=mysql_fetch_array(mysql_query("select idmanifestin from manifestin order by idmanifestin DESC limit 1"));  
	$dt=mysql_fetch_array(mysql_query("SELECT m.idmanifestin,m.acregister,
	f.flight,m.flightdate FROM manifestin as m,flight as f, customer as c
	WHERE m.idflight=f.idflight  AND f.idcustomer=c.idcustomer AND m.idmanifestin=$lst[idmanifestin]")); 
 header('location:media.php?module=isimanifestimport&idm='.$dt[idmanifestin].'&r='.$dt[acregister].'&f='.$dt[flight].'&d='.ymd2dmy($dt[flightdate]));
} 
} 
//---------------End of Menambah Data Manifest Import --------------------------------------------------

//---------------Mengedit Data Manifest Import---------------------------------------------------------
if ($module=='manifestimport' AND $act=='edit')
{
$a=my2date($_POST[tglawal]);
  mysql_query("UPDATE manifestin set idflight='$_POST[flight]' ,idorigin='$_POST[origin]' ,iddestination1='$_POST[destination1]',iddestination2='$_POST[destination2]',iddestination3='$_POST[destination3]',acregister='$_POST[requiredacregister]' , flightdate = '$a',username='$_SESSION[namauser]' ,statusnil='$_POST[statusnil]',etd='$_POST[etd]' WHERE idmanifestin='$_POST[idm]'");
if($_POST[statusnil]=='on')
{
	header('location:media.php?module=carimanifestimport&d='.$_POST[tglawal]);
}
else
{
$lst=mysql_fetch_array(mysql_query("select idmanifestin from manifestin order by idmanifestin DESC limit 1"));  
	$dt=mysql_fetch_array(mysql_query("SELECT m.idmanifestin,m.acregister,
	f.flight,m.flightdate FROM manifestin as m,flight as f, customer as c
	WHERE m.idflight=f.idflight  AND f.idcustomer=c.idcustomer AND m.idmanifestin=$lst[idmanifestin]")); 
 //header('location:media.php?module=carimanifestimport');
 header('location:media.php?module=carimanifestimport&idm='.$dt[idmanifestin].'&r='.$dt[acregister].'&f='.$dt[flight].'&d='.ymd2dmy($dt[flightdate])); 
} 
} 
//---------------End of Mengedit Data Manifest Import --------------------------------------------------
//---------------Mengedit Data AWB Import---------------------------------------------------------
if ($module=='awbimport' AND $act=='edit')
{
$tgl=my2date($_POST[tglawal]);
mysql_query("UPDATE master_smu  set 
nosmu='$_POST[requiredawb]' ,idcommodityap='$_POST[commodity]' ,idorigin='$_POST[origin]' ,iddestination ='$_POST[destination]',berat='$_POST[requiredkg]' ,beratbayar='$_POST[requiredkgb]',koli='$_POST[requiredkoli]' ,
user='$_SESSION[namauser]' ,tglsmu='$tgl' ,shipper= '$_POST[shipper]' ,consignee= '$_POST[consignee]' ,idagent='$_POST[agent]',idconnectingflight='$_POST[connectingflight]',remark='$_POST[remark]' WHERE idmastersmu='$_POST[ids]'"); 

 header('location:media.php?module=carismu&cari='.$_POST[requiredawb]);
} 
//---------------End of Menngedit AWB Import--------------------------------------------------

//update 11 sept 2010
//---------------Menambah Data AWB Today---------------------------------------------------------
if ($module=='awbimport' AND $act=='tambah')
{


	if($_POST[commodity]=='18') //selalu utk MAIL !!
	{
			$noawb=nopos($_POST[requiredawb]);
	}
	else
	{
			$noawb=$_POST[requiredawb];
	}
	
	$tgl=my2date($_POST[tglawal]);
	
	if($_POST[sp]=='')
	{
  mysql_query("INSERT INTO master_smu (nosmu ,idcommodityap ,idorigin ,iddestination ,berat,beratbayar ,koli ,
  isvoid,status_transit ,user ,tglsmu ,shipper ,consignee ,idagent,exim,idconnectingflight,remark) VALUES ('$noawb' ,'$_POST[commodity]','$_POST[origin]', '$_POST[destination]', '$_POST[requiredkgdoc]','$_POST[requiredkgbdoc]','$_POST[requiredkolidoc]', '0', '$_POST[transit]' , '$_SESSION[namauser]', '$tgl' , '$_POST[shipper]', '$_POST[consignee]' , '$_POST[agent]','1','$_POST[connectingflight]','$_POST[remark]')");
    $idsmu=mysql_fetch_array(mysql_query("select idmastersmu from master_smu where nosmu='$noawb'"));
} else {  $idsmu=mysql_fetch_array(mysql_query("select idmastersmu from master_smu where nosmu='$_POST[requiredawb]'"));}
  mysql_query("INSERT INTO isimanifestin (idmanifestin,idmastersmu,berat,beratbayar,koli,nopos) values 
  ('$_POST[idm]','$idsmu[0]','$_POST[requiredkg]','$_POST[requiredkgb]','$_POST[requiredkoli]','$_POST[requiredpos]')");
 header('location:media.php?module=isimanifestimport&idm='.$_POST[idm].'&r='.$_POST[r].'&f='.$_POST[f].'&d='.$_POST[d]);

} 
//---------------End of Menambah Data  AWB--------------------------------------------------
//---------------Confirm AWB Isi Manifest Import -------------------------------------------------
if ($module=='isimanifestimport' AND $act=='confirm')
{
 mysql_query("UPDATE isimanifestin SET statusconfirm='1' WHERE idisimanifestin  = '$_GET[iim]'");
  header('location:media.php?module='.$module.'&idm='.$_GET[idm].'&r='.$_GET[r].'&f='.$_GET[f].'&d='.$_GET[d]);
}
//---------------End of Confirm Isi AWB Manifest Import 
//---------------Cancel AWB Isi Manifest Import -------------------------------------------------
if ($module=='isimanifestimport' AND $act=='cancel')
{
 mysql_query("delete from isimanifestin WHERE idisimanifestin  = '$_GET[iim]'");
  header('location:media.php?module='.$module.'&idm='.$_GET[idm].'&r='.$_GET[r].'&f='.$_GET[f].'&d='.$_GET[d]);
}
//---------------End of Cancel Isi AWB Manifest Import 

//cetak daftar bongkar barang
if ($module=='cetakdaftarbongkar')
{

		//Page header
	class PDF extends FPDF
	{

function Header()
		{	
		$this->SetFont('Arial','',14);
		$this->SetY(20);
$tampil=mysql_query("SELECT m.flightdate,f.flight,o.origin_code 
FROM manifestin as m,origin as o,flight as f
WHERE m.idorigin=o.idorigin AND m.idflight=f.idflight AND m.statusvoid='0' AND m.idmanifestin='$_POST[idm]'"); 
	
$p=mysql_fetch_array($tampil);

 			$this->SetFillColor(255,255,255);
$this->SetAligns(array('C')); 
$this->SetWidths(array(200)); 
			
if($_POST[i]=='1')
{			$this->Row(array('DAFTAR BONGKAR'));$this->ln(2);}
else
		{	$this->Row(array('DAFTAR TIMBUN'));$this->ln(2);}
$this->SetFont('Arial','',11);
$this->SetAligns(array('C')); 
$this->SetWidths(array(200)); 
$this->Row(array('PT. GAPURA ANGKASA'));$this->ln(5);
$this->SetFont('Arial','',9);
$this->SetX(10);
$this->SetAligns(array('L','L')); 
$this->SetWidths(array(40,40)); 
$this->Row(array('Tgl Bongkar',': '.ymd2dmy($p[flightdate])));
$this->SetWidths(array(40,40)); 
$this->Row(array('No Penerbangan',': '.$p[flight]));
$this->SetWidths(array(40,40)); 
$this->Row(array('Asal Penerbangan',': '.$p[origin_code]));
$this->SetWidths(array(200));
$this->SetAligns(array('L')); 
$this->Row(array('-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------'));
$this->SetAligns(array('C','C','C','C','C','C','C')); 
$this->SetWidths(array(10,20,20,15,20,40,40)); 
$this->Row(array('NO','#AWB','JML KEMASAN','BERAT (KGS)','NO/MERK KEMASAN','JENIS BARANG','CONSIGNEE'));
$this->SetWidths(array(200)); 
$this->SetAligns(array('L')); 
$this->Row(array('-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------'));
		}

	
		//Page footer
		function Footer()
		{
			//Position at 1.5 cm from bottom
			$this->SetY(-40);
			//Arial italic 8
			$this->SetFont('Arial','I',8);
			//Page number
$this->SetX(10);
$this->SetWidths(array(200));
$this->SetAligns(array('L')); 
$this->Row(array('-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------'));	
$this->SetWidths(array(200));
$this->SetAligns(array('L')); 
$this->Row(array('F.MES-KF-13 Page '.$this->PageNo().'/{nb}'));	
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
	$this->CheckPageBreak($h);
	//$this->CheckPageBreak($_POST[batas]);
	
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
	//if($this->GetY()+$h>$this->PageBreakTrigger)
	//echo($h);
	if($this->GetY()+$h>$this->PageBreakTrigger)
		{$this->AddPage();
		$this->SetAligns(array('C','L','R','R','C','L','L')); 
$this->SetWidths(array(10,25,10,20,20,45,60)); }
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
	//Instanciation of inherited class
	$pdf=new PDF('P','mm','A4');
	
	$pdf->AliasNbPages();
	//buka file
	$pdf->Open();
	
	//Disable automatic page break
$pdf->SetAutoPageBreak(true,$_POST[batas]);	
//$pdf->SetAutoPageBreak(true);
	
	//set nilai posisi y pada setiap halaman
/*	$y_axis_initial = 32;
	$y_axis1 = 32;
	//tinggi baris
	$row_height = 6;	
*/


	$pdf->AddPage();
//$pdf->SetX(50);
	//$y_axis = 32; // $y_axis_initial + $row_height;
/*
$smu=mysql_query("SELECT s.nosmu,i.berat as berat,i.koli as koli,
 s.nosmu, p.commodityap,con.consignee,p.idcommodityap,con.alamat 
 FROM consignee as con,isimanifestin as i,manifestin as m,commodity_ap as p, master_smu as s, commodity as c 
WHERE i.idmanifestin = m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND p.idcommodity = c.idcommodity AND s.iddestination<>'130' 
	 AND s.consignee=con.idconsignee AND m.idmanifestin='$_POST[idm]' order by i.idisimanifestin ASC"); 
	//AND p.idcommodityap<>'18' 
$smu2=mysql_query("SELECT s.nosmu,i.berat as berat,i.koli as koli,con.alamat,
 s.nosmu, p.commodityap,con.consignee,p.idcommodityap 
 FROM consignee as con,isimanifestin as i,manifestin as m,commodity_ap as p, master_smu as s, commodity as c 
WHERE i.idmanifestin = m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND p.idcommodity = c.idcommodity AND s.iddestination='130' 
	 AND m.idmanifestin='$_POST[idm]' AND s.consignee=con.idconsignee order by i.idisimanifestin ASC"); 
	//AND p.idcommodityap<>'18' 
*/
$smu=mysql_query("SELECT i.nopos,s.nosmu,i.berat as berat,i.koli as koli,
 s.nosmu, p.commodityap,con.consignee,p.idcommodityap,con.alamat 
 FROM consignee as con,isimanifestin as i,manifestin as m,commodity_ap as p, master_smu as s, commodity as c 
WHERE i.idmanifestin = m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND p.idcommodity = c.idcommodity AND s.consignee=con.idconsignee AND m.idmanifestin='$_POST[idm]' order by i.nopos ASC"); 



$no=1;
	$subkoli=0;$subkg=0;
	
	while ($x=mysql_fetch_array($smu))
				{
if($x[idcommodityap]=='18'){$noawb=format_nopos($x[nosmu]);} else {$noawb=format_awb($x[nosmu]);}
$pdf->SetX(10);
$pdf->SetAligns(array('C','L','R','R','C','L','L')); 
$pdf->SetWidths(array(10,25,10,20,20,45,60)); 
$pdf->Row(array($x[nopos],$noawb,number_format($x[koli], 0, '.', '.'),number_format($x[berat], 1, ',', '.'),'Koli',$x[commodityap],$x[consignee].' '.$x[alamat]));
$subkoli+=$x[koli];$subkg+=$x[berat];
$no++;
}
	/*
	while ($x=mysql_fetch_array($smu2))
				{
if($x[idcommodityap]=='18'){$noawb=format_nopos($x[nosmu]);} else {$noawb=format_awb($x[nosmu]);}
$pdf->SetX(10);
$pdf->SetAligns(array('C','L','R','R','C','L','L')); 
$pdf->SetWidths(array(10,25,10,20,20,45,60));
$pdf->Row(array($no,$noawb,number_format($x[koli], 0, '.', '.'),number_format($x[berat], 1, ',', '.'),'Koli',$x[commodityap],$x[consignee].' '.$x[alamat]));
$subkoli+=$x[koli];$subkg+=$x[berat];
$no++;
}
*/
/*
$pdf->SetWidths(array(200));$pdf->Ln(5);
$pdf->SetAligns(array('L')); 
$pdf->Row(array('-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------'));
*/
/*
$nama=mysql_fetch_array(mysql_query("SELECT u.nama_lengkap, 
u.code, u.nipp from user as u where u.id_user='$_SESSION[namauser]'"));
*/
$pdf->Ln(10);
$pdf->SetFillColor(255,255,255);
$pdf->SetX(150);
$tgl1=date("d-m-Y");
$pdf->Cell(120,5,'Medan,'.$tgl1,0,0,'L',1);$pdf->Ln(5);$pdf->SetX(150);
$pdf->Cell(120,5,'PT. Gapura Angkasa',0,0,'L',1);$pdf->Ln(20);
$pdf->SetX(150);$pdf->Cell(120,5,$nama[nama_lengkap],0,0,'L',1);
$pdf->Ln(5);$pdf->SetX(150);
$pdf->Cell(120,5,'ID NBR. '.$nama[nipp],0,0,'L',1);

$pdf->SetX(150);$pdf->Cell(120,5,'AGUS SUCAHYA',0,0,'L',1);



$pdf->Output();
}
//end of cetak bongkar muat		
//cetak noa
if ($module=='cetaknoa')
{

		//Page header
	class PDF extends FPDF
	{
		//Page header
function Header()
		{	
		$this->SetTopMargin(5);
		$this->SetLeftMargin(10);			
		$this->SetFont('Arial','',10);
	
		}
		
		//Page footer
		function Footer()
		{
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
	$this->CheckPageBreak($h);
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
	//Instanciation of inherited class
	$pdf=new PDF('P','mm','A4');
	
	$pdf->AliasNbPages();
	//buka file
	$pdf->Open();
	
	//Disable automatic page break
	$pdf->SetAutoPageBreak(true,10);
	
	//set nilai posisi y pada setiap halaman
	$y_axis_initial = 32;
	$y_axis1 = 32;
	//tinggi baris
	$row_height = 6;	

	$y_axis = 32; // $y_axis_initial + $row_height;
$tampil=mysql_fetch_array(mysql_query("SELECT m.flightdate,f.flight
FROM manifestin as m,flight as f,isimanifestin as i
WHERE m.idflight=f.idflight AND m.statusvoid='0' AND i.idmanifestin=m.idmanifestin AND i.idisimanifestin='$_GET[id]'")); 
	
$smu=mysql_query("SELECT s.nosmu,i.berat as berat,i.koli as koli, s.nosmu, p.commodityap,con.consignee,shi.shipper,p.idcommodityap 
 FROM isimanifestin as i,manifestin as m,commodity_ap as p, master_smu as s, commodity as c,consignee as con, shipper as shi 
WHERE i.idmanifestin = m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND p.idcommodity = c.idcommodity AND s.consignee=con.idconsignee AND s.shipper=shi.idshipper
	 AND i.idisimanifestin='$_GET[id]' "); 
$no=1;
	$subkoli=0;$subkg=0;

	$pdf->AddPage();
 			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','',10);		
	while ($x=mysql_fetch_array($smu))
				{
if($x[idcommodityap]=='18'){$noawb=format_nopos($x[nosmu]);} else {$noawb=format_awb($x[nosmu]);}
$pdf->SetY(35);
$pdf->SetX(40);
$pdf->SetAligns(array('L')); 
$pdf->SetWidths(array(150)); 
$pdf->Row(array($x[consignee]));
$pdf->SetY(65);
$pdf->SetX(50);
$pdf->Row(array($noawb));$pdf->ln();
$pdf->SetX(50);
$pdf->Row(array($tampil[flight].'/'.ymd2dmy($tampil[flightdate])));$pdf->ln();
$pdf->SetX(50);
$pdf->Row(array(number_format($x[koli], 0, '.', '.').' koli /'.number_format($x[berat], 1, ',', '.').' kg'));$pdf->ln();
$pdf->SetX(50);
$pdf->Row(array($x[shipper]));$pdf->ln();
$no++;
}

$nama=mysql_fetch_array(mysql_query("SELECT u.nama_lengkap, u.code, u.nipp from user as u,manifestin as m,isimanifestin as i where u.id_user=m.username AND i.idmanifestin=m.idmanifestin AND i.idisimanifestin='$_GET[id]'"));


$pdf->SetY(130);$pdf->SetX(150);
$pdf->Cell(120,5,$nama[nama_lengkap].'/MESKFXH',0,0,'L',1);
$pdf->Ln();$pdf->SetX(150);
$pdf->Cell(120,5,'ID NBR. '.$nama[nipp],0,0,'L',1);

$pdf->Output();
}
//end of noa


//cetak bc
if ($module=='cetakbc')
{

		//Page header
	class PDF extends FPDF
	{
		//Page header
function Header()
		{	
		$this->SetTopMargin(5);
		$this->SetLeftMargin(10);			
		$this->SetFont('Arial','',10);
	
		}
		
		//Page footer
		function Footer()
		{
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
	$this->CheckPageBreak($h);
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
	//Instanciation of inherited class
	$pdf=new PDF('P','mm','legal');
	
	$pdf->AliasNbPages();
	//buka file
	$pdf->Open();
	
	//Disable automatic page break
	$pdf->SetAutoPageBreak(true,10);
	
	//set nilai posisi y pada setiap halaman
	$y_axis_initial = 32;
	$y_axis1 = 32;
	//tinggi baris
	$row_height = 6;	

	$y_axis = 32; // $y_axis_initial + $row_height;
$tampil=mysql_fetch_array(mysql_query("SELECT m.flightdate,f.flight,c.cus_desc
FROM manifestin as m,flight as f,isimanifestin as i,customer as c
WHERE m.idflight=f.idflight AND m.statusvoid='0' 
AND c.idcustomer=f.idcustomer AND i.idmanifestin=m.idmanifestin 
AND i.idisimanifestin='$_GET[id]'")); 

/*
$kpb=mysql_fetch_array(mysql_query("select m.iddestination1,
m.iddestination2,m.iddestination3 from isimanifestin as i, 
manifestin as m where m.idmanifestin=i.idmanifestin 
AND i.idisimanifestin='$_GET[id]'"));
if($kpb[iddestination2]==$kpb[iddestination3])
{$kp=mysql_fetch_array(mysql_query("select * from destination 
where iddestination='$kpb[iddestination3]'"));
$kpbc=$kp[kpbc];
}
else
{
$kp1=mysql_fetch_array(mysql_query("select * from destination 
where iddestination='$kpb[iddestination3]'"));
$kp2=mysql_fetch_array(mysql_query("select * from destination where 
iddestination='$kpb[iddestination2]'"));
$kpbc=$kp1[kpbc].' via '.$kp2[kpbc];}
*/


$smu=mysql_query("SELECT s.nosmu,s.berat as sberat,s.koli as skoli,i.berat as berat,d.kpbc,d.nokpbc,i.koli as koli, 
s.nosmu,s.tglsmu, p.commodityap,con.consignee,con.alamat as alamatc,shi.shipper,shi.alamat as alamats,p.idcommodityap,d.dest_code,
d.description,cf.nama,cf.alamat,cf.npwp,o.origin_code,r.region as descriptiono,d.nokpbc,d.kpbc
 FROM isimanifestin as i,manifestin as m,commodity_ap as p, 
master_smu as s, commodity as c, destination as d,consignee as con,shipper as shi,
connectingflight as cf, origin as o,region as r
WHERE i.idmanifestin = m.idmanifestin AND i.idmastersmu=s.idmastersmu 
AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap 
AND p.idcommodity = c.idcommodity AND s.iddestination=d.iddestination 
AND s.consignee=con.idconsignee AND s.shipper=shi.idshipper 
AND s.idconnectingflight=cf.idconnectingflight AND s.idorigin=o.idorigin 
AND o.idregion=r.idregion
	 AND i.idisimanifestin='$_GET[id]' "); 

$or=mysql_fetch_array(mysql_query("select o.description,o.origin_code from origin as o, master_smu as s 
where o.idorigin=s.idorigin"));
$no=1;
	$subkoli=0;$subkg=0;

	$pdf->AddPage();
 			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','',9);		
$x=mysql_fetch_array($smu);
if($x[idcommodityap]=='18'){$noawb=format_nopos($x[nosmu]);} else {$noawb=format_awb($x[nosmu]);}
//$pdf->SetX(30);
$pdf->SetY(60);
$pdf->SetAligns(array('L')); 
$pdf->SetWidths(array(80)); 
$pdf->Row(array($x[shipper]."\n".$x[alamats]));
$pdf->ln(5);
//$pdf->SetX(30);
$pdf->SetAligns(array('L')); 
$pdf->SetWidths(array(80)); 
$pdf->Row(array($x[consignee]."\n".$x[alamatc]));
$pdf->ln(9);
//$pdf->SetX(60);
$pdf->SetAligns(array('L')); 
$pdf->SetWidths(array(40)); 
$pdf->Row(array($x[npwp]));
$pdf->ln(5);
//$pdf->SetX(30);
$pdf->SetAligns(array('L')); 
$pdf->SetWidths(array(60)); 
$pdf->Row(array($x[alamat]));
$pdf->ln(4);
$pdf->SetX(65);
$pdf->SetAligns(array('L')); 
$pdf->SetWidths(array(60)); 
$pdf->Row(array('4'));
$pdf->ln(7);
//$pdf->SetX(30);
//$pdf->SetX(30);
$pdf->SetAligns(array('L','L')); 
$pdf->SetWidths(array(60,40)); 
//$pdf->Row(array($tampil[cus_desc]));
$pdf->Row(array($x[nama],'MES'));
$pdf->ln(5);
//$pdf->SetX(30);
$pdf->SetAligns(array('L','L')); 
$pdf->SetWidths(array(60,40)); 
$pdf->Row(array($x[description],$x[dest_code],));
//$pdf->SetX(30);
$pdf->ln(10);
$pdf->SetAligns(array('L','L','L')); 
$pdf->SetWidths(array(60,40,40)); 
if($x[koli]<>$x[skoli])
{$pdf->Row(array('TANPA MERK',$x[koli].' / '.$x[skoli],' KOLI'));} else
{$pdf->Row(array('TANPA MERK',$x[koli],' KOLI'));} 
$pdf->SetX(1);

$pdf->ln(40);
$pdf->SetAligns(array('L','L','C','C')); 
$pdf->SetWidths(array(10,80,40,40)); 
if($x[koli]<>$x[skoli])
{
$pdf->Row(array('1',$x[commodityap],$x[koli].' / '.$x[skoli].' Koli',$x[berat].' / '.$x[sberat].' Kgs'));} else
{
$pdf->Row(array('1',$x[commodityap],$x[koli].' Koli',$x[berat].' Kgs'));
}
$pdf->SetXY(125,60);
$pdf->SetAligns(array('L','L')); 
$pdf->SetWidths(array(60,40)); 
$pdf->Row(array('KPBC Medan','080 100'));
$pdf->SetXY(110,70);
$pdf->SetAligns(array('L','L')); 
$pdf->SetWidths(array(70,30)); 
$pdf->Row(array($x[kpbc],$x[nokpbc]));
$pdf->SetXY(110,70);
//$pdf->Row(array($x[dest_code],$x[description]));$pdf->ln(5);

//jika Destinasi 2 dan dstinsdi 3 sama maka
//yang 	dipake NoKPBC destinasi 3 tanpa via
$pdf->SetXY(110,75);$pdf->SetAligns(array('L')); 
$pdf->SetWidths(array(60)); 
//$pdf->Row(array($x[kpbc]));
$pdf->SetXY(130,85);
$pdf->SetAligns(array('L','L')); 
$pdf->SetWidths(array(60,40)); 
$pdf->Row(array('EX. '.$tampil[flight].'/'.ymd2dmy($tampil[flightdate])));
$pdf->SetXY(140,97);
$pdf->SetAligns(array('L','L')); 
$pdf->SetWidths(array(45,40)); 
$pdf->Row(array($x[origin_code],$x[descriptiono]));$pdf->ln(5);
//$pdf->Row(array('SYDNEY','ASIA'));
$pdf->SetXY(140,102);
$pdf->SetAligns(array('L','L')); 
$pdf->SetWidths(array(45,40)); 
$pdf->Row(array($noawb,ymd2dmy($x[tglsmu])));
$pdf->SetXY(160,107);
$pdf->SetAligns(array('L','L')); 
$pdf->SetWidths(array(100)); 
$pdf->Row(array($_GET[pos]));
$pdf->SetXY(155,112);
$pdf->SetAligns(array('L','L')); 
$pdf->SetWidths(array(100)); 
$bilang=terbilang($_GET[pos],0);
$pdf->Row(array('( '.$bilang.' )'));
$pdf->SetXY(110,125);
$pdf->SetAligns(array('L','L','L')); 
$pdf->SetWidths(array(60)); 
if($x[koli]<>$x[skoli])
{
	$pdf->Row(array($x[berat].' / '.$x[sberat].' Kgs'));
}
else
{
$pdf->Row(array($x[berat].' Kgs'));
}
$tgl1=date("d-m-Y");
$pdf->SetXY(150,280);
$pdf->SetAligns(array('L','L','L')); 
$pdf->SetWidths(array(60)); 
$pdf->Row(array($tgl1));


/*$nama=mysql_fetch_array(mysql_query("SELECT u.nama_lengkap, u.code, u.nipp from user as u,manifestin as m,isimanifestin as i where u.id_user=m.username AND i.idmanifestin=m.idmanifestin AND i.idisimanifestin='$_GET[id]'"));

$pdf->Cell(120,5,$nama[nama_lengkap].'/DPSKFXH',0,0,'L',1);$pdf->Ln();
$pdf->Cell(120,5,'ID NBR. '.$nama[nipp],0,0,'L',1);
*/
$pdf->Output();
}
//end of bc


//cetak bcDN
if ($module=='cetakbcdn')
{

		//Page header
	class PDF extends FPDF
	{
		//Page header
function Header()
		{	
		$this->SetTopMargin(5);
		$this->SetLeftMargin(10);			
		$this->SetFont('Arial','',10);
	
		}
		
		//Page footer
		function Footer()
		{
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
	$this->CheckPageBreak($h);
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
	//Instanciation of inherited class
	$pdf=new PDF('P','mm','legal');
	
	$pdf->AliasNbPages();
	//buka file
	$pdf->Open();
	
	//Disable automatic page break
	$pdf->SetAutoPageBreak(true,10);
	
	//set nilai posisi y pada setiap halaman
	$y_axis_initial = 32;
	$y_axis1 = 32;
	//tinggi baris
	$row_height = 6;	

	$y_axis = 32; // $y_axis_initial + $row_height;
$tampil=mysql_fetch_array(mysql_query("SELECT m.flightdate,f.flight,c.cus_desc
FROM manifestin as m,flight as f,isimanifestin as i,customer as c
WHERE m.idflight=f.idflight AND m.statusvoid='0' 
AND c.idcustomer=f.idcustomer AND i.idmanifestin=m.idmanifestin 
AND i.idisimanifestin='$_GET[id]'")); 

/*
$kpb=mysql_fetch_array(mysql_query("select m.iddestination1,
m.iddestination2,m.iddestination3 from isimanifestin as i, 
manifestin as m where m.idmanifestin=i.idmanifestin 
AND i.idisimanifestin='$_GET[id]'"));
if($kpb[iddestination2]==$kpb[iddestination3])
{$kp=mysql_fetch_array(mysql_query("select * from destination 
where iddestination='$kpb[iddestination3]'"));
$kpbc=$kp[kpbc];
}
else
{
$kp1=mysql_fetch_array(mysql_query("select * from destination 
where iddestination='$kpb[iddestination3]'"));
$kp2=mysql_fetch_array(mysql_query("select * from destination where 
iddestination='$kpb[iddestination2]'"));
$kpbc=$kp1[kpbc].' via '.$kp2[kpbc];}
*/


$smu=mysql_query("SELECT d.tps,s.nosmu,s.berat as sberat,s.koli as skoli,i.berat as berat,d.kpbc,d.nokpbc,i.koli as koli, 
s.nosmu,s.tglsmu, p.commodityap,con.consignee,con.alamat as alamatc,shi.shipper,shi.alamat as alamats,p.idcommodityap,d.dest_code,
d.description,cf.nama,cf.alamat,cf.npwp,o.origin_code,r.region as descriptiono,d.nokpbc,d.kpbc
 FROM isimanifestin as i,manifestin as m,commodity_ap as p, 
master_smu as s, commodity as c, destination as d,consignee as con,shipper as shi,
connectingflight as cf, origin as o,region as r
WHERE i.idmanifestin = m.idmanifestin AND i.idmastersmu=s.idmastersmu 
AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap 
AND p.idcommodity = c.idcommodity AND s.iddestination=d.iddestination 
AND s.consignee=con.idconsignee AND s.shipper=shi.idshipper 
AND s.idconnectingflight=cf.idconnectingflight AND s.idorigin=o.idorigin 
AND o.idregion=r.idregion
	 AND i.idisimanifestin='$_GET[id]' "); 

$or=mysql_fetch_array(mysql_query("select o.description,o.origin_code from origin as o, master_smu as s 
where o.idorigin=s.idorigin"));
$no=1;
	$subkoli=0;$subkg=0;

	$pdf->AddPage();
 			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','',9);		
$x=mysql_fetch_array($smu);
if($x[idcommodityap]=='18'){$noawb=format_nopos($x[nosmu]);} else {$noawb=format_awb($x[nosmu]);}
//$pdf->SetX(30);
$pdf->SetY(50);$pdf->SetX(50);
$pdf->SetAligns(array('L')); 
$pdf->SetWidths(array(80)); 
$pdf->Row(array('010611705904001'));$pdf->SetX(50);
$pdf->Row(array('PT. GAPURA ANGKASA'."\n".'Bandara Polonia Medan'));
$pdf->ln(20);
//$pdf->SetY(30);
$pdf->SetAligns(array('L')); 
$pdf->SetWidths(array(130)); 
$pdf->Row(array($x[tps]));
$pdf->ln(9);
$pdf->SetAligns(array('L')); 
$pdf->SetWidths(array(40)); $pdf->SetX(50);
$pdf->Row(array($x[npwp]));
$pdf->ln(5);
$pdf->SetAligns(array('L')); 
$pdf->SetWidths(array(60)); $pdf->SetX(10);
$pdf->Row(array($x[alamat]));
$pdf->ln(4);
$pdf->SetX(65);
$pdf->SetAligns(array('L','L')); 
$pdf->SetWidths(array(60,40)); 
$pdf->SetX(10);$pdf->ln(10);
$pdf->Row(array('GARUDA INDONESIA'));
$pdf->ln(20);
$pdf->SetAligns(array('L','L','L')); 
$pdf->SetWidths(array(60,40,40)); 
if($x[koli]<>$x[skoli])
{$pdf->Row(array('TANPA MERK',$x[koli].' / '.$x[skoli],' KOLI'));} else
{$pdf->Row(array('TANPA MERK',$x[koli],' KOLI'));} 
$pdf->SetX(1);

$pdf->ln(40);
$pdf->SetAligns(array('L','L','C','C')); 
$pdf->SetWidths(array(10,80,40,40)); 
if($x[koli]<>$x[skoli])
{
$pdf->Row(array('1',$x[commodityap],$x[koli].' / '.$x[skoli].' Koli',$x[berat].' / '.$x[sberat].' Kgs'));} else
{
$pdf->Row(array('1',$x[commodityap],$x[koli].' Koli',$x[berat].' Kgs'));
}
$pdf->SetXY(125,55);
$pdf->SetAligns(array('L','L')); 
$pdf->SetWidths(array(50,40)); 
$pdf->Row(array('KPBC Medan','080100'));
$pdf->SetXY(110,67);
$pdf->SetAligns(array('L','L')); 
$pdf->SetWidths(array(70,40)); 
$pdf->Row(array($x[kpbc],$x[nokpbc]));
//$pdf->Row(array($x[kpbc]));
$pdf->SetXY(125,80);
$pdf->SetAligns(array('L','L')); 
$pdf->SetWidths(array(60,40)); 
$pdf->Row(array('EX. '.$tampil[flight].'/'.ymd2dmy($tampil[flightdate])));
$pdf->SetXY(125,90);
$pdf->SetAligns(array('L','L')); 
$pdf->SetWidths(array(45,40)); 
$pdf->Row(array($x[origin_code],$x[descriptiono]));$pdf->ln(5);
//$pdf->Row(array('SYDNEY','ASIA'));
$pdf->SetXY(125,95);
$pdf->SetAligns(array('L','L')); 
$pdf->SetWidths(array(45,40)); 
$pdf->Row(array($noawb,ymd2dmy($x[tglsmu])));
$pdf->SetXY(168,104);
$pdf->SetAligns(array('L','L')); 
$bilang=terbilang($_GET[pos],0);
$pdf->SetWidths(array(10)); 
$pdf->Row(array($_GET[pos]));
$pdf->SetXY(164,108);
$pdf->SetWidths(array(30));
$pdf->Row(array('( '.$bilang.' )'));
$pdf->SetXY(155,112);
$pdf->SetAligns(array('L','L')); 
$pdf->SetWidths(array(100)); 
$pdf->SetXY(110,125);
$pdf->SetAligns(array('L','L','L')); 
$pdf->SetWidths(array(60)); 
if($x[koli]<>$x[skoli])
{
	$pdf->Row(array($x[berat].' / '.$x[sberat].' Kgs'));
}
else
{
$pdf->Row(array($x[berat].' Kgs'));
}
$tgl1=date("d-m-Y");
$pdf->SetXY(145,272);
$pdf->SetAligns(array('L','L','L')); 
$pdf->SetWidths(array(60)); 
$pdf->Row(array($tgl1));


/*$nama=mysql_fetch_array(mysql_query("SELECT u.nama_lengkap, u.code, u.nipp from user as u,manifestin as m,isimanifestin as i where u.id_user=m.username AND i.idmanifestin=m.idmanifestin AND i.idisimanifestin='$_GET[id]'"));

$pdf->Cell(120,5,$nama[nama_lengkap].'/DPSKFXH',0,0,'L',1);$pdf->Ln();
$pdf->Cell(120,5,'ID NBR. '.$nama[nipp],0,0,'L',1);
*/
$pdf->Output();
}
//end of bcdn


//---------------Menambah Data Consignee---------------------------------------------------------
if ($module=='consignee' AND $act=='tambah')
{
  mysql_query("INSERT INTO consignee(consignee,alamat) 
	                       VALUES('$_POST[consignee]','$_POST[alamat]')");
  header('location:popupconsignee.php');
} 
//---------------End of Menambah Data consignee--------------------------------------------------
//---------------Edit Data consignee---------------------------------------------------------
if ($module=='consignee' AND $act=='edit')
{
 mysql_query("UPDATE consignee SET consignee = '$_POST[consignee]',alamat='$_POST[alamat]'
 				WHERE idconsignee      = '$_POST[id]'");
  header('location:popupconsignee.php');
} 
//---------------End of Edit Data consignee--------------------------------------------------
//---------------Menghapus Data Commocity -------------------------------------------------
if ($module=='consignee' AND $act=='hapus')
{
  mysql_query("DELETE FROM consignee WHERE idconsignee  = '$_GET[id]'");
  header('location:popupconsignee.php');
}
//---------------End of Menghapus Data consignee -------------------------------------------------
//---------------Menambah Data shipper---------------------------------------------------------
if ($module=='shipper' AND $act=='tambah')
{
  mysql_query("INSERT INTO shipper(shipper,alamat) 
	                       VALUES('$_POST[shipper]','$_POST[alamat]')");
  header('location:popupshipper.php');
} 
//---------------End of Menambah Data shipper--------------------------------------------------
//---------------Edit Data shipper---------------------------------------------------------
if ($module=='shipper' AND $act=='edit')
{
 mysql_query("UPDATE shipper SET shipper = '$_POST[shipper]',alamat='$_POST[alamat]'
 				WHERE idshipper      = '$_POST[id]'");
  header('location:popupshipper.php');
} 
//---------------End of Edit Data shipper--------------------------------------------------
//---------------Menghapus Data Commocity -------------------------------------------------
if ($module=='shipper' AND $act=='hapus')
{
  mysql_query("DELETE FROM shipper WHERE idshipper  = '$_GET[id]'");
  header('location:popupshipper.php');
}
//---------------End of Menghapus Data shipper -------------------------------------------------

//---------------Menghapus Data connectingflight  -------------------------------------------------
if ($module=='connectingflight' AND $act=='hapus')
{
  mysql_query("DELETE FROM connectingflight WHERE idconnectingflight  = '$_GET[id]'");
  header('location:media.php?module='.$module);
}
//---------------End of Menghapus Data connectingflight -------------------------------------------------

//---------------Menambah Data connectingflight---------------------------------------------------------
if ($module=='connectingflight' AND $act=='tambah')
{
  mysql_query("INSERT INTO connectingflight(nama,alamat,npwp) 
	                       VALUES('$_POST[nama]','$_POST[alamat]','$_POST[npwp]')");
  header('location:media.php?module='.$module);
} 
//---------------End of Menambah Data connectingflight--------------------------------------------------

//---------------Edit Data connectingflight---------------------------------------------------------
if ($module=='connectingflight' AND $act=='edit')
{
 mysql_query("UPDATE connectingflight SET nama = '$_POST[nama]',
 				alamat= '$_POST[alamat]',npwp='$_POST[npwp]'
				WHERE idconnectingflight      = '$_POST[id]'");		
  header('location:media.php?module='.$module);
} 
//---------------End of Edit Data connectingflight--------------------------------------------------

//---------------Menambah Data Input Output---------------------------------------------------------
if ($module=='inputoutput' AND $act=='tambah')
{
	$t=my2date($_POST[tglawal]);
 mysql_query("UPDATE isimanifestin SET nokeluar = '$_POST[no]',
 		statuskeluar = '$_POST[b]',tglkeluar = '$t'
				WHERE idisimanifestin      = '$_POST[id]'");
header('location:media.php?module=isimanifestimport&idm='.$_POST[idm].'&r='.$_POST[r].'&f='.$_POST[f].'&d='.$_POST[d]);
} 
//---------------End of Menambah Data Input Output--------------------------------------------------

//---------------Mengedit Data Input Output---------------------------------------------------------
if ($module=='inputoutput' AND $act=='edit')
{
	$t=my2date($_POST[tglawal]);
 mysql_query("UPDATE isimanifestin SET nokeluar = '$_POST[no]',
 		statuskeluar = '$_POST[b]',tglkeluar = '$t'
				WHERE idisimanifestin      = '$_POST[id]'");
  header('location:media.php?module=isimanifestimport&idm='.$_POST[idm].'&r='.$_POST[r].'&f='.$_POST[f].'&d='.$_POST[d]);
} 
//---------------End of Mengedit Data Input Output--------------------------------------------------
//cetak kuitansi
if ($module=='cetakkuitansi')
{

		//Page header
	class PDF extends FPDF
	{
		//Page header
function Header()
		{	
		$this->SetTopMargin(5);
		$this->SetLeftMargin(10);			
		$this->SetFont('Arial','',10);
	
		}
		
		//Page footer
		function Footer()
		{
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
	$this->CheckPageBreak($h);
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
	//Instanciation of inherited class
	$pdf=new PDF('P','mm','A4');
	
	$pdf->AliasNbPages();
	//buka file
	$pdf->Open();
	
	//Disable automatic page break
	$pdf->SetAutoPageBreak(true,10);
	
	//set nilai posisi y pada setiap halaman
	$y_axis_initial = 32;
	$y_axis1 = 32;
	//tinggi baris
	$row_height = 6;	

	$y_axis = 32; // $y_axis_initial + $row_height;

$smu=mysql_query("SELECT s.nosmu,i.berat as berat,i.koli as koli, s.nosmu, p.commodityap,con.consignee,shi.shipper,p.idcommodityap 
 FROM isimanifestin as i,manifestin as m,commodity_ap as p, master_smu as s, commodity as c,consignee as con, shipper as shi 
WHERE i.idmanifestin = m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND p.idcommodity = c.idcommodity AND s.consignee=con.idconsignee AND s.shipper=shi.idshipper
	 AND i.idisimanifestin='$_GET[id]' "); 
$no=1;
	$subkoli=0;$subkg=0;

	$pdf->AddPage();
 			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','',10);		
	while ($x=mysql_fetch_array($smu))
				{
if($x[idcommodityap]=='18'){$noawb=format_nopos($x[nosmu]);} else {$noawb=format_awb($x[nosmu]);}
$pdf->SetY(35);
$pdf->SetX(40);
$pdf->SetAligns(array('L')); 
$pdf->SetWidths(array(150)); 
$pdf->Row(array($x[consignee]));
$pdf->SetY(65);
$pdf->SetX(50);
$pdf->Row(array('#LIMA RIBU RUPIAH#'));$pdf->ln();
$pdf->SetX(50);
$pdf->Row(array('Biaya ADM untuk AWB No. '.$noawb));$pdf->ln();
$pdf->SetX(50);
$pdf->Row(array('5.000,-'));$pdf->ln();
}

$nama=mysql_fetch_array(mysql_query("SELECT nama_lengkap, code, nipp from user 
where id_user= '$_SESSION[namauser]'"));


$pdf->SetY(130);$pdf->SetX(150);
$pdf->Cell(120,5,$nama[nama_lengkap].'/MESKFXH',0,0,'L',1);
$pdf->Ln();$pdf->SetX(150);
$pdf->Cell(120,5,'ID NBR. '.$nama[nipp],0,0,'L',1);

$pdf->Output();
}
//end of kuitansi
//cetak noa
if ($module=='cetakdo')
{

		//Page header
	class PDF extends FPDF
	{
		//Page header
function Header()
		{	
		$this->SetTopMargin(5);
		$this->SetLeftMargin(15);			
		$this->SetFont('Arial','',10);
	
		}
		
		//Page footer
		function Footer()
		{
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
	$this->CheckPageBreak($h);
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
	//Instanciation of inherited class
	$pdf=new PDF('P','mm','A4');
	
	$pdf->AliasNbPages();
	//buka file
	$pdf->Open();
	
	//Disable automatic page break
	$pdf->SetAutoPageBreak(true,10);
	
	//set nilai posisi y pada setiap halaman
	$y_axis_initial = 32;
	$y_axis1 = 32;
	//tinggi baris
	$row_height = 6;	

	$y_axis = 32; // $y_axis_initial + $row_height;
	
	$tgl1=date("d-m-Y H:m:s");
	
$tampil=mysql_fetch_array(mysql_query("SELECT m.flightdate,f.flight
FROM manifestin as m,flight as f,isimanifestin as i
WHERE m.idflight=f.idflight AND m.statusvoid='0' AND i.idmanifestin=m.idmanifestin AND i.idisimanifestin='$_GET[id]'")); 

$y=mysql_fetch_array(mysql_query("SELECT nodb,fee,penerima,alamat from deliverybill where idisimanifestin='$_GET[id]'"));	
$x=mysql_fetch_array(mysql_query("SELECT s.nosmu,i.berat as berat,i.koli as koli, s.nosmu, p.commodityap,con.consignee,shi.shipper,p.idcommodityap 
 FROM isimanifestin as i,manifestin as m,commodity_ap as p, master_smu as s, commodity as c,consignee as con, shipper as shi 
WHERE i.idmanifestin = m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND p.idcommodity = c.idcommodity AND s.consignee=con.idconsignee AND s.shipper=shi.idshipper
	 AND i.idisimanifestin='$_GET[id]' ")); 
	
	if($x[idcommodityap]=='18'){$noawb=format_nopos($x[nosmu]);} else {$noawb=format_awb($x[nosmu]);}
	
$no=1;
	$subkoli=0;$subkg=0;

	$pdf->AddPage();
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('arial','',8);
$pdf->SetY(2);$pdf->SetX(10);
$pdf->SetAligns(array('R')); 
$pdf->SetWidths(array(60)); 
$pdf->Row(array($tgl1));$pdf->Ln(1);$pdf->SetFont('arial','B',9);
$pdf->SetX(10);
$pdf->SetAligns(array('R')); 
$pdf->SetWidths(array(60)); 
$pdf->Row(array('DO No. '.$y[nodb]));$pdf->Ln(5);
$pdf->SetX(10);$pdf->SetAligns(array('C')); 
$pdf->SetWidths(array(60)); 
$pdf->SetFont('arial','',9);			
$pdf->Row(array('GAPURA ANGKASA,PT'));$pdf->Ln(1);
$pdf->SetX(10);$pdf->SetAligns(array('C')); 
$pdf->SetWidths(array(60)); 
$pdf->Row(array('BRANCH OFFICE Polonia-Medan'));
$pdf->Ln(1);
$pdf->SetX(10);$pdf->SetAligns(array('C')); 
$pdf->SetWidths(array(60));$pdf->SetFont('arial','',9);		 
$pdf->Row(array('IMPORT DEPARTMENT Ph:061-000000 EXT.5309'));$pdf->Ln(1);$pdf->SetX(10);$pdf->SetAligns(array('C')); 
$pdf->SetWidths(array(60));$pdf->SetFont('arial','',9);		 
$pdf->Row(array('------------------------------------------------------'));$pdf->Ln(1);
$pdf->SetX(10);$pdf->SetAligns(array('C')); 
$pdf->SetWidths(array(60));$pdf->SetFont('arial','B',10);		 
$pdf->Row(array('AWB DELIVERY ORDER'));$pdf->Ln(1);
$pdf->SetX(10);$pdf->SetAligns(array('C')); 
$pdf->SetWidths(array(60));$pdf->SetFont('arial','',9);		 
$pdf->Row(array('------------------------------------------------------'));$pdf->Ln(1);


$pdf->SetFont('arial','',9);	
$pdf->SetX(10);$pdf->SetAligns(array('L')); 
$pdf->SetWidths(array(20,5,40)); 
$pdf->Row(array('AWB No.',': ',$noawb));$pdf->Ln(1);
$pdf->SetX(10);$pdf->SetAligns(array('L')); 
$pdf->SetWidths(array(20,5,40)); 
$pdf->Row(array('Flight No.',': ',$tampil[flight]));$pdf->Ln(1);
$pdf->SetX(10);$pdf->SetAligns(array('L')); 
$pdf->SetWidths(array(20,5,40)); 
$pdf->Row(array('Date of Arr.',': ',ymd2dmy($tampil[flightdate])));$pdf->Ln(1);
$pdf->SetX(10);$pdf->SetAligns(array('L')); 
$pdf->SetWidths(array(20,5)); 
$pdf->Row(array('Consignee',': '));$pdf->SetX(10);$pdf->SetAligns(array('L'));
$pdf->SetWidths(array(60)); $pdf->Row(array($x[consignee]));
$pdf->Ln(1);
$pdf->SetX(10);$pdf->SetAligns(array('L')); 
$pdf->SetWidths(array(20,5)); 
$pdf->Row(array('Penerima : '));$pdf->SetX(10);$pdf->SetAligns(array('L'));
$pdf->SetWidths(array(60)); $pdf->Row(array($y[penerima]));
$pdf->Ln(1);
$pdf->SetX(10);$pdf->SetAligns(array('L')); 
$pdf->SetWidths(array(40,5)); 
$pdf->Row(array('Alamat Penerima : '));$pdf->SetX(10);$pdf->SetAligns(array('L'));
$pdf->SetWidths(array(60)); $pdf->Row(array($y[alamat]));
$pdf->Ln(1);
$pdf->SetX(10);$pdf->SetAligns(array('C','C','L')); 
$pdf->SetWidths(array(10,15,25)); 
$pdf->SetFont('arial','B',9);	
$pdf->Row(array('PCS','KGS','COMMODITY'));
$pdf->ln(1);$pdf->SetFont('arial','',9);	
$pdf->SetX(10);
$pdf->SetAligns(array('C','C','L')); 
$pdf->SetWidths(array(10,15,40));
$pdf->Row(array(number_format($x[koli], 0, '.', '.'),number_format($x[berat], 1, ',', '.'),$x[commodityap],));
$pdf->ln();$pdf->SetFont('arial','B',9);
$pdf->SetX(10);$pdf->SetAligns(array('C')); 
$pdf->SetWidths(array(60));$pdf->SetFont('arial','',9);		 
$pdf->Row(array('------------------------------------------------------'));$pdf->Ln(1);
$pdf->SetX(10);$pdf->SetAligns(array('C')); 
$pdf->SetWidths(array(60)); 
$pdf->Row(array('CHARGE OF AWB DELIVERY'));$pdf->Ln(1);$pdf->SetFont('arial','',9);
$pdf->SetX(10);$pdf->SetAligns(array('C')); 
$pdf->SetWidths(array(60));$pdf->SetFont('arial','',9);		 
$pdf->Row(array('------------------------------------------------------'));$pdf->Ln(1);
$pdf->SetX(10);$pdf->SetAligns(array('L','C','R')); 
$pdf->SetWidths(array(25,10,10)); 
$pdf->SetAligns(array('L','C','R')); 
$pdf->SetWidths(array(25,10,10)); 
$pdf->Row(array('Administration',': Rp. ',$y[fee]));
$pdf->Ln(1); 
$pdf->SetX(10);$pdf->SetAligns(array('L','C','R')); 
$pdf->SetWidths(array(25,10,10)); 
$pdf->Row(array('TOTAL CHARGE',': Rp. ',$y[fee]));
$pdf->Ln(1);
$pdf->SetX(10);
$pdf->SetAligns(array('L','C','L')); 
$pdf->SetWidths(array(25,3,40)); 
if($y[fee]=='0')
{
	$pdf->Row(array('The sum of',':','FREE OF CHARGE'));$pdf->Ln(5);}
	else
	{
		$pdf->Row(array('The sum of',':','FIVE THOUSAND RUPIAH'));$pdf->Ln(5);}


$nama=mysql_fetch_array(mysql_query("SELECT u.nama_lengkap, 
u.code, u.nipp from user as u where u.id_user='$_SESSION[namauser]'"));

/*
$pdf->SetY(130);$pdf->SetX(150);
$pdf->Cell(120,5,$nama[nama_lengkap].'/MESKFXH',0,0,'L',1);
$pdf->Ln();$pdf->SetX(150);
$pdf->Cell(120,5,'ID NBR. '.$nama[nipp],0,0,'L',1);
*/
$pdf->SetX(8);$pdf->SetAligns(array('L','C')); 
$pdf->SetWidths(array(30,30));$pdf->SetAligns(array('L','C'));  
$pdf->Row(array('Consignee or behalf of','     Delivered By     '));$pdf->Ln(12);
$pdf->SetX(8);$pdf->SetAligns(array('L','C')); 
$pdf->SetWidths(array(30,30));$pdf->SetAligns(array('L','C')); 
$pdf->Row(array('                   ',$nama[nama_lengkap])); 
$pdf->SetX(8);$pdf->SetAligns(array('L','C')); 
$pdf->SetWidths(array(30,30));$pdf->SetAligns(array('L','C')); 
$pdf->Row(array('-------------------------',' -------------------------')); 

$pdf->Output();
}
//end of do

//----------------------- Cetak Stockopname Import ------------------------------
if ($module=='cetakstockopnamein')
{
	class PDF extends FPDF
	{
		function Header()
		{
			$tglnya=date("Y-m-d");
			$tgl='Kondisi Tanggal : '.ymd2dmy($tglnya);
			$this->SetFont('Arial','B',14);
			$this->Ln();
			$this->Cell(170,20,'STOCK OPNAME IMPORT',0,0,'C');
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
	mysql_query("delete from stockopnamein");
	
///SMU yang sudah confirm dan statuskeluar kosong dan tujuan DPS(130) 
mysql_query("insert into stockopnamein select m.nosmu,m.tglsmu,sum(i.berat) as berat,sum(i.koli) as koli,sum(i.berat) as ofberat,sum(i.koli) as ofkoli,m.idorigin,m.iddestination from master_smu as m, isimanifestin as i where i.idmastersmu=m.idmastersmu AND i.statuskeluar='' AND m.iddestination='130' group by i.idmastersmu");
//SMU yang sudah confirm dan statuskeluar kosong dan tujuan BUKAN DPS(!=130) 
mysql_query("insert into stockopnamein select m.nosmu,m.tglsmu,sum(i.berat) as berat,sum(i.koli) as koli,sum(i.berat) as ofberat,sum(i.koli) as ofkoli,m.idorigin,m.iddestination from master_smu as m, isimanifestin as i where i.idmastersmu=m.idmastersmu AND i.statuskeluar='' AND m.iddestination<>'130' group by i.idmastersmu");

$data=mysql_query("select *,d.dest_code as destination,o.origin_code as origin  from stockopnamein as s,destination as d,origin as o where s.iddestination=d.iddestination AND s.idorigin=o.idorigin AND s.iddestination ='130' order by nosmu asc");

 $pdf->AddPage();
   $berat_jo=0;$koli_jo=0;   $berat_tr=0;$koli_tr=0;
$berat=0;$koli=0;
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(10,5,'MES',0,0,'L',1);
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
$data=mysql_query("select *,d.dest_code as destination,o.origin_code as origin  from stockopnamein as s,destination as d,origin as o where s.iddestination=d.iddestination AND s.idorigin=o.idorigin AND s.iddestination <>'130' order by s.iddestination,s.nosmu asc");

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
	
}
//-------------------End of Mencetak Stockopanem Import -------------------------------
//---------------DB-------------------------------------------------
if ($module=='inputdo')
{
	$tgl=date("Y-m-d");
	$thn = substr($tgl,0,4);
  //echo($thn);
	$a=mysql_query("select nodb,tglbayar from deliverybill order by iddeliverybill DESC limit 1");
	$b=mysql_fetch_array($a);
	$cthn = substr($b[1],0,4);
	if($cthn<>$thn){$nodb=$thn.'0000000';}
	else {	$nodb=$b[0]+1;}

 
mysql_query("INSERT INTO deliverybill (idisimanifestin,nodb,fee,keterangan,adm,ppn,tglbayar,username,penerima,alamat) VALUES('$_POST[id]','$nodb','$_POST[admin]','$_POST[keterangan]','0','0','$tgl','$_SESSION[namauser]','$_POST[penerima]','$_POST[alamat]')");

mysql_query("update isimanifestin set paid='1' WHERE idisimanifestin='$_POST[id]'");
  header('location:media.php?module=isimanifestimport&idm='.$_POST[idm].'&r='.$_POST[r].'&f='.$_POST[f].'&d='.$_POST[d]);
}
//---------------End of Confirm AWB Manifest Export -------------------------------------------------

elseif ($module=='reportdo')
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
			$this->Cell(170,8,'DELIVERY ORDER CARGO INTERNATIONAL',0,0,'C');
			$this->Ln();
			$this->Cell(170,8,'PT. GARUDA INDONESIA',0,0,'C');	$this->Ln();		
			$this->SetFont('Times','I',11);
			$this->Cell(170,8,'Tanggal : '.$_POST[tglawal].' s/d '.$_POST[tglakhir],0,0,'L',1);$this->Ln(10);

	
				
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
			$pdf->Cell(40,5,'DELIVERY FEE',1,0,'C',1);
			$pdf->Cell(40,5,'NO DO',1,0,'C',1);
			$pdf->Cell(40,5,'TANGGAL',1,0,'C',1);			
			
			$pdf->SetFont('Arial','',9);$pdf->Ln();								
$no=0;
				
$str_data=mysql_query("SELECT s.nosmu,d.fee,d.nodb,d.tglbayar,d.isvoid FROM master_smu as s,deliverybill as d,isimanifestin as i WHERE i.idmastersmu=s.idmastersmu AND i.idisimanifestin=d.idisimanifestin AND i.statusconfirm='1' AND i.statuscancel='0' AND  d.tglbayar between '$tglawal' AND '$tglakhir' order by d.iddeliverybill ASC
		");
		$jm=0;
  		while($r=mysql_fetch_array($str_data))  
  		{
$no+=1;
			if($r[isvoid]=='1'){$abc=0;}else {$abc=$r[fee];}
			$pdf->Cell(10,5,$no,1,0,'R',1);
			$pdf->Cell(40,5,format_awb($r[nosmu]),1,0,'C',1);
			$pdf->Cell(40,5,number_format($abc, 1, ',', '.'),1,0,'R',1);
			if($r[isvoid]=='1'){$pdf->Cell(40,5,$r[nodb].'(VOID)',1,0,'C',1);} else
			{$pdf->Cell(40,5,$r[nodb],1,0,'C',1);}
			$pdf->Cell(40,5,ymd2dmy($r[tglbayar]),1,0,'C',1);	
			$pdf->Ln();			$jm+=$abc;
	}	
		
			$pdf->Cell(10,5,'',0,0,'R',1);
			$pdf->Cell(40,5,'',0,0,'C',1);
			$pdf->Cell(40,5,number_format($jm, 1, ',', '.'),1,0,'R',1);
			$pdf->Cell(40,5,'',0,0,'C',1);
			$pdf->Cell(40,5,'',0,0,'C',1);	
	
			$pdf->Ln(10);	
  				$pdf->Cell(50,6,'Yang Menyerahkan',0,0,'C',1);
				 $pdf->Cell(15,6,'',0,0,'C',1);
				 $pdf->Cell(50,6,'Mengetahui',0,0,'C',1);
				$pdf->Ln(20);	
  				$pdf->Cell(50,6,'( ..................................... )',0,0,'C',1); 
  				$pdf->Cell(15,6,'',0,0,'C',1); 				
				$pdf->Cell(50,6,'( ..................................... )',0,0,'C',1);
				$pdf->Ln(15);	
				
	$pdf->Output('deliveryreport.pdf','I');
}
elseif ($module=='reportflight')
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
			$this->Cell(0,8,'LAPORAN CARGO GUDANG INTERNATIONAL',0,0,'L');
			$this->Ln();
			$this->SetFont('Times','I',11);
			$this->Cell(170,8,'Tanggal : '.$_POST[tglawal].' until '.$_POST[tglakhir],0,0,'L',1);

	$this->Ln(8);
				
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

	    $pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Times','I',11);	


mysql_query("delete from flightdata"); 
mysql_query("insert into flightdata 
select m.flightdate,i.koli,s.nosmu,i.berat,c.commodityap,a.customer,d.dest_code,o.origin_code 
FROM manifestin as m,isimanifestin as i, commodity_ap as c, customer as a, destination as d, origin as o,master_smu as s,flight as f 
WHERE m.idmanifestin=i.idmanifestin AND s.idcommodityap=c.idcommodityap AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND i.idmastersmu=s.idmastersmu AND m.idflight=f.idflight AND i.statusvoid=0 AND i.statusconfirm='1' AND f.idcustomer=a.idcustomer AND d.dest_code='MES' AND f.flight like '%$_POST[airline]%' 
 AND m.flightdate BETWEEN '$tglawal' AND '$tglakhir' group by i.idisimanifestin
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

			
//import angkut lanjut
mysql_query("delete from flightdata"); 
mysql_query("insert into flightdata 
select m.flightdate,i.koli,s.nosmu,i.berat,c.commodityap,a.customer,d.dest_code,o.origin_code 
FROM manifestin as m,isimanifestin as i, commodity_ap as c, customer as a, destination as d, origin as o,master_smu as s,flight as f 
WHERE m.idmanifestin=i.idmanifestin AND s.idcommodityap=c.idcommodityap AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND i.idmastersmu=s.idmastersmu AND m.idflight=f.idflight AND i.statusvoid=0 AND f.idcustomer=a.idcustomer AND i.statusconfirm='1' AND d.dest_code<>'MES' AND f.flight like '%$_POST[airline]%' 
 AND m.flightdate BETWEEN '$tglawal' AND '$tglakhir' group by i.idisimanifestin
");



		$pdf->SetFont('Arial','I',12);
	$pdf->Cell(170,8,'ANGKUT LANJUT',0,0,'L',1);	
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
select m.flightdate,i.koli,s.nosmu,i.berat,c.commodityap,a.customer,d.dest_code,o.origin_code 
FROM manifestout as m,isimanifestout as i, commodity_ap as c, customer as a, destination as d, origin as o,master_smu as s,flight as f 
WHERE m.idmanifestout=i.idmanifestout AND s.idcommodityap=c.idcommodityap AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND i.idmastersmu=s.idmastersmu AND m.idflight=f.idflight AND i.statusvoid=0 AND f.idcustomer=a.idcustomer AND m.statusconfirm='1' AND o.origin_code='MES' AND f.flight like '%$_POST[airline]%' 
 AND m.flightdate BETWEEN '$tglawal' AND '$tglakhir' group by i.idisimanifestout");

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
select m.flightdate,i.koli,s.nosmu,i.berat,c.commodityap,a.customer,d.dest_code,o.origin_code 
FROM manifestout as m,isimanifestout as i, commodity_ap as c, customer as a, destination as d, origin as o,master_smu as s,flight as f 
WHERE m.idmanifestout=i.idmanifestout AND s.idcommodityap=c.idcommodityap AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND i.idmastersmu=s.idmastersmu AND m.idflight=f.idflight AND i.statusvoid=0 AND f.idcustomer=a.idcustomer AND m.statusconfirm='1' AND o.origin_code<>'MES' AND f.flight like '%$_POST[airline]%' 
 AND m.flightdate BETWEEN '$tglawal' AND '$tglakhir' group by i.idisimanifestout");

		$pdf->SetFont('Arial','I',12);
	$pdf->Cell(170,8,'TRANSIT',0,0,'L',1);	
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
elseif ($module=='cargoreport')
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
			$this->Cell(0,8,'LAPORAN CARGO GUDANG INTERNATIONAL',0,0,'L');
			$this->Ln();
			$this->SetFont('Times','I',11);
			$this->Cell(170,8,'Period : '.$_POST[tglawal].' until '.$_POST[tglakhir],0,0,'L',1);

	$this->Ln(8);
				
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

	    $pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Times','I',11);	


mysql_query("delete from flightdata"); 

 if($_POST[proses]=='SEMUA')
 {
  $tr="";
//import dulu
mysql_query("insert into flightdata 
select m.flightdate,i.koli,s.nosmu,i.berat,com.commodity,f.flight,d.dest_code,o.origin_code 
FROM manifestin as m,isimanifestin as i, commodity_ap as c, commodity as com, customer as a, 
destination as d, origin as o,master_smu as s,flight as f 
WHERE m.idmanifestin=i.idmanifestin AND s.idcommodityap=c.idcommodityap 
AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND i.idmastersmu=s.idmastersmu 
AND m.idflight=f.idflight AND i.statusvoid=0 AND i.statusconfirm='1' AND f.idcustomer=a.idcustomer 
AND d.dest_code='MES' AND c.idcommodity=com.idcommodity AND f.flight like '%$_POST[airline]%' 
 AND m.flightdate BETWEEN '$tglawal' AND '$tglakhir' group by i.idisimanifestin
");
//utk import lanjut
mysql_query("insert into flightdata 
select m.flightdate,i.koli,s.nosmu,i.berat,com.commodity,f.flight,d.dest_code,o.origin_code 
FROM manifestin as m,isimanifestin as i, commodity_ap as c, customer as a, destination as d, 
origin as o,master_smu as s,flight as f,commodity as com  
WHERE m.idmanifestin=i.idmanifestin AND s.idcommodityap=c.idcommodityap 
AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND i.idmastersmu=s.idmastersmu 
AND m.idflight=f.idflight AND i.statusvoid=0 AND f.idcustomer=a.idcustomer AND i.statusconfirm='1' 
AND d.dest_code<>'MES' AND f.flight like '%$_POST[airline]%'  AND c.idcommodity=com.idcommodity  
 AND m.flightdate BETWEEN '$tglawal' AND '$tglakhir' group by i.idisimanifestin
");
//utk export
mysql_query("insert into flightdata 
select m.flightdate,i.koli,s.nosmu,i.berat,com.commodity,f.flight,d.dest_code,o.origin_code 
FROM manifestout as m,isimanifestout as i, commodity_ap as c, customer as a, destination as d, 
origin as o,master_smu as s,flight as f,commodity as com  
WHERE m.idmanifestout=i.idmanifestout AND s.idcommodityap=c.idcommodityap 
AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND i.idmastersmu=s.idmastersmu 
AND m.idflight=f.idflight AND i.statusvoid=0 AND f.idcustomer=a.idcustomer AND m.statusconfirm='1' 
AND o.origin_code='MES' AND f.flight like '%$_POST[airline]%' AND c.idcommodity=com.idcommodity 
 AND m.flightdate BETWEEN '$tglawal' AND '$tglakhir' group by i.idisimanifestout");
//transit
mysql_query("insert into flightdata 
select m.flightdate,i.koli,s.nosmu,i.berat,com.commodity,f.flight,d.dest_code,o.origin_code 
FROM manifestout as m,isimanifestout as i, commodity_ap as c, customer as a, destination as d, 
origin as o,master_smu as s,flight as f,commodity as com  
WHERE m.idmanifestout=i.idmanifestout AND s.idcommodityap=c.idcommodityap AND s.idorigin=o.idorigin 
AND s.iddestination=d.iddestination AND i.idmastersmu=s.idmastersmu AND m.idflight=f.idflight 
AND i.statusvoid=0 AND f.idcustomer=a.idcustomer AND m.statusconfirm='1' AND o.origin_code<>'MES' 
AND f.flight like '%$_POST[airline]%' AND c.idcommodity=com.idcommodity  
 AND m.flightdate BETWEEN '$tglawal' AND '$tglakhir' group by i.idisimanifestout");
}
else if($_POST[proses]=='IMPORT')
 {
  $tr="Proses : Import";
//import dulu
mysql_query("insert into flightdata 
select m.flightdate,i.koli,s.nosmu,i.berat,com.commodity,f.flight,d.dest_code,o.origin_code 
FROM manifestin as m,isimanifestin as i, commodity_ap as c, commodity as com, customer as a, 
destination as d, origin as o,master_smu as s,flight as f 
WHERE m.idmanifestin=i.idmanifestin AND s.idcommodityap=c.idcommodityap 
AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND i.idmastersmu=s.idmastersmu 
AND m.idflight=f.idflight AND i.statusvoid=0 AND i.statusconfirm='1' AND f.idcustomer=a.idcustomer 
AND d.dest_code='MES' AND c.idcommodity=com.idcommodity AND f.flight like '%$_POST[airline]%' 
 AND m.flightdate BETWEEN '$tglawal' AND '$tglakhir' group by i.idisimanifestin
");
//utk import lanjut
mysql_query("insert into flightdata 
select m.flightdate,i.koli,s.nosmu,i.berat,com.commodity,f.flight,d.dest_code,o.origin_code 
FROM manifestin as m,isimanifestin as i, commodity_ap as c, customer as a, destination as d, 
origin as o,master_smu as s,flight as f,commodity as com  
WHERE m.idmanifestin=i.idmanifestin AND s.idcommodityap=c.idcommodityap 
AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND i.idmastersmu=s.idmastersmu 
AND m.idflight=f.idflight AND i.statusvoid=0 AND f.idcustomer=a.idcustomer AND i.statusconfirm='1' 
AND d.dest_code<>'MES' AND f.flight like '%$_POST[airline]%'  AND c.idcommodity=com.idcommodity  
 AND m.flightdate BETWEEN '$tglawal' AND '$tglakhir' group by i.idisimanifestin
");
}
else if($_POST[proses]=='EXPORT')
 {
  $tr="Proses : Export";
//utk export
mysql_query("insert into flightdata 
select m.flightdate,i.koli,s.nosmu,i.berat,com.commodity,f.flight,d.dest_code,o.origin_code 
FROM manifestout as m,isimanifestout as i, commodity_ap as c, customer as a, destination as d, 
origin as o,master_smu as s,flight as f,commodity as com  
WHERE m.idmanifestout=i.idmanifestout AND s.idcommodityap=c.idcommodityap 
AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND i.idmastersmu=s.idmastersmu 
AND m.idflight=f.idflight AND i.statusvoid=0 AND f.idcustomer=a.idcustomer AND m.statusconfirm='1' 
AND o.origin_code='MES' AND f.flight like '%$_POST[airline]%' AND c.idcommodity=com.idcommodity 
 AND m.flightdate BETWEEN '$tglawal' AND '$tglakhir' group by i.idisimanifestout"); 
 }
else if($_POST[proses]=='TRANSIT')
 {
 $tr="Proses : Transit";
 mysql_query("insert into flightdata 
select m.flightdate,i.koli,s.nosmu,i.berat,com.commodity,f.flight,d.dest_code,o.origin_code 
FROM manifestout as m,isimanifestout as i, commodity_ap as c, customer as a, destination as d, 
origin as o,master_smu as s,flight as f,commodity as com  
WHERE m.idmanifestout=i.idmanifestout AND s.idcommodityap=c.idcommodityap AND s.idorigin=o.idorigin 
AND s.iddestination=d.iddestination AND i.idmastersmu=s.idmastersmu AND m.idflight=f.idflight 
AND i.statusvoid=0 AND f.idcustomer=a.idcustomer AND m.statusconfirm='1' AND o.origin_code<>'MES' 
AND f.flight like '%$_POST[airline]%' AND c.idcommodity=com.idcommodity  
 AND m.flightdate BETWEEN '$tglawal' AND '$tglakhir' group by i.idisimanifestout");
 }
				$pdf->SetFont('Arial','B',12);
				$pdf->Cell(20,5,$tr,0,0,'L',1);
				$pdf->Ln(8);
$totalhari=ngitunghari($tglawal,$tglakhir);
$n=0;
while($n<=$totalhari)
{
$ttgl=my2date(increment_tgl($n,$tglawal));
				//cek dulu ada ndk
				$cek_str_data=mysql_num_rows(mysql_query("select tgl,airline,nosmu,kategori,berat,koli,asal,tujuan from flightdata 
				where tgl='$ttgl' AND airline like '%$_POST[airline]%'"));
				if($cek_str_data>0){
				
				$gtbrt=0;$gtkol=0;$gtqty=0;			
				$pdf->SetFont('Arial','B',10);
				$pdf->Cell(20,5,'FLT DATE',1,0,'C',1);
				$pdf->Cell(20,5,'FLT NUMB',1,0,'C',1);
				$pdf->Cell(30,5,'NO AWB',1,0,'C',1);
				$pdf->Cell(12,5,'COM',1,0,'C',1);
				$pdf->Cell(20,5,'Weight',1,0,'C',1);
				$pdf->Cell(15,5,'Pcs',1,0,'C',1);
				$pdf->Cell(8,5,'Qty',1,0,'C',1);
				$pdf->Cell(15,5,'ORG',1,0,'C',1);
				$pdf->Cell(15,5,'DEST',1,0,'C',1);
				$pdf->Cell(25,5,'REMARK',1,0,'C',1);				
				$pdf->Ln();
				$brt=0;$kol=0;$qty=0;
				$str_data=mysql_query("select tgl,airline,nosmu,kategori,berat,koli,asal,tujuan from flightdata 
				where tgl='$ttgl' AND airline like '%$_POST[airline]%'");
				$qty=0;
 				while($rrr=mysql_fetch_array($str_data))  
  				{   
					$pdf->SetFont('Arial','',10);
					$pdf->Cell(20,5,ymd2dmy($rrr[tgl]),1,0,'C',1);
					$pdf->Cell(20,5,$rrr[airline],1,0,'C',1);
					$pdf->Cell(30,5,format_awb($rrr[nosmu]),1,0,'C',1);
					$pdf->Cell(12,5,$rrr[kategori],1,0,'C',1);
					$pdf->Cell(20,5,number_format($rrr[berat], 0, '.', '.'),1,0,'R',1);					
					$pdf->Cell(15,5,number_format($rrr[koli],1, ',', '.'),1,0,'R',1);
					$pdf->Cell(8,5,'1',1,0,'R',1);
					$pdf->Cell(15,5,$rrr[asal],1,0,'C',1);
					$pdf->Cell(15,5,$rrr[tujuan],1,0,'C',1);
					$pdf->Cell(25,5,'',1,0,'R',1);
					$pdf->Ln();
					$brt+=$rrr[berat];$kol+=$rrr[koli];$qty++;
				}
				$pdf->Cell(82,5,'TOTAL',1,0,'L',1);
				$pdf->Cell(20,5,number_format($brt, 1, ',', '.'),1,0,'R',1);
				$pdf->Cell(15,5,number_format($kol, 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(8,5,number_format($qty, 0, '.', '.'),1,0,'R',1);
				$pdf->Ln(8);}	
$n++;
}				
			
	
				

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

//update 11 sept 2010
//---------------Menghapus Data Dolar -------------------------------------------------
if ($module=='datadolar' AND $act=='hapus')
{
  mysql_query("DELETE FROM dolar WHERE id  = '$_GET[id]'");
  header('location:media.php?module=dolar');
}
//---------------End of Menghapus Data Dolar -------------------------------------------------

//---------------Menambah Data Dolar---------------------------------------------------------
if ($module=='datadolar' AND $act=='tambah')
{
	$tgl=my2date($_POST[requireddate]);
  $cek=mysql_num_rows(mysql_query("select * from dolar where tgl = '$tgl' AND exga='$_POST[exga]'"));
		if($cek>0)
		{
					showAlert('Tanggal sudah ada !','media.php?module=dolar&cari='.$_POST[requireddate]);																								
			}
			else
			{
				mysql_query("INSERT INTO dolar(tgl,dolar,cl,hnd,doc,exga,user) 
	                       VALUES('$tgl','$_POST[requireddolar]','$_POST[cl]','$_POST[hnd]','$_POST[doc]','$_POST[exga]','$_SESSION[namauser]')");
		  header('location:media.php?module=dolar&cari='.$_POST[requireddate]);
				}
} 
//---------------End of Menambah Data Dolar--------------------------------------------------

//---------------Edit Data Dolar---------------------------------------------------------
if ($module=='datadolar' AND $act=='edit')
{
		$tgl=my2date($_POST[requireddate]);
 mysql_query("UPDATE dolar SET dolar = '$_POST[requireddolar]',
 			tgl='$tgl',cl = '$_POST[cl]',hnd = '$_POST[hnd]',doc = '$_POST[doc]'
				WHERE id     = '$_POST[id]'");
  header('location:media.php?module=dolar&cari='.$_POST[requireddate]);
} 
//---------------End of Edit Data Dolar--------------------------------------------------

//---------------Menambah Data PNBP---------------------------------------------------------
if ($module=='datapnbp' AND $act=='tambah')
{
					mysql_query("INSERT INTO hargapnbp(jml1,hargajml1,hargajml2,userku) 
	                       VALUES('$_POST[requiredpatokan]','$_POST[bawah]','$_POST[atas]','$_SESSION[namauser]')");
		  header('location:media.php?module=pnbp');
} 
//---------------End of Menambah Data PNBPr--------------------------------------------------
//..report charge bc12
elseif ($module=='bc12charge')
{
$tglawal=my2date($_POST[tglawal]);
$tglakhir=my2date($_POST[tglakhir]);

$k=mysql_query("SELECT nama_lengkap,nipp FROM user where id_user='$_SESSION[namauser]'");
$ka=mysql_fetch_array($k);
$kasir=$ka[0];$nipp=$ka[1];

if($_POST[airline]=='GA'){$kode='126';$air='Garuda Indonesia';}
else if($_POST[airline]=='QF'){$kode='081';$air='Qantas Airways';}
else if($_POST[airline]=='KE'){$kode='180'; $air='Korean Air';}
else if($_POST[airline]=='CI'){$kode='297';$air='China Airline';}
else if($_POST[airline]=='MH'){$kode='232';$air='Malaysian Airline';}
else if($_POST[airline]=='QR'){$kode='157';$air='Qatar Airways';}
else if($_POST[airline]=='TG'){$kode='217';$air='Thai Airways';}
else if($_POST[airline]=='FM'){$kode='781';$air='Shanghai Airline';}
else if($_POST[airline]=='UO'){$kode='128';$air='Hongkong Express';}


	class PDF extends FPDF
	{
		//Page header
		function Header()
		{	
		if($_POST[airline]=='GA'){$kode='126';$air='Garuda Indonesia';}
else if($_POST[airline]=='QF'){$kode='081';$air='Qantas Airways';}
else if($_POST[airline]=='KE'){$kode='180'; $air='Korean Air';}
else if($_POST[airline]=='CI'){$kode='297';$air='China Airline';}
else if($_POST[airline]=='MH'){$kode='232';$air='Malaysian Airline';}
else if($_POST[airline]=='QR'){$kode='157';$air='Qatar Airways';}
else if($_POST[airline]=='TG'){$kode='217';$air='Thai Airways';}
else if($_POST[airline]=='FM'){$kode='781';$air='Shanghai Airline';}
else if($_POST[airline]=='UO'){$kode='128';$air='Hongkong Express';}
//		$this->SetTopMargin(5);			
			//$this->SetY(10);			
			$this->SetFillColor(255,255,255);
			$this->SetFont('Arial','',12);
			$this->Cell(0,8,'TRANSHIPMENTS CUSTOMS CLEARANCE CHARGES '.$air,0,0,'L');
			$this->Ln();
			$this->SetFont('Times','I',11);
			$this->Cell(170,8,'Period : '.$_POST[tglawal].' until '.$_POST[tglakhir],0,0,'L',1);
			$this->Ln(10);
				
				
		}
		
		//Page footer
		function Footer()
		{
		/*
	//Position at 1.5 cm from bottom
			$this->SetY(-80);
			//Arial italic 8
			$this->SetFont('Arial','I',9);
			//Page number
			$this->Cell(0,10,'GAPURA BALI WMS INTER - Page '.$this->PageNo().'/{nb}',0,0,'C');
	*/
	$this->SetY(-10);
	$this->SetFont('Arial','I',9);
	$this->Cell(0,10,'GAPURA MEDAN WMS INTER - Page '.$this->PageNo().'/{nb}',0,0,'C');
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
	$this->CheckPageBreak($h);
//$this->CheckPageBreak($_POST[batas]);
	//Draw the cells of the row
	for($i=0;$i<count($data);$i++)
	{
		$w=$this->widths[$i];
		$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
		//Save the current position
		$x=$this->GetX();
		$y=$this->GetY();
		$this->Rect($x,$y,$w,$h);
		//Print the text
		$this->MultiCell($w,4,$data[$i],0,$a);
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
		
	}
	
	$pdf=new PDF('L','mm','A4');
	$pdf->SetMargins(10,10,5);	
	$pdf->SetAutoPageBreak(true,$_POST[margin]);	
	$pdf->AliasNbPages();
	$pdf->Open();
	
	
   $pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Times','',10);	

$tglawal=my2date($_POST[tglawal]);
$tglakhir=my2date($_POST[tglakhir]);
mysql_query("delete from bc12charge"); 

					
$smuk=mysql_query("SELECT cc.customer,cc.pejabatbc12 FROM shipper as con,isimanifestin as i,manifestin as mi,commodity_ap as p, master_smu as s, commodity as c,flight as f, customer as cc WHERE mi.idmanifestin=i.idmanifestin AND mi.idflight=f.idflight AND f.idcustomer=cc.idcustomer AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND p.idcommodity = c.idcommodity AND s.shipper=con.idshipper AND s.iddestination<>'130' 
AND s.nosmu like '$kode%' AND mi.flightdate between ('$tglawal') AND ('$tglakhir') group by cc.customer"); 

			$tkoli=0;$tberat=0;$tberatbayar=0;
			$ttcl=0;$tthnd=0;$ttdoc=0;$ttt=0;
			
while($x=mysql_fetch_array($smuk))
{
	if($x[customer]=='GA'){
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Times','B',9);
		$pdf->Cell(10,6,'Ex-'.$x[customer],0,0,'L',1);
		$pdf->Ln();	
		$pdf->Cell(8,5,'','LRT',0,'C',1);
			$pdf->Cell(17,5,'','LRT',0,'C',1);
			$pdf->Cell(20,5,'','LRT',0,'C',1);
			$pdf->Cell(18,5,'','LRT',0,'C',1);		
			$pdf->Cell(15,5,'','LRT',0,'C',1);
			$pdf->Cell(36,5,'Total Weight (Kgs)','LRT',0,'C',1);
			$pdf->Cell(32,5,'','LRT',0,'C',1);
			$pdf->Cell(35,5,'','LRT',0,'C',1);	
			$pdf->Cell(69,5,'Service Charges(USD)','LRT',0,'C',1);			
			$pdf->Cell(30,5,'','LRT',0,'C',1);
			$pdf->Ln();					
			$pdf->Cell(8,5,'No','LR',0,'C',1);
			$pdf->Cell(17,5,'Date of','LR',0,'C',1);
			$pdf->Cell(20,5,'AWB','LR',0,'C',1);
			$pdf->Cell(18,5,'Country','LR',0,'C',1);		
			$pdf->Cell(15,5,'Total','LR',0,'C',1);
			$pdf->Cell(18,5,'Actual','LRT',0,'C',1);
			$pdf->Cell(18,5,'Chgbl','LRT',0,'C',1);
			$pdf->Cell(32,5,'Description','LR',0,'C',1);
			$pdf->Cell(35,5,'Shipper','LR',0,'C',1);	
			$pdf->Cell(18,5,'W/H Charge','LRT',0,'C',1);
			$pdf->Cell(18,5,'Admin','LRT',0,'C',1);
			$pdf->Cell(15,5,'PPn(10%).','LRT',0,'C',1);
			$pdf->Cell(18,5,'Total','LRT',0,'C',1);	
			$pdf->Cell(30,5,'Remark','LR',0,'C',1);
			$pdf->Ln();								
			$pdf->Cell(8,5,'','LR',0,'C',1);
			$pdf->Cell(17,5,'Arrival','LR',0,'C',1);
			$pdf->Cell(20,5,'','LR',0,'C',1);
			$pdf->Cell(18,5,'ORG/DEST','LR',0,'C',1);		
			$pdf->Cell(15,5,'Collies','LR',0,'C',1);
			$pdf->Cell(18,5,'','LR',0,'C',1);
			$pdf->Cell(18,5,'','LR',0,'C',1);
			$pdf->Cell(32,5,'of Goods','LR',0,'C',1);
			$pdf->Cell(35,5,'','LR',0,'C',1);	
			$pdf->Cell(18,5,'','LR',0,'C',1);
			$pdf->Cell(18,5,'','LR',0,'C',1);
			$pdf->Cell(15,5,'','LR',0,'C',1);
			$pdf->Cell(18,5,'Charges','LR',0,'C',1);	
			$pdf->Cell(30,5,'','LR',0,'C',1);
			$pdf->Ln();					
			$pdf->Cell(8,5,'','LRB',0,'C',1);
			$pdf->Cell(17,5,'','LRB',0,'C',1);
			$pdf->Cell(20,5,'','LRB',0,'C',1);
			$pdf->Cell(18,5,'','LRB',0,'C',1);		
			$pdf->Cell(15,5,'','LRB',0,'C',1);
			$pdf->Cell(18,5,'','LRB',0,'C',1);
			$pdf->Cell(18,5,'','LRB',0,'C',1);
			$pdf->Cell(32,5,'','LRB',0,'C',1);
			$pdf->Cell(35,5,'','LRB',0,'C',1);	
			$pdf->Cell(18,5,'','LRB',0,'C',1);
			$pdf->Cell(18,5,'','LRB',0,'C',1);
			$pdf->Cell(15,5,'','LRB',0,'C',1);
			$pdf->Cell(18,5,'','LRB',0,'C',1);	
			$pdf->Cell(30,5,'','LRB',0,'C',1);
			$pdf->Ln();		} else {
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Times','B',9);
		$pdf->Cell(10,6,'Ex-'.$x[customer],0,0,'L',1);
		$pdf->Ln();	
		$pdf->Cell(8,5,'','LRT',0,'C',1);
			$pdf->Cell(17,5,'','LRT',0,'C',1);
			$pdf->Cell(20,5,'','LRT',0,'C',1);
			$pdf->Cell(18,5,'','LRT',0,'C',1);		
			$pdf->Cell(15,5,'','LRT',0,'C',1);
			$pdf->Cell(36,5,'Total Weight (Kgs)','LRT',0,'C',1);
			$pdf->Cell(32,5,'','LRT',0,'C',1);
			$pdf->Cell(35,5,'','LRT',0,'C',1);	
			$pdf->Cell(69,5,'Service Charges(USD)','LRT',0,'C',1);			
			$pdf->Cell(30,5,'','LRT',0,'C',1);
			$pdf->Ln();					
			$pdf->Cell(8,5,'No','LR',0,'C',1);
			$pdf->Cell(17,5,'Date of','LR',0,'C',1);
			$pdf->Cell(20,5,'AWB','LR',0,'C',1);
			$pdf->Cell(18,5,'Country','LR',0,'C',1);		
			$pdf->Cell(15,5,'Total','LR',0,'C',1);
			$pdf->Cell(18,5,'Actual','LRT',0,'C',1);
			$pdf->Cell(18,5,'Chgbl','LRT',0,'C',1);
			$pdf->Cell(32,5,'Description','LR',0,'C',1);
			$pdf->Cell(35,5,'Shipper','LR',0,'C',1);	
			$pdf->Cell(18,5,'Clearence','LRT',0,'C',1);
			$pdf->Cell(18,5,'Handling','LRT',0,'C',1);
			$pdf->Cell(15,5,'Docs.','LRT',0,'C',1);
			$pdf->Cell(18,5,'Total','LRT',0,'C',1);	
			$pdf->Cell(30,5,'Remark','LR',0,'C',1);
			$pdf->Ln();								
			$pdf->Cell(8,5,'','LR',0,'C',1);
			$pdf->Cell(17,5,'Arrival','LR',0,'C',1);
			$pdf->Cell(20,5,'','LR',0,'C',1);
			$pdf->Cell(18,5,'ORG/DEST','LR',0,'C',1);		
			$pdf->Cell(15,5,'Collies','LR',0,'C',1);
			$pdf->Cell(18,5,'','LR',0,'C',1);
			$pdf->Cell(18,5,'','LR',0,'C',1);
			$pdf->Cell(32,5,'of Goods','LR',0,'C',1);
			$pdf->Cell(35,5,'','LR',0,'C',1);	
			$pdf->Cell(18,5,'','LR',0,'C',1);
			$pdf->Cell(18,5,'','LR',0,'C',1);
			$pdf->Cell(15,5,'','LR',0,'C',1);
			$pdf->Cell(18,5,'Charges','LR',0,'C',1);	
			$pdf->Cell(30,5,'','LR',0,'C',1);
			$pdf->Ln();					
			$pdf->Cell(8,5,'','LRB',0,'C',1);
			$pdf->Cell(17,5,'','LRB',0,'C',1);
			$pdf->Cell(20,5,'','LRB',0,'C',1);
			$pdf->Cell(18,5,'','LRB',0,'C',1);		
			$pdf->Cell(15,5,'','LRB',0,'C',1);
			$pdf->Cell(18,5,'','LRB',0,'C',1);
			$pdf->Cell(18,5,'','LRB',0,'C',1);
			$pdf->Cell(32,5,'','LRB',0,'C',1);
			$pdf->Cell(35,5,'','LRB',0,'C',1);	
			$pdf->Cell(18,5,'','LRB',0,'C',1);
			$pdf->Cell(18,5,'','LRB',0,'C',1);
			$pdf->Cell(15,5,'','LRB',0,'C',1);
			$pdf->Cell(18,5,'','LRB',0,'C',1);	
			$pdf->Cell(30,5,'','LRB',0,'C',1);
			$pdf->Ln();			}			

$smu=mysql_query("SELECT mi.flightdate,cc.customer,s.remark,s.tglsmu,s.nosmu,i.koli as koli,i.berat as berat,i.beratbayar, p.commodityap,con.shipper,s.idorigin, s.iddestination FROM shipper as con,isimanifestin as i,manifestin as mi,commodity_ap as p, master_smu as s, commodity as c,flight as f, customer as cc WHERE mi.idmanifestin=i.idmanifestin AND mi.idflight=f.idflight AND f.idcustomer=cc.idcustomer AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND p.idcommodity = c.idcommodity AND s.shipper=con.idshipper AND s.iddestination<>'130' 
AND s.nosmu like '$kode%' AND mi.flightdate between ('$tglawal') AND ('$tglakhir') AND cc.customer='$x[customer]' order by mi.flightdate ASC"); 

/*$smu=mysql_query("SELECT s.remark,s.tglsmu,s.nosmu,i.koli as koli,i.berat as berat,i.beratbayar,
p.commodityap,con.shipper,s.idorigin,
s.iddestination FROM shipper as con,isimanifestin as i,commodity_ap as p, master_smu as s, 
commodity as c WHERE i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.idcommodityap=p.idcommodityap AND p.idcommodity = c.idcommodity AND s.shipper=con.idshipper AND s.iddestination<>'130' 
AND s.nosmu like '$kode%' AND s.tglsmu between ('$tglawal') AND ('$tglakhir') order by s.tglsmu ASC"); 
*/
$no=1;

			$koli=0;$berat=0;$beratbayar=0;
			$tcl=0;$thnd=0;$tdoc=0;$tt=0;


/*	$pdf->SetAligns(array('C','C','C','C','C','C','C','C','C','C','C','C','C','C')); 
	$pdf->SetWidths(array(10,20,25,20,18,18,18,30,35,18,18,15,18,18)); 
	$pdf->Row(array('No','Date of Arrival','AWB','ORG/DEST',
	'Total Collies','Total Actual Kgs','Total Chgbl Kgs','Description of Goods','Shipper',
	'Clearence','Handling','Docs.','Total Chrg','Kurs'));
*/
			$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Times','',8);	
while($r=mysql_fetch_array($smu))
{
	
	$d=mysql_fetch_array(mysql_query("select dest_code from destination where iddestination='$r[iddestination]'"));
	$o=mysql_fetch_array(mysql_query("select origin_code from origin where idorigin='$r[idorigin]'"));	
	if($x[customer]=='GA')
	{
$p=mysql_fetch_array(mysql_query("select * from dolar where tgl='$r[flightdate]' AND exga='on'"));	
				$cl=($p[cl]*$r[beratbayar]);
				$hnd=$p[hnd];
				$doc=(10/100)*($cl+$hnd);
			
	$t=$cl+$hnd+$doc;
	$pdf->SetAligns(array('R','C','C','C','R','R','R','C','L','R','R','R','R','R')); 
	$pdf->SetWidths(array(8,17,20,18,15,18,18,32,35,18,18,15,18,30)); 		
		
	}
	else
	{
$cek=mysql_num_rows(mysql_query("select dolar from dolar where tgl='$r[flightdate]'"));	
	if($cek<=0)
	{$cl=0;
		$hnd=0;
		$doc=0;}
	else	
	{$p=mysql_fetch_array(mysql_query("select * from dolar where tgl='$r[flightdate]'"));	
			if($p[dolar]<=0)
			{
				$cl=0;
				$hnd=0;
				$doc=0;
			}
			else 
			{
			
					$cl=($p[cl]*$r[beratbayar])/$p[dolar];
				$hnd=$p[hnd]/$p[dolar];
				$doc=$p[doc]/$p[dolar];
			}
		}	
	
	$t=$cl+$hnd+$doc;
	$pdf->SetAligns(array('R','C','C','C','R','R','R','C','L','R','R','R','R','R')); 
	$pdf->SetWidths(array(8,17,20,18,15,18,18,32,35,18,18,15,18,30)); 		
	}
	if(($kode=='180') OR ($x[customer]=='GA'))
	{
	$pdf->Row(array($no,ymd2dmy($r[flightdate]),$r[nosmu],$o[0].'/'.$d[0],
	$r[koli],$r[berat],$r[beratbayar],$r[commodityap],$r[shipper],
	number_format($cl, 2, '.', '.'),number_format($hnd, 2, '.', '.'),
	number_format($doc, 2, '.', '.'),number_format($t, 2, '.', '.'),
	$r[remark]));		
	}
	else
	{
	$pdf->Row(array($no,ymd2dmy($r[flightdate]),$r[nosmu],$o[0].'/'.$d[0],
	$r[koli],$r[berat],$r[beratbayar],$r[commodityap],$r[shipper],
	number_format($cl, 2, '.', '.'),number_format($hnd, 2, '.', '.'),
	number_format($doc, 2, '.', '.'),number_format($t, 2, '.', '.'),
	'1 USD = Rp.'.number_format($p[dolar], 2, '.', '.')));		
		
	}
	

	//number_format($p[0], 0, '.', '.')

			/*	$pdf->Cell(10,5,$no,1,0,'R',1);
				$pdf->Cell(20,5,ymd2dmy($r[tglsmu]),1,0,'C',1);
				$pdf->Cell(25,5,$r[nosmu],1,0,'C',1);
				$pdf->Cell(20,5,$o[0].'/'.$d[0],1,0,'C',1);
				$pdf->Cell(10,5,$r[koli],1,0,'R',1);
				$pdf->Cell(18,5,$r[berat],1,0,'R',1);
				$pdf->Cell(18,5,$r[beratbayar],1,0,'R',1);
				$pdf->Cell(40,5,$r[commodityap],1,0,'C',1);
				$pdf->Cell(10,5,$r[shipper],1,0,'L',1);
				$pdf->Cell(18,5,number_format($cl, 2, '.', '.'),1,0,'R',1);
				$pdf->Cell(18,5,number_format($hnd, 2, '.', '.'),1,0,'R',1);
				$pdf->Cell(15,5,number_format($doc, 2, '.', '.'),1,0,'R',1);
				$pdf->Cell(18,5,number_format($t, 2, '.', '.'),1,0,'R',1);
				$pdf->Cell(18,5,number_format($p[0], 0, '.', '.'),1,0,'R',1);				*/
			//	$pdf->Ln();
			$no+=1;
			$koli+=$r[koli];$berat+=$r[berat];$beratbayar+=$r[beratbayar];
			$tcl+=$cl;$thnd+=$hnd;$tdoc+=$doc;$tt+=$t;
			
			}
						$pdf->SetFillColor(255,255,255);
				$pdf->SetFont('Times','B',9);	
				$pdf->Cell(63,5,'SUB TOTAL : ',1,0,'C',1);
				$pdf->Cell(15,5,number_format($koli, 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(18,5,number_format($berat, 1, '.', '.'),1,0,'R',1);
				$pdf->Cell(18,5,number_format($beratbayar, 1, '.', '.'),1,0,'R',1);
				$pdf->Cell(67,5,'SUB TOTAL ...',1,0,'C',1);
				$pdf->Cell(18,5,number_format($tcl, 2, '.', '.'),1,0,'R',1);
				$pdf->Cell(18,5,number_format($thnd, 2, '.', '.'),1,0,'R',1);
				$pdf->Cell(15,5,number_format($tdoc, 2, '.', '.'),1,0,'R',1);
				$pdf->Cell(18,5,number_format($tt, 2, '.', '.'),1,0,'R',1);
				$pdf->Cell(30,5,'',1,0,'R',1);			
									$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Times','',10);	
		$pdf->Ln(5);
				$tkoli+=$koli;$tberat+=$berat;$tberatbayar+=$beratbayar;
			$ttcl+=$tcl;$tthnd+=$thnd;$ttdoc+=$tdoc;$ttt+=$tt;
}

			$pdf->SetFont('Times','B',9);	
				$pdf->Cell(63,5,'TOTAL : ',1,0,'C',1);
				$pdf->Cell(15,5,number_format($tkoli, 0, '.', '.'),1,0,'R',1);
				$pdf->Cell(18,5,number_format($tberat, 1, '.', '.'),1,0,'R',1);
				$pdf->Cell(18,5,number_format($tberatbayar, 1, '.', '.'),1,0,'R',1);
				$pdf->Cell(67,5,'TOTAL ...',1,0,'C',1);
				$pdf->Cell(18,5,number_format($ttcl, 2, '.', '.'),1,0,'R',1);
				$pdf->Cell(18,5,number_format($tthnd, 2, '.', '.'),1,0,'R',1);
				$pdf->Cell(15,5,number_format($ttdoc, 2, '.', '.'),1,0,'R',1);
				$pdf->Cell(18,5,number_format($ttt, 2, '.', '.'),1,0,'R',1);
				$pdf->Cell(30,5,'',1,0,'R',1);			
						$pdf->Ln(10);
				
$st=mysql_fetch_array(mysql_query("select * from customer where customer='$_POST[airline]'"));
	$pdf->Cell(20,5,'',0,0,'L',1);
	$pdf->Cell(150,5,'PREPARED BY : ',0,0,'L',1);
	$pdf->Cell(100,5,'APPROVED BY : ',0,0,'L',1);$pdf->Ln();
	$pdf->Cell(20,5,'',0,0,'L',1);
	$pdf->Cell(150,5,'PT. GAPURA ANGKASA',0,0,'L',1);
	$pdf->Cell(100,5,'',0,0,'L',1);$pdf->Ln(20);	
	$pdf->Cell(20,5,'',0,0,'L',1);
	$pdf->Cell(150,5,'AGUS SUCAHYA',0,0,'L',1);
	$pdf->Cell(100,5,$st[pejabatbc12],0,0,'L',1);$pdf->Ln();	
	$pdf->Cell(20,5,'',0,0,'L',1);
	$pdf->Cell(150,5,'Cargo Manager',0,0,'L',1);
	$pdf->Cell(100,5,'Freight Sales & Services Officer',0,0,'L',1);


$pdf->Output();

}
//pnbp
elseif ($module=='pnbp')
{
$tglawal=my2date($_POST[tglawal]);
$tglakhir=my2date($_POST[tglakhir]);

if($_POST[airline]=='GA'){$kode='126';$air='Garuda Indonesia';}
else if($_POST[airline]=='QF'){$kode='081';$air='Qantas Airways';}
else if($_POST[airline]=='KE'){$kode='180'; $air='Korean Air';}
else if($_POST[airline]=='CI'){$kode='297';$air='China Airline';}
else if($_POST[airline]=='MH'){$kode='232';$air='Malaysian Airline';}
else if($_POST[airline]=='QR'){$kode='157';$air='Qatar Airways';}
else if($_POST[airline]=='TG'){$kode='217';$air='Thai Airways';}
else if($_POST[airline]=='FM'){$kode='781';$air='Shanghai Airline';}
else if($_POST[airline]=='UO'){$kode='128';$air='Hongkong Express';}


	class PDF extends FPDF
	{
		//Page header
		function Header()
		{	
		}
		function Footer()
		{
			$this->SetY(-10);
			$this->SetFont('Arial','I',9);
			$this->Cell(0,10,'GAPURA MEDAN WMS INTER - Page '.$this->PageNo().'/{nb}',0,0,'C');
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
	$this->CheckPageBreak($h);
//$this->CheckPageBreak($_POST[batas]);
	//Draw the cells of the row
	for($i=0;$i<count($data);$i++)
	{
		$w=$this->widths[$i];
		$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
		//Save the current position
		$x=$this->GetX();
		$y=$this->GetY();
		$this->Rect($x,$y,$w,$h);
		//Print the text
		$this->MultiCell($w,4,$data[$i],0,$a);
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
		
	}
	
	$pdf=new PDF('P','mm','A4');
	$pdf->SetMargins(10,10,5);	
	$pdf->SetAutoPageBreak(true,$_POST[margin]);	
	$pdf->AliasNbPages();
	$pdf->Open();
	
	
   $pdf->AddPage();
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Times','',10);	

$tglawal=my2date($_POST[tglawal]);
$tglakhir=my2date($_POST[tglakhir]);

$tglawal1=ymd2dmy3($tglawal);
$tglakhir1=ymd2dmy3($tglakhir);

$hargapnpb=mysql_fetch_array(mysql_query("select * from hargapnbp order by id DESC limit 1"));
$harga1=$hargapnpb[hargajml1];
$harga2=$hargapnpb[hargajml2];
$jml1=$hargapnpb[jml1];

$nama=mysql_fetch_array(mysql_query("select * from customer where customer='$_POST[airline]'"));
					
$smuk=mysql_query(" SELECT * from manifestin as mi,flight as f, customer as cc
where mi.idflight=f.idflight AND f.idcustomer=cc.idcustomer 
AND mi.statusnil='' AND cc.customer='$_POST[airline]' AND mi.flightdate BETWEEN '$tglawal' AND '$tglakhir'		order by mi.flightdate ASC");	

	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Times','B',10);
	$pdf->Cell(190,5,'DAFTAR REKAPITULASI PEMBAYARAN PNBP BERKALA',0,0,'L',1);$pdf->Ln();	
	$pdf->Cell(190,5,'NAMA PERUSAHAAN :'.$nama[cus_desc] ,0,0,'L',1);$pdf->Ln();	
	$pdf->Cell(190,5,'PERIODE : '.$tglawal1.' s/d '.$tglakhir1,0,0,'L',1);$pdf->Ln();		
	$pdf->Cell(50,5,'SSBP NOMOR :     ',0,'L',1);$pdf->Cell(50,5,'TANGGAL :     ',0,'L',1);
			$pdf->Ln(20);						
			$pdf->Cell(183,5,'INWARD','0',0,'R',1);$pdf->Ln();						
			$pdf->Cell(8,5,'NO','LTR',0,'C',1);
			$pdf->Cell(60,5,'DOKUMEN DASAR',1,0,'C',1);
			$pdf->Cell(25,5,'JENIS','LTR',0,'C',1);
			$pdf->Cell(15,5,'JML','LTR',0,'C',1);		
			$pdf->Cell(30,5,'TARIF PNBP',1,0,'C',1);
			$pdf->Cell(45,5,'FLIGHT',1,0,'C',1);
			$pdf->Ln();				
			$pdf->Cell(8,5,'','LBR',0,'C',1);
			$pdf->Cell(20,5,'JENIS',1,0,'C',1);	
			$pdf->Cell(20,5,'NOMOR',1,0,'C',1);			
			$pdf->Cell(20,5,'TANGGAL',1,0,'C',1);
			$pdf->Cell(25,5,'PENERIMAAN','LRB',0,'C',1);			
			$pdf->Cell(15,5,'POS','LRB',0,'C',1);			
			$pdf->Cell(30,5,'(Rp)',1,0,'C',1);			
			$pdf->Cell(20,5,'NO',1,0,'C',1);			
			$pdf->Cell(25,5,'TANGGAL',1,0,'C',1);			
			$pdf->Ln();						
				$pdf->SetFont('Times','',10);
$no=1;
$totaltarif=0;$totalawb=0;			
while($x=mysql_fetch_array($smuk))
{
$tglflight=ymd2dmy3($x[flightdate]);
	$jmlawb=mysql_fetch_array(mysql_query("select count(i.idmastersmu) as jsmu from isimanifestin as i 
	where i.idmanifestin='$x[idmanifestin]' and i.statusconfirm='1' and i.statusvoid='0' AND i.statuscancel='0'")); 
	if($jmlawb[jsmu]<=$jml1)
	{
		$harganya=$harga1;
		}
		else
		{
					$harganya=$harga2;
			}
	
	$pdf->SetAligns(array('C','C','C','C','C','C','C','C','C')); 
	$pdf->SetWidths(array(8,20,20,20,25,15,30,20,25)); 		
	$pdf->Row(array($no,'BC1.1',$x[nomorpnbp],ymd2dmy3($x[tglpnbp]),
	'PNBP',$jmlawb[0],number_format($harganya, 0, ',', ','),$x[flight],$tglflight));			
	
			$no+=1;
$totaltarif+=$harganya;$totalawb+=$jmlawb[0];		
			
			}
	$pdf->SetAligns(array('C','C','C','C','C')); 
	$pdf->SetWidths(array(93,15,30,20,25)); 			
	$pdf->Row(array('TOTAL',$totalawb,number_format($totaltarif, 0, ',', ','),'',''));				
		$pdf->Ln();
		$pdf->Cell(30,5,'',0,0,'L',1);
	$pdf->Cell(50,5,'Medan, ............ 20 ',0,0,'L',1);$pdf->Ln();
	$pdf->Cell(30,5,'',0,0,'L',1);
	$pdf->Cell(100,5,'PENYETOR',0,0,'L',1);$pdf->Cell(50,5,'PENERIMA',0,0,'L',1);

			
$smuk=mysql_query(" SELECT * from manifestout as mo,flight as f, customer as cc
where mo.idflight=f.idflight AND f.idcustomer=cc.idcustomer AND mo.statusnil='' AND mo.statusconfirm='1' AND mo.statuscancel='0' AND statusvoid='0' AND cc.customer='$_POST[airline]' AND mo.flightdate BETWEEN '$tglawal' AND '$tglakhir'	order by mo.flightdate ASC");	
 $pdf->AddPage();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Times','B',10);
	$pdf->Cell(190,5,'DAFTAR REKAPITULASI PEMBAYARAN PNBP BERKALA',0,0,'L',1);$pdf->Ln();	
	$pdf->Cell(190,5,'NAMA PERUSAHAAN :'.$nama[cus_desc] ,0,0,'L',1);$pdf->Ln();	
	$pdf->Cell(190,5,'PERIODE : '.$tglawal1.' s/d '.$tglakhir1,0,0,'L',1);$pdf->Ln();		
	$pdf->Cell(50,5,'SSBP NOMOR :     ',0,'L',1);$pdf->Cell(50,5,'TANGGAL :     ',0,'L',1);
			$pdf->Ln(20);						
			$pdf->Cell(183,5,'OUTWARD','0',0,'R',1);$pdf->Ln();						
			$pdf->Cell(8,5,'NO','LTR',0,'C',1);
			$pdf->Cell(60,5,'DOKUMEN DASAR',1,0,'C',1);
			$pdf->Cell(25,5,'JENIS','LTR',0,'C',1);
			$pdf->Cell(15,5,'JML','LTR',0,'C',1);		
			$pdf->Cell(30,5,'TARIF PNBP',1,0,'C',1);
			$pdf->Cell(45,5,'FLIGHT',1,0,'C',1);
			$pdf->Ln();				
			$pdf->Cell(8,5,'','LBR',0,'C',1);
			$pdf->Cell(20,5,'JENIS',1,0,'C',1);	
			$pdf->Cell(20,5,'NOMOR',1,0,'C',1);			
			$pdf->Cell(20,5,'TANGGAL',1,0,'C',1);
			$pdf->Cell(25,5,'PENERIMAAN','LRB',0,'C',1);			
			$pdf->Cell(15,5,'POS','LRB',0,'C',1);			
			$pdf->Cell(30,5,'(Rp)',1,0,'C',1);			
			$pdf->Cell(20,5,'NO',1,0,'C',1);			
			$pdf->Cell(25,5,'TANGGAL',1,0,'C',1);			
			$pdf->Ln();						
				$pdf->SetFont('Times','',10);
$no=1;
$totaltarif=0;$totalawb=0;			
while($x=mysql_fetch_array($smuk))
{
$tglflight=ymd2dmy3($x[flightdate]);;
	$jmlawb=mysql_fetch_array(mysql_query("select count(distinct o.idmastersmu) as jsmu from isimanifestout as o 
	where o.idmanifestout='$x[idmanifestout]' and o.statusvoid='0' AND o.statuscancel='0'")); 
		if($jmlawb[0]<=$jml1)
	{
		$harganya=$harga1;
		}
		else
		{
					$harganya=$harga2;
			}
	$pdf->SetAligns(array('C','C','C','C','C','C','C','C','C')); 
	$pdf->SetWidths(array(8,20,20,20,25,15,30,20,25)); 		
$pdf->Row(array($no,'BC1.1',$x[nomorpnbp],ymd2dmy3($x[tglpnbp]),
	'PNBP',$jmlawb[0],number_format($harganya, 0, ',', ','),$x[flight],$tglflight));			
	
			$no+=1;
$totaltarif+=$harganya;$totalawb+=$jmlawb[0];		
			
			}
			
	$pdf->SetAligns(array('C','C','C','C','C')); 
	$pdf->SetWidths(array(93,15,30,20,25)); 			
	$pdf->Row(array('TOTAL',$totalawb,number_format($totaltarif, 0, ',', ','),'',''));				
		$pdf->Ln();
		$pdf->Cell(30,5,'',0,0,'L',1);
	$pdf->Cell(50,5,'Medan, ............ 20 ',0,0,'L',1);$pdf->Ln();
	$pdf->Cell(30,5,'',0,0,'L',1);
	$pdf->Cell(100,5,'PENYETOR',0,0,'L',1);$pdf->Cell(50,5,'PENERIMA',0,0,'L',1);
$pdf->Output();

}
?>
