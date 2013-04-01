<?php
$r=mysql_fetch_array(mysql_query("select * from agent where idagent='$_GET[id]'"));
?>
<h2>EDIT DATA AGENT</h2>
	<form method="POST" action='aksi.php?module=dataagent&act=edit'	onSubmit=\"return checkrequired(this)\">
		<table>
        	<tr>
            	<td>Kode</td>
                <td> : <input type="text" name="namaagent" onChange="javascript:this.value=this.value.toUpperCase();" 
						value="<?php echo $r['agent']; ?>" autocomplete="off"> *</td>
            </tr>
        
        	<tr>
            	<td>Agent Full Name</td>
                <td> : <input type="text" name="agentfullname" onChange="javascript:this.value=this.value.toUpperCase();" 
						value="<?php echo $r['agentfullname']; ?>" autocomplete="off"> *</td>
            </tr>
        
        	<tr>
            	<td>NPWP</td>
                <td> : <input type="text" name="npwp" onchange="javascript:this.value=this.value.toUpperCase();"
                		value="<?php echo $r['npwp']; ?>" autocomplete="off" /></td>
            </tr>
            
            <tr>
            	<td>Alamat</td>
                <td> : <input type="text" name="address" onChange="javascript:this.value=this.value.toUpperCase();" 
						value="<?php echo $r['address']; ?>" autocomplete="off"> </td>
            </tr>
        
        	<tr>
            	<td>Telepon</td>
                <td> : <input type="text" name="phone" onChange="javascript:this.value=this.value.toUpperCase();" 
						value="<?php echo $r['phone']; ?>" autocomplete="off"> </td>
            </tr>
        
        	<tr>
            	<td>Fax</td>
                <td> : <input type="text" name="fax" onChange="javascript:this.value=this.value.toUpperCase();" 
						value="<?php echo $r['fax']; ?>" autocomplete="off"> </td>
            </tr>
        
        	<tr>
            	<td>Contact Person</td>
                <td> : <input type="text" name="contact" onChange="javascript:this.value=this.value.toUpperCase();" 
						value="<?php echo $r['contactperson']; ?>" autocomplete="off"></td>
            </tr>
		
           	<tr>
            	<td>Group</td>
                <td> : <select name="asperindo">
					<?php
                	if($p['asperindo']=='0')
					{
						echo "<option value=0 selected>-</option>";
						echo "<option value=1>ASPERINDO</option>";					
					}
					else
					{
						echo "<option value=0>-</option>";
						echo "<option value=1 selected>ASPERINDO</option>";				
					}
					?>
					</select>
				    <input type="hidden" name="id" value="<?php echo $p['btb_agent']; ?>"></td>
            </tr>

			<tr>
            	<td colspan=2>*) wajib diisi, jika kosong maka data tidak akan tersimpan.</td>
            </tr> 
        
        	<tr>
            	<td colspan=2><input type="submit" value="Update Data">
        					  <input type="button" value="Batal" onclick="self.history.back()">
							  <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>"></td>
            </tr>
		</table>
	</form>