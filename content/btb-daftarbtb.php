<SCRIPT LANGUAGE="JavaScript" src="cal2.js">
</script>
<script language="javascript">
    addCalendar("Caritanggal","Tanggal","tglbtb","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
</script>

<?php
  $tglnya=date("d-m-Y");
  $p      = new Paging;
  $batas  = 10000;
  $posisi = $p->cariPosisi($batas);
  $no     = $posisi+1;

    echo "<h2>BTB Histories</h2>
        <form name=form1 method=POST action=?module=daftarbtb>
        <table>
       <tr><td>Tanggal BTB</td>     <td> : <input type=text onKeyDown=\"javascript:return dFilter (event.keyCode, this, '##-##-####');\" name=tglbtb size=20 value='$tglnya'>*";
  ?>
  <a href="javascript:showCal('Caritanggal')"><img src="images/calendar.png" border="0"></a>
  <?		
		echo "<input type=hidden name=carii value=1>
	    <tr><td colspan=2><input type=submit value=CARI DATA>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";
if($_POST[carii]=='1')
{
$a=my2date($_POST[tglbtb]);
   $tampil2=mysql_query("SELECT * FROM out_dtbarang_h,out_dtbarang where out_dtbarang_h.isvoid='0' 
  AND out_dtbarang_h.id=out_dtbarang.id_h AND out_dtbarang_h.btb_date like '$a%' GROUP By out_dtbarang.id_h 
  order by out_dtbarang_h.id DESC limit $posisi,$batas");
 	$tampil3=mysql_query("SELECT * FROM out_dtbarang_h where isvoid='0' AND out_dtbarang_h.btb_date like '$a%' ORDER BY id DESC");
}
else
{
$a=my2date($tglnya);
  $tampil2=mysql_query("SELECT * FROM out_dtbarang_h,out_dtbarang where out_dtbarang_h.isvoid='0' 
  AND out_dtbarang_h.id=out_dtbarang.id_h  AND btb_date like '$a%' GROUP By out_dtbarang.id_h 
 order by out_dtbarang_h.id DESC limit $posisi,$batas");
 	$tampil3=mysql_query("SELECT * FROM out_dtbarang_h where isvoid='0' AND btb_date like '$a%' ORDER BY id DESC");
}


echo "
		<table>
    <th width=70>No.BTB</th><th width=90>No.SMU</th><th width=70>Komoditi</th><th width=70>Tgl</th><th width=70>Tujuan</th><th width=70>Berat Bayar</th><th width=70>BAYAR</th><th width=130>ACTION</th></tr>";
 		while ($r=mysql_fetch_array($tampil2)){
     echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
          <td align=center>$r[btb_nobtb]</td><td align=center>$r[btb_smu]</td><td align=center>$r[dtBarang_type]</td><td align=center>".ymd2dmy($r[btb_date])."</td><td align=center>$r[btb_tujuan]</td><td align=center>$r[btb_totalberatbayar]</td>
					<td align=center>$r[status_bayar]</td><td align=center> ";
					if($r[status_bayar]=='no')
					{ 
					echo "<a href=aksi.php?module=btb&act=hapus&i=$r[id] title='klik untuk menghapus'>
					<img src=images/b_drop.png border=0 hspace=5>  
					 ";
					}
					echo "<a href=?module=btbinput&i=$r[0] title='klik untuk lihat detil BTB'><img src=images/b_view.png border=0 hspace=5></a> <a href=aksi.php?module=btb&act=cetak&i=$r[id] title='klik cetak slip BTB'><img src=images/b_print.png border=0 hspace=5></a> 
					</td></tr>";
     $no++;
  }
  echo "</table>";
 ;

	$jmldata      = mysql_num_rows($tampil3);
  $jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
  $linkHalaman  = $p->navHalaman($_GET[h], $jmlhalaman,'');


	echo "<p align=left>$linkHalaman</p></td></tr>
	</table></form>";


?>