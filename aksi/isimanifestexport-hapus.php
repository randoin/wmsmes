<?php
 mysql_query("DELETE FROM isimanifestout WHERE idisimanifestout  = '$_GET[idi]'");
  header('location:media.php?module='.$module.'&idm='.$_GET[idm].
  '&r='.$_GET[r].'&f='.$_GET[f].'&d='.$_GET[d].'&idi='.$r[i.idisimanifestout] );
?>