<?php
	if($_GET['p']=='e')
  	{
    	$err='Data Manifest Sudah Ada';
		}
  $tglnya=date("d-m-Y");
  ?>
  <SCRIPT LANGUAGE="JavaScript" src="cal2.js">
  </script>
  <script language="javascript">
    addCalendar("Caritanggal","Tanggal","tglmanifest","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
  </script>
  <?
  echo "<h2>CARGO MANIFEST export</h2>
       <form name=form1 method=POST action=aksi.php?module=manifestout&act=input>
       <table><tr><td>
			  <B>INPUTKAN HEADER MANIFEST</B><BR>
       <table>
       <tr>
       <td>Airline</td>     <td> :
       <select name=airline>";
           $tampil=mysql_query("SELECT * FROM airline ORDER BY airlinecode");
           while($r=mysql_fetch_array($tampil))
           {
    	     echo "<option value='$r[airlinecode]' selected>$r[airlinename]</option>";
  	   }
  echo "</select></td></tr>
       <tr><td>A/C Registration</td>     <td> : <input type=text size=20 name=acregistration autocomplete=off onChange=\"javascript:this.value=this.value.toUpperCase();\">*
       <tr><td>Flight No</td>     <td> : <input type=text size=20 name=noflight autocomplete=off onChange=\"javascript:this.value=this.value.toUpperCase();\">*
       <tr><td>Tanggal Manifest</td>     <td> : <input type=text name=tglmanifest size=20 value='$tglnya' readonly>*";
  ?>
  <a href="javascript:showCal('Caritanggal')"><img src="images/calendar.png" border="0"></a>
  <?
  echo "       <tr><td align=right>NIL ?</td>     
			 <td> : <input type=checkbox name=nil /> (check for NIL)</td></tr>
			 <input type=hidden name=nosmubtb value='$_GET[n]'><input type=hidden name=id value='$_GET[d]'></td></tr>
	<tr><td colspan=2><input type=submit value='Simpan dan Buildup'>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table><span class=error>$err</span>
        </td><td>";

  $p      = new Paging;
  $batas  = 100;
  $posisi = $p->cariPosisi($batas);

  $no     = $posisi+1;
  $tampil2=mysql_query("SELECT * FROM manifestout where isvoid='0' ORDER BY tglmanifest DESC limit $posisi,$batas");
 	$tampil3=mysql_query("SELECT * FROM manifestout where isvoid='0' ORDER BY tglmanifest DESC ");
echo "<CENTER><b>== HISTORI MANIFEST export ==</b></CENTER> 
		<table>
    <tr><th>no</th><th>Airline</th><th>Flight No.</th><th>A/C Registration</th><th>Date</th><th>Status</th><th>ACTION</th></tr>";
 		while ($r=mysql_fetch_array($tampil2)){
     echo "<tr><td align=center>$no</td>
          <td align=center>$r[airline]</td><td align=center>$r[noflight]</td><td align=center>$r[acregistration]</td><td align=center>".ymd2dmy($r[tglmanifest])."</td><td align=center>$r[status]</td><td align=center> ";
					if($r[status]=='checked')
					{ 
					echo "<a href=\"?module=batalmo&i=$r[id_manifestout] 
					\" onclick=\"javascript:return confirm('Pembatalan ini terjadi bila MANIFEST sudah CHECKED tetapi BATAL diberangkatkan. Pembatalan ini akan mengembalikan status manifest menjadi WAITING kembali. Proses ini akan direkam beserta alasannya. Apakah Anda ingin membatalkan manifest ini ?')\"><img src=images/b_deltbl.png border=0 hspace=5 title='Manifest BATAL' alt='Manifest BATAL'></a>";
					}
					else{ 
					echo "<a href=aksi.php?module=manifestout&act=hapus&i=$r[id_manifestout] title='klik untuk menghapus data' onclick=\"javascript:return confirm('Penghapusan data diperbolehkan dan tidak akan direkam karena data manifest ini belum CHECKED. Semua data buildup yang merujuk ke manifest ini akan ikut terhapus. Apakah Anda yakin data manifest ini akan dihapus ?')\"><img src=images/b_drop.png border=0 hspace=5 title='hapus manifest' alt='hapus manifest'></a> <a href=?module=editmanifestout&i=$r[id_manifestout] title='klik untuk memperbaiki data manifest export'><img src=images/b_edit.png border=0 hspace=5 title='Edit Manifest' alt='Edit Manifest'></a> <a href=aksi.php?module=manifestout&act=checked&i=$r[id_manifestout] title='klik untuk confirm barang berangkat' onclick=\"javascript:return confirm('Status CHECKED berarti melakukan konfirmasi bahwa cargo untuk MANIFEST OUT ini telah berangkat. Manifest tidak dapat dihapus atau diedit setelah CHECKED. Apakah Anda yakin ? ')\"><img src=images/b_usrcheck.png border=0 hspace=5 title='klik untuk CONFIRM' alt='klik untuk CONFIRM'></a>";}
					echo "<a href=?module=manifestoutinput&i=$r[id_manifestout] title='klik untuk lihat barang'=&i=$r[id_manifestout] title='klik untuk lihat barang'><img src=images/b_view.png border=0 hspace=5 title='klik untuk lihat isi' alt='klik untuk lihat isi'></a><a href=aksi.php?module=cetakmanifestout&i=$r[id_manifestout]  target=_blank title='klik untuk cetak manifest'><img src=images/b_print.png border=0 hspace=5 title='klik untuk cetak manifest' alt='klik untuk cetak manifest'> </a> 
					</td></tr>";
     $no++;
  }
  echo "</table>";
 ;

	$jmldata      = mysql_num_rows($tampil3);
  $jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
  $linkHalaman  = $p->navHalaman($_GET[h], $jmlhalaman,'');


	echo "$linkHalaman";
	echo "<BR><BR>Status <B>\"waiting\"</B> berarti secara fisik <B>barang belum diberangkatkan (masih dalam gudang)</B>.</td></tr>
	</table></form>
	
				</td></tr>
        
				</form>";


?>