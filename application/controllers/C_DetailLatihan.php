<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class C_DetailLatihan extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //mengambil data menggunakan email
    function index_get() {
        $id_latihan = $this->get('id_latihan');
        if ($id_latihan == '') {
            $soal_latihan = $this->db->get('soal_latihan')->result();
        } else {
            $this->db->where('id_latihan', $id_latihan);
            $soal_latihan = $this->db->get('soal_latihan')->result();
        }
        $this->response($soal_latihan, 200);
    }

}
?>