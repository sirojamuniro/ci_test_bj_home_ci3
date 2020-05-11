<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stok_model extends CI_Model {

	function auth($username, $password)
	{
		return $this->db->where(array('username' => $username, 'password' => $password))
						->get('user')
						->result_array();
	}

    function aplikasi()
    {
        return $this->db->where('id', 1)
						->get('aplikasi')
						->result_array();
    }

    function updateapp($id, $data)
    {
        return $this->db->where('id', $id)
						->update('aplikasi', $data);
    }

    function data_barang($number, $offset)
    {
        return $this->db->join('kategori', 'kategori.id_kategori = barang.kategori_barang', 'left')
						->join('satuan', 'satuan.id_satuan = barang.satuan', 'left')
						->order_by('id_barang DESC')
						->get('barang',$number,$offset)
						->result();
    }
 
    function row_data_barang()
    {
        return $this->db->get('barang')
						->num_rows();
    }

    function kategori()
    {
    	return $this->db->order_by('kategori ASC')
						->get('kategori')
						->result();
    }

    function barang_di_kategori($id)
    {
    	return $this->db->join('kategori', 'kategori.id_kategori = barang.kategori_barang', 'left')
						->where('id_kategori', $id)
						->get('barang')
						->num_rows();
    }

    function input($data)
    {
    	return $this->db->insert('barang', $data);
    }
    
    function input_bmaster($data)
    {
    	return $this->db->insert('barang_master', $data);
    }

    function inputcat($data)
    {
    	return $this->db->insert('kategori', $data);
    }

    function kode_kateg($id)
    {
    	return $this->db->where('id_kategori', $id)
						->get('kategori')
						->result_array();
    }

    function idbarang()
    {
    	return $this->db->select('id_barang')
						->order_by('id_barang DESC')
						->get('barang')
						->result_array();
    }

    function data_kategori($number, $offset){
        return $this->db->order_by('id_kategori DESC')
						->get('kategori',$number,$offset)
						->result();
    }
 
    function row_kategori(){
        return $this->db->get('kategori')
						->num_rows();
    }

    function delete_barang($id)
    {
    	return $this->db->where('id_barang', $id)
						->delete('barang');
    }

    function delete_kategori($id)
    {
    	return $this->db->where('id_kategori', $id)
						->delete('kategori');
    }

    function lihat_barang($id)
    {
        return $this->db->join('kategori', 'kategori.id_kategori = barang.kategori_barang', 'left')
						->join('satuan', 'satuan.id_satuan = barang.satuan', 'left')
						->where('id_barang', $id)
						->get('barang')
						->result_array();
    }
    
    function lihat_bmaster($id)
    {
        return $this->db->select('SUM(stok) as total')
						->where('id_br', $id)
						->get('barang_master');
    }

    function update($id, $data)
    {
        return $this->db->where('id_barang', $id)
						->update('barang', $data);
    }

    function lihat_kategori($id)
    {
        return $this->db->join('barang', 'barang.kategori_barang = kategori.id_kategori', 'left')
						->where('id_kategori', $id)
						->get('kategori')
						->result_array();
    }

    function updatecat($id, $data)
    {
        return $this->db->where('id_kategori', $id)
						->update('kategori', $data);
    }

    function satuan()
    {
        return $this->db->order_by('satuan ASC')
						->get('satuan')
						->result();
    }

    function addsatuan($data)
    {
        return $this->db->insert('satuan', $data);
    }

    function lihat_satuan($id)
    {
        return $this->db->where('id_satuan', $id)
						->get('satuan')
						->result_array();
    }

    function update_satuan($id, $data)
    {
        return $this->db->where('id_satuan', $id)
						->update('satuan', $data);
    }

    function hapus_satuan($id)
    {
        return $this->db->where('id_satuan', $id)
						->delete('satuan');
    }

    function barang_di_satuan($id)
    {
        return $this->db->join('satuan', 'satuan.id_satuan = barang.satuan', 'left')
						->where('id_satuan', $id)
						->get('barang')
						->num_rows();
    }

    function clean()
    {
		$clean = array (
			$this->db->truncate('kategori'),
			$this->db->truncate('satuan'),
			$this->db->truncate('barang'),
			$this->db->truncate('barang_master'),
			$this->db->truncate('penjualan'),
			$this->db->truncate('penjualan_master'),
			$this->db->truncate('aplikasi'),
			$this->db->truncate('user')
		);
		if ($clean) {
				$app = array(
					'nm_app' 		=> 'POSApp',
					'nama_toko' 	=> 'Toko Serba Ada',
					'alamat_toko' 	=> 'Jl. Kepastian dan Yakin No. 11 - Kota',
					'home_txt' 		=> '<strong>POSApp (Point of Sales)</strong> adalah aplikasi sederhana yang dapat digunakan untuk mengontrol keluar masuk barang serta dapat melakukan transaksi penjualan secara langsung.',
					'footer_txt' 	=> ''
				);
				$insert_app = $this->db->insert('aplikasi', $app);
				if ($insert_app){
					$user = array(
						'username' => 'admin',
						'password' => sha1('admin'),
						'nama_user' => 'Administrator',
						'akses_user' => 1,
						'status_user' => 1
					);
					$insert_user = $this->db->insert('user', $user);
					if ($insert_user) {
						session_destroy();
						return redirect(base_url());
					}
			}

		}
	}
    
    function users()
    {
        return $this->db->order_by('id_user')
						->get('user')
						->result();
    }
    
    function cek_user($username)
    {
        return $this->db->select('username')
						->where('username', $username)
						->get('user')
						->num_rows();
    }
    
    function adduser($username, $data)
    {
        $result = $this->cek_user($username);
        if ($result == 0){
            return $this->db->insert('user', $data);
        }
    }
    
    function lihat_users($id)
    {
        return $this->db->where('id_user', $id)
						->get('user')
						->result_array();
    }

    function update_user($id, $data)
    {
        return $this->db->where('id_user', $id)
						->update('user', $data);
    }

    function hapus_user($id)
    {
        return $this->db->where('id_user', $id)
						->delete('user');
    }
    
    function cart($id_barang)
    {
        return $this->db->where('id_barang', $id_barang)
						->join('penjualan', 'penjualan.id_brg = barang.id_barang', 'left')
						->get('barang')
						->result_array();
    }

    function update_stok($id_barang, $qty)
    {
        $data = array(
            'id_br' => $id_barang,
            'stok' => -$qty,
            'tglup' => date('Y-m-d'),
            'wktup' => date('h:i:s'),
            'tipe' => 'keluar'
        );
        return $this->db->insert('barang_master', $data);
    }

    function penjualan($data)
    {
        return $this->db->insert_batch('penjualan', $data);
    }

    function cek_notrx()
    {
        return $this->db->order_by('id_pjmaster DESC')
						->get('penjualan_master')
						->result_array();
    }
    
    function pjmaster($data)
    {
        return $this->db->insert('penjualan_master', $data);
    }
    
	function get_id_pjmaster($notrx)
	{
		return $this->db->select('id_pjmaster')
						->where('no_trx', $notrx)
						->limit(1)
						->get('penjualan_master');
	}

    function laporan($number, $offset, $mulai, $akhir)
	{
        return $this->db->join('user', 'user.id_user = penjualan_master.id_user', 'left')
						->where('tgl_trx >=', $mulai)
						->where('tgl_trx <=', $akhir)
						->order_by('id_pjmaster DESC')
						->get('penjualan_master', $number, $offset)
						->result();
    }
 
    function row_laporan($mulai, $akhir)
	{
		return $this->db->join('user', 'user.id_user = penjualan_master.id_user', 'left')
						->where('tgl_trx >=', $mulai)
    					->where('tgl_trx <=', $akhir)
						->get('penjualan_master')
						->num_rows();
    }
    
    function row_caribrg($search)
    {
        return $this->db->or_like($search)
						->get('barang')
						->num_rows();
    }

    function caribrg($batas = null, $offset = null, $search = null)
    {
        $this->db->from('barang');
        if($batas != null) {
			$this->db->limit($batas, $offset);
        }
        if ($search != null) {
           $this->db->or_like($search);
        }
        $this->db->join('satuan', 'satuan.id_satuan = barang.satuan', 'left')
				->order_by('id_barang DESC');
        $query = $this->db->get();
     
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }
    
    function detail_trx($no_trx)
    {
        return $this->db->join('penjualan', 'penjualan.id_master = penjualan_master.id_pjmaster', 'left')
						->join('barang', 'barang.id_barang = penjualan.id_brg', 'left')
						->join('satuan', 'satuan.id_satuan = barang.satuan', 'left')
						->join('user', 'user.id_user = penjualan_master.id_user', 'left')
						->join('kategori', 'kategori.id_kategori = barang.kategori_barang', 'left')
						->where('no_trx', $no_trx)
						->get('penjualan_master');
    }
    
    function detail_brg($id)
    {
        return $this->db->where('id_barang', $id)
						->join('satuan', 'satuan.id_satuan = barang.satuan', 'left')
						->join('kategori', 'kategori.id_kategori = barang.kategori_barang', 'left')
						->limit(1)
						->get('barang');
    }
    
    function restok($data)
    {
        return $this->db->insert('barang_master', $data);
    }

    function total()
    {
        return $this->db->select('id_barang, harga_beli, harga_jual')
						->get('barang')->result();
    }

    function total_barang_masuk($id)
    {
        return $this->db->select('SUM(stok) as stok')
						->where('id_br', $id)
						->where('tipe', 'masuk')
						->get('barang_master');
    }

    function modal_barang($id)
    {
        return $this->db->select('harga_beli')
						->where('id_barang', $id)
						->get('barang');
    }

    function total_ndisc()
    {
        return $this->db->select('SUM(grand_total) as grand_total')
						->get('penjualan_master');
    }

    function total_wdisc()
    {
        return $this->db->select('SUM(total) as total')
						->get('penjualan_master');
    }

    function pj_hari_ini()
    {
        return $this->db->select('SUM(total) as total')
						->where('tgl_trx', date('Y-m-d'))
						->get('penjualan_master');
    }

    function pj_kemarin()
    {
        $kemarin = date('Y-m-d', strtotime("-1 day", strtotime(date("Y-m-d"))));
        return $this->db->select('SUM(total) as total')
						->where('tgl_trx', $kemarin)
						->get('penjualan_master');
    }

    function total_barang_terjual($id)
    {
        return $this->db->select('SUM(jml_jual) as jml_jual')
						->where('id_brg', $id)
						->get('penjualan');
    }
	
	function jika_ada_pj($id)
	{
		return $this->db->where('id_brg', $id)
						->get('penjualan')
						->num_rows();
	}
	
    function kasir_pj_hari_ini()
    {
		$iduser = $this->session->userdata('user');
		if ($iduser){
			return $this->db->select('SUM(total) as total')
							->where('tgl_trx', date('Y-m-d'))
							->where('id_user', $iduser)
							->get('penjualan_master');	
		}
    }

    function kasir_pj_kemarin()
    {
		$iduser = $this->session->userdata('user');
		if ($iduser){
			$kemarin = date('Y-m-d', strtotime("-1 day", strtotime(date("Y-m-d"))));
			return $this->db->select('SUM(total) as total')
							->where('tgl_trx', $kemarin)
							->where('id_user', $iduser)
							->get('penjualan_master');
		}
    }
	
    function kasir_total_wdisc()
    {
		$iduser = $this->session->userdata('user');
		if ($iduser){
			return $this->db->select('SUM(total) as total')
							->where('id_user', $iduser)
							->get('penjualan_master');
		}
    }
	
	function updatepjmaster($notrx, $data)
	{
		return $this->db->where('no_trx', $notrx)
						->update('penjualan_master', $data);
	}
	
	function sum_minus()
	{
		return $this->db->or_like('kembalian', '-')
						->select('SUM(kembalian) as kbl')
						->get('penjualan_master')
						->row()
						->kbl;
	}
	
	function pj_minus($notrx)
	{
		return $this->db->or_like('kembalian', '-')
						->where('no_trx', $notrx)
						->get('penjualan_master')
						->num_rows();
	}
	
	function cek_kategori($input)
	{
		return $this->db->where('kategori', $input)
						->get('kategori')
						->num_rows();
	}
	
	function cek_satuan($input)
	{
		return $this->db->where('satuan', $input)
						->get('satuan')
						->num_rows();
	}

    function data_pj_master($number, $offset, $notrx)
    {
        return $this->db->join('user', 'user.id_user = penjualan_master.id_user', 'left')
                        ->or_like('no_trx', $notrx)
                        ->order_by('id_pjmaster DESC')
                        ->get('penjualan_master', $number, $offset)
                        ->result();
    }
 
    function row_pj_master($notrx)
    {
        return $this->db->join('user', 'user.id_user = penjualan_master.id_user', 'left')
                        ->or_like('no_trx', $notrx)
                        ->get('penjualan_master')
                        ->num_rows();
    }

    function cek_user_pjmaster($notrx)
    {
        return $this->db->select('id_user')
                        ->where('no_trx', $notrx)
                        ->get('penjualan_master')
                        ->result_array();
    }

    function sum_pj_barang()
    {
        return $this->db->select('SUM(jml_jual) as jmljual')
                        ->get('penjualan')
                        ->row()
                        ->jmljual;
    }

    function sum_br_master()
    {
        return $this->db->select('SUM(stok) as jmlstok')
                        ->get('barang_master')
                        ->row()
                        ->jmlstok;
    }

    function hasilcari($key)
    {
        return $this->db->or_like('nama_barang', $key)
                        ->get('barang')
                        ->result();
    }
}