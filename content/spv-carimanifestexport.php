<SCRIPT LANGUAGE="JavaScript" src="cal2.js">
</script>
<script language="javascript">
    addCalendar("Caritanggalawal","Tanggal","tglawal","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
</script>
<?
$tgl=date('Y-m-d');
if(!empty($_POST[cari])){$cari=$_POST[cari];}else{$cari=$_GET[cari];}

//mulai membuat FORM nya
 	echo "<h2>Data Manifest Export</h2>
 		<form name=form1 method=POST action='?module=carimanifestexport'>
		<table border=0 cellpadding=0 cellspacing=0 width=100%>
			<tr><td>
			PENCARIAN : <input type=text onKeyDown=\"javascript:return dFilter (event.keyCode, this,'##-##-####');\" name=tglawal value=".ymd2dmy($tgl).">"; 
				 ?>
  <a href="javascript:showCal('Caritanggalawal')"><img src="images/calendar.png" border="0"></a>
<? echo "<input type=submit value=CARI></td></tr>
		</table>";
				
if($_GET[d]!=''){$dt=$_GET[d];}
else {$dt=my2date($_POST[tglawal]);}
		
$tdy=ymd2dmy($today);
	$tampil=mysql_query("SELECT m.idmanifestout,m.acregister,m.flightdate,m.pointofloading,m.pointul,m.statusnil,
	f.flight,o.origin_code, d.dest_code,m.statusconfirm,m.statuscancel,c.bendera,c.cus_desc
	FROM manifestout as m,origin as o,destination as d,flight as f, customer as c
	WHERE m.idorigin=o.idorigin AND m.iddestination=d.iddestination AND m.idflight=f.idflight AND m.statusvoid='0' AND 
	f.idcustomer=c.idcustomer AND m.flightdate='$dt' order by m.flightdate desc"); 

//mulai membuat FORM nya
 	echo "<table><tr>
		<th>A/C Reg.</th>
		<th>Flight Date</th>
		<th>Flight</th>
		<th>Org</th 
		<th>Dest</th>
		<th>Koli / Kg</th>
		<th>status</th>
		<th>action</th>
		</tr>";
	while ($r=mysql_fetch_array($tampil))
	{
		$cekbrt=mysql_fetch_array(mysql_query("select sum(i.koli) as koli,sum(i.berat) as berat 
						from manifestout as m, isimanifestout as i 
						where i.idmanifestout=m.idmanifestout AND i.statusvoid='0' 
						AND i.idmanifestout=$r[idmanifestout]"));
		if($cekbrt[koli]==''){$koli=0;} else $koli=$cekbrt[koli];
		if($cekbrt[berat]==''){$berat=0;} else $berat=$cekbrt[berat];
		
		
if($r[statusnil]=='on'){$n='nil';
	echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>$r[acregister]</td>";}
else {$n="$koli / $berat";
	echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td><a href=?module=isimanifestexport&idm=$r[idmanifestout]&r=$r[acregister]&f=$r[flight]&d=".ymd2dmy($r[flightdate]).">$r[acregister]</a></td>";		}
	echo "<td>".ymd2dmy($r[flightdate])."</td><td>$r[flight] $r[cus_desc]</td>
          	<td>$r[origin_code]</td><td>$r[dest_code]</td><td>$n</td>
			<td>";
			if(($r[statusconfirm]=='1') AND ($r[statuscancel]=='0'))
			 {
			  echo "OUT</td><td><a href=aksi.php?module=carimanifestexport&act=release&idm=$r[idmanifestout]&d=$dt onclick=\"javascript:return confirm('RELEASE MANIFEST INI ? ')\">[RELEASE]</a>    | <a href=aksi.php?module=carimanifestexport&act=void&idm=$r[idmanifestout]&d=$dt onclick=\"javascript:return confirm('VOID MANIFEST INI ? ')\">[VOID]</a></td>";
			 }
			else if($r[statuscancel]=='1')
			 {
			  echo "CANCEL</td><td></td>";
			 }
			 else
			 {
			  echo "INSTORE</td><td><a href=aksi.php?module=carimanifestexport&act=confirm&idm=$r[idmanifestout]&d=$dt 
		  onclick=\"javascript:return confirm('VOID MANIFEST INI ?')\">[VOID]</a></td>";
			 }
			echo "</td></tr>";
     $no++;
  	}
  echo "</table>";

?>