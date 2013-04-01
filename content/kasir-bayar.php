<script type="text/javascript">
	/*function hitungtotal(value)
	{
  		var dis=Number(value/100)*(Number (document.getElementById('overtime1').value)+Number (document.getElementById('document1').value));
  		var hasil = Number (document.getElementById('overtime1').value)
			+ Number (document.getElementById('document1').value)-dis;
		var x=Number (document.getElementById('pp').value/100)*hasil;
		var ll=hasil+x;
		document.getElementById('afterdiskon').value=Math.round(dis);
		document.getElementById('afterlain').value=Math.round(x);	
		//document.getElementById('overtime1').value=Math.round(hasil);
		document.getElementById('bt').value=Math.round(ll);	
		document.getElementById('bt0').value=Math.round(ll);
		document.getElementById('ppn1').value=Math.round(x);		
	}*/
	
	function hitungtotal(value)
	{
		var sewa_gudang_discount = Number(value/100)*(Number (document.getElementById('sewagudang').value));
		var sewa_gudang_after_discount = (Number (document.getElementById('sewagudang').value))-Math.round(sewa_gudang_discount);
		var total_before_ppn = Math.round(sewa_gudang_after_discount) + (Number (document.getElementById('kade').value)) + (Number (document.getElementById('administrasi').value));
		var ppn = (Number (document.getElementById('ppn').value)/100);
		var ppn_value = ppn * total_before_ppn;
		var total_after_ppn = Math.round(ppn_value) + Math.round(total_before_ppn);
		document.getElementById('discount_value').value=Math.round(sewa_gudang_discount);
		document.getElementById('after_discount_value').value=Math.round(sewa_gudang_after_discount);
		document.getElementById('total_after_ppn').value=Math.round(total_after_ppn);
		document.getElementById('ppn_value').value=Math.round(ppn_value);
	}
</script>

<?php
date_default_timezone_set('Asia/Jakarta');
$tgl=date("Y-m-d");
/*
$tampil=mysql_query("SELECT * from hargasewa order by id DESC limit 1");
$r=mysql_fetch_array($tampil);

$datasewagudang=$r['sewaperhari'];
$datacargocharge=$r['cargocharge'];
$datakade=$r['kade'];
$datappn=$r['ppn'];
$datadokumen=$r['dokumen'];
$dataminhari=$r['minhari'];
$datamincharge=$r['mincharge'];
$dataminweight=$r['minweight'];
$dataasosiasi=$r['asosiasi'];
$dataloading=$r['loading'];
*/
?>

<?php
$tgl=date("Y-m-d");	
if($_GET['d']=='1') //Export
{
	include "kasir-bayar-export.php";
}
else //Import
{
	include "kasir-bayar-import.php";
}
?>