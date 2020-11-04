<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class C_KodeTeman extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    function index_post() {
        $data = array(
            'id_member'=>$this->post('id_member'),
            'kode_teman'=> $this->post('kode_teman')
        );
        $insert = $this->db->insert('kode_teman', $data);
        if ($insert) {
          $this->response($data, 200);
        } else {
          $this->response(array('status' => 'fail', 502));
        }
    }
}
?>