<h4>Detail Barang</h4>
<p align="right">
<a class="btn btn-primary" href="<?=base_url('barang');?>">Kembali</a>
<a class="btn btn-warning" href="<?=base_url('edit/'.$id_barang);?>">Edit</a>
<?php if ($this->stok_model->jika_ada_pj($id_barang) < 1) { ?>
<a class="btn btn-danger" href="<?=base_url('delete/'.$id_barang);?>">Hapus</a>
<?php } ?>
</p>
<table class="table table-hover">
    <tbody>
        <tr class="table-secondary">
            <td>Kode Barang</td>
            <td>:</td>
            <td><?=$kode_barang;?></td>
        </tr>
        <tr>
            <td>Nama Barang</td>
            <td>:</td>
            <td><?=$nama_barang;?></td>
        </tr>
        <tr class="table-secondary">
            <td>Kategori Barang</td>
            <td>:</td>
            <td><?=$kategori;?></td>
        </tr>
        <tr>
            <td>Total Stok Barang</td>
            <td>:</td>
            <td><?=$jumlah_stok.' '.$satuan;?></td>
        </tr>
        <tr class="table-secondary">
            <td>Stok Barang Saat Ini</td>
            <td>:</td>
            <td><?=$jumlah_barang.' '.$satuan;?></td>
        </tr>
        <tr>
            <td>Harga Beli</td>
            <td>:</td>
            <td>Rp <?=$this->fungsi->rupiah($harga_beli);?></td>
        </tr>
        <tr class="table-secondary">
            <td>Harga Jual</td>
            <td>:</td>
            <td>Rp <?=$this->fungsi->rupiah($harga_jual);?></td>
        </tr>
        <tr>
            <td>Keuntungan (<?=$satuan;?>)</td>
            <td>:</td>
            <td>Rp <?=$this->fungsi->rupiah($harga_jual-$harga_beli);?></td>
        </tr>
        <tr class="table-secondary">
            <td>Diperbarui Tanggal</td>
            <td>:</td>
            <td><?=$this->fungsi->tanggalindo($tgl_up).' '.$waktu_up;?></td>
        </tr>
    </tbody>
</table>