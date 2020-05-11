<?php if ($this->session->flashdata('message')) { ?>
<div class="alert alert-dismissible alert-light">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <p class="mb-0"><?php echo $this->session->flashdata('message'); ?></p>
</div>
<?php } ?>
<p>Selamat Datang, <strong><?= $this->session->userdata('nama'); ?></strong></p>
<p><?= $this->fungsi->aplikasi()['home_txt']; ?></p>

<?php if ($this->session->userdata('akses') == 1) { ?>
<br />
<div class="row">
    <div class="col-sm-4">
        <div class="card border-primary mb-3" style="max-width: 20rem;">
            <div class="card-header">Total Penjualan Hari Ini</div>
            <div class="card-body">
                <h4 class="card-title"><strong>Rp <?= $this->fungsi->rupiah($pj_hari_ini); ?></strong></h4>
                &nbsp;
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card border-primary mb-3" style="max-width: 20rem;">
            <div class="card-header">Total Penjualan Kemarin</div>
            <div class="card-body">
                <h4 class="card-title"><strong>Rp <?= $this->fungsi->rupiah($pj_kemarin); ?></strong></h4>
                &nbsp;
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card border-primary mb-3" style="max-width: 20rem;">
            <div class="card-header">Total Penjualan</div>
            <div class="card-body">
                <h4 class="card-title"><strong>Rp <?= $this->fungsi->rupiah($total_wdisc); ?></strong></h4>
                &nbsp;
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="card border-primary mb-3" style="max-width: 20rem;">
            <div class="card-header">Total Keuntungan</div>
            <div class="card-body">
                <h4 class="card-title"><strong>Rp
                        <?= $this->fungsi->rupiah($total_wdisc - $total_pj_modal + $sum_minus); ?></strong></h4>
                Rp <?= $this->fungsi->rupiah($total_ndisc - $total_pj_modal + $sum_minus); ?> - Diskon Rp
                <?= $this->fungsi->rupiah($total_ndisc - $total_wdisc); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card border-primary mb-3" style="max-width: 20rem;">
            <div class="card-header">Total Keuntungan Tertunda</div>
            <div class="card-body">
                <h4 class="card-title"><strong>Rp <?= ltrim($this->fungsi->rupiah($sum_minus), '-'); ?></strong></h4>
                &nbsp;
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card border-primary mb-3" style="max-width: 20rem;">
            <div class="card-header">Total Modal</div>
            <div class="card-body">
                <h4 class="card-title"><strong>Rp <?= $this->fungsi->rupiah($modal); ?></strong></h4>
                &nbsp;
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="card border-primary mb-3" style="max-width: 20rem;">
            <div class="card-header">Total Barang Terjual</div>
            <div class="card-body">
                <h4 class="card-title"><strong><?php if ($sum_pj_barang) {
														echo $sum_pj_barang;
													} else {
														echo 0;
													} ?> Barang</strong></h4>
                &nbsp;
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card border-primary mb-3" style="max-width: 20rem;">
            <div class="card-header">Total Sisa Barang</div>
            <div class="card-body">
                <h4 class="card-title"><strong><?php if ($sum_br_master) {
														echo $sum_br_master;
													} else {
														echo 0;
													} ?> Barang</strong></h4>
                &nbsp;
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card border-primary mb-3" style="max-width: 20rem;">
            <div class="card-header">Total Barang Masuk</div>
            <div class="card-body">
                <h4 class="card-title"><strong><?php if ($sum_br_master || $sum_pj_barang) {
														echo $sum_br_master + $sum_pj_barang;
													} else {
														echo 0;
													} ?> Barang</strong></h4>
                &nbsp;
            </div>
        </div>
    </div>
</div>

<?php } else { ?>

<br />
<div class="row">
    <div class="col-sm-4">
        <div class="card border-primary mb-3" style="max-width: 20rem;">
            <div class="card-header">Penjualan Hari Ini</div>
            <div class="card-body">
                <h4 class="card-title"><strong>Rp <?= $this->fungsi->rupiah($kasir_pj_hari_ini); ?></strong></h4>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card border-primary mb-3" style="max-width: 20rem;">
            <div class="card-header">Penjualan Kemarin</div>
            <div class="card-body">
                <h4 class="card-title"><strong>Rp <?= $this->fungsi->rupiah($kasir_pj_kemarin); ?></strong></h4>
            </div>
        </div>
    </div>

</div>
<?php } ?>