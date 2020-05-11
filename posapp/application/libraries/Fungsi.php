<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fungsi {
	protected $_ci;
	
	function __construct()
	{
		$this->_ci =&get_instance();
		$this->_ci->load->model('stok_model');
	}

	function template($content, $data=null)
	{
		$data['_content'] = $this->_ci->load->view($content, $data, true);
		$this->_ci->load->view('template.php', $data);
	}

	function rupiah($nominal)
	{
 		$rp = number_format($nominal,0,',','.');
		return $rp;
	}

	function barang_di_kategori($id)
	{
		$hitung = $this->_ci->stok_model->barang_di_kategori($id);
		return $hitung;
	}

	function barang_di_satuan($id)
	{
		$hitung = $this->_ci->stok_model->barang_di_satuan($id);
		return $hitung;
	}

	function aplikasi()
	{
		$result = $this->_ci->stok_model->aplikasi();
		$display = array(
			'nm_app'         => $result[0]['nm_app'],
			'nama_toko'      => $result[0]['nama_toko'],
			'alamat_toko'    => $result[0]['alamat_toko'],
			'home_txt'       => $result[0]['home_txt'], 
			'footer_txt'     => $result[0]['footer_txt']
		);
		return $display;
	}
	
	function tanggal_lap($tanggal)
	{
		$bulan = array (
			1 => 'Januari',
				 'Februari',
				 'Maret',
				 'April',
				 'Mei',
				 'Juni',
				 'Juli',
				 'Agustus',
				 'September',
				 'Oktober',
				 'November',
				 'Desember'
		);
		$p = explode('/', $tanggal);
		return $p[2] . ' ' . $bulan[ (int)$p[1] ] . ' ' . $p[0];
	}
	
	function tanggalindo($tanggal)
	{
		$bulan = array (
			1 => 'Januari',
				 'Februari',
				 'Maret',
				 'April',
				 'Mei',
				 'Juni',
				 'Juli',
				 'Agustus',
				 'September',
				 'Oktober',
				 'November',
				 'Desember'
		);
		$p = explode('-', $tanggal);
		return $p[2] . ' ' . $bulan[ (int)$p[1] ] . ' ' . $p[0];
	}
}