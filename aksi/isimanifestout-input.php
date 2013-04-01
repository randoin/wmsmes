<?php
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
?>