<h4><strong>Ubah Data Pengguna</strong></h4>
<?php if ($this->session->flashdata('message')) { ?>
<div class="alert alert-dismissible alert-light">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<p class="mb-0"><?php echo $this->session->flashdata('message');?></p>
</div>
<?php } ?>
<form action="<?=base_url('updateuser');?>" method="POST">
    <input hidden="" readonly="" type="text" name="id_user" id="id_user" value="<?=$id_user;?>" required="">
	<div class="form-group">
		<label class="col-form-label" for="username">Username</label>
		<input readonly="" type="text" class="form-control" name="username" id="username" value="<?=$username;?>" required="">
	</div>
	<div class="form-group">
		<label class="col-form-label" for="nama_user">Nama</label>
		<input type="text" class="form-control" name="nama_user" id="nama_user" value="<?=$nama_user;?>" required="">
	</div>
	<div class="form-group">
		<label class="col-form-label" for="akses_user">Akses Pengguna</label>
      	<select name="akses_user" class="form-control" id="akses_user" required="">
            <?php 
                if ($id_user == 1) {
                    echo '<option value="1">Administrator</option>';
                }else{
                    echo '<option value="2">Kasir</option>';
                    echo '<option value="1">Administrator</option>';
                }
            ?>
      	</select>
    </div>
    <div class="form-group">
		<label class="col-form-label" for="status_user">Status Pengguna</label>
      	<select name="status_user" class="form-control" id="status_user" required="">
            <?php 
                if ($id_user == 1) {
                    echo '<option value="1">Aktif</option>';
                }else{
                    echo '<option value="1">Aktif</option>';
                    echo '<option value="2">Nonaktif</option>';
                }
            ?>
      	</select>
    </div>
    <div class="form-group">
		<label class="col-form-label" for="password">Password Baru <small><em>(Optional)</em></small></label>
		<input type="password" class="form-control" name="password" id="password">
	</div>
	<button type="submit" class="btn btn-primary">Simpan</button>
</form>