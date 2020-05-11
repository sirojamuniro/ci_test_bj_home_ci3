<h4><strong>Tambah Satuan</strong></h4>
<?php if ($this->session->flashdata('message')) { ?>
<div class="alert alert-dismissible alert-light">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<p class="mb-0"><?php echo $this->session->flashdata('message');?></p>
</div>
<?php } ?>
<form action="<?php if (!empty($id_satuan) && !empty($nm_satuan)) { echo base_url('updatesatuan'); } else {	echo base_url('addsatuan'); } ?>" method="POST">
	<?php if (!empty($id_satuan)) { ?>
		<input hidden="" type="number" class="form-control" name="id_satuan" id="id_satuan" value="<?=$id_satuan;?>" required="">
	<?php } ?>
	<div class="form-group">
		<label class="col-form-label" for="satuan">Nama Satuan</label>
		<input type="text" class="form-control" name="satuan" id="satuan" <?php if (!empty($nm_satuan)) { echo 'value="'.$nm_satuan.'"'; } ?> required="">
	</div>
	<button type="submit" class="btn btn-primary">Simpan</button>
</form>
<br />
<h4><strong>Tabel Satuan</strong></h4>
<table class="table table-hover">
	<thead>
		<tr>
			<td scope="col"><strong>#</strong></td>
			<td scope="col"><strong>Satuan</strong></td>
			<td align="center" scope="col"><strong>Tipe</strong></td>
			<td align="center" scope="col"><strong>Aksi</strong></td>
		</tr>
	</thead>
	<tbody>
		<?php if ($satuan) { $no=1; foreach ($satuan as $r) { ?>
		<tr class="table-secondary">
			<td><?=$no++;?></td>
			<td><?=$r->satuan;?></td>
			<td align="center"><?=$this->fungsi->barang_di_satuan($r->id_satuan);?></td>
			<td align="center">
				<a href="<?=base_url('editsatuan/'.$r->id_satuan);?>" title="Edit"><i class="fa fa-pencil-square-o"></i></a> &nbsp;
				<?php if ($this->fungsi->barang_di_satuan($r->id_satuan) == 0) { ?>
				<a href="<?=base_url('delsatuan/'.$r->id_satuan);?>" title="Hapus"><i class="fa fa-trash-o"></i></a>
				<?php } ?>
			</td>
		</tr>
		<?php } } else { ?>
		<tr class="table-secondary">
			<td colspan="5" align="center">Tidak ditemukan</td>
		</tr>
	<?php } ?>
	</tbody>
</table>