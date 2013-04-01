<?php
if((!empty($_POST[totalberat])) AND (!empty($_POST[totalkoli])) AND 
(!empty($_POST[totalberatdatang])) AND (!empty($_POST[totalkolidatang])) 
AND (!empty($_POST[no_smu])) )
{
mysql_query("update isimanifestout set 
no_smu='$_POST[no_smu]',totalberat='$_POST[totalberat]',
totalkoli='$_POST[totalkoli]',jenisbarang='$_POST[jenisbarang]',status_transit='$_POST[transit]',
asal='$_POST[asal]',tujuan='$_POST[tujuan]',status_update='yes' WHERE id_isimanifestout='$_POST[n]'");
mysql_query("update breakdown set beratdatang='$_POST[totalberatdatang]',
kolidatang='$_POST[totalkolidatang]' WHERE id_isimanifestout='$_POST[n]'");
}
header('location:media.php?module=barangdatang&i='.$_POST[i]);
?>