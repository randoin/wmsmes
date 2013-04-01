<SCRIPT LANGUAGE="JavaScript" src="cal2.js">
</script>
<script language="javascript">
    addCalendar("Caritanggalawal","Tanggal","tglawal","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
</script>
<?
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
 	echo "<h2>Data Manifest Export : $_GET[d] $_GET[f] A/C Reg.$_GET[r] | Total : $totsmu SMU -> $totb[1]koli $totb[0]kg </h2><p>";
	//$dt=my2date($_POST[tglawal]);		
$tdy=ymd2dmy($today);

if($_GET[d]!=''){$dt=my2date($_GET[d]);}
else {$dt=my2date($_POST[tglawal]);}

	echo "<a href=?module=carimanifestexport&idm=$_GET[idm]&d=$dt>[KEMBALI]</a></p>";		
	$tampil=mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu FROM 
	isimanifestout as i,manifestout as m, master_smu as s 
	WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0'
	 AND m.idmanifestout='$_GET[idm]'"); 

//mulai membuat FORM nya
 	echo "<table><tr>
		<th>No</th>
		<th>ULD</th>
		<th>AWB#</th>
		<th>KOLI</th>
		<th>KG</th>
		</tr>";
		$no=1;
	while ($r=mysql_fetch_array($tampil))
	{
	echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>$no</td><td>$r[nould]</td><td>$r[nosmu]</td><td>$r[koli]</td><td>$r[berat]</td></tr>";
     $no++;
  	}
  echo "</table>";

?>