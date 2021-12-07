<?php
if (defined("GELANG") === false) {
    die("Anda tidak boleh membuka halaman ini secara langsung!");
}
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Form Movie</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="?page=movie_list" class="btn btn-sm btn-outline-secondary">Kembali</a>
    </div>
</div>

<?php 
    $sql = "select * from genre where deleted_at is null";
    $genre = mysqli_query($koneksi, $sql);
?>

<form action="?page=movie_save" method="post">
    <table class="table">
        <tr>
            <td width="15%">Judul Movie</td>
            <td width="10px">:</td>
            <td><input type="text" name="judul_movie" class="form-control"></td>
        </tr>
        <tr>
            <td>Tahun</td>
            <td>:</td>
            <td><input type="text" name="tahun" class="form-control"></td>
        </tr>
        <tr>
            <td>Deskripsi</td>
            <td>:</td>
            <td><textarea name="deskripsi" class="form-control"></textarea></td>
        </tr>
        <tr>
            <td>Genre(s)</td>
            <td>:</td>
            <td>
                <?php
                    while($row = mysqli_fetch_assoc($genre))
                    {
                        // nama form genre[] -> untuk menyimpan data dalam bentuk array karena typenya checkbox
                        echo "<input type='checkbox' name='genre[]' value='".$row['id_genre']."' />".$row['nama_genre']."<br />"; 
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td><input type="submit" value="Simpan Data" class="btn btn-primary"></td>
        </tr>
    </table>
</form>