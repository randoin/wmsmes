<?php
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
?>