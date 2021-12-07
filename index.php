<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Movie Database</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>

    <!-- Custom styles for this template -->
    <link href="assets/css/dashboard.css" rel="stylesheet">
</head>

<body>
    <?php
    define("GELANG", true);
    require_once "libraries/koneksi.php";
    require_once "libraries/fungsi.php";

    // ambil data menu/modul

    // $sql = "select m.* from modul_role as mr
    // join modul as m on m.id_modul=mr.id_modul 
    // where mr.id_role=" . $_SESSION['id_role'] . " and mr.deleted_at is null and m.deleted_at is null";
    // $menu = mysqli_query($koneksi, $sql);
    ?>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Movie Database</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php if (isset($_SESSION['is_logged_in'])) { ?>
            <?php
            $sql = "select m.* from modul_role as mr
    join modul as m on m.id_modul=mr.id_modul
    where mr.id_role=" . $_SESSION['id_role'] . " and mr.deleted_at is null and m.deleted_at is null";
            $menu = mysqli_query($koneksi, $sql);
            ?>
            <span class="navbar-text float-end">
                Welcome, <?php echo $_SESSION['nama']; ?>
            </span>
            <div class="navbar-nav">
                <div class="nav-item text-nowrap">
                    <a class="nav-link px-3" href="?page=logout">Sign out</a>
                </div>
            </div>
        <?php } else { ?>
            <div class="navbar-nav">
                <div class="nav-item text-nowrap">
                    <a class="nav-link px-3" href="?page=login">Login</a>
                </div>
            </div>
        <?php } ?>
    </header>
    <div class="container-fluid">
        <div class="row">
            <?php if (isset($_SESSION['is_logged_in'])) : ?>
                <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                    <div class="position-sticky pt-3">
                        <ul class="nav flex-column">
                            <?php
                            while ($row = mysqli_fetch_assoc($menu)) :
                            ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="?page=<?php echo $row['nm_modul']; ?>">
                                        <span data-feather="<?php echo $row['icon_modul']; ?>"></span>
                                        <?php echo $row['judul_modul']; ?>
                                    </a>
                                </li>
                            <?php
                            endwhile;
                            ?>
                        </ul>
                    </div>
                </nav>
            <?php endif;
            ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <?php
                if (isset($_GET['page']) == false) {
                    $halaman = "login";
                } else {
                    $halaman = $_GET['page'];
                    if (file_exists("pages/" . $halaman . ".php") == false) {
                        $halaman = "404";
                    }
                }

                $page_public = ['login', 'login_proses'];

                // pengecekan auth
                if (in_array($halaman, $page_public) == false) {
                    // harus diproteksi (harus login)
                    if (isset($_SESSION['is_logged_in']) == false) {
                        // belum login nih
                        redirect('?page=login&err=2');
                    }
                }

                if ((in_array($halaman, $page_public) == false && strpos($halaman, "_") !== false)) {
                    // pengecekan otorisasi
                    // action di database: create, read, update, delete, save
                    $map_action_modul = [
                        'create'    => 'create',
                        'delete'    => 'delete',
                        'edit'      => 'update',
                        'update'    => 'update',
                        'list'      => 'read',
                        'pdf'       => 'read',
                        'excel'     => 'read',
                        'word'      => 'read',
                        'save'      => 'save',
                        'chart'     => 'read',
                    ];


            
                    $exp_halaman = explode("_", $halaman);
                    $action = $exp_halaman[1];
                    $modul = $exp_halaman[0];

                    if(in_array($action, ['pdf', 'excel', 'word']))
                    {
                        ob_clean();
                    }

                    $action_modul = $map_action_modul[$action];
                    // var_dump($action_modul);
                    $id_role = $_SESSION['id_role'];

                    // cek data modul
                    $sql = "select * from modul where nm_modul like '$modul%' and deleted_at is null";
                    $data_modul = mysqli_query($koneksi, $sql);
                    $row_modul = mysqli_fetch_assoc($data_modul);
                    $id_modul = $row_modul['id_modul'];

                    // cek di database
                    $sql = "select * from modul_role where id_modul=$id_modul and id_role=$id_role and is_$action_modul=1 and deleted_at is null";
                    $data_modul_role = mysqli_query($koneksi, $sql);

                    if (mysqli_num_rows($data_modul_role) == 0) {
                        // tidak punya kewenangan ini
                        redirect('?page=403');
                        exit;
                    }
                }

                require_once "pages/" . $halaman . ".php";
                ?>
            </main>
        </div>
    </div>


    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script> -->
    <script src="assets/js/dashboard.js"></script>
</body>

</html>