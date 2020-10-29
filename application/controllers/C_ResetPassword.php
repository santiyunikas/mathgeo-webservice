<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/email/PHPMailer/PHPMailerAutoload.php';
use Restserver\Libraries\REST_Controller;

class C_ResetPassword extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }


    //digunakan untuk membuat akun baru
    function index_get() {
        $otp = $this->get('otp');
        if ($otp == '') {
            $otp = '1234';
        }

        $email = $this->get('email');
        if ($email == '') {
            $this->response(array('status' => 'fail', 502));
        } else {
            $this->db->where('email', $email);
            $member = $this->db->get('member')->result();
            if($member->email==$email){
                $this->sendOtp($otp, $member);
                $this->response($member, 200);
            }
        }  
    }

    //digunakan untuk membuat format email dan mengirimnya
    function sendOtp($otp, $member){
        $to = $email;
        $subject = $otp.' -- Kode OTP Kamu';
        $message = '
                <p><strong>Dear '.$member['nama_lengkap'].'</strong></p>
                <p>Kamu terdeteksi melakukan reset password akun MathGeo</p>
                <p>'.$otp.' -- Kode OTP Kamu</p>
                <br>
                <br>
                <p>Salam,</p>
                <p><strong>Santi</strong></p>
                <p>MathGeo Developer</p>
                <p>ps: Abaikan email ini jika kamu merasa tidak melakukan reset password.</p>';
        $this->smtp_mail($to, $subject, $message, '', '', 0, 0, false);
    }

    //konfigurasi email
    function smtp_mail($to, $subject, $message, $from_name, $from, $cc, $bcc, $debug=false) {
        $mail = new PHPMailer;
        $mail->SMTPDebug = $debug; // Ubah menjadi true jika ingin menampilkan sistem debug SMTP Mailer
        $mail->isSMTP();
        
        // Hapus Semua Tujuan, CC dan BCC
        $mail->ClearAddresses();  
        $mail->ClearCCs();
        $mail->ClearBCCs();
      
        /* -------------------------- Konfigurasi Dasar SMTP ---------------------------------- */
        
        $mail->SMTPAuth 	= false;                        				
        $mail->Host 		  = 'mail.ub-learningtechnology.com';  // Masukkan Server SMTP
        $mail->Port 		  = 587;                                      // Masukkan Port SMTP
        $mail->SMTPSecure = 'tls';                                    // Masukkan Pilihan Enkripsi ( `tls` atau `ssl` )
        $mail->Username 	= 'mathgeo_team@ub-learningtechnology.com';                // Masukkan Email yang digunakan selama proses pengiriman email via SMTP
        $mail->Password 	= 'mathgeo_team';        						          // Masukkan Password dari Email tsb
        $default_email_from       = 'mathgeo_team@ub-learningtechnology.com';        // Masukkan default from pada email
        $default_email_from_name  = 'Santi dari MathGeo';           // Masukkan default nama dari from pada email
        
        /* -------------------------- Konfigurasi Dasar SMTP ---------------------------------- */
        
        if(empty($from)) $mail->From = $default_email_from;
        else $mail->From = $from;
      
        if(empty($from_name)) $mail->FromName = $default_email_from_name;
        else $mail->FromName = $from_name;
        
        // Set penerima email
        if(is_array($to)) {
          foreach($to as $k => $v) {
            $mail->addAddress($v);
          }
        } else {
          $mail->addAddress($to);
        }
        
        // Set email CC ( optional )
        if(!empty($cc)) {
          if(is_array($cc)) {
            foreach($cc as $k => $v) {
              $mail->addCC($v);
            }
          } else {
            $mail->addCC($cc);
          }
        }
        
        // Set email BCC ( optional )
        if(!empty($bcc)) {
          if(is_array($bcc)) {
            foreach($bcc as $k => $v) {
              $mail->addBCC($v);
            }
          } else {
            $mail->addBCC($bcc);
          }
        }
        
        // Set isi dari email
        $mail->isHTML(true);
        $mail->Subject 	= $subject;
        $mail->Body 	= $message;
        $mail->AltBody	= $message;
        $mail->send();
    }

}
?>