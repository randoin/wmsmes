<?php
mysql_query("DELETE FROM master_smu WHERE idmastersmu='$_GET[ids]'");
mysql_query("DELETE FROM isimanifestin WHERE idmastersmu='$_GET[ids]'");
header('location:media.php?module=carismu');
?>