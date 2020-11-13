<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class C_StatusMengerjakanLatihan extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    function index_get() {
        $id_latihan = $this->get('id_latihan');
        $id_member = $this->get('id_member');
        if ($id_member == '') {
            $reviewLatihan = $this->db->get('status_mengerjakan_latihan')->result();
        } else {
            $array = array('id_latihan =' => $id_latihan,
                            'id_member =' => $id_member);
            $this->db->where($array);
            $reviewLatihan = $this->db->get('status_mengerjakan_latihan')->result();
        }
        $this->response($reviewLatihan, 200);
    }

    function index_post() {
        $data = array(
            'id_member'=>$this->post('id_member'),
            'id_latihan'=> $this->post('id_latihan'),
            'status_pengerjaan'=> 1,
            'nilai'=> $this->post('nilai')
        );
        $insert = $this->db->insert('status_mengerjakan_latihan', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    function index_put() {
        $data = array(
            'id_member'=> $this->put('id_member'),
            'id_latihan'=> $this->put('id_latihan')
        );
        $nilai = array(
            'nilai'=> $this->put('nilai')
        );

        $this->db->where($data);
        $update = $this->db->update('status_mengerjakan_latihan', $nilai);
        if ($update) {
            $this->response($nilai, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
}
?>