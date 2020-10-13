<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Verify extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    // Menampilkan data menggunakan email
    function index_get() {
        $email = $this->get('email');
        if ($email == '') {
            $member_registered = $this->db->get('is_verified_member')->result();
        } else {
            $this->db->where('email', $email);
            $member_registered = $this->db->get('is_verified_member')->result();
        }
        $this->response($member_registered, 200);
    }

    // function index_get() {
    //     $email = $this->get('email');

    //     if (!empty($email)) {

    //         // Verify data                          
    //         $data = array(
    //             'email'=> $email,
    //             'active'=> 1
    //         );
    //         $this->db->where('email', $email);
    //         $update = $this->db->update('is_verified_member', $data);
    //         if ($update) {
    //             echo '<div class="statusmsg">Your account has been activated, you can now login</div>';
    //             // $this->response($data, 200);
    //         } else {
    //             echo '<div class="statusmsg">Invalid approach, please use the link that has been send to your email.</div>';
    //             // $this->response(array('status' => 'fail', 502));
    //         }
    //     }   
    // }

    //Mengirim atau menambah data baru
    // function index_post() {
    //     $data = array(
    //         'id_member'=>$this->post('id_member'),
    //         'email'=> $this->post('email'),
    //         'password'=> $this->post('password'),
    //         'nama_lengkap'=> $this->post('nama_lengkap'),
    //         'nomor_telepon'=> $this->post('nomor_telepon')
    //     );
    //     $insert = $this->db->insert('member', $data);
    //     if ($insert) {
    //         $this->response($data, 200);
    //     } else {
    //         $this->response(array('status' => 'fail', 502));
    //     }
    // }

    //Memperbaharui password
    // function index_put() {
    //     $email = $this->put('email');
    //     $data = array(
    //         'password'=> $this->put('password'),
    //     );
    //     $this->db->where('email', $email);
    //     $update = $this->db->update('member', $data);
    //     if ($update) {
    //         $this->response($data, 200);
    //     } else {
    //         $this->response(array('status' => 'fail', 502));
    //     }
    // }
    
    //delete data yang sudah ada
    // function index_delete() {
    //     $id = $this->delete('id_member');
    //     $this->db->where('id_member', $id);
    //     $delete = $this->db->delete('member');
    //     if ($delete) {
    //         $this->response(array('status' => 'success'), 201);
    //     } else {
    //         $this->response(array('status' => 'fail', 502));
    //     }
    // }
}
?>