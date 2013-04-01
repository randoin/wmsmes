<?php
 $tglnya=date("d-m-Y");
  
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



?>