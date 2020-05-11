<h4><strong>Tambah Admin</strong></h4>
<?php if ($this->session->flashdata('message')) { ?>
<div class="alert alert-dismissible alert-light">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<p class="mb-0"><?php echo $this->session->flashdata('message');?></p>
</div>
<?php } ?>
<form action="<?=base_url('insertuser');?>" method="POST">
	<div class="form-group">
		<label class="col-form-label" for="username">Username</label>
		<input type="text" class="form-control" name="username" id="username" required="">
	</div>
	<div class="form-group">
		<label class="col-form-label" for="password">Password</label>
		<input type="password" class="form-control" name="password" id="password" required="">
	</div>
	<div class="form-group">
		<label class="col-form-label" for="nama_user">Nama</label>
		<input type="text" class="form-control" name="nama_user" id="nama_user" required="">
	</div>
	<div class="form-group">
		<label class="col-form-label" for="akses_user">Akses Pengguna</label>
      	<select name="akses_user" class="form-control" id="akses_user" required="">
        	<option value=""> ... </option>
        	<option value="1">Administrator</option>
            <option value="2">Kasir</option>
      	</select>
    </div>
    <div class="form-group">
		<label class="col-form-label" for="status_user">Status Pengguna</label>
      	<select name="status_user" class="form-control" id="status_user" required="">
            <option value=""> ... </option>
            <option value="1">Aktif</option>
        	<option value="2">Nonaktif</option>
      	</select>
    </div>
	<button type="submit" class="btn btn-primary">Simpan</button>
</form>