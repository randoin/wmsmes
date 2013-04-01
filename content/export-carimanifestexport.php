<SCRIPT LANGUAGE="JavaScript" src="cal2.js">
</script>
<script language="javascript">
    addCalendar("Caritanggalawal","Tanggal","tglawal","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
</script>

<?php
$tgl=date('Y-m-d');
if(!empty($_POST['tglawal']))
	{
		$tglawal=$_POST['tglawal'];
	}
else
	{
		$tglawal=$_GET['tglawal'];
	}
echo $cari;
//mulai membuat FORM nya
?>

<h2>Data Manifest Export</h2>
	<form name="form1" method="POST" action="?module=carimanifestexport">
		<table border=0 cellpadding=0 cellspacing=0 width=100%>
			<tr>
            	<td>
					PENCARIAN : <input type="text" name="tglawal" value="<?php echo $tglawal; ?>">
				    <a href="javascript:showCal('Caritanggalawal')"><img src="images/calendar.png" border="0"></a>
					<input type="submit" value="CARI">
                </td>
           </tr>
		</table>
<p><a href="?act=tambah_manifestexport">[TAMBAH DATA]</a></p>

<?php					
	if($_GET['d']!='')
		{
			$dt=my2date($_GET['d']);
		}
	elseif($_POST['tglawal']=='')
		{
			$dt=$today;
		}
	else
		{
			$dt=my2date($_POST['tglawal']);
		}
		
	$tdy=ymd2dmy($today);
	$tampil=mysql_query("
	SELECT m.idmanifestout,m.acregister,m.flightdate,m.pointofloading,m.pointul,m.statusnil,
	f.flight,o.origin_code, d.dest_code,m.iddestination2,m.statusconfirm,m.statuscancel,c.bendera,c.cus_desc
	FROM manifestout as m,origin as o,destination as d,flight as f, customer as c
	WHERE m.idorigin=o.idorigin
	AND m.iddestination=d.iddestination
	AND m.idflight=f.idflight
	AND m.statusvoid='0'
	AND f.idcustomer=c.idcustomer
	AND m.flightdate='$dt'
	order by f.flight asc"); 

//mulai membuat FORM nya
?> 	

<table>
	<tr>
		<th width="75">A/C Reg.</th>
		<th>Flight Date</th>
		<th width="47">Flight</th>
		<th width="47">Org</th> 
		<th width="39">Dest</th>
		<th width="73">Koli / Kg</th>
		<th width="76">status</th>
		<th width="40">action</th>
        <th width="135">manifest</th>
		<th width="62">h.ovr</th>
		<th width="62">delv.</th>
	</tr>
    
    <?php	
	while ($r=mysql_fetch_array($tampil))
	{
		$cekbrt=mysql_fetch_array(mysql_query("
		select sum(i.koli) as koli,sum(i.berat) as berat 
		from manifestout as m, isimanifestout as i 
		where i.idmanifestout=m.idmanifestout AND i.statusvoid='0' 
		AND i.idmanifestout=$r[idmanifestout]"));
		
		if($cekbrt[koli]=='')
		{
			$koli=0;
		} 
		else
		{
		 $koli=$cekbrt[koli];
		}
		
		if($cekbrt[berat]=='')
		{
			$berat=0;
		} 
		else 
		{
			$berat=$cekbrt[berat];
		}
	
		$des2=mysql_fetch_array(mysql_query("SELECT dest_code from destination 
	where iddestination=$r[iddestination2]"));	
		
		if($r[statusnil]=='on')
		{
			$n='nil';
	?>
			<tr onmouseover="this.className = 'hlt';" onmouseout="this.className = '';">
        <?php
        }
    	else 
		{
			echo $n="$koli / $berat";
		}
		?>
		
        	<tr onmouseover="this.className = 'hlt';" onmouseout="this.className = '';">
				<td><a href="?module=isimanifestexport&idm=<?php echo $r['idmanifestout']; ?> &r=<?php echo $r['acregister']; ?> &f=<?php echo $r['flight']; ?> &d="<?php echo ymd2dmy($r['flightdate']); ?> <?php echo $r['acregister']; ?>"></a></td>
      			<td width=75><?php echo ($r['flightdate']); ?></td>
    			<td><?php echo $r['flight']; ?></td>
        		<td><?php echo $r['origin_code']; ?></td>
        		<td><?php echo $r['dest_code']; ?> <?php echo $des2['0']; ?></td>
        		<td align="right"><?php echo $n; ?></td>
				<td>
           			<?php	
					if(($r['statusconfirm']=='1') AND ($r['statuscancel']=='0'))
		 			{
					echo "OUT";
					?></td>
				<td></td>
        		<td><a href="?module=batascetakmanifest&idm=<?php echo $r['idmanifestout']; ?>&s=0">[CARGO]</a>
           			<a href="?module=batascetakmanifest&idm=<?php echo $r['idmanifestout']; ?>&s=1">[MAIL]</a>
					<a href="?module=batascetakmanifest&idm=<?php echo $r['idmanifestout']; ?>&s=2">[SPLIT]</a></td>
        		<td align=center><a href="aksi.php?module=cetakhandoverexport&idm=<?php echo $r['idmanifestout']; ?>">[CETAK]</a></td>
        		<td align=center><a href="aksi.php?module=cetakdeliverycargo&idm=<?php echo $r['idmanifestout']; ?>&s=0">[CETAK]</a></td>
           			<?php	
		 			}
					elseif($r['statuscancel']=='1')
						{
					
					echo "CANCEL";
					?>
                <td width="0"></td>
                <td width="0"></td>
				<td width="0"></td>
				<td width="0"></td>
				<td width="0"></td>
					<?php	
                     	}
					else
						{
					?>
				<td width="0"></td>
        		<td width="150"><a href="?module=inputpnbp&idm=<?php echo $r['idmanifestout']; ?>&d=<?php echo $dt; ?>" onclick="javascript:return confirm('PNBP HARUS SUDAH ADA SEBELUM CONFIRM')">[CONFIRM]</a>  
						<a href="?act=edit_carimanifestexport&idm=<?php echo $r['idmanifestout']; ?>&r=<?php echo $r['acregister']; ?>&f=<?php echo $r['flight']; ?>&d=<?php echo $dt; ?>">[EDIT]</a>
               		<?php
					if($koli<>'0')
						{
					?>
					<a href="?module=beratuld&idm=<?php echo $r['idmanifestout']; ?>&d=<?php echo $dt; ?>&red=<?php echo $r['acregister']; ?>&f=<?php echo $r['flight']; ?>">[KG ULD]</a>
					<?php				
                    	} 
					?>
				</td>
        		<td width="96"><a href="?module=batascetakmanifest&idm=<?php echo $r['idmanifestout']; ?>&s=0">[CARGO]</a>
              					<a href="?module=batascetakmanifest&idm=<?php echo $r['idmanifestout']; ?>&s=1">[MAIL]</a>
								<a href="?module=batascetakmanifest&idm=<?php echo $r['idmanifestout']; ?>&s=2">[SPLIT]</a></td>
        		<td width="0"></td>
        		<td width="16"></td>
	<?php	 
	}
	?>	
			</tr>
 <?php	 				 	
    $no++;
}	
?>
</table>