<?php
if (defined("GELANG") === false) {
    die("Anda tidak boleh membuka halaman ini secara langsung!");
}

// Data yg ditangkap 
$id_genre = $_GET['id_genre'];

$data = [
    'deleted_at' => date("Y-m-d H:i:s")
];

update_data($koneksi, "genre", $data, $id_genre, "id_genre");

redirect("?page=genre_list");