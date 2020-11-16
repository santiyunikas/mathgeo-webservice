<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class C_PembahasanLatihan extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    function index_get() {
        $id_latihan = $this->get('id_latihan');
        if ($id_latihan == '') {
            $pembahasan = $this->db->get('pembahasan_soal_latihan')->result();
        } else {
            $this->db->where('id_latihan', $id_latihan);
            $pembahasan = $this->db->get('pembahasan_soal_latihan')->result();
        }
        $this->response($pembahasan, 200);
    }
}
?>