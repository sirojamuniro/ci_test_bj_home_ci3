<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<title><?=$this->fungsi->aplikasi()['nm_app'];?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="<?=base_url('assets/bootswatch/yeti/bootstrap.css');?>" media="screen">
    <link rel="stylesheet" href="<?=base_url('assets/bootswatch/yeti/bootstrap.min.css');?>">
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url('assets/gijgo/css/gijgo.min.css');?>" type="text/css" />
    <script src="<?=base_url('assets/gijgo/js/gijgo.min.js');?>" type="text/javascript"></script>
    <script src="<?=base_url('assets/jquery/jquery-3.2.1.js');?>"></script>
    <script src="<?=base_url('assets/jquery/jquery-3.2.1.min.js');?>"></script>
</head>
<body>
<div class="container">
    <br />
	<form class="form-inline" action="<?=base_url('penjualan/caribarang');?>" method="GET">
        <a href="<?=base_url('caribarang');?>"><i class="fa fa-home" style="font-size:48px"></i></a> &nbsp;&nbsp; 
		<input class="form-control" type="text" name="s" placeholder="Ketik Nama atau Kode Barang" required=""> &nbsp; <button class="btn btn-primary" type="submit">Cari</button>
	</form>
    <br />
    <?php if (!empty($cari)) { ?>
    <div class="alert alert-dismissible alert-light">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <p class="mb-0">Menampilkan hasil pencarian <strong><?=$cari;?></strong></p>
    </div>
    <?php } ?>
	<table class="table table-hover">
		<thead>
			<tr>
				<td scope="col"><strong>#</strong></td>
				<td scope="col"><strong>Kode Barang</strong></td>
				<td scope="col"><strong>Nama Barang</strong></td>
				<td scope="col"><strong>Stok Barang</strong></td>
				<td align="right" scope="col"><strong>Harga Jual</strong></td>
			</tr>
		</thead>
		<tbody>
		<?php if (!empty($result)) { $no=1; foreach ($result as $data) { ?>
			<tr>
				<td><?=$no++;?></td>
                <td>
                <?php 
                    $bmaster = $this->stok_model->lihat_bmaster($data->id_barang);
                    if ($bmaster->row()->total < 1) { 
                        echo $data->kode_barang;
                    } else { ?>
                        <a href="javascript:self.close();" onclick="goAndClose('<?=base_url();?>penjualan/addcart/<?=$data->id_barang;?>/1')" title="Tambah ke Penjualan"><?=$data->kode_barang;?></a>
                <?php } ?>
                </td>
				<td><?=$data->nama_barang;?></td>
				<td>
                <?php  
                    if ($bmaster->row()->total < 1) { 
                        echo 'Kosong';
                    }else{
                        echo $bmaster->row()->total.' '.$data->satuan;
                    }
                ?>
                </td>
				<td align="right"><?=$this->fungsi->rupiah($data->harga_jual);?></td>
			</tr>
		<?php } } else { ?>
            <tr>
                <td align="center" colspan="5">Tidak ditemukan</td>
            </tr>
        <?php } ?>
		</tbody>
	</table>
	<?=$halaman;?>
</div>
	<script type="text/javascript">
		function goAndClose(url) {
			opener.location.href = url
			this.close;
		}
	</script>
	<script src="<?=base_url('assets/vendor/jquery/dist/jquery.min.js');?>"></script>
	<script src="<?=base_url('assets/vendor/popper.js/dist/umd/popper.min.js');?>"></script>
	<script src="<?=base_url('assets/vendor/bootstrap/dist/js/bootstrap.min.js');?>"></script>
	<script src="<?=base_url('assets/js/custom.js');?>"></script>
</body>
</html>