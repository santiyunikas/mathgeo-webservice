<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/email/PHPMailer/PHPMailerAutoload.php';
use Restserver\Libraries\REST_Controller;

class C_Register extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //Menampilkan data menggunakan email
    function index_get() {
        $email = $this->get('email');
        if ($email == '') {
            $member = $this->db->get('')->result();
        } else {
            $this->db->where('email', $email);
            $member = $this->db->get('member')->result();
        }
        $this->response($member, 200);

        if(!empty($email)){
            // Verify data                          
            $search = mysql_query("SELECT email, active FROM is_verified_member WHERE email='".$email."' AND active='0'") or die(mysql_error()); 
            $match  = mysql_num_rows($search);
                          
            if($match > 0){
                // We have a match, activate the account
                mysql_query("UPDATE is_verified_member SET active='1' WHERE email='".$email."' AND active='0'") or die(mysql_error());
                echo '<div class="statusmsg">Your account has been activated, you can now login</div>';
            }else{
                // No match -> invalid url or account has already been activated.
                echo '<div class="statusmsg">The url is either invalid or you already have activated your account.</div>';
            }
                          
        }else{
            // Invalid approach
            echo '<div class="statusmsg">Invalid approach, please use the link that has been send to your email.</div>';
        }
    }

}
?>