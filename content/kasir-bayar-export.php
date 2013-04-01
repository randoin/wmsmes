<?php
//jika export
	$jdl='DeliveryBill EXPORT - No. BTB : '.$_GET['n'];
	$tampil=mysql_query("SELECT * FROM out_dtbarang_h where btb_nobtb='$_GET[n]' AND status_bayar='no' AND isvoid='0' AND posted='1'");
	$r=mysql_fetch_array($tampil);
	
		//cek harga asperindo or not
	$c=mysql_query("SELECT * from agent where btb_agent='$r[btb_agent]'");
	$c1=mysql_fetch_array($c);

		// get tariff based on agent membership : asperindo or not
		if($c1['asperindo']=='1')
		{
			//asperindo
 			$h=mysql_fetch_array(mysql_query("SELECT * from hargasewa where asperindo=1 and type='export' order by id DESC limit 1"));
			
			// harga sewa gudang
			$datasewagudang=$h['sewaperhari'];
			
			// harga cargo charge
			$datacargocharge=$h['cargocharge'];
			
			// harga kade
			$datakade=$h['kade'];
			
			// ppn dalam prosen
			$datappn=$h['ppn'];
			
			// harga dokumen
			$datadokumen=$h['dokumen'];
			
			// jumlah minimal hari
			$dataminhari=$h['minhari'];
			
			// harga minimal charge
			$datamincharge=$h['mincharge'];
			
			// berat minimal
			$dataminweight=$h['minweight'];
		}
		else
		{
			//bukan asperino
 			$x=mysql_fetch_array(mysql_query("SELECT * from hargasewa where asperindo=0 and type='export' order by id DESC limit 1"));
			
			// harga sewa gudang
			$datasewagudang=$x['sewaperhari'];
			
			// harga cargo charge
			$datacargocharge=$x['cargocharge'];
			
			// harga kade
			$datakade=$x['kade'];
			
			// ppn dalam prosen
			$datappn=$x['ppn'];
			
			// harga dokumen
			$datadokumen=$x['dokumen'];
			
			// jumlah minimal hari
			$dataminhari=$x['minhari'];
			
			// harga minimal charge
			$datamincharge=$x['mincharge'];
			
			// berat minimal
			$dataminweight=$x['minweight'];
		}
		
		# NEW CALCULATION
		
			# Count Days
				$now = time(); // or your date as well
     			$your_date = strtotime($r['btb_date']);
     			$datediff = $now - $your_date;
     			$hari = floor($datediff/(60*60*24));
				
				if($hari<=1)
				{
					$hari=1;
				}
				elseif ($hari<=$dataminhari)
				{
					$hari=1;
				}
				else
				{
					$hari=$hari-2;
				}
			# Count Days
			
			# Minimum Weight
					if ( $r['btb_totalberat'] <= $dataminweight )
					{
						$r['btb_totalberatbayar'] = $dataminweight;
						$minimum_weight = 'y';
					}
					else
					{
						$r['btb_totalberatbayar'] = $r['btb_totalberat'];
						$minimum_weight = 'n';
					}
			# Minimum Weight
			
			# Calc Sewa Gudang
				$sewagudang = ($r['btb_totalberatbayar'] * ($datasewagudang+$datacargocharge)) * $hari;
				$minimum_charge = 'n';	
					# Minimum Charge
					if ( $sewagudang <= $datamincharge )
					{
						$sewagudang = $datamincharge;
						$minimum_charge = 'y';		
					}
					# Minimum Charge
				$sewagudang_round_up = round($sewagudang,0);
				$sewagudang_formatted = number_format($sewagudang_round_up, 0, ',', '.');
			# Calc Sewa Gudang
			
			# Calc Cargo Charge
				$cargocharge = $r['btb_totalberat'] * $datacargocharge;
				$cargocharge_round_up = round($cargocharge,0);
				$cargocharge_formatted = number_format($cargocharge_round_up, 0, ',', '.'); 	
			# Calc Cargo Charge
			
			# Cargo Charge PPn
				$cargocharge_ppn = round($cargocharge * ($datappn/100),0);
			# Cargo Charge PPn
			
			# Calc Kade
				$kade = $r['btb_totalberat'] * $datakade;
				$kade_round_up = round($kade,0);
				$kade_formatted = number_format($kade_round_up, 0, ',', '.'); 
			# Calc Kade
			
			# Sewa Gudang + Cargo Charge + Kade
				#$sewagd_cgo_kade = round(($sewagudang + $cargocharge + $kade),0);
				$sewagd_cgo_kade = round(($sewagudang + $kade),0);
			# Sewa Gudang + Cargo Charge + Kade
			
			# Administrasi
				$administrasi =  $datadokumen;
				$administrasi_round_up =  round($datadokumen,0);
				$administrasi_formatted =  number_format($administrasi_round_up, 0, ',', '.');
			# Administrasi
			
			# PPn
				$ppn = $datappn;
				#$ppn_value = ($ppn/100)*($sewagudang + $cargocharge + $kade + $administrasi);
				$ppn_value = ($ppn/100)*($sewagudang + $kade + $administrasi);
				#$ppn_value_round_up = round(($ppn/100)*($sewagudang + $cargocharge + $kade + $administrasi),0);
				$ppn_value_round_up = round(($ppn/100)*($sewagudang + $kade + $administrasi),0);
				$ppn_value_formatted = number_format($ppn_value_round_up, 0, ',', '.');
			# PPN
			
			# Total Before PPn
				#$total_before_ppn = $sewagudang + $cargocharge + $kade + $administrasi;
				$total_before_ppn = $sewagudang + $kade + $administrasi;
			# Total Before PPn
			
			# Total After PPn
				$total_after_ppn = ($ppn_value+$total_before_ppn);
				$total_after_ppn_round_up = round($total_after_ppn);
				$total_after_ppn_formatted = number_format(($total_after_ppn_round_up), 0, ',', '.');  
			# Total After PPn
			
			
		# NEW CALCULATION

	
	/*		
	# hitung berat yg dibayar
	if($r['btb_totalberatbayar']<=2)
	{
		# bila berat kurang dari 2 kg maka berat adalah dataminweight
		$beratbayar=$dataminweight;
	}
	else
	{
		# bila berat lebih dari 2 kg maka berat adalah totalberat
		$beratbayar=$r['btb_totalberatbayar'];
	}
						
	# hitung hari
	$now = time(); // or your date as well
    $your_date = strtotime($r['btb_date']);
    $datediff = $now - $your_date;
    $hari = floor($datediff/(60*60*24));
	if($hari<=1)
	{
		$hari=1;
	}
	elseif ($hari<=$dataminhari)
	{
		$hari=1;
	}
	else
	{
		$hari=$hari-2;
	}
			
	$sewagudang=$datasewagudang;
	//$weight=$dataminweight;
	$cargocharge=$r['btb_totalberatbayar']*$datacargocharge;
	$dokumen=$datadokumen;
	$kade=$r['btb_totalberat']*$datakade;
					
	$total=($beratbayar*$hari*$sewagudang);
	if ($total<=5000)
	{
		$total=5000;	
	}
	else
	{
	}
		
	//$ppn=round(($total+$dokumen)*($datappn/100));
	$ppn=round(($total+$kade+$cargocharge+$dokumen)*($datappn/100));
		
	//$total2=round($total+$dokumen+$ppn);
	$total2=round($total+$ppn);
	
	//bult dsatuan !!!
	$total2sat=round($total2/10)*10;
		
	//
	$formatsewagudang=number_format($sewagudang, 0, '.', '.');
		
	$formatdokumen=number_format($dokumen, 0, '.', '.');
		
	$formatcargocharge=number_format($cargocharge, 0, '.', '.');	
			
	$formatberatbayar=number_format($beratbayar, 0, '.', '.');
		
	$formatkade=number_format($kade, 0, '.', '.');
		
	$formattotal=number_format($total, 0, '.', '.');   
				
	$formatppn=number_format($ppn, 0, '.', '.');
		
	$formattotal2=number_format($total2, 0, '.', '.');
	*/

?>

<h2><?php echo "$jdl"; ?></h2>
<form name="form1" method="POST" action="aksi.php?module=deliverybill&act=input">
   	<table border="0">
    	<tr>
        	<td valign="top">
            	<table>
                    <tr>
                        <td>Tgl BTB</td>
                        <td>: <input type="text" size="20" value="<?php echo ymd2dmy($r['btb_date']); ?>" readonly="true" /> *</td>
                    </tr>
                    
                    <tr>
                        <td>Pengirim/Agent</td>     
                        <td> : <input type="text" size="20" value="<?php echo $r['btb_agent']; ?>" readonly="true" /> *</td>		
                    </tr>
                    
                    <tr>
                        <td>No. SMU</td>
                        <td>: <input type="text" size="20"  name="nosmu" value="<?php echo $r['btb_smu']; ?>" readonly="readonly"/> 
                              <input type="hidden" name="nosmubtb" value="<?php echo $_GET['n']; ?>"></td>
                    </tr>
                    
                    <tr>
                        <td>Airline</td>
                        <td> : <input type="text" size="20" value="<?php echo $r['airline']; ?>" readonly="true"> *</td>
                    </tr>
                    
                    <tr>
                        <td>Tujuan</td>
                        <td> : <input type="text" size="20" value="<?php echo $r['btb_tujuan']; ?>" readonly="true" /> *</td>
                    </tr>
                    
                    <tr>
                        <td>Tanggal Masuk</td>
                        <td> : <input type="text" size="20" value="<?php echo ymd2dmy($r['btb_date']); ?>" readonly="true" /> *</td>
                    </tr>
                    
                    <tr>
                        <td>Tanggal Keluar</td>
                        <td> : <input type="text" size="20" value="<?php echo ymd2dmy($tgl=date('Y-m-d')); ?>" readonly="true" /> *</td>
                    </tr>
                    
                    <tr>
                        <td>Jumlah Hari</td>
                        <td> : <input type="text" size="20" name="hari" id="hari" value="<?php echo $hari; ?>" /> Hari</td>
                    </tr>
                    
                    			<input type="hidden" name="cargocharge" id="cargocharge" value ="<?php echo $cargocharge_round_up; ?>" />
                                
                    <tr>
                        <td>Cara Pembayaran</td>
                        <td> : <select name="carabayar">
                        			<option value="CASH" selected>CASH</option>
                               		<option value="PERIODICAL">PERIODICAL</option>
                               </select></td>
                    </tr>
				</table>
			</td>
            
            <td valign="top">
            	<table>
                	<tr>
                    	<td>Berat Aktual</td>
                        <td> : <input type="text" size="20" value="<?php echo $r['btb_totalberat']; ?>" readonly="true" /> KG *
                        	   <input type="hidden" name="berat_aktual" value="<?php echo $r['btb_totalberat']; ?>"> </td>
                    </tr>
                    
                    <tr>
        				<td>Total Berat Bayar</td>
	 					<td> : <input type="text" size="20" name="totalberatbayar" id="minimum_weight" value="<?php echo $r['btb_totalberatbayar']; ?>" readonly="true"> KG *
            				   <input type="hidden" size="20" name="minimum_weight" value="<?php echo $minimum_weight; ?>"></td>
        			</tr>

			        <tr>
			 			<td>Sewa Gudang</td>     
						<td>: Rp 
                        <input type="text" name="sewagudang_formatted" id="sewagudang_formatted" value="<?php echo $sewagudang_formatted; ?>" readonly="true"/>
						<?php echo $hari; ?> Hari *
                        <input type="hidden" name="minimum_charge" value="<?php echo $minimum_charge; ?>" />
                        <input type="hidden" name="sewagudang" id="sewagudang" value="<?php echo $sewagudang; ?>" /></td>    
					</tr>
                    
                    <tr>
                    	<td>Disc.</td>     
						<td> : <input type="text" size="5" onchange='javascript:hitungtotal(this.value)' name="discount_percent" id="discount_percent"> % | Rp
				   			   <input type="text" size="20" name="discount_value" id="discount_value" readonly="true"></td>
                    </tr>

                    <tr>
	 					<td>Total Sewa Gudang</td>     
						<td>: Rp 
                        <input type="text" name="after_discount_value" id="after_discount_value" size="20" value="<?php echo $sewagudang; ?>" readonly="true"> <?php echo $hari; ?> Hari *</td>    
					</tr>
                    
                    <tr>
                    	<td>KADE</td>
            			<td> : Rp <input type="text" size="20" name="kade_formatted" value="<?php echo $kade_formatted; ?>" readonly="true"> *
            		  			  <input type="hidden" name="kade" id="kade" value="<?php echo $kade_round_up; ?>"> </td>
                    </tr>
                    
                    <tr>
                        <td>Administrasi</td>
            			<td> : Rp 
                        <input type="text" size="20" name="administrasi_formatted" value="<?php echo $administrasi_formatted; ?>" readonly="true"> *
                        <input type="hidden" name="administrasi" id="administrasi" value="<?php echo $administrasi_round_up; ?>" /></td>
                    </tr>
                    
                    <tr>
	                    <td>PPn</td>
				 		<td> : <input type="text" name="ppn_persen" id="ppn_persen" size="5" value="<?php echo $datappn; ?>" readonly="true"> % | Rp
		    				   <input type="text" size="20" name="ppn_value" id="ppn_value" value="<?php echo $ppn_value_round_up; ?>" readonly="true"> *
                               <input type="hidden" name="ppn" id="ppn" value="<?php echo $ppn; ?>" /></td>
                    </tr>
                    
                    <tr>
        	            <td>BIAYA TOTAL</td>
            			<td> : Rp <input type="text" size="30" value="<?php echo $total_after_ppn_round_up; ?>" readonly="true" name="total_after_ppn" id="total_after_ppn"> *</td>
                    </tr>
                    
                    <tr>
                    	<td colspan="2" rowspan="5">Keterangan Diskon :<BR> <textarea name="keterangan" cols="50" ></textarea></td>
                    </tr>
        		</table>
			</td>
				   						
   		<tr>
        	<td><strong>*) tidak perlu diisi (otomatis)</strong></td>
			<td><input type="submit" value="Simpan dan Cetak">
	    <input type="button" value="Batal" onclick="self.history.back()">
        <input type="hidden" name="id" value="1"> </td></tr>
    </table>
</form>