<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->library('fungsi');
        $this->load->model('stok_model');
    }

	public function index()
	{
		if ($this->session->userdata('akses')) {
			redirect(base_url('home'));
		} else {
			$this->fungsi->template('login');
		}
	}

	function auth()
	{
		$username   = strtolower($this->input->post('username'));
		$password   = sha1($this->input->post('password'));
		$result     = $this->stok_model->auth($username, $password);
		if ($result) {
			if ($result[0]['status_user'] == 1) {
				if (($result[0]['akses_user'] == 1) || ($result[0]['akses_user'] == 2)) {
					$sess = array(
				    	'akses'		=> $result[0]['akses_user'],
				    	'user'		=> $result[0]['id_user'],
                        'nama'		=> $result[0]['nama_user'],
				    	'logged_in' => TRUE
					);
					$this->session->set_userdata($sess);
					redirect(base_url('home'));
				}
			}else{
				$this->session->set_flashdata('message', 'Username Anda '.ucwords($username).' Sedang Dinonaktifkan');
				redirect(base_url());
			}
		} else {
			$this->session->set_flashdata('message', 'Kombinasi Username atau Password Salah');
			redirect(base_url());
		}
	}

	function barang()
	{
		if ($this->session->userdata('akses')) {
            $total = $this->stok_model->row_data_barang();
            $config['base_url'] 		= base_url('page/barang');
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
            	'halaman' 	=> $this->pagination->create_links(),
            	'result'	=> $this->stok_model->data_barang($config['per_page'], $from)
            );
			$this->fungsi->template('barang', $data);
		}else{
			redirect(base_url());
		}
	}

	function home()
	{
		if ($this->session->userdata('akses')) {
			error_reporting(0);
	    	$total = $this->stok_model->total();
	    	foreach ($total as $key) {
	    		$harga_beli     = $this->stok_model->modal_barang($key->id_barang)->row()->harga_beli;
	    		$total_barang   = $this->stok_model->total_barang_masuk($key->id_barang)->row()->stok;
	    		$jml_jual       = $this->stok_model->total_barang_terjual($key->id_barang)->row()->jml_jual;
	    		$modal          += $harga_beli * $total_barang;
	    		$pj             += $harga_beli * $jml_jual;
	    	}
            $data = array(
                'modal'             => $modal,
                'pj_hari_ini'       => $this->stok_model->pj_hari_ini()->row()->total,
                'pj_kemarin'        => $this->stok_model->pj_kemarin()->row()->total,
                'kasir_pj_hari_ini' => $this->stok_model->kasir_pj_hari_ini()->row()->total,
                'kasir_pj_kemarin'  => $this->stok_model->kasir_pj_kemarin()->row()->total,
                'kasir_total_wdisc' => $this->stok_model->kasir_total_wdisc()->row()->total,
                'total_ndisc'       => $this->stok_model->total_ndisc()->row()->grand_total,
                'total_wdisc'       => $this->stok_model->total_wdisc()->row()->total,
                'total_pj_modal'    => $pj,
                'sum_minus'         => $this->stok_model->sum_minus(),
                'sum_pj_barang'		=> $this->stok_model->sum_pj_barang(),
                'sum_br_master'		=> $this->stok_model->sum_br_master()
            );
			$this->fungsi->template('home', $data);
		}else{
			redirect(base_url());
		}
	}

	function add()
	{
		if ($this->session->userdata('akses') == 1) {
			$data = array(
				'allsatuan'=> $this->stok_model->satuan(),
				'kategori' => $this->stok_model->kategori()
			);
			$this->fungsi->template('add', $data);
		}else{
			redirect(base_url());
		}
	}

	function input()
	{
		if ($this->session->userdata('akses') == 1) {
			$rk = $this->stok_model->kode_kateg($this->input->post('kategori_barang'));
			$rb = $this->stok_model->idbarang();
			if (!$rb[0]['id_barang']) {
				$id_barang = 1;
			}else{
				$id_barang = $rb[0]['id_barang']+1;
			}
			$barang = array(
				'kode_barang'		=> $rk[0]['kode_kategori'].date('Y').date('m').date('d').$this->input->post('kategori_barang').$id_barang,
				'kategori_barang' 	=> $this->input->post('kategori_barang'),
				'nama_barang' 		=> ucwords($this->input->post('nama_barang')),
				'satuan' 			=> ucwords($this->input->post('satuan')),
				'harga_beli' 		=> $this->input->post('harga_beli'),
				'harga_jual' 		=> $this->input->post('harga_jual'),
                'tanggal_masuk' 	=> date('Y-m-d'),
                'waktu_masuk'       => date('h:i:s')
			);
            $brgmaster = array (
                'id_br' => $id_barang,
                'stok'  => $this->input->post('jumlah_barang'),
                'tglup' => date('Y-m-d'),
                'wktup' => date('h:i:s'),
                'tipe'  => 'masuk'
            );
            $bmaster = $this->stok_model->input_bmaster($brgmaster);
			$brg = $this->stok_model->input($barang);
			if ($brg && $bmaster) {
				$this->session->set_flashdata('message', 'Barang Baru Berhasil Ditambahkan');
				redirect(base_url('barang'));
			}else{
				$this->session->set_flashdata('message', 'Ooopss! Silahkan Ulangi Kembali');
				redirect(base_url('add'));
			}
		}else{
			redirect(base_url());
		}
	}

	function addcat()
	{
		if ($this->session->userdata('akses') == 1) {
            $total = $this->stok_model->row_kategori();
            $config['base_url'] 		= base_url('page/addcat');
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
            	'halaman' 		=> $this->pagination->create_links(),
            	'kategori'		=> $this->stok_model->data_kategori($config['per_page'], $from)
            );
			$this->fungsi->template('addcat', $data);
		}else{
			redirect(base_url());
		}
	}

	function inputcat()
	{
		if ($this->session->userdata('akses') == 1) {
            $cek_kategori = $this->stok_model->cek_kategori($this->input->post('kategori'));
            if ($cek_kategori == 0) {
                $data = array(
                    'kategori' 		=> ucwords($this->input->post('kategori')),
                    'kode_kategori' => strtoupper(substr($this->input->post('kategori'),0,3))
                );
                $exec = $this->stok_model->inputcat($data);
                if ($exec) {
                    $this->session->set_flashdata('message', 'Kategori Baru Berhasil Ditambahkan');
                    redirect(base_url('addcat'));
                }else{
                    $this->session->set_flashdata('message', 'Ooopss! Silahkan Ulangi Kembali');
                    redirect(base_url('addcat'));
                }
            }else{
                $this->session->set_flashdata('message', 'Ooopss! Kategori '.ucwords($this->input->post('kategori')).' Sudah Ada');
                redirect(base_url('addcat'));
            }
		}else{
			redirect(base_url());
		}
	}

	function delete($id)
	{
		if ($this->session->userdata('akses') == 1) {
            $pj = $this->stok_model->jika_ada_pj($id);
            if ($pj > 0) {
                $this->session->set_flashdata('message', 'Ooopss! Silahkan Ulangi Kembali');
                redirect(base_url('barang'));
            }else{
                $exec = $this->stok_model->delete_barang($id);
                if ($exec) {
                    $this->session->set_flashdata('message', 'Data Barang Berhasil Dihapus');
                    redirect(base_url('barang'));
                }else{
                    $this->session->set_flashdata('message', 'Ooopss! Silahkan Ulangi Kembali');
                    redirect(base_url('barang'));
                }
            }
		}else{
			redirect(base_url());
		}
	}

	function delcat($id)
	{
		if ($this->session->userdata('akses') == 1) {
			if ($this->fungsi->barang_di_kategori($id) == 0){
				$exec = $this->stok_model->delete_kategori($id);
				if ($exec) {
					$this->session->set_flashdata('message', 'Kategori Berhasil Dihapus');
					redirect(base_url('addcat'));
				}else{
					$this->session->set_flashdata('message', 'Ooopss! Silahkan Ulangi Kembali');
					redirect(base_url('addcat'));
				}
			} else {
					$this->session->set_flashdata('message', 'Ooopss! Silahkan Ulangi Kembali');
					redirect(base_url('addcat'));
			}
		}else{
			redirect(base_url());
		}
	}

	function edit($id)
	{
		if ($this->session->userdata('akses') == 1) {
			$result = $this->stok_model->lihat_barang($id);
            $bmaster = $this->stok_model->lihat_bmaster($id);
			$data = array(
				'id_barang' 		=> $result[0]['id_barang'],
				'kode_barang' 		=> $result[0]['kode_barang'],
				'id_kategori' 		=> $result[0]['id_kategori'],
				'kategori'			=> $result[0]['kategori'],
				'allcat'			=> $this->stok_model->kategori(),
				'nama_barang' 		=> $result[0]['nama_barang'],
				'jumlah_barang' 	=> $bmaster->row()->total,
				'allsatuan'			=> $this->stok_model->satuan(),
				'id_satuan' 		=> $result[0]['id_satuan'],
				'satuan' 			=> $result[0]['satuan'],
				'harga_beli' 		=> $result[0]['harga_beli'],
				'harga_jual' 		=> $result[0]['harga_jual']
			);
			$this->fungsi->template('edit', $data);
		}else{
			redirect(base_url());
		}
	}

	function update()
	{
		if ($this->session->userdata('akses') == 1) {
			$id = $this->input->post('id_barang');
			$rk = $this->stok_model->kode_kateg($this->input->post('kategori_barang'));
			$data = array(
				'kode_barang'		=> $rk[0]['kode_kategori'].date('Y').date('m').date('d').$this->input->post('kategori_barang').$id,
				'kategori_barang' 	=> $this->input->post('kategori_barang'),
				'nama_barang' 		=> ucwords($this->input->post('nama_barang')),
				'satuan' 			=> $this->input->post('satuan'),
				'harga_beli' 		=> $this->input->post('harga_beli'),
				'harga_jual' 		=> $this->input->post('harga_jual'),
                'tanggal_masuk'     => date('Y-m-d'),
                'waktu_masuk'       => date('h:i:s')
			);
			$exec = $this->stok_model->update($id, $data);
			if ($exec) {
				$this->session->set_flashdata('message', 'Data Barang Berhasil Diubah');
				redirect(base_url('barang'));
			}else{
				$this->session->set_flashdata('message', 'TOoopss! Silahkan Ulangi Kembali');
				redirect(base_url('edit/'.$id));
			}
		}else{
			redirect(base_url());
		}
	}

	function editcat($id)
	{
		if ($this->session->userdata('akses') == 1) {
            $total = $this->stok_model->row_kategori();
            $config['base_url'] 		= base_url('page/addcat');
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
			$result = $this->stok_model->lihat_kategori($id);
			$data = array(
				'id_kategori' 	=> $result[0]['id_kategori'],
				'kat'	 		=> $result[0]['kategori'],
				'halaman' 		=> $this->pagination->create_links(),
            	'kategori'		=> $this->stok_model->data_kategori($config['per_page'], $from)
			);
			$this->fungsi->template('addcat', $data);
		}else{
			redirect(base_url());
		}
	}

	function updatecat()
	{
		if ($this->session->userdata('akses') == 1) {
            $cek_kategori = $this->stok_model->cek_kategori($this->input->post('kategori'));
            if ($cek_kategori == 0) {
                $id = $this->input->post('id_kategori');
                $data = array(
                    'kategori' 		=> ucwords($this->input->post('kategori')),
                    'kode_kategori' => strtoupper(substr($this->input->post('kategori'),0,3))
                );
                $exec = $this->stok_model->updatecat($id, $data);
                if ($exec) {
                    $this->session->set_flashdata('message', 'Kategori Berhasil Diubah');
                    redirect(base_url('addcat'));
                }else{
                    $this->session->set_flashdata('message', 'Ooopss! Silahkan Ulangi Kembali');
                    redirect(base_url('editcat/'.$id));
                }
            }else{
                $this->session->set_flashdata('message', 'Ooopss! Kategori '.ucwords($this->input->post('kategori')).' Sudah Ada');
                redirect(base_url('addcat'));
            }
		}else{
			redirect(base_url());
		}
	}

	function satuan()
	{
		if ($this->session->userdata('akses') == 1) {
			$data ['satuan'] = $this->stok_model->satuan();
			$this->fungsi->template('satuan', $data);
		}else{
			redirect(base_url());
		}
	}

	function addsatuan()
	{
		if ($this->session->userdata('akses') == 1) {
            $cek_satuan = $this->stok_model->cek_satuan(ucwords($this->input->post('satuan')));
            if ($cek_satuan == 0) {
                $data ['satuan'] = ucwords($this->input->post('satuan'));
                $exec = $this->stok_model->addsatuan($data);
                if ($exec) {
                    $this->session->set_flashdata('message', 'Satuan Baru Berhasil Ditambahkan');
                    redirect(base_url('satuan'));
                }else{
                    $this->session->set_flashdata('message', 'Ooopss! Silahkan Ulangi Kembali');
                    redirect(base_url('satuan'));
                }
            }else{
                $this->session->set_flashdata('message', 'Ooopss! Satuan '.ucwords($this->input->post('satuan')).' Sudah Ada');
                redirect(base_url('satuan'));
            }
		}else{
			redirect(base_url());
		}
	}

	function editsatuan($id)
	{
		if ($this->session->userdata('akses') == 1) {
            $result = $this->stok_model->lihat_satuan($id);
            $data = array(
                'id_satuan' => $result[0]['id_satuan'],
                'nm_satuan' => $result[0]['satuan'],
                'satuan' 	=> $this->stok_model->satuan()
             );
            $this->fungsi->template('satuan', $data);
		}else{
			redirect(base_url());
		}
	}

	function updatesatuan()
	{
		if ($this->session->userdata('akses') == 1) {
            $cek_satuan = $this->stok_model->cek_satuan(ucwords($this->input->post('satuan')));
            if ($cek_satuan == 0) {
                $data = array(
                    'id_satuan' => $this->input->post('id_satuan'),
                    'satuan'	=> ucwords($this->input->post('satuan'))
                );
                $exec = $this->stok_model->update_satuan($this->input->post('id_satuan'), $data);
                if ($exec) {
                    $this->session->set_flashdata('message', 'Data Satuan Berhasil Diubah');
                    redirect(base_url('satuan'));
                }else{
                    $this->session->set_flashdata('message', 'Ooopss! Silahkan Ulangi Kembali');
                    redirect(base_url('satuan'));
                }
            }else{
                $this->session->set_flashdata('message', 'Ooopss! Satuan '.ucwords($this->input->post('satuan')).' Sudah Ada');
                redirect(base_url('satuan'));
            } 
		}else{
			redirect(base_url());
		}
	}

	function delsatuan($id)
	{
		if ($this->session->userdata('akses') == 1) {
			if ($this->fungsi->barang_di_satuan($id) == 0){
				$exec = $this->stok_model->hapus_satuan($id);
				if ($exec) {
					$this->session->set_flashdata('message', 'Satuan Berhasil Dihapus');
					redirect(base_url('satuan'));
				}else{
					$this->session->set_flashdata('message', 'Ooopss! Silahkan Ulangi Kembali');
					redirect(base_url('satuan'));
				}
			} else {
				$this->session->set_flashdata('message', 'Ooopss! Silahkan Ulangi Kembali');
				redirect(base_url('satuan'));
			}
		}else{
			redirect(base_url());
		}
	}

	function aplikasi()
	{
		if ($this->session->userdata('akses') == 1) {
			$this->fungsi->template('aplikasi');
		}else{
			redirect(base_url());
		}
	}

	function updateapp()
	{
		if ($this->session->userdata('akses') == 1) {
			$data = array(
				'nm_app' 	    => ucwords($this->input->post('nm_app')),
                'nama_toko' 	=> ucwords($this->input->post('nama_toko')),
                'alamat_toko'	=> ucwords($this->input->post('alamat_toko')),
				'home_txt' 	    => $this->input->post('home_txt'), 
				'footer_txt'    => $this->input->post('footer_txt'), 
			);
			$exec = $this->stok_model->updateapp(1, $data);
			if ($exec) {
				$this->session->set_flashdata('message', 'Tersimpan');
				redirect(base_url('aplikasi'));
			}else{
				$this->session->set_flashdata('message', 'Gagal');
				redirect(base_url('aplikasi'));
			}
		}else{
			redirect(base_url());
		}
	}

	function bersihkan()
	{
		if ($this->session->userdata('akses') == 1) {
			$this->fungsi->template('bersihkan');
		}else{
			redirect(base_url());
		}
	}

	function clean()
	{
		if ($this->session->userdata('akses') == 1) {
			$exec = $this->stok_model->clean();
			if ($exec) {
				$this->session->set_flashdata('message', 'Semua Data Berhasil Dihapus dari Database Server');
				redirect(base_url('home'));
			}else{
				$this->session->set_flashdata('message', 'Ooopss! Silahkan Ulangi Kembali');
				redirect(base_url('home'));
			}
		}else{
			redirect(base_url());
		}
	}

	function laporan()
	{
		if ($this->session->userdata('akses')) {
			$this->fungsi->template('laporan');
		}else{
			redirect(base_url());
		}
	}

    function users()
	{
		if ($this->session->userdata('akses') == 1) {
            $data['users'] = $this->stok_model->users();
			$this->fungsi->template('users', $data);
		}else{
			redirect(base_url());
		}
	}
    
    function adduser()
    {
		if ($this->session->userdata('akses') == 1) {
			$this->fungsi->template('adduser');
		}else{
			redirect(base_url());
		}
    }
    
    function insertuser()
    {
		if ($this->session->userdata('akses') == 1) {
            $cek_user = $this->stok_model->cek_user($this->input->post('username'));
            if ($cek_user == 0) {
                $data = array(
                    'username'      => strtolower($this->input->post('username')),
                    'password'      => sha1($this->input->post('password')),
                    'nama_user'     => ucwords($this->input->post('nama_user')),
                    'akses_user'    => $this->input->post('akses_user'),
                    'status_user'   => $this->input->post('status_user')
                );
                $exec = $this->stok_model->adduser($this->input->post('username'), $data);
                if ($exec) {
                    $this->session->set_flashdata('message', 'Pengguna Baru Berhasil Ditambahkan');
                    redirect(base_url('pengguna'));
                }else{
                    $this->session->set_flashdata('message', 'Ooopss! Silahkan Ulangi Kembali');
                    redirect(base_url('adduser'));
                }
            }else{
                $this->session->set_flashdata('message', 'Ooopss! Username Sudah Digunakan');
                redirect(base_url('adduser'));
            }
		}else{
			redirect(base_url());
		}
    }
    
    function edituser($id)
    {
		if ($this->session->userdata('akses') == 1) {
            $result = $this->stok_model->lihat_users($id);
            $data = array(
                'id_user'       => $result[0]['id_user'],
                'username'      => $result[0]['username'],
                'nama_user'     => $result[0]['nama_user'],
                'akses_user'    => $result[0]['akses_user'],
                'status_user'   => $result[0]['status_user']
            );
            $this->fungsi->template('edituser', $data);
		}else{
			redirect(base_url());
		}
    }
    
    function updateuser()
    {
		if ($this->session->userdata('akses') == 1) {
            if (!empty($this->input->post('password'))){
                $data = array(
                    'id_user'       => $this->input->post('id_user'),
                    'username'      => strtolower($this->input->post('username')),
                    'password'      => sha1($this->input->post('password')),
                    'nama_user'     => ucwords($this->input->post('nama_user')),
                    'akses_user'    => $this->input->post('akses_user'),
                    'status_user'   => $this->input->post('status_user')
                );
                $exec = $this->stok_model->update_user($this->input->post('id_user'), $data);
                if ($exec) {
                    if ($this->input->post('password') && ($this->input->post('id_user') == $this->session->userdata('user'))) {
                        session_destroy();
                        $this->session->set_flashdata('message', 'Data Anda Berhasil Diubah. Silahkan Login Kembali');
                        redirect(base_url());
                    }else{
                        $this->session->set_flashdata('message', 'Data Berhasil Diubah');
                        redirect(base_url('pengguna'));
                    }
                }else{
                    $this->session->set_flashdata('message', 'Ooopss! Silahkan Ulangi Kembali');
                    redirect(base_url('edituser/'.$this->input->post('id_user')));
                }
            }else{
                $data = array(
                    'id_user'       => $this->input->post('id_user'),
                    'username'      => strtolower($this->input->post('username')),
                    'nama_user'     => $this->input->post('nama_user'),
                    'akses_user'    => $this->input->post('akses_user'),
                    'status_user'   => $this->input->post('status_user')
                );
                $exec = $this->stok_model->update_user($this->input->post('id_user'), $data);
                if ($exec) {
                    $this->session->set_flashdata('message', 'Data Berhasil Diubah');
                    redirect(base_url('pengguna'));
                }else{
                    $this->session->set_flashdata('message', 'Ooopss! Silahkan Ulangi Kembali');
                    redirect(base_url('edituser/'.$this->input->post('id_user')));
                }
            }
		}else{
			redirect(base_url());
		}
    }
    
    function deluser($id)
    {
		if ($this->session->userdata('akses') == 1) {
            if ($id != 1) {
                $exec = $this->stok_model->hapus_user($id);
                if ($exec) {
                    $this->session->set_flashdata('message', 'Pengguna Berhasil Dihapus');
                    redirect(base_url('pengguna'));
                }else{
                    $this->session->set_flashdata('message', 'Ooopss! Silahkan Ulangi Kembali');
                    redirect(base_url('pengguna'));
                }
            } else {
                $this->session->set_flashdata('message', 'Ooopss! Silahkan Ulangi Kembali');
                redirect(base_url('pengguna'));
            }
		}else{
			redirect(base_url());
		}
    }

  	function lihat_laporan()
  	{
  		if ($this->session->userdata('akses')) {
  			$idusr = $this->session->userdata('user');
			if (!$this->uri->segment(3) && !$this->uri->segment(4)){
				$tgl_mulai  = str_replace('/','-',$this->input->post('mulai'));
				$tgl_sampai = str_replace('/','-',$this->input->post('sampai'));
			}else{
				$tgl_mulai  = $this->uri->segment(3);
				$tgl_sampai = $this->uri->segment(4);
			}
			$tgl_mulai_db = str_replace('-','/',$tgl_mulai);
			$tgl_sampai_db = str_replace('-','/',$tgl_sampai);
            $total = $this->stok_model->row_laporan($tgl_mulai_db, $tgl_sampai_db);
            $config['base_url'] 		= base_url('page/lihat_laporan/'.$tgl_mulai.'/'.$tgl_sampai);
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
            $from = $this->uri->segment(5);
            $data = array(
              	'tgl_mulai' => $tgl_mulai_db,
              	'tgl_akhir' => $tgl_sampai_db,
              	'halaman' 	=> $this->pagination->create_links(),
              	'result'	=> $this->stok_model->laporan($config['per_page'], $from, $tgl_mulai_db, $tgl_sampai_db)
            );
            $this->fungsi->template('laporan', $data);
  		}else{
  			redirect(base_url());
  		}
  	}
    
    function search()
    {
  		if ($this->session->userdata('akses')) {
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
            $config['page_query_string']    = TRUE;
            $config['base_url']             = base_url('page/search?s='.$key);
            $config['total_rows']           = $total;
            $config['per_page']             = $batas;
            $config['uri_segment']          = $page;
            $config['full_tag_open']        = '<div><ul class="pagination"><li class="page-item page-link"><strong>Halaman : </strong></li>';
            $config['full_tag_close']       = '</ul></div>';
            $config['first_link']           = '<li class="page-item page-link">Awal</li>';
            $config['last_link']            = '<li class="page-item page-link">Akhir</li>';
            $config['prev_link']            = '&laquo';
            $config['prev_tag_open']        = '<li class="page-item page-link">';
            $config['prev_tag_close']       = '</li>';
            $config['next_link']            = '&raquo';
            $config['next_tag_open']        = '<li class="page-item page-link">';
            $config['next_tag_close']       = '</li>';
            $config['cur_tag_open']         = '<li class="page-item page-link">';
            $config['cur_tag_close']        = '</li>';
            $config['num_tag_open']         = '<li class="page-item page-link">';
            $config['num_tag_close']        = '</li>';
            $this->pagination->initialize($config);
            $from = $this->uri->segment(3);
            $data = array(
                'cari'      => $key,
                'halaman'   => $this->pagination->create_links(),
                'result'    => $this->stok_model->caribrg($batas, $offset, $cari)
            );
            $this->fungsi->template('barang', $data);
  		}else{
  			redirect(base_url());
  		}
    }
    
    function detail_trx($no_trx)
    {
        if ($this->session->userdata('akses')){
            $r = $this->stok_model->detail_trx($no_trx)->result_array();
            $data = array(
                'nota'          => $r['0']['no_trx'],
                'tanggal'       => $r['0']['tgl_trx'],
                'jam'           => $r['0']['waktu_trx'],
                'kasir'         => $r['0']['nama_user'],
                'grand_total'   => $r['0']['grand_total'],
                'diskon'        => $r['0']['diskon'],
                'total'         => $r['0']['total'],
                'bayar'         => $r['0']['bayar'],
                'kembalian'     => $r['0']['kembalian'],
                'keterangan'    => $r['0']['keterangan'],
                'sub_total'     => $r['0']['sub_total'],
                'result'        => $this->stok_model->detail_trx($no_trx)->result()
            );
            $this->fungsi->template('detail_trx', $data);
  		}else{
  			redirect(base_url());
  		}
    }
    
    function detail_brg($id)
    {
        if ($this->session->userdata('akses') == 1){
            $result = $this->stok_model->detail_brg($id)->result_array();
            $data = array(
                'id_barang'     => $result[0]['id_barang'],
                'kode_barang'   => $result[0]['kode_barang'],
                'nama_barang'   => $result[0]['nama_barang'],
                'kategori'      => $result[0]['kategori'],
                'jumlah_stok'   => $this->stok_model->total_barang_masuk($id)->row()->stok,
                'jumlah_barang' => $this->stok_model->lihat_bmaster($id)->row()->total,
                'satuan'        => $result[0]['satuan'],
                'harga_beli'    => $result[0]['harga_beli'],
                'harga_jual'    => $result[0]['harga_jual'],
                'tgl_up'        => $result[0]['tanggal_masuk'],
                'waktu_up'      => $result[0]['waktu_masuk']
            );
            $this->fungsi->template('detail_brg', $data);
 		}else{
  			redirect(base_url());
  		}
    }
    
    function restok()
    {
        if ($this->session->userdata('akses') == 1){
            $data = array(
                'id_br' => $this->input->post('idbrg'),
                'stok'  => $this->input->post('restok'),
                'tglup' => date('Y-m-d'),
                'wktup' => date('h:s:i'),
                'tipe'  => 'masuk'
            );
            $exec = $this->stok_model->restok($data);
            if ($exec) {
                $this->session->set_flashdata('message', 'Stok Barang Berhasil Ditambahkan');
                redirect(base_url('barang'));
            }else{
                $this->session->set_flashdata('message', 'Ooopss! Silahkan Ulangi Kembali');
                redirect(base_url('barang'));
            }
 		}else{
  			redirect(base_url());
  		}
    }
    
    function editnota($notrx)
    {
    	if ($this->session->userdata('akses')) {
        	$min = $this->stok_model->pj_minus($notrx);
        	if ($min == 1) {
        		$cek_user = $this->stok_model->cek_user_pjmaster($notrx);
	        	if ($cek_user[0]['id_user'] == $this->session->userdata('user')){
		            $r = $this->stok_model->detail_trx($notrx)->result_array();
		            $data = array(
		                'nota'          => $r['0']['no_trx'],
		                'tanggal'       => $r['0']['tgl_trx'],
		                'jam'           => $r['0']['waktu_trx'],
		                'kasir'         => $r['0']['nama_user'],
		                'jml_jual'      => $r['0']['jml_jual'],
		                'grand_total'   => $r['0']['grand_total'],
		                'diskon'        => $r['0']['diskon'],
		                'total'         => $r['0']['total'],
		                'bayar'         => $r['0']['bayar'],
		                'kembalian'     => $r['0']['kembalian'],
		                'keterangan'    => $r['0']['keterangan'],
		                'sub_total'     => $r['0']['sub_total'],
		                'result'        => $this->stok_model->detail_trx($notrx)->result()
		            );
		            $this->fungsi->template('editnota', $data);
		        } else if ($this->session->userdata('akses') == 1){
		            $r = $this->stok_model->detail_trx($notrx)->result_array();
		            $data = array(
		                'nota'          => $r['0']['no_trx'],
		                'tanggal'       => $r['0']['tgl_trx'],
		                'jam'           => $r['0']['waktu_trx'],
		                'kasir'         => $r['0']['nama_user'],
		                'jml_jual'      => $r['0']['jml_jual'],
		                'grand_total'   => $r['0']['grand_total'],
		                'diskon'        => $r['0']['diskon'],
		                'total'         => $r['0']['total'],
		                'bayar'         => $r['0']['bayar'],
		                'kembalian'     => $r['0']['kembalian'],
		                'keterangan'    => $r['0']['keterangan'],
		                'sub_total'     => $r['0']['sub_total'],
		                'result'        => $this->stok_model->detail_trx($notrx)->result()
		            );
		            $this->fungsi->template('editnota', $data);
		        }else{
		        	$this->session->set_flashdata('message', 'Ooopss! Terjadi Kesalahan');
	                $time = mktime(0, 0, 0, date('m')-1, date('d'), date('Y'));
					redirect(base_url()."page/lihat_laporan/".date('Y-m-d', $time)."/".date('Y-m-d'));
		        }
	    	} else {
	    		$this->session->set_flashdata('message', 'Ooopss! Terjadi Kesalahan');
	    		redirect(base_url()."page/lihat_laporan/".date('Y-m-d', $time)."/".date('Y-m-d'));
	    	}
 		}else{
  			redirect(base_url());
  		}
    }
    
    function edit_trx()
    {
    	$cek_user = $this->stok_model->cek_user_pjmaster($this->input->post('notrx'));
    	$r = $this->stok_model->detail_trx($notrx)->result_array();
        if ($this->session->userdata('akses')) {
        	$min = $this->stok_model->pj_minus($this->input->post('notrx'));
        	if ($min == 1) {
	        	if ($this->session->userdata('user') == $cek_user[0]['id_user']){
		            $dmaster = array(
		                'bayar'         => $this->input->post('bayar'),
		                'kembalian'     => $this->input->post('kembalian'),
		                'keterangan'    => $this->input->post('info')
		            );
		            $pjmaster = $this->stok_model->updatepjmaster($this->input->post('notrx'), $dmaster);
		            if ($pjmaster){
						$this->session->set_flashdata('message', 'Transaksi Nomor <strong><a href="'.base_url('detail_trx/'.$this->input->post('notrx')).'">'.$this->input->post('notrx').'</a></strong> Berhasil Diubah');
		                $time = mktime(0, 0, 0, date('m')-1, date('d'), date('Y'));
						redirect(base_url()."page/lihat_laporan/".date('Y-m-d', $time)."/".date('Y-m-d'));
		            }else{
						$this->session->set_flashdata('message', 'Ooopss! Silahkan Ulangi Kembali');
		                $time = mktime(0, 0, 0, date('m')-1, date('d'), date('Y'));
						redirect(base_url()."page/lihat_laporan/".date('Y-m-d', $time)."/".date('Y-m-d'));
		            }
	            } else if ($this->session->userdata('akses') == 1){
	            	$dmaster = array(
		                'bayar'         => $this->input->post('bayar'),
		                'kembalian'     => $this->input->post('kembalian'),
		                'keterangan'    => $this->input->post('info')
		            );
		            $pjmaster = $this->stok_model->updatepjmaster($this->input->post('notrx'), $dmaster);
		            if ($pjmaster){
						$this->session->set_flashdata('message', 'Transaksi Nomor <strong><a href="'.base_url('detail_trx/'.$this->input->post('notrx')).'">'.$this->input->post('notrx').'</a></strong> Berhasil Diubah');
		                $time = mktime(0, 0, 0, date('m')-1, date('d'), date('Y'));
						redirect(base_url()."page/lihat_laporan/".date('Y-m-d', $time)."/".date('Y-m-d'));
		            }else{
						$this->session->set_flashdata('message', 'Ooopss! Silahkan Ulangi Kembali');
		                $time = mktime(0, 0, 0, date('m')-1, date('d'), date('Y'));
						redirect(base_url()."page/lihat_laporan/".date('Y-m-d', $time)."/".date('Y-m-d'));
		            }
		        }else{
		        	$this->session->set_flashdata('message', 'Ooopss! Terjadi Kesalahan');
	                $time = mktime(0, 0, 0, date('m')-1, date('d'), date('Y'));
					redirect(base_url()."page/lihat_laporan/".date('Y-m-d', $time)."/".date('Y-m-d'));
		        }
	    	} else {
	        	$this->session->set_flashdata('message', 'Ooopss! Terjadi Kesalahan');
                $time = mktime(0, 0, 0, date('m')-1, date('d'), date('Y'));
				redirect(base_url()."page/lihat_laporan/".date('Y-m-d', $time)."/".date('Y-m-d'));
	    	}
 		}else{
  			redirect(base_url());
  		}
    }

    function carinota()
    {
		if ($this->session->userdata('akses')) {
			$notrx = $this->input->post('nota');
			if (!$this->uri->segment(3)){
				$notrx = $this->input->post('nota');
			}else{
				$notrx = $this->uri->segment(3);
			}
            $total = $this->stok_model->row_pj_master($notrx);
            $config['base_url'] 		= base_url('page/carinota/'.$notrx);
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
            $from = $this->uri->segment(4);
            $data = array(
            	'carinota' 	=> $notrx,
            	'halaman' 	=> $this->pagination->create_links(),
            	'result'	=> $this->stok_model->data_pj_master($config['per_page'], $from, $notrx)
            );
			$this->fungsi->template('laporan', $data);
		}else{
			redirect(base_url());
		}
    }
    
	function backup()
	{
        if ($this->session->userdata('akses') == 1){
			$this->load->dbutil();
			$backup = $this->dbutil->backup();
			$this->load->helper('file');
			write_file('./backup/posapp-'.date("Y-m-d").'.sql.gzip', $backup);
			$this->load->helper('download');
			force_download('posapp-'.date("Y-m-d").'.sql.gzip', $backup);
		}else{
			redirect(base_url());
		}
	}

	function hasilcari()
	{
		$key = $this->input->get('q');
		$data = $this->stok_model->hasilcari($key);
		foreach ($data as $result) {
			echo '<a href="'.base_url().'penjualan/addcart/'.$result->id_barang.'/1">'.$result->nama_barang.'</a><br />';
		}
	}

	function logout()
	{
		session_destroy();
		redirect(base_url());
	}
}