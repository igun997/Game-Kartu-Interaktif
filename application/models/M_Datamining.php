<?php

class M_Datamining extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getData($kode = '') {
        $assetVideo = base_url("_upload/video/");
        $assetFoto = base_url("_upload/foto/");
        $tokoh = new Entities\Tokoh();
        if ($tokoh->find($kode) !== 0) {
            return array("status" => 1, "data" => array("nama_tokoh" => $tokoh->getNama(), "tentang" => $tokoh->getTentang(), "foto" => $assetFoto . $tokoh->getFoto(), "video" => $assetVideo . $tokoh->getVideo(), "tempat_lahir" => $tokoh->getTempat_lahir(), "tanggal_lahir" => $tokoh->getTanggal_lahir(), "tanggal_wafat" => $tokoh->getTanggal_wafat()));
        }else{
            return array("status" => 0, "data" => array());
        }
    }

    function login($username = '', $password = '') {
        if ($username != '' && $password != '') {
            $user = $this->db->get_where("users", array("username" => $username));
            if ($user->num_rows() > 0) {
                $d = $user->row();
                if ($this->encrypt->decode($d->password) == $password) {
                    $this->session->set_userdata("login", true);
                    $this->session->set_userdata("login_level", 1);
                    $this->session->set_userdata("username", $username);
                    $this->session->set_userdata("id_users", $d->id_users);
                    return array("status" => 1);
                } else {
                    return array("status" => 0,"msg"=>"Wrong Password","debug"=>$password.$this->encrypt->decode($d->password));
                }
            } else {
                return array("status" => 0,"msg"=>"Wrong Users");
            }
        } else {
            return array("status" => 0);
        }
    }

}
