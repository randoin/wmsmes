<SCRIPT LANGUAGE="JavaScript" src="cal2.js">
</script>
<script language="javascript">
    addCalendar("Caritanggalawal","Tanggal","tglawal","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
</script>

<?php
	$totb=mysql_fetch_array(mysql_query("SELECT sum(i.berat),sum(i.koli) FROM 
	isimanifestout as i,manifestout as m, master_smu as s WHERE i.idmanifestout = m.idmanifestout 
	AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND m.idmanifestout='$_GET[idm]'")); 
	$totsmu=mysql_num_rows(mysql_query("SELECT count(i.idmastersmu) FROM 
	isimanifestout as i,manifestout as m, master_smu as s WHERE i.idmanifestout = m.idmanifestout 
	AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' 
	AND m.idmanifestout='$_GET[idm]' GROUP BY i.idmastersmu")); 
	$con=mysql_fetch_array(mysql_query("select statusconfirm from manifestout where statusvoid='0' AND idmanifestout='$_GET[idm]'"));
$tgl=date('Y-m-d');

//mulai membuat FORM nya
?>
<h2>Data Manifest Export : <?php echo $_GET['d']; ?> <?php echo $_GET['f']; ?> A/C Reg. <?php echo $_GET['r']; ?> | Total : <?php echo $totsmu; ?> SMU -> <?php echo $totb['1']; ?>koli <?php echo $totb['0']; ?>kg </h2><p>
<?php
	//$dt=my2date($_POST[tglawal]);		
$tdy=ymd2dmy($today);

if($_GET['d']!='')
	{
		$dt=my2date($_GET['d']);
	}
else 
	{
		$dt=my2date($_POST['tglawal']);
	}
if($con['statusconfirm']=='0')
	{
	?>
	<a href="?act=tambah_isimanifestexport&idm=<?php echo $_GET['idm']; ?>&r=<?php echo $_GET['r']; ?>&f=<?php echo $_GET['f']; ?>&d=<?php echo $_GET['d']; ?>">[TAMBAH AWB]</a>	
	<?php
    }
	?>
	<a href="?module=carimanifestexport&idm=<?php echo $_GET['idm']; ?>&d=<?php echo $dt; ?>">[KEMBALI]</a></p>
	<?php
	$daftaruld=mysql_query("
	SELECT i.nould 
	FROM isimanifestout as i,manifestout as m, master_smu as s 
	WHERE i.idmanifestout = m.idmanifestout 
	AND i.idmastersmu=s.idmastersmu 
	AND i.statusvoid='0' 
	AND i.statuscancel='0'
	AND m.idmanifestout='$_GET[idm]' 
	GROUP BY i.nould order by nould ASC"); 
	

//mulai membuat FORM nya
 	
	while ($pp=mysql_fetch_array($daftaruld))
	{
	$no=1;
	?>
	<p>.format_uld($pp[nould]).</p>
	<?php
	$tampil=mysql_query("
	SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu,s.idcommodityap 
	FROM isimanifestout as i,manifestout as m, master_smu as s 
	WHERE i.idmanifestout = m.idmanifestout 
	AND i.idmastersmu=s.idmastersmu 
	AND i.statusvoid='0' 
	AND i.statuscancel='0'
	AND m.idmanifestout='$_GET[idm]' 
	AND i.nould='$pp[0]' 
	order by nould ASC"); 
	?>
<table>
		<tr>
			<th>No</th>
			<th>AWB#</th>
			<th>KOLI</th>
			<th>KG</th>
			<th>ACTION</th>
		</tr>
	<?php
	while ($r=mysql_fetch_array($tampil))
		{
			if($r['idcommodityap']=='18')
				{
					$noawb=format_nopos($r['nosmu']);
				}
			else 
				{
					$noawb=format_awb($r['nosmu']);
				}
		?>
		<tr onmouseover="this.className = 'hlt';" onmouseout="this.className = '';">
			<td><?php echo $no; ?></td>
        	<td><?php echo $noawb; ?></td>
        	<td align=right><?php echo $r['koli']; ?></td>
        	<td align=right><?php echo $r['berat']; ?></td>
        		<?php
				if($con['statusconfirm'])
					{
				?>
		 	<td></td>
        </tr>
        		<?php
					}
				else
					{
				?>
		  	 <td>
				<a href="aksi.php?module=isimanifestexport&act=hapus&idm=<?php echo $_GET['idm']; ?>&r=<?php echo $_GET['r']; ?>&f=<?php echo $_GET['f']; ?>&d=<?php echo $_GET['d']; ?>&idi=<?php echo $r['idisimanifestout']; ?>" 
		  onclick="javascript:return confirm('cancel AWB ini ?')" >[CANCEL]</a></td>
        </tr>";		
		<?php	
            }
     	$no++;
  		}
		?>
	</table>
    <?php
	}
  //echo "</table>";

?>