<?php
include "config/koneksi.php";
include "config/fpdf.php";
include "config/library.php";
include "config/fungsi_indotgl.php";
include "config/fungsi_combobox.php";
include "config/class_paging.php";


// Module Home
/*
       <tr>
			<td>Code</td> 
			<td> : <input type=text name=code size=20 value='$r[code]' onChange=\"javascript:this.value=this.value.toUpperCase();\"  > </td>
		</tr>	
*/
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
// end of home

// Manajemen User
elseif (($_GET[module]=='user')AND($_SESSION[level]=='admin'))
{
  echo "<h2>MANAJEMEN USER ACCOUNT WMS</h2>
        <form method=POST action='?act=tambahuser'>
        <input type=submit value='Tambah User' class='tombol'>
        </form>
        <table>
        <tr><th>no</th><th>username</th><th>nama lengkap</th><th>nipp</th><th>user level</th>
		<th>no telpon</th><th>action</th></th></tr>";
	$p      = new Paging;
	$batas  = 100;
	$posisi = $p->cariPosisi($batas);
	$tampil=mysql_query("SELECT * FROM user WHERE id_user!='admin' ORDER BY level DESC limit $posisi,$batas");
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
elseif (($_GET[act]=='tambahuser')AND($_SESSION[level]=='admin')){
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
			<option value='export'>EXPORT</option>
			<option value='import'>IMPORT</option>
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
elseif (($_GET[act]=='edituser')AND($_SESSION[level]=='admin')){
  $edit=mysql_query("SELECT * FROM user WHERE id_user='$_GET[id]'");
  $r=mysql_fetch_array($edit);

  echo "<h2>Edit User</h2>
        <form method=POST action=aksi.php?module=user&act=update>
        <input type=hidden name=id value='$r[id_user]'>
        <table>
        <tr><td>Username</td>     <td> : $r[id_user]</td></tr>
        <tr><td>Password</td>     <td> : <input type=text name=password> *) </td></tr>
        <tr><td>Nama Lengkap</td> <td> : <input type=text name=nama_lengkap size=30  value='$r[nama_lengkap]'></td></tr>
        <tr><td>NIPP</td> <td> : <input type=text name=nipp size=20 value='$r[nipp]'> *</td></tr>					
        <tr><td>User Level</td> <td> : 
		<select name=level>";
		if($r[level]=='supervisor')
		{
		echo "<option value='supervisor' selected>SUPERVISOR</option>
			<option value='export'>EXPORT</option>
			<option value='import'>IMPORT</option>
			<option value='btb'>BTB</option>";
		}
		else if($r[level]=='export')
		{
		echo "<option value='supervisor'>SUPERVISOR</option>
			<option value='export' selected>EXPORT</option>
			<option value='import'>IMPORT</option>
			<option value='btb'>BTB</option>";
		}
		else if($r[level]=='import')
		{
		echo "<option value='supervisor'>SUPERVISOR</option>
			<option value='export'>EXPORT</option>
			<option value='import' selected>IMPORT</option>
			<option value='btb'>BTB</option>";
		}
		else if($r[level]=='btb')
		{
		echo "<option value='supervisor'>SUPERVISOR</option>
			<option value='export'>EXPORT</option>
			<option value='import'>IMPORT</option>
			<option value='btb' selected>BTB</option>";
		}
		
		echo "</select></td></tr>
		<tr><td>No. Telpon</td> <td> : <input type=text name=no_telpon size=30 value='$r[telpon]'></td></tr>						
        <tr><td colspan=2>*) Apabila password tidak diubah, dikosongkan saja.</td></tr>
        <tr><td colspan=2><input type=submit value=Update>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";
}

//start melihat data user
// Form edit user
elseif ($_GET[module]=='myacc')
{
	$data=mysql_query("SELECT * FROM user WHERE id_user='$_SESSION[namauser]'");
	$r=mysql_fetch_array($data);
	echo "<h2>USERNAME :  $_SESSION[namauser]</h2>
        <form method=POST action=aksi.php?&act=user_update>
        <input type=hidden name=id value='$r[id_user]'>
        <table>
        <tr><td>Password</td>     <td> : <input type=text name=password> *) </td></tr>
        <tr>
			<td>Nama Lengkap</td> 
			<td> : <input type=text name=nama_lengkap size=30  value='$r[nama_lengkap]' onChange=\"javascript:this.value=this.value.toUpperCase();\"  ></td>
		</tr>
        <tr>
			<td>NIPP</td> 
			<td> : <input type=text name=nipp size=20 value='$r[nipp]' onChange=\"javascript:this.value=this.value.toUpperCase();\"  > </td>
		</tr>					
 
        <tr>
			<td>User Level</td> <td> : $r[level] </td>
		</tr>
		<tr>
			<td>No. Telpon</td>
			<td> : <input type=text name=no_telpon size=30 value='$r[telpon]'></td>
		</tr>						
        <tr><td colspan=2>*) Apabila password tidak diubah, dikosongkan saja.</td></tr>
        <tr><td colspan=2><input type=submit value=Update>
			<input type=hidden name=module value=$_GET[module]>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";
}
//

//******************************START OF BTB INTER *************************************

//---------------Menampilkan Data SMU-------------------------------------------------
elseif (($_GET[module]=='carismu')AND($_SESSION[level]=='btb'))
{
	$p      = new Paging;
	$batas  =10;
	$posisi = $p->cariPosisi($batas);
    $no     = $posisi+1;
	

if(!empty($_POST[cari])){$cari=$_POST[cari];}else{$cari=$_GET[cari];}

//mulai membuat FORM nya
 	echo "<h2>Data Airwaybill AWB/SMU</h2>
 		<form method=POST action='?module=carismu'>
		<table border=0 cellpadding=0 cellspacing=0 width=100%>
			<tr><td>
			PENCARIAN : <input name=cari type=text size=20 value='$_POST[cari]' autocomplete=off> 
			<input type=submit value=CARI> 11122223333 (tanpa tanda minus atau spasi,11digit!)</td></tr>
		</table>"; 
if(!empty($cari))//jika user melakukan pencarian
{
	$tampil=mysql_query("SELECT m.idmastersmu,m.nosmu,m.tglsmu,o.origin_code,d.dest_code,m.berat,m.koli,p.commodityap,a.agent 
	FROM master_smu as m,origin as o,destination as d,commodity_ap as p, agent as a
	WHERE m.idorigin=o.idorigin AND m.iddestination=d.iddestination AND m.idagent=a.idagent 
	AND m.idcommodityap=p.idcommodityap AND m.nosmu like '%$cari%' AND m.isvoid='0'
						order by m.nosmu ASC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT m.idmastersmu,m.nosmu,m.tglsmu,o.origin_code,d.dest_code,m.berat,m.koli FROM master_smu as m,origin as o,destination as d,commodity_ap as p WHERE m.idorigin=o.idorigin AND m.iddestination=d.iddestination AND m.idcommodityap=p.idcommodityap AND m.nosmu like '%$cari%' AND m.isvoid='0'"));

		
	$jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
	$linkHalaman  = $p->navHalaman($_GET[halaman], $jmlhalaman,'cari='.$cari);	
	echo "<p>$linkHalaman</p><table><tr>
		<th>AWB #</th><th>Date</th><th>Com</th><th>Org</th><th>Dest</th><th>Koli</th><th>KG</th><th>agent</th><th>status</th><th>action</th></tr>";
	while ($r=mysql_fetch_array($tampil))
	{
	$cekterbang = mysql_num_rows(mysql_query("select m.flightdate,m.acregister,f.flight
		from manifestout as m,isimanifestout as i,flight as f
		where m.idmanifestout=i.idmanifestout AND m.statuscancel='0' AND m.statusvoid='0' AND i.statuscancel='0' AND i.statusvoid='0'  
		AND m.idflight=f.idflight AND i.idmastersmu='$r[idmastersmu]' AND m.statusconfirm='1'"));
	
	

	echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>".format_awb($r[nosmu])."</td><td>".ymd2dmy($r[tglsmu])."</td><td>$r[commodityap]</td>
          	<td>$r[origin_code]</td><td>$r[dest_code]</td><td align=right>$r[koli]</td><td align=right>$r[berat]</td><td>$r[agent]</td>
			<td>";
		if($cekterbang>0) 
		{
			$data=mysql_fetch_array(mysql_query("select m.flightdate,m.acregister,f.flight
			from manifestout as m,isimanifestout as i,flight as f
			where m.idmanifestout=i.idmanifestout
			AND m.idflight=f.idflight AND i.idmastersmu='$r[idmastersmu]'")); 
			echo "Reg.$data[acregister] $data[flight] ".ymd2dmy($data[flightdate])."</td><td></td>";
		}
		else
		{
			echo "instore</td><td><a href=?act=edit_carismu&ids=$r[idmastersmu]>[EDIT]</a> | <a href=aksi.php?module=carismu&act=hapus&ids=$r[idmastersmu]>[DELETE]</a></td>";
		}		
			echo "</td></tr>";
     $no++;
  	}
  echo "</table><p>word '$cari' found : $jmldata rows</p></form>";
}
}
//-------------------------------- end of cari SMU -------------------------------------------
//-----------------Menampilkan Data AWB Today-------------------------------------------------
elseif (($_GET[module]=='awbtoday')AND($_SESSION[level]=='btb'))
{
$today=date('Y-m-d');
	$tampil=mysql_query("SELECT m.idmastersmu,m.nosmu,m.tglsmu,o.origin_code,d.dest_code,m.berat,m.koli,p.commodityap,
	m.consignee,m.shipper,a.agent 
	FROM master_smu as m,origin as o,destination as d,commodity_ap as p, agent as a
	WHERE m.idorigin=o.idorigin AND m.iddestination=d.iddestination AND m.idcommodityap=p.idcommodityap AND 
	m.idagent=a.idagent AND m.tglsmu='$today' AND m.isvoid='0' order by m.idmastersmu desc"); 

//mulai membuat FORM nya
 	echo "<h2>Data AWB Today</h2>
		<p><a href=?act=tambah_awbtoday>[TAMBAH DATA]</a></p>
		<table><tr>
		<th>AWB #</th><th>Date</th><th>Com</th><th>Org</th><th>Dest</th><th>Koli</th><th>KG</th>
		<th>Consignee</th><th>Shipper</th><th>Agent</th><th>status</th></tr>";
	while ($r=mysql_fetch_array($tampil))
	{
	$cekterbang = mysql_num_rows(mysql_query("select m.flightdate,m.acregister,f.flight
		from manifestout as m,isimanifestout as i,flight as f
		where m.idmanifestout=i.idmanifestout AND m.statuscancel='0' AND m.statusvoid='0' AND i.statuscancel='0' AND i.statusvoid='0'  
		AND m.idflight=f.idflight AND i.idmastersmu='$r[idmastersmu]' AND m.statusconfirm='1'"));
	

	echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>".format_awb($r[nosmu])."<td>".ymd2dmy($r[tglsmu])."</td><td>$r[commodityap]</td>
          	<td>$r[origin_code]</td><td>$r[dest_code]</td><td align=right>$r[koli]</td><td align=right>$r[berat]</td>
<td>$r[consignee]</td><td>$r[shipper]</td><td>$r[agent]</td>
			<td>";
		if($cekterbang>0) 
		{
			$data=mysql_fetch_array(mysql_query("select m.flightdate,m.acregister,f.flight
			from manifestout as m,isimanifestout as i,flight as f
			where m.idmanifestout=i.idmanifestout
			AND m.idflight=f.idflight AND i.idmastersmu='$r[idmastersmu]'")); 
			echo "Reg.$data[acregister] $data[flight] ".ymd2dmy($data[flightdate])."</td>";
		}
		else
		{
			echo "instore</td>";
		}		
			echo "</td></tr>";
     $no++;
  	}
  echo "</table>";
}
//---------------End of Menampilkan Data AWB Today-------------------------------------------------
//---------------Menambah Data AWB TODAY-----------------------------------------------------------
elseif (($_GET[act]=='tambah_awbtoday')AND($_SESSION[level]=='btb')){
?>
<SCRIPT LANGUAGE="JavaScript" src="cal2.js">
</script>
<script language="javascript">
    addCalendar("Caritanggalawal","Tanggal","tglawal","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
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
$tgl=date('Y-m-d');	
  echo "<h2>Tambah Air Way Bill (AWB)</h2>
        <form name=form1 method=POST action='aksi.php?module=awbtoday&act=tambah'> 
        <table>
			<tr><td>
			Date</td><td>: <input type=text name=tglawal value=".ymd2dmy($tgl).">"; 
				 ?>
  <a href="javascript:showCal('Caritanggalawal')"><img src="images/calendar.png" border="0"></a>
  <?			
			
        echo "</td><tr><td>AWB</td>     <td> : <input type=text name=requiredawb
		 onkeypress=\"return isNumberKey(event)\" autocomplete=off> * ex : 11122223333 (tanpa tanda minus atau spasi,11digit!)</td></tr>
        <tr><td>COMMODITY</td><td> : <select name=commodity>";
		$tampil=mysql_query("SELECT a.idcommodityap,a.commodityap,c.commodity FROM commodity_ap as a, 
		commodity as c WHERE a.idcommodity=c.idcommodity ORDER BY a.commodityap ASC");
        while($r=mysql_fetch_array($tampil))
		{
    	 echo "<option value='$r[idcommodityap]'>$r[commodityap] ($r[commodity])</option>";
		}
		echo "</select></td></tr>
        <tr><td>ORIGIN</td><td> : <select name=origin>";
		$tampil=mysql_query("SELECT o.idorigin,o.origin_code,r.region,r.dest_desc FROM 
		origin as o, region as r WHERE o.idregion=r.idregion order by o.origin_code ASC");
        while($r=mysql_fetch_array($tampil))
		{
			if($r[origin_code]=='DPS')
			{
				echo "<option value='$r[idorigin]' selected>$r[origin_code] / Region : $r[region] ($r[dest_desc])</option>";
				}
				else
				{
    	 echo "<option value='$r[idorigin]'>$r[origin_code] / Region : $r[region] ($r[dest_desc])</option>";
		} 
		}
		echo "</select></td></tr>
        <tr><td>DESTINATION</td><td> : <select name=destination>";
		$tampil=mysql_query("SELECT d.iddestination,d.dest_code,r.region,r.dest_desc FROM 
		destination as d, region as r WHERE d.idregion=r.idregion order by d.dest_code ASC");
        while($r=mysql_fetch_array($tampil))
		{
    	 echo "<option value='$r[iddestination]'>$r[dest_code] / Region : $r[region] ($r[dest_desc])</option>";
		}
		echo "</select></td></tr>	
        <tr><td>Collies</td>     <td> : <input type=text size=5 name=requiredkoli
		 onkeypress=\"return isNumberKey(event)\"
		autocomplete=off> *		

        <tr><td>Weight (Kg)</td>     <td> : <input type=text size=5 name=requiredkg
		 onkeypress=\"return isNumberKey(event)\" autocomplete=off> *
        <tr><td>Consignee</td>     <td> : <input type=text size=50 name=consignee autocomplete=off>
        <tr><td>Shipper</td>     <td> : <input type=text size=50 name=shipper autocomplete=off>	
        <tr><td>AGENT</td><td> : <select name=agent>
		<option value='15'>none</option>";
		$tampil=mysql_query("SELECT * FROM agent ORDER BY agent ASC");
        while($r=mysql_fetch_array($tampil))
		{
    	 echo "<option value='$r[idagent]'>$r[agent]</option>";
		}
		echo "</select></td></tr>								
		<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, 
		tidak akan tersimpan.</td></tr> 
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
		
        </table>
        </form>";
		?>
		<script language="JavaScript" type="text/javascript">
  var frmvalidator  = new Validator("form1");
  frmvalidator.addValidation("requiredawb","req","Nomor AWB tidak boleh kosong!");  
  frmvalidator.addValidation("requiredawb","minlen=11","Penomoran AWB 11 Digits!");
  frmvalidator.addValidation("requiredawb","maxlen=11","Penomoran AWB 11 Digits!");
 frmvalidator.addValidation("requiredawb","numeric","Nomor AWB hanya boleh diisi angka!");

  frmvalidator.addValidation("requiredkoli","req","Jumlah Koli AWB tidak boleh kosong!");  
  frmvalidator.addValidation("requiredkoli","dec","Jumlah Koli AWB hanya boleh diisi angka!");
  frmvalidator.addValidation("requiredkg","req","Berat AWB tidak boleh kosong!");  
  frmvalidator.addValidation("requiredkg","dec","Berat AWB hanya boleh diisi angka!");  
 </script>
<?
}
//---------------End of Menambah Data AWB TODAY-----------------------------------------------------------
//---------------MENGEDIT AWB-----------------------------------------------------------
elseif (($_GET[act]=='edit_carismu')AND($_SESSION[level]=='btb')){
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
$tgl=date('Y-m-d');	
$sql=mysql_fetch_array(mysql_query("select * from master_smu where idmastersmu='$_GET[ids]'"));
  echo "<h2>Editing Air Way Bill (AWB)</h2>
        <form name=form1 method=POST action='aksi.php?module=awbtoday&act=edit' 
		onSubmit=\"return checkrequired(this)\">
        <table>
        <tr><td>AWB</td>     <td> : <input type=text name=requiredawb 
 onkeypress=\"return isNumberKey(event)\" autocomplete=off value='$sql[nosmu]'> * ex : 11122223333 (tanpa tanda minus atau spasi, 11 digit!)</td></tr>
        <tr><td>COMMODITY</td><td> : <select name=commodity>";
		$tampil=mysql_query("SELECT a.idcommodityap,a.commodityap,c.commodity FROM commodity_ap as a, 
		commodity as c WHERE a.idcommodity=c.idcommodity ORDER BY a.commodityap ASC");
        while($r=mysql_fetch_array($tampil))
		{
			if($sql[idcommodityap]==$r[idcommodityap])
			{
				echo "<option value='$r[idcommodityap]' selected>$r[commodityap] ($r[commodity])</option>";
			}
			else
			{
				echo "<option value='$r[idcommodityap]'>$r[commodityap] ($r[commodity])</option>";
			}
		 }
		echo "</select></td></tr>
        <tr><td>ORIGIN</td><td> : <select name=origin>";
		$tampil=mysql_query("SELECT o.idorigin,o.origin_code,r.region,r.dest_desc FROM 
		origin as o, region as r WHERE o.idregion=r.idregion order by o.origin_code ASC");
        while($r=mysql_fetch_array($tampil))
		{
			if($sql[idorigin]==$r[idorigin])
			{
				echo "<option value='$r[idorigin]' selected>$r[origin_code] / Region : $r[region] ($r[dest_desc])</option>";
			}
			else
			{
				echo "<option value='$r[idorigin]'>$r[origin_code] / Region : $r[region] ($r[dest_desc])</option>";
			}			
    	 
		}
		echo "</select></td></tr>
        <tr><td>DESTINATION</td><td> : <select name=destination>";
		$tampil=mysql_query("SELECT d.iddestination,d.dest_code,r.region,r.dest_desc FROM 
		destination as d, region as r WHERE d.idregion=r.idregion order by d.dest_code ASC");
        while($r=mysql_fetch_array($tampil))
		{
			if($sql[iddestination]==$r[iddestination])
			{
				echo "<option value='$r[iddestination]' selected>$r[dest_code] / Region : $r[region] ($r[dest_desc])</option>";
			}
			else
			{
				echo "<option value='$r[iddestination]'>$r[dest_code] / Region : $r[region] ($r[dest_desc])</option>";
			}					
    	 
		}
		echo "</select></td></tr>	
        <tr><td>Weight (Kg)</td>     <td> : <input type=text size=5 name=requiredkg
		 onkeypress=\"return isNumberKey(event)\" autocomplete=off value=$sql[berat]> *
        <tr><td>Collies</td>     <td> : <input type=text size=5 name=requiredkoli
		 onkeypress=\"return isNumberKey(event)\"
		autocomplete=off value=$sql[koli]> *		
        <tr><td>Consignee</td>     <td> : <input type=text size=50 name=consignee autocomplete=off value=$sql[consignee]>
        <tr><td>Shipper</td>     <td> : <input type=text size=50 name=shipper autocomplete=off value=$sql[shipper]>	
        <tr><td>AGENT</td><td> : <select name=agent>
		<option value='15'>none</option>";
		$tampil=mysql_query("SELECT * FROM agent ORDER BY agent ASC");
        while($r=mysql_fetch_array($tampil))
		{
			if($sql[idagent]==$r[idagent])
			{
			echo "<option value='$r[idagent]' selected>$r[agent]</option>";
			}
			else
			{
			echo "<option value='$r[idagent]' >$r[agent]</option>";
			}
		}
		echo "</select></td></tr>								
		<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, 
		tidak akan tersimpan.</td></tr> 
				<input type=hidden name=tglsmu value=$tgl>
				<input type=hidden name=ids value=$sql[idmastersmu]>
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
		
        </table>
        </form>";
		?>
		<script language="JavaScript" type="text/javascript">
  var frmvalidator  = new Validator("form1");
  frmvalidator.addValidation("requiredawb","req","Nomor AWB tidak boleh kosong!");  
  frmvalidator.addValidation("requiredawb","minlen=11","Penomoran AWB 11 Digits!");
  frmvalidator.addValidation("requiredawb","maxlen=11","Penomoran AWB 11 Digits!");
 frmvalidator.addValidation("requiredawb","numeric","Nomor AWB hanya boleh diisi angka!");

  frmvalidator.addValidation("requiredkoli","req","Jumlah Koli AWB tidak boleh kosong!");  
  frmvalidator.addValidation("requiredkoli","dec","Jumlah Koli AWB hanya boleh diisi angka!");
  frmvalidator.addValidation("requiredkg","req","Berat AWB tidak boleh kosong!");  
  frmvalidator.addValidation("requiredkg","dec","Berat AWB hanya boleh diisi angka!");  
  

</script>		
<?
}
//---------------End of MENGEDIT SMU-----------------------------------------------------------

//************************************** END OF BTB ******************************************************

//**************************************** START OF EXPORT ***********************************************
//---------------Menampilkan Isi Data Manifest Export-------------------------------------------------
//---------------Menampilkan Data SMU-------------------------------------------------
elseif (($_GET[module]=='carismu')AND($_SESSION[level]=='export'))
{
	$p      = new Paging;
	$batas  =10;
	$posisi = $p->cariPosisi($batas);
    $no     = $posisi+1;
	

if(!empty($_POST[cari])){$cari=$_POST[cari];}else{$cari=$_GET[cari];}

//mulai membuat FORM nya
 	echo "<h2>Data Airwaybill AWB/SMU</h2>
 		<form method=POST action='?module=carismu'>
		<table border=0 cellpadding=0 cellspacing=0 width=100%>
			<tr><td>
			PENCARIAN : <input name=cari type=text size=20 value='$_POST[cari]' autocomplete=off> 
			<input type=submit value=CARI></td></tr>
		</table>"; 
if(!empty($cari))//jika user melakukan pencarian
{
$tampil=mysql_query("
SELECT i.berat,i.koli,m.acregister,m.flightdate,f.flight
FROM isimanifestout as i,master_smu as s,manifestout as m, flight as f,origin as o, destination as d,commodity_ap as c,agent as a
WHERE i.idmastersmu=s.idmastersmu AND i.idmanifestout=m.idmanifestout AND s.nosmu='$cari' AND i.statusvoid='0' AND i.statuscancel='0' AND m.statusvoid='0' AND m.statusconfirm='1' AND m.idflight=f.idflight AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND s.idcommodityap=c.idcommodityap AND s.idagent=a.idagent
");
$tampil1=mysql_query("
SELECT s.nosmu,s.tglsmu,s.berat as brt,s.koli as kl,o.origin_code,d.dest_code,c.commodityap,a.agent 
FROM master_smu as s,origin as o, destination as d,commodity_ap as c,agent as a
WHERE s.nosmu ='$cari' AND s.idorigin=o.idorigin AND s.iddestination=d.iddestination AND s.idcommodityap=c.idcommodityap AND s.idagent=a.idagent
");

	echo "<table><tr>
		<th>#AWB / Date</th><th>Qty</th><th>Com</th><th>Org</th><th>Dest</th><th>agent</th></tr>";
	$b=0;$k=0;
	while ($r=mysql_fetch_array($tampil1))
	{
	echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>".format_awb($r[nosmu])." / ".ymd2dmy($r[tglsmu])."</td><td>$r[kl] koli $r[brt] kg</td><td>$r[commodityap]</td>
          	<td>$r[origin_code]</td><td>$r[dest_code]</td><td>$r[agent]</td>";
     $no++;
	 $b+=$r[brt];$k+=$r[kl];
  	}
	$no=1;
  echo "</table>
<table><tr><th colspan=4>Histories : </th></tr>
		<th>no</th><th>A/C Reg</th><th>Flight / Date</th><th>Qty</th></tr>";
	while ($r=mysql_fetch_array($tampil))
	{
	echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>$no</td><td>$r[acregister]</td><td>$r[flight] / ".ymd2dmy($r[flightdate])."</td><td>$r[koli] koli $r[berat] kg</td>";
     $no++;
	$b-=$r[berat];$k-=$r[koli]; 
  	}
  echo "</table>
<p>Instore : $k koli $b kg</p>


</form>";
}
}
//-------------------------------- end of cari SMU -------------------------------------------
//Melihat data isi manifest export------------------
elseif (($_GET[module]=='isimanifestexport')AND($_SESSION[level]=='export'))
{
?>
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

    if($con[statusconfirm]=='0')
	{
	echo "<a href=\"?act=tambah_isimanifestexport&idm=$_GET[idm]&r=$_GET[r]&f=$_GET[f]&d=$_GET[d]\">[TAMBAH AWB]</a>";	
	}
	echo "<a href=?module=carimanifestexport&idm=$_GET[idm]&d=$dt>[KEMBALI]</a></p>";
	
	$daftaruld=mysql_query("SELECT i.nould FROM 
	isimanifestout as i,manifestout as m, master_smu as s 
	WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0'
	 AND m.idmanifestout='$_GET[idm]' GROUP BY i.nould order by nould ASC"); 
	

//mulai membuat FORM nya
 	
	while ($pp=mysql_fetch_array($daftaruld))
	{
	$no=1;
	echo "<p>".format_uld($pp[nould])."</p>";
	
			$tampil=mysql_query("SELECT i.idisimanifestout,i.idmanifestout,i.idmastersmu,i.nould,i.berat,i.koli,i.statusconfirm, s.nosmu FROM 
	isimanifestout as i,manifestout as m, master_smu as s 
	WHERE i.idmanifestout = m.idmanifestout AND i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND i.statuscancel='0'
	 AND m.idmanifestout='$_GET[idm]' AND i.nould='$pp[0]' order by nould ASC"); 
echo "<table><tr>
		<th>No</th>
		<th>AWB#</th>
		<th>KOLI</th>
		<th>KG</th>
		<th>ACTION</th>
		</tr>";	

	while ($r=mysql_fetch_array($tampil))
	{
		

	echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>$no</td><td>".format_awb($r[nosmu])."</td><td align=right>$r[koli]</td><td align=right>$r[berat]</td>";
		if($con[statusconfirm])
		{
		  echo "<td></td></tr>";
		}
		else
		{
		  echo "<td>
<a href=\"aksi.php?module=isimanifestexport&act=hapus&idm=$_GET[idm]&r=$_GET[r]&f=$_GET[f]&d=$_GET[d]&idi=$r[idisimanifestout]\" 
		  onclick=\"javascript:return confirm('cancel AWB ini ?')\" >[CANCEL]</a></td></tr>";		
		}
     $no++;
  	}
	echo "</table>";
	}
  //echo "</table>";
}
//-------------------------------- end of ISi Manifest Export -------------------------------------------

//---------------Menambah Data Isi Manifest Export-----------------------------------------------------------
elseif (($_GET[act]=='tambah_isimanifestexport')AND($_SESSION[level]=='export')){
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

	//Allow only alphabetical input, decimal point, backspace
	function isNumber(evt)
	{
		var myValidChars = new Array(0,8,46,48,49,50,51,52,53,54,55,56,57,190);
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode in oc(myValidChars))
		return true;
		return false;
	}	

	//Allow only alphabetical input, decimal point, backspace
	function iscek(evt)
	{
		var myValidChars = new Array(0,8,46,48,49,50,51,52,53,54,55,56,57,190,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122);
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode in oc(myValidChars))
		return true;
		return false;
	}
	
</SCRIPT>
<?
$data0=mysql_fetch_array(mysql_query("SELECT berat,koli FROM master_smu where 
idmastersmu='$_GET[ids]' and isvoid='0'"));
$data1=mysql_fetch_array(mysql_query("SELECT SUM(berat) as berat,SUM(koli) as koli FROM isimanifestout where idmastersmu='$_GET[ids]' and statusvoid='0' and statuscancel='0' GROUP BY idmastersmu"));
$berat=$data0[berat]-$data1[berat];
$koli=$data0[koli]-$data1[koli];

$tgl=date('Y-m-d');	
  echo "<h2>Tambah Isi Manifest Export -> A/C Reg.$_GET[r] Flight $_GET[f] $_GET[d]</h2>
        <form name=form1 method=POST action='aksi.php?module=isimanifestexport&act=tambah' 
		onSubmit=\"return checkrequired(this)\">
		<input type=hidden name=idm value='$_GET[idm]'>
		<input type=hidden name=r value='$_GET[r]'>
		<input type=hidden name=f value='$_GET[f]'>
		<input type=hidden name=d value='$_GET[d]'>	
		<input type=hidden name=ids value='$_GET[ids]'>
		<input type=hidden name=brt value='$berat'>
		<input type=hidden name=kl value='$koli'>	
        <table>
        <tr><td>AWB</td>     <td> : <input type=text size=20 name=requiredawb 
		 autocomplete=off value='$_GET[awb]'> 
		<input type=submit value=CHECK name=tombolcek></td></tr>
        <tr><td>KG</td>     <td> : <input type=text size=5 name=kg onkeypress=\"return isNumberKey(event)\"
		autocomplete=off value=$berat> *</td></tr>
        <tr><td>KOLI</td>     <td> : <input type=text size=5 name=koli onkeypress=\"return isNumberKey(event)\"
		autocomplete=off value=$koli> *</td></tr>
        <tr><td>ULD</td>     <td> : <input type=text size=20 onChange=\"javascript:this.value=this.value.toUpperCase();\"  
		name=uld onkeypress=\"return iscek(event)\" autocomplete=off value=$_GET[olduld]> * ex : AKE12345678GA (tanpa tanda minus atau spasi)</td></tr>		
		<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, 
		tidak akan tersimpan.
		</td></tr> 
        <tr><td colspan=2><input type=submit value=Simpan name=tombolkirim>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>
		<p>
		<a href=\"?module=isimanifestexport&idm=$_GET[idm]&r=$_GET[r]&f=$_GET[f]&d=$_GET[d]\">[KEMBALI]</a> ";
?>		<script language="JavaScript" type="text/javascript">
  var frmvalidator  = new Validator("form1");
  frmvalidator.addValidation("requiredawb","req","Nomor AWB tidak boleh kosong!");  
  frmvalidator.addValidation("requiredawb","minlen=11","Penomoran AWB 11 Digits!");
  frmvalidator.addValidation("requiredawb","maxlen=11","Penomoran AWB 11 Digits!");
 frmvalidator.addValidation("requiredawb","numeric","Nomor AWB hanya boleh diisi angka!");

  frmvalidator.addValidation("koli","req","Jumlah Koli AWB tidak boleh kosong!");  
  frmvalidator.addValidation("koli","dec","Jumlah Koli AWB hanya boleh diisi angka!");
  frmvalidator.addValidation("kg","req","Berat AWB tidak boleh kosong!");  
  frmvalidator.addValidation("kg","dec","Berat AWB hanya boleh diisi angka!");  

 </script>
 <?
if($_GET[e]=='1')
{
 echo " No. Air Way Bill (AWB) Tidak Ditemukan !</p>";
}
else if($_GET[e]=='2')
{
 echo " Maaf, Kg dan Koli Melebihi AWB, Silahkan ketik ulang !</p>";
}
		
}
//---------------End of Menambah Data Isi Manifest Export-----------------------------------------------------------

//--------------Menambah Berat ULD
elseif (($_GET[module]=='beratuld')AND($_SESSION[level]=='export'))
{?>
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
$uld_data=mysql_query("select idberauld,uld,sum(berat) as berat from beratuld where idmanifestout='$_GET[idm]' GROUP BY uld");
 	echo "<h2>Daftar Berat ULD untuk Manifest A/C Reg.".$_GET[red]." : ".$_GET[f].
		" Flight Date ".ymd2dmy($_GET[d])."</h2>
 		<form name=form1 method=POST action='aksi.php?module=beratuld&act=update'>
		<table border=0 cellpadding=0 cellspacing=0>
		<tr><th>No</th><th>No uld</th><th>kg</th></tr>";
		$no=1;
		while($r=mysql_fetch_array($uld_data))
		{
			echo "<tr><td>$no</td><td>$r[uld]</td><td>: <input type=text name=berat[] size=5 value=".number_format($r[berat], 1, ',', '.')." onkeypress=\"return isNumberKey(event)\"></td></tr>
<input type=hidden name=idb[] value=$r[idberauld]>
<input type=hidden name=d value=\"$_GET[d]\">
<input type=hidden name=uld[] value=\"$r[uld]\">";
			$no++;
			
		}
		echo "<tr><td colspan=3><input type=submit value=UPDATE></td></tr></form>
<p><a href=\"?module=carimanifestexport&d=$_GET[d]\">[KEMBALI]</p>";
	}	
//-------------------------------------------

//---------------Menampilkan Data Manifest Export-------------------------------------------------
elseif (($_GET[module]=='carimanifestexport')AND($_SESSION[level]=='export'))
{
?>
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
		</table>
<p><a href=?act=tambah_manifestexport>[TAMBAH DATA]</a>
</p>"; 
				
if($_GET[d]!=''){$dt=$_GET[d];}
else {$dt=my2date($_POST[tglawal]);}
		
$tdy=ymd2dmy($today);
$tampil=mysql_query("SELECT m.idmanifestout,m.acregister,m.flightdate,m.pointofloading,m.pointul,m.statusnil,
	f.flight,o.origin_code, d.dest_code,m.iddestination2,m.statusconfirm,m.statuscancel,c.bendera,c.cus_desc
	FROM manifestout as m,origin as o,destination as d,flight as f, customer as c
	WHERE m.idorigin=o.idorigin AND m.iddestination=d.iddestination AND m.idflight=f.idflight AND m.statusvoid='0' AND 
	f.idcustomer=c.idcustomer AND m.flightdate='$dt' order by f.flight asc"); 

//mulai membuat FORM nya
 	echo "<table><tr>
		<th>A/C Reg.</th>
		<th>Flight Date</th>
		<th>Flight</th>
		<th>Org</th 
		<th>Dest</th>
		<th>Koli / Kg</th>
		<th>status</th>
		<th>action</th><th>cetak manifest</th>
<th>handover</th>
<th>delivery</th>
		</tr>";
	while ($r=mysql_fetch_array($tampil))
	{
		$cekbrt=mysql_fetch_array(mysql_query("select sum(i.koli) as koli,sum(i.berat) as berat 
						from manifestout as m, isimanifestout as i 
						where i.idmanifestout=m.idmanifestout AND i.statusvoid='0' 
						AND i.idmanifestout=$r[idmanifestout]"));
		if($cekbrt[koli]==''){$koli=0;} else $koli=$cekbrt[koli];
		if($cekbrt[berat]==''){$berat=0;} else $berat=$cekbrt[berat];
	$des2=mysql_fetch_array(mysql_query("SELECT dest_code from destination 
	where iddestination=$r[iddestination2]"));	
		
if($r[statusnil]=='on'){$n='nil';
	echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>$r[acregister]</td>";}
else {$n="$koli / $berat";
	echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td><a href=\"?module=isimanifestexport&idm=$r[idmanifestout]&r=$r[acregister]&f=$r[flight]&d=".ymd2dmy($r[flightdate])."\">$r[acregister]</a></td>";		}
	echo "<td width=10>".ymd2dmy($r[flightdate])."</td><td>$r[flight]</td>
          	<td>$r[origin_code]</td><td>$r[dest_code] $des2[0]</td><td align=right>$n</td>
			<td>";
			if(($r[statusconfirm]=='1') AND ($r[statuscancel]=='0'))
			 {
			  echo "OUT</td><td></td><td><a href=aksi.php?module=cetakmanifestout&idm=$r[idmanifestout]&s=0>[NORMAL]</a>
<a href=aksi.php?module=cetakmanifestout&idm=$r[idmanifestout]&s=1>[SPLIT]</a></td><td align=center><a href=aksi.php?module=cetakhandoverexport&idm=$r[idmanifestout]>[CETAK]</a></td><td align=center><a href=aksi.php?module=cetakdeliverycargo&idm=$r[idmanifestout]&s=0>[CETAK]</a></td>";
			 }
			else if($r[statuscancel]=='1')
			 {
			  echo "CANCEL</td><td></td><td></td><td></td>";
			 }
			 else
			 {
			  echo "</td><td><a href=aksi.php?module=carimanifestexport&act=confirm&idm=$r[idmanifestout]&d=$dt 
		  onclick=\"javascript:return confirm('CONFIRM MANIFEST INI ?')\">[CONFIRM]</a>  
<a href=?act=edit_carimanifestexport&idm=$r[idmanifestout]&d=$dt 
		  >[EDIT]</a>";
		if($koli<>'0'){ echo " 
<a href=\"?module=beratuld&idm=$r[idmanifestout]&d=$dt&red=$r[acregister]&f=$r[flight] 
		  \">[KG ULD]</a>";}
		echo "  </td><td><a href=aksi.php?module=cetakmanifestout&idm=$r[idmanifestout]&s=0>[NORMAL]</a>
<a href=aksi.php?module=cetakmanifestout&idm=$r[idmanifestout]&s=1>[SPLIT]</a></td><td></td><td></td>";
			 }
			echo "
	</tr>";
     $no++;
  	}
  echo "</table>";
}
//-------------------------------- end of cari Manifest Export -------------------------------------------
//-----------------MenampilkanData Manifest Export Today-------------------------------------------------
elseif (($_GET[module]=='manifestexport_today')AND($_SESSION[level]=='export'))
{
$today=date('Y-m-d');


if($_GET[d]!=''){$tdy=$_GET[d];}
else {$tdy=ymd2dmy($today);}

	$tampil=mysql_query("SELECT m.idmanifestout,m.acregister,m.flightdate,m.pointofloading,m.pointul,m.statusnil,
	f.flight,o.origin_code, d.dest_code,m.iddestination2,m.statusconfirm,m.statuscancel,c.bendera,c.cus_desc
	FROM manifestout as m,origin as o,destination as d,flight as f, customer as c
	WHERE m.idorigin=o.idorigin AND m.iddestination=d.iddestination AND m.idflight=f.idflight AND m.statusvoid='0' AND 
	f.idcustomer=c.idcustomer AND m.flightdate='$today' order by m.idmanifestout desc"); 


//mulai membuat FORM nya
 	echo "<h2>Data Manifest Export Today : $tdy</h2>
		<p><a href=?act=tambah_manifestexport>[TAMBAH DATA]</a></p>
		<table><tr>
		<th>A/C Reg.</th>
		<th>Flight Date</th>
		<th>Flight</th>
		<th>Org</th>
		<th>Dest</th>
		<th>Point LO</th>
		<th>Point U/L</th><th>NIL ?</th>
		<th>status</th><th>action</th>
		</tr>";
	while ($r=mysql_fetch_array($tampil))
	{
if($r[statusnil]=='on'){$n='nil';}else {$n='';}

	$des2=mysql_fetch_array(mysql_query("SELECT dest_code from destination 
	where iddestination=$r[iddestination2]"));	
	
	echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td><a href=?module=isimanifestexport&idm=$r[idmanifestout]&r=$r[acregister]&f=$r[flight]&d=".ymd2dmy($r[flightdate]).">$r[acregister]</a></td><td>".ymd2dmy($r[flightdate])."</td><td>$r[flight]</td>
          	<td>$r[origin_code]</td><td>$r[dest_code]  $des2[0]</td><td>$r[pointofloading]</td><td>$r[pointul]</td><td>$n</td>
			<td>";
			if(($r[statusconfirm]=='1') AND ($r[statuscancel]=='0'))
			 {
			  echo "OUT</td><td></td>";
			 }
			else if($r[statuscancel]=='1')
			 {
			  echo "CANCEL</td><td></td>";
			 }
			 else
			 {
			  echo "INSTORE</td><td><a href=aksi.php?module=carimanifestexport&act=confirm&idm=$r[idmanifestout]&d=$tdy 
		  onclick=\"javascript:return confirm('CONFIRM MANIFEST INI ?')\">[CONFIRM]</a></td>";
			 }
			echo "</td></tr>";
     $no++;
  	}
  echo "</table>";
}
//---------------End of MenampilkanData Manifest Export Today-------------------------------------------------

//---------------Menambah Data Manifest Export-----------------------------------------------------------
elseif (($_GET[act]=='tambah_manifestexport')AND($_SESSION[level]=='export')){
?>
<SCRIPT LANGUAGE="JavaScript" src="cal2.js">
</script>
<script language="javascript">
    addCalendar("Caritanggalawal","Tanggal","tglawal","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
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
$tgl=date('Y-m-d');	
  echo "<h2>Tambah Manifest Export</h2>
        <form name=form1 method=POST action='aksi.php?module=manifestexport&act=tambah' 
		onSubmit=\"return checkrequired(this)\">
        <table>
		<tr><td>FLIGHT DATE</td>
		<td>: <input type=text onKeyDown=\"javascript:return dFilter (event.keyCode, this,'##-##-####');\" name=tglawal value=".ymd2dmy($tgl).">"; 
				 ?>
  <a href="javascript:showCal('Caritanggalawal')"><img src="images/calendar.png" border="0"></a>
  <?
	echo "</td></tr>
		<tr><td>ETD</td>
		<td>: <input type=text onKeyDown=\"javascript:return dFilter (event.keyCode, this,'##:##:##');\" name=etd value='00:00:00'> (hours:minutes:second)</td></tr> 
        <tr><td>FLIGHT NUMBER</td><td> : <select name=flight>";
		$tampil=mysql_query("SELECT f.idflight,f.flight,c.cus_desc,c.bendera FROM flight as f,customer as c 
		WHERE f.idcustomer = c.idcustomer order by flight");
        while($r=mysql_fetch_array($tampil))
		{
			if($r[flight] == 'GA343')
			{
				    	 echo "<option value=$r[idflight] selected>$r[flight]-$r[cus_desc] / Bendera : $r[bendera]</option>";
				}else
				{
					
    	 echo "<option value=$r[idflight]>$r[flight]-$r[cus_desc] / Bendera : $r[bendera]</option>";
		}
		}
		echo "</select></td></tr>
        <tr><td>ORIGIN</td><td> : <select name=origin>";
		$tampil=mysql_query("SELECT o.idorigin,o.origin_code,r.region,r.dest_desc FROM 
		origin as o, region as r WHERE o.idregion=r.idregion order by o.origin_code ASC");
        while($r=mysql_fetch_array($tampil))
		{
			if($r[origin_code]=='DPS')
			{
				echo "<option value='$r[idorigin]' selected>$r[origin_code] / Region : $r[region] 
				($r[dest_desc])</option>";
			}
			else
			{
				echo "<option value='$r[idorigin]'>$r[origin_code] / Region : $r[region] 
				($r[dest_desc])</option>";
			}
			
		}
		echo "</select></td></tr>
        <tr><td>DESTINATION 1</td><td> : <select name=destination>";
		$tampil=mysql_query("SELECT d.iddestination,d.dest_code,r.region,r.dest_desc FROM 
		destination as d, region as r WHERE d.idregion=r.idregion order by d.dest_code ASC");
        while($r=mysql_fetch_array($tampil))
		{
    	 echo "<option value='$r[iddestination]'>$r[dest_code] / Region : $r[region] ($r[dest_desc])</option>";
		}
		echo "</select></td></tr>	
        <tr><td>DESTINATION 2</td><td> : <select name=destination2>
		<option value='0'>none</option>";
		$tampil=mysql_query("SELECT d.iddestination,d.dest_code,r.region,r.dest_desc FROM 
		destination as d, region as r WHERE d.idregion=r.idregion order by d.dest_code ASC");
        while($r=mysql_fetch_array($tampil))
		{
    	 echo "<option value='$r[iddestination]'>$r[dest_code] / Region : $r[region] ($r[dest_desc])</option>";
		}
		echo "</select></td></tr>	
        <tr><td>A/C REGISTER</td>     <td> : <input type=text size=5 name=requiredacregister 
		onChange=\"javascript:this.value=this.value.toUpperCase();\" autocomplete=off> *</td></tr>
        <tr><td>POINT OF LOADING</td>     <td> : <input type=text size=20 name=requiredpointofloading value='DENPASAR' onChange=\"javascript:this.value=this.value.toUpperCase();\"  
		autocomplete=off> *</td></tr>
        <tr><td>POINT U/L</td>     <td> : <input type=text size=20 name=requiredpointul  value='AS BELOW' onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		autocomplete=off> *</td></tr>
        <tr><td>Status NIL</td>     <td> : <input type=checkbox size=5 name=statusnil autocomplete=off></td></tr>		
		<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, 
		tidak akan tersimpan.</td></tr> 
        <tr><td colspan=2>
		<input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
		
        </table>
        </form>";
}
//---------------End of Menambah Data Manifest Export-----------------------------------------------------------
//---------------Mengedit Data Manifest Export-----------------------------------------------------------
elseif (($_GET[act]=='edit_carimanifestexport')AND($_SESSION[level]=='export')){
?>
<SCRIPT LANGUAGE="JavaScript" src="cal2.js">
</script>
<script language="javascript">
    addCalendar("Caritanggalawal","Tanggal","tglawal","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
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
$tgl=date('Y-m-d');	
$cekadasmu=mysql_num_rows(mysql_query("
select i.idmastersmu from manifestout as m, isimanifestout as i 
WHERE i.idmanifestout=m.idmanifestout AND m.statusvoid='0' AND i.statusvoid='0' AND m.idmanifestout='$_GET[idm]'"));

$sql=mysql_fetch_array(mysql_query("select * from manifestout where idmanifestout='$_GET[idm]'"));
  echo "<h2>Editing Manifest Export</h2>
        <form name=form1 method=POST action='aksi.php?module=manifestexport&act=edit' 
		onSubmit=\"return checkrequired(this)\">
        <table>
		<tr><td>FLIGHT DATE</td>
		<td>: <input type=text onKeyDown=\"javascript:return dFilter (event.keyCode, this,'##-##-####');\" name=tglawal value=".ymd2dmy($sql[flightdate]).">"; 
				 ?>
  <a href="javascript:showCal('Caritanggalawal')"><img src="images/calendar.png" border="0"></a>
  <?
	echo "</td></tr>
		<tr><td>ETD</td>
		<td>: <input type=text onKeyDown=\"javascript:return dFilter (event.keyCode, this,'##:##:##');\" name=etd value=$sql[etd]> (hours:minutes:second)</td></tr> 
        <tr><td>FLIGHT NUMBER</td><td> : <select name=flight>";
		$tampil=mysql_query("SELECT f.idflight,f.flight,c.cus_desc,c.bendera FROM flight as f,customer as c 
		WHERE f.idcustomer = c.idcustomer order by f.flight ASC");
        while($r=mysql_fetch_array($tampil))
		{
			if($r[idflight]==$sql[idflight])
			{
				echo "<option value=$r[idflight] selected>$r[flight]-$r[cus_desc] 
				/ Bendera : $r[bendera]</option>";
			}
			else
			{
				echo "<option value=$r[idflight]>$r[flight]-$r[cus_desc] 
				/ Bendera : $r[bendera]</option>";				
			}
		}
		echo "</select></td></tr>
        <tr><td>ORIGIN</td><td> : <select name=origin>";
		$tampil=mysql_query("SELECT o.idorigin,o.origin_code,r.region,r.dest_desc FROM 
		origin as o, region as r WHERE o.idregion=r.idregion order by o.origin_code ASC");
        while($r=mysql_fetch_array($tampil))
		{
			if($r[idorigin]==$sql[idorigin])
			{
				echo "<option value='$r[idorigin]' selected>$r[origin_code] 
				/ Region : $r[region] ($r[dest_desc])</option>";
			}
			else
			{
				echo "<option value='$r[idorigin]'>$r[origin_code] / Region : $r[region] ($r[dest_desc])</option>";
			}
    	 
		}
		echo "</select></td></tr>
        <tr><td>DESTINATION 1</td><td> : <select name=destination>";
		$tampil=mysql_query("SELECT d.iddestination,d.dest_code,r.region,r.dest_desc FROM 
		destination as d, region as r WHERE d.idregion=r.idregion order by d.dest_code ASC");
        while($r=mysql_fetch_array($tampil))
		{
			if($r[iddestination]==$sql[iddestination])
			{
			echo "<option value='$r[iddestination]' selected>$r[dest_code] 
				/ Region : $r[region] ($r[dest_desc])</option>";
			}
			else
			{
				echo "<option value='$r[iddestination]'>$r[dest_code] 
				/ Region : $r[region] ($r[dest_desc])</option>";			}			

		}
		echo "</select></td></tr>	
        <tr><td>DESTINATION 2</td><td> : <select name=destination2>";
		$tampil=mysql_query("SELECT d.iddestination,d.dest_code,r.region,r.dest_desc FROM 
		destination as d, region as r WHERE d.idregion=r.idregion order by d.dest_code ASC");
		if($sql[iddestination2]=='0')
		{
							echo "<option value=0 selected>none</option>";	
			while($r=mysql_fetch_array($tampil))
			{
				echo "<option value='$r[iddestination]'>$r[dest_code] 
				/ Region : $r[region] ($r[dest_desc])</option>";
			}
		}
		else
		{
			echo "<option value=0>none</option>";	
        while($r=mysql_fetch_array($tampil))
		{
			if($r[iddestination]==$sql[iddestination2])
			{
			echo "<option value='$r[iddestination]' selected>$r[dest_code] 
				/ Region : $r[region] ($r[dest_desc])</option>";
			}
			else
			{
				echo "<option value='$r[iddestination]'>$r[dest_code] 
				/ Region : $r[region] ($r[dest_desc])</option>";
			}			
		}
		}
		echo "</select></td></tr>	
        <tr><td>A/C REGISTER</td>     <td> : <input type=text size=5 name=requiredacregister 
		onChange=\"javascript:this.value=this.value.toUpperCase();\" autocomplete=off value=\"$sql[acregister]\"> *</td></tr>
        <tr><td>POINT OF LOADING</td>     <td> : <input type=text size=20 name=requiredpointofloading value=\"$sql[pointofloading]\" onChange=\"javascript:this.value=this.value.toUpperCase();\" autocomplete=off> *</td></tr>
        <tr><td>POINT U/L</td>     <td> : <input type=text size=20 name=requiredpointul  value=\"$sql[pointul]\" onChange=\"javascript:this.value=this.value.toUpperCase();\" autocomplete=off> *</td></tr>";
		//cek, kalau sdh ada smu didalamnya,tida boleh nil !
		if($cekadasmu<=0){echo "
        <tr><td>Status NIL</td>     <td> :";
		if($sql[statusnil]=='on')
		{
			echo "<input type=checkbox size=5 name=statusnil checked>";
		} else
		{
			echo "<input type=checkbox size=5 name=statusnil>";			
		}
		echo "
		</td></tr>";}		
		echo "<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, 
		tidak akan tersimpan.</td></tr> 
        <tr><td colspan=2>
		<input type=submit value=Simpan><input type=hidden name=idm value=$sql[idmanifestout]>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
		
        </table>
        </form>";
}
//---------------End of Mengedit Data Manifest Export-----------------------------------------------------------
//***************************************************************************************************

//******************************START OF SUPERVISOR INTER *************************************
//Melihat data isi manifest export------------------
elseif (($_GET[module]=='isimanifestexport')AND($_SESSION[level]=='supervisor'))
{
?>
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
}
//-------------------------------- end of Data Manifest Export -------------------------------------------
//---------------Menampilkan Data dan Release Manifest Export-------------------------------------------------
elseif (($_GET[module]=='carimanifestexport')AND($_SESSION[level]=='supervisor'))
{
?>
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
}
//-------------------------------- end of cari Manifest Export -------------------------------------------
//---------------Menampilkan Data Region-------------------------------------------------
elseif (($_GET[module]=='dataregion')AND($_SESSION[level]=='supervisor'))
{
	$p      = new Paging;
	$batas  =10;
	$posisi = $p->cariPosisi($batas);
    $no     = $posisi+1;
	
	if($_GET[r]=='r'){$tab='region';}
	else if($_GET[r]=='d'){$tab='dest_desc';}
	else $tab='region';
	
if(!empty($_POST[cari])){$cari=$_POST[cari];}else{$cari=$_GET[cari];}
if(!empty($cari))//jika user melakukan pencarian
{
	if($_GET[a]=='1') // urutkan Ascending dulu
  	{
	$b=0; 
	$tampil=mysql_query("SELECT * FROM region WHERE region like '%$cari%' OR dest_desc like '%$cari%' 
						order by $tab ASC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM region WHERE region like '%$cari%' OR 
						dest_desc like '%$cari%'"));
	}
	else // jika diklik lagi maka akan pengurutan DESCENDING
  	{
	$b=1; 
	$tampil=mysql_query("SELECT * FROM region WHERE region like '%$cari%' OR dest_desc like '%$cari%' 
						order by $tab DESC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM region WHERE region like '%$cari%' OR 
						dest_desc like '%$cari%'"));
	}
}	
 else//jika user TIDAK melakukan pencarian
{
	if($_GET[a]=='1') // urutkan Ascending dulu
  	{
	$b=0; 
	$tampil=mysql_query("SELECT * FROM region order by $tab ASC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM region"));
	}
	else // jika diklik lagi maka akan pengurutan DESCENDING
  	{
	$b=1; 
	$tampil=mysql_query("SELECT * FROM region order by $tab DESC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM region"));
	}
}
//mulai membuat FORM nya
 	echo "<h2>DATA REGION</h2>
 		<form method=POST action='?module=dataregion'>
		<table border=0 cellpadding=0 cellspacing=0 width=100%>
			<tr><td>
			PENCARIAN : <input name=cari type=text size=20 value='$_POST[cari]' autocomplete=off> 
			<input type=submit value=CARI> <a href=?act=tambah_dataregion>
			<span class=tombol> TAMBAH DATA </span></a>
			</td></tr>
		</table>"; 
	$jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
	$linkHalaman  = $p->navHalaman($_GET[halaman], $jmlhalaman,'cari='.$cari);	
	echo "<p>$linkHalaman</p><table><tr><th>no</th>
		<th><a href=?module=dataregion&r=r&a=$b&cari=$cari>region</a></th>
		<th><a href=?module=dataregion&r=d&a=$b&cari=$cari>description</a></th><th>action</th></th></tr>";
	while ($r=mysql_fetch_array($tampil))
	{
		echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>$no</td><td>$r[region]</td>
          	<td>$r[dest_desc]</td><td><a href=?act=edit_dataregion&id=$r[idregion]>EDIT</a> | 
			<a href=\"javascript:deldata('$r[idregion]','Dest Region : $r[dest_desc] ?',
			'aksi.php?module=dataregion&act=hapus&id=')\">HAPUS</a>
          	</td></tr>";
     $no++;
  	}
  echo "</table><p>word '$cari' found : $jmldata rows in $jmlhalaman pages</p></form>";
}

//---------------End of Menampilkan Data Region-------------------------------------------------

//---------------Menambah Data Region-----------------------------------------------------------
elseif (($_GET[act]=='tambah_dataregion')AND($_SESSION[level]=='supervisor')){
  echo "<h2>TAMBAH DATA REGION</h2>
        <form method=POST action='aksi.php?module=dataregion&act=tambah' 
		onSubmit=\"return checkrequired(this)\">
        <table>
        <tr><td>REGION</td>     <td> : <input type=text name=requiredregion
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		autocomplete=off> *</td></tr>
        <tr><td>DESCRIPTION</td>     <td> : <input type=text name=requireddescription size=30 
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		autocomplete=off> *</td></tr>
		<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, tidak akan tersimpan.</td></tr> 
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";
}
//---------------End of Menambah Data Region-----------------------------------------------------------

//---------------Mengedit Data Region-----------------------------------------------------------
elseif (($_GET[act]=='edit_dataregion')AND($_SESSION[level]=='supervisor')){
$r=mysql_fetch_array(mysql_query("select * from region where idregion='$_GET[id]'"));
  echo "<h2>EDIT DATA REGION</h2>
        <form method=POST action='aksi.php?module=dataregion&act=edit' 
		onSubmit=\"return checkrequired(this)\">
        <table>
        <tr><td>REGION</td>     <td> : <input type=text name=requiredregion
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		value='$r[region]' autocomplete=off> *</td></tr>
        <tr><td>DESCRIPTION</td>     <td> : <input type=text name=requireddescription size=30 
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		value='$r[dest_desc]' autocomplete=off> *</td></tr>
		<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, tidak akan tersimpan.</td></tr> 
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()>
		<input type=hidden name=id value='$_GET[id]'>
		</td></tr>
        </table>
        </form>";
}
//---------------End of Mengedit Data Region-----------------------------------------------------------

//---------------Menampilkan Data commodity-------------------------------------------------
elseif (($_GET[module]=='datacommodity')AND($_SESSION[level]=='supervisor'))
{
	$p      = new Paging;
	$batas  =10;
	$posisi = $p->cariPosisi($batas);
    $no     = $posisi+1;
	
	if($_GET[r]=='r'){$tab='commodity';}
	else if($_GET[r]=='d'){$tab='com_desc';}
	else $tab='commodity';
	
if(!empty($_POST[cari])){$cari=$_POST[cari];}else{$cari=$_GET[cari];}
if(!empty($cari))//jika user melakukan pencarian
{
	if($_GET[a]=='1') // urutkan Ascending dulu
  	{
	$b=0; 
	$tampil=mysql_query("SELECT * FROM commodity WHERE commodity like '%$cari%' OR com_desc like '%$cari%' 
						order by $tab ASC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM commodity WHERE commodity like '%$cari%' OR 
						com_desc like '%$cari%'"));
	}
	else // jika diklik lagi maka akan pengurutan DESCENDING
  	{
	$b=1; 
	$tampil=mysql_query("SELECT * FROM commodity WHERE commodity like '%$cari%' OR com_desc like '%$cari%' 
						order by $tab DESC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM commodity WHERE commodity like '%$cari%' OR 
						com_desc like '%$cari%'"));
	}
}	
 else//jika user TIDAK melakukan pencarian
{
	if($_GET[a]=='1') // urutkan Ascending dulu
  	{
	$b=0; 
	$tampil=mysql_query("SELECT * FROM commodity order by $tab ASC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM commodity"));
	}
	else // jika diklik lagi maka akan pengurutan DESCENDING
  	{
	$b=1; 
	$tampil=mysql_query("SELECT * FROM commodity order by $tab DESC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM commodity"));
	}
}
//mulai membuat FORM nya
 	echo "<h2>DATA COMMODITY</h2>
 		<form method=POST action='?module=datacommodity'>
		<table border=0 cellpadding=0 cellspacing=0 width=100%>
			<tr><td>
			PENCARIAN : <input name=cari type=text size=20 value='$_POST[cari]' autocomplete=off> 
			<input type=submit value=CARI> <a href=?act=tambah_datacommodity>
			<span class=tombol> TAMBAH DATA </span></a>
			</td></tr>
		</table>"; 
	$jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
	$linkHalaman  = $p->navHalaman($_GET[halaman], $jmlhalaman,'cari='.$cari);	
	echo "<p>$linkHalaman</p><table><tr><th>no</th>
		<th><a href=?module=datacommodity&r=r&a=$b&cari=$cari>commodity</a></th>
		<th><a href=?module=datacommodity&r=d&a=$b&cari=$cari>description</a></th><th>action</th></th></tr>";
	while ($r=mysql_fetch_array($tampil))
	{
		echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>$no</td><td>$r[commodity]</td>
          	<td>$r[com_desc]</td><td><a href=?act=edit_datacommodity&id=$r[idcommodity]>EDIT</a> | 
			<a href=\"javascript:deldata('$r[idcommodity]','Commodity : $r[com_desc] ?',
			'aksi.php?module=datacommodity&act=hapus&id=')\">HAPUS</a>
          	</td></tr>";
     $no++;
  	}
  echo "</table><p>word '$cari' found : $jmldata rows in $jmlhalaman pages</p></form>";
}

//---------------End of Menampilkan Data commodity-------------------------------------------------

//---------------Menambah Data commodity-----------------------------------------------------------
elseif (($_GET[act]=='tambah_datacommodity')AND($_SESSION[level]=='supervisor')){
  echo "<h2>TAMBAH DATA COMMODITY</h2>
        <form method=POST action='aksi.php?module=datacommodity&act=tambah' 
		onSubmit=\"return checkrequired(this)\">
        <table>
        <tr><td>COMMODITY</td>     <td> : <input type=text name=requiredcommodity
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		autocomplete=off> *</td></tr>
        <tr><td>DESCRIPTION</td>     <td> : <input type=text name=requireddescription size=30 
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		autocomplete=off> *</td></tr>
		<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, tidak akan tersimpan.</td></tr> 
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";
}
//---------------End of Menambah Data commodity-----------------------------------------------------------

//---------------Mengedit Data commodity-----------------------------------------------------------
elseif (($_GET[act]=='edit_datacommodity')AND($_SESSION[level]=='supervisor')){
$r=mysql_fetch_array(mysql_query("select * from commodity where idcommodity='$_GET[id]'"));
  echo "<h2>EDIT DATA COMMODITY</h2>
        <form method=POST action='aksi.php?module=datacommodity&act=edit' 
		onSubmit=\"return checkrequired(this)\">
        <table>
        <tr><td>commodity</td>     <td> : <input type=text name=requiredcommodity
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		value='$r[commodity]' autocomplete=off> *</td></tr>
        <tr><td>DESCRIPTION</td>     <td> : <input type=text name=requireddescription size=30 
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		value='$r[com_desc]' autocomplete=off> *</td></tr>
		<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, tidak akan tersimpan.</td></tr> 
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()>
		<input type=hidden name=id value='$_GET[id]'>
		</td></tr>
        </table>
        </form>";
}
//---------------End of Mengedit Data commodity-----------------------------------------------------------

//---------------Menampilkan Data customer-------------------------------------------------
elseif (($_GET[module]=='datacustomer')AND($_SESSION[level]=='supervisor'))
{
	$p      = new Paging;
	$batas  =10;
	$posisi = $p->cariPosisi($batas);
    $no     = $posisi+1;
	
	if($_GET[r]=='r'){$tab='customer';}
	else if($_GET[r]=='d'){$tab='cus_desc';}
	else $tab='bendera';
	
if(!empty($_POST[cari])){$cari=$_POST[cari];}else{$cari=$_GET[cari];}
if(!empty($cari))//jika user melakukan pencarian
{
	if($_GET[a]=='1') // urutkan Ascending dulu
  	{
	$b=0; 
	$tampil=mysql_query("SELECT * FROM customer WHERE customer like '%$cari%' OR cus_desc like '%$cari%' 
						order by $tab ASC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM customer WHERE customer like '%$cari%' OR 
						cus_desc like '%$cari%'"));
	}
	else // jika diklik lagi maka akan pengurutan DESCENDING
  	{
	$b=1; 
	$tampil=mysql_query("SELECT * FROM customer WHERE customer like '%$cari%' OR cus_desc like '%$cari%' 
						order by $tab DESC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM customer WHERE customer like '%$cari%' OR 
						cus_desc like '%$cari%'"));
	}
}	
 else//jika user TIDAK melakukan pencarian
{
	if($_GET[a]=='1') // urutkan Ascending dulu
  	{
	$b=0; 
	$tampil=mysql_query("SELECT * FROM customer order by $tab ASC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM customer"));
	}
	else // jika diklik lagi maka akan pengurutan DESCENDING
  	{
	$b=1; 
	$tampil=mysql_query("SELECT * FROM customer order by $tab DESC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM customer"));
	}
}
//mulai membuat FORM nya
 	echo "<h2>DATA CUSTOMER</h2>
 		<form method=POST action='?module=datacustomer'>
		<table border=0 cellpadding=0 cellspacing=0 width=100%>
			<tr><td>
			PENCARIAN : <input name=cari type=text size=20 value='$_POST[cari]' autocomplete=off> 
			<input type=submit value=CARI> <a href=?act=tambah_datacustomer>
			<span class=tombol> TAMBAH DATA </span></a>
			</td></tr>
		</table>"; 
	$jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
	$linkHalaman  = $p->navHalaman($_GET[halaman], $jmlhalaman,'cari='.$cari);	
	echo "<p>$linkHalaman</p><table><tr><th>no</th>
		<th><a href=?module=datacustomer&r=r&a=$b&cari=$cari>customer</a></th>
		<th><a href=?module=datacustomer&r=d&a=$b&cari=$cari>description</a></th>
		<th><a href=?module=datacustomer&r=b&a=$b&cari=$cari>bendera</a></th>
		<th>action</th></th></tr>";
	while ($r=mysql_fetch_array($tampil))
	{
		echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>$no</td><td align=left>$r[customer]</td>
          	<td>$r[cus_desc]</td><td>$r[bendera]</td><td><a href=?act=edit_datacustomer&id=$r[idcustomer]>EDIT</a> | 
			<a href=\"javascript:deldata('$r[idcustomer]','Customer : $r[cus_desc] ?',
			'aksi.php?module=datacustomer&act=hapus&id=')\">HAPUS</a>
          	</td></tr>";
     $no++;
  	}
  echo "</table><p>word '$cari' found : $jmldata rows in $jmlhalaman pages</p></form>";
}

//---------------End of Menampilkan Data customer-------------------------------------------------

//---------------Menambah Data customer-----------------------------------------------------------
elseif (($_GET[act]=='tambah_datacustomer')AND($_SESSION[level]=='supervisor')){
  echo "<h2>TAMBAH DATA customer</h2>
        <form method=POST action='aksi.php?module=datacustomer&act=tambah' 
		onSubmit=\"return checkrequired(this)\">
        <table>
        <tr><td>CUSTOMER</td>     <td> : <input type=text name=requiredcustomer
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		autocomplete=off> *</td></tr>
        <tr><td>DESCRIPTION</td>     <td> : <input type=text name=requireddescription size=30 
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		autocomplete=off> *</td></tr>
       <tr><td>BENDERA</td>     <td> : <input type=text name=requiredbendera size=30 
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		autocomplete=off> *</td></tr>
		<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, tidak akan tersimpan.</td></tr> 
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";
}
//---------------End of Menambah Data customer-----------------------------------------------------------

//---------------Mengedit Data customer-----------------------------------------------------------
elseif (($_GET[act]=='edit_datacustomer')AND($_SESSION[level]=='supervisor')){
$r=mysql_fetch_array(mysql_query("select * from customer where idcustomer='$_GET[id]'"));
  echo "<h2>EDIT DATA customer</h2>
        <form method=POST action='aksi.php?module=datacustomer&act=edit' 
		onSubmit=\"return checkrequired(this)\">
        <table>
        <tr><td>CUSTOMER</td>     <td> : <input type=text name=requiredcustomer
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		value='$r[customer]' autocomplete=off> *</td></tr>
        <tr><td>DESCRIPTION</td>     <td> : <input type=text name=requireddescription size=30 
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		value='$r[cus_desc]' autocomplete=off> *</td></tr>
        <tr><td>BENDERA</td>     <td> : <input type=text name=requiredbendera size=30 
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		value='$r[bendera]' autocomplete=off> *</td></tr		
		<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, tidak akan tersimpan.</td></tr> 
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()>
		<input type=hidden name=id value='$_GET[id]'>
		</td></tr>
        </table>
        </form>";
}
//---------------End of Mengedit Data customer-----------------------------------------------------------

//---------------Menampilkan Data agent-------------------------------------------------
elseif (($_GET[module]=='dataagent')AND($_SESSION[level]=='supervisor'))
{
	$p      = new Paging;
	$batas  =10;
	$posisi = $p->cariPosisi($batas);
    $no     = $posisi+1;
	
	if($_GET[r]=='c'){$tab='agent';}
	else if($_GET[r]=='d'){$tab='agentfullname';}
	else $tab='agent';
	
if(!empty($_POST[cari])){$cari=$_POST[cari];}else{$cari=$_GET[cari];}
if(!empty($cari))//jika user melakukan pencarian
{
	if($_GET[a]=='1') // urutkan Ascending dulu
  	{
	$b=0; 
	$tampil=mysql_query("SELECT * FROM agent
			WHERE (agent like '%$cari%' OR contactperson like '%$cari%') 
			order by $tab ASC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM agent
			WHERE (agent like '%$cari%' OR contactperson like '%$cari%')"));
	}
	else // jika diklik lagi maka akan pengurutan DESCENDING
  	{
	$b=1; 
	$tampil=mysql_query("SELECT * FROM agent
			WHERE (agent like '%$cari%' OR contactperson like '%$cari%') 
			order by $tab DESC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM agent
			WHERE (agent like '%$cari%' OR contactperson like '%$cari%')"));
	}
}	
 else//jika user TIDAK melakukan pencarian
{
	if($_GET[a]=='1') // urutkan Ascending dulu
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
 	echo "<h2>DATA AGENT</h2>
 		<form method=POST action='?module=dataagent'>
		<table border=0 cellpadding=0 cellspacing=0 width=100%>
			<tr><td>
			PENCARIAN : <input name=cari type=text size=20 value='$_POST[cari]' autocomplete=off> 
			<input type=submit value=CARI> <a href=?act=tambah_dataagent>
			<span class=tombol> TAMBAH DATA </span></a>
			</td></tr>
		</table>"; 
	$jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
	$linkHalaman  = $p->navHalaman($_GET[halaman], $jmlhalaman,'cari='.$cari);	
	echo "<p>$linkHalaman</p><table><tr><th>no</th>
		<th><a href=?module=dataagent&r=c&a=$b&cari=$cari>code</a></th>
		<th><a href=?module=dataagent&r=d&a=$b&cari=$cari>agent</a></th>
		<th>address</th><th>phone</th><th>fax</th><th>contact person</th>
		<th>action</th>";
	while ($r=mysql_fetch_array($tampil))
	{
		echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>$no</td><td>$r[agent]</td>
          	<td>$r[agentfullname]</td><td>$r[address]</td>
			<td>$r[phone]</td><td>$r[fax]</td>
			<td>$r[contactperson]</td>
			<td><a href=?act=edit_dataagent&id=$r[idagent]>EDIT</a> | 
			<a href=\"javascript:deldata('$r[idagent]','Agent : $r[agent] ?',
			'aksi.php?module=dataagent&act=hapus&id=')\">HAPUS</a>
          	</td></tr>";
     $no++;
  	}
  echo "</table><p>word '$cari' found : $jmldata rows in $jmlhalaman pages</p></form>";
}

//---------------End of Menampilkan Data agent-------------------------------------------------

//---------------Mengedit Data agent-----------------------------------------------------------
elseif (($_GET[act]=='edit_dataagent')AND($_SESSION[level]=='supervisor')){
$r=mysql_fetch_array(mysql_query("select * from agent where idagent='$_GET[id]'"));
  echo "<h2>EDIT DATA AGENT</h2>
        <form method=POST action='aksi.php?module=dataagent&act=edit' 
		onSubmit=\"return checkrequired(this)\">
        <table>
        <tr><td>CODE</td>     <td> : 
		<input type=text name=requiredcode
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		value='$r[agent]' autocomplete=off> *</td></tr>
        <tr><td>AGENT FULL NAME</td>     <td> : 
		<input type=text name=requiredagent
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		value='$r[agentfullname]' autocomplete=off> *</td></tr>
        <tr><td>ADDRESS</td>     <td> : 
		<input type=text name=address
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		value='$r[address]' autocomplete=off> </td></tr>
        <tr><td>PHONE</td>     <td> : 
		<input type=text name=phone
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		value='$r[phone]' autocomplete=off> </td></tr>
        <tr><td>FAX</td>     <td> : 
		<input type=text name=fax
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		value='$r[fax]' autocomplete=off> </td></tr>
        <tr><td>CONTACT PERSON</td>     <td> : 
		<input type=text name=contact
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		value='$r[contactperson]' autocomplete=off></td></tr>
		
		<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, tidak akan tersimpan.</td></tr> 
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()>
		<input type=hidden name=id value='$_GET[id]'>
		</td></tr>
        </table>
        </form>";
}
//---------------End of Mengedit Data agent-----------------------------------------------------------

//---------------Menambah Data Agent-----------------------------------------------------------
elseif (($_GET[act]=='tambah_dataagent')AND($_SESSION[level]=='supervisor')){
  echo "<h2>TAMBAH DATA AGENT</h2>
        <form method=POST action='aksi.php?module=dataagent&act=tambah' 
		onSubmit=\"return checkrequired(this)\">
        <table>
        <tr><td>CODE</td>     <td> : 
		<input type=text name=requiredcode
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		autocomplete=off> *</td></tr>
        <tr><td>AGENT FULL NAME</td>     <td> : 
		<input type=text name=requiredagent
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		autocomplete=off> *</td></tr>
        <tr><td>ADDRESS</td>     <td> : 
		<input type=text name=address
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		 autocomplete=off> </td></tr>
        <tr><td>PHONE</td>     <td> : 
		<input type=text name=phone
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		autocomplete=off> </td></tr>
        <tr><td>FAX</td>     <td> : 
		<input type=text name=fax
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		autocomplete=off> </td></tr>
        <tr><td>CONTACT PERSON</td>     <td> : 
		<input type=text name=contact
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		autocomplete=off></td></tr>
		<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, tidak akan tersimpan.</td></tr>        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";
}
//---------------End of Menambah Data Agent-----------------------------------------------------------


//---------------Menampilkan Data flight-------------------------------------------------
elseif (($_GET[module]=='dataflightno')AND($_SESSION[level]=='supervisor'))
{
	$p      = new Paging;
	$batas  =10;
	$posisi = $p->cariPosisi($batas);
    $no     = $posisi+1;
	
	if($_GET[r]=='r'){$tab='flight';}
	else if($_GET[r]=='c'){$tab='customer';}
	else if($_GET[r]=='b'){$tab='bendera';}
	else $tab='cus_desc';
	
if(!empty($_POST[cari])){$cari=$_POST[cari];}else{$cari=$_GET[cari];}
if(!empty($cari))//jika user melakukan pencarian
{
	if($_GET[a]=='1') // urutkan Ascending dulu
  	{
	$b=0; 
	$tampil=mysql_query("SELECT * FROM flight as f,customer as c 
			WHERE f.idcustomer=c.idcustomer AND 
			(f.flight like '%$cari%' OR c.customer like '%$cari%' OR c.bendera like '%$cari%') 
			order by $tab ASC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM flight as f,customer as c 
			WHERE f.idcustomer=c.idcustomer AND 
			(f.flight like '%$cari%' OR c.customer like '%$cari%' OR c.bendera like '%$cari%')"));
	}
	else // jika diklik lagi maka akan pengurutan DESCENDING
  	{
	$b=1; 
	$tampil=mysql_query("SELECT * FROM flight as f,customer as c 
			WHERE f.idcustomer=c.idcustomer AND 
			(f.flight like '%$cari%' OR c.customer like '%$cari%' OR c.bendera like '%$cari%') 
			order by $tab DESC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM flight as f,customer as c 
			WHERE f.idcustomer=c.idcustomer AND 
			(f.flight like '%$cari%' OR c.customer like '%$cari%' OR c.bendera like '%$cari%')"));
	}
}	
 else//jika user TIDAK melakukan pencarian
{
	if($_GET[a]=='1') // urutkan Ascending dulu
  	{
	$b=0; 
	$tampil=mysql_query("SELECT * FROM flight as f,customer as c 
			WHERE f.idcustomer=c.idcustomer order by $tab ASC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM flight as f,customer as c 
			WHERE f.idcustomer=c.idcustomer"));
	}
	else // jika diklik lagi maka akan pengurutan DESCENDING
  	{
	$b=1; 
	$tampil=mysql_query("SELECT * FROM flight as f,customer as c 
			WHERE f.idcustomer=c.idcustomer order by $tab DESC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM flight as f,customer as c 
			WHERE f.idcustomer=c.idcustomer"));
	}
}
//mulai membuat FORM nya
 	echo "<h2>DATA FLIGHT</h2>
 		<form method=POST action='?module=dataflightno'>
		<table border=0 cellpadding=0 cellspacing=0 width=100%>
			<tr><td>
			PENCARIAN : <input name=cari type=text size=20 value='$_POST[cari]' autocomplete=off> 
			<input type=submit value=CARI> <a href=?act=tambah_dataflight>
			<span class=tombol> TAMBAH DATA </span></a>
			</td></tr>
		</table>"; 
	$jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
	$linkHalaman  = $p->navHalaman($_GET[halaman], $jmlhalaman,'cari='.$cari);	
	echo "<p>$linkHalaman</p><table><tr><th>no</th>
		<th><a href=?module=dataflightno&r=r&a=$b&cari=$cari>flight#</a></th>
		<th><a href=?module=dataflightno&r=c&a=$b&cari=$cari>customer code</a></th>
		<th><a href=?module=dataflightno&r=d&a=$b&cari=$cari>customer description</a></th>
		<th><a href=?module=dataflightno&r=b&a=$b&cari=$cari>bendera</a></th>
		<th>action</th></th></tr>";
	while ($r=mysql_fetch_array($tampil))
	{
		echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>$no</td><td>$r[flight]</td>
          	<td>$r[customer]</td><td>$r[cus_desc]</td><td>$r[bendera]</td>
			<td><a href=?act=edit_dataflight&id=$r[idflight]>EDIT</a> | 
			<a href=\"javascript:deldata('$r[idflight]','Flight# $r[flight] ?',
			'aksi.php?module=dataflightno&act=hapus&id=')\">HAPUS</a>
          	</td></tr>";
     $no++;
  	}
  echo "</table><p>word '$cari' found : $jmldata rows in $jmlhalaman pages</p></form>";
}

//---------------End of Menampilkan Data flight-------------------------------------------------

//---------------Menambah Data flight-----------------------------------------------------------
elseif (($_GET[act]=='tambah_dataflight')AND($_SESSION[level]=='supervisor')){
  echo "<h2>TAMBAH DATA FLIGHT</h2>
        <form method=POST action='aksi.php?module=dataflightno&act=tambah' 
		onSubmit=\"return checkrequired(this)\">
        <table>
        <tr><td>FLIGHT</td>     <td> : <input type=text name=requiredflight
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		autocomplete=off> *</td></tr>
        <tr><td>CUSTOMER</td>
	    	<td> : <select name=customer>";
				$tampil=mysql_query("SELECT * FROM customer ORDER BY customer ASC");
         		while($r=mysql_fetch_array($tampil))
				{
    	    		echo "<option value=$r[idcustomer]>$r[customer] -> $r[cus_desc] -> $r[bendera]</option>";
				}
		echo "</select>	</td></tr>
		<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, tidak akan tersimpan.</td></tr> 
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";
}
//---------------End of Menambah Data flight-----------------------------------------------------------

//---------------Mengedit Data flight-----------------------------------------------------------
elseif (($_GET[act]=='edit_dataflight')AND($_SESSION[level]=='supervisor')){
$r=mysql_fetch_array(mysql_query("select * from flight where idflight='$_GET[id]'"));
  echo "<h2>EDIT DATA FLIGHT</h2>
        <form method=POST action='aksi.php?module=dataflightno&act=edit' 
		onSubmit=\"return checkrequired(this)\">
        <table>
        <tr><td>FLIGHT</td>     <td> : <input type=text name=requiredflight
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		value='$r[flight]' autocomplete=off> *</td></tr>
       <tr><td>CUSTOMER</td>
	    	<td> : <select name=customer>";
				$tampil=mysql_query("SELECT * FROM customer ORDER BY customer ASC");
         		while($p=mysql_fetch_array($tampil))
				{
    	    		if($p[idcustomer]==$r[idcustomer])
					{echo "<option value='$p[idcustomer]' selected>$p[customer] -> $p[cus_desc] -> $p[bendera]</option>";}
					else
					{echo "<option value='$p[idcustomer]'>$p[customer] -> $p[cus_desc] -> $p[bendera]</option>";}
				}
		echo "</select>	</td></tr>
		<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, tidak akan tersimpan.</td></tr> 
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()>
		<input type=hidden name=id value='$_GET[id]'>
		</td></tr>
        </table>
        </form>";
}
//---------------End of Mengedit Data flight-----------------------------------------------------------


//---------------Menampilkan Data destination-------------------------------------------------
elseif (($_GET[module]=='datadestinasi')AND($_SESSION[level]=='supervisor'))
{
	$p      = new Paging;
	$batas  =10;
	$posisi = $p->cariPosisi($batas);
    $no     = $posisi+1;
	
	if($_GET[r]=='c'){$tab='d.dest_code';}
	else if($_GET[r]=='d'){$tab='r.dest_desc';}
	else $tab='r.region';
	
if(!empty($_POST[cari])){$cari=$_POST[cari];}else{$cari=$_GET[cari];}
if(!empty($cari))//jika user melakukan pencarian
{
	if($_GET[a]=='1') // urutkan Ascending dulu
  	{
	$b=0; 
	$tampil=mysql_query("SELECT * FROM destination as d,region as r 
			WHERE d.idregion=r.idregion AND 
			(d.dest_code like '%$cari%' OR r.dest_desc like '%$cari%') 
			order by $tab ASC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM destination as d,region as r 
			WHERE d.idregion=r.idregion AND 
			(d.dest_code like '%$cari%' OR r.dest_desc like '%$cari%')"));
	}
	else // jika diklik lagi maka akan pengurutan DESCENDING
  	{
	$b=1; 
	$tampil=mysql_query("SELECT * FROM destination as d,region as r 
			WHERE d.idregion=r.idregion AND 
			(d.dest_code like '%$cari%' OR r.dest_desc like '%$cari%') 
			order by $tab DESC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM destination as d,region as r 
			WHERE d.idregion=r.idregion AND 
			(d.dest_code like '%$cari%' OR r.dest_desc like '%$cari%')"));
	}
}	
 else//jika user TIDAK melakukan pencarian
{
	if($_GET[a]=='1') // urutkan Ascending dulu
  	{
	$b=0; 
	$tampil=mysql_query("SELECT * FROM destination as d,region as r 
			WHERE d.idregion=r.idregion
			order by $tab ASC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM destination as d,region as r 
			WHERE d.idregion=r.idregion"));
	}
	else // jika diklik lagi maka akan pengurutan DESCENDING
  	{
	$b=1; 
	$tampil=mysql_query("SELECT * FROM destination as d,region as r 
			WHERE d.idregion=r.idregion
			order by $tab DESC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM destination as d,region as r 
			WHERE d.idregion=r.idregion"));
	}
}
//mulai membuat FORM nya
 	echo "<h2>DATA DESTINATION</h2>
 		<form method=POST action='?module=datadestinasi'>
		<table border=0 cellpadding=0 cellspacing=0 width=100%>
			<tr><td>
			PENCARIAN : <input name=cari type=text size=20 value='$_POST[cari]' autocomplete=off> 
			<input type=submit value=CARI> <a href=?act=tambah_datadestination>
			<span class=tombol> TAMBAH DATA </span></a>
			</td></tr>
		</table>"; 
	$jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
	$linkHalaman  = $p->navHalaman($_GET[halaman], $jmlhalaman,'cari='.$cari);	
	echo "<p>$linkHalaman</p><table><tr><th>no</th>
		<th><a href=?module=datadestinasi&r=c&a=$b&cari=$cari>code destination</a></th>
		<th><a href=?module=datadestinasi&r=d&a=$b&cari=$cari>destination</a></th>
		<th><a href=?module=datadestinasi&r=r&a=$b&cari=$cari>region code</a></th>
		<th>action</th></th></tr>";
	while ($r=mysql_fetch_array($tampil))
	{
		echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>$no</td><td>$r[dest_code]</td>
          	<td>$r[dest_desc]</td><td>$r[region]</td>
			<td><a href=?act=edit_datadestination&id=$r[iddestination]>EDIT</a> | 
			<a href=\"javascript:deldata('$r[iddestination]','Dest Code : $r[dest_code] ?',
			'aksi.php?module=datadestinasi&act=hapus&id=')\">HAPUS</a>
          	</td></tr>";
     $no++;
  	}
  echo "</table><p>word '$cari' found : $jmldata rows in $jmlhalaman pages</p></form>";
}

//---------------End of Menampilkan Data destination-------------------------------------------------

//---------------Menambah Data destination-----------------------------------------------------------
elseif (($_GET[act]=='tambah_datadestination')AND($_SESSION[level]=='supervisor')){
  echo "<h2>TAMBAH DATA DESTINATION</h2>
        <form method=POST action='aksi.php?module=datadestinasi&act=tambah' 
		onSubmit=\"return checkrequired(this)\">
        <table>
        <tr><td>CODE</td>     <td> : <input type=text name=requiredcode
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		autocomplete=off> *</td></tr>
        <tr><td>REGION/DESTINATION</td>
	    	<td> : <select name=region>";
				$tampil=mysql_query("SELECT * FROM region ORDER BY region ASC");
         		while($r=mysql_fetch_array($tampil))
				{
    	    		echo "<option value='$r[idregion]'>$r[region] -> $r[dest_desc]</option>";
				}
		echo "</select></td></tr>
		<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, tidak akan tersimpan.</td></tr> 
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";
}
//---------------End of Menambah Data destination-----------------------------------------------------------

//---------------Mengedit Data destination-----------------------------------------------------------
elseif (($_GET[act]=='edit_datadestination')AND($_SESSION[level]=='supervisor')){
$r=mysql_fetch_array(mysql_query("select * from destination where iddestination='$_GET[id]'"));
  echo "<h2>EDIT DATA DESTINATION</h2>
        <form method=POST action='aksi.php?module=datadestinasi&act=edit' 
		onSubmit=\"return checkrequired(this)\">
        <table>
       <tr><td>CODE</td>     <td> : <input type=text name=requiredcode
		onChange=\"javascript:this.value=this.value.toUpperCase();\" value='$r[dest_code]' 
		autocomplete=off> *</td></tr>
       <tr><td>REGION</td>
	    	<td> : <select name=region>";
				$tampil=mysql_query("SELECT * FROM region ORDER BY region ASC");
         		while($p=mysql_fetch_array($tampil))
				{
    	    		if($p[idregion]==$r[idregion])
					{echo "<option value='$p[idregion]' selected>$p[region] -> $p[dest_desc]</option>";}
					else
					{echo "<option value='$p[idregion]'>$p[region] -> $p[dest_desc]</option>";}
				}
		echo "</select>	*</td></tr>
		<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, tidak akan tersimpan.</td></tr> 
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()>
		<input type=hidden name=id value='$_GET[id]'>
		</td></tr>
        </table>
        </form>";
}
//---------------End of Mengedit Data destination-----------------------------------------------------------

//---------------Menampilkan Data Commodity AP-------------------------------------------------
elseif (($_GET[module]=='datacommodity_ap')AND($_SESSION[level]=='supervisor'))
{
	$p      = new Paging;
	$batas  =10;
	$posisi = $p->cariPosisi($batas);
    $no     = $posisi+1;
	
	if($_GET[r]=='r'){$tab='cp.commodityap';}
	else $tab='c.commodity';
	
if(!empty($_POST[cari])){$cari=$_POST[cari];}else{$cari=$_GET[cari];}
if(!empty($cari))//jika user melakukan pencarian
{
	if($_GET[a]=='1') // urutkan Ascending dulu
  	{
	$b=0; 
	$tampil=mysql_query("SELECT * FROM commodity_ap as cp,commodity as c 
			WHERE cp.idcommodity=c.idcommodity AND 
			(cp.commodityap like '%$cari%' OR c.commodity like '%$cari%') 
			order by $tab ASC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM commodity_ap as cp,commodity as c 
			WHERE cp.idcommodity=c.idcommodity AND 
			(cp.commodityap like '%$cari%' OR c.commodity like '%$cari%')"));
	}
	else // jika diklik lagi maka akan pengurutan DESCENDING
  	{
	$b=1; 
	$tampil=mysql_query("SELECT * FROM commodity_ap as cp,commodity as c 
			WHERE cp.idcommodity=c.idcommodity AND 
			(cp.commodityap like '%$cari%' OR c.commodity like '%$cari%') 
			order by $tab DESC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM commodity_ap as cp,commodity as c 
			WHERE cp.idcommodity=c.idcommodity AND 
			(cp.commodityap like '%$cari%' OR c.commodity like '%$cari%')"));
	}
}	
 else//jika user TIDAK melakukan pencarian
{
	if($_GET[a]=='1') // urutkan Ascending dulu
  	{
	$b=0; 
	$tampil=mysql_query("SELECT * FROM commodity_ap as cp,commodity as c 
			WHERE cp.idcommodity=c.idcommodity order by $tab ASC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM commodity_ap as cp,commodity as c 
			WHERE cp.idcommodity=c.idcommodity"));
	}
	else // jika diklik lagi maka akan pengurutan DESCENDING
  	{
	$b=1; 
	$tampil=mysql_query("SELECT * FROM commodity_ap as cp,commodity as c 
			WHERE cp.idcommodity=c.idcommodity order by $tab DESC limit $posisi,$batas"); 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM commodity_ap as cp,commodity as c 
			WHERE cp.idcommodity=c.idcommodity"));
	}
}
//mulai membuat FORM nya
 	echo "<h2>DATA COMMODITY (REFF:AP)</h2>
 		<form method=POST action='?module=datacommodity_ap'>
		<table border=0 cellpadding=0 cellspacing=0 width=100%>
			<tr><td>
			PENCARIAN : <input name=cari type=text size=20 value='$_POST[cari]' autocomplete=off> 
			<input type=submit value=CARI> <a href=?act=tambah_datacommodity_ap>
			<span class=tombol> TAMBAH DATA </span></a>
			</td></tr>
		</table>"; 
	$jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
	$linkHalaman  = $p->navHalaman($_GET[halaman], $jmlhalaman,'cari='.$cari);	
	echo "<p>$linkHalaman</p><table><tr><th>no</th>
		<th><a href=?module=datacommodity_ap&r=r&a=$b&cari=$cari>sub commodity code</a></th>
		<th><a href=?module=datacommodity_ap&r=d&a=$b&cari=$cari>commodity code</a></th><th>action</th></th></tr>";
	while ($r=mysql_fetch_array($tampil))
	{
		echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		<td>$no</td><td>$r[commodityap]</td>
          	<td>$r[commodity]</td>
			<td><a href=?act=edit_datacommodity_ap&id=$r[idcommodityap]>EDIT</a> | 
			<a href=\"javascript:deldata('$r[idcommodityap]','Commodity $r[commodityap] ?',
			'aksi.php?module=datacommodity_ap&act=hapus&id=')\">HAPUS</a>
          	</td></tr>";
     $no++;
  	}
  echo "</table><p>word '$cari' found : $jmldata rows in $jmlhalaman pages</p></form>";
}

//---------------End of Menampilkan Data Commodity AP-------------------------------------------------

//---------------Menambah Data Commodity AP-----------------------------------------------------------
elseif (($_GET[act]=='tambah_datacommodity_ap')AND($_SESSION[level]=='supervisor')){
  echo "<h2>TAMBAH DATA COMMODITY (REFF:AP)</h2>
        <form method=POST action='aksi.php?module=datacommodity_ap&act=tambah' 
		onSubmit=\"return checkrequired(this)\">
        <table>
        <tr><td>SUB CODE</td>     <td> : <input type=text name=requiredsubcodecommodity
		onChange=\"javascript:this.value=this.value.toUpperCase();\" 
		autocomplete=off> *</td></tr>
        <tr><td>COMMODITY CODE</td>
	    	<td> : <select name=commodity>";
				$tampil=mysql_query("SELECT * FROM commodity ORDER BY commodity ASC");
         		while($r=mysql_fetch_array($tampil))
				{
    	    		echo "<option value='$r[idcommodity]'>$r[commodity] -> $r[com_desc]</option>";
				}
		echo "</select>	*</td></tr>
		<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, tidak akan tersimpan.</td></tr> 
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";
}
//---------------End of Menambah Data Commodity AP-----------------------------------------------------------

//---------------Mengedit Data Commodity AP-----------------------------------------------------------
elseif (($_GET[act]=='edit_datacommodity_ap')AND($_SESSION[level]=='supervisor')){
$r=mysql_fetch_array(mysql_query("select * from commodity_ap where idcommodityap='$_GET[id]'"));
  echo "<h2>EDIT DATA COMMODITY (REFF:AP)</h2>
        <form method=POST action='aksi.php?module=datacommodity_ap&act=edit' 
		onSubmit=\"return checkrequired(this)\">
        <table>
        <tr><td>SUB CODE</td>     <td> : <input type=text name=requiredsubcodecommodity
		onChange=\"javascript:this.value=this.value.toUpperCase();\" value='$r[commodityap]'  
		autocomplete=off> *</td></tr>
         <tr><td>COMMODITY CODE</td>
	    	<td> : <select name=commodity>";
				$tampil=mysql_query("SELECT * FROM commodity ORDER BY commodity ASC");
         		while($p=mysql_fetch_array($tampil))
				{
    	    		if($p[idcommodity]==$r[idcommodity])
					{echo "<option value='$p[idcommodity]' selected>$p[commodity] -> $p[com_desc]</option>";}
					else
					{echo "<option value='$p[idcommodity]'>$p[commodity] -> $p[com_desc]</option>";}
				}
		echo "</select>	*</td></tr>
		<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, tidak akan tersimpan.</td></tr> 
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()>
		<input type=hidden name=id value='$_GET[id]'>
		</td></tr>
        </table>
        </form>";
}
//---------------End of Mengedit Data Commodity AP-----------------------------------------------------------

//******************************END OF SUPERVISOR INTER *************************************















//****************************** START OF EXPORT INTER **************************************
//---------------Menampilkan Data SMU INTER-------------------------------------------------
elseif (($_GET[module]=='datasmuinter')AND($_SESSION[level]=='export'))
{
 	echo "<h2>DATA AWB INTERNATIONAL</h2>
 		<form method=POST action='?module=datasmuinter'>
		<table border=0 cellpadding=0 cellspacing=0 width=100%>
			<tr><td>
			PENCARIAN : <input name=cari type=text size=20 value='$_POST[cari]' autocomplete=off> 
			<input type=submit value=CARI> <a href=?act=tambah_datasmuinter>
			<span class=tombol> TAMBAH DATA </span></a>
			</td></tr>
		</table></form>"; 
		
if(!empty($_POST[cari])){$cari=$_POST[cari];}else{$cari=$_GET[cari];}
if(!empty($cari))//jika user melakukan pencarian
{
	$no1 = substr($cari,0,3);
	$no2 = substr($cari,3,4);
	$no3 = substr($cari,7,4);
	$cari= $no1.'-'.$no2.' '.$no3;
	$jmldata=mysql_num_rows(mysql_query("SELECT * FROM mastersmu WHERE nosmu = '$cari'"));
	if($jmldata<=0)
	{
	echo "<p><B><font color=#FF0000>Sorry, AWB# $cari NOT FOUND !!</font></b><BR>
	<B>Perlu diingat dan dicek lagi :</B><BR>1. No AWB TIDAK USAH DIMASUKKAN TANDA '-' nya atau spasinya, langsung ketik angkanya saja. <BR>
	2. Panjang No AWB adalah 11 (tanpa -) digit, contoh : XXX-YYYY ZZZZ<BR>
	<b>Jika kedua hal tersebut sudah benar tapi data belum ditemukan, kemungkinan AWB memang belum ada di database.</b></p>";
	}
	else
	{
	$p=mysql_query("SELECT * FROM mastersmu as m,commodity_ap as c,
	agent as a,origin as o, destination as d WHERE 
	m.nosmu = '$cari' AND m.idcommodityap=c.idcommodityap 
	AND m.idorigin=o.idorigin AND m.iddestination=d.iddestination
	AND m.idagent = a.idagent");
	$r=mysql_fetch_array($p);
	echo "<table>
	<tr align=left><td><B>AWB No.</B></td><td>: $r[nosmu]</td></tr>
	<tr><td><B>AWB Date</B></td><td>: $r[tglsmu]</td></tr>
	<tr><td><B>Commodity</B></td><td>: $r[commodityap]-$r[comm_code]</td></tr>
	<tr><td><B>Origin</B></td><td>: $r[origin_code] - region $r[region]</td></tr>
	<tr><td><B>Destination</B></td><td>: $r[dest_code] - region $r[region]</td></tr>			
	<tr><td><B>Weight(Kg)</B></td><td>: $r[berat]</td></tr>
	<tr><td><B>Collies</B></td><td>: $r[koli]</td></tr>
	<tr><td><B>Transit ?</B></td><td>: $r[status_transit]</td></tr>
	<tr><td><B>Agent</B></td><td>:  $r[agent]</td></tr>			
	<tr><td><B>Consignee</B></td><td>: $r[consignee]</td></tr>
	<tr><td><B>Shipper</B></td><td>: $r[shipper]</td></tr></table>";
	}
}	

}

//---------------End of Menampilkan Data SMU INTER-------------------------------------------------
//---------------Menambah Data SMU Inter-----------------------------------------------------------
elseif (($_GET[act]=='tambah_datasmuinter')AND($_SESSION[level]=='export')){
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
  echo "<h2>TAMBAH DATA AWB INTERNATIONAL</h2>
        <form method=POST action='aksi.php?module=datasmuinter&act=tambah' 
		onSubmit=\"return checkrequired(this)\">
        <table>
        <tr><td>AWB</td>     <td> : <input type=text maxlength=11 name=requiredawb
		 onkeypress=\"return isNumberKey(event)\"
		autocomplete=off> * ex : 11122223333 (tanpa tanda minus atau spasi, max 11 angka)</td></tr>
        <tr><td>COMMODITY</td><td> : <select name=commodity>";
		$tampil=mysql_query("SELECT * FROM commodity_ap ORDER BY commodityap ASC");
        while($r=mysql_fetch_array($tampil))
		{
    	 echo "<option value='$r[idcommodityap]'>$r[commodityap] / $r[comm_code]</option>";
		}
		echo "</select></td></tr>
        <tr><td>ORIGIN</td><td> : <select name=origin>";
		$tampil=mysql_query("SELECT * FROM origin ORDER BY origin_code ASC");
        while($r=mysql_fetch_array($tampil))
		{
    	 echo "<option value='$r[idorigin]'>$r[origin_code] / Region : $r[region]</option>";
		}
		echo "</select></td></tr>
        <tr><td>DESTINATION</td><td> : <select name=destination>";
		$tampil=mysql_query("SELECT * FROM destination ORDER BY dest_code ASC");
        while($r=mysql_fetch_array($tampil))
		{
    	 echo "<option value='$r[iddestination]'>$r[dest_code] / Region : $r[region]</option>";
		}
		echo "</select></td></tr>	
        <tr><td>Weight (Kg)</td>     <td> : <input type=text maxlength=5 name=requiredkg
		 onkeypress=\"return isNumberKey(event)\"
		autocomplete=off> *
        <tr><td>Collies</td>     <td> : <input type=text maxlength=5 name=requiredkoli
		 onkeypress=\"return isNumberKey(event)\"
		autocomplete=off> *		
        <tr><td>Consignee</td>     <td> : <input type=text maxlength=5 name=requiredkg
		 onkeypress=\"return isNumberKey(event)\"
		autocomplete=off> *
        <tr><td>Shipper</td>     <td> : <input type=text maxlength=5 name=requiredkoli
		 onkeypress=\"return isNumberKey(event)\"
		autocomplete=off> *	
        <tr><td>AGENT</td><td> : <select name=agent>
		<option value='0'>none</option>";
		$tampil=mysql_query("SELECT * FROM agent ORDER BY agent ASC");
        while($r=mysql_fetch_array($tampil))
		{
    	 echo "<option value='$r[idagent]'>$r[agent]</option>";
		}
		echo "</select></td></tr>								
		
		<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, 
		tidak akan tersimpan.</td></tr> 
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";
}
//---------------End of Menambah Data SMU Inter-----------------------------------------------------------






// Form tambah user
elseif (($_GET[act]=='tambahuser')AND($_SESSION[level]=='admin')){
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
			<option value='import'>import BREAKDOWN</option>
			<option value='export'>export BUILDUP</option>
			<option value='btb'>BTB</option>
		</select>
		</td></tr>
		<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, tidak akan tersimpan.</td></tr> 
        <tr><td colspan=2><input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";
}

// Form edit user
elseif (($_GET[act]=='edituser')AND($_SESSION[level]=='admin')){
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
			<option value='import'>import BREAKDOWN</option>
			<option value='export'>export BUILDUP</option>";
		}
		else if($r[level]=='kasir')
		{
		echo "<option value='supervisor' selected>SUPERVISOR</option>
			<option value='kasir' selected>KASIR</option>
			<option value='import'>import BREAKDOWN</option>
			<option value='export'>export BUILDUP</option>";
		}
		else if($r[level]=='import')
		{
		echo "<option value='supervisor'>SUPERVISOR</option>
			<option value='kasir'>KASIR</option>
			<option value='import' selected>import BREAKDOWN</option>
			<option value='export'>export BUILDUP</option>";
		}
		else if($r[level]=='export')
		{
		echo "<option value='supervisor'>SUPERVISOR</option>
			<option value='kasir'>KASIR</option>
			<option value='import'>import BREAKDOWN</option>
			<option value='export' selected>export BUILDUP</option>";
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
  											
						<tr><td colspan=2>*) wajib diisi, data kosong atau duplikasi/double ID kunci, tidak akan tersimpan.</td></tr> 
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
		<input type=radio name=status value='export' checked>export
		<input type=radio name=status value='btb' >btb
		<input type=radio name=status value='import'>import
									   <input type=radio name=status value='export'>store out
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
  if ($r[status]=='export'){
    echo "<tr><td>Status</td> <td> : 
	<input type=radio name=status value=export checked>export
    <input type=radio name=status value=btb>btb
    <input type=radio name=status value=import>import
	<input type=radio name=status value=export>store out
	<input type=radio name=status value=store_in>store in
	<input type=radio name=status value=kasir>kasir
	<input type=radio name=status value=supervisor>supervisor  
    <input type=radio name=status value=admin>admin</td></tr>";
  }
   else if ($r[status]=='import'){
    echo "<tr><td>Status</td> <td> : 
	<input type=radio name=status value=export>export
	    <input type=radio name=status value=btb>btb
    <input type=radio name=status value=import checked>import
	<input type=radio name=status value=export>store out
	<input type=radio name=status value=store_in>store in
	<input type=radio name=status value=kasir>kasir
	<input type=radio name=status value=supervisor>supervisor  
    <input type=radio name=status value=admin>admin</td></tr>";
  }
   else if ($r[status]=='export'){
    echo "<tr><td>Status</td> <td> : 
	<input type=radio name=status value=export>export
	    <input type=radio name=status value=btb>btb
    <input type=radio name=status value=import>import
	<input type=radio name=status value=export checked>store out
	<input type=radio name=status value=store_in>store in
	<input type=radio name=status value=kasir>kasir
	<input type=radio name=status value=supervisor>supervisor  
    <input type=radio name=status value=admin>admin</td></tr>";
  }
     else if ($r[status]=='store_in'){
    echo "<tr><td>Status</td> <td> : 
	<input type=radio name=status value=export>export
	    <input type=radio name=status value=btb>btb
    <input type=radio name=status value=import>import
	<input type=radio name=status value=export>store out
	<input type=radio name=status value=store_in checked>store in
	<input type=radio name=status value=kasir>kasir
	<input type=radio name=status value=supervisor>supervisor  
    <input type=radio name=status value=admin>admin</td></tr>";
  }
   else if ($r[status]=='kasir'){
    echo "<tr><td>Status</td> <td> : 
	<input type=radio name=status value=export>export
	    <input type=radio name=status value=btb>btb
    <input type=radio name=status value=import>import
	<input type=radio name=status value=export>store out
	<input type=radio name=status value=store_in>store in
	<input type=radio name=status value=kasir checked>kasir
	<input type=radio name=status value=supervisor>supervisor  
   <input type=radio name=status value=admin>admin</td></tr>";
  }
      else if ($r[status]=='supervisor'){
    echo "<tr><td>Status</td> <td> : 
	<input type=radio name=status value=export>export
	    <input type=radio name=status value=btb>btb
    <input type=radio name=status value=import>import
	<input type=radio name=status value=export>store out
	<input type=radio name=status value=store_in>store in
	<input type=radio name=status value=kasir>kasir
	<input type=radio name=status value=supervisor checked>supervisor  
    <input type=radio name=status value=admin>admin</td></tr>";
  }
   else if ($r[status]=='admin'){
    echo "<tr><td>Status</td> <td> : 
	<input type=radio name=status value=export>export
	    <input type=radio name=status value=btb>btb
    <input type=radio name=status value=import>import
	<input type=radio name=status value=export>store out
	<input type=radio name=status value=store_in>store in
	<input type=radio name=status value=kasir>kasir
	<input type=radio name=status value=supervisor>supervisor  
    <input type=radio name=status value=admin checked>admin</td></tr>";
  } 
   else if ($r[status]=='btb'){
    echo "<tr><td>Status</td> <td> : 
	<input type=radio name=status value=export>export
	    <input type=radio name=status value=btb checked>btb
    <input type=radio name=status value=import>import
	<input type=radio name=status value=export>store out
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
					untuk DeliveryBill <B>export</B>. <BR>Masukkan nomor Surat Muatan Udara/Airway Bill 
					(<B>No. SMU/AWB</B>) untuk DeliveryBill <B>import</B></p>";
	} 
	elseif($_GET[psn]=='w')
	{
		$halo='Barang masih di cek - Belum Confirm';
		echo "<p class=error>$halo</p>";
		echo "<p>INFO: <BR>Masukkan Nomor Bukti Timbang Barang (<B>No. BTB</B>) 
					untuk DeliveryBill <B>export</B>. <BR>Masukkan nomor Surat Muatan Udara/Airway Bill 
					(<B>No. SMU/AWB</B>) untuk DeliveryBill <B>import</B></p>";
	} 
	elseif($_GET[psn]=='o')
	{
		$halo='Barang sudah OUT';
		echo "<p class=error>$halo</p>";
		echo "<p>INFO: <BR>Masukkan Nomor Bukti Timbang Barang (<B>No. BTB</B>) 
					untuk DeliveryBill <B>export</B>. <BR>Masukkan nomor Surat Muatan Udara/Airway Bill 
					(<B>No. SMU/AWB</B>) untuk DeliveryBill <B>import</B></p>";
	} 
	elseif($_GET[psn]=='e')
	{
		$halo='Data tidak ditemukan';
		echo "<p class=error>$halo</p>";
		echo "<p>INFO: <BR>Masukkan Nomor Bukti Timbang Barang (<B>No. BTB</B>) 
					untuk DeliveryBill <B>export</B>. <BR>Masukkan nomor Surat Muatan Udara/Airway Bill 
					(<B>No. SMU/AWB</B>) untuk DeliveryBill <B>import</B></p>";
	} 
	else
 	{
  	echo "<p>INFO: <BR>Masukkan Nomor Bukti Timbang Barang (<B>No. BTB</B>) untuk DeliveryBill
		<B>export</B>. <BR>Masukkan nomor Surat Muatan Udara/Airway Bill (<B>No. SMU/AWB</B>) untuk 
		DeliveryBill <B>import</B></p>";
 	}
}
//cetak laporan harian
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

	echo "<h2>Daily Reporting</h2>
				<form name=form1 method=POST action='aksi.php?module=kasirlapcetak'>
				<table>
				<tr><td>Tanggal </td><td>: <input type=text onKeyDown=\"javascript:return dFilter (event.keyCode, this, '##-##-####');\" name=tglawal value='$today'>"; 
				 ?>
  <a href="javascript:showCal('Caritanggalawal')"><img src="images/calendar.png" border="0"></a>
  <?
	echo "</td></tr>
				<tr><td>Proses  </td><td>: 
					<select name=outin>
					 <option value='SEMUA'>SEMUA</option>					
					 <option value='import'>import</option>
					 <option value='export'>export</option>
					</select>
				</td></tr>
				<tr><td>Jenis Pembayaran  </td><td>: 
					<select name=cara_bayar>
					 <option value='SEMUA'>SEMUA</option>
					 <option value='CASH'>CASH</option>
					 <option value='PERIODICAL'>CREDIT</option>
					</select>
				</td></tr>		
				<tr><td>Untuk  </td><td>: 
					<select name=untuk>
					 <option value='gp'>Internal GAPURA</option>
					 <option value='ap'>Angkasa Pura</option>
					</select>
				</td></tr>
				<tr><td colspan=2>
				<input type=submit value=DETIL name=bt_preview> <input type=submit value=SUMMARY name=bt_preview></td> 								
				</table>
        </form>";
	
}
//cetak laporan harian periodical
elseif (($_GET[module]=='kasirlapp')AND ($_SESSION[level]=='kasir'))
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

	echo "<h2>Periodical Reporting</h2>
				<form name=form1 method=POST action='aksi.php?module=kasirlapcetakk'>
				<table>
				<tr><td>Tanggal Awal </td><td>: <input type=text onKeyDown=\"javascript:return dFilter (event.keyCode, this, '##-##-####');\" name=tglawal value='$today'>"; 
				 ?>
  <a href="javascript:showCal('Caritanggalawal')"><img src="images/calendar.png" border="0"></a>
  <?
	echo "</td></tr>
				<tr><td>Tanggal Akhir </td><td>: <input type=text onKeyDown=\"javascript:return dFilter (event.keyCode, this, '##-##-####');\" name=tglakhir value='$today'>"; 
				 ?>
  <a href="javascript:showCal('Caritanggalakhir')"><img src="images/calendar.png" border="0"></a>
  <?
	echo "</td></tr>
	
				<tr><td>Proses  </td><td>: 
					<select name=outin>
					 <option value='SEMUA'>SEMUA</option>					
					 <option value='import'>import</option>
					 <option value='export'>export</option>
					</select>
				</td></tr>
				<tr><td>Jenis Pembayaran  </td><td>: 
					<select name=cara_bayar>
					 <option value='SEMUA'>SEMUA</option>
					 <option value='CASH'>CASH</option>
					 <option value='PERIODICAL'>CREDIT</option>
					</select>
				</td></tr>		
	      <tr><td>Agent  </td><td>: 
				<select name=agent>
				<option value='SEMUA' selected>SEMUA</option>
				<option value='ACS'>ACS</option>
				<option value='GMFAA'>GMFAA</option>
				<option value='POS'>POS</option>
				<option value='QATAR'>QATAR</option>
				
				<option value='OTHERS'>Others</option>				
</td></tr>				
				<tr><td>Untuk  </td><td>: 
					<select name=untuk>
					 <option value='gp'>Internal GAPURA</option>
					 <option value='ap'>Angkasa Pura</option>
					</select>
				</td></tr>
				<tr><td colspan=2>
				<input type=submit value=\"per Customer\" name=bt_preview> <input type=submit value=\"per Tanggal\" name=bt_preview></td> 								
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
				<option value='0' selected>import</option>
				<option value='1'>export</option>
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
				<option value='0' selected>import</option>
				<option value='1'>export</option>
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
				<option value='0' selected>import</option>
				<option value='1'>export</option>
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
$dataminhari=$r[minhari];
$datamincharge=$r[mincharge];

if($_GET[d]=='1'){//jika export
$jdl='DeliveryBill export - No. BTB : '.$_GET[n];
		$tampil=mysql_query("SELECT * FROM out_dtbarang_h where btb_nobtb='$_GET[n]' AND status_bayar='no' AND isvoid='0' AND posted='1'");
		$r=mysql_fetch_array($tampil);
		if($r[btb_totalberatbayar]<=10){$beratkalitarif=$datamincharge;}else {$beratkalitarif=round($r[btb_totalberatbayar]*$datasewagudang);}
		$dokumen=$datadokumen;
		$lama=ngitunghari($r[btb_date],$tgl)+1;
		if($lama<=0){$lama=1;}
		if($lama<($dataminhari+1)){$lamaku=1;}
		else if($lama>=($dataminhari+1)){$lamaku=$lama-2;}
		$total=round(($beratkalitarif*$lamaku)/10)*10;
		$ppn=round(($total+$dokumen)*($datappn/100));
		$total2=round($total+$dokumen+$ppn);
		//bult dsatuan !!!
		$total2sat=round($total2/10)*10;
		
		//
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
//jika import
$jdl='DeliveryBill import - No. SMU : '.$_GET[n];
		$tampil=mysql_query("
		SELECT * from breakdown,isimanifestin,manifestin 
where breakdown.id_isimanifestin=isimanifestin.id_isimanifestin AND isimanifestin.id_manifestin=manifestin.id_manifestin 
AND breakdown.status_ambil='INSTORE' AND isimanifestin.status_transit='DPS'  
AND isimanifestin.no_smu ='$_GET[n]' AND breakdown.id_breakdown='$_GET[x]' 
AND breakdown.status_bayar='no' 
AND breakdown.isvoid='0' AND breakdown.b_iscancel='0'");
$r=mysql_fetch_array($tampil);		
	
		
		if(($r[beratdatang]<=10) AND ($r[beratbayar]<=10)){$beratkalitarif=$datamincharge;}
		else {$beratkalitarif=round($r[beratbayar]*$datasewagudang);}
		
		$dokumen=$datadokumen;
		$lama=ngitunghari($r[tgldatang],$tgl)+1;
		if($lama<=0){$lama=1;}
		if($lama<($dataminhari+1)){$lamaku=1;}
		else if($lama>=($dataminhari+1)){$lamaku=$lama-2;}
		$total=round(($beratkalitarif*$lamaku)/10)*10;
		$ppn=round(($total+$dokumen)*0.1);
		$total2=round($total+$dokumen+$ppn);
			//bult dsatuan !!!
		$total2sat=round($total2/10)*10;
		
		//
 
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
			 		<td> : <input type=text size=20 value=".$r[beratbayar]." readonly=true> *</td>  
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
$nodb='DBI-'.$r[nodb];
}
else if($r[status]=='1')
{
$nodb='DBO-'.$r[nodb];
}
echo "<BR><BR><p><a href=aksi.php?module=cetakdb&n=$r[id_deliverybill] target=_blank alt='klik untuk melihat preview kuitansi sebelum di cetak' title='klik untuk melihat preview kuitansi sebelum di cetak'>Cetak Deliver Bill #$nodb</a></p>";
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
elseif (($_GET[module]=='dbexport')AND ($_SESSION[level]=='kasir')){
$tgl=date("Y-m-d");
  $p      = new Paging;
  $batas  = 50;
  $posisi = $p->cariPosisi($batas);

  
  $no     = $posisi+1;

if($_POST[carii]=='1')
{
$tampil=mysql_query("SELECT * FROM deliverybill,out_dtbarang_h where deliverybill.no_smubtb=out_dtbarang_h.btb_nobtb AND (deliverybill.no_smubtb like '%$_POST[cari]%' OR deliverybill.nosmu like '%$_POST[cari]%')ORDER BY deliverybill.id_deliverybill DESC limit $posisi,$batas");

$tampil1=mysql_query("SELECT * FROM deliverybill,out_dtbarang_h where deliverybill.no_smubtb=out_dtbarang_h.btb_nobtb AND (deliverybill.no_smubtb like '%$_POST[cari]%' OR deliverybill.nosmu like '%$_POST[cari]%')ORDER BY deliverybill.id_deliverybill DESC");

}
else
{
$tampil=mysql_query("SELECT * FROM deliverybill,out_dtbarang_h where deliverybill.no_smubtb=out_dtbarang_h.btb_nobtb ORDER BY id_deliverybill DESC limit $posisi,$batas");
$tampil1=mysql_query("SELECT * FROM deliverybill,out_dtbarang_h where deliverybill.no_smubtb=out_dtbarang_h.btb_nobtb ORDER BY id_deliverybill DESC");
$t="SELECT * FROM deliverybill,out_dtbarang_h where deliverybill.no_smubtb=out_dtbarang_h.btb_nobtb AND tglbayar =  '$tgl' AND id_carabayar='1' AND deliverybill.isVoid='0' ORDER BY id_deliverybill DESC";
}
//<a href=aksi.php?module=cetaklap&i=1 target=_blank><img src=images/printer.jpg border=0></a>
    echo "<h2>History Delivery Bill export</h2>
  

       <form name=form1 method=POST action=?module=dbexport>
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
<tr><th>no</th><th>Tgl</th><th>No. BTB</th><th>No. SMU</th><th>TOTAL BAYAR</th><th>Agent</th><th>Cara Bayar</th><th>No. DB</th><th>Keterangan</th><th>Action</th></tr>";


  while ($r=mysql_fetch_array($tampil)){
$total=round(($r[document]+$r[overtime]+$r[lain]-$r[diskon])/10)*10;
$tgl=ymd2dmy($r[tglbayar]);
//if($r[id_carabayar]=='1'){$stb='CASH';}else{$stb='PERIODICAL';}
$formatdiskon=number_format($r[diskon], 0, '.', '.');   
$formatdokumen=number_format($r[document], 0, '.', '.');   
$formatstorage=number_format($r[storage], 0, '.', '.');   
$formatlain=number_format($r[lain], 0, '.', '.');   
$formattotal=number_format($total, 0, '.', '.');   
$nodb='DBO-'.$r[nodb];
/*     echo "<tr><td>$no</td><td>$tgl</td>
          <td>$r[no_smubtb]</td><td>$r[no_smu]</td><td>$r[btb_totalberatbayar] Kg</td><td>$r[hari]</td><td>Rp.$formatstorage</td><td>Rp.$formatdiskon</td><td>Rp. $formatlain</td><td>Rp. $formattotal</td><td>$r[btb_agent]</td><td>$r[id_carabayar]</td><td>$nodb</td>
					*/

	
					
echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\"><td>$no</td><td>$tgl</td>
          <td>$r[no_smubtb]</td><td>$r[btb_smu]</td><td>Rp. $formattotal</td><td>$r[btb_agent]</td><td>$r[id_carabayar]</td>";
								 if($r[11]=='1'){echo "<td><font color=RED><B>$nodb (VOID)</B></font></td>";}
		 else {echo "<td>$nodb</td>";}
					echo "<td>$r[keterangan]</td>
					<td><a href=?module=cetakdb&n=$r[id_deliverybill] alt='klik untuk mencetak ulang kuitansi pembayaran' title='klik untuk mencetak ulang kuitansi pembayaran'><img src=images/b_print.png border=0 hspace=5></a> ";
					if(($r[status_keluar]=='INSTORE')AND ($r[11]=='0'))
					{
					echo "<a href=?module=nosmuedit&n=$r[id] alt='klik untuk melakukan editing No.SMU' title='klik untuk melakukan editing No.SMU'><img src=images/b_edit.png border=0 hspace=5></a> <a href=?module=voiddb&n=$nodb&i=$r[no_smubtb]&s=1 onclick=\"javascript:return confirm('VOID hanya dapat dilakukan bila barang sudah terbayar tapi belum keluar gudang. Proses VOID ini akan direkam beserta alasan VOID. Apakah Anda yakin akan VOID barang ini ?')\"><img src=images/b_drop.png border=0 hspace=5></a></td></tr>";
					}

     $no++;
  }
  echo "</table>";
  $jmldata      = mysql_num_rows($tampil1);
  $jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
  $linkHalaman  = $p->navHalaman($_GET[h], $jmlhalaman,'0');

  echo "<p>$linkHalaman</p>";
  
 
 
}

//Form data  DBI
elseif (($_GET[module]=='dbimport')AND ($_SESSION[level]=='kasir')){
$tgl=date("Y-m-d");
  $p      = new Paging;
  $batas  = 30;
  $posisi = $p->cariPosisi($batas);

  
  $no     = $posisi+1;

if($_POST[carii]=='1')
{
$tampil=mysql_query("SELECT * FROM deliverybill,breakdown where 
deliverybill.idbreakdown=breakdown.id_breakdown  
AND deliverybill.nosmu like '%$_POST[cari]%' ORDER BY id_deliverybill DESC limit $posisi,$batas");
$tampill=mysql_query("SELECT * FROM deliverybill,breakdown where 
deliverybill.idbreakdown=breakdown.id_breakdown 
AND deliverybill.nosmu like '%$_POST[cari]%' ORDER BY id_deliverybill DESC");
}
else
{
$tampil=mysql_query("SELECT * FROM deliverybill,breakdown where 
deliverybill.idbreakdown=breakdown.id_breakdown ORDER BY id_deliverybill DESC limit $posisi,$batas");
$tampill=mysql_query("SELECT * FROM deliverybill,breakdown where 
deliverybill.idbreakdown=breakdown.id_breakdown");
}

/*


*/

// <a href=aksi.php?module=cetaklap&i=2 target=_blank><img src=images/printer.jpg border=0></a>
    echo "<h2>History Delivery Bill import</h2>
        <form name=form1 method=POST action=?module=dbimport>
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
<tr><th>no</th><th>Tgl</th><th>No. SMU</th><th>TOTAL BAYAR</th><th>Cara Bayar</th><th>No. DB</th>
<th>Keterangan</th><th>Cetak</th></tr>";



  while ($r=mysql_fetch_array($tampil)){
$total=round(($r[document]+$r[overtime]+$r[lain]-$r[diskon])/10)*10;
$tgl=ymd2dmy($r[tglbayar]);
$formattotal=number_format($total, 0, '.', '.');   
$nodb='DBI-'.$r[nodb];
/*     echo "<tr><td>$no</td>
          <td>$r[no_smubtb]</td><td>$r[totalberat] Kg</td><td>$r[hari]</td><td>Rp.$formatstorage</td><td>Rp.$formatdiskon</td><td>Rp. $formatlain</td><td>Rp. $formattotal</td><td>$r[agent]</td><td>$r[id_carabayar]</td><td>$nodb</td>
*/
     echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\"><td>$no</td><td>$tgl</td><td>$r[no_smubtb]</td><td>Rp. $formattotal</td><td>$r[id_carabayar]</td>";
					
			 if($r[11]=='1'){echo "<td><font color=RED><B>$nodb (VOID)</B></font></td>";}
		 else {echo "<td>$nodb</td>";}
		 echo "			
					<td>$r[16]</td>

					<td>";
					echo "<a href=?module=cetakdb&n=$r[id_deliverybill] alt='klik untuk mencetak ulang kuitansi pembayaran'
					 title='klik untuk mencetak ulang kuitansi pembayaran'><img src=images/b_print.png border=0 hspace=5>
					 </a> ";
					if(($r[status_ambil]=='INSTORE')AND ($r[11]=='0'))
					{
					echo "<a href=\"?module=voiddb&n=$nodb&i=$r[no_smubtb]&s=0&b=$r[idbreakdown]\" 
					onclick=\"javascript:return confirm('VOID hanya dapat dilakukan bila barang sudah terbayar tapi belum 
					keluar gudang. Proses VOID ini akan direkam beserta alasan VOID. 
					Apakah Anda yakin akan VOID barang ini ?')\"><img src=images/b_drop.png border=0 hspace=5 alt=\"klik untuk melakukan void\" title=\"klik untuk melakukan void\"></a>					
					</td></tr>";
					}

				/*	else if(($r[status_ambil]=='OUT'))
					{
						echo "<a href=?module=cetakdb&n=$r[id_deliverybill] alt='klik untuk mencetak ulang kuitansi pembayaran'
						title='klik untuk mencetak ulang kuitansi pembayaran'><img src=images/b_print.png border=0 hspace=5>
						</a>";
					}					
         */
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
//inputkan isi SMU
elseif (($_GET[module]=='btbinput')AND ($_SESSION[level]=='btb')){
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
	$tampil=mysql_query("SELECT * FROM out_dtbarang_h where id='$_GET[i]'");
	$x=mysql_fetch_array($tampil);
	$idbtb=$x[id];


echo "<h2>BTB No. $x[btb_nobtb] - SMU No. $x[btb_smu]</h2>

        <form name=form1 method=POST action='aksi.php?module=isibtb&act=input&j=$_GET[j]'>
<table><tr><td>
       	<table>
  
       	  <tr><td>Berat Timbang</td>     <td> : <input type=text size=10 name=berat autocomplete=off onkeypress=\"return isNumberKey(event)\" value='10'></td></tr>
<tr><td>Jml Koli</td>     <td> : <input type=text size=10 name=koli autocomplete=off onkeypress=\"return isNumberKey(event)\" value='1'></td></tr>					
    	  <tr><td>Panjang</td><td> : <input type=text name=panjang size=10 autocomplete=off onkeypress=\"return isNumberKey(event)\" value='0'></td></tr>
 
		</td></tr>
<tr><td>Lebar</td>     <td> : <input type=text size=10 name=lebar autocomplete=off onkeypress=\"return isNumberKey(event)\" value='0'></td></tr>
    	  <tr><td>Tinggi</td><td> : <input type=text name=tinggi size=10 autocomplete=off onkeypress=\"return isNumberKey(event)\" value='0'></td></tr>
 
		</td></tr>												
                <tr><td colspan=2><strong>Data diisikan sesuai hasil timbang</strong></td></tr>
								<tr><td colspan=2>
												
								<input type=hidden name=i value='$_GET[i]'>
								";
								if($x[status_bayar]=='no')
								{echo "<input type=submit name=tombol value=\"Simpan\"> ";}
								
        echo "<input type=hidden name=jenisbarang><input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
</td>
<td><B><CENTER>== DAFTAR ISI BTB ==</B><BR>
</CENTER>";
	$nilai=mysql_query("select SUM(btb_totalberatbayar),SUM(btb_totalkoli),SUM(btb_totalberat),SUM(btb_totalvolume) FROM out_dtbarang_h where out_dtbarang_h.id='$_GET[i]'");
	$nn=mysql_fetch_array($nilai);
	 echo "<CENTER>(TOTAL => Berat : $nn[2] Kg, Koli : $nn[1] Pcs, Volume : $nn[3] Pcs,  <STRONG>Berat Bayar : $nn[0])</strong></center><BR> <table><tr><th>no</th>
	 <th>Berat Timbang</th><th>Koli</th><th>Panjang</th><th>Lebar</th><th>Tinggi</th>
	 <th>Berat Volume</th><th>Berat di Bayar</th> 

				 <th>Action</th>
         </tr>";

	
	$tampil=mysql_query("SELECT * FROM out_dtbarang,out_dtbarang_h
	where out_dtbarang.id_h=out_dtbarang_h.id AND out_dtbarang_h.id='$_GET[i]' 
	order by out_dtbarang_h.id DESC");

    	$no     = $posisi+1;
  	while ($r=mysql_fetch_array($tampil))
        {
				echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\"><td>$no</td>
          <td align=center>$r[dtBarang_berat]</td>
          <td align=center>$r[dtBarang_koli]</td>					
					<td align=center>$r[dtBarang_panjang]</td>
          <td align=center>$r[dtBarang_lebar]</td>
					<td align=center>$r[dtBarang_tinggi]</td>
          <td align=center>$r[dtBarang_luasdimensi]</td>
					<td align=center>$r[dtBarang_brtdibayar]</td>
					
					
				<td align=center>";
					if($x[status_bayar]=='no'){ echo "<a href=aksi.php?module=isibtb&act=hapus&h=$_GET[i]&i=$r[0] title='klik untuk cancel SMU' onclick=\"javascript:return confirm('Penghapusan masih boleh dilakukan karena belum terbayar. Apakah Anda yakin data SMU ini dibatalkan ?')\"><img src=images/b_drop.png border=0 hspace=5></a>";
					echo "</td></tr>";
					}
     	  $no++;
  	}
        echo "</table>";

echo "</td></tr></table>
     </form>";

}

//daftar BTB
elseif (($_GET[module]=='daftarbtb')AND ($_SESSION[level]=='btb')){
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

}


//Input SMU1
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
       <form name=form1 method=POST action=aksi.php?module=btb&act=input>
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

elseif (($_GET[module]=='manifestin') AND ($_SESSION[level]=='import'))
{
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
  echo "<h2>CARGO MANIFEST import</h2>
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
       <tr><td>A/C Registration</td>     
			 <td> : <input type=text size=10 name=acregistration 
			 autocomplete=off onChange=\"javascript:this.value=this.value.toUpperCase();\"> *</td></tr>
       <tr><td>Flight No</td>     
			 <td> : <input type=text size=10 name=noflight 
			 autocomplete=off onChange=\"javascript:this.value=this.value.toUpperCase();\"> *</td></tr>
       <tr><td>Tanggal Manifest</td>     
			 <td> : <input type=text onKeyDown=\"javascript:return dFilter (event.keyCode, 
			 this, '##-##-####');\" name=tglmanifest size=20 value='$tglnya'>*";
  ?>
  <a href="javascript:showCal('Caritanggal')"><img src="images/calendar.png" 
	border="0"></a>
  <?
  echo "</td></tr>
         <tr><td align=right>NIL ?</td>     
			 <td> : <input type=checkbox name=nil /> (check for NIL)</td></tr>

       	  <tr><td>Asal(NIL)</td><td> :
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
          <tr><td>Status(NIL)</td><td>";
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
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 echo "<input type=hidden name=nosmubtb value='$_GET[n]'><input type=hidden 
				name=id value='$_GET[d]'></td></tr> 
				<tr><td colspan=2> *) Wajib Diisi</td></tr>
				<tr><td colspan=2><input type=submit value='Simpan dan Breakdown'>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table><span class=error>$err</span>
        </td><td>";

  $p      = new Paging;
  $batas  = 100;
  $posisi = $p->cariPosisi($batas);
  $no     = $posisi+1;
	
  $tampil2=mysql_query("SELECT * FROM manifestin where isvoid='0' 
	ORDER BY tglmanifest DESC limit $posisi,$batas");
 	$tampil3=mysql_query("SELECT * FROM manifestin where isvoid='0' 
	ORDER BY tglmanifest DESC ");

	$jmldata      = mysql_num_rows($tampil3);
  $jmlhalaman   = $p->jumlahHalaman($jmldata, $batas);
  $linkHalaman  = $p->navHalaman($_GET[h], $jmlhalaman,'');


echo "<CENTER><b>== HISTORI MANIFEST import ==</b><BR><BR>Status <font color=RED><B>\"on progress\"</B> </font>
	berarti masih ada SMU yang belum CONFIRM. <BR>Status 
	<font color=GREEN><B>\"complete\"</B></font> berarti 
	seluruh SMU dalam Manifest ini sudah seluruhnya CONFIRM
	<BR>$linkHalaman</CENTER>
			<table><th width=70>No.Flight</th><th width=70>A/C Reg</th>
			<th width=70>Tgl</th><th width=70>Status</th><th width=130>ACTION</th></tr>";
while ($r=mysql_fetch_array($tampil2))
{
 //cek dulu apakah ada salah satu dari SMU di manifest ini sudah ada yang konfirm
 	$st=mysql_query("select count(*) from breakdown where status_check='confirm' 
 	AND id_manifestin='$r[0]'");
	$st1=mysql_fetch_array($st);
	$adacek=$st1[0];
		
 //cek dulu apakah ada salah satu dari SMU di manifest ini masihn ada yang waiting
	$st=mysql_query("select count(*) from breakdown where status_check='waiting' 
	AND id_manifestin='$r[0]' AND b_iscancel='0'");
	$st1=mysql_fetch_array($st);
	$ada=$st1[0];
	
	//jika masih ada yang waiting maka status manifest menjadi on progress
	//jika tidak ada lagi yang waiting berarti manifest tersebut sudah komplit
	if($ada<>'0') //jika ada yang waiting
	{ $stat='on progress';$cl='red'; } else {$stat='complete';$cl='green';};
	
	echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
        <td align=center>$r[noflight]</td><td align=center>$r[acregistration]</td>
				<td align=center>".ymd2dmy($r[tglmanifest])."</td><td align=center>
				<font color=$cl>$stat</font></td><td align=center> ";

	//jika belum ada satupun SMU dalam sebuah manifest ter CONFIRM maka
	//data header Manifest masih dapat diubah-ubah
	//jika sudah ada 1 saja yang ter Confirm, maka data header manifest tidak
	//dapat diubah lagi
	if($adacek=='0')//tidak ada yang confirm 
	{ 
		echo "<a href=?module=editmanifestin&i=$r[id_manifestin] 
		title='klik untuk memperbaiki data manifest import'>
		<img src=images/b_edit.png border=0 hspace=5></a>";
	}
		echo "<a href=?module=barangdatang&i=$r[id_manifestin] 
		title='klik untuk lihat barang'><img src=images/b_view.png border=0 hspace=5></a> 
		</td></tr>";
$no++;     
}
  echo "</table>";

echo "</td></tr>
	</table></form>
	</td></tr> </form>";
}


//Editing Header Manifest
elseif ($_GET[module]=='editmanifestin')
{
  ?>
  <SCRIPT LANGUAGE="JavaScript" src="cal2.js">
  </script>
  <script language="javascript">
    addCalendar("Caritanggal","Tanggal","tglmanifest","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
  </script>
  <?

//$tampil=mysql_query("SELECT * FROM manifestin where isvoid='0' AND id_manifestin='$_GET[i]' ");
$tampil=mysql_query("SELECT * FROM manifestin where isvoid='0' AND id_manifestin='$_GET[i]' ");
$r=mysql_fetch_array($tampil);
echo "<h2>CARGO MANIFEST import - EDITING</h2>
			<form name=form1 method=POST action=aksi.php?module=manifestin&act=edit>
			<table><tr><td><B>EDIT DATA HEADER MANIFEST</B><BR><table><tr>
      <td>Airline</td><td> :
      <select name=airline>";
$tampil1=mysql_query("SELECT * FROM airline ORDER BY airlinecode");
while($p=mysql_fetch_array($tampil1))
{
	if($p[airlinecode]==$r[airline])
		echo "<option value='$p[airlinecode]' selected>$p[airlinename]</option>";
 	else 
		echo "<option value='$p[airlinecode]'>$p[airlinename]</option>";
	}
echo "</select></td></tr><tr><td>A/C Registration</td>     
			<td> : <input type=text size=30 name=acregistration value='$r[acregistration]'
			onChange=\"javascript:this.value=this.value.toUpperCase();\"></td></tr>
			<tr><td>Flight No</td>     <td> : <input type=text size=30 name=noflight
			value='$r[noflight]' onChange=\"javascript:this.value=this.value.toUpperCase();\"></td></tr>
			<tr><td>Tanggal Manifest</td>     <td> : <input type=text 
			onKeyDown=\"javascript:return dFilter (event.keyCode, this, '##-##-####');\" 
			name=tglmanifest size=20 value=".ymd2dmy($r[tglmanifest])." readonly>";
?>
<a href="javascript:showCal('Caritanggal')"><img src="images/calendar.png" border="0"></a>
  <?
if($r[nil]=='on') {$n='checked=checked';
  echo "
           </td></tr><tr><td align=right>NIL ?</td>     
			 <td> : <input type=checkbox name=nil $n/> (check for NIL)</td></tr>
       	  <tr><td>Asal Airport(NIL)</td><td> :
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


          <tr><td>Status(NIL)</td><td>";
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
		</td></tr>";	} else {$n='';
		  echo "
           </td></tr><tr><td align=right>NIL ?</td>     
			 <td> : <input type=checkbox name=nil $n/> (check for NIL)</td></tr>";
       	  
		
		}

		 
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 echo "<input type=hidden name=i value='$_GET[i]'></td></tr>
				<td colspan=2><strong><center>*) wajib diisi, jika kosong maka data tidak akan 
				tersimpan.</strong></center></td></tr>	
				<tr><td colspan=2><input type=submit value='UPDATE'>
				<input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>";
}				

//Input data isi manifest
elseif (($_GET[module]=='manifestininput')AND ($_SESSION[level]=='import')){
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
	$tampil=mysql_query("SELECT * FROM manifestin where id_manifestin='$_GET[i]'");
	$r=mysql_fetch_array($tampil);
	$idmanifestin=$r[id_manifestin];
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
					(event.keyCode, this, '###-#### ### ### ###');\" size=20 
					name=nosmu autocomplete=off onChange=\"javascript:this.value=this.value.toUpperCase();\" value=";
					if($_GET[n]=='')
					{
						if(($_GET[airline]=='GA') OR ($_POST[airline]=='GA')) {$a='126-';} else {$a='000-00';}
					}
					else 
					{
					$a=$_GET[n];
					}
					echo "\"$a\">
					<input type=submit value=\"Cek\" name=tombol>
					</td></tr>
          <tr><td>Komoditi</td>     <td> :
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
						<option value='POST' selected>POS</option>
						<option value='GMFAA'>GMFAA</option>
						<option value='ACS'>ACS</option>
										<option value='QATAR'>QATAR</option>";
						 		
					}
					elseif($tp[agent]=='GMFAA')
					{
						echo "<option value=''>-</option>
						<option value='POST'>POS</option>
						<option value='GMFAA' selected>GMFAA</option>
						<option value='ACS'>ACS</option>
										<option value='QATAR'>QATAR</option>"; 		
					}
					elseif($tp[agent]=='ACS')
					{
						echo "<option value=''>-</option>
						<option value='POST'>POS</option>
						<option value='GMFAA'>GMFAA</option>
						<option value='ACS' selected>ACS</option>
										<option value='QATAR'>QATAR</option>"; 		
					}		
					elseif($tp[agent]=='QATAR')
					{
						echo "<option value=''>-</option>
						<option value='POST'>POS</option>
						<option value='GMFAA'>GMFAA</option>
						<option value='ACS'>ACS</option>
										<option value='QATAR' selected>QATAR</option>"; 		
					}										
					else
					{
						echo "<option value='' selected>-</option>
						<option value='POST'>POS</option>
						<option value='GMFAA'>GMFAA</option>
						<option value='ACS'>ACS</option>
										<option value='QATAR'>QATAR</option>"; 		
					}					
		  echo "</select> 
       	  <tr><td>Koli</td>     <td> : <input type=text size=10 name=totalkoli autocomplete=off onkeypress=\"return isNumberKey(event)\" value='$_GET[k]'></td></tr>
    	  <tr><td>Berat</td><td> : <input type=text name=totalkg size=10 autocomplete=off onkeypress=\"return isNumberKey(event)\" value='$_GET[b]'></td></tr>
       	  <tr><td>Asal</td><td> :
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
			if($_POST[airline]=='')
			{
			$air=$_GET[airline];
			}
			else
			{
			$air=$_POST[airline];
			}
  		echo "</select>
		</td></tr>
                <tr><td colspan=2><strong>Data diisikan sesuai Manifest kedatangan</strong></td></tr>
								<tr><td colspan=2>
								<input type=hidden name=airline value='$air'>								
								<input type=hidden name=k value='$_GET[k]'>
								<input type=hidden name=b value='$_GET[b]'>
								<input type=hidden name=a value='$_GET[a]'>																
								<input type=hidden name=idman value='$idmanifestin'>
								<input type=hidden name=idisiman value='$idisiman'>								
								<input type=hidden name=tglmanifest value='$tglman'>
								<input type=submit name=tombol value=\"Simpan\">
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
	$tampil=mysql_query("SELECT * FROM breakdown,isimanifestin where breakdown.id_isimanifestin = isimanifestin.id_isimanifestin AND breakdown.id_manifestin='$idmanifestin' and breakdown.isvoid='0' ORDER BY id_breakdown DESC");

    	$no     = $posisi+1;
  	while ($r=mysql_fetch_array($tampil))
        {
        	if($r[status]=='DPS'){$tuju='DPS';}else {$tuju=$r[tujuan];}
     	   echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\"><td>$no</td>
          <td>$r[no_smu]</td><td align=center>$r[kolidatang]</td><td align=center>$r[beratdatang]</td><td align=center>$tuju</td><td align=center>";
					if(($r[status_check]=='waiting') AND ($r[b_iscancel]=='0')){ echo "<a href=?module=isimanifestindel&n=$r[id_isimanifestin]&b=$r[id_breakdown]&i=$_GET[i] title='klik untuk cancel SMU' onclick=\"javascript:return confirm('CANCEL hanya dilakukan pada SMU yang batal datang. Jika memang cancel, Anda harus melengkapi alasannya setelah ini.CANCEL hanya bisa dilakukan pada data SMU yang masih berstatus WAITING. Apakah Anda yakin data SMU ini dibatalkan ?')\"><img src=images/b_drop.png border=0 hspace=5></a>";
					
					
					/*echo "<a href=\"aksi.php?module=isimanifestin&act=hapus&i=$r[id_isimanifestin]&b=$r[id_breakdown]\" onclick=\"javascript:return confirm('Penghapusan data diperbolehkan dan tidak akan direkam karena SMU ini belum CONFIRM. Apakah Anda yakin SMU ini akan dihapus ?')\">
					<img src=images/b_drop.png border=0 alt=\"klik untuk menghapus\" title=\"klik untuk menghapus\"></a>
					*/
					echo "</td></tr>";
					}
     	  $no++;
  	}
        echo "</table>";

echo "</td></tr></table>
     </form>";

}

//Edit Isi dari Manifest
elseif (($_GET[module]=='editisimanifestin')AND ($_SESSION[level]=='import'))
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
elseif (($_GET[module]=='barangdatang')AND ($_SESSION[level]=='import')){
if($_POST[i]=='') //i digunakan untuk menyimpan id manifest
{$i=$_GET[i];} 
else {$i=$_POST[i];}

$dataman=mysql_query("SELECT * from manifestin where id_manifestin='$i'"); 
$r=mysql_fetch_array($dataman);
$tgl=ymd2dmy($r[tglmanifest]);
$tgl1=my2date($_POST[cari]);

$p      = new Paging;
$batas  = 50;
$posisi = $p->cariPosisi($batas);
$no     = $posisi+1;

//hitung jumlah total berat datang dan koli datang dalam sebuah manifest
$a=mysql_query("SELECT SUM(beratdatang),SUM(kolidatang) 
	FROM breakdown,isimanifestin where 
	breakdown.id_isimanifestin=isimanifestin.id_isimanifestin
	AND breakdown.id_manifestin='$i'  
	AND breakdown.isvoid='0'");	
$instok=mysql_fetch_array($a);	
	
if($_POST[carii]=='1')
{
	$tampill=mysql_query("SELECT * FROM breakdown,isimanifestin where 
	breakdown.id_isimanifestin = isimanifestin.id_isimanifestin AND	
	breakdown.id_manifestin='$i' and breakdown.isvoid='0' AND isimanifestin.no_smu like	
	'%$_POST[cari]%' ORDER BY id_breakdown DESC");
}
else
{
	$tampill=mysql_query("SELECT * FROM breakdown,isimanifestin where	
	breakdown.id_isimanifestin = isimanifestin.id_isimanifestin AND	
	breakdown.id_manifestin='$i' and breakdown.isvoid='0' ORDER BY id_breakdown DESC");
}
$tglnya=date("d-m-Y");

echo "<h2>Isi Cargo Manifest => $r[airline] : A/C Reg.$r[acregistration] 
			Flight No.$r[noflight] / $tgl | $instok[0] Kg / $instok[1] Koli</h2>
      <form name=form1 method=POST action=?module=barangdatang>
      <table>
      <tr><td>Cari No.SMU</td><td> : <input type=text size=30 name=cari onKeyDown=\"javascript:return dFilter (event.keyCode, this, '###-#### ### #');\">
			<input type=hidden name=carii value=1><input type=hidden name=i value='$i'>
			<input type=submit value=CARI DATA>
      <input type=button value=Batal onclick=self.history.back()>
			</table></form>";
			if($r[nil]<>'on'){ echo "<a href='?module=manifestininput&act=input&idman=$_GET[i]&i=$_GET[i]&airline=$r[airline]'<img src=images/joined_lg.gif border=0 alt=\"menambah data\" title=\"menambah data\"></a><BR>";}
			else { echo "NUL MANIFEST !";}

echo "<table>
        <tr>
					<th align=center>no</th>
					<th align=center>No. SMU</th>
					<th align=center width=30>KOLI </th>
					<th align=center width=30>BERAT AKT</th>
					<th align=center width=30>KOLI DTG</th>	
					<th align=center width=30>BERAT DTG</th>			
					<th align=center width=30>BERAT BAYAR</th>
					<th align=center width=100>KOMODITI</th>
					<th align=center width=30>AGENT</th>	
					<th align=center width=30>ASAL</th>			
					<th align=center width=30>TUJUAN</th>
					<th align=center>STATUS</th><th>Action</th>
				</tr>";

  while ($r=mysql_fetch_array($tampill))
	{
  $tglnya=ymd2dmy($r[tgl]);

	//untuk status SMU, sudah di cek untuk CONFIRM atau belum Waiting
	if($r[status_check]=='waiting')
	{$cl='red';}else{$cl='green';}
	
	//untuk membedakan warna status CANCEL
	if($r[b_iscancel]=='1'){$st='cancel';$cl='yellow';}else {$st=$r[status_check];}
	
echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\">
		 <td align=center>$no</td>
		 <td align=center>$r[no_smu]</td>
		 <td align=center>$r[totalkoli]</td>		 
		 <td align=center>$r[totalberat]</td>
		 <td align=center>$r[kolidatang]</td>
		 <td align=center>$r[beratdatang]</td>
		 <td align=center>$r[beratbayar]</td>		
		 <td align=left>$r[jenisbarang]</td>
		 <td align=center>$r[agent]</td>
		 <td align=center>$r[asal]</td>
		 <td align=center>$r[tujuan]</td>				  
		 <td align=center><font color=$cl>$st</font></td>";
				  
//jika status SMU masih WAITING 
if(($r[status_check]=='waiting') AND ($r[b_iscancel]=='0'))
	{
		echo "<td align=center>
		<a href=?module=isimanifestindel&n=$r[id_isimanifestin]&b=$r[id_breakdown]&i=$i title='klik untuk cancel SMU' onclick=\"javascript:return confirm('CANCEL hanya dilakukan pada SMU yang batal datang. Jika memang cancel, Anda harus melengkapi alasannya setelah ini.CANCEL hanya bisa dilakukan pada data SMU yang masih berstatus WAITING. Apakah Anda yakin data SMU ini dibatalkan ?')\"><img src=images/b_drop.png border=0 hspace=5></a>
		<a href=?module=breakdownedit&n=$r[id_isimanifestin]&b=$r[id_breakdown]&i=$i title='klik untuk update data sesuai dgn SMU datang' onclick=\"javascript:return confirm('Editing hanya dilakukan untuk SMU yang datanya	tidak sesuai dengan data MANIFEST INPUT. Apakah Anda yakin akan mengedit data sesuai SMU ?')\"><img src=images/b_edit.png border=0 hspace=5></a>
		<a href=aksi.php?module=manifestin&act=smuchecked&i=$_GET[i]&b=$r[id_breakdown] 		 title='klik untuk confirm barang datang' onclick=\"javascript:return confirm('Status CONFIRM berarti melakukan konfirmasi bahwa cargo untuk No.SMU ini telah tiba dan di verifikasi/cek. SMU ini tidak dapat dihapus atau diedit setelah CONFIRM. Apakah Anda yakin ? ')\"><img src=images/b_usrcheck.png border=0 hspace=5></a>";
	}
		else {echo"<td></td>";}

	echo" </tr>";
  $no++;
}
  echo "</table>";
}

//Pecah SMU
elseif (($_GET[module]=='splitsmu') AND ($_SESSION[level]=='import'))
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

echo "<CENTER><b>== SPLIT SMU import ==</b></CENTER> 
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
elseif (($_GET[module]=='breakdownedit')AND($_SESSION[level]=='import')){
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

$tampil=mysql_query("select * from breakdown,isimanifestin where breakdown.id_isimanifestin=isimanifestin.id_isimanifestin AND breakdown.id_breakdown='$_GET[b]'");
$r=mysql_fetch_array($tampil);
$kol=$r[kolidatang];
$ber=$r[beratdatang];

//cek dulu apakah SMU ini (jika split) sudah ada yang CONFIRM
$st=mysql_query("select count(*) from breakdown where status_check='confirm' AND id_isimanifestin='$_GET[n]'");
$st1=mysql_fetch_array($st);
$adacek=$st1[0];


echo "<h2>Edit Breakdown No. SMU : $r[no_smu]</h2>
      <form name=form1 method=POST action=aksi.php?module=isimanifestin&act=edit>
      <table>";		
				
//jika belum ada yang CONFIRM maka seluruh data SMU dapat diedit
if($adacek=='0')
{
echo "<tr><td>No SMU</td><td> : <input type=text onKeyDown=\"javascript:return dFilter (event.keyCode, this, '###-####-### #');\" name=no_smu size=40 value='$r[no_smu]' onChange=\"javascript:this.value=this.value.toUpperCase();\"></td></tr><tr><td>Jenis Barang</td><td> : <select name=jenisbarang>";
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
			
     	  <tr><td>Jumlah Koli di SMU </td><td> : <input type=text name=totalkoli size=10 value=$r[totalkoli] onkeypress=\"return isNumberKey(event)\" autocomplete=off> -> Datang : <input type=text name=totalkolidatang size=10 value=$kol onkeypress=\"return isNumberKey(event)\" autocomplete=off></td></tr>
    	  <tr><td>Berat Aktual di SMU</td><td> : <input type=text name=totalberat size=10 value=$r[totalberat] onkeypress=\"return isNumberKey(event)\" autocomplete=off> -> Datang : <input type=text name=totalberatdatang size=10 value=$ber onkeypress=\"return isNumberKey(event)\" autocomplete=off></td></tr>      	  
     	  <tr><td>Berat Di Bayar </td><td> : <input type=text name=totalberatbayar size=10 value=$r[beratbayar] onkeypress=\"return isNumberKey(event)\" autocomplete=off></td></tr>				
				
				<tr><td>Agent</td><td> :
          <select name=agent>";
					if($r[agent]=='POST')
					{
						echo "<option value=''>-</option>
						<option value='POST' selected>POST</option>
						<option value='GMFAA'>GMFAA</option>
						<option value='ACS'>ACS</option>
						<option value='QATAR'>QATAR</option>"; 		
					}
					elseif($r[agent]=='GMFAA')
					{
						echo "<option value=''>-</option>
						<option value='POST'>POST</option>
						<option value='GMFAA' selected>GMFAA</option>
						<option value='ACS'>ACS</option>
						<option value='QATAR'>QATAR</option>"; 		
					}
					elseif($r[agent]=='ACS')
					{
						echo "<option value=''>-</option>
						<option value='POST'>POST</option>
						<option value='GMFAA'>GMFAA</option>
						<option value='ACS' selected>ACS</option>
						<option value='QATAR'>QATAR</option>"; 		
					}		
					elseif($r[agent]=='QATAR')
					{
						echo "<option value=''>-</option>
						<option value='POST'>POST</option>
						<option value='GMFAA'>GMFAA</option>
						<option value='ACS'>ACS</option>
						<option value='QATAR' selected>QATAR</option>"; 		
					}									
					else
					{
						echo "<option value='' selected>-</option>
						<option value='POST'>POST</option>
						<option value='GMFAA'>GMFAA</option>
						<option value='ACS'>ACS</option>
						<option value='QATAR'>QATAR</option>"; 		
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
		</td></tr>";
}

//jika ternyata SMU adalah split dan sudah ada yang melakukan CONFIRM, maka
// data tidak dapat diedit kecuali sisa kedatangan
else
{
   echo "
		<tr><td>No SMU</td><td> : $r[no_smu]</td></tr>		
          <tr><td>Komoditi</td>     <td> :$r[jenisbarang]
          </td></tr>
			
     	  <tr><td>Jumlah Koli di SMU </td><td> : $r[totalkoli] -> Datang : <input type=text name=totalkolidatang size=10 value=$kol onkeypress=\"return isNumberKey(event)\" autocomplete=off></td></tr>
    	  <tr><td>Berat Aktual di SMU</td><td> : $r[totalberat] -> Datang : <input type=text name=totalberatdatang size=10 value=$ber onkeypress=\"return isNumberKey(event)\" autocomplete=off></td></tr>      	  
     	  <tr><td>Berat Di Bayar </td><td> : <input type=text name=totalberatbayar size=10 value=$r[beratbayar] onkeypress=\"return isNumberKey(event)\" autocomplete=off></td></tr>				
				
				<tr><td>Agent</td><td> :$r[agent]</td></tr>
         

       	  <tr><td>Asal Airport</td><td> :$r[asal]</td></tr>
         


          <tr><td>Status</td><td> : $r[status_transit]</td></tr>
		  
		</td></tr>";}

echo "		<tr><td colspan=2><strong>Data diisikan sesuai dengan riil kedatangan dokumen SMU/Cargo</strong></td></tr>
                <tr><td colspan=2><input type=submit value='UPDATE'>
        <input type=button value=Batal onclick=self.history.back()>
		<input type=hidden name=n value='$r[id_isimanifestin]'>
		<input type=hidden name=i value='$_GET[i]'>
		<input type=hidden name=a value='$_GET[a]'>
		<input type=hidden name=b value='$_GET[b]'>	
				<input type=hidden name=adacek value='$adacek'>	
		</td></tr>
	   
        </table>
        </form>";


}

//*****CANCEL SMU - Ada di Manifest, tetapi tidak ada barang datang
elseif (($_GET[module]=='isimanifestindel')AND($_SESSION[level]=='import')){
$tampil=mysql_query("select * from isimanifestin where id_isimanifestin='$_GET[n]'");
$r=mysql_fetch_array($tampil);
echo "<h2>Cancel  No. SMU : $r[no_smu]</h2>
	<form name=form1 method=POST action=aksi.php?module=isimanifestin&act=cancel>
  <table>
	<tr><td>Keterangan</td><td> : <input type=text name=keterangan_void size=60 
	autocomplete=off></td></tr>
	</td></tr>
	<tr><td colspan=2><input type=submit value='SIMPAN'>
  <input type=button value=Batal onclick=self.history.back()>
	<input type=hidden name=n value='$r[id_isimanifestin]'>
	<input type=hidden name=i value='$_GET[i]'>
	<input type=hidden name=b value='$_GET[b]'>		
	<input type=hidden name=nosmu value='$r[no_smu]'>		
	</td></tr>
  </table>
  </form>";
}

//Form cetak stockopname import
elseif (($_GET[module]=='stockopnamein')AND($_SESSION[level]=='import')){
$tglnya=date("Y-m-d");
$tgl=ymd2dmy($tglnya);


$a=mysql_query("SELECT SUM(beratdatang),SUM(kolidatang) 
	FROM breakdown,isimanifestin where 
	breakdown.id_isimanifestin=isimanifestin.id_isimanifestin 
	AND breakdown.isvoid='0' AND breakdown.b_iscancel='0' 
	AND breakdown.status_ambil='INSTORE'
	AND breakdown.status_check='confirm'");	
$instok=mysql_fetch_array($a);
	
	$no=1;
if($_POST[carii]=='1')
{

		$tampill=mysql_query("SELECT * FROM breakdown,isimanifestin,manifestin where 
	breakdown.id_isimanifestin=isimanifestin.id_isimanifestin AND 
	isimanifestin.id_manifestin=manifestin.id_manifestin AND
	isimanifestin.isvoid='0' AND isimanifestin.no_smu like '%$_POST[cari]%' AND
	breakdown.b_iscancel='0' AND breakdown.isvoid='0' 
	AND breakdown.status_check='confirm' AND breakdown.status_ambil='INSTORE'
	GROUP by isimanifestin.id_isimanifestin 
	order by tgldatang DESC");
}
else
{
	
	$tampill=mysql_query("SELECT * FROM breakdown,isimanifestin,manifestin where 
	breakdown.id_isimanifestin=isimanifestin.id_isimanifestin AND 
	isimanifestin.id_manifestin=manifestin.id_manifestin AND	
	isimanifestin.isvoid='0' AND breakdown.b_iscancel='0' AND breakdown.isvoid='0' 
	AND breakdown.status_check='confirm' AND breakdown.status_ambil='INSTORE'
	GROUP by isimanifestin.id_isimanifestin 
	order by tgldatang DESC");
}




   echo "<h2>Kondisi Gudang import Per Tanggal : $tgl | $instok[0] Kg / $instok[1] Koli</h2>
				<p><a href=aksi.php?module=cetakstockopnamein target=_blank>Klik Disini untuk cetak STOCKOPNAME import Checklist</a></p>
				       <form name=form1 method=POST action=?module=stockopnamein>
        <table>
        <tr><td>Cari No.SMU</td>     <td> : <input type=text size=30 name=cari>
		<input type=hidden name=carii value=1><input type=hidden name=i value='$i'><input type=submit value=CARI DATA>
        <input type=button value=Batal onclick=self.history.back()>

        </table>
        </form>
				<table>
        <tr><th>no</th><th>No.SMU/AWB</th><th>Tgl Datang</th><th>No Flight</th><th>Total Koli</th><th>Total Berat</th><th>Bayar</th><th>Action</th></tr>";
  while ($r=mysql_fetch_array($tampill)){
$tgldatang=ymd2dmy($r[tgldatang]);
$tglambil=ymd2dmy($r[tglambil]);
     echo "";


		 	echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\"><td>$no</td><td align='center'>$r[no_smu]</td><td align='center'>$tgldatang</td><td align='center'>$r[noflight]</td><td align='right'>$r[kolidatang]</td><td align='right' >$r[beratdatang]</td><td align='center'>$r[status_bayar]</td>";
	
		 if(($r[status_bayar]=='yes') AND ($r[status_ambil]=='INSTORE'))
		 {
		 	echo "<td><a href=aksi.php?module=keluarbarangin&i=$r[id_breakdown] onclick=\"javascript:return confirm('Barang hanya bisa dikeluarkan dari Gudang jika sudah terbayar. Apakah Anda yakin mengeluarkan barang ini dari Gudang import ?')\">[Keluarkan]</a>";
		 }
		 else
		 {
		  echo "<td>";
		 }
		 
		 
		 echo "</td></tr>";
     $no++;
  }
  echo "</table>";

	echo "</td></tr></table></form>";
}


//************************END OF export ***************************************************


//*************************** begin of level export **************************************
//LEVEL export
//batal manifest out
elseif (($_GET[module]=='batalmo')AND($_SESSION[level]=='export')){
$str=mysql_query("select * from manifestout where id_manifestout='$_GET[i]'");
$r=mysql_fetch_array($str);
$tgl2=ymd2dmy($r[tglmanifest]);
    echo "<h2>Pembatalan Manifest Out $r[airline] : A/C Reg.$r[acregistration] Flight No.$r[noflight] / $tgl2</h2>
       <form name=form1 method=POST action=aksi.php?module=batalmo>
        <table>	
    	  <tr><td>Keterangan</td><td> : <input type=text name=keterangan size=60></td></tr>
		</td></tr>
                <tr><td colspan=2><input type=submit value='OK'>
        <input type=button value=BACK onclick=self.history.back()>
		<input type=hidden name=i value='$_GET[i]'>
		</td></tr>
	   
        </table>
        </form>";
}

//Input Header Manifest
elseif (($_GET[module]=='manifestout') AND ($_SESSION[level]=='export'))
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

if($r[nil]=='on') {$n='checked=checked';} else {$n='';}
		
		

  echo "<h2>CARGO MANIFEST export - EDITING</h2>
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
	 echo "
           </td></tr><tr><td align=right>NIL ?</td>     
			 <td> : <input type=checkbox name=nil $n/> (check for NIL)</td></tr>
<input type=hidden name=i value='$_GET[i]'></td></tr>
	<tr><td colspan=2><input type=submit value='UPDATE'>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>";
}				

//Input data isi manifest
elseif (($_GET[module]=='manifestoutinput')AND ($_SESSION[level]=='export')){
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
$ni=$r[nil];
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
	
		//kalau tdk ada di BTB baru cek di import
		/*$str=mysql_query("SELECT * FROM isimanifestin,manifestin where isimanifestin.no_smu='$_GET[n]' 
		AND manifestin.status='checked' AND isimanifestin.isvoid='0' AND isimanifestin.status_transit='TRANSIT'  
		AND isimanifestin.status_out='INSTORE'");
		$pr=mysql_fetch_array($str);*/

		$breakdata=mysql_query("SELECT *,SUM(kolidatang) AS bkolidatang,
		SUM(beratdatang) AS bberatdatang FROM breakdown,isimanifestin where 
		breakdown.id_isimanifestin=isimanifestin.id_isimanifestin AND isimanifestin.status_transit='TRANSIT' 
		AND breakdown.status_check='confirm'
		AND isimanifestin.no_smu='$_GET[n]' GROUP BY breakdown.id_isimanifestin");
		$p=mysql_fetch_array($breakdata);
		
		$tkoli=mysql_query("SELECT SUM(koli) AS totkoli,SUM(berat) AS totberat FROM buildup where 
		buildup.nosmu='$_GET[n]'");
		/*
		$tkoli=mysql_query("SELECT SUM(koli) AS totkoli,SUM(berat) AS totberat FROM buildup where 
		buildup.nosmu='$_GET[n]' AND status_keluar='INSTORE'");		
		*/

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
								if(($c=='waiting') AND ($ni<>'on')) {echo "<input type=submit name=tombolsimpan value='Simpan dan Tambah'>
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
		 if($ni=='on') echo "MANIFEST NIL !!";
echo "</td></tr></table>
     </form>";

}


//Edit Isi dari Manifest
elseif (($_GET[module]=='editisimanifestout')AND ($_SESSION[level]=='export'))
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
elseif (($_GET[module]=='barangkeluar')AND ($_SESSION[level]=='export')){

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
elseif (($_GET[module]=='splitsmu') AND ($_SESSION[level]=='export'))
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

echo "<CENTER><b>== SPLIT SMU export ==</b></CENTER> 
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
elseif (($_GET[module]=='breakdownedit')AND($_SESSION[level]=='export')){
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
elseif (($_GET[module]=='isimanifestoutdel')AND($_SESSION[level]=='export')){
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

//Form cetak stockopname export
elseif (($_GET[module]=='stockopnameout')AND($_SESSION[level]=='export')){
$tglnya=date("Y-m-d");
$tgl=ymd2dmy($tglnya);
mysql_query("delete from stockopnameout");

/*
PROSES MENGHITUNG STOCKOPNAME
proses ini menggunakan bantuan tabel stockopnameout
stockopname dibagi 2 proses yaitu :
 1. penghitungan untuk AWB yang SUDAH di MANIFEST EXPORT, confirm/tdk, split/tdk :
     1.1 yg sudah CONFIRM
     1.2 sisa nya
 2. penghitungan untuk AWB yang BELUM SAMA SEKALI di MANIFIEST EXPORT
*/

// 1. penghitungan untuk AWB yang SUDAH di MANIFEST EXPORT, confirm/tdk, split/tdk
//daftar awb yang sudah CONFIRM di manifest export -> m.statusconfirm=1:
$manifest_confirm=mysql_query("select s.idmastersmu,s.nosmu,s.tglsmu,sum(i.berat) as berat,sum(i.koli) as koli 
FROM master_smu as s, isimanifestout as i, manifestout as m
WHERE m.idmanifestout=i.idmanifestout AND 
i.idmastersmu=s.idmastersmu AND i.statusvoid='0' AND s.isvoid='0' 
AND m.statusvoid='0' AND m.statuscancel='0' AND m.statusconfirm='1' GROUP BY s.idmastersmu");

//menghitung jumlah barang tersisa untuk awb yang sudah terconfirm di manifest
$tberat=0;$tkoli=0;
while ($r=mysql_fetch_array($manifest_confirm))
 {
	 //data berat koli awb yang confirm secara keseluruhan
	$data0=mysql_fetch_array(mysql_query("SELECT nosmu,berat,koli,tglsmu,idorigin,iddestination 
	FROM master_smu where  
	 idmastersmu='$r[idmastersmu]' and isvoid='0'"));
	// data berat koli -> awb yang di confirm
	$data1=mysql_fetch_array(mysql_query("SELECT SUM(i.berat) as berat,SUM(i.koli) as koli 
	FROM isimanifestout as i, manifestout as m where m.idmanifestout=i.idmanifestout AND 
	 i.idmastersmu='$r[idmastersmu]'  and i.statusvoid='0' and i.statuscancel='0' AND 
	m.statusvoid='0' and m.statuscancel='0' AND m.statusconfirm='1' GROUP BY i.idmastersmu"));
	
	//total berat awb yang di confirm
	$berat=$data0[berat]-$data1[berat];
	//total berat datang awb
	$berat_of=$data0[berat];
	//total koli awb yang di confirm
	$koli=$data0[koli]-$data1[koli];
	//total koli datang awb
	$koli_of=$data0[koli];
	
	if(($berat<>'0') AND ($koli<>'0'))
	{
			//simpan ke tabel stockopnameout
		mysql_query("insert into stockopnameout 
		values('$data0[nosmu]','$data0[tglsmu]','$berat','$koli',
		'$data0[berat]','$data0[koli]','$data0[idorigin]','$data0[iddestination]')");
		 $tberat+=$berat;$tkoli+=$koli;
	}
  }

//end of  penghitungan untuk AWB yang SUDAH di MANIFEST EXPORT, confirm/tdk, split/tdk  

//  2. penghitungan untuk AWB yang BELUM SAMA SEKALI di MANIFEST EXPORT 
//daftar semua AWB di database
$nomanifest=mysql_query("select s.idmastersmu,s.nosmu,s.tglsmu,s.berat,s.koli,s.idorigin,s.iddestination 
FROM master_smu as s WHERE s.isvoid='0'");

while ($r=mysql_fetch_array($nomanifest))
{
	//cari apakah AWB ini sudah ada di tabel manifest dan confirm dan tdk void & tdk cancel
	$st=mysql_num_rows(mysql_query("select i.idmastersmu 
	from isimanifestout as i,manifestout as m 
	WHERE m.idmanifestout=i.idmanifestout AND i.statusvoid='0' AND i.statuscancel='0' 
	AND m.statusvoid='0' AND m.statuscancel='0' AND m.statusconfirm='1' 
	AND i.idmastersmu='$r[idmastersmu]'")); 
	if($st<=0)
	{
		mysql_query("insert into stockopnameout 
		values('$r[nosmu]','$r[tglsmu]','$r[berat]','$r[koli]',
		'$r[berat]','$r[koli]','$r[idorigin]','$r[iddestination]')");
		 $tberat+=$berat;$tkoli+=$koli;
	}
}
// end of penghitungan untuk AWB yang BELUM SAMA SEKALI di MANIFIEST EXPORT 
//-------------------------------
$jml=mysql_fetch_array(mysql_query("select count(nosmu) as jsmu,sum(berat) as jberat,sum(koli) as jkoli from stockopnameout"));

  echo "<h2>Kondisi Gudang EXPORT Per : $tgl | 
			".number_format($jml[jsmu], 0, ',', '.')." AWB : 
			".number_format($jml[jkoli], 0, ',', '.')." Koli / 
			".number_format($jml[jberat] , 1, ',', '.')." Kg </h2>
		<p><a href=aksi.php?module=cetakstockopnameout target=_blank>[Cetak Stockopname] </a> <a href=#join>[Joining] </a> <a href=#transit>[Transit] </a></p>";
//hitung berat joining
$jml=mysql_fetch_array(mysql_query("select  count(s.nosmu) as jsmu,sum(s.berat) as jberat,sum(s.koli) as jkoli from stockopnameout as s,origin as o, destination as d WHERE s.idorigin=o.idorigin AND s.iddestination = d.iddestination 
AND o.origin_code='DPS'"));
echo "<p><a name=join id=join>JOINING</a> -> 			".number_format($jml[jsmu], 0, ',', '.')." AWB : 
			".number_format($jml[jkoli], 0, ',', '.')." Koli / 
			".number_format($jml[jberat] , 1, ',', '.')." Kg</p>
<table><tr><th>no</th><th>#AWB / Date</th><th>Kg</th><th>Koli</th>
<th>ORG</th><th>DEST</th>";
$no=1;  

$data=mysql_query("select s.*,o.origin_code,d.dest_code from stockopnameout as s,origin as o, destination as d WHERE s.idorigin=o.idorigin AND s.iddestination = d.iddestination 
AND o.origin_code='DPS' order by d.dest_code ASC");
while ($r=mysql_fetch_array($data))
  {
	echo "<tr><td>$no</td><td align=center>".format_awb($r[nosmu])." / ".ymd2dmy($r[tglsmu])."</td><td align=right width=80>$r[berat] of $r[berat_of]</td><td align=right width=80>$r[koli] of $r[koli_of]</td><td align=center width=40>$r[origin_code]</td><td align=center width=40>$r[dest_code]</td></tr>";
    $no++;		
	}
  echo "</table>
<p><a href=aksi.php?module=cetakstockopnameout target=_blank>[Cetak Stockopname] </a> <a href=#join>[Joining] </a> <a href=#transit>[Transit] </a></p><BR>";
//utk transit :
//hitung berat transit
$jml=mysql_fetch_array(mysql_query("select  count(s.nosmu) as jsmu,sum(s.berat) as jberat,sum(s.koli) as jkoli from stockopnameout as s,origin as o, destination as d WHERE s.idorigin=o.idorigin AND s.iddestination = d.iddestination 
AND o.origin_code<>'DPS'"));
echo "<p><a name=transit id=transit>TRANSIT -> 			".number_format($jml[jsmu], 0, ',', '.')." AWB : 
			".number_format($jml[jkoli], 0, ',', '.')." Koli / 
			".number_format($jml[jberat] , 1, ',', '.')." Kg</p>
<table><tr><th>no</th><th>#AWB / Date</th><th>Kg</th><th>Koli</th>
<th>ORG</th><th>DEST</th>";
$no=1;  
$data=mysql_query("select s.*,o.origin_code,d.dest_code from stockopnameout as s,origin as o, destination as d WHERE s.idorigin=o.idorigin AND s.iddestination = d.iddestination 
AND o.origin_code<>'DPS' order by d.dest_code ASC");
while ($r=mysql_fetch_array($data))
  {
	echo "<tr><td>$no</td><td align=center>".format_awb($r[nosmu])." / ".ymd2dmy($r[tglsmu])."</td><td align=right width=80>$r[berat] of $r[berat_of]</td><td align=right width=80>$r[koli] of $r[koli_of]</td><td align=center width=40>$r[origin_code]</td><td align=center width=40>$r[dest_code]</td></tr>";
    $no++;		
	}
  echo "</table>
		<p><a href=aksi.php?module=cetakstockopnameout target=_blank>[Cetak Stockopname] </a> <a href=#join>[Joining] </a> <a href=#transit>[Transit] </a></p>";  
}
// end of stockname export

//************************END OF export ***************************************************
//******************************************************************************************





//****************** SUPERVISOR **************//
elseif (($_GET[module]=='daily_report')AND ($_SESSION[level]=='supervisor'))
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

	echo "<h2>Daily Report</h2>
				<form name=form1 method=POST action='aksi.php?module=daily_cargo'>
				<table>
				<tr><td>Tanggal  </td><td>: <input type=text onKeyDown=\"javascript:return dFilter (event.keyCode, this, '##-##-####');\" name=tglawal value='$today'>"; 
				 ?>
  <a href="javascript:showCal('Caritanggalawal')"><img src="images/calendar.png" border="0"></a>
  <? 
/*
					 <option value='SEMUA'>SEMUA</option>					
					 <option value='EXPORT'>EXPORT</option>
					 <option value='IMPORT'>IMPORT</option>
					 <option value='TRANSIT'>TRANSIT</option>			
*/  echo "
				<tr><td>Proses  </td><td>: 
					<select name=outin>
					 <option value='EXPORT'>EXPORT</option>
					 <option value='TRANSIT'>TRANSIT</option>					 
					</select>
				</td></tr>


				<tr><td colspan=2>
				<input type=submit value=\"Preview\" name=bt_preview>
				</td> 	
											
				</table>
        </form>";
}

//flown
elseif (($_GET[module]=='flown_ga')AND ($_SESSION[level]=='supervisor'))
{
  ?>
  <SCRIPT LANGUAGE="JavaScript" src="cal2.js">
  </script>
  <script language="javascript">
    addCalendar("Caritanggalawal","Tanggal","tglawal","form1");
    setWidth(90, 1, 15, 1);
    setFormat("dd-mm-yyyy");
  </script>

  <?
	$tglsekarang=date("Y-m-d");
$today=ymd2dmy($tglsekarang);

	echo "<h2>FLOWN SMU GA</h2>
				<form name=form1 method=POST action='aksi.php?module=flown_ga'>
				<table>
				<tr><td>Tanggal</td><td>: <input type=text onKeyDown=\"javascript:return dFilter (event.keyCode, this, '##-##-####');\" name=tglawal value='$today'>"; 
				 ?>
  <a href="javascript:showCal('Caritanggalawal')"><img src="images/calendar.png" border="0"></a>
  <?
	echo "</td></tr>
	
				<tr><td colspan=2>
				<input type=submit value=\"Preview\" name=bt_preview>
				</td> 	
											
				</table>
        </form>";
}

//////
//periodic report cargo
elseif (($_GET[module]=='flightdata')AND ($_SESSION[level]=='supervisor'))
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

	echo "<h2>After Manifest Reporting</h2>
				<form name=form1 method=POST action='aksi.php?module=flightdata'>
				<table>
				<tr><td>Tanggal Awal </td><td>: <input type=text onKeyDown=\"javascript:return dFilter (event.keyCode, this, '##-##-####');\" name=tglawal value='$today'>"; 
				 ?>
  <a href="javascript:showCal('Caritanggalawal')"><img src="images/calendar.png" border="0"></a>
  <?
	echo "</td></tr>
				<tr><td>Tanggal Akhir </td><td>: <input type=text onKeyDown=\"javascript:return dFilter (event.keyCode, this, '##-##-####');\" name=tglakhir value='$today'>"; 
				 ?>
  <a href="javascript:showCal('Caritanggalakhir')"><img src="images/calendar.png" border="0"></a>
  <?
	echo "</td></tr>
	

				<tr><td>Airline  </td><td>: <input type=text name=airline>
				</td></tr>		

				<tr><td colspan=2>
				<input type=submit value=\"Preview\" name=bt_preview>
				</td> 	
											
				</table>
        </form>";
}
////

//periodic report cargo
elseif (($_GET[module]=='period_report')AND ($_SESSION[level]=='supervisor'))
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

	echo "<h2>After Manifest Reporting</h2>
				<form name=form1 method=POST action='aksi.php?module=period_cargo'>
				<table>
				<tr><td>Tanggal Awal </td><td>: <input type=text onKeyDown=\"javascript:return dFilter (event.keyCode, this, '##-##-####');\" name=tglawal value='$today'>"; 
				 ?>
  <a href="javascript:showCal('Caritanggalawal')"><img src="images/calendar.png" border="0"></a>
  <?
	echo "</td></tr>
				<tr><td>Tanggal Akhir </td><td>: <input type=text onKeyDown=\"javascript:return dFilter (event.keyCode, this, '##-##-####');\" name=tglakhir value='$today'>"; 
				 ?>
  <a href="javascript:showCal('Caritanggalakhir')"><img src="images/calendar.png" border="0"></a>
  <?
	echo "</td></tr>
	
				<tr><td>Proses  </td><td>: 
					<select name=outin>
<option value='SEMUA'>SEMUA</option>
                                        <option value='IMPORT'>IMPORT</option>
				 	<option value='EXPORT'>EXPORT</option>
					 <option value='TRANSIT'>TRANSIT</option>					 
					</select>
				</td></tr>
				<tr><td>Airline  </td><td>: 
					<select name=airline>
					 <option value='SEMUA'>SEMUA</option>
";
	$data=mysql_query("select c.customer from customer as c
					order by c.customer ASC");
					while($r=mysql_fetch_array($data))
					{
						echo "<option value=$r[customer]>$r[customer]</option>";
					}
					echo "</select>
				</td></tr>		

				<tr><td colspan=2>
				<input type=submit value=\"Preview\" name=bt_preview>
				<input type=submit value=\"Per Airport\" name=bt_preview>
				</td> 	
											
				</table>
        </form>";
}

//summary_report_cargo
elseif (($_GET[module]=='summary_cargo')AND ($_SESSION[level]=='supervisor'))
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

	echo "<h2>After Manifest Reporting</h2>
				<form name=form1 method=POST action='aksi.php?module=summary_cargo'>
				<table>
				<tr><td>Tanggal Awal </td><td>: <input type=text onKeyDown=\"javascript:return dFilter (event.keyCode, this, '##-##-####');\" name=tglawal value='$today'>"; 
				 ?>
  <a href="javascript:showCal('Caritanggalawal')"><img src="images/calendar.png" border="0"></a>
  <?
	echo "</td></tr>
				<tr><td>Tanggal Akhir </td><td>: <input type=text onKeyDown=\"javascript:return dFilter (event.keyCode, this, '##-##-####');\" name=tglakhir value='$today'>"; 
				 ?>
  <a href="javascript:showCal('Caritanggalakhir')"><img src="images/calendar.png" border="0"></a>
  <?
	echo "</td></tr>
	
				<tr><td>Proses  </td><td>: 
					<select name=outin>		
					 <option value='SEMUA'>SEMUA</option>
                                        <option value='IMPORT'>IMPORT</option>
				 	<option value='EXPORT'>EXPORT</option>
					 <option value='TRANSIT'>TRANSIT</option>
				</td></tr>
				<tr><td>Airline  </td><td>: 
					<select name=airline>
					 <option value='SEMUA'>SEMUA</option>
";
	$data=mysql_query("select c.customer from customer as c
					order by c.customer ASC");
					while($r=mysql_fetch_array($data))
					{
						echo "<option value=$r[customer]>$r[customer]</option>";
					}
					echo "</select>
				</td></tr>	
				<tr><td>Filter </td><td>: 
					<select name=filter>
					 <option value='PER TONASE'>PER TONASE</option>
					 <option value='PER KOLI'>PER KOLI</option>
					 <option value='PER JML SMU'>PER JML SMU</option>
					 <option value='PER COMMODITY'>PER COMMODITY</option>	
					 <option value='PER AIRPORT'>PER AIRPORT</option>						 				 					 					 
					</select>
				</td></tr>						

				<tr><td colspan=2>
				<input type=submit value=\"Preview\" name=bt_preview>
				</td> 	
											
				</table>
        </form>";
}

//Form void delivery bill
elseif (($_GET[module]=='data')AND ($_SESSION[level]=='supervisor')){
$tgl=date("Y-m-d");

  $no     = $posisi+1;
    echo "<h2>Releasing import Data</h2>
        <form name=form1 method=POST action=?module=data>
        <table>
        <tr><td>Cari</td>     <td> : <input type=text size=30 name=cari>		
		<input type=hidden name=carii value=1>
	    <tr><td colspan=2><input type=submit value=CARI DATA>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>
        </form>";
		
if(($_POST[carii]=='1') AND ($_POST[cari]<>''))
{

$tampil1=mysql_query("SELECT * FROM deliverybill,breakdown where 
deliverybill.idbreakdown=breakdown.id_breakdown  
AND (deliverybill.nosmu like '%$_POST[cari]%' OR deliverybill.nodb like '%$_POST[cari]%') 
ORDER BY id_deliverybill DESC");

if($r=mysql_fetch_array($tampil1))
{
$tampil=mysql_query("SELECT * FROM deliverybill,breakdown where 
deliverybill.idbreakdown=breakdown.id_breakdown  
AND (deliverybill.nosmu like '%$_POST[cari]%' OR deliverybill.nodb like '%$_POST[cari]%') 
ORDER BY id_deliverybill DESC");
$a='1';
}
else
{
$tampil=mysql_query("SELECT * FROM breakdown,isimanifestin where 
isimanifestin.id_isimanifestin=breakdown.id_isimanifestin  
AND isimanifestin.no_smu like '%$_POST[cari]%' ORDER BY isimanifestin.no_smu DESC");
$a='2';
}




echo "<table>        
<tr><th>no</th><th>No. SMU</th><th>No. DB</th><th>Berat Bayar</th><th>Jml Bayar</th><th>Cara Bayar</th><th>CONFIRM</th><th>OUT</th><th>PAID</th></tr>";



  while ($r=mysql_fetch_array($tampil)){
$total=round(($r[document]+$r[overtime]+$r[lain]-$r[diskon])/10)*10;
$tgl=ymd2dmy($r[tglbayar]);
$formattotal=number_format($total, 0, '.', '.');   
$formatberatbayar=number_format($r[beratbayar], 0, '.', '.');   
$nodb='DBI-'.$r[nodb];

if(deliverybill.isvoid=='1')
{

     echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\"><td>$no</td><td align='center'>$r[no_smubtb]</td><td align='center'>$nodb</td><td align='center'>$formatberatbayar</td><td>Rp. $formattotal</td><td align='center'>$r[id_carabayar]</td><td>$r[status_check]</td><td>$r[status_ambil]</td><td>$r[status_bayar]</td></tr>";}
else
{
 if($a=='1')
 {

     echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\"><td>$no</td><td align='center'>$r[no_smubtb]</td><td align='center'>$nodb</td><td align='center'>$formatberatbayar</td><td>Rp. $formattotal</td><td align='center'>$r[id_carabayar]</td><td>$r[status_check] <a href=\"aksi.php?module=release_confirm&b=$r[idbreakdown]\">[waiting]</td><td>$r[status_ambil]  <a href=\"aksi.php?module=release_ambil&b=$r[idbreakdown]\">[release]</td><td>$r[status_bayar]</td></tr>";
	}
	else
	{
	     echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\"><td>$no</td><td align='center'>$r[no_smu]</td><td align='center'>$nodb</td><td align='center'>$formatberatbayar</td><td>Rp. $formattotal</td><td align='center'>$r[id_carabayar]</td><td>$r[status_check] <a href=\"aksi.php?module=release_confirm&b=$r[id_breakdown]\">[waiting]</td><td>$r[status_ambil]  <a href=\"aksi.php?module=release_ambil&b=$r[id_breakdown]\">[release]</td><td>$r[status_bayar]</td></tr>";
	}
	 
	 
	 }

     $no++;
  }
/*keluar 
$tampil1=mysql_query("SELECT * FROM deliverybill,out_dtbarang_h where deliverybill.no_smubtb=out_dtbarang_h.btb_nobtb AND (deliverybill.no_smubtb like '%$_POST[cari]%' OR deliverybill.nosmu like '%$_POST[cari]%' OR deliverybill.nodb like '%$_POST[cari]%') ORDER BY deliverybill.id_deliverybill DESC");  
while ($r=mysql_fetch_array($tampil1)){
$total=round(($r[document]+$r[overtime]+$r[lain]-$r[diskon])/10)*10;
$tgl=ymd2dmy($r[tglbayar]);
$formattotal=number_format($total, 0, '.', '.');   
$formatberatbayar=number_format($r[btb_totalberatbayar], 1, '.', '.');   
$nodb='DBO-'.$r[nodb];

if(deliverybill.isvoid=='1')
{

     echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\"><td>$no</td><td align='center'>$r[no_smubtb]</td><td align='center'>$nodb</td><td align='center'>$formatberatbayar</td><td>Rp. $formattotal</td><td align='center'>$r[id_carabayar]</td><td></td><td>$r[status_keluar]</td><td>$r[status_bayar]</td></tr>";}
else
{

     echo "<tr onmouseover=\"this.className = 'hlt';\" onmouseout=\"this.className = '';\"><td>$no</td><td align='center'>$r[no_smubtb]</td><td align='center'>$nodb</td><td align='center'>$formatberatbayar</td><td>Rp. $formattotal</td><td align='center'>$r[id_carabayar]</td><td></td><td>$r[status_keluar] <a href=\"?module=voiddb&n=$nodb&i=$r[no_smubtb]&s=0&b=$r[idbreakdown]\" 
					onclick=\"javascript:return confirm('VOID hanya dapat dilakukan bila barang sudah terbayar tapi belum 
					keluar gudang. Proses VOID ini akan direkam beserta alasan VOID. 
					Apakah Anda yakin akan VOID barang ini ?')\">[release]</td><td>$r[status_bayar]</td></tr>";}

     $no++;
  }
 */ 
  echo "</table>";
  
}
}

//void deliverybill
elseif (($_GET[module]=='voiddb')AND($_SESSION[level]=='kasir')){
    echo "<h2>VOID DeliveryBill # $_GET[n]</h2>
       <form name=form1 method=POST action=aksi.php?module=voiddb>
        <table>	
    	  <tr><td>Keterangan</td><td> : <input type=text name=keterangan size=60></td></tr>
		</td></tr>
                <tr><td colspan=2><input type=submit value='SIMPAN'>
        <input type=button value=Batal onclick=self.history.back()>
		<input type=hidden name=i value='$_GET[i]'>		<input type=hidden name=s value='$_GET[s]'><input type=hidden name=b value='$_GET[b]'>
		</td></tr>
	   
        </table>
        </form>";
}


//Form void import
elseif (($_GET[module]=='superimport')AND ($_SESSION[level]=='supervisor')){
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

    echo "<h2>Data Transaksi import </h2>
  <a href=aksi.php?module=cetaklap&i=1 target=_blank><img src=images/printer.jpg border=0></a>

       <form name=form1 method=POST action=?module=superexport>
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
elseif (($_GET[module]=='manifestout11')AND ($_SESSION[level]=='export')){
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
elseif (($_GET[act]=='tambahmanifestoutjjj')AND($_SESSION[level]=='export')){
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
elseif (($_GET[act]=='buildup')AND ($_SESSION[level]=='export')){
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
elseif (($_GET[act]=='tambahbuildup')AND($_SESSION[level]=='export')){
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

if ($module=='backup' AND $act=='supervisor')
{
//  header('location:media.php?module='.$module);

	//Create a list of tables to be exported
	$table_list = array();
	while($t = mysql_fetch_array($tables))
	{
		array_push($table_list, $t[0]);
	}

	//Instantiate the SQL_Export class
	require("SQL_Export.php");
	$e = new SQL_Export($server, $username, $password, $database, $table_list);
	//Run the export
	echo $e->export();

	//Clean up the joint
	mysql_close($e->cnx);
	mysql_close($cnx);
}
?>
