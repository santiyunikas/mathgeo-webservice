<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class C_Register extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //Menampilkan menggunakan id
    function index_get() {
        $id = $this->get('id_member');
        if ($id == '') {
            $member = $this->db->get('member')->result();
        } else {
            $this->db->where('id_member', $id);
            $member = $this->db->get('member')->result();
        }
        $this->response($member, 200);
    }

    //Mengirim atau menambah data baru
    function index_post() {
        $data = array(
            'id_member'=>$this->post('id_member'),
            'email'=> $this->post('email'),
            'password'=> $this->post('password'),
            'nama_lengkap'=> $this->post('nama_lengkap'),
            'nomor_telepon'=> $this->post('nomor_telepon')
        );
        $insert = $this->db->insert('member', $data);
        if ($insert) {
            $this->response($data, 200);
            $verify_data = array(
                'email'=> $this->post('email'),
                'active'=> 0
            );

            $insert_verify = $this->db->insert('is_verified_member', $verify_data);
            if($insert_verify){
                $to = $data['email'];
                $subject = 'Santi dari MathGeo';
                $message = '
                Dear '.$data['nama_lengkap'].'

                Terimakasih telah melakukan registrasi!
                Akun kamu sudah dibuat, kamu bisa login menggunakan email dan password dibawah ini

                -----------------------------------
                Email: '.$data['email'].'
                Password: '.$data['password'].'
                -----------------------------------

                Klik link dibawah ini untuk mengaktifkan akun kamu:
                https://mathgeo.ub-learningtechnology.com/verify.php?email='.$data['email'].'

                Selamat belajar dengan tekun



                Salam,
                
                Santi

                MathGeo Developer

                ps: Abaikan email ini jika kamu merasa tidak melakukan registrasi.
                Balas email ini untuk informasi lebih lanjut.

                ';
                $headers = 'From:sysufiana@gmail.com'."\r\n";
                mail($to, $subject, $message, $headers);
            }else{
                $this->response(array('status' => 'fail', 502));
            }
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    //Memperbaharui data yang telah ada
    function index_put() {
        $id = $this->put('id_member');
        $data = array(
            'id_member'=>$this->put('id_member'),
            'email'=> $this->put('email'),
            'password'=> $this->put('password'),
            'nama_lengkap'=> $this->put('nama_lengkap'),
            'nomor_telepon'=> $this->put('nomor_telepon')
                );
        $this->db->where('id_member', $id);
        $update = $this->db->update('member', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
    
    //delete data yang sudah ada
    function index_delete() {
        $id = $this->delete('id_member');
        $this->db->where('id_member', $id);
        $delete = $this->db->delete('member');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
}
?>