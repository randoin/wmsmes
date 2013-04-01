<?php
mysql_query("UPDATE agent SET agent = '$_POST[namaagent]',
							  agentfullname = '$_POST[agentfullname]',
							  npwp = '$_POST[npwp]',
							  address = '$_POST[address]',
							  phone = '$_POST[phone]',
							  fax= '$_POST[fax]',
							  contactperson = '$_POST[contact]',
							  asperindo ='$_POST[asperindo]'
				WHERE idagent      = '$_POST[id]'");
  header('location:media.php?module='.$module);
?>