<h4>Laporan Transaksi</h4>
<p><strong>Nomor:</strong> <?=$nota;?> | <strong>Kasir:</strong> <?=$kasir;?> | <strong>Tanggal:</strong> <?=$this->fungsi->tanggalindo($tanggal);?> <?=$jam;?></p>
<table class="table table-hover">
    <thead>
      <tr>
          <td align="center" scope="col"><strong>#</strong></td>
          <td scope="col"><strong>KODE BARANG</strong></td>
          <td scope="col"><strong>NAMA BARANG</strong></td>
          <td align="center" scope="col"><strong>JUMLAH</strong></td>
          <td align="right" scope="col"><strong>HARGA BARANG</strong></td>
          <td align="right" scope="col"><strong>SUB TOTAL</strong></td>
      </tr>
    </thead>
    <tbody>
        <?php $no=1; foreach ($result as $items) { ?>
        <tr class="table-secondary">
            <td align="center"><?=$no++;?></td>
            <td><?=$items->kode_barang;?></td>
            <td><?=$items->nama_barang;?></td>
            <td align="center"><?=$items->jml_jual;?></td>
            <td align="right">Rp <?=$this->fungsi->rupiah($items->harga_jual);?></td>
            <td align="right">Rp <?=$this->fungsi->rupiah($items->sub_total);?></td>
        </tr>
        <?php } ?>
        <tr>
            <td colspan="4"></td>
            <td align="right" colspan="2"><font size="5">Rp <?=$this->fungsi->rupiah($grand_total);?></font></td>
        </tr>
        <tr class="table-secondary">
            <td colspan="4">&nbsp;</td>
            <td><strong>DISKON</strong></td>
            <?php $disc = $grand_total/100*$diskon ?>
            <td align="right"><?=$diskon;?> % / Rp <?=$this->fungsi->rupiah($disc);?></td>
        </tr>
        <tr class="table-secondary">
            <td colspan="4">&nbsp;</td>
            <td><strong>TOTAL</strong></td>
            <td align="right">Rp <?=$this->fungsi->rupiah($total);?></td>
        </tr>
        <tr class="table-secondary">
            <td colspan="4">&nbsp;</td>
            <td><strong>BAYAR</strong></td>
            <td align="right">Rp <?=$this->fungsi->rupiah($bayar);?></td>
        </tr>
        <tr class="table-secondary">
            <td colspan="4">&nbsp;</td>
            <td><strong>KEMBALI</strong></td>
            <td align="right">Rp <?=$this->fungsi->rupiah($kembalian);?></td>
        </tr>
        <tr class="table-secondary">
            <td colspan="6" align="right"><?=$keterangan;?></td>
        </tr>
    </tbody>
</table>