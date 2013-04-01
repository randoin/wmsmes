<?php
$today=date('Y-m-d');
	$tampil=mysql_query("SELECT m.idmastersmu,
								m.nosmu,
								m.tglsmu,
								o.origin_code,
								d.dest_code,
								m.berat,
								m.koli,
								p.commodityap,
								m.consignee,
								m.shipper,
								a.agent,
								m.exim 
						   FROM master_smu as m,
						   		origin as o,
								destination as d,
								commodity_ap as p, 
								agent as a
						  WHERE m.idorigin=o.idorigin 
						  	AND m.iddestination=d.iddestination 
							AND m.idcommodityap=p.idcommodityap 
							AND	m.idagent=a.idagent 
							AND m.tglsmu='$today' 
							AND m.isvoid='0' 
					   order by m.idmastersmu desc"); 

//mulai membuat FORM nya
?>

<h2>Data AWB Today</h2>
<p><a href=?module=carismu>[KEMBALI]</a></p>
<table>
	<tr>
		<th>AWB #</th>
        <th>Date</th>
        <th>Com</th>
        <th>Org</th>
        <th>Dest</th>
        <th>Koli</th>
        <th>KG</th>
        <th>agent</th>
        <th>status</th>
        <th>action</th>
	</tr>
    <?php		
		while ($r=mysql_fetch_array($tampil))
		{
			if($r['commodityap']=='MAIL')
			{
				$noawb=format_nopos($r['nosmu']);
			}
			else
			{
				$noawb=format_awb($r['nosmu']);
			}
		$cekterbang = mysql_num_rows(mysql_query("select m.flightdate,
														 m.acregister,f.flight
													from manifestout as m,
														 isimanifestout as i,
														 flight as f
												   where m.idmanifestout=i.idisimanifestout 
												     AND m.statuscancel='0' 
													 AND m.statusvoid='0' 
													 AND i.statuscancel='0' 
													 AND i.statusvoid='0'  
													 AND m.idflight=f.idflight 
													 AND i.idmastersmu='$r[idmastersmu]' 
													 AND m.statusconfirm='1'"));
	?>
	
	<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td><?php $noawb ?></td>
        <td><?php ".ymd2dmy($r[tglsmu])." ?></td>
        <td><?php $r['commodityap'] ?></td>
        <td><?php $r['origin_code'] ?></td>
        <td><?php $r['dest_code'] ?></td>
        <td align=right><?php $r['koli'] ?></td>
        <td align=right><?php $r['berat'] ?></td>
        <td><?php $r['agent'] ?></td>
		<td>
		<?php		
		if($cekterbang>0) 
		{
			$data=mysql_fetch_array(mysql_query("select m.flightdate,
														m.acregister,
														f.flight
												   from manifestout as m,
												   		isimanifestout as i,
														flight as f
												  where m.idmanifestout=i.idmanifestout
												    AND m.idflight=f.idflight 
													AND i.idmastersmu='$r[idmastersmu]'")); 
			echo "Reg.$data[acregister] $data[flight] ".ymd2dmy($data[flightdate])."</td><td></td>";
		}
		else if(($cekterbang<=0)AND($r[exim]=='1')) 
		{
			echo "import</td>
		<td></td>";
		}		
		else if(($cekterbang<=0)AND($r[exim]=='')) 
		{
			echo "instore</td><td><a href=?act=edit_carismu&ids=$r[idmastersmu]>[EDIT]</a> | <a href=aksi.php?module=carismu&act=hapus&ids=$r[idmastersmu] 
onclick=\"javascript:return confirm('Apakah Anda yakin akan menghapus AWB ?')\">[DELETE]</a></td>";
		}		
		
		?></td>
	</tr>
    <?php	
     $no++;
  	}
	?>
</table>