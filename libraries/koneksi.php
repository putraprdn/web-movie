<?php
    $host = "localhost";
    $username = "root";
    $password = '';
    $db = "movie_db";

    $koneksi = mysqli_connect($host, $username, $password, $db);

    if($koneksi == false)
    {
        // gagal koneksi
        die("Error connecting to database".mysqli_connect_error());
    }