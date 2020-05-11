<?php if ($this->session->flashdata('message')) { ?>
<div class="alert alert-dismissible alert-light">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<p class="mb-0"><?php echo $this->session->flashdata('message');?></p>
</div>
<?php } ?>

<h4><strong>Edit Data Barang</strong></h4>
<form action="<?=base_url('update');?>" method="POST">
	<input hidden="" type="number" class="form-control" name="id_barang" id="id_barang" value="<?=$id_barang;?>" required="">
	<div class="form-group">
		<label class="col-form-label" for="kode_barang">Kode Barang</label>
		<input readonly="" type="text" class="form-control" name="kode_barang" id="kode_barang" value="<?=$kode_barang;?>" required="">
	</div>
    <div class="form-group">
      <label class="col-form-label" for="kategori_barang">Kategori Barang <a href="<?=base_url('addcat');?>" title="Tambah Kategori"><i class="fa fa-plus-circle"></i></a></label>
      <select name="kategori_barang" class="form-control" id="kategori_barang" required="">
        <option style="background: grey;" value="<?=$id_kategori;?>"><?=$kategori;?> <small></small></option>
        <option value=""> ... </option>
        <?php foreach ($allcat as $r) { ?>
		<option value="<?=$r->id_kategori;?>"><?=$r->kategori;?></option>
        <?php } ?>
      </select>
    </div>
	<div class="form-group">
		<label class="col-form-label" for="nama_barang">Nama Barang</label>
		<input type="text" class="form-control" name="nama_barang" id="nama_barang" value="<?=$nama_barang;?>" required="">
	</div>
	<div class="form-group">
		<label class="col-form-label" for="jumlah_barang">Stok Barang</label>
		<input readonly="" type="number" class="form-control" name="jumlah_barang" id="jumlah_barang" value="<?=$jumlah_barang;?>" required="">
	</div>
	<div class="form-group">
		<label class="col-form-label" for="satuan">Satuan <a href="<?=base_url('satuan');?>" title="Tambah Satuan"><i class="fa fa-plus-circle"></i></a></label></label></label>
      	<select name="satuan" class="form-control" id="satuan" required="">
        	<option style="background: grey;" value="<?=$id_satuan;?>"><?=$satuan;?></option>
        	<option value=""> ... </option>
        	<?php foreach ($allsatuan as $r) { ?>
        	<option value="<?=$r->id_satuan;?>"><?=$r->satuan;?></option>
        	<?php } ?>
      	</select>
	</div>
	<div class="form-group">
		<label class="col-form-label" for="harga_beli">Harga Beli (Rp)</label>
		<input type="number" class="form-control" name="harga_beli" id="harga_beli" value="<?=$harga_beli;?>" required="">
	</div>
	<div class="form-group">
		<label class="col-form-label" for="harga_jual">Harga Jual (Rp)</label>
		<input type="number" class="form-control" name="harga_jual" id="harga_jual" value="<?=$harga_jual;?>" required="">
	</div>
	<button type="submit" class="btn btn-primary">Simpan</button>
</form>