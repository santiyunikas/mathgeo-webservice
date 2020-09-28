<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class C_Member extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //Menampilkan data kontak
    function index_get() {
        $id = $this->get('id_member');
        if ($id == '') {
            $member = $this->db->get('member')->result();
        } else {
            $this->db->where('id_member', $id);
            $member = $this->db->get('member')->result();
        }
        $this->response($member, 200);
    }

    //Mengirim atau menambah data kontak baru
    function index_post() {
        $data = array(
            'id_member'=>$this->post('id_member'),
            'email'=> $this->post('email'),
            'password'=> $this->post('password'),
            'nama_lengkap'=> $this->post('nama_lengkap'),
            'nomor_telepon'=> $this->post('nomor_telepon')
        );
        $insert = $this->db->insert('member', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    //Memperbaharui data yang telah ada
    function index_put() {
        $id = $this->put('id_member');
        $data = array(
            'id_member'=>$this->put('id_member'),
            'email'=> $this->put('email'),
            'password'=> $this->put('password'),
            'nama_lengkap'=> $this->put('nama_lengkap'),
            'nomor_telepon'=> $this->put('nomor_telepon')
                );
        $this->db->where('id_member', $id);
        $update = $this->db->update('member', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
    
    //delete data yang sudah ada
    function index_delete() {
        $id = $this->delete('id_member');
        $this->db->where('id_member', $id);
        $delete = $this->db->delete('member');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
}
?>