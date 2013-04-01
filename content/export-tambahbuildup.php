<?php
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

?>