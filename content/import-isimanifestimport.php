<SCRIPT LANGUAGE="JavaScript" src="cal2.js">
</script>
<script language="javascript">
    addCalendar("Caritanggalawal","Tanggal","tglawal","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
</script>

<?php
	echo $totb=mysql_fetch_array(mysql_query("SELECT sum(i.berat),sum(i.koli)
		FROM isimanifestin as i,manifestin as m, master_smu as s
			WHERE i.idmanifestin = m.idmanifestin
				AND i.idmastersmu=s.idmastersmu
					AND i.statusvoid='0'
						AND i.statuscancel='0'
							AND m.idmanifestin='$_GET[idm]'"));
	 
	echo $totsmu=mysql_num_rows(mysql_query("SELECT count(i.idmastersmu)
		FROM isimanifestin as i,manifestin as m, master_smu as s
			WHERE i.idmanifestin = m.idmanifestin
				AND i.idmastersmu=s.idmastersmu
					AND i.statusvoid='0'
						AND i.statuscancel='0' 
							AND m.idmanifestin='$_GET[idm]'
								GROUP BY i.idmastersmu")); 
	echo $tgl=date('Y-m-d');
?>
	
<h2>Data Manifest Import : 
<?php
//mulai membuat FORM nya	   	
	echo $_GET['d'] $_GET['f'] A/C Reg $_GET['r'] | Total : echo $totsmu SMU -> echo $totb[1] koli echo $totb[0] kg;
	echo $tdy=ymd2dmy($today);

	if($_GET['d']!='')
		{
			echo $dt=my2date($_GET['d']);
		}
	else
		{
			echo $dt=my2date($_POST['tglawal']);
		}

	<a href="?act=tambah_isimanifestimport" &idm=$_GET['idm'] &r=$_GET['r'] &f=$_GET['f'] &d=$_GET['d']>[TAMBAH AWB]</a>
	<a href="?module=carimanifestimport" &idm=$_GET['idm'] &d=$dt>[KEMBALI]</a>
	
	
	echo $tampil=mysql_query("SELECT i.idisimanifestin,i.idmanifestin,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm,i.nopos, i.paid,s.nosmu,s.idcommodityap,i.nokeluar,i.statuskeluar,i.tglkeluar,d.dest_code,o.origin_code FROM 
	isimanifestin as i,manifestin as m, master_smu as s,destination as d, origin as o,consignee as con  
	WHERE i.idmanifestin = m.idmanifestin AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0' AND s.iddestination=d.iddestination AND s.idorigin=o.idorigin AND s.consignee=con.idconsignee
	 AND m.idmanifestin='$_GET[idm]' order by i.nopos ASC"); 

?></h2><p>
	<table>
		<tr>
			<th>No</th>
			<th>AWB#</th>
			<th>KOLI</th>
			<th>KG</th>
            <th>ORG/DEST</th>
            <th>POS</th>
			<th>ACTION</th>
            <th>Cetak</th>
            <th>STATUS</th>
            <th>PAID</th>
		</tr>
		
	<?php	
		echo $no=1;
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
			<td align=center><?php echo $r['origin_code']; ?> / <?php echo $r['dest_code']; ?></td>
			<td align=center><?php echo $r['nopos']; ?></td>";
            <?php	
			if($r['statusconfirm']=='1')
				{
					if(($r['paid']=='1') AND ($r['nokeluar']==''))
						{
			?>
		  	<td></td>
		  	
            <td><a href="aksi.php?module=cetakbc&id=$r['idisimanifestin']&pos=$r['nopos']">[BC1.2]</a>
		  	  	<a href="aksi.php?module=cetakbcdn&id=$r['idisimanifestin']&pos=$r['nopos']">[BC1.2-DN]</a>
			  	<a href="aksi.php?module=cetaknoa&id=$r['idisimanifestin']">[NOA]</a>
		  	</td>
            
			<td><a href="?module=inputoutput&id=$r['idisimanifestin']&b=BC1.2&idm=$_GET[idm]&r=$_GET[r]&f=$_GET[f]&d=$_GET[d]">[BC1.2]</a>
				<a href="?module=inputoutput&id=$r['idisimanifestin']&b=BC2.3&idm=$_GET[idm]&r=$_GET[r]&f=$_GET[f]&d=$_GET[d]">[BC2.3]</a>
				<a href="?module=inputoutput&id=$r['idisimanifestin']&b=SPPB&idm=$_GET[idm]&r=$_GET[r]&f=$_GET[f]&d=$_GET[d]"> [SPPB]</a>
			</td>
            
			<td><a href="aksi.php?module=cetakdo&id=$r['idisimanifestin']">[PAID]</a></td>
		</tr>
				<?php
                		}
					else
					
					if(($r['paid']=='1') AND ($r['nokeluar']<>''))
						{
				?>
		  	
            <td></td>
            
			<td><a href="aksi.php?module=cetakbc&id=$r['idisimanifestin']&pos=$r['nopos']">[BC1.2]</a>
				<a href="aksi.php?module=cetakbcdn&id=$r['idisimanifestin']&pos=$r['nopos']">[BC1.2-DN]</a>
				<a href="aksi.php?module=cetaknoa&id=$r['idisimanifestin']">[NOA]</a>
			</td>
			
            <td><?php echo $r['statuskeluar']; ?> No. <?php echo $r['nokeluar']; ?> Tgl <?php echo ymd2dmy($r['tglkeluar']); ?></td>
			
            <td><a href="aksi.php?module=cetakdo&id=$r['idisimanifestin']">[PAID]</a></td>
		</tr>
        		<?php	
						}
					else
					if(($r['paid']<>'1') AND ($r['nokeluar']==''))
						{
				?>
                
		  	<td></td>
            
			<td><a href="aksi.php?module=cetakbc&id=$r['idisimanifestin']&pos=$r['nopos']">[BC1.2]</a>
				<a href="aksi.php?module=cetakbcdn&id=$r['idisimanifestin']&pos=$r['nopos']">[BC1.2-DN]</a>
				<a href="aksi.php?module=cetaknoa&id=$r['idisimanifestin']">[NOA]</a>
				<a href="?module=harga&id=$r['idisimanifestin']&idm=$_GET[idm]&r=$_GET[r]&f=$_GET[f]&d=$_GET[d]"> [DO]</a>
			</td>
			
			<td><a href="?module=inputoutput&id=$r['idisimanifestin']&b=BC1.2&idm=$_GET[idm]&r=$_GET[r]&f=$_GET[f]&d=$_GET[d]">[BC1.2]</a>
				<a href="?module=inputoutput&id=$r['idisimanifestin']&b=BC2.3&idm=$_GET[idm]&r=$_GET[r]&f=$_GET[f]&d=$_GET[d]">[BC2.3]</a>
				<a href="?module=inputoutput&id=$r['idisimanifestin']&b=SPPB&idm=$_GET[idm]&r=$_GET[r]&f=$_GET[f]&d=$_GET[d]"> [SPPB]</a>
			</td>
			
			<td></td>
            
		</tr>
        		<?php	
						}
					else
					if(($r['paid']<>'1') AND ($r['nokeluar']<>''))
						{
				?>
		  	<td></td>
            
			<td><a href="aksi.php?module=cetakbc&id=$r[idisimanifestin]&pos=$r[nopos]">[BC1.2]</a>
				<a href="aksi.php?module=cetakbcdn&id=$r[idisimanifestin]&pos=$r[nopos]">[BC1.2-DN]</a>
				<a href="aksi.php?module=cetaknoa&id=$r[idisimanifestin]">[NOA]</a>
				<a href="?module=harga&id=$r[idisimanifestin]&idm=$_GET[idm]&r=$_GET[r]&f=$_GET[f]&d=$_GET[d]"> [DO]</a>
			</td>
			
			<td><?php echo $r['statuskeluar']; ?> No. <?php echo $r['nokeluar']; ?> Tgl <?php echo ymd2dmy($r['tglkeluar']); ?></td>
            
			<td></td>
            
		</tr>
        		<?php	
						}			
	
					}
				else
				if($r['nokeluar']=='')
					{
				?>
		  	<td><a href="aksi.php?module=isimanifestimport&act=cancel&idm=$_GET[idm]&r=$_GET[r]&f=$_GET[f]&d=$_GET[d]&iim=$r[idisimanifestin]" onclick="javascript:return confirm('Apakah Anda yakin akan menghapus AWB ini ?')">[CANCEL]</a>
		  	<a href="aksi.php?module=isimanifestimport&act=confirm&idm=$_GET[idm]&r=$_GET[r]&f=$_GET[f]&d=$_GET[d]&iim=$r[idisimanifestin]">[CONFIRM]</a>
			</td>
		
			<td><a href="aksi.php?module=cetakbc&id=$r[idisimanifestin]&pos=$r[nopos]">[BC1.2]</a>
				<a href="aksi.php?module=cetaknoa&id=$r[idisimanifestin]">[NOA]</a>
			</td>
            
			<td></td>
        
			<td></td>
        
		</tr>
        		<?php		
					}
				else
					{
				?>
		  	<td><a href="aksi.php?module=isimanifestimport&act=cancel&idm=$_GET[idm]&r=$_GET[r]&f=$_GET[f]&d=$_GET[d]&iim=$r[idisimanifestin]" onclick="javascript:return confirm('Apakah Anda yakin akan menghapus AWB ini ?')">[CANCEL]</a>
		  		<a href="aksi.php?module=isimanifestimport&act=confirm&idm=$_GET[idm]&r=$_GET[r]&f=$_GET[f]&d=$_GET[d]&iim=$r[idisimanifestin]">[CONFIRM]</a></td>
          
		  	<td><a href="aksi.php?module=cetakbc&id=$r[idisimanifestin]&pos=$r[nopos]">[BC1.2]</a>
		  		<a href="aksi.php?module=cetaknoa&id=$r[idisimanifestin]">[NOA]</a></td>
                
			<td><?php echo $r['statuskeluar']; ?> No. <?php echo $r['nokeluar']; ?> Tgl <?php echo ymd2dmy($r['tglkeluar']); ?> <a href="?module=edit_inputoutput&id=$r[idisimanifestin]&b=SPPB&idm=$_GET[idm]&r=$_GET[r]&f=$_GET[f]&d=$_GET[d]">[EDIT]</a>
            </td>
            
			<td></td>
			
		</tr>	
        		<?php	
					}
        		 $no++;
  				}
				?>
	</table>
