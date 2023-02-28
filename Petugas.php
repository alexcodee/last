<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Petugas extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_petugas');
    }

    public function index()
    {
        if ($this->session->userdata('login_petugas_status') == 'ok') {
            redirect('petugas/halamanUtama');
        } else {
            $this->load->view('petugas/header');
            $this->load->view('petugas/login');
            $this->load->view('petugas/footer');
        }
    }

    public function halamanUtama()
    {
        $this->load->view('petugas/header');
        $this->load->view('petugas/halamanutama');
        $this->load->view('petugas/footer');
    }

    public function login()
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('petugas/header');
            $this->load->view('petugas/login');
            $this->load->view('petugas/footer');
        } else {
            $pass = md5($this->input->post('password'));
            $data = array(
                'username'  => $this->input->post('username'),
                'password'  => $pass
            );
            $data_login = $this->M_petugas->login($data);

            if (count($data_login) > 0) {
                //data login ada
                $this->session->set_userdata('login_petugas_status', 'ok');
                $this->session->set_userdata('id_petugas', $data_login[0]['id_petugas']);
                $this->session->set_userdata('nama_petugas', $data_login[0]['nama_petugas']);
                $this->session->set_userdata('level', $data_login[0]['level']);
                redirect('petugas/index');
            } else {
                //data login gak ada, kemungkinan salah username atau password
                $data['error'] = array('error' => 'Username atau Password Salah');
                $this->load->view('petugas/header');
                $this->load->view('petugas/login', $data);
                $this->load->view('petugas/footer');
            }
        }
    }

    public function logout()
    {

        unset(
            $_SESSION['login_petugas_status'],
            $_SESSION['id_petugas'],
            $_SESSION['nama_petugas'],
            $_SESSION['level']
        );

        redirect('petugas/index');
    }

    public function pengaduan()
    {
        $data['aduan'] = $this->M_petugas->tampilPengaduan();
        $this->load->view('petugas/header');
        $this->load->view('petugas/tabelpengaduan', $data);
        $this->load->view('petugas/footer');
    }

    public function detailaduan($id)
    {
        $data['detailaduan'] = $this->M_petugas->tampilDetailAduan($id);
        $this->load->view('petugas/header');
        $this->load->view('petugas/detailaduan', $data);
        $this->load->view('petugas/footer');
    }

    public function ubahstatus($id)
    {
        $this->form_validation->set_rules('status', 'Status', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('petugas/header');
            $this->load->view('petugas/detailaduan');
            $this->load->view('petugas/footer');
        } else {
            $data = array(

                'status'              => $this->input->post('status')
            );

            if ($this->M_petugas->ubahStatusAduan($id, $data)) {
                redirect('petugas/pengaduan');
            } else {
                echo "Gagal Ubah Status";
            }
        }
    }
    public function petugas()
    {
        if ($this->session->login_status_petugas == 'ok') {
            $data['petugas'] = $this->M_petugas->tampilPetugas();
            $this->load->view('petugas/header');
            $this->load->view('petugas/petugas', $data);
            $this->load->view('petugas/footer');
        } else {
            $this->load->view('petugas/header');
            $this->load->view('petugas/login');
            $this->load->view('petugas/footer');
        }
    }
    public function tambah_petugas()
    {
        if ($this->session->login_status_petugas == 'ok') {
            $this->load->view('petugas/header');
            $this->load->view('petugas/form_petugas');
            $this->load->view('petugas/footer');
        } else {
            $this->load->view('petugas/header');
            $this->load->view('petugas/login');
            $this->load->view('petugas/footer');
        }
    }

    public function registrasi_petugas()
    {

        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('telepon', 'Telepon', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('petugas/header');
            $this->load->view('petugas/form_petugas');
            $this->load->view('petugas/footer');
        } else {
            $data = array(
                'nama_petugas' => $this->input->post('nama'),
                'username' => $this->input->post('username'),
                'password' => md5($this->input->post('password')),
                'telp' => $this->input->post('telepon'),
                'level' => 'petugas'
            );
            if ($this->M_petugas->registrasi_petugas($data)) {
                redirect('petugas/petugas');
            } else {
                echo "Gagal Tambah Data Petugas";
            }
        }
    }
}
