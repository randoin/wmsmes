<?php
	$p      = new Paging;
	$batas  =10;
	$posisi = $p->cariPosisi($batas);
    $no     = $posisi+1;
	
	if(!empty($_POST['cari']))
		{
			$cari=$_POST['cari'];
		}
	else
		{
			$cari=$_GET['cari'];
		}

//mulai membuat FORM nya
?> 	

<h2>Data AWB</h2>
<form method="POST" action='?module=carismu'>
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
        	<td>PENCARIAN : <input name="cari" type="text" size="20" value="<?php echo $_POST['cari']; ?>" autocomplete="off"> 
							<input type="submit" value="CARI"></td>
        </tr>
	</table>
<?php
	if(!empty($cari))//jika user melakukan pencarian
		{
			$tampil=mysql_query("
								SELECT 	i.berat,
										i.koli,
										m.acregister,
										m.flightdate,
										f.flight,
										m.idmanifestin
								FROM 	isimanifestin as i,
										master_smu as s,
										manifestin as m, 
										flight as f,
										origin as o, 
										destination as d,
										commodity_ap as c,
										agent as a
								WHERE 	i.idmastersmu=s.idmastersmu 
								AND 	i.idmanifestin=m.idmanifestin 
								AND 	s.nosmu='$cari' 
								AND 	i.statusvoid='0' 
								AND 	i.statuscancel='0' 
								AND 	m.statusvoid='0' 
								AND 	m.idflight=f.idflight 
								AND 	s.idorigin=o.idorigin 
								AND 	s.iddestination=d.iddestination 
								AND 	s.idcommodityap=c.idcommodityap 
								AND 	s.idagent=a.idagent
							   ");
								
			$tampil1=mysql_query("
								SELECT 	s.idmastersmu,
										s.nosmu,
										s.tglsmu,
										s.berat as brt,
										s.beratbayar as brtbayar,
										s.koli as kl,
										o.origin_code,
										d.dest_code,
										c.commodityap,
										a.agent 
								FROM 	master_smu as s,
										origin as o, 
										destination as d,
										commodity_ap as c,
										agent as a
								WHERE 	s.nosmu ='$cari' 
								AND 	s.idorigin=o.idorigin 
								AND 	s.iddestination=d.iddestination 
								AND 	s.idcommodityap=c.idcommodityap 
								AND 	s.idagent=a.idagent
								");
		}
?>

<table>
	<tr>
		<th>#AWB / Date</th>
        <th>Qty</th>
        <th>Com</th>
        <th>Org</th>
        <th>Dest</th>
        <th>agent</th>
        <th>action</th>
    </tr>
    <?php
	$b=0;$k=0;
	while ($r=mysql_fetch_array($tampil1))
	{
	$cekconfirm=mysql_num_rows(mysql_query("select s.idmastersmu from master_smu as s, isimanifestin as i where i.idmastersmu=s.idmastersmu AND s.idmastersmu='$r[idmastersmu]' AND i.statusconfirm='1'"));

	if($cekconfirm<=0)
	{
	?>
	<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>".<?php echo format_awb($r['nosmu']); ?>." / ".<?php echo ymd2dmy($r['tglsmu']); ?>."</td>
		<td><?php echo $r['kl']; ?> koli <?php echo $r['brt']; ?> kg -> Chgbl Wght : <?php echo $r['brtbayar']; ?> kg</td>
        <td><?php echo $r['commodityap']; ?></td>
        <td><?php echo $r['origin_code']; ?></td>
        <td><?php echo $r['dest_code']; ?></td>
        <td><?php echo $r['agent']; ?></td>
        <td><a href=?module=edit_awbimport&act=hapusi&ids=$r[idmastersmu]>[EDIT]</a>
        	<a href="aksi.php?module=carismu&act=hapusi"&ids=$r['idmastersmu'] onclick=\"javascript:return confirm('Apakah Anda yakin akan menghapus AWB ?')\">[DELETE]</a></td>
    <?php
	}
	else
	{
	?>
	<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>".format_awb(<?php echo $r['nosmu']; ?>)." / ".ymd2dmy(<?php echo $r['tglsmu']; ?>)."</td>
		<td><?php echo $r['kl']; ?> koli <?php echo $r['brt']; ?> kg</td>
		<td><?php echo $r['commodityap']; ?></td>
        <td><?php echo $r['origin_code']; ?></td>
		<td><?php echo $r['dest_code']; ?></td>
		<td><?php echo $r['agent']; ?></td>
		<td></td>
	<?php
    }
	
	$no++;
	$b+=$r['brt'];$k+=$r['kl'];
  	}
	$no=1;
	?>
</table>

<table>
	<tr>
    	<th colspan=4>Histories : </th>
    </tr>
	<tr>
    	<th>no</th>
        <th>A/C Reg</th>
        <th>Flight / Date</th>
        <th>Qty</th>
    </tr>
    <?php
	while ($r=mysql_fetch_array($tampil))
	{
	?>
	<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td><?php echo $no; ?></td>
        <td><?php echo $r['acregister']; ?></td>
        <td><a href="?module=isimanifestimport"&idm=$r['idmanifestin']&r=$r['acregister']&f=$r['flight']&d=".ymd2dmy($r[flightdate])."> <?php echo $r['flight']; ?> / ".<?php echo ymd2dmy($r['flightdate']); ?>."</a></td>
        <td><?php echo $r['koli']; ?> koli <?php echo $r['berat']; ?> kg</td>
    <?php
    $no++;
	$b-=$r['berat'];$k-=$r['koli']; 
  	}
	?>
</table>
</form>