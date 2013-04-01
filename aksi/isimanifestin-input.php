<?php
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
?>