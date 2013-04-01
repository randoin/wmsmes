<?php
 $tglnya=date("d-m-Y");
 
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
		  if(($tp[tujuan]=='MES') OR ($tp[tujuan]==''))
		  {
          echo("<input type=radio name=transit value='MES' onClick=\"agree=0; document.form1.tujuan.focus();\" checked>MES
				<input type=radio name=transit value='TRANSIT' onClick=\"agree=1; document.form1.tujuan.focus();\">Transit to :");
		  }
		  else
		  {
          echo("<input type=radio name=transit value='MES' onClick=\"agree=0; document.form1.tujuan.focus();\">MES
				<input type=radio name=transit value='TRANSIT' onClick=\"agree=1; document.form1.tujuan.focus();\" checked>Transit to :");
		  }
					echo "<select name=tujuan onFocus=\"if (!agree)this.blur();\" onChange=\"if (!agree)this.value='';\">
	<option value='MES' selected>--Pilih Tujuan--</option>";
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

?>