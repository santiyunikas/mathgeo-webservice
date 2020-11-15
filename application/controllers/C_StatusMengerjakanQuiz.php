<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class C_StatusMengerjakanQuiz extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    function index_get() {
        $id_quiz = $this->get('id_quiz');
        $id_member = $this->get('id_member');
        if ($id_member == '' || $id_quiz == '') {
            $reviewQuiz = $this->db->get('status_mengerjakan_quiz')->result();
        } else {
            $array = array('id_quiz =' => $id_quiz,
                            'id_member =' => $id_member);
            $this->db->where($array);
            $reviewQuiz = $this->db->get('status_mengerjakan_quiz')->result();
        }
        $this->response($reviewQuiz, 200);
    }

    function index_post() {
        $data = array(
            'id_member'=>$this->post('id_member'),
            'id_quiz'=> $this->post('id_quiz'),
            'status_pengerjaan'=> 1,
            'nilai'=> $this->post('nilai')
        );
        $insert = $this->db->insert('status_mengerjakan_quiz', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    function index_put() {
        $data = array(
            'id_member'=> $this->put('id_member'),
            'id_quiz'=> $this->put('id_quiz')
        );
        $nilai = array(
            'nilai'=> $this->put('nilai')
        );

        $this->db->where($data);
        $update = $this->db->update('status_mengerjakan_quiz', $nilai);
        if ($update) {
            $this->response($nilai, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
}
?>