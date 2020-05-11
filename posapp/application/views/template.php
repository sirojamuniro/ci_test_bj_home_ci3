<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?= $this->fungsi->aplikasi()['nama_toko']; ?> | <?= $this->fungsi->aplikasi()['nm_app']; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" href="<?= base_url('assets/ico.png'); ?>">

    <link rel="stylesheet" href="<?= base_url('assets/bootswatch/yeti/bootstrap.css'); ?>" media="screen">
    <link rel="stylesheet" href="<?= base_url('assets/bootswatch/yeti/bootstrap.min.css'); ?>">

    <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('assets/gijgo/css/gijgo.min.css'); ?>" type="text/css" />
    <script src="<?= base_url('assets/gijgo/js/gijgo.min.js'); ?>" type="text/javascript"></script>

    <script src="<?= base_url('assets/jquery/jquery-3.2.1.js'); ?>"></script>
    <script src="<?= base_url('assets/jquery/jquery-3.2.1.min.js'); ?>"></script>

    <!--frontend -->

    <link href="<?php echo base_url(); ?>assets_frontend/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Libraries CSS Files -->
    <link href="<?php echo base_url(); ?>assets_frontend/lib/animate/animate.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets_frontend/lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets_frontend/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets_frontend/lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Main Stylesheet File -->
    <link href="<?php echo base_url(); ?>assets_frontend/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url(); ?>"><?= $this->fungsi->aplikasi()['nm_app']; ?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01"
                aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarColor01">
                <?php if ($this->session->userdata('akses') == 2) { ?>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= base_url('home'); ?>">Beranda <span
                                class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('cart'); ?>">Penjualan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('barang'); ?>">Tabel Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url(); ?>page/lihat_laporan/<?php $time = mktime(0, 0, 0, date('m') - 1, date('d'), date('Y'));
																							echo date('Y-m-d', $time); ?>/<?= date('Y-m-d'); ?>/">Laporan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('logout'); ?>">Logout</a>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0" action="<?= base_url('page/search'); ?>" method="GET">
                    <input class="form-control mr-sm-2" type="text" name="s" placeholder="Nama atau Kode Barang"
                        required="">
                    <button class="btn btn-primary my-2 my-sm-0" type="submit">Cari</button>
                </form>
                <?php } else if ($this->session->userdata('akses') == 1) { ?>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= base_url('home'); ?>">Beranda <span
                                class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="themes">Transaksi <span
                                class="caret"></span></a>
                        <div class="dropdown-menu" aria-labelledby="themes">
                            <a class="dropdown-item" href="<?= base_url('cart'); ?>">Penjualan</a>
                            <a class="dropdown-item" href="<?= base_url('add'); ?>">Pembelian</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="themes">Barang <span
                                class="caret"></span></a>
                        <div class="dropdown-menu" aria-labelledby="themes">
                            <a class="dropdown-item" href="<?= base_url('barang'); ?>">Tabel Barang</a>
                            <a class="dropdown-item" href="<?= base_url('addcat'); ?>"> Tabel Kategori</a>
                            <a class="dropdown-item" href="<?= base_url('satuan'); ?>"> Tabel Satuan</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url(); ?>page/lihat_laporan/<?php $time = mktime(0, 0, 0, date('m') - 1, date('d'), date('Y'));
																							echo date('Y-m-d', $time); ?>/<?= date('Y-m-d'); ?>/">Laporan</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="themes">Pengaturan <span
                                class="caret"></span></a>
                        <div class="dropdown-menu" aria-labelledby="themes">
                            <a class="dropdown-item" href="<?= base_url('pengguna'); ?>">Pengguna</a>
                            <a class="dropdown-item" href="<?= base_url('aplikasi'); ?>">Aplikasi</a>
                            <a class="dropdown-item" href="<?= base_url('bersihkan'); ?>">Bersihkan</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('logout'); ?>">Logout</a>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0" action="<?= base_url('page/search'); ?>" method="GET">
                    <input class="form-control mr-sm-2" type="text" name="s" placeholder="Nama atau Kode Barang"
                        required="">
                    <button class="btn btn-primary my-2 my-sm-0" type="submit">Cari</button>
                </form>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="container">
        <br /><?php echo $_content; ?><br />
    </div>
    <div class="container">
        <footer id="footer">
            <div class="row">
                <div class="col-lg-12">
                    <p align="right"><?= $this->fungsi->aplikasi()['footer_txt']; ?></p>
                    <small>
                        <p align="right">&copy; <?= date('Y'); ?> - <?= $this->fungsi->aplikasi()['nm_app']; ?> v.1.0
                            </a></p>
                    </small>
                </div>
            </div>
        </footer>
    </div>
    <script src="<?= base_url('assets/vendor/jquery/dist/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/popper.js/dist/umd/popper.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/custom.js'); ?>"></script>

    <!-- JavaScript Libraries -->
    <script src="<?php echo base_url(); ?>assets_frontend/lib/easing/easing.min.js"></script>
    <script src="<?php echo base_url(); ?>assets_frontend/lib/counterup/jquery.waypoints.min.js"></script>
    <script src="<?php echo base_url(); ?>assets_frontend/lib/counterup/jquery.counterup.js"></script>
    <script src="<?php echo base_url(); ?>assets_frontend/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="<?php echo base_url(); ?>assets_frontend/lib/lightbox/js/lightbox.min.js"></script>
    <script src="<?php echo base_url(); ?>assets_frontend/lib/typed/typed.min.js"></script>
    <!-- Contact Form JavaScript File -->
    <script src="<?php echo base_url(); ?>assets_frontend/contactform/contactform.js"></script>

    <!-- Template Main Javascript File -->
    <script src="<?php echo base_url(); ?>assets_frontend/js/main.js"></script>
</body>

</html>