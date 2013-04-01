<?php
  $lokasi_file = $_FILES['fupload']['tmp_name'];
  $nama_file   = $_FILES['fupload']['name'];

  // Apabila ada gambar yang diupload
  if (!empty($lokasi_file))
  {
    move_uploaded_file($lokasi_file,"foto_berita/$nama_file");
    mysql_query("INSERT INTO banner(judul,
                                    url,
                                    tgl_posting,
                                    gambar) 
                            VALUES('$_POST[judul]',
                                   '$_POST[link]',
                                   '$tgl_sekarang',
                                   '$nama_file')");
  }
  else
  {
    mysql_query("INSERT INTO banner(judul,
                                    tgl_posting,
                                    url) 
                            VALUES('$_POST[judul]',
                                   '$tgl_sekarang',
                                   '$_POST[link]')");
  }
  header('location:media.php?module='.$module);
?>