<?php
if(empty($_POST[nosmu]))
{
	mysql_query("update out_dtbarang_h set btb_smu='$_POST[nosmu]' where id='$_POST[no]'");

}
else
{
	$str=mysql_query("select * from out_dtbarang_h where btb_smu='$_POST[nosmu]'");
	$ada=mysql_num_rows($str);
	if($ada<=0)
	{
		mysql_query("update out_dtbarang_h set btb_smu='$_POST[nosmu]' where id='$_POST[no]'");	mysql_query("update deliverybill set nosmu='$_POST[nosmu]' where no_smubtb='$_POST[nobtb]'");
	}
}	
header('location:media.php?module=dboutgoing');
?>