<?php
//jika import
	$jdl='DeliveryBill import - No. SMU : ' .$_GET['n']; 
		$tampil=mysql_query("
			SELECT * from breakdown,isimanifestin,manifestin 
			where breakdown.id_isimanifestin=isimanifestin.id_isimanifestin
			AND isimanifestin.id_manifestin=manifestin.id_manifestin 
			AND breakdown.status_ambil='INSTORE' AND isimanifestin.status_transit='MES'  
			AND isimanifestin.no_smu ='$_GET[n]' AND breakdown.id_breakdown='$_GET[x]' 
			AND breakdown.status_bayar='no' 
			AND breakdown.isvoid='0' AND breakdown.b_iscancel='0'");
	$r=mysql_fetch_array($tampil);		
	
		
		if(($r['beratdatang']<=10) AND ($r['beratbayar']<=10))
			{
				$beratkalitarif=$datamincharge;
			}
		
		else 
			{
				$beratkalitarif=round($r['beratbayar']*$datasewagudang);
			}
		
		$dokumen=$datadokumen;
				
		$lama=ngitunghari($r['tgldatang'],$tgl)+1;
				
			if($lama<=0){$lama=1;}
			
		if($lama<($dataminhari+1)){$lamaku=1;}
		else if($lama>=($dataminhari+1)){$lamaku=$lama-2;}
		
		$total=round(($beratkalitarif*$lamaku)/10)*10;
		$ppn=round(($total+$dokumen)*0.1);
		$total2=round($total+$dokumen+$ppn);
			//bult dsatuan !!!
		$total2sat=round($total2/10)*10;
		
		//
 
		$formatdokumen=number_format($dokumen, 0, '.', '.');
		$formatberatkalitarif=number_format($beratkalitarif, 0, '.', '.');
		$formattotal=number_format($total, 0, '.', '.');   		
		$formatppn=number_format($ppn, 0, '.', '.');
		$formattotal2=number_format($total2, 0, '.', '.');

?>

<h2><?php echo "$jdl"; ?></h2>
    	
<form name="form1" method="POST" action='aksi.php?module=deliverybill&act=input'>
	<table>
    	<tr>
			<td>Penerima</td>     
			<td> : <input type="text" size="30" name="penerima" onChange="javascript:this.value=this.value.toUpperCase();"
            		autocomplete="off"/></td>		
			<td></td>
			<td>No. SMU</td>
			<td> : <input type="text" size="20" value=<?php echo $r['no_smu']; ?> name="nosmu" readonly="true"> *</td>  
		</tr>
       	
        <tr>
			<td>Alamat</td>    
			<td> : <textarea name="alamat" onChange="javascript:this.value=this.value.toUpperCase();"></textarea></td>		
			<td></td>
			<td>Airline/Asal</td>
			<td> : <input type="text" size="20" value="<?php echo $r['airline']; ?>"/"<?php echo $r['asal'];?>" readonly="true"> *</td>     
		</tr>
       	
        <tr>
        	<td>Cargo Charge</td>
            <td> : <input type="text" size="20" value="<?php echo $formatdokumen; ?>" readonly="true"> *</td>
			<td></td>
			<td>Total Berat Bayar (Kg)</td>
			<td> : <input type="text" size="20" value="<?php echo $r['beratbayar']; ?>" readonly="true"> *</td>  
		</tr>		
       	
        <tr>
        	<td>Administrasi (Rp)</td>    
			<td> : <input type="text" size="20" value="<?php echo $formatdokumen; ?>" readonly="true"> *</td>
			<td></td>
		 	<td>Cara Pembayaran</td>
            <td> : <select name="id_carabayar"> </select><option value="CASH" selected>CASH</option>
            		<option value="PERIODICAL">PERIODICAL</option></td>
		</tr>			
       	
        <tr>
			<td>Sewa Gudang/hari (Rp)</td>
			<td> : <input type="text" size="20" value="<?php echo $formatberatkalitarif; ?>" readonly="true"> *</td>
            <td> </td>
		 	<td>Tgl Kedatangan</td>     
			<td> : <input type="text" size="20" value="<?php echo ymd2dmy($r[tgldatang]); ?>" readonly="true"> * </td>		
		</tr>

       	<tr>
			<td>Total Sewa Gudang (Rp)</td>     
			<td> : <input type="text" name="overtime" size="20" value="<?php echo $formattotal; ?>" readonly="true"> * <?php echo $lama ?> hari </td>
            <td> </td>		 	
			<td colspan=2 rowspan=3>Keterangan Diskon :<BR><textarea name="keterangan" cols="40"
            	onChange="javascript:this.value=this.value.toUpperCase();"> </textarea></td>
		</tr>
        
       	<tr>
			<td>PPn (% | Rp)</td>     
			<td> : <input type="text" name="lain" id="lain" size="5" value="<?php echo $datappn; ?>" readonly="true"> 
			<input type="text" size="20" name="afterppn" id="afterlain" value="<?php echo $formatppn; ?>" readonly="true"> *</td>					
			<td> </td>
		</tr>
       	
        <tr>
			<td>Disc. (% | Rp)</td>     
			<td> : <input type="text" size="5" onchange="javascript:hitungtotal(this.value)" name="diskon" id="diskon"> <input type="text" size="20" name="afterdiskon" id="afterdiskon" readonly="true"> </td>
			<td> </td>
		</tr>
        
        <tr>
        	<td>BIAYA TOTAL (Rp)</td>    
			<td> : <input type="text" size="30" value="<?php echo $formattotal2; ?>" readonly="true" name="bt" id="bt"> *</td>
        </tr>																
					
  			<input type="hidden" name="hari" value="<?php echo $lama; ?>">
			<input type="hidden" name="pp" id="pp" value="<?php echo $datappn; ?>">				
  			<input type="hidden" name="storage1" value ="<?php echo $beratkalitarif; ?>">
            <input type="hidden" name="overtime1" id="overtime1" value="<?php echo $total; ?>">
            <input type="hidden" name="document1" id="document1" value="<?php echo $dokumen; ?>">
            <input type="hidden" name="ppn1" id="ppn1" value ="<?php echo $ppn; ?>">
            <input type="hidden" name="id_breakdown" value="<?php echo $r['id_breakdown']; ?>">
            <input type="hidden" name="nosmubtb" value="<?php echo $_GET['n']; ?>">
            <input type="hidden" name="bt0" id="bt0" value="<?php echo $total2; ?>">
            <input type="hidden" name="id" value="<?php echo $_GET['d']; ?>">		   						
	    
		<tr> 
        	<td colspan=5> <input type="submit" value="Simpan dan Cetak"> <input type="button" value="Batal" onclick="self.history.back()"> <strong>*) tidak perlu diisi (otomatis)</strong> </td> 
        </tr>
	</table>
</form>