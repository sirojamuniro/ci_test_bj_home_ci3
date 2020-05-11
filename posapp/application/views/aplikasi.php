<h4><strong>Pengaturan Aplikasi</strong></h4>
<?php if ($this->session->flashdata('message')) { ?>
<div class="alert alert-dismissible alert-light">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<p class="mb-0"><?php echo $this->session->flashdata('message');?></p>
</div>
<?php } ?>
<form action="<?=base_url('updateapp');?>" method="POST">
	<div class="form-group">
		<label class="col-form-label" for="nm_app">Nama Aplikasi</label>
		<input readonly="" type="text" class="form-control" name="nm_app" id="nm_app" value="<?=$this->fungsi->aplikasi()['nm_app'];?>" required="">
	</div>
	<div class="form-group">
		<label class="col-form-label" for="nama_toko">Nama Toko</label>
		<input type="text" class="form-control" name="nama_toko" id="nama_toko" value="<?=$this->fungsi->aplikasi()['nama_toko'];?>" required="">
	</div>
	<div class="form-group">
		<label class="col-form-label" for="alamat_toko">Alamat Toko</label>
		<textarea type="text" class="form-control" name="alamat_toko" id="alamat_toko" required=""><?=$this->fungsi->aplikasi()['alamat_toko'];?></textarea>
	</div>
	<div class="form-group">
		<label class="col-form-label" for="home_txt">Teks Halaman Home</label>
		<textarea class="form-control" name="home_txt" id="home_txt"><?=$this->fungsi->aplikasi()['home_txt'];?></textarea>
	</div>
	<div class="form-group">
		<label class="col-form-label" for="footer_txt">Teks Bagian Footer</label>
		<textarea class="form-control" name="footer_txt" id="footer_txt"><?=$this->fungsi->aplikasi()['footer_txt'];?></textarea>
	</div>
	<button type="submit" class="btn btn-primary">Simpan</button>
</form>