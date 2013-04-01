<?php
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
?>