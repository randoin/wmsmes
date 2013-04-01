<?php
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
?>