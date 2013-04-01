<?php
?>
<SCRIPT LANGUAGE="JavaScript" src="cal2.js">
</script>
<script language="javascript">
    addCalendar("Caritanggalawal","Tanggal","cari","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
</script>
<?php
	$p      = new Paging;
	$batas  =10;
	$posisi = $p->cariPosisi($batas);
    $no     = $posisi+1;
	
if(!empty($_POST[cari])){$cari=$_POST[cari];}else{$cari=$_GET[cari];}
$tgl=my2date($cari);
if(!empty($cari))//jika user melakukan pencarian
{
		$tampil=mysql_query("SELECT * FROM dolar WHERE tgl = '$tgl' limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM dolar WHERE tgl = '$tgl'"));
//mulai membuat FORM nya
}
else
{
	$tampil=mysql_query("SELECT * FROM dolar order by tgl desc limit 2"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM dolar order by id desc limit 1")); 
}	


 	echo "<h2>DATA KURS DOLLAR per Hari</h2>
 		<form name=form1 id=form1 method=POST action='?module=dolar'>
		<table border=0 cellpadding=0 cellspacing=0 width=100%>
			<tr><td>
			PENCARIAN : <input name=cari type=text size=20 value='$_POST[cari]' autocomplete=off readonly=true> 
			<input type=submit value=CARI> ";
	 ?>
  <a href="javascript:showCal('Caritanggalawal')"><img src="images/calendar.png" border="0"></a>
  <?
		echo "<a href=?act=tambah_datadolar>
			<span class=tombol> TAMBAH DATA </span></a>
			</td></tr>
		</table>"; 
	$jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
	$linkHalaman  = $p->navHalaman($_GET['halaman'], $jmlhalaman,'cari='.$cari);	
	echo "<p>$linkHalaman</p><table><tr><th>no</th>
		<th>Date</a></th>
		<th>RUPIAH/USD</th><th>CL</th><th>HND</th><th>DOC</th><th>STATUS</th><th>action</th></th></tr>";
	while ($r=mysql_fetch_array($tampil))
	{
		if($r[exga]=='on'){$ex='EX-GA';} else {$ex='';}
		
		echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>$no</td><td align=center>".ymd2dmy($r[tgl])."</td>
          	<td align=right>".number_format($r[dolar], 0, ',', '.')."</td>
<td align=right>".number_format($r[cl], 2, ',', '.')."</td>
<td align=right>".number_format($r[hnd], 2, ',', '.')."</td>
<td align=right>".number_format($r[doc], 2, ',', '.')."</td>
<td align=right>".$ex."</td>
<td><a href=?act=edit_datadolar&id=$r[id]>EDIT</a> | 
			<a href=\"javascript:deldata('$r[id]','Data dolar tgl ini ?',
			'aksi.php?module=datadolar&act=hapus&id=')\">HAPUS</a>
          	</td></tr>";
     $no++;
  	}
  echo "</table><p>word '$cari' found : $jmldata rows in $jmlhalaman pages</p></form>";

?>