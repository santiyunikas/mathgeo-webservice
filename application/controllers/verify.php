<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class verify extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //Menampilkan data menggunakan email
    function index_get() {
        $email = $this->get('email');

        if (!empty($email)) {

            // Verify data                          
            $data = array(
                'email'=> $email,
                'active'=> 1
            );
            $this->db->where('email', $email);
            $update = $this->db->update('is_verified_member', $data);
            if ($update) {
                echo '<div class="statusmsg">Your account has been activated, you can now login</div>';
                // $this->response($data, 200);
            } else {
                echo '<div class="statusmsg">Invalid approach, please use the link that has been send to your email.</div>';
                // $this->response(array('status' => 'fail', 502));
            }
        }   
    }

}
?>