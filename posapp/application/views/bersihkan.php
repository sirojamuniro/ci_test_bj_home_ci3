<h4><strong>Konfirmasi Pembersihan Data Aplikasi</strong></h4>
<?php if ($this->session->flashdata('message')) { ?>
<div class="alert alert-dismissible alert-light">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<p class="mb-0"><?php echo $this->session->flashdata('message');?></p>
</div>
<?php } ?>
<ul>
	<li>Tekan <strong>YA, BERSIHKAN SEKARANG</strong> untuk menghapus semua data dari database dan tidak dapat dikembalikan. Untuk keamanan data Anda, silahkan <a href="<?=base_url('page/backup');?>" title="Klik Disini untuk Backup"><strong>Backup Database</strong></a> terlebih dahulu.</li>
	<li>Tekan <strong>TIDAK, JANGAN SEKARANG</strong> untuk membatalkan.</li>
</ul>
<div class="btn-group" role="group" aria-label="Basic example">
	<a onClick="if(!confirm('Yakin untuk melanjutkan?')){return false;}" href="<?=base_url('clean');?>"><button type="button" class="btn btn-danger">YA, BERSIHKAN SEKARANG</button></a> &nbsp; 
	<a href="<?=base_url('home');?>"><button type="button" class="btn btn-primary">TIDAK, JANGAN SEKARANG</button></a>
</div>