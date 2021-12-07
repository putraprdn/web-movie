<?php
if (defined("GELANG") === false) {
    die("Anda tidak boleh membuka halaman ini secara langsung!");
}

// Data yg ditangkap 
$data = [
    'nama_genre' => clean_data($_POST['nama_genre']),
];
$id_genre = clean_data($_POST['id_genre']);

update_data($koneksi, "genre", $data, $id_genre, "id_genre");

redirect("?page=genre_list");