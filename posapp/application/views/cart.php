<h4><strong>Penjualan</strong></h4>
<p align="right"><a href="" onclick="window.open('<?=base_url();?>caribarang','popUpWindow','height=600,width=1000,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');" title="Cari Barang"><i class="fa fa-search"></i></a> Cari Barang</p>
<form>
    <div class="form-group">
        <input class="form-control" type="text" onkeyup="showResult(this.value)" placeholder="Ketik Nama Barang">
        <div id="hasilcari"></div>
    </div>
</form>
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
            <?php if (!empty($this->cart->contents())) { ?>
            <td align="center"><strong>Batal</strong></td>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
    <?php 
    if (!empty($this->cart->contents())) {
        foreach ($this->cart->contents() as $items) { ?>
        <tr class="table-secondary">
            <td><?=$items['id'];?></td>
            <td><?=$items['name'];?></td>
            <td>
                <form action="<?=base_url('updatecart');?>" method="POST">
                    <input hidden="" type="text" name="idbrg" value="<?=$items['id_brg'];?>">
                    <input hidden="" type="text" name="rowid" value="<?=$items['rowid'];?>">
                    <input type="number" value="<?=$items['qty'];?>" name="qty" size="5"> &nbsp; <button hidden="" class="btn btn-primary btn-sm fa fa-check" title="Simpan"></button>
                </form>
            </td>
            <td align="right"><?=$this->fungsi->rupiah($items['price']);?></td>
            <td align="right"><?=$this->fungsi->rupiah($items['subtotal']);?></td>
            <td align="center"><button class="btn btn-danger btn-sm fa fa-times" onclick="location.href = '<?=base_url();?>removecart/<?=$items['rowid'];?>';" title="Batalkan"></button></td>
        </tr>
    <?php } } else { ?>
        <tr class="table-secondary">
            <td align="center" colspan="5">&nbsp;</td>
        </tr>
        <?php } ?>
        <tr>
            <td colspan="6" align="right"><font size="6"><strong>Rp <?=$this->fungsi->rupiah($this->cart->total());?></strong></font></td>
        </tr>
    </tbody>
</table>
<?php if (!empty($this->cart->contents())) { ?>
<form onSubmit="if(!confirm('Pastikan sudah terjadi pembayaran!')){return false;}" action="<?=base_url('transaction');?>" method="POST" name="frm_byr">
<div class="form-group">
    <label for="notrx"><strong>NOMOR TRANSAKSI</strong></label>
    <input class="form-control" type="text" name="notrx" id="notrx" value="<?=$notrx;?>" readonly="">
</div>
<p align="right"></p>
  	<table class="table table-hover" cellpadding="5">
        <tbody>
        <tr class="table-secondary">
            <td align="right" colspan="5"><strong><font size="5">Rp <span id="hasil"></span></font></strong></td>
        </tr>
        <tr class="table-secondary">
            <td><strong>BAYAR (Rp)</strong></td>
            <td align="right"><input type="number" name="bayar" id = "bayar" onfocus="startCalculate()" onblur="stopCalc()" required=""></td>
            <td><strong>TOTAL (Rp)</strong></td>
            <td align="right"><input readonly type="number" name="total" onfocus="startCalculate()" onblur="stopCalc()" value="<?=$this->cart->total();?>" required=""></td>
        </tr>
        <tr class="table-secondary">
            <td><strong>DISKON (%)</strong></td>
            <td align="right"><input type="number" name="diskon" id = "diskon" onfocus="startCalculate()" onblur="stopCalc()" value="0" required=""></td>
            <td><strong>KEMBALI (Rp)</strong></td>
            <td align="right"><input readonly type="number" name="kembalian" id = "kembalian" onfocus="startCalculate()" onblur="stopCalc()" required=""></td>
        </tr>
        <tr class="table-secondary">
            <td colspan="4"><strong>Keterangan </strong><small>(Optional)</small><textarea name="info" class="form-control"></textarea></td>
        </tr>
        <tr class="table-secondary">
            <td align="right" colspan="4"><button type="button" class="btn btn-danger" onclick="location.href = '<?=base_url();?>cartdestroy';">BATAL</button> <button class="btn btn-primary">SIMPAN</button></td>
        </tr>
        </tbody>
    </table>
</form>
<?php } ?>
<script language="JavaScript">
    function startCalculate()
    {
        interval=setInterval("Calculate()",1);
    }
    function Calculate()
    {
        var a=<?=$this->cart->total();?>;
        var b=document.frm_byr.total.value;
        var c=document.frm_byr.diskon.value;
        var d=document.frm_byr.bayar.value;
        var e=100;
        var f=(a / e * c);
        var g=(a - f);
        var h=(d - g);
        document.frm_byr.total.value=(g);
        document.frm_byr.kembalian.value=(h);
        var hasil;
        hasil = (g);
        var bilangan = (g);
        var number_string = bilangan.toString(),
            sisa    = number_string.length % 3,
            rupiah  = number_string.substr(0, sisa),
            ribuan  = number_string.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        document.getElementById("hasil").innerHTML=rupiah;
    }
    function stopCalc()
    {
        clearInterval(interval);
    }

    function showResult(str) {
      if (str.length==0) {
        document.getElementById("hasilcari").innerHTML="";
        document.getElementById("hasilcari").style.border="0px";
        return;
      }
      if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
      } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
          document.getElementById("hasilcari").innerHTML=this.responseText;
          document.getElementById("hasilcari").style.border="1px solid #A5ACB2";
        }
      }
      xmlhttp.open("GET","<?=base_url();?>page/hasilcari?q="+str,true);
      xmlhttp.send();
    }
</script>