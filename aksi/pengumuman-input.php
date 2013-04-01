<?php
  $tanggal=sprintf("%02d%02d%02d",$_POST[thn],$_POST[bln],$_POST[tgl]);
  
  mysql_query("INSERT INTO pengumuman(judul,
                                      isi,
                                      tanggal,
                                      tgl_posting,
                                      id_user) 
					                   VALUES('$_POST[judul]',
                                    '$_POST[isi_pengumuman]',
                                    '$tanggal',
                                    '$tgl_sekarang',
                                    '$_SESSION[namauser]')");
  header('location:media.php?module='.$module);
?>