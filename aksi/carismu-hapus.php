<?php
mysql_query("DELETE FROM master_smu WHERE idmastersmu='$_GET[ids]'");
mysql_query("DELETE FROM isimanifestout WHERE idmastersmu='$_GET[ids]'");
header('location:media.php?module=carismu&cari='.$_POST[requiredawb]);
?>