<?php
  mysql_query("UPDATE kotatujuan SET kode = '$_POST[kode]',keterangan='$_POST[keterangan]',status='$_POST[status]' WHERE id_kotatujuan = '$_POST[id]'");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
?>