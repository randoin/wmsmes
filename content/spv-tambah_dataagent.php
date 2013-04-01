<h2>TAMBAH DATA AGENT</h2>
<form method="POST" action='aksi.php?module=dataagent&act=tambah' onSubmit="return checkrequired(this)">
<table>
	<tr>
    	<td>Kode</td>     
        <td> : <input type="text" name="namaagent" onChange="javascript:this.value=this.value.toUpperCase();" autocomplete="off"> *</td>
    </tr>
    
    <tr>
    	<td>Agent Full Name</td>
        <td> : <input type="text" name="agentfullname" onChange="javascript:this.value=this.value.toUpperCase();" autocomplete="off"> *</td>
    </tr>
    
    <tr>
    	<td>NPWP</td>
        <td> : <input type="text" name="npwp" onchange="javascript:this.value=this.value.toUpperCase();" autocomplete="off" /> </td>
    </tr>
    
    <tr>
    	<td>Alamat</td>
        <td> : <input type="text" name="address" onChange="javascript:this.value=this.value.toUpperCase();" autocomplete="off"> </td>
    </tr>
    
    <tr>
    	<td>Telepon</td>
        <td> : <input type="text" name="phone" onChange="javascript:this.value=this.value.toUpperCase();" autocomplete="off"> </td>
    </tr>
    
    <tr>
    	<td>Fax</td>
        <td> : <input type="text" name="fax" onChange="javascript:this.value=this.value.toUpperCase();"	autocomplete="off"> </td>
    </tr>
    
    <tr>
    	<td>Contact Person</td>
        <td> : <input type="text" name="contact" onChange="javascript:this.value=this.value.toUpperCase();"	autocomplete=off></td>
    </tr>
	
    <tr>
    	<td>Group</td>
        <td> :
        	<select name="asperindo">
            	<option value="0">-</option>
                <option value="1" selected="selected">ASPERINDO</option>
        </td>
    </tr>
    
    <tr>
    	<td colspan=2>*) wajib diisi, jika kosong maka data tidak akan tersimpan.</td>
    </tr>
    
    <tr>
    	<td colspan=2><input type="submit" value="Simpan">
        			  <input type="button" value="Batal" onclick="self.history.back()"/></td>
    </tr>
</table>
</form>