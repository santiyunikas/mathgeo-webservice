<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class C_DetailQuiz extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //mengambil data menggunakan email
    function index_get() {
        $id_quiz = $this->get('id_quiz');
        if ($id_quiz == '') {
            $soal_quiz = $this->db->get('soal_quiz')->result();
        } else {
            $this->db->where('id_quiz', $id_quiz);
            $soal_quiz = $this->db->get('soal_quiz')->result();
        }
        $this->response($soal_quiz, 200);
    }

}
?>