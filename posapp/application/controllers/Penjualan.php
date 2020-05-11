<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->library('fungsi');
        $this->load->model('stok_model');
    }

    function cart()
    {
    	if ($this->session->userdata('akses')) {
    		$trx = $this->stok_model->cek_notrx();
    		if (empty($trx[0]['no_trx'])){
    			$data['notrx'] = date('Y').date('m').date('d')."1";
    		}else{
    			$data['notrx'] = $trx[0]['no_trx']+1;
    		}
    		$this->fungsi->template('cart', $data);
		} else {
			redirect(base_url());
		}
    }

    function addcart($id_barang, $qty)
    {
    	if ($this->session->userdata('akses')) {
            $bmaster = $this->stok_model->lihat_bmaster($id_barang);
            if ($bmaster->row()->total >= $qty) {
	    	    $result = $this->stok_model->cart($id_barang);
                $data = array(
                    'id_brg'    => $result[0]['id_barang'],
                    'jml_brg'   => $result[0]['jumlah_barang'],
                    'id'        => $result[0]['kode_barang'],
                    'name'      => $result[0]['nama_barang'],
                    'qty'       => $qty,
                    'price'     => $result[0]['harga_jual']
                );
                $this->cart->insert($data);
                redirect(base_url('cart'));
            }else{
                $this->session->set_flashdata('message', 'Ooopss! Stok Barang Kosong atau Kurang dari Jumlah Order');
				redirect(base_url('cart'));
            }
		} else {
			redirect(base_url());
		}
    }

    function updatecart()
    {
    	if ($this->session->userdata('akses')) {
            $bmaster = $this->stok_model->lihat_bmaster($this->input->post('idbrg'));
            if ($bmaster->row()->total >= $this->input->post('qty')) {
                $data = array(
                     'rowid' => $this->input->post('rowid'),
                     'qty'   => $this->input->post('qty')
                );
                $this->cart->update($data);
                redirect(base_url('cart'));
            } else {
                $this->session->set_flashdata('message', 'Ooopss! Kurang dari Jumlah Order');
				redirect(base_url('cart'));
            }
		} else {
			redirect(base_url());
		}
    }

	function removecart($row)
	{
    	if ($this->session->userdata('akses')) {
			$data = array(
                'rowid' => $row, 
				'qty'   => 0, 
			);
			$this->cart->update($data);
			redirect(base_url('cart'));
		} else {
			redirect(base_url());
		}
	}
    
	function cartdestroy()
	{
    	if ($this->session->userdata('akses')) {
			$this->cart->destroy();
			redirect(base_url('cart'));
		} else {
			redirect(base_url());
		}
	}

	function caribarang()
	{
    	if ($this->session->userdata('akses')) {
			if (!empty($this->input->get('s'))){
                $key = $this->input->get('s'); 
                $page=$this->input->get('per_page');
                $cari=array(
                    'kode_barang' => $key,
                    'nama_barang' => $key
                );
                $batas = 10;
                if(!$page){
                    $offset = 0;
                }else{
                    $offset = $page;
                }
                $total = $this->stok_model->row_caribrg($cari);
                $config['page_query_string']= TRUE;
                $config['base_url']         = base_url('penjualan/cari?s='.$key);
                $config['total_rows']       = $total;
                $config['per_page']         = $batas;
                $config['uri_segment']      = $page;
                $config['full_tag_open']    = '<div><ul class="pagination"><li class="page-item page-link"><strong>Halaman : </strong></li>';
                $config['full_tag_close']   = '</ul></div>';
                $config['first_link']       = '<li class="page-item page-link">Awal</li>';
                $config['last_link']        = '<li class="page-item page-link">Akhir</li>';
                $config['prev_link']        = '&laquo';
                $config['prev_tag_open']    = '<li class="page-item page-link">';
                $config['prev_tag_close']   = '</li>';
                $config['next_link']        = '&raquo';
                $config['next_tag_open']    = '<li class="page-item page-link">';
                $config['next_tag_close']   = '</li>';
                $config['cur_tag_open']     = '<li class="page-item page-link">';
                $config['cur_tag_close']    = '</li>';
                $config['num_tag_open']     = '<li class="page-item page-link">';
                $config['num_tag_close']    = '</li>';
                $this->pagination->initialize($config);
                $from = $this->uri->segment(3);
                $data = array(
                    'cari'     => $key,
                    'halaman'  => $this->pagination->create_links(),
                    'result'   => $this->stok_model->caribrg($batas, $offset, $cari)
                );
                $this->load->view('caribarang', $data);
            } else {
                $total = $this->stok_model->row_data_barang();
                $config['base_url'] 		= base_url('penjualan/caribarang');
                $config['total_rows'] 		= $total;
                $config['per_page'] 		= 10;
                $config['full_tag_open']    = '<div><ul class="pagination"><li class="page-item page-link"><strong>Halaman : </strong></li>';
                $config['full_tag_close']   = '</ul></div>';
                $config['first_link']       = '<li class="page-item page-link">Awal</li>';
                $config['last_link']        = '<li class="page-item page-link">Akhir</li>';
                $config['prev_link']        = '&laquo';
                $config['prev_tag_open']    = '<li class="page-item page-link">';
                $config['prev_tag_close']   = '</li>';
                $config['next_link']        = '&raquo';
                $config['next_tag_open']    = '<li class="page-item page-link">';
                $config['next_tag_close']   = '</li>';
                $config['cur_tag_open']     = '<li class="page-item page-link">';
                $config['cur_tag_close']    = '</li>';
                $config['num_tag_open']     = '<li class="page-item page-link">';
                $config['num_tag_close']    = '</li>';
                $this->pagination->initialize($config);
                $from = $this->uri->segment(3);
                $data = array(
                    'halaman'   => $this->pagination->create_links(),
                    'result'    => $this->stok_model->data_barang($config['per_page'], $from)
                );
                $this->load->view('caribarang', $data);
            }
        } else {
			redirect(base_url());
		}
	}

	function transaction()
	{
    	if ($this->session->userdata('akses')) {
            $dmaster = array(
                'id_user'       => $this->session->userdata('user'),
                'no_trx'        => $this->input->post('notrx'),
                'grand_total'   => $this->cart->total(),
                'diskon'        => $this->input->post('diskon'),
                'total'         => $this->input->post('total'),
                'bayar'         => $this->input->post('bayar'),
                'kembalian'     => $this->input->post('kembalian'),
                'keterangan'    => $this->input->post('info'),
                'tgl_trx'       => date('Y-m-d'),
                'waktu_trx'     => date('h:i:s')
            );
            $pjmaster = $this->stok_model->pjmaster($dmaster);
            $id_master = $this->stok_model->get_id_pjmaster($this->input->post('notrx'))->result_array();
            foreach ($this->cart->contents() as $items) {
            	$dpj[] = array(
            		'id_brg' 	=> $items['id_brg'],
                    'id_master'	=> $id_master[0]['id_pjmaster'], 
            		'jml_jual' 	=> $items['qty'],
            		'sub_total' => $items['subtotal']
            	);
				$this->stok_model->update_stok($items['id_brg'], $items['qty']);
            }
            $pj = $this->stok_model->penjualan($dpj);
            if ($pj && $pjmaster){
            	$this->cart->destroy();
				$this->session->set_flashdata('message', 'Penjualan Sukses. <a class="alert-link" href="'.base_url().'detail_trx/'.$this->input->post('notrx').'">Lihat Detail Transaksi</a>');
				redirect(base_url('cart'));
            }else{
				$this->session->set_flashdata('message', 'Ooopss! Penjualan Gagal, Namun Stok Data Berubah. Silahkan Hubungi Admin!');
				redirect(base_url('cart'));
            }
        } else {
			redirect(base_url());
		}
	}
}