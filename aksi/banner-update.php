<?php
  $lokasi_file = $_FILES['fupload']['tmp_name'];
  $nama_file   = $_FILES['fupload']['name'];

  // Apabila gambar tidak diganti
  if (empty($lokasi_file))
  {
    mysql_query("UPDATE banner SET judul     = '$_POST[judul]',
                                   url       = '$_POST[link]'
                             WHERE id_banner = '$_POST[id]'");
  }
  else
  {
    move_uploaded_file($lokasi_file,"foto_berita/$nama_file");
    mysql_query("UPDATE banner SET judul     = '$_POST[judul]',
                                   url       = '$_POST[link]',
                                   gambar    = '$nama_file'   
                             WHERE id_banner = '$_POST[id]'");
  }
  header('location:media.php?module='.$module);
?>