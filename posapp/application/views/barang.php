<h4><strong>Tabel Barang</strong><?php if ($this->session->userdata('akses') == 1) { ?> <a href="<?=base_url('add');?>" title="Tambah Barang"><i class="fa fa-plus-circle"></i></a><?php } ?></h4>
<?php if ($this->session->flashdata('message')) { ?>
<div class="alert alert-dismissible alert-light">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<p class="mb-0"><?php echo $this->session->flashdata('message');?></p>
</div>
<?php } else if (!empty($cari)) { ?>
<div class="alert alert-dismissible alert-light">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
    <p class="mb-0">Menampilkan hasil pencarian <strong><?=$cari;?></strong></p>
</div>
<?php } ?><br />
<table class="table table-hover">
	<thead>
		<tr>
			<td scope="col"><strong>#</strong></td>
			<td scope="col"><strong>Kode Barang</strong></td>
			<td scope="col"><strong>Nama Barang</strong></td>
			<td scope="col"><strong>Stok</strong></td>
		<?php if ($this->session->userdata('akses') == 1) { ?>
			<td align="right" scope="col"><strong>Modal</strong></td>
		<?php } ?>
			<td align="right" scope="col"><strong>Harga Jual</strong></td>
		<?php if ($this->session->userdata('akses') == 1) { ?>
            <td align="center" scope="col"><strong>Tambah Stok</strong></td>
			<td scope="col"><strong>Aksi</strong></td>
		<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php if (!empty($result)) { $no=1; foreach ($result as $data) { ?>
		<tr class="table-secondary">
			<td><?=$no++;?></td>
            <td>
            <?php 
                $bmaster = $this->stok_model->lihat_bmaster($data->id_barang);
                if ($bmaster->row()->total < 1) { 
                    echo $data->kode_barang;
                } else { ?>
                    <a href="<?=base_url('penjualan/addcart/'.$data->id_barang.'/1');?>" title="Tambah ke Penjualan"><?=$data->kode_barang;?></a>
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
		<?php if ($this->session->userdata('akses') == 1) { ?>
			<td align="right"><?=$this->fungsi->rupiah($data->harga_beli);?></td>
		<?php } ?>
			<td align="right"><?=$this->fungsi->rupiah($data->harga_jual);?></td>
		<?php 
		if ($this->session->userdata('akses') == 1) { ?>
            <td align="center">
                <form action="<?=base_url('restok');?>" method="POST">
                    <input hidden="" type="number" name="idbrg" id="idbrg" value="<?=$data->id_barang;?>" required="">
                    <input type="number" name="restok" id="restok" required="">
                    <input hidden="" type="submit">
                </form>
            </td>
			<td>
				<a href="<?=base_url('detail_brg/'.$data->id_barang);?>" title="Detail"><i class="fa fa-eye"></i></a> &nbsp;
				<a href="<?=base_url('edit/'.$data->id_barang);?>" title="Edit"><i class="fa fa-pencil-square-o"></i></a> &nbsp;
				<?php if ($this->stok_model->jika_ada_pj($data->id_barang) < 1) { ?>
				<a href="<?=base_url('delete/'.$data->id_barang);?>" title="Hapus"><i class="fa fa-trash-o"></i></a>
				<?php } ?>
			</td>
		</tr>
	<?php } } ?>
    <?php } else if ($this->session->userdata('akses') == 1) { ?> 
        <tr>
            <td align="center" colspan="10">Tidak ditemukan</td>
        </tr>   
    <?php } else { ?>
        <tr>
            <td align="center" colspan="5">Tidak ditemukan</td>
        </tr>
    <?php } ?>
	</tbody>
</table>
<?=$halaman;?>