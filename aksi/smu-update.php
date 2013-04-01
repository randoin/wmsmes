<?php
$tgl=my2date($_POST[tglbtb]);
mysql_query("UPDATE smu SET idairline='$_POST[idairline]',idjenisbarang='$_POST[idjenisbarang]',idkomoditi='$_POST[idkomoditi]' WHERE id_smu = '$_POST[id]'");
header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
?>