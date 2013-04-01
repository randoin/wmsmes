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

<?php
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
?>