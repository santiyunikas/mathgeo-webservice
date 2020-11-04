<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class C_ReferalMember extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //mengambil data menggunakan kode referal
    function index_get() {
        $kode_referal = $this->get('kode_referal');
        if ($kode_referal == '') {
            $member = $this->db->get('member')->result();
        } else {
            $this->db->where('kode_referal', $kode_referal);
            $member = $this->db->get('member')->result();
        }
        $this->response($member, 200);
    }

    //memperbaharui jumlah koin
    function index_put() {
        $email = $this->put('email');
        $data = array(
            'jumlah_koin'=> $this->put('jumlah_koin'),
        );
        $this->db->where('email', $email);
        $update = $this->db->update('member', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
}
?>