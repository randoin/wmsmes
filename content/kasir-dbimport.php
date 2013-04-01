<?php
  $tgl=date("Y-m-d");
  $p      = new Paging;
  $batas  = 30;
  $posisi = $p->cariPosisi($batas);

  
  $no     = $posisi+1;

if($_POST[carii]=='1')
{
$tampil=mysql_query("SELECT * FROM deliverybill,breakdown where 
deliverybill.idbreakdown=breakdown.id_breakdown  
AND deliverybill.nosmu like '%$_POST[cari]%' ORDER BY id_deliverybill DESC limit $posisi,$batas");
$tampill=mysql_query("SELECT * FROM deliverybill,breakdown where 
deliverybill.idbreakdown=breakdown.id_breakdown 
AND deliverybill.nosmu like '%$_POST[cari]%' ORDER BY id_deliverybill DESC");
}
else
{
$tampil=mysql_query("SELECT * FROM deliverybill,breakdown where 
deliverybill.idbreakdown=breakdown.id_breakdown ORDER BY id_deliverybill DESC limit $posisi,$batas");
$tampill=mysql_query("SELECT * FROM deliverybill,breakdown where 
deliverybill.idbreakdown=breakdown.id_breakdown");
}
?>

<h2>History Delivery Bill Import</h2>
<form name="form1" method="POST" action="?module=dbimport">
	<table>
    	<tr>
        	<td>Cari</td>
            <td> : <input type="text" size="30" name="cari">		
				   <input type="hidden" name="carii" value="1"></td>
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
        <th>No. SMU</th>
        <th>TOTAL BAYAR</th>
        <th>Cara Bayar</th>
        <th>No. DB</th>
		<th>Keterangan</th>
        <th>Cetak</th>
	</tr>

	<?php	
		while ($r=mysql_fetch_array($tampil)){
		$total=round(($r[document]+$r[overtime]+$r[lain]-$r[diskon])/10)*10;
		$tgl=ymd2dmy($r[tglbayar]);
		$formattotal=number_format($total, 0, '.', '.');   
		$nodb='DBI-'.$r[nodb];
	?>
    <tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
    	<td><?php $no ?></td>
        <td><?php $tgl ?></td>
        <td><?php $r['no_smubtb'] ?></td>
        <td><?php Rp. $formattotal ?></td>
        <td><?php $r['id_carabayar'] ?></td>
        
	<?php					
		if($r[11]=='1')
			{
				echo "<td><font color=RED><B>$nodb (VOID)</B></font></td>";
			}
		else 
			{
				echo "<td>$nodb</td>";
			}
	?>
		<td>$r[16]</td>
		<td><a href=?module=cetakdb&n=$r[id_deliverybill] alt='klik untuk mencetak ulang kuitansi pembayaran'
			title='klik untuk mencetak ulang kuitansi pembayaran'><img src=images/b_print.png border=0 hspace=5>
			</a>
        <?php	
			if(($r[status_ambil]=='INSTORE')AND ($r[11]=='0'))
				{
					echo "<a href=\"?module=voiddb&n=$nodb&i=$r[no_smubtb]&s=0&b=$r[idbreakdown]\" 
					onclick=\"javascript:return confirm('VOID hanya dapat dilakukan bila barang sudah terbayar tapi belum 
					keluar gudang. Proses VOID ini akan direkam beserta alasan VOID. 
					Apakah Anda yakin akan VOID barang ini ?')\"><img src=images/b_drop.png border=0 hspace=5 alt=\"klik untuk melakukan void\" title=\"klik untuk melakukan void\"></a>					
					</td></tr>";
				}

     $no++;
  }
  echo "</table>";
  $jmldata      = mysql_num_rows($tampill);
  $jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
  $linkHalaman  = $p->navHalaman($_GET[h], $jmlhalaman,'0');

  echo "<p>$linkHalaman</p>";
?>