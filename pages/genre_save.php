<?php
if (defined("GELANG") === false) {
    die("Anda tidak boleh membuka halaman ini secara langsung!");
}

$data = [
    'nama_genre' => clean_data($_POST['nama_genre']),
];
// die($data);
save_data($koneksi, "genre", $data);

redirect("?page=genre_list");