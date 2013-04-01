<?php
  mysql_query("INSERT INTO agent(agent,agentfullname,npwp,address,phone,fax,contactperson,asperindo) 
	           		VALUES ('$_POST[namaagent]',
					       '$_POST[agentfullname]',
						   '$_POST[npwp]',
						   '$_POST[address]',
						   '$_POST[phone]',
						   '$_POST[fax]',
						   '$_POST[contact]',
						   '$_POST[asperindo]')");
  header('location:media.php?module='.$module);
?>