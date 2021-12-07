<?php
if (defined("GELANG") === false) {
    die("Anda tidak boleh membuka halaman ini secara langsung!");
}

$username = clean_data($_POST['username']);
$password = clean_data($_POST['password']);

$password = md5($password);
$sql = "select * from user where user_username='$username' and user_password='$password' and deleted_at is null";

$result = mysqli_query($koneksi, $sql);

// cek apakah user ada di dalam database
$num_rows = mysqli_num_rows($result);

if($num_rows == 0)
{
    // user tidak ditemukan
    redirect('?page=login&err=1');
}
else 
{
    // user ditemukan
    $row = mysqli_fetch_assoc($result);
    $_SESSION['nama'] = $row['nm_user'];
    $_SESSION['is_logged_in'] = true;
    $_SESSION['id_role'] = $row['id_role'];

    redirect('?page=home');
}