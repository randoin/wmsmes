<h2>Masukkan No. BTB/No. SMU</h2>
<form method="POST" action="aksi.php?module=deliverybill&act=caribtbsmu">
	<input type="input" name="nobtbsmu" size="40" onChange="javascript:this.value=this.value.toUpperCase();" autocomplete="off">
    <input type="submit" value="CHECK">
</form>

<?php	
	if($_GET[psn]=='t')
	{
		$halo='Barang Transit';
		echo "<p class=error>$halo</p>";
		echo "<p>INFO: <BR>Masukkan Nomor Bukti Timbang Barang (<B>No. BTB</B>) 
					untuk DeliveryBill <B>export</B>. <BR>Masukkan nomor Surat Muatan Udara/Airway Bill 
					(<B>No. SMU/AWB</B>) untuk DeliveryBill <B>import</B></p>";
	} 
	elseif($_GET[psn]=='w')
	{
		$halo='Barang masih di cek - Belum Confirm';
		echo "<p class=error>$halo</p>";
		echo "<p>INFO: <BR>Masukkan Nomor Bukti Timbang Barang (<B>No. BTB</B>) 
					untuk DeliveryBill <B>export</B>. <BR>Masukkan nomor Surat Muatan Udara/Airway Bill 
					(<B>No. SMU/AWB</B>) untuk DeliveryBill <B>import</B></p>";
	} 
	elseif($_GET[psn]=='o')
	{
		$halo='Barang sudah OUT';
		echo "<p class=error>$halo</p>";
		echo "<p>INFO: <BR>Masukkan Nomor Bukti Timbang Barang (<B>No. BTB</B>) 
					untuk DeliveryBill <B>export</B>. <BR>Masukkan nomor Surat Muatan Udara/Airway Bill 
					(<B>No. SMU/AWB</B>) untuk DeliveryBill <B>import</B></p>";
	} 
	elseif($_GET[psn]=='e')
	{
		$halo='Data tidak ditemukan';
		echo "<p class=error>$halo</p>";
		echo "<p>INFO: <BR>Masukkan Nomor Bukti Timbang Barang (<B>No. BTB</B>) 
					untuk DeliveryBill <B>export</B>. <BR>Masukkan nomor Surat Muatan Udara/Airway Bill 
					(<B>No. SMU/AWB</B>) untuk DeliveryBill <B>import</B></p>";
	} 
	else
 	{
  	echo "<p>INFO: <BR>Masukkan Nomor Bukti Timbang Barang (<B>No. BTB</B>) untuk DeliveryBill
		<B>export</B>. <BR>Masukkan nomor Surat Muatan Udara/Airway Bill (<B>No. SMU/AWB</B>) untuk 
		DeliveryBill <B>import</B></p>";
 	}

?>