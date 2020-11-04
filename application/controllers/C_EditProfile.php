<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class C_EditProfile extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    function index_put() {
        $id = $this->put('id');
        $data = array(
            'nama_lengkap'=> $this->put('nama_lengkap'),
            'nomor_telepon'=> $this->put('nomor_telepon'),
            'email'=> $this->put('email')
        );
        $this->db->where('id', $id);
        $update = $this->db->update('member', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

}
?>