<?php
  mysql_query("DELETE FROM user WHERE user user_id");
  //mysql_query("DELETE FROM ".$module." WHERE id_".$module."='$_GET[id]' AND logon='0'");
  header('location:media.php?module='.$module.'&l='.$_SESSION[level]);
?>