<?php
$tgl=my2date($_POST[requireddate]);
mysql_query("UPDATE manifestin SET statusconfirm='1',tglpnbp='$tgl',nomorpnbp='$_POST[requirednomor]' WHERE idmanifestin  = '$_POST[idm]'");
header('location:media.php?module='.$module.'&d='.$_POST[d]);
?>