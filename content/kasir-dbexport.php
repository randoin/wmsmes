<?php
	$tgl=date("Y-m-d");
  	$p      = new Paging;
  	$batas  = 50;
  	$posisi = $p->cariPosisi($batas);

    $no     = $posisi+1;

	if($_POST[carii]=='1')
	{
		$tampil=mysql_query("SELECT * FROM deliverybill,
										   out_dtbarang_h 
									 where deliverybill.no_smubtb=out_dtbarang_h.btb_nobtb 
									   AND (deliverybill.no_smubtb like '%$_POST[cari]%' OR deliverybill.nosmu like '%$_POST[cari]%')ORDER BY deliverybill.id_deliverybill DESC limit $posisi,$batas");

		$tampil1=mysql_query("SELECT * FROM deliverybill,out_dtbarang_h where deliverybill.no_smubtb=out_dtbarang_h.btb_nobtb AND (deliverybill.no_smubtb like '%$_POST[cari]%' OR deliverybill.nosmu like '%$_POST[cari]%')ORDER BY deliverybill.id_deliverybill DESC");

	}
	else
	{
		$tampil=mysql_query("SELECT * FROM deliverybill,out_dtbarang_h where deliverybill.no_smubtb=out_dtbarang_h.btb_nobtb ORDER BY id_deliverybill DESC limit $posisi,$batas");
		$tampil1=mysql_query("SELECT * FROM deliverybill,out_dtbarang_h where deliverybill.no_smubtb=out_dtbarang_h.btb_nobtb ORDER BY id_deliverybill DESC");
		$t="SELECT * FROM deliverybill,out_dtbarang_h where deliverybill.no_smubtb=out_dtbarang_h.btb_nobtb AND tglbayar =  '$tgl' AND id_carabayar='1' AND deliverybill.isVoid='0' ORDER BY id_deliverybill DESC";
	}
//<a href=aksi.php?module=cetaklap&i=1 target=_blank><img src=images/printer.jpg border=0></a>
?>

<h2>History Delivery Bill Export</h2>
<form name="form1" method="POST" action="?module=dbexport">
	<table>
		<tr>
        	<td>Cari No.BTB/No.SMU</td>
            <td> : <input type="text" size="30" name="cari">		
				   <input type="hidden" name="carii" value="1"> </td>
        </tr>
        
	    <tr>
        	<td colspan="2"><input type="submit" value="CARI DATA">
        					<input type="button" value="Batal" onclick="self.history.back()"></td>
        </tr>
	</table>
</form>
	
<table>        
	<tr>
    	<th>no</th>
        <th>Tgl</th>
        <th>No. BTB</th>
        <th>No. SMU</th>
        <th>TOTAL BAYAR</th>
        <th>Agent</th>
        <th>Cara Bayar</th>
        <th>No. DB</th>
        <th>Keterangan</th>
        <th>Action</th>
	</tr>
	<?php	
		while ($r=mysql_fetch_array($tampil))
		{
			$total=round(($r['document']+$r['overtime']+$r['lain']-$r['diskon'])/10)*10;
			$tgl=ymd2dmy($r['tglbayar']);
			$formatdiskon=number_format($r['diskon'], 0, '.', '.');   
			$formatdokumen=number_format($r['document'], 0, '.', '.');   
			$formatstorage=number_format($r['storage'], 0, '.', '.');   
			$formatlain=number_format($r['lain'], 0, '.', '.');   
			$formattotal=number_format($total, 0, '.', '.');   
			$nodb='DBO-'.$r['nodb'];
	?>				
	<tr onmouseover="this.className = 'hlt';" onmouseout="this.className = '';">
		<td><?php echo $no; ?></td>
		<td><?php echo $tgl; ?></td>
        <td><?php echo $r['no_smubtb']; ?></td>
        <td><?php echo $r['btb_smu']; ?></td>
        <td>Rp. <?php echo $formattotal; ?></td>
        <td><?php echo $r['btb_agent']; ?></td>
        <td><?php echo $r['id_carabayar']; ?></td>
        <?php	
			if($r[11]=='1')
				{ ?>
					<td><font color=RED><B><?php echo $nodb; ?> (VOID)</B></font></td>
        <?php
				}
		 	else 
			{
		?>
				<td><?php echo $nodb; ?></td>
        <?php
			}
		?>	
		<td><?php echo $r['keterangan']; ?></td>
		<td><a href=?module=cetakdb&n=<?php echo $r['id_deliverybill']; ?>alt='klik untuk mencetak ulang kuitansi pembayaran' title='klik untuk mencetak ulang kuitansi pembayaran'><img src=images/b_print.png border=0 hspace=5></a>
        <?php	
			if(($r[status_keluar]=='INSTORE')AND ($r[11]=='0'))
				{
					echo "<a href=?module=nosmuedit&n=$r[id] alt='klik untuk melakukan editing No.SMU' title='klik untuk melakukan editing No.SMU'><img src=images/b_edit.png border=0 hspace=5></a> <a href=?module=voiddb&n=$nodb&i=$r[no_smubtb]&s=1 onclick=\"javascript:return confirm('VOID hanya dapat dilakukan bila barang sudah terbayar tapi belum keluar gudang. Proses VOID ini akan direkam beserta alasan VOID. Apakah Anda yakin akan VOID barang ini ?')\"><img src=images/b_drop.png border=0 hspace=5></a></td></tr>";
					}

     $no++;
  }
  echo "</table>";
  $jmldata      = mysql_num_rows($tampil1);
  $jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
  $linkHalaman  = $p->navHalaman($_GET[h], $jmlhalaman,'0');

  echo "<p>$linkHalaman</p>";
?>