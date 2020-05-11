<h4><strong>Detail Transaksi</strong></h4>
<?php if ($this->session->flashdata('message')) { ?>
<div class="alert alert-dismissible alert-light">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <p class="mb-0"><?php echo $this->session->flashdata('message');?></p>
</div>
<?php } else { echo "<br />"; } ?>
<table class="table table-hover">
    <thead>
        <tr>
            <td><strong>Kode</strong></td>
            <td><strong>Barang</strong></td>
            <td><strong>Qty</strong></td>
            <td align="right"><strong>Harga</strong></td>
            <td align="right"><strong>Total</strong></td>
        </tr>
    </thead>
    <tbody>
    <?php 
    if (!empty($result)) {
        foreach ($result as $items) { ?>
        <tr class="table-secondary">
            <td><?=$items->kode_barang;?></td>
            <td><?=$items->nama_barang;?></td>
            <td><?=$items->jml_jual;?></td>
            <td align="right"><?=$this->fungsi->rupiah($items->harga_jual);?></td>
            <td align="right"><?=$this->fungsi->rupiah($items->sub_total);?></td>
        </tr>
    <?php } } else { ?>
        <tr>
            <td align="center" colspan="5">&nbsp;</td>
        </tr>
        <?php } ?>
        <tr>
            <td colspan="6" align="right"><font size="6"><strong>Rp <?=$this->fungsi->rupiah($grand_total);?></strong></font></td>
        </tr>
    </tbody>
</table>
<?php if (!empty($result)) { ?>
<form onSubmit="if(!confirm('Yakin untuk menyimpan?')){return false;}" action="<?=base_url('edit_trx');?>" method="POST" name="frm_byr">
<div class="form-group">
    <label for="notrx"><strong>NOMOR TRANSAKSI</strong></label>
    <input class="form-control" type="text" name="notrx" value="<?=$nota;?>" readonly="">
</div>
<p align="right"></p>
  	<table class="table table-hover" cellpadding="5">
        <tbody>
        <tr class="table-secondary">
            <td align="right" colspan="5"><strong><font size="5">Rp <span id="hasil"><?=$total;?></span></font></strong></td>
        </tr>
        <tr class="table-secondary">
            <td><strong>BAYAR (Rp)</strong></td>
            <td align="right"><input type="number" name="bayar" id="bayar" value="<?=$bayar;?>" onfocus="startCalculate()" onblur="stopCalc()" required=""></td>
            <td><strong>TOTAL (Rp)</strong></td>
            <td align="right"><input readonly type="number" name="total" id="total" value="<?=$total;?>" onfocus="startCalculate()" onblur="stopCalc()" required=""></td>
        </tr>
        <tr class="table-secondary">
            <td><strong>DISKON (%)</strong></td>
            <td align="right"><input readonly type="number" name="diskon" id="diskon" value="<?=$diskon;?>" onfocus="startCalculate()" onblur="stopCalc()" required=""></td>
            <td><strong>KEMBALI (Rp)</strong></td>
            <td align="right"><input readonly="" type="number" name="kembalian" id="kembalian" value="<?=$kembalian;?>" onfocus="startCalculate()" onblur="stopCalc()" required=""></td>
        </tr>
        <tr class="table-secondary">
            <td colspan="4"><strong>Keterangan </strong><small>(Optional)</small><textarea name="info" class="form-control"><?=$keterangan;?></textarea></td>
        </tr>
        <tr class="table-secondary">
            <td align="right" colspan="4"><button class="btn btn-primary">SIMPAN</button></td>
        </tr>
        </tbody>
    </table>
</form>
<script language="JavaScript">
    function startCalculate()
    {
        interval=setInterval("Calculate()",1);
    }
    function Calculate()
    {
        var a=<?=$total;?>;
        var b=document.frm_byr.bayar.value;
        var c=(b-a)
        document.frm_byr.kembalian.value=(c);
    }
    function stopCalc()
    {
        clearInterval(interval);
    }
</script>
<?php } ?>