<h4><strong>Pengaturan Admin</strong> <a href="<?=base_url('adduser');?>" title="Tambah Pengguna"><i class="fa fa-plus-circle"></i></a></h4>
<?php if ($this->session->flashdata('message')) { ?>
<div class="alert alert-dismissible alert-light">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<p class="mb-0"><?php echo $this->session->flashdata('message');?></p>
</div>
<?php } ?>
<table class="table table-hover">
	<thead>
		<tr>
			<td scope="col"><strong>#</strong></td>
			<td scope="col"><strong>Username</strong></td>
			<td scope="col"><strong>Nama</strong></td>
			<td scope="col"><strong>Akses</strong></td>
            <td scope="col"><strong>Status</strong></td>
            <td scope="col"><strong>Aksi</strong></td>
		</tr>
	</thead>
	<tbody>
		<?php $no=1; foreach ($users as $r) { ?>
		<tr class="table-secondary">
			<td><?=$no++;?></td>
			<td><?=$r->username;?></td>
			<td><?=$r->nama_user;?></td>
            <td><?php if ($r->akses_user == 1) { echo "Administrator"; } else if ($r->akses_user == 2) { echo "Kasir"; } ?></td>
            <td><?php if ($r->status_user == 1) { echo "Aktif"; }else { echo "Nonaktif"; } ?></td>
			<td>
				<a href="<?=base_url('edituser/'.$r->id_user);?>" title="Edit"><i class="fa fa-pencil-square-o"></i></a> &nbsp;
				<?php if ($r->id_user != 1) { ?>
                <a href="<?=base_url('deluser/'.$r->id_user);?>" title="Hapus"><i class="fa fa-trash-o"></i></a>
                <?php } ?>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>