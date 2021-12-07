<?php
if (defined("GELANG") === false) {
    die("Anda tidak boleh membuka halaman ini secara langsung!");
}
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Form Genre</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="?page=genre_list" class="btn btn-sm btn-outline-secondary">Kembali</a>
    </div>
</div>

<form action="?page=genre_save" method="post">
    <table class="table">
        <tr>
            <td width="15%">Nama Genre</td>
            <td width="10px">:</td>
            <td><input type="text" name="nama_genre" class="form-control"></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td><input type="submit" value="Simpan Data" class="btn btn-primary"></td>
        </tr>
    </table>
</form>