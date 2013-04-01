<?php
  $cek=mysql_query("select * from breakdown where id_isimanifestin='$_GET[n]'");
	$ada=mysql_num_rows($cek);
	if($ada>1){ mysql_query("DELETE FROM breakdown WHERE id_breakdown='$_GET[id]'");}
  header('location:media.php?module=splitsmu&n='.$_GET[n].'&i='.$_GET[i]);
?>