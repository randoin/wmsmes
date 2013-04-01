<?php
	if(!empty($_POST['berat']))
  	{	
		if($_POST['panjang']=='')
			{
				$panjang=0;
			}
			else
				{
					$panjang=$_POST['panjang'];
				} 
		if($_POST['lebar']=='')
			{
				$lebar=0;
			}
			else
				{
					$lebar=$_POST['lebar'];
				}
		if($_POST[tinggi]=='')
			{
				$tinggi=0;
			}
			else
				{
					$tinggi=$_POST['tinggi'];
				} 				
		if($_POST[koli]=='')
			{
				$koli=1;
			}
			else
				{
					$koli=$_POST['koli'];
				}		
		
		$n=mysql_query("select * from out_dtbarang_h where id='$_POST[i]'");
		$p=mysql_fetch_array($n);
		
		$luas=($_POST['lebar']*$_POST['panjang']*$_POST['tinggi'])/6000;

		if($luas>=$_POST['berat'])
			{
				$beratdibayar=$luas;
			}
			else
				{
					$beratdibayar=$_POST['berat'];
				}
		mysql_query("
					INSERT INTO out_dtbarang(dtBarang_berat,dtBarang_panjang,dtBarang_lebar,dtBarang_tinggi,
								dtBarang_luasdimensi,dtBarang_brtdibayar,id_h,dtBarang_koli,dtBarang_type) 
					VALUES('$_POST[berat]',
			   		   	   '$panjang',
			   		   	   '$lebar',
			   		   	   '$tinggi',
			   		   	   '$luas',
			   		   	   '$beratdibayar',
			   		   	   '$_POST[i]',
			   		   	   '$koli',
			   		   	   '$_GET[j]')
			   		");
	
		$pberat=$p['btb_totalberat']+$_POST['berat'];
		$pkoli=$p['btb_totalkoli']+$_POST['koli'];
		$pvol=$p['btb_totalvolume']+$luas;
		$pbayar=$p['btb_totalberatbayar']+$beratdibayar;
		//if($pbayar<=2) 
		//{
			//$pbayar=2;
		//}
		
		// select type agent
		$agent=$p['agent'];
		$cek_asperindo_query=mysql_query("select asperindo from agent where btb_agent='$btb'");
		$cek_asperindo=mysql_fetch_array($cek_asperindo_query);
		
		$asperindo=$cek_asperindo['asperindo'];
		
		if ($asperindo==0)
		{
			$minweight_query=mysql_query("SELECT * FROM hargasewa WHERE asperindo='0' and type='export' ORDER BY id DESC LIMIT 1");
		}
		else
		{
			$minweight_query=mysql_query("SELECT * FROM hargasewa WHERE asperindo='1' and type='export' ORDER BY id DESC LIMIT 1");
		}

		
		$minweight=mysql_fetch_array($minweight_query);

		if($pbayar<=$minweight['minweight']) 
		{ 
			$pbayar=$minweight['minweight'];
		}

		mysql_query("
					UPDATE out_dtbarang_h
					set btb_totalberat='$pberat',
						btb_totalkoli='$pkoli',
						btb_totalvolume='$pvol',
						btb_totalberatbayar='$pbayar',
						posted='1' 
				  where id='$_POST[i]'");

	}
		header('location:media.php?module=btbinput&i='.$_POST['i'].'&j='.$_GET['j']);
?>