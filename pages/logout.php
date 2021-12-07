<?php
if (defined("GELANG") === false) {
    die("Anda tidak boleh membuka halaman ini secara langsung!");
}

session_destroy();

redirect("?page=login&msg=1");