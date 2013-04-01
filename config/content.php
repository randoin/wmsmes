<?php
include "config/koneksi.php";
include "config/fpdf.php";
include "config/library.php";
include "config/fungsi_indotgl.php";
include "config/fungsi_combobox.php";
include "config/class_paging.php";


// Module Home
if (($_GET[module]=='home'))
{
  echo "<h2>Selamat Datang</h2>
       <p>Halo <b>$_SESSION[namauser]</b>, apa kabar Anda hari ini ?
       Semoga Baik dan Selamat Bekerja !<BR>Hari ini: ";
  echo tgl_indo(date("Y m d"));
  echo " | ";
  echo date("H:i:s");
  echo "</p>";
}

//******************************START OF SUPERVISOR *************************************
// Manajemen User
elseif (($_GET[module]=='user')AND($_SESSION[level]=='supervisor'))
{
  echo "<h2>MANAJEMEN USER ACCOUNT WMS</h2>
        <form method=POST action='?act=tambahuser'>
        <input type=submit value='Tambah User' class='tombol'>
        </form>
        <table>
        <tr><th>no</th><th>username</th><th>nama lengkap</th><th>nipp</th><th>user level</th>
		<th>no telpon</th><th>action</th></th></tr>";
	$p      = new Paging;
	$batas  = 5;
	$posisi = $p->cariPosisi($batas);
	$tampil=mysql_query("SELECT * FROM user WHERE id_user!='admin' ORDER BY level DESC,id_user ASC limit $posisi,$batas");
    $no     = $posisi+1;
  while ($r=mysql_fetch_array($tampil)){
	echo "<tr><td>$no</td>
          <td>$r[id_user]</td>
          <td>$r[nama_lengkap]</td><td>$r[nipp]</td><td>$r[level]</td><td>$r[telpon]</td>
		      
          <td><a href=?act=edituser&id=$r[id_user]>EDIT</a> | 
	            <a href=aksi.php?module=user&act=hapus&id=$r[id_user]>HAPUS</a>
          </td></tr>";
     $no++;
  }
  echo "</table>";
	$jmldata      = mysql_num_rows(mysql_query("SELECT * FROM user WHERE id_user!='admin'"));
	$jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
	$linkHalaman  = $p->navHalaman($_GET[h], $jmlhalaman,'');
	echo "<p>$linkHalaman</p>";
}

// Form tambah user
elseif (($_GET[act]=='tambahuser')AND($_SESSION[level]=='supervisor')){
  echo "<h2>TAMBAH USER ACCOUNT WMS</h2>
        <form method=POST action='aksi.php?module=user&act=input'>
        <table>
        <tr><td>Username</td>     <td> : <input type=text name=id_user> *</td></tr>
        <tr><td>Password</td>     <td> : <input type=text name=password> *</td></tr>
        <tr><td>Nama Lengkap</td> <td> : <input type=text name=nama_lengkap size=30> *</td></tr>
        <tr><td>NIPP</td> <td> : <input type=text name=nipp size=20> *</td></tr>				
		<tr><td>No. Telpon</td> <td> : <input type=text name=no_telpon size=30></td></tr>		  
        <tr><td>User Level</td> <td> : 
		<select name=level>
			<option value='supervisor' selected>SUPERVISOR</option>
			<option value='kasir'>KASIR</option>
			<option value='incoming'>INCOMING BREAKDOWN</option>
			<option value='outgoing'>OUTGOING BUILDUP</option>
			<option value='btb'>BTB</option>
		</select>
		</td></tr>
		<tr><td colspan=2>*) wajib diisi, jika kosong maka data tidak akan tersimpan.</td></tr> 
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";
}

// Form edit user
elseif (($_GET[act]=='edituser')AND($_SESSION[level]=='supervisor')){
  $edit=mysql_query("SELECT * FROM user WHERE id_user='$_GET[id]'");
  $r=mysql_fetch_array($edit);

  echo "<h2>Edit User</h2>
        <form method=POST action=aksi.php?module=user&act=update>
        <input type=hidden name=id value='$r[id_user]'>
        <table>
        <tr><td>Username</td>     <td> : <input type=text name=id_user value='$r[id_user]'></td></tr>
        <tr><td>Password</td>     <td> : <input type=text name=password> *) </td></tr>
        <tr><td>Nama Lengkap</td> <td> : <input type=text name=nama_lengkap size=30  value='$r[nama_lengkap]'></td></tr>
        <tr><td>NIPP</td> <td> : <input type=text name=nipp size=20 value='$r[nipp]'> *</td></tr>					
        <tr><td>User Level</td> <td> : 
		<select name=level>";
		if($r[level]=='supervisor')
		{
		echo "<option value='supervisor' selected>SUPERVISOR</option>
			<option value='kasir'>KASIR</option>
			<option value='incoming'>INCOMING BREAKDOWN</option>
			<option value='outgoing'>OUTGOING BUILDUP</option>";
		}
		else if($r[level]=='kasir')
		{
		echo "<option value='supervisor' selected>SUPERVISOR</option>
			<option value='kasir' selected>KASIR</option>
			<option value='incoming'>INCOMING BREAKDOWN</option>
			<option value='outgoing'>OUTGOING BUILDUP</option>";
		}
		else if($r[level]=='incoming')
		{
		echo "<option value='supervisor'>SUPERVISOR</option>
			<option value='kasir'>KASIR</option>
			<option value='incoming' selected>INCOMING BREAKDOWN</option>
			<option value='outgoing'>OUTGOING BUILDUP</option>";
		}
		else if($r[level]=='outgoing')
		{
		echo "<option value='supervisor'>SUPERVISOR</option>
			<option value='kasir'>KASIR</option>
			<option value='incoming'>INCOMING BREAKDOWN</option>
			<option value='outgoing' selected>OUTGOING BUILDUP</option>";
		}
		
		echo "</select></td></tr>
		<tr><td>No. Telpon</td> <td> : <input type=text name=no_telpon size=30 value='$r[telpon]'></td></tr>						
        <tr><td colspan=2>*) Apabila password tidak diubah, dikosongkan saja.</td></tr>
        <tr><td colspan=2><input type=submit value=Update>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";
}

// Harga Sewa Gudang
elseif (($_GET[module]=='sewagudang')AND($_SESSION[level]=='supervisor'))
{
?>
 <SCRIPT language=Javascript>
//Convert array into object
function oc(a)
{
var o = {};
for(var i=0;i<a.length;i++)
{
o[a[i]]='';
}
return o;
}

//Allow only numeric input, decimal point, backspace
function isNumberKey(evt)
{
var myValidChars = new Array(0,8,46,48,49,50,51,52,53,54,55,56,57,190);
var charCode = (evt.which) ? evt.which : event.keyCode
if (charCode in oc(myValidChars))
return true;
return false;
}
   </SCRIPT>

<?
$tgl=date("Y-m-d");

	if((!empty($_POST[sewagudang])) AND (!empty($_POST[dokumen])) AND (!empty($_POST[ppn])))
	{
		mysql_query("INSERT INTO hargasewa (tgl,sewaperhari,dokumen,user,ppn,minhari,mincharge) values ('$tgl','$_POST[sewagudang]','$_POST[dokumen]','$_SESSION[namauser]','$_POST[ppn]','$_POST[minhari]','$_POST[mincharge]')");
	}
	
	$tampil=mysql_query("select * from hargasewa order by id DESC limit 1");
	$p=mysql_fetch_array($tampil);
	
  echo "<h2>PARAMETER HARGA SEWA DOKUMEN DAN BIAYA LAINNYA</h2>
        <form method=POST action='?module=sewagudang'>
				  <table>
       			<tr><td>Sewa Gudang / Hari (Rp)</td>     
							<td> : <input type=text name=sewagudang value='$p[sewaperhari]' onkeypress=\"return isNumberKey(event)\"> *</td></tr>
        		<tr><td>Administrasi (Rp)</td>     <td> : <input type=text name=dokumen value='$p[dokumen]' onkeypress=\"return isNumberKey(event)\"> *</td></tr>
        		<tr><td>PPn (%)</td> <td> : <input type=text name=ppn size=10 value='$p[ppn]' onkeypress=\"return isNumberKey(event)\"> *</td></tr>		
        		<tr><td>Minimal Hari</td> <td> : <input type=text name=minhari size=10 value='$p[minhari]' onkeypress=\"return isNumberKey(event)\"> <input type=text name=mincharge size=10 value='$p[mincharge]' onkeypress=\"return isNumberKey(event)\"> *</td></tr>		
  											
						<tr><td colspan=2>*) wajib diisi, jika kosong maka data tidak akan tersimpan.</td></tr> 
        		<tr><td colspan=2><input type=submit value='UPDATE HARGA'>
        		<input type=button value=Batal onclick=self.history.back()></td></tr>
        	</table>
				</form>	
	<table><tr><th>no</th><th>Tanggal</th><th>Sewa Gudang/Hari</th><th>Dokumen</th>
		<th>Ppn</th><th>Min Hari</th><th>Min Charge (Rp)</th><th>user</th></tr>";
		$p      = new Paging;
		$batas  = 2;
		$posisi = $p->cariPosisi($batas);
		$tampil=mysql_query("SELECT * FROM hargasewa ORDER BY id DESC limit $posisi,$batas");
    $no     = $posisi+1;
		$tgl1=my2date($r[tgl]);
  	while ($r=mysql_fetch_array($tampil))
		{
			echo "<tr><td>$no</td>
      	    <td>$r[tgl]</td>
        	  <td>$r[sewaperhari]</td>
						<td>$r[dokumen]</td>
						<td>$r[ppn]</td>
						<td>$r[minhari]</td>
						<td>$r[mincharge]</td>						
						<td>$r[user]</td></tr>";
     	$no++;
  	}
  	echo "</table>";
			$jmldata      = mysql_num_rows(mysql_query("SELECT * FROM hargasewa"));
			$jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
			$linkHalaman  = $p->navHalaman($_GET[h], $jmlhalaman,'0');
		echo "<p>$linkHalaman</p>";
}


//************************************ END OF SUPERVISOR ***************************************************


//************************************ START OF ADMIN ***************************************************
// Bagian Modul
elseif (($_GET[module]=='modul')AND($_SESSION[level]=='admin')){
  echo "<h2>Modul</h2>
        <form method=POST action='?act=tambahmodul'>
        <input type=submit value='Tambah Modul'>
        </form>
        <table>
        <tr><th>no</th><th>nama modul</th><th>link</th>
        <th>publish</th><th>aktif</th><th>status</th><th>aksi</th></th></tr>";
  $tampil=mysql_query("SELECT * FROM modul ORDER BY urutan");
  while ($r=mysql_fetch_array($tampil)){
    echo "<tr><td>$r[urutan]</td>
          <td>$r[nama_modul]</td>
          <td><a href=$r[link]>$r[link]</a></td>
          <td align=center>$r[publish]</td>
          <td align=center>$r[aktif]</td>
          <td align=center>$r[status]</td>
          <td><a href=?act=editmodul&id=$r[id_modul]>Edit</a> | 
	            <a href=aksi.php?module=modul&act=hapus&id=$r[id_modul]>Hapus</a>
          </td></tr>";
  }
  echo "</table>";
}

// Form Tambah Modul
elseif (($_GET[act]=='tambahmodul')AND($_SESSION[level]=='admin')){
  echo "<h2>Tambah Modul</h2>
        <form method=POST action='aksi.php?module=modul&act=input'>
        <table>
        <tr><td>Nama Modul</td> <td> : <input type=text name=nama_modul></td></tr>
        <tr><td>Link</td>       <td> : <input type=text name=link size=30></td></tr>
        <tr><td>Publish</td>    <td> : <input type=radio name=publish value='Y' checked>Y 
                                       <input type=radio name=publish value='N'>N  </td></tr>
        <tr><td>Aktif</td>      <td> : <input type=radio name=aktif value='Y' checked>Y 
                                       <input type=radio name=aktif value='N'>N  </td></tr>
        <tr><td>Status</td>     <td> : <input type=radio name=status value='admin'>admin
		<input type=radio name=status value='outgoing' checked>outgoing
		<input type=radio name=status value='btb' >btb
		<input type=radio name=status value='incoming'>incoming
									   <input type=radio name=status value='outgoing'>store out
									   <input type=radio name=status value='store_in'>store in
									   <input type=radio name=status value='kasir'>kasir
									   <input type=radio name=status value='supervisor'>supervisor  </td></tr>
        <tr><td>Urutan</td>     <td> : <input type=text name=urutan size=1></td></tr>
        <tr><td colspan=2><input type=submit value=Simpan name=simpanmodul>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";
}

// Form Edit Modul
elseif (($_GET[act]=='editmodul')AND($_SESSION[level]=='admin')){
  $edit = mysql_query("SELECT * FROM modul WHERE id_modul='$_GET[id]'");
  $r    = mysql_fetch_array($edit);

  echo "<h2>Edit Modul</h2>
        <form method=POST action=aksi.php?module=modul&act=update>
        <input type=hidden name=id value='$r[id_modul]'>
        <table>
        <tr><td>Nama Modul</td>     <td> : <input type=text name=nama_modul value='$r[nama_modul]'></td></tr>
        <tr><td>Link</td>     <td> : <input type=text name=link size=30 value='$r[link]'></td></tr>";
  if ($r[publish]=='Y'){
    echo "<tr><td>Publish</td> <td> : <input type=radio name=publish value=Y checked>Y  
          <input type=radio name=publish value=N> N</td></tr>";
  }
  else{
    echo "<tr><td>Publish</td> <td> : <input type=radio name=publish value=Y>Y  
          <input type=radio name=publish value=N checked>N</td></tr>";
  }
  if ($r[aktif]=='Y'){
    echo "<tr><td>Aktif</td> <td> : <input type=radio name=aktif value=Y checked>Y  
          <input type=radio name=aktif value=N> N</td></tr>";
  }
  else{
    echo "<tr><td>Aktif</td> <td> : <input type=radio name=aktif value=Y>Y  
          <input type=radio name=aktif value=N checked>N</td></tr>";
  }
  if ($r[status]=='outgoing'){
    echo "<tr><td>Status</td> <td> : 
	<input type=radio name=status value=outgoing checked>outgoing
    <input type=radio name=status value=btb>btb
    <input type=radio name=status value=incoming>incoming
	<input type=radio name=status value=outgoing>store out
	<input type=radio name=status value=store_in>store in
	<input type=radio name=status value=kasir>kasir
	<input type=radio name=status value=supervisor>supervisor  
    <input type=radio name=status value=admin>admin</td></tr>";
  }
   else if ($r[status]=='incoming'){
    echo "<tr><td>Status</td> <td> : 
	<input type=radio name=status value=outgoing>outgoing
	    <input type=radio name=status value=btb>btb
    <input type=radio name=status value=incoming checked>incoming
	<input type=radio name=status value=outgoing>store out
	<input type=radio name=status value=store_in>store in
	<input type=radio name=status value=kasir>kasir
	<input type=radio name=status value=supervisor>supervisor  
    <input type=radio name=status value=admin>admin</td></tr>";
  }
   else if ($r[status]=='outgoing'){
    echo "<tr><td>Status</td> <td> : 
	<input type=radio name=status value=outgoing>outgoing
	    <input type=radio name=status value=btb>btb
    <input type=radio name=status value=incoming>incoming
	<input type=radio name=status value=outgoing checked>store out
	<input type=radio name=status value=store_in>store in
	<input type=radio name=status value=kasir>kasir
	<input type=radio name=status value=supervisor>supervisor  
    <input type=radio name=status value=admin>admin</td></tr>";
  }
     else if ($r[status]=='store_in'){
    echo "<tr><td>Status</td> <td> : 
	<input type=radio name=status value=outgoing>outgoing
	    <input type=radio name=status value=btb>btb
    <input type=radio name=status value=incoming>incoming
	<input type=radio name=status value=outgoing>store out
	<input type=radio name=status value=store_in checked>store in
	<input type=radio name=status value=kasir>kasir
	<input type=radio name=status value=supervisor>supervisor  
    <input type=radio name=status value=admin>admin</td></tr>";
  }
   else if ($r[status]=='kasir'){
    echo "<tr><td>Status</td> <td> : 
	<input type=radio name=status value=outgoing>outgoing
	    <input type=radio name=status value=btb>btb
    <input type=radio name=status value=incoming>incoming
	<input type=radio name=status value=outgoing>store out
	<input type=radio name=status value=store_in>store in
	<input type=radio name=status value=kasir checked>kasir
	<input type=radio name=status value=supervisor>supervisor  
   <input type=radio name=status value=admin>admin</td></tr>";
  }
      else if ($r[status]=='supervisor'){
    echo "<tr><td>Status</td> <td> : 
	<input type=radio name=status value=outgoing>outgoing
	    <input type=radio name=status value=btb>btb
    <input type=radio name=status value=incoming>incoming
	<input type=radio name=status value=outgoing>store out
	<input type=radio name=status value=store_in>store in
	<input type=radio name=status value=kasir>kasir
	<input type=radio name=status value=supervisor checked>supervisor  
    <input type=radio name=status value=admin>admin</td></tr>";
  }
   else if ($r[status]=='admin'){
    echo "<tr><td>Status</td> <td> : 
	<input type=radio name=status value=outgoing>outgoing
	    <input type=radio name=status value=btb>btb
    <input type=radio name=status value=incoming>incoming
	<input type=radio name=status value=outgoing>store out
	<input type=radio name=status value=store_in>store in
	<input type=radio name=status value=kasir>kasir
	<input type=radio name=status value=supervisor>supervisor  
    <input type=radio name=status value=admin checked>admin</td></tr>";
  } 
   else if ($r[status]=='btb'){
    echo "<tr><td>Status</td> <td> : 
	<input type=radio name=status value=outgoing>outgoing
	    <input type=radio name=status value=btb checked>btb
    <input type=radio name=status value=incoming>incoming
	<input type=radio name=status value=outgoing>store out
	<input type=radio name=status value=store_in>store in
	<input type=radio name=status value=kasir>kasir
	<input type=radio name=status value=supervisor>supervisor  
    <input type=radio name=status value=admin>admin</td></tr>";
  } 	
  
  
  else  if ($r[status]==''){
    echo "<tr><td>Status</td> <td> : <input type=radio name=status value=user>user  
          <input type=radio name=status value=admin checked>admin
		  </td></tr>";
  }
  echo "<tr><td>Urutan</td>       <td> : <input type=text name=urutan size=1 value='$r[urutan]'></td></tr>
        <tr><td colspan=2><input type=submit value=Update>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";
}

//************************************ END OF ADMIN ***************************************************



//************************START OF KASIR***************************************************
//Modul DeliveryBill
elseif (($_GET[module]=='deliverybill')AND ($_SESSION[level]=='kasir'))
{
	echo "<h2>Masukkan No. BTB/No. SMU</h2>
				<form method=POST action='aksi.php?module=deliverybill&act=caribtbsmu'>
					<input type=input name=nobtbsmu size=40 onChange=\"javascript:this.value=this.value.toUpperCase();\" autocomplete=off>
        	<input type=submit value='CHECK'>
        </form>";
	if($_GET[psn]=='t')
	{
		$halo='Barang Transit';
		echo "<p class=error>$halo</p>";
		echo "<p>INFO: <BR>Masukkan Nomor Bukti Timbang Barang (<B>No. BTB</B>) 
					untuk DeliveryBill <B>OUTGOING</B>. <BR>Masukkan nomor Surat Muatan Udara/Airway Bill 
					(<B>No. SMU/AWB</B>) untuk DeliveryBill <B>INCOMING</B></p>";
	} 
	elseif($_GET[psn]=='w')
	{
		$halo='Manifest masih status waiting (barang belum datang)';
		echo "<p class=error>$halo</p>";
		echo "<p>INFO: <BR>Masukkan Nomor Bukti Timbang Barang (<B>No. BTB</B>) 
					untuk DeliveryBill <B>OUTGOING</B>. <BR>Masukkan nomor Surat Muatan Udara/Airway Bill 
					(<B>No. SMU/AWB</B>) untuk DeliveryBill <B>INCOMING</B></p>";
	} 
	elseif($_GET[psn]=='o')
	{
		$halo='Barang sudah OUT';
		echo "<p class=error>$halo</p>";
		echo "<p>INFO: <BR>Masukkan Nomor Bukti Timbang Barang (<B>No. BTB</B>) 
					untuk DeliveryBill <B>OUTGOING</B>. <BR>Masukkan nomor Surat Muatan Udara/Airway Bill 
					(<B>No. SMU/AWB</B>) untuk DeliveryBill <B>INCOMING</B></p>";
	} 
	elseif($_GET[psn]=='e')
	{
		$halo='Data tidak ditemukan';
		echo "<p class=error>$halo</p>";
		echo "<p>INFO: <BR>Masukkan Nomor Bukti Timbang Barang (<B>No. BTB</B>) 
					untuk DeliveryBill <B>OUTGOING</B>. <BR>Masukkan nomor Surat Muatan Udara/Airway Bill 
					(<B>No. SMU/AWB</B>) untuk DeliveryBill <B>INCOMING</B></p>";
	} 
	else
 	{
  	echo "<p>INFO: <BR>Masukkan Nomor Bukti Timbang Barang (<B>No. BTB</B>) untuk DeliveryBill
		<B>OUTGOING</B>. <BR>Masukkan nomor Surat Muatan Udara/Airway Bill (<B>No. SMU/AWB</B>) untuk 
		DeliveryBill <B>INCOMING</B></p>";
 	}
}
//cetak laporan
elseif (($_GET[module]=='kasirlap')AND ($_SESSION[level]=='kasir'))
{
  ?>
  <SCRIPT LANGUAGE="JavaScript" src="cal2.js">
  </script>
  <script language="javascript">
    addCalendar("Caritanggalawal","Tanggal","tglawal","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
  </script>
  <script language="javascript">
    addCalendar("Caritanggalakhir","Tanggal","tglakhir","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
  </script>
	
  <?
	$tglsekarang=date("Y-m-d");
$today=ymd2dmy($tglsekarang);

	echo "<h2>Reporting</h2>
				<form name=form1 method=POST action='aksi.php?module=kasirlapcetak'>
				<table>
				<tr><td>Tanggal </td><td>: <input type=text name=tglawal value='$today'>"; 
				 ?>
  <a href="javascript:showCal('Caritanggalawal')"><img src="images/calendar.png" border="0"></a>
  <?
	echo "s/d <input type=text name=tglakhir value='$today'>"; 
				 ?>
  <a href="javascript:showCal('Caritanggalakhir')"><img src="images/calendar.png" border="0"></a>
  <?
	echo "</td></tr>
				<tr><td>Laporan  </td><td>: 
					<select name=tipe_laporan>
					 <option value='per_smu'>Per SMU</option>
					 <option value='per_agent'>Per Agent</option>
					 <option value='per_airline'>Per Airline</option>
					<option value='per_tipebarang'>Per Tipe Barang</option>					 	
					 				 					 
					</select>
				</td></tr>
				<tr><td>Pada  </td><td>: 
					<select name=outin>
					 <option value='INCOMING'>INCOMING</option>
					 <option value='OUTGOING'>OUTGOING</option>
					</select>
				</td></tr>
				<tr><td>Jenis Pembayaran  </td><td>: 
					<select name=cara_bayar>
					 <option value='SEMUA'>SEMUA</option>
					 <option value='CASH'>CASH</option>
					 <option value='PERIODICAL'>PERIODICAL</option>
					</select>
				</td></tr>		
				<tr><td>Untuk  </td><td>: 
					<select name=untuk>
					 <option value='gp'>Internal GAPURA</option>
					 <option value='ap'>Angkasa Pura</option>
					</select>
				</td></tr>
				<tr><td colspan=2><input type=submit value=CETAK></td> 								
				</table>
        </form>";
	
}

//MODUL DAILY REPORT KASIR
elseif (($_GET[module]=='dailyreport')AND ($_SESSION[level]=='kasir'))
{
?>
	<SCRIPT LANGUAGE="JavaScript" src="cal2.js"></script>
  <script language="javascript">
    addCalendar("Caritanggalawal","Tanggal","tglawal","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
  </script>
  <script language="javascript">
    addCalendar("Caritanggalawal2","Tanggal","tglawal","form2");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
  </script>
  <script language="javascript">
    addCalendar("Caritanggalawal3","Tanggal","tglawal","form3");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
  </script>	
<?
	$tglsekarang=date("Y-m-d");
	$today=ymd2dmy($tglsekarang);
	echo "<h2>Daily Report</h2>
				<table><tr><td><form name=form1 method=POST action='aksi.php?module=dailyreport'>
				<table>
				<tr><td>Tanggal </td><td>: <input type=text name=tglawal value='$today'>"; 
?>
  <a href="javascript:showCal('Caritanggalawal')"><img src="images/calendar.png" border="0"></a>
<?
	echo "</td></tr>
			<tr><td>Airline  </td><td>: 
	      <select name=airline>
				<option value='' selected>*</option>";
        $tampil=mysql_query("SELECT * FROM airline ORDER BY airlinecode");
         while($r=mysql_fetch_array($tampil))
				{
    	    echo "<option value='$r[airlinecode]'>$r[airlinename]</option>";
				}
  echo "</select>
				</td></tr>
				<tr><td>Proses </td><td>: 
				<select name=outin>
				<option value='0' selected>INCOMING</option>
				<option value='1'>OUTGOING</option>
				</select>
				</td></tr>
				<tr><td>Jenis Pembayaran  </td><td>: 
					<select name=cara_bayar>
					 <option value=''>*</option>
					 <option value='CASH' selected>CASH</option>
					 <option value='PERIODICAL'>PERIODICAL</option>
					</select>
				</td></tr>		
				<tr><td>Untuk  </td><td>: 
					<select name=untuk>
					 <option value='gp' selected>Internal GAPURA</option>
					 <option value='ap'>Angkasa Pura</option>
					</select>
				</td></tr>
		
				<tr><td colspan=2 align=center><input type=submit value='CETAK Per Airline Per SMU' name=pilih></td> 								
				</table>
        </form></td><td><form name=form2 method=POST action='aksi.php?module=dailyreport'>
				<table>
				<tr><td>Tanggal </td><td>: <input type=text name=tglawal value='$today'>"; 
?>
  <a href="javascript:showCal('Caritanggalawal2')"><img src="images/calendar.png" border="0"></a>
<?
	echo "</td></tr>
			<tr><td>Airline  </td><td>: 
	      <select name=airline>
				<option value='' selected>*</option>";
        $tampil=mysql_query("SELECT * FROM airline ORDER BY airlinecode");
         while($r=mysql_fetch_array($tampil))
				{
    	    echo "<option value='$r[airlinecode]'>$r[airlinename]</option>";
				}
  echo "</select>
				</td></tr>
				<tr><td>Proses </td><td>: 
				<select name=outin>
 	 		  <option value=''>*</option>				
				<option value='0' selected>INCOMING</option>
				<option value='1'>OUTGOING</option>
				</select>
				</td></tr>
				<tr><td>Jenis Pembayaran  </td><td>: 
					<select name=cara_bayar>
					 <option value=''>*</option>
					 <option value='CASH' selected>CASH</option>
					 <option value='PERIODICAL'>PERIODICAL</option>
					</select>
				</td></tr>		
				<tr><td>Untuk  </td><td>: 
					<select name=untuk>
					 <option value='gp' selected>Internal GAPURA</option>
					 <option value='ap'>Angkasa Pura</option>
					</select>
				</td></tr>
		
				<tr><td colspan=2 align=center><input type=submit value='CETAK Per Airline Per Komoditi' name=pilih></td> 								
				</table>
        </form></td><td><form name=form3 method=POST action='aksi.php?module=dailyreport'>
				<table>
				<tr><td>Tanggal </td><td>: <input type=text name=tglawal value='$today'>"; 
?>
  <a href="javascript:showCal('Caritanggalawal3')"><img src="images/calendar.png" border="0"></a>
<?
	echo "</td></tr>
				<tr><td>Agent</td><td>: 
	      <select name=agent>
				<option value='' selected>*</option>";
        $tampil=mysql_query("SELECT * FROM btb_agent ORDER BY btb_agent");
         while($r=mysql_fetch_array($tampil))
				{
    	    echo "<option value='$r[btb_agent]'>$r[btb_agent]</option>";
				}
	
	echo"			</td></tr>
				<tr><td>Proses </td><td>: 
				<select name=outin>
 	 		  <option value=''>*</option>				
				<option value='0' selected>INCOMING</option>
				<option value='1'>OUTGOING</option>
				</select>
				</td></tr>
				<tr><td>Jenis Pembayaran  </td><td>: 
					<select name=cara_bayar>
					 <option value=''>*</option>
					 <option value='CASH' selected>CASH</option>
					 <option value='PERIODICAL'>PERIODICAL</option>
					</select>
				</td></tr>		
				<tr><td>Untuk  </td><td>: 
					<select name=untuk>
					 <option value='gp' selected>Internal GAPURA</option>
					 <option value='ap'>Angkasa Pura</option>
					</select>
				</td></tr>
		
				<tr><td colspan=2 align=center><input type=submit value='CETAK Per Agent Per Komoditi' name=pilih></td> 								
				</table>
        </form></td></tr></table>";
	
}

//Modul Bayar
elseif (($_GET[module]=='bayar')AND ($_SESSION[level]=='kasir')){
?>

<script type="text/javascript">
function hitungtotal(value) {
  var dis=Number(value/100)*(Number (document.getElementById('overtime1').value)+Number (document.getElementById('document1').value));
  var hasil = Number (document.getElementById('overtime1').value)
	+ Number (document.getElementById('document1').value)-dis;
	var x=Number (document.getElementById('pp').value/100)*hasil;
	var ll=hasil+x;
	document.getElementById('afterdiskon').value=Math.round(dis);
	document.getElementById('afterlain').value=Math.round(x);	
	//document.getElementById('overtime1').value=Math.round(hasil);
	document.getElementById('bt').value=Math.round(ll);	
	document.getElementById('bt0').value=Math.round(ll);
	document.getElementById('ppn1').value=Math.round(x);		
	}
</script>

<?
$tgl=date("Y-m-d");
$tampil=mysql_query("SELECT * from hargasewa order by id DESC limit 1");
$r=mysql_fetch_array($tampil);

$datasewagudang=$r[sewaperhari];
$datappn=$r[ppn];
$datadokumen=$r[dokumen];


if($_GET[d]=='1'){//jika outgoing
$jdl='DeliveryBill OUTGOING - No. BTB : '.$_GET[n];
		$tampil=mysql_query("SELECT * FROM out_dtbarang_h where btb_nobtb='$_GET[n]' AND status_bayar='no' AND isvoid='0' AND posted='1'");
		$r=mysql_fetch_array($tampil);
		if($r[btb_totalberatbayar]<=10){$beratkalitarif=4000;}else {$beratkalitarif=round($r[btb_totalberatbayar]*$datasewagudang);}
		$dokumen=$datadokumen;
		$lama=ngitunghari($r[btb_date],$tgl)+1;
		if($lama<=0){$lama=1;}
		if($lama<4){$lamaku=1;}
		else if($lama>=4){$lamaku=$lama-2;}
		$total=round($beratkalitarif*$lamaku);
		$ppn=round(($total+$dokumen)*($datappn/100));
		$total2=round($total+$dokumen+$ppn);
		$formatdokumen=number_format($dokumen, 0, '.', '.');   		
		$formatberatkalitarif=number_format($beratkalitarif, 0, '.', '.');
		$formattotal=number_format($total, 0, '.', '.');   		
		$formatppn=number_format($ppn, 0, '.', '.');
		$formattotal2=number_format($total2, 0, '.', '.');
  
	echo "<h2>$jdl</h2>
        <form name=form1 method=POST action='aksi.php?module=deliverybill&act=input'>
        <table>
       	<tr>
			 		<td>Tgl BTB</td>     
					<td> : <input type=text size=20 value=".ymd2dmy($r[btb_date])." readonly=true> *</td>		
					<td></td>
			 		<td>No. SMU</td>
			 		<td> : <input type=text size=20  name=nosmu value=\"$r[btb_smu]\"> </td>  
				</tr>
       	<tr>
			 		<td>Pengirim/Agent</td>    
					<td> : <input type=text size=20 value=".$r[btb_agent]." readonly=true> *</td>		
					<td></td>
			 		<td>Airline/Tujuan</td>
			 		<td> : <input type=text size=20 value=".$r[airline]."/".$r[btb_tujuan]." readonly=true> *</td>     
				</tr>
       	<tr>
			 		<td>Administrasi (Rp)</td>    
					<td> : <input type=text size=20 value=$formatdokumen readonly=true> *</td>		
					<td></td>
					<td>Total Berat Bayar (Kg)</td>
			 		<td> : <input type=text size=20 value=".$r[btb_totalberatbayar]." readonly=true> *</td>  
				</tr>		
       	<tr>
			 		<td>Sewa Gudang/hari (Rp)</td>
			 		<td> : <input type=text size=20 value=$formatberatkalitarif readonly=true> *</td> 
					<td></td>
				 	<td>Cara Pembayaran</td>  <td> : <select name=id_carabayar>
    			<option value=CASH selected>CASH</option><option value=PERIODICAL>PERIODICAL</option>   
				</tr>			
       	<tr>
			 		<td>Total Sewa Gudang (Rp)</td>     
					<td> : <input type=text name=overtime size=20 value='$formattotal' readonly=true> * $lama hari</td>		
					<td></td>
			 		<td></td>
			 		<td></td> 
				</tr>
       	<tr>
					<td>Disc. (% | Rp)</td>     
					<td> : <input type=text size=5 onchange='javascript:hitungtotal(this.value)' name=diskon id=diskon> 
								<input type=text size=20 name=afterdiskon id=afterdiskon readonly=true></td>					
					<td></td>		 	
					<td colspan=2 rowspan=3>Keterangan Diskon :<BR><textarea name=keterangan cols=40 ></textarea></td>
				</tr>
       	<tr>
					<td>PPn (% | Rp)</td>     
					<td> : <input type=text name=lain id=lain size=5 value=$datappn readonly=true> 
					<input type=text size=20 name=afterppn id=afterlain value=$formatppn readonly=true> *</td>					
					<td></td>
				</tr>
       	<tr>
					<td>BIAYA TOTAL (Rp)</td>    
					<td> : <input type=text size=30 value=$formattotal2 readonly=true name=bt id=bt> *</td>
					<td></td>
				</tr>																
				
  		<input type=hidden name=hari value='$lama'>
			<input type=hidden name=pp id=pp value='$datappn'>					
  		<input type=hidden name=storage1 value =$beratkalitarif>
			<input type=hidden name=overtime1 id=overtime1 value =$total>	
			<input type=hidden name=document1 id=document1 value =$dokumen>									
			<input type=hidden name=ppn1 id=ppn1 value =$ppn>  
			  
			<input type=hidden name=nosmubtb value='$_GET[n]'>
			<input type=hidden name=bt0 id=bt0 value='$total2'>			
			<input type=hidden name=id value='$_GET[d]'>		   						
	    <tr><td colspan=5><strong>*) tidak perlu diisi (otomatis)</strong></td>
			<tr><td colspan=5><input type=submit value='Simpan dan Cetak'>
        <input type=button value=Batal onclick=self.history.back()> </td></tr>
        </table>
        </form>";

}
else
{
//jika INCOMING
$jdl='DeliveryBill INCOMING - No. SMU : '.$_GET[n];
		$tampil=mysql_query("
		SELECT * from breakdown,isimanifestin,manifestin 
where breakdown.id_isimanifestin=isimanifestin.id_isimanifestin AND isimanifestin.id_manifestin=manifestin.id_manifestin 
AND breakdown.status_ambil='INSTORE' AND isimanifestin.status_transit='DPS'  
AND isimanifestin.no_smu ='$_GET[n]' AND breakdown.id_breakdown='$_GET[x]' 
AND breakdown.status_bayar='no' 
AND breakdown.isvoid='0'");
		
	
		$r=mysql_fetch_array($tampil);
		if($r[beratdatang]<=10){$beratkalitarif=4000;}else {$beratkalitarif=round($r[beratdatang]*395);}
		$dokumen=2000;
		$lama=ngitunghari($r[tgldatang],$tgl);
		if($lama<=0){$lama=1;}
		if($lama<4){$lamaku=$lama;}
		else if($lama>=4){$lamaku=$lama-2;}
		
		$total=round($beratkalitarif*$lamaku);
		$ppn=round(($total+$dokumen)*0.1);
		$total2=round($total+$dokumen+$ppn);
 
$formatdokumen=number_format($dokumen, 0, '.', '.');
$formatberatkalitarif=number_format($beratkalitarif, 0, '.', '.');
$formattotal=number_format($total, 0, '.', '.');   		
$formatppn=number_format($ppn, 0, '.', '.');
$formattotal2=number_format($total2, 0, '.', '.');
 
 	echo "<h2>$jdl</h2>
        <form name=form1 method=POST action='aksi.php?module=deliverybill&act=input'>
        <table>
       	<tr>
			 		<td>Penerima</td>     
					<td> : <input type=text size=30 name=penerima onChange=\"javascript:this.value=this.value.toUpperCase();\" autocomplete=off></td>		
					<td></td>
			 		<td>No. SMU</td>
			 		<td> : <input type=text size=20 value='$r[no_smu]' name=nosmu readonly> *</td>  
				</tr>
       	<tr>
			 		<td>Alamat</td>    
					<td> : <textarea name=alamat onChange=\"javascript:this.value=this.value.toUpperCase();\"></textarea></td>		
					<td></td>
			 		<td>Airline/Asal</td>
			 		<td> : <input type=text size=20 value=".$r[airline]."/".$r[asal]." readonly=true> *</td>     
				</tr>
       	<tr>
			 		<td>Administrasi (Rp)</td>    
					<td> : <input type=text size=20 value=$formatdokumen readonly=true> *</td>		
					<td></td>
					<td>Total Berat Bayar (Kg)</td>
			 		<td> : <input type=text size=20 value=".$r[beratdatang]." readonly=true> *</td>  
				</tr>		
       	<tr>
			 		<td>Sewa Gudang/hari (Rp)</td>
			 		<td> : <input type=text size=20 value=$formatberatkalitarif readonly=true> *</td> 
					<td></td>
				 	<td>Cara Pembayaran</td>  <td> : <select name=id_carabayar>
    			<option value=CASH selected>CASH</option><option value=PERIODICAL>PERIODICAL</option>   
				</tr>			
       	<tr>
			 		<td>Total Sewa Gudang (Rp)</td>     
					<td> : <input type=text name=overtime size=20 value='$formattotal' readonly=true> * $lama hari</td>		
					<td></td>
		 		<td>Tgl Kedatangan</td>     
					<td> : <input type=text size=20 value=".ymd2dmy($r[tgldatang])." readonly=true> *</td>		

				</tr>
       	<tr>
					<td>Disc. (% | Rp)</td>     
					<td> : <input type=text size=5 onchange='javascript:hitungtotal(this.value)' name=diskon id=diskon> 
								<input type=text size=20 name=afterdiskon id=afterdiskon readonly=true></td>					
					<td></td>		 	
					<td colspan=2 rowspan=3>Keterangan Diskon :<BR><textarea name=keterangan cols=40 onChange=\"javascript:this.value=this.value.toUpperCase();\"></textarea></td>
				</tr>
       	<tr>
					<td>PPn (% | Rp)</td>     
					<td> : <input type=text name=lain id=lain size=5 value=$datappn readonly=true> 
					<input type=text size=20 name=afterppn id=afterlain value=$formatppn readonly=true> *</td>					
					<td></td>
				</tr>
       	<tr>
					<td>BIAYA TOTAL (Rp)</td>    
					<td> : <input type=text size=30 value=$formattotal2 readonly=true name=bt id=bt> *</td>
					<td></td>
				</tr>																
				
  		<input type=hidden name=hari value='$lama'>	
			<input type=hidden name=pp id=pp value='$datappn'>					
  		<input type=hidden name=storage1 value =$beratkalitarif>
			<input type=hidden name=overtime1 id=overtime1 value =$total>	
			<input type=hidden name=document1 id=document1 value =$dokumen>									
			<input type=hidden name=ppn1 id=ppn1 value =$ppn>
			<input type=hidden name=id_breakdown value='$r[id_breakdown]'> 
			  
			<input type=hidden name=nosmubtb value='$_GET[n]'>
			<input type=hidden name=bt0 id=bt0 value='$total2'>			
			<input type=hidden name=id value='$_GET[d]'>		   						
	    
			<tr><td colspan=5><input type=submit value='Simpan dan Cetak'>
        <input type=button value=Batal onclick=self.history.back()> <strong>*) tidak perlu diisi (otomatis)</strong></td></tr>
        </table>
        </form>";
}
}


elseif (($_GET[module]=='cetakdb')AND ($_SESSION[level]=='kasir')){
$tgl=date("Y-m-d");
$tampil=mysql_query("select * from deliverybill where id_deliverybill='$_GET[n]'");
$r=mysql_fetch_array($tampil);
if($r[status]=='0')
{
if($r[id_deliverybill]<10){$nodb='I000000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10 AND $r[id_deliverybill]<100){$nodb='I00000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100 AND $r[id_deliverybill]<1000){$nodb='I0000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000 AND $r[id_deliverybill]<10000){$nodb='I000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10000 AND $r[id_deliverybill]<100000){$nodb='I00'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100000 AND $r[id_deliverybill]<1000000){$nodb='I0'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000000 AND $r[id_deliverybill]<10000000){$nodb='I'.$r[id_deliverybill];}
}
else if($r[status]=='1')
{if($r[id_deliverybill]<10){$nodb='O000000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10 AND $r[id_deliverybill]<100){$nodb='O00000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100 AND $r[id_deliverybill]<1000){$nodb='O0000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000 AND $r[id_deliverybill]<10000){$nodb='O000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10000 AND $r[id_deliverybill]<100000){$nodb='O00'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100000 AND $r[id_deliverybill]<1000000){$nodb='O0'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000000 AND $r[id_deliverybill]<10000000){$nodb='O'.$r[id_deliverybill];}
}
echo "<p><a href=aksi.php?module=cetakdb&n=$r[id_deliverybill] target=_blank alt='klik untuk melihat preview kuitansi sebelum di cetak' title='klik untuk melihat preview kuitansi sebelum di cetak'>Cetak Deliver Bill #$nodb</a></p>";
}

elseif (($_GET[module]=='nosmuedit')AND($_SESSION[level]=='kasir')){
$tampil=mysql_query("select * from out_dtbarang_h where id='$_GET[n]'");
$r=mysql_fetch_array($tampil);
    echo "<h2>Edit SMU No. BTB : $r[btb_nobtb]</h2>
       <form name=form1 method=POST action=aksi.php?module=editnosmu>
        <table>
        <tr>
					<td>No. SMU</td>     
					<td> : <input type=text size=30 name=nosmu value='$r[btb_smu]'> *		
				</tr>
	    <tr><td colspan=2>*) tidak boleh duplikasi no smu
	    <tr><td colspan=2><input type=submit value=UPDATE><input type=hidden name=no value='$r[id]'><input type=hidden name=nobtb value='$r[btb_nobtb]'>
			
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";
}		

//Form histori DBO
elseif (($_GET[module]=='dboutgoing')AND ($_SESSION[level]=='kasir')){
$tgl=date("Y-m-d");
  $p      = new Paging;
  $batas  = 10;
  $posisi = $p->cariPosisi($batas);

  
  $no     = $posisi+1;

if($_POST[carii]=='1')
{
$tampil=mysql_query("SELECT * FROM deliverybill,out_dtbarang_h where deliverybill.no_smubtb=out_dtbarang_h.btb_nobtb AND deliverybill.isVoid='0' AND (deliverybill.no_smubtb like '%$_POST[cari]%' OR deliverybill.nosmu like '%$_POST[cari]%')ORDER BY deliverybill.id_deliverybill DESC limit $posisi,$batas");

$tampil1=mysql_query("SELECT * FROM deliverybill,out_dtbarang_h where deliverybill.no_smubtb=out_dtbarang_h.btb_nobtb AND deliverybill.isVoid='0' AND (deliverybill.no_smubtb like '%$_POST[cari]%' OR deliverybill.nosmu like '%$_POST[cari]%')ORDER BY deliverybill.id_deliverybill DESC");

}
else
{
$tampil=mysql_query("SELECT * FROM deliverybill,out_dtbarang_h where deliverybill.no_smubtb=out_dtbarang_h.btb_nobtb AND deliverybill.isVoid='0' ORDER BY id_deliverybill DESC limit $posisi,$batas");
$tampil1=mysql_query("SELECT * FROM deliverybill,out_dtbarang_h where deliverybill.no_smubtb=out_dtbarang_h.btb_nobtb AND deliverybill.isVoid='0' ORDER BY id_deliverybill DESC");
$t="SELECT * FROM deliverybill,out_dtbarang_h where deliverybill.no_smubtb=out_dtbarang_h.btb_nobtb AND tglbayar =  '$tgl' AND id_carabayar='1' AND deliverybill.isVoid='0' ORDER BY id_deliverybill DESC";
}
//<a href=aksi.php?module=cetaklap&i=1 target=_blank><img src=images/printer.jpg border=0></a>
    echo "<h2>History Delivery Bill OUTGOING</h2>
  

       <form name=form1 method=POST action=?module=dboutgoing>
        <table>
        <tr><td>Cari No.BTB/No.SMU</td>     <td> : <input type=text size=30 name=cari>		
		<input type=hidden name=carii value=1>
	    <tr><td colspan=2><input type=submit value=CARI DATA>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";
/*		
echo "<table>        
<tr><th>no</th><th>Tgl</th><th>No. BTB</th><th>No. SMU</th><th>Berat</th><th>Hari</th><th>Sewa</th><th>Diskon</th><th>PPn</th><th>TOTAL</th><th>Agent</th><th>Cara Bayar</th><th>No. DB</th><th>Cetak</th></tr>";
*/
echo "<table>        
<tr><th>no</th><th>Tgl</th><th>No. BTB</th><th>No. SMU</th><th>TOTAL BAYAR</th><th>Agent</th><th>Cara Bayar</th><th>No. DB</th><th>Action</th></tr>";


  while ($r=mysql_fetch_array($tampil)){
$total=$r[document]+$r[overtime]+$r[lain];
$tgl=ymd2dmy($r[tglbayar]);
//if($r[id_carabayar]=='1'){$stb='CASH';}else{$stb='PERIODICAL';}
$formatdiskon=number_format($r[diskon], 0, '.', '.');   
$formatdokumen=number_format($r[document], 0, '.', '.');   
$formatstorage=number_format($r[storage], 0, '.', '.');   
$formatlain=number_format($r[lain], 0, '.', '.');   
$formattotal=number_format($total, 0, '.', '.');   
if($r[id_deliverybill]<10){$nodb='O000000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10 AND $r[id_deliverybill]<100){$nodb='O00000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100 AND $r[id_deliverybill]<1000){$nodb='O0000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000 AND $r[id_deliverybill]<10000){$nodb='O000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10000 AND $r[id_deliverybill]<100000){$nodb='O00'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100000 AND $r[id_deliverybill]<1000000){$nodb='O0'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000000 AND $r[id_deliverybill]<10000000){$nodb='O'.$r[id_deliverybill];}
/*     echo "<tr><td>$no</td><td>$tgl</td>
          <td>$r[no_smubtb]</td><td>$r[no_smu]</td><td>$r[btb_totalberatbayar] Kg</td><td>$r[hari]</td><td>Rp.$formatstorage</td><td>Rp.$formatdiskon</td><td>Rp. $formatlain</td><td>Rp. $formattotal</td><td>$r[btb_agent]</td><td>$r[id_carabayar]</td><td>$nodb</td>
					*/
					
echo "<tr><td>$no</td><td>$tgl</td>
          <td>$r[no_smubtb]</td><td>$r[btb_smu]</td><td>Rp. $formattotal</td><td>$r[btb_agent]</td><td>$r[id_carabayar]</td><td>$nodb</td>					
					<td><a href=?module=cetakdb&n=$r[id_deliverybill] alt='klik untuk mencetak ulang kuitansi pembayaran' title='klik untuk mencetak ulang kuitansi pembayaran'>Cetak</a> | ";
					if($r[status_keluar]=='INSTORE')
					{
					echo "<a href=?module=nosmuedit&n=$r[id] alt='klik untuk melakukan editing No.SMU' title='klik untuk melakukan editing No.SMU'>Edit SMU</a> | <a href=?module=voiddb&n=$nodb&i=$r[no_smubtb]&s=1 onclick=\"javascript:return confirm('VOID hanya dapat dilakukan bila barang sudah terbayar tapi belum keluar gudang. Proses VOID ini akan direkam beserta alasan VOID. Apakah Anda yakin akan VOID barang ini ?')\">VOID</a></td></tr>";
					}
					else {echo " Edit SMU | VOID"; }
     $no++;
  }
  echo "</table>";
  $jmldata      = mysql_num_rows($tampil1);
  $jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
  $linkHalaman  = $p->navHalaman($_GET[h], $jmlhalaman,'0');

  echo "<p>$linkHalaman</p>";
  
 
 
}

//Form data  DBI
elseif (($_GET[module]=='dbincoming')AND ($_SESSION[level]=='kasir')){
$tgl=date("Y-m-d");
  $p      = new Paging;
  $batas  = 10;
  $posisi = $p->cariPosisi($batas);

  
  $no     = $posisi+1;

if($_POST[carii]=='1')
{
$tampil=mysql_query("SELECT * FROM deliverybill,breakdown where 
deliverybill.idbreakdown=breakdown.id_breakdown AND deliverybill.isVoid='0' 
AND deliverybill.nosmu like '%$_POST[cari]%' ORDER BY id_deliverybill DESC limit $posisi,$batas");
$tampill=mysql_query("SELECT * FROM deliverybill,breakdown where 
deliverybill.idbreakdown=breakdown.id_breakdown AND deliverybill.isVoid='0' 
AND deliverybill.nosmu like '%$_POST[cari]%' ORDER BY id_deliverybill DESC");
}
else
{
$tampil=mysql_query("SELECT * FROM deliverybill,breakdown where 
deliverybill.idbreakdown=breakdown.id_breakdown AND deliverybill.isvoid='0' ORDER BY id_deliverybill DESC limit $posisi,$batas");
$tampill=mysql_query("SELECT * FROM deliverybill,breakdown where 
deliverybill.idbreakdown=breakdown.id_breakdown AND deliverybill.isvoid='0'");
}

/*


*/

// <a href=aksi.php?module=cetaklap&i=2 target=_blank><img src=images/printer.jpg border=0></a>
    echo "<h2>History Delivery Bill INCOMING</h2>
        <form name=form1 method=POST action=?module=dbincoming>
        <table>
        <tr><td>Cari</td>     <td> : <input type=text size=30 name=cari>		
		<input type=hidden name=carii value=1>
	    <tr><td colspan=2><input type=submit value=CARI DATA>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";
		
/*echo "<table>        
<tr><th>no</th><th>No. SMU</th><th>Berat</th><th>Hari</th><th>Sewa</th><th>Diskon</th><th>PPn</th><th>TOTAL</th><th>Agent</th><th>Cara Bayar</th><th>No. DB</th><th>Cetak</th></tr>";
*/
echo "<table>        
<tr><th>no</th><th>Tgl</th><th>No. SMU</th><th>TOTAL BAYAR</th><th>Cara Bayar</th><th>No. DB</th><th>Cetak</th></tr>";



  while ($r=mysql_fetch_array($tampil)){
$total=$r[document]+$r[overtime]+$r[lain];
$tgl=ymd2dmy($r[tglbayar]);
$formattotal=number_format($total, 0, '.', '.');   
if($r[id_deliverybill]<10){$nodb='I000000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10 AND $r[id_deliverybill]<100){$nodb='I00000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100 AND $r[id_deliverybill]<1000){$nodb='I0000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000 AND $r[id_deliverybill]<10000){$nodb='I000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10000 AND $r[id_deliverybill]<100000){$nodb='I00'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100000 AND $r[id_deliverybill]<1000000){$nodb='I0'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000000 AND $r[id_deliverybill]<10000000){$nodb='I'.$r[id_deliverybill];}
/*     echo "<tr><td>$no</td>
          <td>$r[no_smubtb]</td><td>$r[totalberat] Kg</td><td>$r[hari]</td><td>Rp.$formatstorage</td><td>Rp.$formatdiskon</td><td>Rp. $formatlain</td><td>Rp. $formattotal</td><td>$r[agent]</td><td>$r[id_carabayar]</td><td>$nodb</td>
*/
     echo "<tr><td>$no</td><td>$tgl</td>
          <td>$r[no_smubtb]</td><td>Rp. $formattotal</td><td>$r[id_carabayar]</td><td>$nodb</td>

					<td><a href=?module=cetakdb&n=$r[id_deliverybill] alt='klik untuk mencetak ulang kuitansi pembayaran' title='klik untuk mencetak ulang kuitansi pembayaran'>Cetak</a> | ";
					if($r[status_ambil]=='INSTORE')
					{
					echo "<a href=\"?module=voiddb&n=$nodb&i=$r[no_smubtb]&s=0&b=$r[idbreakdown] 
					\" onclick=\"javascript:return confirm('VOID hanya dapat dilakukan bila barang sudah terbayar tapi belum keluar gudang. Proses VOID ini akan direkam beserta alasan VOID. Apakah Anda yakin akan VOID barang ini ?')\">VOID</a></td></tr>";
					}
					else {echo "VOID</td></tr>"; }


		//			<td><a href=?module=cetakdb&n=$r[id_deliverybill]  alt='klik untuk melihat preview kuitansi sebelum di cetak' title='klik untuk melihat preview kuitansi sebelum di cetak'>Cetak</a></td>
         
     $no++;
  }
  echo "</table>";
  $jmldata      = mysql_num_rows($tampill);
  $jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
  $linkHalaman  = $p->navHalaman($_GET[h], $jmlhalaman,'0');

  echo "<p>$linkHalaman</p>";
 
}




//************************END OF KASIR***************************************************

//LEVEL BTB
//Input SMU
elseif (($_GET[module]=='btb') AND ($_SESSION[level]=='btb'))
{
 $tglnya=date("d-m-Y");
  ?>
  <SCRIPT LANGUAGE="JavaScript" src="cal2.js">
  </script>
  <script language="javascript">
    addCalendar("Caritanggal","Tanggal","tglbtb","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
  </script>
  <?
  echo "<h2>BUKTI TIMBANG BARANG</h2>
       <form name=form1 method=POST action=aksi.php?module=manifestin&act=input>
       <table><tr><td>
			  <B>INPUTKAN DATA SMU</B><BR>
       <table>
       <tr>
       <td>Airline</td>     <td> :
       <select name=airline>";
           $tampil=mysql_query("SELECT * FROM airline ORDER BY airlinecode DESC");
           while($r=mysql_fetch_array($tampil))
           {
    	     echo "<option value='$r[airlinecode]' selected>$r[airlinename]</option>";
  	   }
  echo "</select></td></tr>
       <td>Agent</td>     <td> :
       <select name=agent>";
           $tampil=mysql_query("SELECT * FROM btb_agent ORDER BY btb_agent");
           while($r=mysql_fetch_array($tampil))
           {
    	     echo "<option value='$r[btb_agent]' selected>$r[btb_agent]</option>";
  	   }
  echo "</select></td></tr>
<tr><td>Tujuan</td><td> :
          <select name=tujuan>";
  	    	  $tampil=mysql_query("SELECT * FROM destination ORDER BY destination ASC");
  		  while($r=mysql_fetch_array($tampil))
                  {
   		    echo "<option value=$r[destination]>$r[destinationdesc]</option>";
						}
  	  echo "</select>
</td>	
         <tr><td>Jenis Barang</td>     <td> :
	  	<select name=jenisbarang>";
  		  $tampil=mysql_query("SELECT * FROM typebarang ORDER BY typebarang ASC");
  		  while($r=mysql_fetch_array($tampil))
                  {
										echo "<option value='$r[typebarang]'>$r[typebarang]</option>";
										}				
				echo "</td>		
<tr><td>No.SMU</td>     <td> : <input type=text onKeyDown=\"javascript:return dFilter (event.keyCode, this, '###-####-### #');\" name=nosmu size=20>														
       <tr><td>Tanggal BTB</td>     <td> : <input type=text onKeyDown=\"javascript:return dFilter (event.keyCode, this, '##-##-####');\" name=tglbtb size=20 value='$tglnya'>*";
  ?>
  <a href="javascript:showCal('Caritanggal')"><img src="images/calendar.png" border="0"></a>
  <?
  echo "<input type=hidden name=nosmubtb value='$_GET[n]'><input type=hidden name=id value='$_GET[d]'></td></tr>
	<tr><td colspan=2> *) Wajib Diisi</td></tr>
  
	<tr><td colspan=2><input type=submit value='Simpan dan Breakdown'>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table><span class=error>$err</span>
        </td><td>";

  $p      = new Paging;
  $batas  = 5;
  $posisi = $p->cariPosisi($batas);

  $no     = $posisi+1;
  $tampil2=mysql_query("SELECT * FROM out_dtbarang_h where isvoid='0' ORDER BY id DESC limit $posisi,$batas");
 	$tampil3=mysql_query("SELECT * FROM out_dtbarang_h where isvoid='0' ORDER BY id DESC");
echo "<CENTER><b>== HISTORI BTB ==</b></CENTER> 
		<table>
    <th width=70>No.BTB</th><th width=70>Tgl</th><th width=70>Tujuan</th><th width=70>Berat Bayar</th><th width=70>Status</th><th width=130>ACTION</th></tr>";
 		while ($r=mysql_fetch_array($tampil2)){
     echo "<tr>
          <td align=center>$r[btb_nobtb]</td><td align=center>".ymd2dmy($r[btb_date])."</td><td align=center>$r[btb_tujuan]</td><td align=center>$r[btb_totalberatbayar]</td>
					<td align=center>$r[status_keluar]</td><td align=center> ";
					if($r[status_bayar]=='yes')
					{ 
					echo "<img src=images/b_drop.png hspace=5> <img src=images/b_edit.png hspace=5> 
					 ";
					}
					else{ 
					echo "<a href=aksi.php?module=btb&act=hapus&i=$r[id] title='klik untuk menghapus data' onclick=\"javascript:return confirm('Apakah Anda yakin data BTB ini akan VOID ?')\"><img src=images/b_drop.png border=0 hspace=5></a>  <a href=?module=editbtb&i=$r[id] title='klik untuk memperbaiki data SMU BTB'><img src=images/b_edit.png border=0 hspace=5></a>";}
					echo "<a href=?module=btb&act=detil&i=$r[id] title='klik untuk lihat detil BTB'><img src=images/b_view.png border=0 hspace=5></a> <a href=?module=barangdatang&i=$r[id_manifestin] title='klik untuk lihat barang'><img src=images/b_print.png border=0 hspace=5></a> 
					</td></tr>";
     $no++;
  }
  echo "</table>";
 ;

	$jmldata      = mysql_num_rows($tampil3);
  $jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
  $linkHalaman  = $p->navHalaman($_GET[h], $jmlhalaman,'');


	echo "<p align=right>$linkHalaman</p></td></tr>
	</table></form>
	
				</td></tr>
        
				</form>";

}


//Edit SMU
elseif (($_GET[module]=='editbtb') AND ($_SESSION[level]=='btb'))
{
 $tglnya=date("d-m-Y");
  ?>
  <SCRIPT LANGUAGE="JavaScript" src="cal2.js">
  </script>
  <script language="javascript">
    addCalendar("Caritanggal","Tanggal","tglbtb","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
  </script>
  <?
	
			$tampil=mysql_query("SELECT * FROM out_dtbarang_h,out_dtbarang where out_dtbarang_h.isvoid='0' AND out_dtbarang_h.id='$_GET[i]' 
			AND out_dtbarang_h.id=out_dtbarang.id_h");
    $r=mysql_fetch_array($tampil);
		
 	
  echo "<h2>BUKTI TIMBANG BARANG</h2>
       <form name=form1 method=POST action=aksi.php?module=btb&act=edit>
       <table><tr><td>
			  <B>EDIT DATA SMU</B><BR>
       <table>
       <tr>
       <td>Airline</td>     <td> :
       <select name=airline>";
           $tampil1=mysql_query("SELECT * FROM airline ORDER BY airlinecode DESC");
           while($p=mysql_fetch_array($tampil1))
           {
						if($p[airlinecode]==$r[airline])
							{
    	     		echo "<option value='$p[airlinecode]' selected>$p[airlinename]</option>";
							}
							else echo "<option value='$p[airlinecode]'>$p[airlinename]</option>";					
  	   }
  echo "</select></td></tr>
       <td>Agent</td>     <td> :
       <select name=agent>";
           $tampil1=mysql_query("SELECT * FROM btb_agent ORDER BY btb_agent");
           while($p=mysql_fetch_array($tampil1))
           {
					 		if($p[btb_agent]==$r[btb_agent])
							{
    	     echo "<option value='$p[btb_agent]' selected>$p[btb_agent]</option>";
					 }
					 else
							{
    	     echo "<option value='$p[btb_agent]'>$p[btb_agent]</option>";
					 }
					 
  	   }
  echo "</select></td></tr>
<tr><td>Tujuan</td><td> :
          <select name=tujuan>";
  	    	  $tampil1=mysql_query("SELECT * FROM destination ORDER BY destination ASC");
  		  while($p=mysql_fetch_array($tampil1))
                  {
							if($p[destination]==$r[btb_tujuan])
							{
   		    echo "<option value=$p[destination] selected>$p[destinationdesc]</option>";
					} else							{
   		    echo "<option value=$p[destination]>$p[destinationdesc]</option>";
					}
						}
  	  echo "</select>
</td>	
         <tr><td>Jenis Barang</td>     <td> :
	  	<select name=jenisbarang>";
  		  $tampil1=mysql_query("SELECT * FROM typebarang ORDER BY typebarang ASC");
  		  while($p=mysql_fetch_array($tampil1))
                  {
																if($p[typebarang]==$r[dtBarang_type])
							{
									echo "<option value='$p[typebarang]' selected>$p[typebarang]</option>";
										}
										else {
									echo "<option value='$p[typebarang]'>$p[typebarang]</option>";
										}		
										}	
												
				echo "</td>		
<tr><td>No.SMU</td>     <td> : <input type=text onKeyDown=\"javascript:return dFilter (event.keyCode, this, '###-####-### #');\" name=nosmu size=20 value='$r[btb_smu]'>														
       <tr><td>Tanggal BTB</td>     <td> : <input type=text onKeyDown=\"javascript:return dFilter (event.keyCode, this, '##-##-####');\" name=tglbtb size=20 value='$tglnya'>";
  ?>
  <a href="javascript:showCal('Caritanggal')"><img src="images/calendar.png" border="0"></a>
  <?
  echo "<input type=hidden name=id value='$_GET[i]'></td></tr>
  
	<tr><td colspan=2><input type=submit value='UPDATE'>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table><span class=error>$err</span>
        </td></table></form>";


}


//

//


//LEVEL INCOMING
//HOME of Incoming
//Input Header Manifest
elseif (($_GET[module]=='manifestin') AND ($_SESSION[level]=='incoming'))
{
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
  echo "<h2>CARGO MANIFEST INCOMING</h2>
       <form name=form1 method=POST action=aksi.php?module=manifestin&act=input>
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
       <tr><td>A/C Registration</td>     <td> : <input type=text size=10 name=acregistration autocomplete=off onChange=\"javascript:this.value=this.value.toUpperCase();\"> *
       <tr><td>Flight No</td>     <td> : <input type=text size=10 name=noflight autocomplete=off onChange=\"javascript:this.value=this.value.toUpperCase();\"> *
       <tr><td>Tanggal Manifest</td>     <td> : <input type=text onKeyDown=\"javascript:return dFilter (event.keyCode, this, '##-##-####');\" name=tglmanifest size=20 value='$tglnya'>*";
  ?>
  <a href="javascript:showCal('Caritanggal')"><img src="images/calendar.png" border="0"></a>
  <?
  echo "<input type=hidden name=nosmubtb value='$_GET[n]'><input type=hidden name=id value='$_GET[d]'></td></tr>
	<tr><td colspan=2> *) Wajib Diisi</td></tr>
  
	<tr><td colspan=2><input type=submit value='Simpan dan Breakdown'>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table><span class=error>$err</span>
        </td><td>";

  $p      = new Paging;
  $batas  = 5;
  $posisi = $p->cariPosisi($batas);

  $no     = $posisi+1;
  $tampil2=mysql_query("SELECT * FROM manifestin where isvoid='0' ORDER BY id_manifestin DESC limit $posisi,$batas");
 	$tampil3=mysql_query("SELECT * FROM manifestin where isvoid='0' ORDER BY id_manifestin DESC ");
echo "<CENTER><b>== HISTORI MANIFEST INCOMING ==</b></CENTER> 
		<table>
    <th width=70>Flight No</th><th width=70>A/C Reg</th><th width=70>Date</th><th width=70>Status</th><th width=130>ACTION</th></tr>";
 		while ($r=mysql_fetch_array($tampil2)){
     echo "<tr>
          <td align=center>$r[noflight]</td><td align=center>$r[acregistration]</td><td align=center>".ymd2dmy($r[tglmanifest])."</td><td align=center>$r[status]</td><td align=center> ";
					if($r[status]=='checked')
					{ 
					echo "<img src=images/b_drop.png hspace=5> <img src=images/b_edit.png hspace=5> 
					<img src=images/b_usrcheck.png hspace=5> ";
					}
					else{ 
					echo "<a href=aksi.php?module=manifestin&act=hapus&i=$r[id_manifestin] title='klik untuk menghapus data' onclick=\"javascript:return confirm('Penghapusan data diperbolehkan dan tidak akan direkam karena data manifest ini belum CHECKED. Semua data breakdown yang merujuk ke manifest ini akan ikut terhapus. Apakah Anda yakin data manifest ini akan dihapus ?')\"><img src=images/b_drop.png border=0 hspace=5></a>  <a href=?module=editmanifestin&i=$r[id_manifestin] title='klik untuk memperbaiki data manifest incoming'><img src=images/b_edit.png border=0 hspace=5></a> <a href=aksi.php?module=manifestin&act=checked&i=$r[id_manifestin] title='klik untuk confirm barang datang' onclick=\"javascript:return confirm('Status CHECKED berarti melakukan konfirmasi bahwa cargo untuk MANIFEST INPUT ini telah tiba dan dicek sesuai SMU. Manifest tidak dapat dihapus atau diedit setelah CHECKED. Apakah Anda yakin ? ')\"><img src=images/b_usrcheck.png border=0 hspace=5></a>  ";}
					echo "<a href=?module=barangdatang&i=$r[id_manifestin] title='klik untuk lihat barang'><img src=images/b_view.png border=0 hspace=5></a> 
					</td></tr>";
     $no++;
  }
  echo "</table>";
 ;

	$jmldata      = mysql_num_rows($tampil3);
  $jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
  $linkHalaman  = $p->navHalaman($_GET[h], $jmlhalaman,'');


	echo "<p align=right>$linkHalaman</p>";
	echo "<BR><BR>Status <B>\"waiting\"</B> berarti secara fisik <B>barang belum ada di gudang</B>.</td></tr>
	</table></form>
	
				</td></tr>
        
				</form>";

}


//Edit Header Manifest
elseif ($_GET[module]=='editmanifestin')
{
	if($_GET['p']=='e')
  	{
    	$err='Data Manifest Sudah Ada';
		}

  ?>
  <SCRIPT LANGUAGE="JavaScript" src="cal2.js">
  </script>
  <script language="javascript">
    addCalendar("Caritanggal","Tanggal","tglmanifest","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
  </script>
  <?
		$tampil=mysql_query("SELECT * FROM manifestin where isvoid='0' AND id_manifestin='$_GET[i]' ");
    $r=mysql_fetch_array($tampil);
		
		

  echo "<h2>CARGO MANIFEST INCOMING - EDITING</h2>
       <form name=form1 method=POST action=aksi.php?module=manifestin&act=edit>
       <table><tr><td>
			  <B>EDIT DATA HEADER MANIFEST</B><BR>
       <table>
       <tr>
       <td>Airline</td>     <td> :
       <select name=airline>";
           $tampil1=mysql_query("SELECT * FROM airline ORDER BY airlinecode");
  				 while($p=mysql_fetch_array($tampil1))
           	{
							if($p[airlinecode]==$r[airline])
							{
    	     		echo "<option value='$p[airlinecode]' selected>$p[airlinename]</option>";
							}
							else echo "<option value='$p[airlinecode]'>$p[airlinename]</option>";
							
  	   			}
  echo "</select></td></tr>
       <tr><td>A/C Registration</td>     <td> : <input type=text size=30 name=acregistration value='$r[acregistration]' onChange=\"javascript:this.value=this.value.toUpperCase();\">
       <tr><td>Flight No</td>     <td> : <input type=text size=30 name=noflight value='$r[noflight]' onChange=\"javascript:this.value=this.value.toUpperCase();\">
       <tr><td>Tanggal Manifest</td>     <td> : <input type=text onKeyDown=\"javascript:return dFilter (event.keyCode, this, '##-##-####');\" name=tglmanifest size=20 value=".ymd2dmy($r[tglmanifest])." readonly>";
  ?>
  <a href="javascript:showCal('Caritanggal')"><img src="images/calendar.png" border="0"></a>
  <?
  echo "<input type=hidden name=i value='$_GET[i]'></td></tr>
<td colspan=2><strong><center>*) wajib diisi, jika kosong maka data tidak akan tersimpan.
</strong></center></td></tr>	
	<tr><td colspan=2><input type=submit value='UPDATE'>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>";
}				

//Input data isi manifest
elseif (($_GET[module]=='manifestininput')AND ($_SESSION[level]=='incoming')){
?>
<SCRIPT LANGUAGE="JavaScript">
 agree= 0;
</script>

 <SCRIPT language=Javascript>
//Convert array into object
function oc(a)
{
var o = {};
for(var i=0;i<a.length;i++)
{
o[a[i]]='';
}
return o;
}

//Allow only numeric input, decimal point, backspace
function isNumberKey(evt)
{
var myValidChars = new Array(0,8,46,48,49,50,51,52,53,54,55,56,57,190);
var charCode = (evt.which) ? evt.which : event.keyCode
if (charCode in oc(myValidChars))
return true;
return false;
}
   </SCRIPT>

<?
$tglnya=date("d-m-Y");
if($i=='')
{
	$tampil=mysql_query("SELECT * FROM manifestin order by id_manifestin DESC limit 1 ");
	$r=mysql_fetch_array($tampil);
	$idmanifestin=$r[id_manifestin];
}
else
{
	$idmanifestin=$_GET[idman];
}
if($_GET[a]>0)
{
$tmp=mysql_query("select no_smu,jenisbarang,agent,asal,tujuan,id_isimanifestin from isimanifestin where isimanifestin.no_smu='$_GET[n]'");
$tp=mysql_fetch_array($tmp);	
$idisiman=$tp[id_isimanifestin]; 
}
$tglman=$r[tglmanifest];
$tgl2=ymd2dmy($r[tglmanifest]);
$dbr=mysql_query("SELECT SUM(totalberat),SUM(totalkoli) FROM isimanifestin where id_manifestin='$idmanifestin' and isvoid='0' ORDER BY id_manifestin");
$databerat=mysql_fetch_array($dbr);

	     	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM isimanifestin where id_manifestin='$idmanifestin' and isvoid='0' ORDER BY id_manifestin"));

echo "<h2>Flight No.$r[noflight] A/C Reg.$r[acregistration] Tgl.$tgl2</h2>

        <form name=form1 method=POST action='aksi.php?module=isimanifestin&act=input'>
<table><tr><td>
       	<table>
       	  <tr><td>No.SMU</td><td> : 
					<input type=text onKeyDown=\"javascript:return dFilter 
					(event.keyCode, this, '###-#### ### #');\" size=20 
					name=nosmu autocomplete=off onChange=\"javascript:this.value=this.value.toUpperCase();\" value='$_GET[n]'>
					<input type=submit value=Cek name=tombolcek>
					</td></tr>
          <tr><td>Jenis Barang</td>     <td> :
	  	<select name=jenisbarang>";
  		  $tampil=mysql_query("SELECT * FROM typebarang ORDER BY typebarang ASC");
  		  while($r=mysql_fetch_array($tampil))
                  {
                    if($r[typebarang]==$tp[jenisbarang])
										{
										echo "<option value='$r[typebarang]' selected>$r[typebarang]</option>";
										}
										else
										{
										echo "<option value='$r[typebarang]'>$r[typebarang]</option>";
										}										
										
  		  }
  	  echo "</select>
          </td></tr>
       	  <tr><td>Agent</td><td> :
          <select name=agent>";
					if($tp[agent]=='POST')
					{
						echo "<option value=''>-</option>
						<option value='POST' selected>POST</option>
						<option value='GMFAA'>GMFAA</option>
						<option value='ACS'>ACS</option>"; 		
					}
					elseif($tp[agent]=='GMFAA')
					{
						echo "<option value=''>-</option>
						<option value='POST'>POST</option>
						<option value='GMFAA' selected>GMFAA</option>
						<option value='ACS'>ACS</option>"; 		
					}
					elseif($tp[agent]=='ACS')
					{
						echo "<option value=''>-</option>
						<option value='POST'>POST</option>
						<option value='GMFAA'>GMFAA</option>
						<option value='ACS' selected>ACS</option>"; 		
					}					
					else
					{
						echo "<option value='' selected>-</option>
						<option value='POST'>POST</option>
						<option value='GMFAA'>GMFAA</option>
						<option value='ACS'>ACS</option>"; 		
					}					
		  echo "</select> 
       	  <tr><td>Total Koli</td>     <td> : <input type=text size=10 name=totalkoli autocomplete=off onkeypress=\"return isNumberKey(event)\" value='$_GET[k]'></td></tr>
    	  <tr><td>Total Berat</td><td> : <input type=text name=totalkg size=10 autocomplete=off onkeypress=\"return isNumberKey(event)\" value='$_GET[b]'></td></tr>
       	  <tr><td>Asal Airport</td><td> :
          <select name=asal>";
  	    	  $tampil=mysql_query("SELECT * FROM destination ORDER BY destination ASC");
  		  while($r=mysql_fetch_array($tampil))
                  {
                    if($r[destination]==$tp[asal])
										{
    		    echo "<option value=$r[destination] selected>$r[destinationdesc]</option>";
						}
							else									{
    		    echo "<option value=$r[destination]>$r[destinationdesc]</option>";
						}
  		  }
  	  echo "</select>
          <tr><td>Status</td><td>";
		  if(($tp[tujuan]=='DPS') OR ($tp[tujuan]==''))
		  {
          echo("<input type=radio name=transit value='DPS' onClick=\"agree=0; document.form1.tujuan.focus();\" checked>DPS
				<input type=radio name=transit value='TRANSIT' onClick=\"agree=1; document.form1.tujuan.focus();\">Transit to :");
		  }
		  else
		  {
          echo("<input type=radio name=transit value='DPS' onClick=\"agree=0; document.form1.tujuan.focus();\">DPS
				<input type=radio name=transit value='TRANSIT' onClick=\"agree=1; document.form1.tujuan.focus();\" checked>Transit to :");
		  }
					echo "<select name=tujuan onFocus=\"if (!agree)this.blur();\" onChange=\"if (!agree)this.value='';\">
	<option value='DPS' selected>--Pilih Tujuan--</option>";
  		$tampil=mysql_query("SELECT * FROM destination ORDER BY destination ASC");
  		while($r=mysql_fetch_array($tampil))
                {
								                    if($r[destination]==$tp[tujuan])
										{
    		  echo "<option value=$r[destination] selected>$r[destinationdesc]</option>";
					}
					else
															{
    		  echo "<option value=$r[destination]>$r[destinationdesc]</option>";
					}
  		}
  		echo "</select>
		</td></tr>
                <tr><td colspan=2><center><strong>SEMUA ISIAN WAJIB DIISI</strong></center></td></tr>
								<tr><td colspan=2>
								<input type=hidden name=k value='$_GET[k]'>
								<input type=hidden name=b value='$_GET[b]'>
								<input type=hidden name=a value='$_GET[a]'>																
								<input type=hidden name=idman value='$idmanifestin'>
								<input type=hidden name=idisiman value='$idisiman'>								
								<input type=hidden name=tglmanifest value='$tglman'>
								<input type=submit name=tombolsimpan value='Simpan dan Tambah'>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
</td>
<td><B><CENTER>== DAFTAR ISI CARGO MANIFEST ==</B><BR>
( Total isi : ".$jmldata." items - ".$databerat[0]." Kg - ".$databerat[1]." Koli)</CENTER>";

	 echo "<table><tr><th>no</th>
	 <th>No.SMU</th><th>Koli</th><th>Berat</th>
	 <th>Tujuan</th>
				 <th>Action</th>
         </tr>";
	$tgl1=my2date($tgl);
	$p      = new Paging;
	$batas  = 5;
	$posisi = $p->cariPosisi($batas);

	$tampil=mysql_query("SELECT * FROM breakdown,isimanifestin where breakdown.id_isimanifestin = isimanifestin.id_isimanifestin AND breakdown.id_manifestin='$idmanifestin' and breakdown.isvoid='0' ORDER BY id_breakdown DESC limit $posisi,$batas");

    	$no     = $posisi+1;
  	while ($r=mysql_fetch_array($tampil))
        {
        	if($r[status]=='DPS'){$tuju='DPS';}else {$tuju=$r[tujuan];}
     	   echo "<tr><td>$no</td>
          <td>$r[no_smu]</td><td align=center>$r[kolidatang]</td><td align=center>$r[beratdatang]</td><td align=center>$tuju</td><td align=center>";
					if($r[status_out]=='INSTORE'){ echo "<a href=\"aksi.php?module=isimanifestin&act=hapus&a=$r[split]&i=$r[id_isimanifestin]&d=$r[id_breakdown]\" onclick=\"javascript:return confirm('Penghapusan data diperbolehkan dan tidak akan direkam karena data manifest ini belum CHECKED. Apakah Anda yakin SMU ini akan dihapus ?')\">
					<img src=images/b_drop.png border=0 alt=\"klik untuk menghapus\" title=\"klik untuk menghapus\"></a></td></tr>";
					}
					else
					{
					echo "<img src=images/b_drop.png border=0 alt=\"klik untuk menghapus\">";
					}
     	  $no++;
  	}
        echo "</table>";

	$jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
  $linkHalaman  = $p->navHalaman($_GET[h], $jmlhalaman,'0');
	echo "<p align=right>$linkHalaman</p>";
echo "</td></tr></table>
     </form>";

}

//Edit Isi dari Manifest
elseif (($_GET[module]=='editisimanifestin')AND ($_SESSION[level]=='incoming'))
{
	if($_GET['p']=='e')
  	{
    	$err='Data SMU tersebut Sudah Ada';
		}

  ?>
  <SCRIPT LANGUAGE="JavaScript" src="cal2.js">
  </script>
  <script language="javascript">
    addCalendar("Caritanggal","Tanggal","tglmanifest","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
  </script>
  <?
		$tampil=mysql_query("SELECT * FROM isimanifestin where isvoid='0' AND id_isimanifestin='$_GET[i]' ");
    $r=mysql_fetch_array($tampil);
		
		

 echo "<h2>Edit data</h2>

        <form method=POST action='aksi.php?module=isimanifestin&act=input'>
<table><tr><td>
       	<table>
       	  <tr><td>No.SMU</td><td> : <input type=text size=30 name=nosmu value='$r[no_smu]'></td></tr>
          <tr><td>Jenis Barang</td>     <td> :
	  	<select name=jenisbarang>";
  		  $tampil1=mysql_query("SELECT * FROM typebarang ORDER BY typebarang ASC");
  		  while($p=mysql_fetch_array($tampil1))
                  {
									 if($p[typebarang]==$r[jenisbarang])
									 {
                    echo "<option value='$p[typebarang]' selected>$p[typebarang]</option>";
									} 
									else
									 {
									  echo "<option value='$p[typebarang]'>$p[typebarang]</option>";
									 }
  		  					}
  	  echo "</select>
          </td></tr>
       	  <tr><td>Total Koli</td>     <td> : <input type=text size=10 name=totalkoli value='$r[totalkoli]'></td></tr>
    	  <tr><td>Total Berat</td><td> : <input type=text name=totalkg size=10 value='$r[totalberat]'></td></tr>
       	  <tr><td>Asal Airport</td><td> :
          <select name=asal>";
  	    	  $tampil2=mysql_query("SELECT * FROM destination ORDER BY destination ASC");
  		  while($p=mysql_fetch_array($tampil2))
                  {
									if($p[destination]==$r[asal]){echo "<option value=$p[destination] selected>$p[destinationdesc]</option>";}
									else{echo "<option value=$p[destination]>$p[destinationdesc]</option>";}
									}
  	  echo "</select>
          <tr><td>Status</td><td>";
			if($r[status_transit]=='DPS'){ 
			echo("
          <input type=radio name=transit value='DPS' checked>DPS
          <input type=radio name=transit value='TRANSIT'>Transit to :");}
					else {
								echo("
          <input type=radio name=transit value='DPS'>DPS
          <input type=radio name=transit value='TRANSIT' checked>Transit to :");}

echo "
	<select name=tujuan>";
    	    	  $tampil2=mysql_query("SELECT * FROM destination ORDER BY destination ASC");
  		  while($p=mysql_fetch_array($tampil2))
                  {
									if($p[destination]==$r[tujuan]){echo "<option value=$p[destination] selected>$p[destinationdesc]</option>";}
									else{echo "<option value=$p[destination]>$p[destinationdesc]</option>";}
									}

  		echo "</select>
		</td></tr>
                <tr><td colspan=2>
								<input type=hidden name=idman value='$idmanifestin'><input type=submit value='Simpan dan Tambah'>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>";
}				



//barang datang
elseif (($_GET[module]=='barangdatang')AND ($_SESSION[level]=='incoming')){

	if($_POST[i]==''){$i=$_GET[i];} else {$i=$_POST[i];}
	$dataman=mysql_query("SELECT * from manifestin where id_manifestin='$i'"); 
	$r=mysql_fetch_array($dataman);
$tgl=ymd2dmy($r[tglmanifest]);
	
$tgl1=my2date($_POST[cari]);
  $p      = new Paging;
  $batas  = 10;
  $posisi = $p->cariPosisi($batas);


  $no     = $posisi+1;

$a=mysql_query("SELECT SUM(beratdatang),SUM(kolidatang) 
	FROM breakdown,isimanifestin where 
	breakdown.id_isimanifestin=isimanifestin.id_isimanifestin
	AND breakdown.id_manifestin='$i'  
	AND breakdown.isvoid='0'");	
$instok=mysql_fetch_array($a);	
	
if($_POST[carii]=='1')
{
$tampil=mysql_query("SELECT * FROM breakdown,isimanifestin where breakdown.id_isimanifestin = isimanifestin.id_isimanifestin AND breakdown.id_manifestin='$i' and breakdown.isvoid='0' AND isimanifestin.no_smu like '%$_POST[cari]%' ORDER BY id_breakdown DESC limit $posisi,$batas");

$tampill=mysql_query("SELECT * FROM breakdown,isimanifestin where breakdown.id_isimanifestin = isimanifestin.id_isimanifestin AND breakdown.id_manifestin='$i' and breakdown.isvoid='0' AND isimanifestin.no_smu like '%$_POST[cari]%' ORDER BY id_breakdown");
}
else
{

$tampil=mysql_query("SELECT * FROM breakdown,isimanifestin where breakdown.id_isimanifestin = isimanifestin.id_isimanifestin AND breakdown.id_manifestin='$i' and breakdown.isvoid='0' ORDER BY id_breakdown DESC limit $posisi,$batas");
$tampill=mysql_query("SELECT * FROM breakdown,isimanifestin where breakdown.id_isimanifestin = isimanifestin.id_isimanifestin AND breakdown.id_manifestin='$i' and breakdown.isvoid='0' ORDER BY id_breakdown");

}



$tglnya=date("d-m-Y");
    echo "<h2>Isi Cargo Manifest => $r[airline] : A/C Reg.$r[acregistration] Flight No.$r[noflight] / $tgl | $instok[0] Kg / $instok[1] Koli</h2>
       <form name=form1 method=POST action=?module=barangdatang>
        <table>
        <tr><td>Cari No.SMU</td>     <td> : <input type=text size=30 name=cari>
		<input type=hidden name=carii value=1><input type=hidden name=i value='$i'><input type=submit value=CARI DATA>
        <input type=button value=Batal onclick=self.history.back()>

        </table>
        </form>";

echo "<table>
        <tr><th align=center>no</th><th align=center>No. SMU</th><th align=center>BERAT AKTUAL</th><th align=center>JUMLAH KOLI </th><th align=center>BERAT DIBAYAR</th><th align=center>KOLI Datang</th><th>Tujuan</th><th>Action</th></tr>";

  while ($r=mysql_fetch_array($tampil)){
  $tglnya=ymd2dmy($r[tgl]);
     echo "<tr><td align=center>$no</td>
          <td align=center>$r[no_smu]</td><td align=center>$r[totalberat]</td>
		  <td align=center>$r[totalkoli]</td><td align=center>$r[beratdatang]</td>
		  <td align=center>$r[kolidatang]</td>
		  <td align=center>$r[tujuan]</td>";
				  if(($r[status_bayar]=='no') AND ($r[iscancel]<>'1'))
		  {
		  echo "<td align=center>
			<a href=?module=isimanifestindel&n=$r[id_isimanifestin]&b=$r[id_breakdown]&a=$r[split]&i=$i  
		  title='klik untuk cancel SMU' onclick=\"javascript:return confirm('CANCEL hanya dilakukan pada SMU yang batal datang. Jika memang cancel, Anda harus melengkapi alasannya setelah ini. CANCEL hanya bisa dilakukan pada barang yang belum terbayar. Apakah Anda yakin data SMU ini dibatalkan ?')\"><img src=images/b_drop.png border=0 hspace=5></a> <a href=?module=breakdownedit&n=$r[id_isimanifestin]&b=$r[id_breakdown]&a=$r[split]&i=$i 
							title='klik untuk update data sesuai dgn SMU datang' onclick=\"javascript:return confirm('Editing hanya dilakukan untuk SMU yang datanya tidak sesuai dengan data MANIFEST INPUT. Apakah Anda yakin akan mengedit data sesuai SMU ?')\"><img src=images/b_edit.png border=0 hspace=5></a>";
			
						  if($r[iscancel]=='1')
		  				{
		  				echo "<img src=images/b_drop.png border=0 hspace=5> <img src=images/b_edit.png border=0 hspace=5></a>";}
						//	else {echo "<img src=images/b_edit.png border=0 hspace=5></td>";}
			
			
			}
	else {echo "<td align=center><img src=images/b_drop.png border=0 hspace=5> <img src=images/b_edit.png border=0 hspace=5>  ";}
		echo" </tr>";
     $no++;
  }
  echo "</table>";
   $jmldata      = mysql_num_rows($tampill);
  $jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
  $linkHalaman  = $p->navHalaman($_GET[h], $jmlhalaman,'i='.$_GET[i]);

  echo "<p>$linkHalaman</p>";


}

//Pecah SMU
elseif (($_GET[module]=='splitsmu') AND ($_SESSION[level]=='incoming'))
{
 ?>
  <SCRIPT language=Javascript>
//Convert array into object
function oc(a)
{
var o = {};
for(var i=0;i<a.length;i++)
{
o[a[i]]='';
}
return o;
}

//Allow only numeric input, decimal point, backspace
function isNumberKey(evt)
{
var myValidChars = new Array(0,8,46,48,49,50,51,52,53,54,55,56,57,190);
var charCode = (evt.which) ? evt.which : event.keyCode
if (charCode in oc(myValidChars))
return true;
return false;
}
   </SCRIPT>
  <SCRIPT LANGUAGE="JavaScript" src="cal2.js">
  </script>
  <script language="javascript">
    addCalendar("Caritanggal","Tanggal","tgldatang","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
  </script>
  <?
 $tampil=mysql_query("select *, SUM(beratdatang) AS tberatdatang, SUM(kolidatang) AS tkolidatang from isimanifestin,breakdown where isimanifestin.id_isimanifestin=breakdown.id_isimanifestin AND isimanifestin.id_isimanifestin='$_GET[n]' GROUP BY isimanifestin.id_isimanifestin");
  $r=mysql_fetch_array($tampil);

	if($_GET['p']=='e')
  	{
    	$err='Jumlah Barang Melebihi Manifest !';
	}
  $tglnya=date("d-m-Y");
  echo "<h2>Split kedatangan SMU : $r[no_smu]</h2>
       <form name=form1 method=POST action=aksi.php?module=breakdown&act=input>
       <table><tr><td>
			  <B>UPDATE JUMLAH BARANG <u>SESUAI KEDATANGAN</u> !</B><BR>
       <table>
       <tr><td><b>Total Koli di SMU</b></td>     <td> : <input type=text size=10 name=totalkoli value='$r[totalkoli]' readonly=true> *
       <tr><td><b>Total Berat di SMU</b></td>     <td> : <input type=text size=10 name=totalberat value='$r[totalberat]' readonly=true> *
       <tr><td><b>JML BERAT DATANG</b></td>     <td> : <input type=text size=10 name=tberatdatang value='$r[tberatdatang]'
	    readonly=true> *	   
       <tr><td><b>JML KOLI DATANG</b></td>     <td> : <input type=text size=10 name=tkolidatang  value='$r[tkolidatang]'
	   readonly=true> *	   	   
       <tr><td>Tanggal Datang</td>     <td> : <input type=text name=tgldatang size=10 value='$tglnya' readonly>";
  ?>
  <a href="javascript:showCal('Caritanggal')"><img src="images/calendar.png" border="0"></a>
  <?
  $kol=$r[totalkoli]-$r[tkolidatang];
  $brt=$r[totalberat]-$r[tberatdatang];
  echo "
  <tr><td>Koli Datang</td>     <td> : <input type=text size=10 name=kolidatang value=$kol onkeypress=\"return isNumberKey(event)\">
  <tr><td>Berat Datang</td>     <td> : <input type=text size=10 name=beratdatang value=$brt onkeypress=\"return isNumberKey(event)\">
<input type=hidden name=i value='$_GET[i]'><input type=hidden name=n value='$_GET[n]'></td></tr>
	<tr><td colspan=2><strong><center>*) Readonly - Tidak perlu diisi (otomatis)</center></strong></td></tr>

	<tr><td colspan=2><input type=submit value='Simpan'>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table><span class=error>$err</span>
        </td><td>";

  $p      = new Paging;
  $batas  = 10;
  $posisi = $p->cariPosisi($batas);

  $no     = $posisi+1;
  
$tampil2=mysql_query("SELECT * FROM breakdown where isvoid='0' AND id_isimanifestin='$_GET[n]' order by tgldatang DESC limit $posisi,$batas");
$tampil3=mysql_query("SELECT * FROM breakdown where isvoid='0' AND id_isimanifestin='$_GET[n]' order by tgldatang DESC");

echo "<CENTER><b>== SPLIT SMU INCOMING ==</b></CENTER> 
		<table>
    <tr><th>no</th><th>Tgl Datang</th><th>Berat Datang</th><th>Koli Datang</th><th>Status</th><th>BAYAR</th><th>ACTION</th></tr>";
 		while ($r=mysql_fetch_array($tampil2)){
     echo "<tr><td align=center>$no</td>
          <td align=center>".ymd2dmy($r[tgldatang])."</td><td align=center>$r[beratdatang]</td><td align=center>$r[kolidatang]</td><td align=center>$r[status_ambil]</td><td align=center>$r[status_bayar]</td><td align=center> ";
					if(($r[status_ambil]=='INSTORE') AND ($r[status_bayar]=='no'))
					{ 
					echo " 
					<a href=aksi.php?module=breakdown&act=hapus&id=$r[id_breakdown]&i=$_GET[i]&n=$_GET[n] title='klik untuk menghapus' onclick=\"javascript:return confirm('Penghapusan data masih diperbolehkan dan tidak direkam, selama status barang masih INSTORE dan BELUM TERBAYAR. Anda tidak dapat menghapus data jika hanya terdapat sebuah data kedatangan per SMU. Apakah Anda yakin akan menghapus data kedatangan split SMU ini ?')\">Hapus</a> ";
					}
					else
					{echo "Hapus";}
					echo " 
					</td></tr>";
     $no++;
  }
  echo "</table>";
 ;

	$jmldata      = mysql_num_rows($tampil3);
  $jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
  $linkHalaman  = $p->navHalaman($_GET[h], $jmlhalaman,'');


	echo "$linkHalaman";
	echo "<BR><BR>Status <B>\"INSTORE\"</B> berarti barang belum ada di diambil atau belum masuk buildup</B>.</td></tr>
	</table></form>
	
				</td></tr>
        
				</form>";

}




//Edit SMU dan Brekadown
elseif (($_GET[module]=='breakdownedit')AND($_SESSION[level]=='incoming')){
?>
 
 <SCRIPT language=Javascript>
//Convert array into object
function oc(a)
{
var o = {};
for(var i=0;i<a.length;i++)
{
o[a[i]]='';
}
return o;
}

//Allow only numeric input, decimal point, backspace
function isNumberKey(evt)
{
var myValidChars = new Array(0,8,46,48,49,50,51,52,53,54,55,56,57,190);
var charCode = (evt.which) ? evt.which : event.keyCode
if (charCode in oc(myValidChars))
return true;
return false;
}
   </SCRIPT>
<?
if($_GET[a]=='0')
{
$tampil=mysql_query("select * from isimanifestin where id_isimanifestin='$_GET[n]'");
$r=mysql_fetch_array($tampil);

$kol=$r[totalkoli];
$ber=$r[totalberat];
}
else
{
$tampil=mysql_query("select * from breakdown,isimanifestin where breakdown.id_isimanifestin=isimanifestin.id_isimanifestin AND breakdown.id_breakdown='$_GET[b]'");
$r=mysql_fetch_array($tampil);

$kol=$r[kolidatang];
$ber=$r[beratdatang];
}

    echo "<h2>Edit Breakdown No. SMU : $r[no_smu]</h2>
       <form name=form1 method=POST action=aksi.php?module=isimanifestin&act=edit>
        <table>
		<tr><td>No SMU</td><td> : <input type=text name=no_smu size=20 value='$r[no_smu]' onChange=\"javascript:this.value=this.value.toUpperCase();\"></td></tr>		
          <tr><td>Jenis Barang</td>     <td> :
	  	<select name=jenisbarang>";
  		  $a=mysql_query("SELECT * FROM typebarang ORDER BY typebarang ASC");
  		  while($p=mysql_fetch_array($a))
                {
                    if($p[typebarang]==$r[jenisbarang])
					{
						echo "<option value='$p[typebarang]' selected>$p[typebarang]</option>";
					}
                    else 
					{
						echo "<option value='$p[typebarang]'>$p[typebarang]</option>";
					}
				}
  	  echo "</select>
          </td></tr>
			
    	  <tr><td>Jml  Koli (SMU)</td><td> : <input type=text name=totalkoli size=10 value=$r[totalkoli] onkeypress=\"return isNumberKey(event)\" autocomplete=off> -> Datang : <input type=text name=totalkolidatang size=10 value=$kol onkeypress=\"return isNumberKey(event)\" autocomplete=off></td></tr>
    	  <tr><td>Berat Terbayar (SMU)</td><td> : <input type=text name=totalberat size=10 value=$r[totalberat] onkeypress=\"return isNumberKey(event)\" autocomplete=off> -> Datang : <input type=text name=totalberatdatang size=10 value=$ber onkeypress=\"return isNumberKey(event)\" autocomplete=off></td></tr>
      	  <tr><td>Agent</td><td> :
          <select name=agent>";
					if($r[agent]=='POST')
					{
						echo "<option value=''>-</option>
						<option value='POST' selected>POST</option>
						<option value='GMFAA'>GMFAA</option>
						<option value='ACS'>ACS</option>"; 		
					}
					elseif($r[agent]=='GMFAA')
					{
						echo "<option value=''>-</option>
						<option value='POST'>POST</option>
						<option value='GMFAA' selected>GMFAA</option>
						<option value='ACS'>ACS</option>"; 		
					}
					elseif($r[agent]=='ACS')
					{
						echo "<option value=''>-</option>
						<option value='POST'>POST</option>
						<option value='GMFAA'>GMFAA</option>
						<option value='ACS' selected>ACS</option>"; 		
					}					
					else
					{
						echo "<option value='' selected>-</option>
						<option value='POST'>POST</option>
						<option value='GMFAA'>GMFAA</option>
						<option value='ACS'>ACS</option>"; 		
					}					
		  echo "</select> 

       	  <tr><td>Asal Airport</td><td> :
          <select name=asal>";
  	    	  $tampil=mysql_query("SELECT * FROM destination ORDER BY destination ASC");
  		  while($p=mysql_fetch_array($tampil))
                {
                    if($p[destination]==$r[asal])
					{
						echo "<option value=$p[destination] selected>$p[destinationdesc]</option>";
					}
                    else 
					{
						echo "<option value=$p[destination]>$p[destinationdesc]</option>";
					}
				}
  	  echo "</select>


          <tr><td>Status</td><td>";
		  if($r[status_transit]=='DPS')
		  {
          echo("<input type=radio name=transit value='DPS' onClick=\"agree=0; document.form1.tujuan.focus();\" checked>DPS
				<input type=radio name=transit value='TRANSIT' onClick=\"agree=1; document.form1.tujuan.focus();\">Transit to :");
		  }
		  else
		  {
          echo("<input type=radio name=transit value='DPS' onClick=\"agree=0; document.form1.tujuan.focus();\">DPS
				<input type=radio name=transit value='TRANSIT' onClick=\"agree=1; document.form1.tujuan.focus();\" checked>Transit to :");
		  }

	echo "<select name=tujuan onFocus=\"if (!agree)this.blur();\" onChange=\"if (!agree)this.value='';\">
		<option value='DPS' selected>--Pilih Tujuan--</option>";
  		$tampil=mysql_query("SELECT * FROM destination ORDER BY destination ASC");
 		  while($p=mysql_fetch_array($tampil))
                {
                    if($p[destination]==$r[tujuan])
					{
						echo "<option value=$p[destination] selected>$p[destinationdesc]</option>";
					}
                    else 
					{
						echo "<option value=$p[destination]>$p[destinationdesc]</option>";
					}
				}
  		echo "</select>
		</td></tr>
		<tr><td colspan=2><center><strong>SEMUA ISIAN WAJIB DIISI</strong></center></td></tr>
                <tr><td colspan=2><input type=submit value='UPDATE'>
        <input type=button value=Batal onclick=self.history.back()>
		<input type=hidden name=n value='$r[id_isimanifestin]'>
		<input type=hidden name=i value='$_GET[i]'>
		<input type=hidden name=a value='$_GET[a]'>
		<input type=hidden name=b value='$_GET[b]'>				
		</td></tr>
	   
        </table>
        </form>";
}

//*****HAPUS ISI MANIFEST
elseif (($_GET[module]=='isimanifestindel')AND($_SESSION[level]=='incoming')){
$tampil=mysql_query("select * from isimanifestin where id_isimanifestin='$_GET[n]'");
$r=mysql_fetch_array($tampil);
    echo "<h2>Cancel  No. SMU : $r[no_smu]</h2>
       <form name=form1 method=POST action=aksi.php?module=isimanifestin&act=cancel>
        <table>	
    	  <tr><td>Keterangan</td><td> : <input type=text name=keterangan_void size=60></td></tr>
		</td></tr>
                <tr><td colspan=2><input type=submit value='CANCEL'>
        <input type=button value=Batal onclick=self.history.back()>
		<input type=hidden name=n value='$r[id_isimanifestin]'>
		<input type=hidden name=i value='$_GET[i]'>
		<input type=hidden name=a value='$_GET[a]'>
		<input type=hidden name=b value='$_GET[b]'>		
		
		</td></tr>
	   
        </table>
        </form>";
}

//Form cetak stockopname incoming
elseif (($_GET[module]=='stockopnamein')AND($_SESSION[level]=='incoming')){
$tglnya=date("Y-m-d");
$tgl=ymd2dmy($tglnya);

  $p      = new Paging;
  $batas  = 10;
  $posisi = $p->cariPosisi($batas);
  $no     = $posisi+1;

$a=mysql_query("SELECT SUM(beratdatang),SUM(kolidatang) 
	FROM breakdown,isimanifestin,manifestin where 
	breakdown.id_isimanifestin=isimanifestin.id_isimanifestin 
	AND breakdown.isvoid='0' AND breakdown.status_ambil='INSTORE' AND isimanifestin.status_transit='DPS' 
	AND isimanifestin.id_manifestin=manifestin.id_manifestin AND manifestin.status='checked'");	
$instok=mysql_fetch_array($a);
	
	
if($_POST[carii]=='1')
{
	$tampil=mysql_query("SELECT * FROM breakdown,isimanifestin,manifestin where 
	breakdown.id_isimanifestin=isimanifestin.id_isimanifestin AND 
	isimanifestin.isvoid='0' AND isimanifestin.no_smu like '%$_POST[cari]%' AND isimanifestin.id_manifestin=manifestin.id_manifestin AND manifestin.status='checked' 
	 AND isimanifestin.status_transit='DPS'  
	order by isimanifestin.no_smu DESC limit $posisi,$batas");
	
		$tampill=mysql_query("SELECT * FROM breakdown,isimanifestin,manifestin where 
	breakdown.id_isimanifestin=isimanifestin.id_isimanifestin AND 
	isimanifestin.isvoid='0' AND isimanifestin.no_smu like '%$_POST[cari]%' AND isimanifestin.id_manifestin=manifestin.id_manifestin AND manifestin.status='checked' 
	 AND isimanifestin.status_transit='DPS' 
	order by isimanifestin.no_smu DESC");
}
else
{
	$tampil=mysql_query("SELECT * FROM breakdown,isimanifestin,manifestin where 
	breakdown.id_isimanifestin=isimanifestin.id_isimanifestin  
	AND isimanifestin.isvoid='0' AND isimanifestin.id_manifestin=manifestin.id_manifestin AND manifestin.status='checked' AND isimanifestin.status_transit='DPS'
	order by isimanifestin.no_smu DESC limit $posisi,$batas");
	$tampill=mysql_query("SELECT * FROM breakdown,isimanifestin,manifestin where 
	breakdown.id_isimanifestin=isimanifestin.id_isimanifestin  
	AND isimanifestin.isvoid='0' AND isimanifestin.id_manifestin=manifestin.id_manifestin AND manifestin.status='checked' AND isimanifestin.status_transit='DPS'
	order by isimanifestin.no_smu DESC");

}




   echo "<h2>Kondisi Gudang Incoming Per Tanggal : $tgl | $instok[0] Kg / $instok[1] Koli</h2>
				<p><a href=aksi.php?module=cetakstockopnamein target=_blank>Klik Disini untuk cetak STOCKOPNAME INCOMING Checklist</a></p>
				       <form name=form1 method=POST action=?module=stockopnamein>
        <table>
        <tr><td>Cari No.SMU</td>     <td> : <input type=text size=30 name=cari>
		<input type=hidden name=carii value=1><input type=hidden name=i value='$i'><input type=submit value=CARI DATA>
        <input type=button value=Batal onclick=self.history.back()>

        </table>
        </form>
				<table>
        <tr><th>no</th><th>No.SMU/AWB</th><th>Tgl Datang</th><th>Total Koli</th><th>Total Berat</th><th>Bayar</th><th>Action</th></tr>";
  while ($r=mysql_fetch_array($tampil)){
$tgldatang=ymd2dmy($r[tgldatang]);
$tglambil=ymd2dmy($r[tglambil]);
     echo "";


		 	echo "<tr><td>$no</td><td align='center'>$r[no_smu]</td><td align='center'>$tgldatang</td><td align='right'>$r[kolidatang]</td><td align='right' >$r[beratdatang]</td><td align='center'>$r[status_bayar]</td>";
	
		 if(($r[status_bayar]=='yes') AND ($r[status_ambil]=='INSTORE'))
		 {
		 	echo "<td><a href=aksi.php?module=keluarbarangin&i=$r[id_breakdown] onclick=\"javascript:return confirm('Barang hanya bisa dikeluarkan dari Gudang jika sudah terbayar. Apakah Anda yakin mengeluarkan barang ini dari Gudang Incoming ?')\">[Keluarkan]</a>";
		 }
		 else
		 {
		  echo "<td>";
		 }
		 
		 
		 echo "</td></tr>";
     $no++;
  }
  echo "</table>";
 	$jmldata      = mysql_num_rows($tampill);
  $jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
  $linkHalaman  = $p->navHalaman($_GET[h], $jmlhalaman,'&n='.$_GET[n]);

	echo "<p>$linkHalaman</p>";
	echo "</td></tr></table></form>";
}


//************************END OF outgoing ***************************************************


//*************************** begin of level outgoing **************************************
//LEVEL OUTGOING
//batal manifest out
elseif (($_GET[module]=='batalmo')AND($_SESSION[level]=='outgoing')){
$str=mysql_query("select * from manifestout where id_manifestout='$_GET[i]'");
$r=mysql_fetch_array($str);
$tgl2=ymd2dmy($r[tglmanifest]);
    echo "<h2>Pembatalan Manifest Out $r[airline] : A/C Reg.$r[acregistration] Flight No.$r[noflight] / $tgl2</h2>
       <form name=form1 method=POST action=aksi.php?module=batalmo>
        <table>	
    	  <tr><td>Keterangan</td><td> : <input type=text name=keterangan size=60></td></tr>
		</td></tr>
                <tr><td colspan=2><input type=submit value='CANCEL'>
        <input type=button value=BACK onclick=self.history.back()>
		<input type=hidden name=i value='$_GET[i]'>
		</td></tr>
	   
        </table>
        </form>";
}

//Input Header Manifest
elseif (($_GET[module]=='manifestout') AND ($_SESSION[level]=='outgoing'))
{
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
  echo "<h2>CARGO MANIFEST OUTGOING</h2>
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
  echo "<input type=hidden name=nosmubtb value='$_GET[n]'><input type=hidden name=id value='$_GET[d]'></td></tr>
	<tr><td colspan=2><input type=submit value='Simpan dan Buildup'>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table><span class=error>$err</span>
        </td><td>";

  $p      = new Paging;
  $batas  = 10;
  $posisi = $p->cariPosisi($batas);

  $no     = $posisi+1;
  $tampil2=mysql_query("SELECT * FROM manifestout where isvoid='0' ORDER BY id_manifestout DESC limit $posisi,$batas");
 	$tampil3=mysql_query("SELECT * FROM manifestout where isvoid='0' ORDER BY id_manifestout DESC ");
echo "<CENTER><b>== HISTORI MANIFEST outgoing ==</b></CENTER> 
		<table>
    <tr><th>no</th><th>Airline</th><th>Flight No.</th><th>A/C Registration</th><th>Date</th><th>Status</th><th>ACTION</th></tr>";
 		while ($r=mysql_fetch_array($tampil2)){
     echo "<tr><td align=center>$no</td>
          <td align=center>$r[airline]</td><td align=center>$r[noflight]</td><td align=center>$r[acregistration]</td><td align=center>".ymd2dmy($r[tglmanifest])."</td><td align=center>$r[status]</td><td align=center> ";
					if($r[status]=='checked')
					{ 
					echo "<a href=\"?module=batalmo&i=$r[id_manifestout] 
					\" onclick=\"javascript:return confirm('Pembatalan ini terjadi bila MANIFEST sudah CHECKED tetapi BATAL diberangkatkan. Pembatalan ini akan mengembalikan status manifest menjadi WAITING kembali. Proses ini akan direkam beserta alasannya. Apakah Anda ingin membatalkan manifest ini ?')\">BATAL</a> | Delete | Edit No.Manifest | CHECKED | ";
					}
					else{ 
					echo "BATAL | <a href=aksi.php?module=manifestout&act=hapus&i=$r[id_manifestout] title='klik untuk menghapus data' onclick=\"javascript:return confirm('Penghapusan data diperbolehkan dan tidak akan direkam karena data manifest ini belum CHECKED. Semua data buildup yang merujuk ke manifest ini akan ikut terhapus. Apakah Anda yakin data manifest ini akan dihapus ?')\">Delete</a> | <a href=?module=editmanifestout&i=$r[id_manifestout] title='klik untuk memperbaiki data manifest outgoing'>Edit No.Manifest</a> | <a href=aksi.php?module=manifestout&act=checked&i=$r[id_manifestout] title='klik untuk confirm barang berangkat' onclick=\"javascript:return confirm('Status CHECKED berarti melakukan konfirmasi bahwa cargo untuk MANIFEST OUT ini telah berangkat. Manifest tidak dapat dihapus atau diedit setelah CHECKED. Apakah Anda yakin ? ')\">CHECKED</a> | ";}
					echo "<a href=?module=manifestoutinput&i=$r[id_manifestout] title='klik untuk lihat barang'=&i=$r[id_manifestout] title='klik untuk lihat barang'>Lihat Isi</a> | <a href=aksi.php?module=cetakmanifestout&i=$r[id_manifestout]  target=_blank title='klik untuk cetak manifest'>CETAK</a> 
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

}


//Edit Header Manifest
elseif ($_GET[module]=='editmanifestout')
{
	if($_GET['p']=='e')
  	{
    	$err='Data Manifest Sudah Ada';
		}

  ?>
  <SCRIPT LANGUAGE="JavaScript" src="cal2.js">
  </script>
  <script language="javascript">
    addCalendar("Caritanggal","Tanggal","tglmanifest","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
  </script>
  <?
		$tampil=mysql_query("SELECT * FROM manifestout where isvoid='0' AND id_manifestout='$_GET[i]' ");
    $r=mysql_fetch_array($tampil);
		
		

  echo "<h2>CARGO MANIFEST OUTGOING - EDITING</h2>
       <form name=form1 method=POST action=aksi.php?module=manifestout&act=edit>
       <table><tr><td>
			  <B>EDIT DATA HEADER MANIFEST</B><BR>
       <table>
       <tr>
       <td>Airline</td>     <td> :
       <select name=airline>";
           $tampil1=mysql_query("SELECT * FROM airline ORDER BY airlinecode");
  				 while($p=mysql_fetch_array($tampil1))
           	{
							if($p[airlinecode]==$r[airline])
							{
    	     		echo "<option value='$p[airlinecode]' selected>$p[airlinename]</option>";
							}
							else echo "<option value='$p[airlinecode]'>$p[airlinename]</option>";
							
  	   			}
  echo "</select></td></tr>
       <tr><td>A/C Registration</td>     <td> : <input type=text size=30 name=acregistration value='$r[acregistration]' autocomplete=off  onChange=\"javascript:this.value=this.value.toUpperCase();\">*
       <tr><td>Flight No</td>     <td> : <input type=text size=30 name=noflight value='$r[noflight]' autocomplete=off  onChange=\"javascript:this.value=this.value.toUpperCase();\">*
       <tr><td>Tanggal Manifest</td>     <td> : <input type=text name=tglmanifest size=20 value=".ymd2dmy($r[tglmanifest])." readonly>*";
  ?>
  <a href="javascript:showCal('Caritanggal')"><img src="images/calendar.png" border="0"></a>
  <?
  echo "<input type=hidden name=i value='$_GET[i]'></td></tr>
	<tr><td colspan=2><input type=submit value='UPDATE'>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>";
}				

//Input data isi manifest
elseif (($_GET[module]=='manifestoutinput')AND ($_SESSION[level]=='outgoing')){
?>
  <script language="javascript">
//Convert array into object
function oc(a)
{
var o = {};
for(var i=0;i<a.length;i++)
{
o[a[i]]='';
}
return o;
}

//Allow only numeric input, decimal point, backspace
function isNumberKey(evt)
{
var myValidChars = new Array(0,8,46,48,49,50,51,52,53,54,55,56,57,190);
var charCode = (evt.which) ? evt.which : event.keyCode
if (charCode in oc(myValidChars))
return true;
return false;
}
   </SCRIPT>
<?
		
$tglnya=date("d-m-Y");
if($_GET[i]=='')
{
	$tampil=mysql_query("SELECT * FROM manifestout order by id_manifestout DESC limit 1 ");
	$r=mysql_fetch_array($tampil);
	$idmanifestout=$r[id_manifestout];
}
else
{
	$tampil=mysql_query("SELECT * FROM manifestout where id_manifestout='$_GET[i]' ");
	$r=mysql_fetch_array($tampil);
	$idmanifestout=$r[id_manifestout];
}
$c=$r[status];
$tglman=$r[tglmanifest];
$tgl2=ymd2dmy($r[tglmanifest]);
 $tampill=mysql_query("SELECT * FROM buildup where isvoid='0' AND 
 id_manifestout='$idmanifestout' ORDER BY nould DESC");
$jmldata = mysql_num_rows($tampill);
$dbr=mysql_query("SELECT SUM(berat),SUM(koli) FROM buildup where id_manifestout='$idmanifestout' and isvoid='0'");
$databerat=mysql_fetch_array($dbr);

echo "<h2>$r[airline] : A/C Reg.$r[acregistration] Flight No.$r[noflight] / $tgl2</h2>";
if($_GET[e]=='1')
{$err='Data BUILDUP melebihi Data SMU !!!';}

if($_GET[a]>=1)
{
//cari di BTB dulu
$str=mysql_query("SELECT * FROM out_dtbarang_h,out_dtbarang where out_dtbarang_h.id=out_dtbarang.id_h AND out_dtbarang_h.btb_smu='$_GET[n]' AND out_dtbarang_h.status_bayar='yes' AND out_dtbarang_h.status_keluar='INSTORE' GROUP BY out_dtbarang_h.id");
$p=mysql_fetch_array($str);
	$tkoli=mysql_query("SELECT SUM(koli) AS totkoli,SUM(berat) AS totberat 
		FROM buildup,out_dtbarang_h where out_dtbarang_h.id=buildup.id_out_dtbarang_h 
		AND buildup.nosmu='$p[1]' AND out_dtbarang_h.status_keluar='INSTORE' GROUP BY buildup.id_out_dtbarang_h");
		$tk=mysql_fetch_array($tkoli);
		$sisakoli=$p[12]-$tk[totkoli];
		$sisaberat=$p[9]-$tk[totberat];
		$tipe=$p[32];
		$asal='DPS';
		$tujuan=$p[btb_tujuan];
		$transit='DPS';
		$totalberat=$p[9];
		$totalkoli=$p[12];	
		$beratbuildup=$tk[totberat];
		$kolibuildup=$tk[totkoli];
		$iddt=$p[0];

	}
	else
	{
	
		//kalau tdk ada di BTB baru cek di incoming
		$str=mysql_query("SELECT * FROM isimanifestin,manifestin where isimanifestin.no_smu='$_GET[n]' 
		AND manifestin.status='checked' AND isimanifestin.isvoid='0' AND isimanifestin.status_transit='TRANSIT'  
		AND isimanifestin.status_out='INSTORE'");
		$pr=mysql_fetch_array($str);

		$breakdata=mysql_query("SELECT *,SUM(kolidatang) AS bkolidatang,
		SUM(beratdatang) AS bberatdatang FROM breakdown,isimanifestin where 
		breakdown.id_isimanifestin=isimanifestin.id_isimanifestin AND isimanifestin.status_transit='TRANSIT'  
		AND isimanifestin.no_smu='$_GET[n]' GROUP BY breakdown.id_isimanifestin");
		$p=mysql_fetch_array($breakdata);
		
		$tkoli=mysql_query("SELECT SUM(koli) AS totkoli,SUM(berat) AS totberat FROM buildup,isimanifestin where 
		buildup.nosmu=isimanifestin.no_smu AND buildup.nosmu='$p[13]' GROUP BY buildup.nosmu");

		$tk=mysql_fetch_array($tkoli);
		$sisakoli=$p[bkolidatang]-$tk[totkoli];
		$sisaberat=$p[bberatdatang]-$tk[totberat];
		$tipe=$p[jenisbarang];
		$asal=$p[asal];
		$tujuan=$p[tujuan];
		$transit='TRANSIT';
		$totalberat=$p[bberatdatang];
		$totalkoli=$p[bkolidatang];	
		$beratbuildup=$tk[totberat];
		$kolibuildup=$tk[totkoli];
		$iddt=$p[0];
	}


echo "<form name=form1 method=POST action='aksi.php?module=isimanifestout&act=input'>
<table><tr><td>
       	<table><tr><td>No.SMU</td><td> : <input name=nosmu size=20 value='$_GET[n]' autocomplete=off>
				<input type=submit value=CHECK name=tombolcek>
</td></tr><tr><td><B>Asal Airport</B></td><td> : <input type=text name=asal id=txtasal size=20  value='$asal' readonly=true></td</tr>
          <tr><td><B>Tujuan</B></td><td> : <input type=text name=tujuan size=20  value='$tujuan' readonly=true></td></tr>					
          <tr><td><B>Jenis Barang</B></td>     <td> : <input type=text size=30 name=jenisbarang  value='$tipe' readonly=true></td></tr>
       	  <tr><td><B>Koli/Berat (SMU)</B></td>     <td> : <input type=text size=8 name=totalkolismu  value='$totalkoli' readonly=true> koli / <input type=text name=totalberatsmu size=8 value='$totalberat' readonly=true> Kg</td></tr>
       	  <tr><td><B>Koli/Berat (Buildup)</B></td>     <td> : <input type=text size=8 name=totalkolibuildup  value='$kolibuildup' readonly=true> koli / <input type=text name=totalberatbuildup size=8 value='$beratbuildup' readonly=true> Kg</td></tr>
          <tr><td>No. ULD</td><td> : <input type=text name=nould size=20 autocomplete=off onChange=\"javascript:this.value=this.value.toUpperCase();\"> *</td></tr>					
       	  <tr><td>Jml Koli</td>     <td> : <input type=text size=10 name=koli  value='$sisakoli' autocomplete=off onkeypress=\"return isNumberKey(event)\"> *</td></tr>
    	  <tr><td>Berat(KG)</td><td> : <input type=text name=berat size=10  value='$sisaberat' autocomplete=off onkeypress=\"return isNumberKey(event)\"> *</td></tr>


                <tr><td colspan=2><center><strong>*) DATA TIDAK AKAN TERSIMPAN JIKA FIELD INI MASIH KOSONG</strong></center></td></tr>
                <tr><td colspan=2>
								<input type=hidden name=idman value='$idmanifestout'>
								<input type=hidden name=idoutdata value='$iddt'>
								<input type=hidden name=transit value='$transit'>
								";
								if($c=='waiting') {echo "<input type=submit name=tombolsimpan value='Simpan dan Tambah'>
        <input type=button value=Batal onclick=self.history.back()>";}
				echo "</td></tr>
        </table>
				<span class=error>$err</span>
</td>
<td><B><CENTER>== DAFTAR ISI CARGO MANIFEST OUT ==</B><BR>( Total isi : ".$jmldata." items - ".$databerat[0]." Kg - ".$databerat[1]." Koli)</CENTER></B>";

	$p      = new Paging;
	$batas  = 10;
	$posisi = $p->cariPosisi($batas);
	$no     = $posisi+1;
	

 $tampil=mysql_query("SELECT * FROM buildup where isvoid='0' AND id_manifestout='$idmanifestout' 
 ORDER BY nould DESC limit $posisi,$batas");




	 echo "<table>
         <tr><th>no</th><th>No.ULD</th><th>No.SMU</th><th>Jml Koli</th><th>Berat(KG)</th><th>Asal</th><th>Tujuan</th><th>Jenis</th><th>Action</th>
         </tr>";
	$tgl1=my2date($tgl);

/*
	$tampil=mysql_query("
	SELECT * FROM buildup,out_dtbarang_h where buildup.id_out_dtbarang_h=out_dtbarang_h.id and buildup.isvoid='0' ORDER BY buildup.id_out_dtbarang_h DESC limit $posisi,$batas");
 */
// $tampil=mysql_query("
//	SELECT * FROM buildup where isvoid='0' AND id_manifestout='$idmanifestout' ORDER BY nosmu DESC limit $posisi,$batas");
	
	   	
  	while ($r=mysql_fetch_array($tampil))
        {
        	if($r[status]=='DPS'){$tuju='DPS';}else {$tuju=$r[tujuan];}
     	   echo "<tr><td>$no</td>
          <td align=center>$r[nould]</td><td>$r[nosmu]</td><td align=center>$r[koli]</td><td align=center>$r[berat]</td><td align=center>$r[asal]</td><td align=center>$r[tujuan]</td><td align=center>$r[jenisbarang]</td><td align=center>";
					if($r[status_keluar]=='INSTORE'){ echo "<a href=\"aksi.php?module=isimanifestout&act=hapus&n=$r[id_buildup]&i=$_GET[i]\" onclick=\"javascript:return confirm('Penghapusan data masih diperbolehkan dan tidak direkam, selama MANIFEST belum bestatus CHECKED. Apakah Anda yakin akan menghapus data ?')\">Delete</a></td></tr>";
					}
					else
					{
					echo "Delete";
					}
     	  $no++;
  	}
        echo "</table>";
     	
	$jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
  $linkHalaman  = $p->navHalaman($_GET[h], $jmlhalaman,'i='.$_GET[i]);
	echo $linkHalaman;
echo "</td></tr></table>
     </form>";
}


//Edit Isi dari Manifest
elseif (($_GET[module]=='editisimanifestout')AND ($_SESSION[level]=='outgoing'))
{
	if($_GET['p']=='e')
  	{
    	$err='Data SMU tersebut Sudah Ada';
		}

  ?>
  <SCRIPT LANGUAGE="JavaScript" src="cal2.js">
  </script>
  <script language="javascript">
    addCalendar("Caritanggal","Tanggal","tglmanifest","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
  </script>
  <?
		$tampil=mysql_query("SELECT * FROM isimanifestout where isvoid='0' AND id_isimanifestout='$_GET[i]' ");
    $r=mysql_fetch_array($tampil);
		
		

 echo "<h2>Edit data</h2>

        <form method=POST action='aksi.php?module=isimanifestout&act=input'>
<table><tr><td>
       	<table>
       	  <tr><td>No.SMU</td><td> : <input type=text size=30 name=nosmu value='$r[no_smu]'></td></tr>
          <tr><td>Jenis Barang</td>     <td> :
	  	<select name=jenisbarang>";
  		  $tampil1=mysql_query("SELECT * FROM typebarang ORDER BY typebarang ASC");
  		  while($p=mysql_fetch_array($tampil1))
                  {
									 if($p[typebarang]==$r[jenisbarang])
									 {
                    echo "<option value='$p[typebarang]' selected>$p[typebarang]</option>";
									} 
									else
									 {
									  echo "<option value='$p[typebarang]'>$p[typebarang]</option>";
									 }
  		  					}
  	  echo "</select>
          </td></tr>
       	  <tr><td>Total Koli</td>     <td> : <input type=text size=10 name=totalkoli value='$r[totalkoli]'></td></tr>
    	  <tr><td>Total Berat</td><td> : <input type=text name=totalkg size=10 value='$r[totalberat]'></td></tr>
       	  <tr><td>Asal Airport</td><td> :
          <select name=asal>";
  	    	  $tampil2=mysql_query("SELECT * FROM destination ORDER BY destination ASC");
  		  while($p=mysql_fetch_array($tampil2))
                  {
									if($p[destination]==$r[asal]){echo "<option value=$p[destination] selected>$p[destinationdesc]</option>";}
									else{echo "<option value=$p[destination]>$p[destinationdesc]</option>";}
									}
  	  echo "</select>
          <tr><td>Status</td><td>";
			if($r[status_transit]=='DPS'){ 
			echo("
          <input type=radio name=transit value='DPS' checked>DPS
          <input type=radio name=transit value='TRANSIT'>Transit to :");}
					else {
								echo("
          <input type=radio name=transit value='DPS'>DPS
          <input type=radio name=transit value='TRANSIT' checked>Transit to :");}

echo "
	<select name=tujuan>";
    	    	  $tampil2=mysql_query("SELECT * FROM destination ORDER BY destination ASC");
  		  while($p=mysql_fetch_array($tampil2))
                  {
									if($p[destination]==$r[tujuan]){echo "<option value=$p[destination] selected>$p[destinationdesc]</option>";}
									else{echo "<option value=$p[destination]>$p[destinationdesc]</option>";}
									}

  		echo "</select>
		</td></tr>
                <tr><td colspan=2>
								<input type=hidden name=idman value='$idmanifestout'><input type=submit value='Simpan dan Tambah'>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>";
}				



//barang keluar
elseif (($_GET[module]=='barangkeluar')AND ($_SESSION[level]=='outgoing')){

	if($_POST[i]==''){$i=$_GET[i];} else {$i=$_POST[i];}
	$dataman=mysql_query("SELECT * from manifestout where id_manifestout='$i'"); 
	$r=mysql_fetch_array($dataman);
$tgl=ymd2dmy($r[tglmanifest]);
	
$tgl1=my2date($_POST[cari]);
  $p      = new Paging;
  $batas  = 10;
  $posisi = $p->cariPosisi($batas);


  $no     = $posisi+1;
if($_POST[carii]=='1')
{
$tampil=mysql_query("select *, SUM(beratdatang) AS tberatdatang, SUM(kolidatang) AS tkolidatang from isimanifestout,breakdown 
where isimanifestout.id_isimanifestout=breakdown.id_isimanifestout AND isimanifestout.id_manifestout='$i' 
AND isimanifestout.no_smu like '%$_POST[cari]%' AND isimanifestout.isvoid='0' GROUP BY isimanifestout.id_isimanifestout 
order by isimanifestout.id_isimanifestout DESC limit $posisi,$batas");

$tampill=mysql_query("select *, SUM(beratdatang) AS tberatdatang, SUM(kolidatang) AS tkolidatang from isimanifestout,breakdown where isimanifestout.id_isimanifestout=breakdown.id_isimanifestout AND isimanifestout.id_manifestout='$i' 
AND isimanifestout.no_smu like '%$_POST[cari]%' AND isimanifestout.isvoid='0' GROUP BY isimanifestout.id_isimanifestout order by isimanifestout.id_isimanifestout DESC");
}
else
{
$tampil=mysql_query("select * FROM buildup where id_manifestout='$_GET[i]'  
order by nould ASC limit $posisi,$batas");
$tampill=mysql_query("select * FROM buildup where id_manifestout='$_GET[i]'  
order by nould ASC");

}



$tglnya=date("d-m-Y");
    echo "<h2>Isi Cargo Manifest => $r[airline] : A/C Reg.$r[acregistration] Flight No.$r[noflight] / $tgl </h2>
       <form name=form1 method=POST action=?module=barangdatang>
        <table>
        <tr><td>Cari No.SMU</td>     <td> : <input type=text size=30 name=cari>
		<input type=hidden name=carii value=1><input type=hidden name=i value='$i'><input type=submit value=CARI DATA>
        <input type=button value=Batal onclick=self.history.back()>

        </table>
        </form>";

echo "<table>
        <tr><th align=center>no</th><th align=center>No. ULD</th><th align=center>No. SMU</th><th align=center>Berat(Kg)</th><th align=center>Koli</th><th>Jenis Barang</th><th>Asal</th><th>Tujuan</th><th>Action</th></tr>";

  while ($r=mysql_fetch_array($tampil)){
  $tglnya=ymd2dmy($r[tgl]);
     echo "<tr><td align=center>$no</td>
          <td align=center>$r[nould]<td align=center>$r[nosmu]</td><td align=center>$r[berat]</td>
		  <td align=center>$r[koli]</td><td>$r[jenisbarang]</td><td align=center>$r[asal]</td>
		  <td align=center>$r[tujuan]</td>";
				  if($r[status_bayar]=='no')
		  {
		  echo "<td align=center>
			<a href=?module=isimanifestoutdel&n=$r[id_isimanifestout]&i=$i  
		  title='klik untuk menghapus SMU'>CANCEL</a> | ";
			
						  if($r[status_update]=='no')
		  				{
		  				echo "<a href=?module=breakdownedit&n=$r[id_isimanifestout]&i=$i 
							title='klik untuk update data sesuai dgn SMU datang'>Edit</a> | Split SMU";}
							else {echo "Edit | <a href=?module=splitsmu&n=$r[id_isimanifestout]&i=$i 
							title='Jika barang datang tidak sejumlah SMU'>Split SMU</a></td>";}
			
			
			}
	else {echo "<td align=center>CANCEL | Edit | <a href=?module=splitsmu&n=$r[id_isimanifestout]&i=$i 
							title='Jika barang datang tidak sejumlah SMU'>Split SMU</a> ";}
		echo" </tr>";
     $no++;
  }
  echo "</table>";
   $jmldata      = mysql_num_rows($tampill);
  $jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
  $linkHalaman  = $p->navHalaman($_GET[h], $jmlhalaman,'i='.$_GET[i]);

  echo "<p>$linkHalaman</p>";


}

//Pecah SMU
elseif (($_GET[module]=='splitsmu') AND ($_SESSION[level]=='outgoing'))
{
 ?>
  <SCRIPT LANGUAGE="JavaScript" src="cal2.js">
  </script>
  <script language="javascript">
    addCalendar("Caritanggal","Tanggal","tgldatang","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
  </script>
  <?
 $tampil=mysql_query("select *, SUM(beratdatang) AS tberatdatang, SUM(kolidatang) AS tkolidatang from isimanifestout,breakdown where isimanifestout.id_isimanifestout=breakdown.id_isimanifestout AND isimanifestout.id_isimanifestout='$_GET[n]' GROUP BY isimanifestout.id_isimanifestout");
  $r=mysql_fetch_array($tampil);

	if($_GET['p']=='e')
  	{
    	$err='Jumlah Barang Melebihi Manifest !';
	}
  $tglnya=date("d-m-Y");
  echo "<h2>Split kedatangan SMU : $r[no_smu]</h2>
       <form name=form1 method=POST action=aksi.php?module=breakdown&act=input>
       <table><tr><td>
			  <B>UPDATE JUMLAH BARANG <u>SESUAI KEDATANGAN</u> !</B><BR>
       <table>
       <tr><td><b>Total Koli di SMU</b></td>     <td> : <input type=text size=10 name=totalkoli value='$r[totalkoli]' readonly=true> *
       <tr><td><b>Total Berat di SMU</b></td>     <td> : <input type=text size=10 name=totalberat value='$r[totalberat]' readonly=true> *
       <tr><td><b>JML BERAT DATANG</b></td>     <td> : <input type=text size=10 name=tberatdatang value='$r[tberatdatang]'
	    readonly=true> *	   
       <tr><td><b>JML KOLI DATANG</b></td>     <td> : <input type=text size=10 name=tkolidatang  value='$r[tkolidatang]'
	   readonly=true> *	   	   
       <tr><td>Tanggal Datang</td>     <td> : <input type=text name=tgldatang size=10 value='$tglnya' readonly>";
  ?>
  <a href="javascript:showCal('Caritanggal')"><img src="images/calendar.png" border="0"></a>
  <?
  $kol=$r[totalkoli]-$r[tkolidatang];
  $brt=$r[totalberat]-$r[tberatdatang];
  echo "
  <tr><td>Koli Datang</td>     <td> : <input type=text size=10 name=kolidatang value=$kol>
  <tr><td>Berat Datang</td>     <td> : <input type=text size=10 name=beratdatang value=$brt>
<input type=hidden name=i value='$_GET[i]'><input type=hidden name=n value='$_GET[n]'></td></tr>
	<tr><td colspan=2><strong><center>*) Readonly - Otomatis terisi</center></strong></td></tr>

	<tr><td colspan=2><input type=submit value='Simpan'>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table><span class=error>$err</span>
        </td><td>";

  $p      = new Paging;
  $batas  = 10;
  $posisi = $p->cariPosisi($batas);

  $no     = $posisi+1;
  
$tampil2=mysql_query("SELECT * FROM breakdown where isvoid='0' AND id_isimanifestout='$_GET[n]' order by tgldatang DESC limit $posisi,$batas");
$tampil3=mysql_query("SELECT * FROM breakdown where isvoid='0' AND id_isimanifestout='$_GET[n]' order by tgldatang DESC");

echo "<CENTER><b>== SPLIT SMU outgoing ==</b></CENTER> 
		<table>
    <tr><th>no</th><th>Tgl Datang</th><th>Berat Datang</th><th>Koli Datang</th><th>Status</th><th>ACTION</th></tr>";
 		while ($r=mysql_fetch_array($tampil2)){
     echo "<tr><td align=center>$no</td>
          <td align=center>".ymd2dmy($r[tgldatang])."</td><td align=center>$r[beratdatang]</td><td align=center>$r[kolidatang]</td><td align=center>$r[status_ambil]</td><td align=center> ";
					if($r[status_ambil]=='INSTORE')
					{ 
					echo " 
					<a href=aksi.php?module=breakdown&act=hapus&id=$r[id_breakdown]&i=$_GET[i]&n=$_GET[n] title='klik untuk menghapus'>Hapus</a> ";
					}
					else
					{echo "Hapus";}
					echo " 
					</td></tr>";
     $no++;
  }
  echo "</table>";
 ;

	$jmldata      = mysql_num_rows($tampil3);
  $jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
  $linkHalaman  = $p->navHalaman($_GET[h], $jmlhalaman,'');


	echo "$linkHalaman";
	echo "<BR><BR>Status <B>\"INSTORE\"</B> berarti barang belum ada di diambil atau belum masuk buildup</B>.</td></tr>
	</table></form>
	
				</td></tr>
        
				</form>";

}




//Edit SMU dan Brekadown
elseif (($_GET[module]=='breakdownedit')AND($_SESSION[level]=='outgoing')){
$tampil=mysql_query("select * from isimanifestout where id_isimanifestout='$_GET[n]'");
$r=mysql_fetch_array($tampil);
    echo "<h2>Edit Breakdown No. SMU : $r[no_smu]</h2>
       <form name=form1 method=POST action=aksi.php?module=isimanifestout&act=edit>
        <table>
		<tr><td>No SMU</td><td> : <input type=text name=no_smu size=20 value='$r[no_smu]'></td></tr>		
          <tr><td>Jenis Barang</td>     <td> :
	  	<select name=jenisbarang>";
  		  $a=mysql_query("SELECT * FROM typebarang ORDER BY typebarang ASC");
  		  while($p=mysql_fetch_array($a))
                {
                    if($p[typebarang]==$r[jenisbarang])
					{
						echo "<option value='$p[typebarang]' selected>$p[typebarang]</option>";
					}
                    else 
					{
						echo "<option value='$p[typebarang]'>$p[typebarang]</option>";
					}
				}
  	  echo "</select>
          </td></tr>
			
    	  <tr><td>Jml  Koli (SMU)</td><td> : <input type=text name=totalkoli size=10 value=$r[totalkoli]></td></tr>
    	  <tr><td>Berat  (SMU)</td><td> : <input type=text name=totalberat size=10 value=$r[totalberat]></td></tr>
    	  <tr><td>Jml  Koli (DATANG)</td><td> : <input type=text name=totalkolidatang size=10 value=$r[totalkoli]></td></tr>
    	  <tr><td>Berat  (DATANG)</td><td> : <input type=text name=totalberatdatang size=10 value=$r[totalberat]></td></tr>
       	  <tr><td>Asal Airport</td><td> :
          <select name=asal>";
  	    	  $tampil=mysql_query("SELECT * FROM destination ORDER BY destination ASC");
  		  while($p=mysql_fetch_array($tampil))
                {
                    if($p[destination]==$r[asal])
					{
						echo "<option value=$p[destination] selected>$p[destinationdesc]</option>";
					}
                    else 
					{
						echo "<option value=$p[destination]>$p[destinationdesc]</option>";
					}
				}
  	  echo "</select>
          <tr><td>Status</td><td>";
		  if($r[status_transit]=='DPS')
		  {
          echo("<input type=radio name=transit value='DPS' checked>DPS
				<input type=radio name=transit value='TRANSIT'>Transit to :");
		  }
		  else
		  {
          echo("<input type=radio name=transit value='DPS'>DPS
				<input type=radio name=transit value='TRANSIT' checked>Transit to :");
		  }

	echo "<select name=tujuan>";
  		$tampil=mysql_query("SELECT * FROM destination ORDER BY destination ASC");
 		  while($p=mysql_fetch_array($tampil))
                {
                    if($p[destination]==$r[tujuan])
					{
						echo "<option value=$p[destination] selected>$p[destinationdesc]</option>";
					}
                    else 
					{
						echo "<option value=$p[destination]>$p[destinationdesc]</option>";
					}
				}
  		echo "</select>
		</td></tr>
                <tr><td colspan=2><input type=submit value='UPDATE'>
        <input type=button value=Batal onclick=self.history.back()>
		<input type=hidden name=n value='$r[id_isimanifestout]'>
		<input type=hidden name=i value='$_GET[i]'>
		</td></tr>
	   
        </table>
        </form>";
}

//*****HAPUS ISI MANIFEST
elseif (($_GET[module]=='isimanifestoutdel')AND($_SESSION[level]=='outgoing')){
$tampil=mysql_query("select * from isimanifestout where id_isimanifestout='$_GET[n]'");
$r=mysql_fetch_array($tampil);
    echo "<h2>Cancel  No. SMU : $r[no_smu]</h2>
       <form name=form1 method=POST action=aksi.php?module=isimanifestout&act=cancel>
        <table>	
    	  <tr><td>Keterangan</td><td> : <input type=text name=keterangan_void size=60></td></tr>
		</td></tr>
                <tr><td colspan=2><input type=submit value='CANCEL'>
        <input type=button value=Batal onclick=self.history.back()>
		<input type=hidden name=n value='$r[id_isimanifestout]'>
		<input type=hidden name=i value='$_GET[i]'>
		</td></tr>
	   
        </table>
        </form>";
}

//Form cetak stockopname outgoing
elseif (($_GET[module]=='stockopnameout')AND($_SESSION[level]=='outgoing')){
$tglnya=date("Y-m-d");
$tgl=ymd2dmy($tglnya);

  $p      = new Paging;
  $batas  = 10;
  $posisi = $p->cariPosisi($batas);
  $no     = $posisi+1;
	
mysql_query("DELETE FROM stockopnameout");	
//sisa BTB yang tersplit
mysql_query("
INSERT INTO stockopnameout(nosmu,sisakoli,sisaberat) SELECT nosmu,out_dtbarang_h.btb_totalkoli-SUM(koli) AS sisakoli,
out_dtbarang_h.btb_totalberat-SUM(berat) AS sisaberat FROM buildup,out_dtbarang_h where out_dtbarang_h.btb_smu=buildup.nosmu
AND buildup.status_keluar='OUT' GROUP BY buildup.id_out_dtbarang_h;");

//sisa transit 1 SMU yang tersplit
mysql_query("
INSERT INTO stockopnameout(nosmu,sisakoli,sisaberat) SELECT nosmu,isimanifestin.totalkoli-SUM(buildup.koli) AS sisakoli,
isimanifestin.totalberat-SUM(buildup.berat) AS sisaberat FROM buildup,isimanifestin where 
isimanifestin.id_isimanifestin=buildup.id_out_dtbarang_h 
AND buildup.status_keluar='OUT' AND  buildup.status_transit='TRANSIT' GROUP BY buildup.id_out_dtbarang_h");

//btb belum builup
mysql_query("
INSERT INTO stockopnameout(nosmu,sisakoli,sisaberat) 
select btb_smu AS nosmu,btb_totalkoli AS sisakoli,btb_totalberat AS sisaberat from out_dtbarang_h where status_keluar='INSTORE'");

//transit belum buildup
mysql_query("
INSERT INTO stockopnameout(nosmu,sisakoli,sisaberat) 
select isimanifestin.no_smu as nosmu,isimanifestin.totalkoli as sisakoli, isimanifestin.totalberat as sisaberat 
from breakdown, isimanifestin
WHERE breakdown.id_isimanifestin =isimanifestin.id_isimanifestin 
AND isimanifestin.status_transit='TRANSIT' 
AND breakdown.status_ambil='INSTORE' 
GROUP BY breakdown.id_isimanifestin");

mysql_query("DELETE FROM stockopnameout where sisakoli='0' OR sisaberat='0'");

$a=mysql_query("SELECT SUM(sisaberat),SUM(sisakoli) FROM stockopnameout");	
$instok=mysql_fetch_array($a);

	
if($_POST[carii]=='1')
{
$tampil=mysql_query("SELECT * FROM stockopnameout where nosmu like '%$_POST[cari]%' 
order by nosmu ASC limit $posisi,$batas");
$tampill=mysql_query("SELECT * FROM stockopnameout order by nosmu ASC"); 
}
else
{
$tampil=mysql_query("SELECT * FROM stockopnameout order by nosmu ASC limit $posisi,$batas");
$tampill=mysql_query("SELECT * FROM stockopnameout order by nosmu ASC"); 
}


   echo "<h2>Kondisi Gudang outgoing Per Tanggal : $tgl | $instok[0] Kg / $instok[1] Koli</h2>
				<p><a href=aksi.php?module=cetakstockopnameout target=_blank>Klik Disini untuk cetak STOCKOPNAME outgoing Checklist</a></p>
				       <form name=form1 method=POST action=?module=stockopnameout>
        <table>
        <tr><td>Cari No.SMU</td>     <td> : <input type=text size=30 name=cari>
		<input type=hidden name=carii value=1><input type=hidden name=i value='$i'><input type=submit value=CARI DATA>
        <input type=button value=Batal onclick=self.history.back()>

        </table>
        </form>
				<table>
        <tr><th>no</th><th>No.SMU/AWB</th><th>Total Koli</th><th>Total Berat</th>";
  while ($r=mysql_fetch_array($tampil)){
     echo "<tr><td>$no</td><td align=center>$r[nosmu]</td><td align=center>$r[sisakoli]</td><td align=center>$r[sisaberat]</td></tr>";
     $no++;
  }
  echo "</table>";
 	$jmldata      = mysql_num_rows($tampill);
  $jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
  $linkHalaman  = $p->navHalaman($_GET[h], $jmlhalaman,'&n='.$_GET[n]);

	echo "<p>$linkHalaman</p>";
	echo "</td></tr></table></form>";
}


//************************END OF OUTGOING ***************************************************
//******************************************************************************************





//****************** SUPERVISOR **************//
//Form void delivery bill
elseif (($_GET[module]=='delivery')AND ($_SESSION[level]=='supervisor')){
$tgl=date("Y-m-d");
  $p      = new Paging;
  $batas  = 10;
  $posisi = $p->cariPosisi($batas);

  
  $no     = $posisi+1;

if($_POST[carii]=='1')
{
$tampil=mysql_query("SELECT * FROM deliverybill where (nosmu like '%$_POST[cari]%') ORDER BY tglbayar DESC limit $posisi,$batas");
$tampil1=mysql_query("SELECT * FROM deliverybill where (nosmu like '%$_POST[cari]%') ORDER BY tglbayar DESC");

}
else
{
$tampil=mysql_query("SELECT * FROM deliverybill ORDER BY tglbayar DESC limit $posisi,$batas");
$tampil1=mysql_query("SELECT * FROM deliverybill ORDER BY tglbayar DESC");
}

    echo "<h2>Data Delivery Bill</h2>
     <form name=form1 method=POST action=?module=superoutgoing>
        <table>
        <tr><td>Cari</td>     <td> : <input type=text size=30 name=cari>		
		<input type=hidden name=carii value=1>
	    <tr><td colspan=2><input type=submit value=CARI DATA>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";
		
echo "<table>         <tr><th>no</th><th>No. BTB</th><th>TOTAL BAYAR</th><th>Tgl Bayar</th><th>No. DB</th>
<th>Cara Bayar</th><th>STATUS</th><th>Tgl Void</th><th>Operator</th><th>Keterangan Void</th></tr>";


  while ($r=mysql_fetch_array($tampil)){
  if($r[isvoid]=='1'){$v='VOID';}else {$v='-';}
$total=$r[document]+$r[overtime]+$r[lain];
$tgl=ymd2dmy($r[tglbayar]);
$tglv=ymd2dmy($r[tglvoid]);
$formatdokumen=number_format($r[document], 0, '.', '.');   
$formatstorage=number_format($r[storage], 0, '.', '.');   
$formatlain=number_format($r[lain], 0, '.', '.');   
$formattotal=number_format($total, 0, '.', '.');  
if($r[status]=='1')
{ 
if($r[id_deliverybill]<10){$nodb='O000000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10 AND $r[id_deliverybill]<100){$nodb='O00000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100 AND $r[id_deliverybill]<1000){$nodb='O0000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000 AND $r[id_deliverybill]<10000){$nodb='O000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10000 AND $r[id_deliverybill]<100000){$nodb='O00'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100000 AND $r[id_deliverybill]<1000000){$nodb='O0'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000000 AND $r[id_deliverybill]<10000000){$nodb='O'.$r[id_deliverybill];}
}
else
{
if($r[id_deliverybill]<10){$nodb='I000000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10 AND $r[id_deliverybill]<100){$nodb='I00000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100 AND $r[id_deliverybill]<1000){$nodb='I0000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000 AND $r[id_deliverybill]<10000){$nodb='I000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10000 AND $r[id_deliverybill]<100000){$nodb='I00'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100000 AND $r[id_deliverybill]<1000000){$nodb='I0'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000000 AND $r[id_deliverybill]<10000000){$nodb='I'.$r[id_deliverybill];}
}

     echo "<tr><td>$no</td>
           <td>$r[nosmu]</td><td>Rp. $formattotal</td><td>$tgl</td><td>$nodb</td><td>$r[id_carabayar]</td><td>$v</td>
					<td>$tglv</td><td>$r[user]</td><td>$r[keterangan]</td></tr>";    
					$no++;
  }
  echo "</table>";
  $jmldata      = mysql_num_rows($tampil1);
  $jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
  $linkHalaman  = $p->navHalaman($_GET[h], $jmlhalaman,'0');

  echo "<p>$linkHalaman</p>";
   
}

//void deliverybill
elseif (($_GET[module]=='voiddb')AND($_SESSION[level]=='kasir')){
    echo "<h2>VOID DeliveryBill # $_GET[n]</h2>
       <form name=form1 method=POST action=aksi.php?module=voiddb>
        <table>	
    	  <tr><td>Keterangan</td><td> : <input type=text name=keterangan size=60></td></tr>
		</td></tr>
                <tr><td colspan=2><input type=submit value='CANCEL'>
        <input type=button value=Batal onclick=self.history.back()>
		<input type=hidden name=i value='$_GET[i]'>		<input type=hidden name=s value='$_GET[s]'><input type=hidden name=b value='$_GET[b]'>
		</td></tr>
	   
        </table>
        </form>";
}


//Form void incoming
elseif (($_GET[module]=='superincoming')AND ($_SESSION[level]=='supervisor')){
$tgl=date("Y-m-d");
  $p      = new Paging;
  $batas  = 10;
  $posisi = $p->cariPosisi($batas);

  
  $no     = $posisi+1;

if($_POST[carii]=='1')
{
$tampil=mysql_query("SELECT * FROM deliverybill,in_dtbarang_h where deliverybill.no_smubtb=in_dtbarang_h.no_smu AND tglbayar =  '$tgl' AND (deliverybill.no_smubtb like '%$_POST[cari]%' OR deliverybill.id_deliverybill like '%$_POST[cari]%' OR in_dtbarang_h.agent like '%$_POST[cari]%')ORDER BY deliverybill.id_deliverybill DESC limit $posisi,$batas");

$tampil1=mysql_query("SELECT * FROM deliverybill,in_dtbarang_h where deliverybill.no_smubtb=in_dtbarang_h.no_smu AND tglbayar =  '$tgl' AND (deliverybill.no_smubtb like '%$_POST[cari]%' OR deliverybill.id_deliverybill like '%$_POST[cari]%' OR in_dtbarang_h.agent like '%$_POST[cari]%')ORDER BY deliverybill.id_deliverybill DESC");

}
else
{
$tampil=mysql_query("SELECT * FROM deliverybill,in_dtbarang_h where deliverybill.no_smubtb=in_dtbarang_h.no_smu AND tglbayar =  '$tgl' ORDER BY id_deliverybill DESC limit $posisi,$batas");
$tampil1=mysql_query("SELECT * FROM deliverybill,in_dtbarang_h where deliverybill.no_smubtb=in_dtbarang_h.no_smu AND tglbayar =  '$tgl' ORDER BY id_deliverybill DESC");
}

    echo "<h2>Data Transaksi INCOMING </h2>
  <a href=aksi.php?module=cetaklap&i=1 target=_blank><img src=images/printer.jpg border=0></a>

       <form name=form1 method=POST action=?module=superoutgoing>
        <table>
        <tr><td>Cari</td>     <td> : <input type=text size=30 name=cari>		
		<input type=hidden name=carii value=1>
	    <tr><td colspan=2><input type=submit value=CARI DATA>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";
		
echo "<table>         <tr><th>no</th><th>No. BTB</th><th>TOTAL BAYAR</th><th>Tgl Bayar</th><th>No. DB</th>
<th>STATUS</th><th>Tgl Void</th><th>Operator</th><th>Keterangan</th></tr>";


  while ($r=mysql_fetch_array($tampil)){
  if($r[isVoid]=='1'){$v='VOID';}else {$v='-';}
$total=$r[document]+$r[overtime]+$r[lain]+$r[storage];
$tgl=ymd2dmy($r[tglbayar]);
//if($r[id_carabayar]=='1'){$stb='CASH';}else{$stb='PERIODICAL';}
$formatdokumen=number_format($r[document], 0, '.', '.');   
$formatstorage=number_format($r[storage], 0, '.', '.');   
$formatlain=number_format($r[lain], 0, '.', '.');   
$formattotal=number_format($total, 0, '.', '.');   
if($r[id_deliverybill]<10){$nodb='I000000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10 AND $r[id_deliverybill]<100){$nodb='I00000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100 AND $r[id_deliverybill]<1000){$nodb='I0000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000 AND $r[id_deliverybill]<10000){$nodb='I000'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=10000 AND $r[id_deliverybill]<100000){$nodb='I00'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=100000 AND $r[id_deliverybill]<1000000){$nodb='I0'.$r[id_deliverybill];}
else if($r[id_deliverybill]>=1000000 AND $r[id_deliverybill]<10000000){$nodb='I'.$r[id_deliverybill];}
     echo "<tr><td>$no</td>
          <td>$r[no_smubtb]</td><td>Rp. $formattotal</td><td>$tgl</td><td>$nodb</td><td>$v</td>
					<td>$v</td><td>$v</td><td>$r[keterangan]</td>
         </tr>";
     $no++;
  }
  echo "</table>";
  $jmldata      = mysql_num_rows($tampil1);
  $jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
  $linkHalaman  = $p->navHalaman($_GET[h], $jmlhalaman,'0');

  echo "<p>$linkHalaman</p>";
  
 
 
}








//************************END OF super***************************************************
//**********************************************






//Form Manifset out
elseif (($_GET[module]=='manifestout11')AND ($_SESSION[level]=='outgoing')){
  echo "<h2>Cargo Manifest - Outbound</h2>
        <form method=POST action='?act=tambahmanifestout'>
        <input type=submit value='Tambah Manifest'>
        </form>
        <table>
        <tr><th>no</th><th>Date</th><th>Operator</th><th>Flight No</th><th>A/C Registration</th></tr>";
  $tampil=mysql_query("SELECT * from manifest,operatorairline where 
  manifest.id_operatorairline=operatorairline.id_operatorairline order by etd DESC");
  $no=1;
  while ($r=mysql_fetch_array($tampil)){
  $tglnya=ymd2dmy($r[etd]);
     echo "<tr><td>$no</a></td>
          <td>$tglnya</td><td>$r[operatorairline]</td><td>$r[noflight]</td><td><a href=?act=buildup&id=$r[id_manifest]>$r[acregistration]</a></td></tr>";
     $no++;
  }
  echo "</table>";
}

// Form tambah manifest out
elseif (($_GET[act]=='tambahmanifestoutjjj')AND($_SESSION[level]=='outgoing')){
?>
	
	<SCRIPT LANGUAGE="JavaScript" src="cal2.js">
    </script>
	<script language="javascript">
    addCalendar("Caritanggal","Date of Departure","etd","form1");
    setWidth(90, 1, 15, 1);
	setFormat("dd-mm-yyyy");
    </script>

			
  <? $tglnya=date("d-m-Y");
  echo "<h2>Tambah Cargo Manifest - Outbound</h2>
        <form name=form1 method=POST action='aksi.php?module=manifestout&act=input'>
        <table>
        <tr><td>Date</td>     <td> : <input type=text name=etd size=20 value='$tglnya'>";?>
		<a href="javascript:showCal('Caritanggal')"><img src="images/calendar.png" border="0"></a>
		<?
		echo "</td></tr>				
        <tr><td>Operator Airline</td>     <td> :
      	<select name=id_operatorairline>
        <option value=0 selected>- Pilih Airlines -</option>";
  		$tampil=mysql_query("SELECT * FROM operatorairline ORDER BY operatorairline");
  			while($r=mysql_fetch_array($tampil)){
    	echo "<option value=$r[id_operatorairline]>$r[operatorairline] ($r[kodeoperator])</option>";
  		}
  		echo "</select></td></tr>	   	
        <tr><td>Flight No.</td>     <td> : <input type=text name=noflight size=20></td></tr>	
        <tr><td>A/C Registration</td>     <td> : <input type=text name=acregistration size=20></td></tr>			
			
	    <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";
}

//Form buildup
elseif (($_GET[act]=='buildup')AND ($_SESSION[level]=='outgoing')){
		$tampil=mysql_query("SELECT * FROM manifest where id_manifest='$_GET[id]'");
  		$w=mysql_fetch_array($tampil);
		
 	echo "<h2>A/C Registration : $w[acregistration]</h2>
        <form method=POST action='?act=tambahbuildup'>
		<input type=hidden value='$w[nosmu]' name=nosmu><input type=hidden value='$w[id_smu]' name=idsmu><input type=hidden value='$w[id_manifest]' name=id_manifest>
        <input type=submit value='Tambah Barang'>
        </form>";
        echo "<table>
        <tr><th>no</th><th>No.ULD</th><th>No. SMU</th><th>Berat(KG)</th><th>Komoditi</th><th>Tujuan</th></tr>";
  $tampil=mysql_query("SELECT * from buildup where id_manifest='$w[id_manifest]'");
  $no=1;
  while ($r=mysql_fetch_array($tampil)){
     echo "<tr><td>$no</td>
          <td>$r[nould]</td><td>$r[nosmu]</td><td>$r[kg]</td><td>$r[kode]</td><td>$r[kodekomoditi]</td>
         </tr>";
     $no++;
  }
  echo "</table>";
}
// Form tambah buildup
elseif (($_GET[act]=='tambahbuildup')AND($_SESSION[level]=='outgoing')){
?><SCRIPT LANGUAGE="JavaScript">
			function popupwindow(URL) {
			day = new Date();
			id = day.getTime();
			eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=0,location=0,statusbar=0,url=0,menubar=0,titlebar=0,resizable=0,width=750,height=450,left = 440,top = 175');");

			}
			
			</script>
  <? echo "<h2>Tambah Data</h2>
        <form method=POST action='aksi.php?module=buildup&act=input'>
        <table>
        <tr><td>No. ULD</td>     <td> :
      	<select name=id_uld>
        <option value=0 selected>- Pilih No.ULD -</option>";
  		$tampil=mysql_query("select * from uld,jenisuld
where uld.id_jenisuld=jenisuld.id_jenisuld ORDER BY jenisuld.kodeuld,uld.nould DESC");
  			while($r=mysql_fetch_array($tampil)){
    	echo "<option value=$r[id_uld]>$r[kodeuld]-$r[nould]</option>";
  		}
  		echo "</select></td></tr>	   	
        <tr><td>No. SMU</td>     <td> :
      	<select name=id_smu>
        <option value=0 selected>- Pilih No.SMU -</option>";
  		$tampil=mysql_query("select * from smu where statuskirim=0 AND statusbayar=1 ORDER BY id_smu DESC");
  		while($r=mysql_fetch_array($tampil))
		{
		 $tam=mysql_query("select sum(koli) AS bkoli from buildup where id_smu='$r[id_smu]'");
  		 $w=mysql_fetch_array($tam);
		 {   
		     if($w[bkoli]=$r[beratkoli]){$all='1';} else {$all='2';}
	     	 echo "<option value=$r[id_smu]>$r[nosmu] ($w[koli]/$r[beratkoli])</option>";
    	 }		
  		}
  		echo "</select></td></tr><input type=hidden name=all value='$all'>
		<input type=hidden name=id_manifest value='$_POST[id_manifest]'>	   	
        <tr><td>Koli</td>     <td> : <input type=text name=jmlkoli size=20>	
        <tr><td>Berat Kotor (KG)</td>     <td> : <input type=text name=beratkotor size=20></td></tr>			   						
	    <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";
}








//***************************************************************************************
// BAGIAN OUTBOUND
//***************************************************************************************
//Form BARANG OUTBOUND
elseif (($_GET[act]=='barangoutbound')AND ($_SESSION[level]=='outbound')){
		$tampil=mysql_query("SELECT * FROM smu where id_smu='$_GET[id]'");
  		$w=mysql_fetch_array($tampil);
if($w[statusbayar]=='0'){
  echo "<h2>No SMU : $w[nosmu]</h2>
        <form method=POST action='?act=tambahbarangoutbound'>
		<input type=hidden value='$w[nosmu]' name=nosmu><input type=hidden value='$w[id_smu]' name=idsmu>
        <input type=submit value='Tambah Barang'>
        </form>";} 
        echo "<table>
        <tr><th>no</th><th>Penjelasan</th><th>Koli</th><th>KG</th></tr>";
  $tampil=mysql_query("SELECT * from barangoutbound where id_smu='$w[id_smu]'");
  $no=1;
  while ($r=mysql_fetch_array($tampil)){
     echo "<tr><td>$no</td>
          <td>$r[penjelasan]</td><td>$r[koli]</td><td>$r[kg]</td>
         </tr>";
     $no++;
  }
  echo "</table>";
}
// Form tambah Barang OUTBOUND
elseif (($_GET[act]=='tambahbarangoutbound')AND($_SESSION[level]=='outbound')){
  echo "<h2>Tambah Barang</h2>
        <form method=POST action='aksi.php?module=barangoutbound&act=input'>
        <table>
        <tr><td>Penjelasan</td>     <td> : <textarea name=penjelasan rows=3 cols=50></textarea></td></tr>						
        <tr><td>Koli</td>     <td> : <input type=text name=koli size=10></td></tr>				
        <tr><td>KG</td>     <td> : <input type=text name=kg size=10></td></tr>			   				
        <tr><td>No. SMU</td>     <td> : <input type=text name=nosmu size=50 value='$_POST[nosmu]' readonly=true>
		<input type=hidden name=idsmu value='$_POST[idsmu]'></td></tr>			   						
	    <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";
}

//************************END OF OUTBOUND***************************************************



// Form Balas Email
elseif ($_GET[act]=='balasemail'){
  $tampil = mysql_query("SELECT * FROM hubungi WHERE id_hubungi='$_GET[id]'");
  $r      = mysql_fetch_array($tampil);

  echo "<h2>Reply Email</h2>
        <form method=POST action='?module=kirimemail'>
        <table>
        <tr><td>Kepada</td><td> : <input type=text name=email size=30 value='$r[email]'></td></tr>
        <tr><td>Subjek</td><td> : <input type=text name=subjek size=50 value='Re: $r[subjek]'></td></tr>
        <tr><td>Pesan</td><td>  : <textarea name=pesan rows=13 cols=70>
        
        
        
  ------------------------------------------------------------------------------
  $r[pesan]</textarea></td></tr>
        <tr><td colspan=2><input type=submit value=Kirim>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";
}

// Kirim Email
elseif ($_GET[module]=='kirimemail'){
  mail($_POST[email],$_POST[subjek],$_POST[pesan],"From: redaksi@bukulokomedia.com");
  echo "<h2>Status Email</h2>
        <p>Email telah sukses terkirim ke tujuan</p>

        <p>[ <a href=javascript:history.go(-1)>Kembali</a> ]</p>";	 		  
}
//UMUM

// Apabila modul tidak ditemukan
else{
  echo "<p align=center><b>MODUL BELUM TERPASANG</b></p>";
}

?>
