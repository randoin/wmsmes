<?php
	$p      = new Paging;
	$batas  =10;
	$posisi = $p->cariPosisi($batas);
    $no     = $posisi+1;
	
	if($_GET['r']=='c')
		{
			$tab='btb_agent';
		}
		else if($_GET['r']=='d')
			{
				$tab='agentfullname';
			}
			else $tab='btb_agent';
	
	if(!empty($_POST['cari']))
		{
			$cari=$_POST['cari'];
		}
		else
			{
				$cari=$_GET['cari'];
			}
			
	if(!empty($cari))//jika user melakukan pencarian
		{
			if($_GET['a']=='1') // urutkan Ascending dulu
  				{
					$b=0; 
					$tampil=mysql_query("SELECT * FROM agent
										 WHERE (btb_agent like '%$cari%' OR contactperson like '%$cari%') 
										 order by $tab ASC limit $posisi,$batas");
										  
					$jmldata = mysql_num_rows(mysql_query("SELECT * FROM agent
														   WHERE (btb_agent like '%$cari%' OR contactperson like '%$cari%')"));
				}
			else // jika diklik lagi maka akan pengurutan DESCENDING
  				{
					$b=1; 
					$tampil=mysql_query("SELECT * FROM agent
										 WHERE (btb_agent like '%$cari%' OR contactperson like '%$cari%') 
										 order by $tab DESC limit $posisi,$batas"); 
	
					$jmldata = mysql_num_rows(mysql_query("SELECT * FROM agent
														   WHERE (btb_agent like '%$cari%' OR contactperson like '%$cari%')"));
				}
		}	
 	else//jika user TIDAK melakukan pencarian
		{
			if($_GET['a']=='1') // urutkan Ascending dulu
  				{
					$b=0; 
					$tampil=mysql_query("SELECT * FROM agent order by $tab ASC limit $posisi,$batas"); 
					$jmldata = mysql_num_rows(mysql_query("SELECT * FROM agent"));
				}
			else // jika diklik lagi maka akan pengurutan DESCENDING
  				{
					$b=1; 
					$tampil=mysql_query("SELECT * FROM agent order by $tab DESC limit $posisi,$batas"); 
					$jmldata = mysql_num_rows(mysql_query("SELECT * FROM agent"));
				}
		}
//mulai membuat FORM nya
?>

<h2>DATA AGENT</h2>
<form method="POST" action='?module=dataagent'>
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
        	<td>PENCARIAN : <input name="cari" type="text" size="20" value="<?php echo $_POST['cari']; ?>" autocomplete="off"> 
							<input type="submit" value="CARI"><a href="?act=tambah_dataagent">
							<span class="tombol"> TAMBAH DATA </span></a>
			</td>
        </tr>
	</table>
    <?php 
		$jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
		$linkHalaman  = $p->navHalaman($_GET['halaman'], $jmlhalaman,'cari='.$cari);
	?>	
	<p><?php echo $linkHalaman; ?></p>
    
    <table>
    	<tr>
        	<th>no</th>
			<th><a href="?module=dataagent"&r=c&a=<?php echo $b; ?>&cari=<?php echo $cari; ?>>code</a></th>
			<th><a href="?module=dataagent"&r=d&a=<?php echo $b; ?>&cari=<?php echo $cari; ?>>agent</a></th>
            <th>npwp</th>
			<th>address</th>
            <th>phone</th>
            <th>fax</th>
            <th>contact person</th>
            <th>Group</th>
			<th>action</th>
            <?php
				while ($r=mysql_fetch_array($tampil))
					{
						$d=mysql_query("select * from agent order by btb_agent");
						$g=mysql_fetch_array($d);
						if($r['asperindo']=='1')
						{
							$g='ASPERINDO';
						} 
						else 
						{
							$g='none';
						}
			?>
			<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
				<td><?php echo $no; ?></td>
                <td><?php echo $r['btb_agent']; ?></td>
          		<td><?php echo $r['agentfullname']; ?></td>
                <td><?php echo $r['npwp']; ?></td>
                <td><?php echo $r['address']; ?></td>
				<td><?php echo $r['phone']; ?></td>
                <td><?php echo $r['fax']; ?></td>
				<td><?php echo $r['contactperson']; ?></td>
                <td><?php echo $g; ?></td>
				<td><a href="?act=edit_dataagent&id=<?php echo $r['idagent']; ?>">EDIT</a> | 
					<a href="javascript:deldata('<?php echo $r['idagent']; ?>','Agent : <?php echo $r['agent']; ?>?','aksi.php?module=dataagent&act=hapus&id=')">HAPUS</a></td>
            </tr>
    <?php
     $no++;
  	}
	?>
	</table><p>word <?php echo $cari; ?> found : <?php echo $jmldata; ?> rows in <?php echo $jmlhalaman; ?> pages</p>
</form>