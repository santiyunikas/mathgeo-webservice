<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class C_Pengguna extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //Menampilkan data kontak
    function index_get() {
        $id = $this->get('id_pengguna');
        if ($id == '') {
            $pengguna = $this->db->get('pengguna')->result();
        } else {
            $this->db->where('id_pengguna', $id);
            $pengguna = $this->db->get('pengguna')->result();
        }
        $this->response($pengguna, 200);
    }

    //Mengirim atau menambah data kontak baru
    function index_post() {
        $data = array(
            'id_pengguna'=>$this->post('id_pengguna'),
            'email'=> $this->post('email'),
            'password'=> $this->post('password'),
            'nama_lengkap'=> $this->post('nama_lengkap'),
            'nomor_telepon'=> $this->post('nomor_telepon')
        );
        $insert = $this->db->insert('pengguna', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    //Memperbaharui data yang telah ada
    function index_put() {
        $id = $this->put('id_pengguna');
        $data = array(
            'id_pengguna'=>$this->put('id_pengguna'),
            'email'=> $this->put('email'),
            'password'=> $this->put('password'),
            'nama_lengkap'=> $this->put('nama_lengkap'),
            'nomor_telepon'=> $this->put('nomor_telepon')
                );
        $this->db->where('id_pengguna', $id);
        $update = $this->db->update('pengguna', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    function index_delete() {
        $id = $this->delete('id_pengguna');
        $this->db->where('id_pengguna', $id);
        $delete = $this->db->delete('pengguna');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
}
?>