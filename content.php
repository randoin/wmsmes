<script type="text/javascript" src="config/jquery-1.4.2.min.js"></script>	
<script type="text/javascript" src="config/jquery.maskedinput.js"></script>	
		
	
<?php
include "config/koneksi.php";
include "config/fpdf.php";
include "config/library.php";
include "config/fungsi_indotgl.php";
include "config/fungsi_combobox.php";
include "config/class_paging.php";



// Module Home
if (($_GET['module']=='home'))
{
	include "content/content-home.php";
}
// end of home


else if (($_GET['module']=='batascetakmanifest'))
{
	include "content/content-batascetakmanifest.php";
}

else if (($_GET['module']=='batascetakbongkar'))
{
	include "content/content-batascetakbongkar.php";
}
// end of home

// Manajemen User
elseif (($_GET['module']=='user')AND($_SESSION['level']=='admin'))
{
	include "content/admin-user.php";
}

// Form tambah user
elseif (($_GET['act']=='tambahuser')AND($_SESSION['level']=='admin'))
{
	include "content/admin-tambahuser.php";
}

// Form edit user
elseif (($_GET['act']=='edituser')AND($_SESSION['level']=='admin'))
{
	include "content/admin-edituser.php";
}

//start melihat data user
// Form edit user
elseif ($_GET['module']=='myacc')
{
	include "content/myaccount.php";
}
//

//update 11 sept 2010
//---------------Menampilkan Data cKurs-------------------------------------------------
elseif (($_GET['module']=='dolar')AND($_SESSION['level']=='admin'))
{
	include "content/admin-dolar.php";
}
//---------------End of Menampilkan Data Kurs Dolar ------------------------------------


//---------------Menambah Data Dolar----------------------------------------------------
elseif (($_GET['act']=='tambah_datadolar')AND($_SESSION['level']=='admin'))
{
	include "content/admin-tambah_datadolar.php";
}
//---------------End of Menambah Data Dolar---------------------------------------------


//---------------Mengedit Data dolar----------------------------------------------------
elseif (($_GET['act']=='edit_datadolar')AND($_SESSION['level']=='admin'))
{
	include "content/admin-edit_datadolar.php";
}
//---------------End of Mengedit Data dolar---------------------------------------------


//---------------Menampilkan harga pnbp-------------------------------------------------
elseif (($_GET['module']=='pnbp')AND($_SESSION['level']=='admin'))
{
	include "content/admin-pnbp.php";
}
//---------------End of Menampilkan Tarif PNBP-------------------------------------------------


//---------------Menambah Data PNBP-----------------------------------------------------------
elseif (($_GET['act']=='tambah_datapnbp')AND($_SESSION['level']=='admin'))
{
	include "content/admin-tambah_datapnbp.php";
}
//---------------End of Menambah Data PNBP-----------------------------------------------------------



//******************************START OF BTB INTER *************************************

//---------------Menampilkan Data SMU-------------------------------------------------
elseif (($_GET['module']=='carismu')AND($_SESSION['level']=='btb'))
{
	include "content/btb-carismu.php";
}
//-------------------------------- end of cari SMU -------------------------------------------


//-----------------Menampilkan Data AWB Today-------------------------------------------------
elseif (($_GET['module']=='awbtoday')AND($_SESSION['level']=='btb'))
{
	include "content/btb-awbtoday.php";
}
//---------------End of Menampilkan Data AWB Today-------------------------------------------------


//---------------Menambah Data AWB TODAY-----------------------------------------------------------
elseif (($_GET['act']=='tambah_awbtoday')AND($_SESSION['level']=='btb'))
{
	include "content/btb-tambah_awbtoday.php";
}
//---------------End of Menambah Data AWB TODAY-----------------------------------------------------------


//---------------MENGEDIT AWB-----------------------------------------------------------
elseif (($_GET['act']=='edit_carismu')AND($_SESSION['level']=='btb'))
{
	include "content/btb-edit_carismu.php";
}
//---------------End of MENGEDIT SMU-----------------------------------------------------------


//************************************** END OF BTB ******************************************************


//**************************************** START OF EXPORT ***********************************************
//---------------Menampilkan Isi Data Manifest Export-------------------------------------------------
//---------------Menampilkan Data SMU-------------------------------------------------
elseif (($_GET['module']=='carismu')AND($_SESSION['level']=='export'))
{
	include "content/export-carismu.php";
}
//-------------------------------- end of cari SMU -------------------------------------------


//Melihat data isi manifest export------------------
elseif (($_GET['module']=='isimanifestexport')AND($_SESSION['level']=='export'))
{
	include "content/export-isimanifestexport.php";
}
//-------------------------------- end of ISi Manifest Export -------------------------------------------


//---------------Menambah Data Isi Manifest Export-----------------------------------------------------------
elseif (($_GET['act']=='tambah_isimanifestexport')AND($_SESSION['level']=='export'))
{
	include "content/export-tambah_isimanifestexport";
}
//---------------End of Menambah Data Isi Manifest Export-----------------------------------------------------------


//--------------Menambah Berat ULD
elseif (($_GET['module']=='beratuld')AND($_SESSION['level']=='export'))
{
	include "content/export-beratuld.php";
}	
//-------------------------------------------


//---------------Menampilkan Data Manifest Export-------------------------------------------------
elseif (($_GET['module']=='carimanifestexport')AND($_SESSION['level']=='export'))
{
	include "content/export-carimanifestexport.php";
}
//-------------------------------- end of cari Manifest Export -------------------------------------------


else if($_GET['module']=='inputpnbp')
{
	include "content/inputpnbp.php";
}

else if($_GET['module']=='inputepnbp')
{
	include "content/inputepnbp.php";
}

//-----------------MenampilkanData Manifest Export Today-------------------------------------------------

elseif (($_GET['module']=='manifestexport_today')AND($_SESSION['level']=='export'))
{
	include "content/export-manifestexport_today.php";
}
//---------------End of MenampilkanData Manifest Export Today-------------------------------------------------


//---------------Menambah Data Manifest Export-----------------------------------------------------------
elseif (($_GET['act']=='tambah_manifestexport')AND($_SESSION['level']=='export'))
{
	include "content/export-tambah_manifestexport.php";
}
//---------------End of Menambah Data Manifest Export-----------------------------------------------------------


//---------------Mengedit Data Manifest Export-----------------------------------------------------------
elseif (($_GET['act']=='edit_carimanifestexport')AND($_SESSION['level']=='export'))
{
	include "content/export-edit_carimanifestexport.php";
}
//---------------End of Mengedit Data Manifest Export-----------------------------------------------------------
//***************************************************************************************************



//******************************START OF SUPERVISOR INTER *************************************
//Melihat data isi manifest export------------------
elseif (($_GET['module']=='isimanifestexport')AND($_SESSION['level']=='supervisor'))
{
	include "content/spv-isimanifestexport.php";
}
//-------------------------------- end of Data Manifest Export -------------------------------------------


//---------------Menampilkan Data dan Release Manifest Export-------------------------------------------------
elseif (($_GET['module']=='carimanifestexport')AND($_SESSION['level']=='supervisor'))
{
	include "content/spv-carimanifestexport.php";
}
//-------------------------------- end of cari Manifest Export -------------------------------------------


//---------------Menampilkan Data Region-------------------------------------------------
elseif (($_GET['module']=='dataregion')AND($_SESSION['level']=='export'))
{
	include "content/export-dataregion.php";
}
//---------------End of Menampilkan Data Region-------------------------------------------------


//---------------Menambah Data Region-----------------------------------------------------------
elseif (($_GET['act']=='tambah_dataregion')AND($_SESSION['level']=='export'))
{
	include "content/export-tambah_dataregion.php";
}
//---------------End of Menambah Data Region-----------------------------------------------------------


//---------------Mengedit Data Region-----------------------------------------------------------
elseif (($_GET['act']=='edit_dataregion')AND($_SESSION['level']=='export'))
{
	include "content/export-edit_dataregion.php";
}
//---------------End of Mengedit Data Region-----------------------------------------------------------


//---------------Menampilkan Data commodity-------------------------------------------------
elseif (($_GET['module']=='datacommodity')AND($_SESSION['level']=='supervisor'))
{
	include "content/spv-datacommodity.php";
}

//---------------End of Menampilkan Data commodity-------------------------------------------------


//---------------Menambah Data commodity-----------------------------------------------------------
elseif (($_GET['act']=='tambah_datacommodity')AND($_SESSION['level']=='supervisor'))
{
	include "content/spv-tambah_datacommodity.php";
}
//---------------End of Menambah Data commodity-----------------------------------------------------------


//---------------Mengedit Data commodity-----------------------------------------------------------
elseif (($_GET['act']=='edit_datacommodity')AND($_SESSION['level']=='supervisor'))
{
	include "content/spv-edit_datacommodity.php";
}
//---------------End of Mengedit Data commodity-----------------------------------------------------------


//---------------Menampilkan Data customer-------------------------------------------------
elseif (($_GET['module']=='datacustomer')AND($_SESSION['level']=='supervisor'))
{
	include "content/spv-datacustomer.php";
}
//---------------End of Menampilkan Data customer-------------------------------------------------


//---------------Menambah Data customer-----------------------------------------------------------
elseif (($_GET['act']=='tambah_datacustomer')AND($_SESSION['level']=='supervisor'))
{
	include "content/spv-tambah_datacustomer.php";
}
//---------------End of Menambah Data customer-----------------------------------------------------------


//---------------Mengedit Data customer-----------------------------------------------------------
elseif (($_GET['act']=='edit_datacustomer')AND($_SESSION['level']=='supervisor'))
{
	include "content/spv-edit_datacustomer.php";
}
//---------------End of Mengedit Data customer-----------------------------------------------------------


//---------------Menampilkan Data agent-------------------------------------------------
elseif (($_GET['module']=='dataagent')AND($_SESSION['level']=='supervisor'))
{
	include "content/spv-dataagent.php";
}
//---------------End of Menampilkan Data agent-------------------------------------------------


//---------------Mengedit Data agent-----------------------------------------------------------
elseif (($_GET['act']=='edit_dataagent')AND($_SESSION['level']=='supervisor'))
{
	include "content/spv-edit_dataagent.php";
}
//---------------End of Mengedit Data agent-----------------------------------------------------------


//---------------Menambah Data Agent-----------------------------------------------------------
elseif (($_GET['act']=='tambah_dataagent')AND($_SESSION['level']=='supervisor'))
{
	include "content/spv-tambah_dataagent.php";
}
//---------------End of Menambah Data Agent-----------------------------------------------------------


//---------------Menampilkan Data flight-------------------------------------------------
elseif (($_GET['module']=='dataflightno')AND($_SESSION['level']=='supervisor'))
{
	include "content/spv-dataflightno.php";
}
//---------------End of Menampilkan Data flight-------------------------------------------------


//---------------Menambah Data flight-----------------------------------------------------------
elseif (($_GET['act']=='tambah_dataflight')AND($_SESSION['level']=='supervisor'))
{
	include "content/spv-tambah_dataflight.php";
}
//---------------End of Menambah Data flight-----------------------------------------------------------


//---------------Mengedit Data flight-----------------------------------------------------------
elseif (($_GET['act']=='edit_dataflight')AND($_SESSION['level']=='supervisor'))
{
	include "content/spv-edit_dataflight.php";
}
//---------------End of Mengedit Data flight-----------------------------------------------------------


//---------------Menampilkan Data destination-------------------------------------------------
elseif (($_GET['module']=='datadestinasi')AND($_SESSION['level']=='export'))
{
	include "content/export-datadestinasi.php";
}
//---------------End of Menampilkan Data destination-------------------------------------------------


//---------------Menambah Data destination-----------------------------------------------------------
elseif (($_GET['act']=='tambah_datadestination')AND($_SESSION['level']=='export'))
{
	include "content/export-tambah_datadestination.php";
}
//---------------End of Menambah Data destination-----------------------------------------------------------


//---------------Mengedit Data destination-----------------------------------------------------------
elseif (($_GET['act']=='edit_datadestination')AND($_SESSION['level']=='export'))
{
	include "content/export-edit_datadestination.php";
}
//---------------End of Mengedit Data destination-----------------------------------------------------------


//---------------Menampilkan Data origin-------------------------------------------------
elseif (($_GET['module']=='dataorigin')AND($_SESSION['level']=='export'))
{
	include "content/export-dataorigin.php";
}
//---------------End of Menampilkan Data origin-------------------------------------------------


//---------------Menambah Data origin-----------------------------------------------------------
elseif (($_GET['act']=='tambah_dataorigin')AND($_SESSION['level']=='export'))
{
	include "content/export-tambah_dataorigin.php";
}
//---------------End of Menambah Data origin-----------------------------------------------------------


//---------------Mengedit Data origin-----------------------------------------------------------
elseif (($_GET['act']=='edit_dataorigin')AND($_SESSION['level']=='export'))
{
	include "content/export-edit_dataorigin.php";
}
//---------------End of Mengedit Data origin-----------------------------------------------------------


//---------------Menampilkan Data Commodity AP-------------------------------------------------
elseif (($_GET['module']=='datacommodity_ap')AND($_SESSION['level']=='export'))
{
	include "content/export-datacommodity_ap.php";
}
//---------------End of Menampilkan Data Commodity AP-------------------------------------------------


//---------------Menambah Data Commodity AP-----------------------------------------------------------
elseif (($_GET['act']=='tambah_datacommodity_ap')AND($_SESSION['level']=='export'))
{
	include "content/export-tambah_datacommodity_ap.php";
}
//---------------End of Menambah Data Commodity AP-----------------------------------------------------------


//---------------Mengedit Data Commodity AP-----------------------------------------------------------
elseif (($_GET['act']=='edit_datacommodity_ap')AND($_SESSION['level']=='export'))
{
	include "content/export-edit_datacommodity_ap.php";
}
//---------------End of Mengedit Data Commodity AP-----------------------------------------------------------

//******************************END OF SUPERVISOR INTER *************************************




//****************************** START OF EXPORT INTER **************************************

//---------------Menampilkan Data SMU INTER-------------------------------------------------
elseif (($_GET['module']=='datasmuinter')AND($_SESSION['level']=='export'))
{
	include "content/export-datasmuinter.php";
}
//---------------End of Menampilkan Data SMU INTER-------------------------------------------------


//---------------Menambah Data SMU Inter-----------------------------------------------------------
elseif (($_GET['act']=='tambah_datasmuinter')AND($_SESSION['level']=='export'))
{
	include "content/export-tambah_datasmuinter.php";
}
//---------------End of Menambah Data SMU Inter-----------------------------------------------------------


// Form edit user
elseif (($_GET['act']=='edituser')AND($_SESSION['level']=='admin'))
{
	include "conten/admin-edituser2.php";
}

// Harga Sewa Gudang
elseif (($_GET['module']=='sewagudang')AND($_SESSION['level']=='supervisor'))
{
	include "content/spv-sewagudang.php";
}

// Harga Sewa Gudang Export Asosiasi
elseif (($_GET['module']=='sewagudangexasosiasi')AND($_SESSION['level']=='supervisor'))
{
	include "content/spv-sewagudangexasosiasi.php";
}

// Harga Sewa Gudang Export Non Asosiasi
elseif (($_GET['module']=='sewagudangexnonasosiasi')AND($_SESSION['level']=='supervisor'))
{
	include "content/spv-sewagudangexnonasosiasi.php";
}

// Harga Sewa Gudang Import Asosiasi
elseif (($_GET['module']=='sewagudangimasosiasi')AND($_SESSION['level']=='supervisor'))
{
	include "content/spv-sewagudangimasosiasi.php";
}

// Harga Sewa Gudang Import Non Asosiasi
elseif (($_GET['module']=='sewagudangimnonasosiasi')AND($_SESSION['level']=='supervisor'))
{
	include "content/spv-sewagudangimnonasosiasi.php";
}
//************************************ END OF SUPERVISOR ***************************************************


//************************************ START OF ADMIN ***************************************************
// Bagian Modul
elseif (($_GET['module']=='modul')AND($_SESSION['level']=='admin'))
{
	include "content/admin-modul.php";
}

// Form Tambah Modul
elseif (($_GET['act']=='tambahmodul')AND($_SESSION['level']=='admin'))
{
	include "content/admin-tambahmodul.php";
}

// Form Edit Modul
elseif (($_GET['act']=='editmodul')AND($_SESSION['level']=='admin'))
{
	include "content/admin-editmodul.php";
}

//************************************ END OF ADMIN ***************************************************



//************************START OF KASIR***************************************************
//Modul DeliveryBill
elseif (($_GET['module']=='deliverybill')AND ($_SESSION['level']=='kasir'))
{
  include "content/kasir-deliverybill.php";
}
//cetak laporan harian
elseif (($_GET['module']=='kasirlap')AND ($_SESSION['level']=='kasir'))
{
  include "content/kasir-kasirlap.php";
}
//cetak laporan harian periodical
elseif (($_GET['module']=='kasirlapp')AND ($_SESSION['level']=='kasir'))
{
  include "content/kasir-kasirlapp.php";	
}
//MODUL DAILY REPORT KASIR
elseif (($_GET['module']=='dailyreport')AND ($_SESSION['level']=='kasir'))
{
   include "content/kasir-dailyreport.php";
}

//Modul Bayar
elseif (($_GET['module']=='bayar')AND ($_SESSION['level']=='kasir'))
{
	include "content/kasir-bayar.php";
}

elseif (($_GET['module']=='cetakdb')AND ($_SESSION['level']=='kasir'))
{
	include "content/kasir-cetakdb.php";
}

elseif (($_GET['module']=='nosmuedit')AND($_SESSION['level']=='kasir'))
{
	include "content/kasir-nosmuedit.php";
}		

//Form histori DBO
elseif (($_GET['module']=='dbexport')AND ($_SESSION['level']=='kasir'))
{
	include "content/kasir-dbexport.php";
}

//Form data  DBI
elseif (($_GET['module']=='dbimport')AND ($_SESSION['level']=='kasir'))
{
	include "content/kasir-dbimport.php";
}




//************************END OF KASIR***************************************************

//LEVEL BTB
//inputkan isi SMU
elseif (($_GET['module']=='btbinput')AND ($_SESSION['level']=='btb'))
{
	include "content/btb-btbinput.php";
}

//daftar BTB
elseif (($_GET['module']=='daftarbtb')AND ($_SESSION['level']=='btb'))
{
	include "content/btb-daftarbtb.php";
}

//Input SMU1
elseif (($_GET['module']=='btb') AND ($_SESSION['level']=='btb'))
{
	include "content/btb-btb.php";
}

//Edit SMU
elseif (($_GET['module']=='editbtb') AND ($_SESSION['level']=='btb'))
{
	include "content/btb-editbtb.php";
}

elseif (($_GET['module']=='manifestin') AND ($_SESSION['level']=='import'))
{
	include "content/import-manifestin.php";
}

//Editing Header Manifest
elseif ($_GET['module']=='editmanifestin')
{
	include "content/import-editmanifestin.php";
}				

//Input data isi manifest
elseif (($_GET['module']=='manifestininput')AND ($_SESSION['level']=='import'))
{
	include "content/import-manifestinput.php";
}

//Edit Isi dari Manifest
elseif (($_GET['module']=='editisimanifestin')AND ($_SESSION['level']=='import'))
{
	include "content/import-editisimanifestin.php";
}				

//barang datang
elseif (($_GET['module']=='barangdatang')AND ($_SESSION['level']=='import'))
{
	include "content/import-barangdatang.php";
}

//Pecah SMU
elseif (($_GET['module']=='splitsmu') AND ($_SESSION['level']=='import'))
{
	include "content/import-splitsmu.php";
}

//Edit SMU dan Brekadown
elseif (($_GET['module']=='breakdownedit')AND($_SESSION['level']=='import'))
{
	include "content/import-breakdownedit.php";
}

//*****CANCEL SMU - Ada di Manifest, tetapi tidak ada barang datang
elseif (($_GET['module']=='isimanifestindel')AND($_SESSION['level']=='import'))
{
	include "content/import-isimanifestindel.php";
}

//************************END OF IMPORT ***************************************************


//*************************** begin of level export **************************************
//LEVEL export
//batal manifest out
elseif (($_GET['module']=='batalmo')AND($_SESSION['level']=='export'))
{
	include "content/export-batalmo.php";
}

//Input Header Manifest
elseif (($_GET['module']=='manifestout') AND ($_SESSION['level']=='export'))
{
	include "content/export-manifestout.php";
}

//Edit Header Manifest
elseif ($_GET['module']=='editmanifestout')
{
	include "content/export-editmanifestout.php";
}				

//Input data isi manifest
elseif (($_GET['module']=='manifestoutinput')AND ($_SESSION['level']=='export'))
{
	include "content/export-manifestoutinput.php";
}

//Edit Isi dari Manifest
elseif (($_GET['module']=='editisimanifestout')AND ($_SESSION['level']=='export'))
{
	include "content/export-editisimanifestout.php";
}				

//barang keluar
elseif (($_GET['module']=='barangkeluar')AND ($_SESSION['level']=='export'))
{
	include "content/export-barangkeluar.php";
}

//Pecah SMU
elseif (($_GET['module']=='splitsmu') AND ($_SESSION['level']=='export'))
{
	include "content/export-splitsmu.php";
}

//Edit SMU dan Brekadown
elseif (($_GET['module']=='breakdownedit')AND($_SESSION['level']=='export'))
{
	include "content/export-breakdownedit.php";
}

//*****HAPUS ISI MANIFEST
elseif (($_GET['module']=='isimanifestoutdel')AND($_SESSION['level']=='export'))
{
	include "content/export-isimanifestoutdel.php";
}

//Form cetak stockopname export
elseif (($_GET['module']=='stockopnameout')AND($_SESSION['level']=='export'))
{
	include "content/export-stockopnameout.php";
}
// end of stockname export

//************************END OF export ***************************************************
//******************************************************************************************





//****************** SUPERVISOR **************//
elseif (($_GET['module']=='reportdo')AND ($_SESSION['level']=='supervisor'))
{
	include "content/spv-reportdo.php";
}

elseif (($_GET['module']=='daily_report')AND ($_SESSION['level']=='supervisor'))
{
	include "content/spv-dailyreport.php";
}

//flown
elseif (($_GET['module']=='flown_ga')AND ($_SESSION['level']=='supervisor'))
{
	include "content/spv-flown_ga.php";
}

//////
//periodic report cargo
elseif (($_GET['module']=='flightdata')AND ($_SESSION['level']=='supervisor'))
{
	include "content/spv-flightdata.php";
}
////

//periodic report cargo
elseif (($_GET['module']=='period_report')AND ($_SESSION['level']=='supervisor'))
{
	include "content/spv-period_report.php";
}

//summary_report_cargo
elseif (($_GET['module']=='summary_cargo')AND ($_SESSION['level']=='supervisor'))
{
	include "content/spv-summary_cargo.php";
}

//Form void delivery bill
elseif (($_GET['module']=='data')AND ($_SESSION['level']=='supervisor'))
{
	include "content/spv-data.php";
}

//void deliverybill
elseif (($_GET['module']=='voiddb')AND($_SESSION['level']=='kasir'))
{
	include "kasir-voiddb.php";
}

//Form void import
elseif (($_GET['module']=='superimport')AND ($_SESSION['level']=='supervisor'))
{
	include "content/spv-superimport.php";
}

//************************END OF super***************************************************
//**********************************************






//Form Manifset out
elseif (($_GET['module']=='manifestout11')AND ($_SESSION['level']=='export'))
{
	include "content/export-manifestout11.php";
}

// Form tambah manifest out
elseif (($_GET['act']=='tambahmanifestoutjjj')AND($_SESSION['level']=='export'))
{
	include "content/export-tambahmanifestoutjjj.php";
}

//Form buildup
elseif (($_GET['act']=='buildup')AND ($_SESSION['level']=='export'))
{
	include "content/export-buildup.php";
}

// Form tambah buildup
elseif (($_GET['act']=='tambahbuildup')AND($_SESSION['level']=='export'))
{
	include "content/export-tambahbuildup.php";
}



//***************************************************************************************
// BAGIAN OUTBOUND
//***************************************************************************************

//Form BARANG OUTBOUND
elseif (($_GET['act']=='barangoutbound')AND ($_SESSION['level']=='outbound'))
{
	include "content/outbound-barangoutbound.php";
}

// Form tambah Barang OUTBOUND
elseif (($_GET['act']=='tambahbarangoutbound')AND($_SESSION['level']=='outbound'))
{
	include "content/outbound-tambahbarangoutbound.php";
}

//************************END OF OUTBOUND***************************************************



// Form Balas Email
elseif ($_GET['act']=='balasemail')
{
	include "content/balasemail.php";
}

// Kirim Email
elseif ($_GET['module']=='kirimemail')
{
	include "kirimemail.php";
}

/*
if ($module=='backup' AND $act=='supervisor')
{
//  header('location:media.php?module='.$module);

	//Create a list of tables to be exported
	$table_list = array();
	while($t = mysql_fetch_array($tables))
	{
		array_push($table_list, $t[0]);
	}

	//Instantiate the SQL_Export class
	require("SQL_Export.php");
	$e = new SQL_Export($server, $username, $password, $database, $table_list);
	//Run the export
	echo $e->export();

	//Clean up the joint
	mysql_close($e->cnx);
	mysql_close($cnx);
}
*/



//IMPORT!!!
//---------------Menampilkan Data SMU-------------------------------------------------
elseif (($_GET['module']=='carismu')AND($_SESSION['level']=='import'))
{
	include "content/import-carismu.php";
}

//-------------------------------- end of cari SMU -------------------------------------------


//update 11 sept 2010
//menambah AWB import
elseif (($_GET['module']=='tambah_awb')AND($_SESSION['level']=='import'))
{
	include "content/import-tambah_awb.php";
}
//end of menambah import


//-----------------MenampilkanData Manifest Import Today-------------------------------------------------
elseif (($_GET['module']=='manifestimport_today')AND($_SESSION['level']=='import'))
{
	include "content/import-manifestimport_today.php";
}
//---------------End of MenampilkanData Manifest Import Today-------------------------------------------------


//---------------Menambah Data Manifest Import-----------------------------------------------------------
elseif (($_GET['act']=='tambah_manifestimport')AND($_SESSION['level']=='import'))
{
	include "content/import-tambah_manifestimport.php";
}
//---------------End of Menambah Data Manifest Import-----------------------------------------------------------


//---------------Mengedit Data Manifest Import-----------------------------------------------------------
elseif (($_GET['act']=='edit_carimanifestimport')AND($_SESSION['level']=='import'))
{
	include "content/import-edit_carimanifestimport.php";
}
//---------------End of Mengedit Data Manifest Import-----------------------------------------------------------


//---------------Menampilkan Data Manifest Import-------------------------------------------------
elseif (($_GET['module']=='carimanifestimport')AND($_SESSION['level']=='import'))
{
	include "content/import-carimanifestimport.php";
}
//---------------end of cari Manifest Import 


//---------------Melihat data isi Manifest Import------------------
elseif (($_GET['module']=='isimanifestimport')AND($_SESSION['level']=='import'))
{
	include "content/import-isimanifestimport.php";
}
//---------------end of ISi Manifest Import -------------------------------------------


//---------------Menambah Data Isi Manifest Import-----------------------------------------------------------
elseif (($_GET['act']=='tambah_isimanifestimport')AND($_SESSION['level']=='import'))
{
	include "content/import-tambah_isimanifestimport.php";
}
//---------------END of Menambah Data Isi Manifest Import-----------------------------------------------------------


//mengedit isimanifestin import
elseif (($_GET['act']=='edit_isimanifestimport')AND($_SESSION['level']=='import'))
{
	include "content/edit_isimanifestimport";
}
//end of menambah import


//---------------MENGEDIT AWB-----------------------------------------------------------
elseif (($_GET['module']=='edit_awbimport')AND($_SESSION['level']=='import'))
{
	include "content/import-edit_awbimport.php";
}
//end of Mengedit AWB Impor


//---------------Menampilkan Data SMU-------------------------------------------------
elseif (($_GET['module']=='cariawbimport')AND($_SESSION['level']=='supervisor'))
{
	include "content/spv-cariawbimport.php";
}
//-------------------------------- end of cari SMU -------------------------------------------


//---------------Menampilkan Data Consignee-------------------------------------------------
elseif (($_GET['module']=='consignee')AND($_SESSION['level']=='import'))
{
	include "content/import-consignee.php";
}
//---------------End of Menampilkan Data Consignee-------------------------------------------------


//---------------Menambah Data Consignee-----------------------------------------------------------
elseif (($_GET['act']=='tambah_consignee')AND($_SESSION['level']=='import'))
{
	include "content/import-tambah_consignee.php";
}
//---------------End of Menambah Data Consignee-----------------------------------------------------------


//---------------Mengedit Data Consignee-----------------------------------------------------------
elseif (($_GET['act']=='edit_consignee')AND($_SESSION['level']=='import'))
{
	include "content/import-edit_consignee.php";
}
//---------------End of Mengedit Data Consignee----------------------------------------------------


//---------------Menampilkan DATA SHIPPER-------------------------------------------------
elseif (($_GET['module']=='shipper')AND($_SESSION['level']=='import'))
{
	include "content/import-shipper.php";
}
//---------------End of Menampilkan Data shipper-------------------------------------------------


//---------------Menambah Data shipper-----------------------------------------------------------
elseif (($_GET['act']=='tambah_shipper')AND($_SESSION['level']=='import'))
{
	include "content/import-tambah_shipper.php";
}
//---------------End of Menambah Data shipper-----------------------------------------------------------


//---------------Mengedit Data shipper-----------------------------------------------------------
elseif (($_GET['act']=='edit_shipper')AND($_SESSION['level']=='import'))
{
	include "content/import-edit_shipper.php";
}
//---------------End of Mengedit Data shipper-----------------------------------------------------------


//---------------Menampilkan Data connectingflight-------------------------------------------------
elseif (($_GET['module']=='connectingflight')AND($_SESSION['level']=='supervisor'))
{
	include "content/spv-connectingflight.php";
}
//---------------End of Menampilkan Data connectingflight-------------------------------------------------


//---------------Menambah Data connectingflight-----------------------------------------------------------
elseif (($_GET['act']=='tambah_dataconnectingflight')AND($_SESSION['level']=='supervisor'))
{
	include "content/spv-tambah_dataconnectingflight.php";
}
//---------------End of Menambah Data connectingflight-----------------------------------------------------


//---------------Mengedit Data connectingflight-----------------------------------------------------------
elseif (($_GET['act']=='edit_dataconnectingflight')AND($_SESSION['level']=='supervisor'))
{
	include "content/spv-edit_dataconnectingflight.php";
}
//---------------End of Mengedit Data destination-----------------------------------------------------------


//UMUM
elseif (($_GET['module']=='inputoutput')AND($_SESSION['level']=='import'))
{
	include "content/import-inputoutput.php";
}
//---------------End of Menambah Input Output-----------------------------------------------------------


//memasukkan harga
elseif (($_GET['module']=='harga')AND($_SESSION['level']=='import'))
{
	include "content/import-harga.php";
}
//end of harga


//---------------Mengedit Input Output-------------------------------------------------------
elseif (($_GET['module']=='edit_inputoutput')AND($_SESSION['level']=='import'))
{
	include "content/import-edit_inputoutput.php";
}
//---------------End of Mengedit Input Output-----------------------------------------------------------


//Form cetak stockopname import
elseif (($_GET['module']=='stockopnamein')AND($_SESSION['level']=='import'))
{
	include "content/import-stockopnamein.php";
}
// end of stockname import


//---------------Report Flight------------------------------------------------------------
elseif (($_GET['module']=='reportflight')AND ($_SESSION['level']=='supervisor'))
{
	include "content/spv-reportflight.php";
}
//---------------End Of Report Flight-----------------------------------------------------


elseif (($_GET['module']=='cargoreport')AND ($_SESSION['level']=='supervisor'))
{
	include "content/spv-cargoreport.php";
}


//update 11 sept 2010
elseif (($_GET['module']=='bc12charge')AND ($_SESSION['level']=='supervisor'))
{
	include "content/spv-bc12charge.php";
}


elseif (($_GET['module']=='pnbp')AND ($_SESSION['level']=='supervisor'))
{
	include "content/spv-pnbp.php";
}

// Apabila modul tidak ditemukan
else{
  echo "<p align=center><b>MODUL BELUM TERPASANG</b></p>";
}
?>
