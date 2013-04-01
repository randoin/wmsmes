<?php
  mysql_query("UPDATE komoditi SET kodekomoditi = '$_POST[kodekomoditi]',keterangan='$_POST[keterangan]' WHERE id_komoditi = '$_POST[id]'");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
?>