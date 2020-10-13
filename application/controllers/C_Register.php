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

    //Menampilkan menggunakan id
    function index_get() {
        $id = $this->get('id_pengguna');
        if ($id == '') {
            $pengguna = $this->db->get('pengguna')->result();
        } else {
            $this->db->where('id_pengguna', $id);
            $pengguna = $this->db->get('pengguna')->result();
        }
        $this->response($pengguna, 200);
    }

    //Mengirim atau menambah data baru
    function index_post() {
        $data = array(
            'id_pengguna'=>$this->post('id_pengguna'),
            'email'=> $this->post('email'),
            'password'=> $this->post('password'),
            'nama_lengkap'=> $this->post('nama_lengkap'),
            'nomor_telepon'=> $this->post('nomor_telepon'),
            'active'=> 0
        );
        $insert = $this->db->insert('pengguna', $data);
        if ($insert) {
          $this->sendEmailVerification($data);
          $this->response($data, 200);
        } else {
          $this->response(array('status' => 'fail', 502));
        }
    }

    function sendEmailVerification($data){
        $to = $data['email'];
        $subject = 'Santi dari MathGeo';
        $message = '
                <p><strong>Dear '.$data['nama_lengkap'].'</strong></p>
                <p>Terimakasih telah melakukan registrasi!</p>
                <p>Akun kamu sudah dibuat, kamu bisa login menggunakan email dan password dibawah ini</p>
                <p>-----------------------------------</p>
                <p>Email: '.$data['email'].'</p>
                <p>Password: '.$data['password'].'</p>
                <p>-----------------------------------</p>
                <p>Klik link dibawah ini untuk mengaktifkan akun kamu:</p>
                https://mathgeo.ub-learningtechnology.com/verify.php?email='.$data['email'].'
                <p>Selamat belajar dengan tekun</p>                
                <p>Salam,</p>
                <p><strong>Santi</strong></p>
                <p>MathGeo Developer</p>
                <p>ps: Abaikan email ini jika kamu merasa tidak melakukan registrasi.</p>';
        $this->smtp_mail($to, $subject, $message, '', '', 0, 0, false);
    }

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

    //Memperbaharui data yang telah ada
    function index_put() {
        $id = $this->put('id_pengguna');
        $data = array(
          'id_pengguna'=>$this->post('id_pengguna'),
          'email'=> $this->post('email'),
          'password'=> $this->post('password'),
          'nama_lengkap'=> $this->post('nama_lengkap'),
          'nomor_telepon'=> $this->post('nomor_telepon'),
          'active'=> 1
        );
        $this->db->where('id_pengguna', $id);
        $update = $this->db->update('pengguna', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
    
    //delete data yang sudah ada
    function index_delete() {
        $email= $this->delete('email');
        $this->db->where('email', $email);
        $delete = $this->db->delete('pengguna');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
}
?>