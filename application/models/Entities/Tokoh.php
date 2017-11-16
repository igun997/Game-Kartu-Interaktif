<?php

namespace Entities;

class Tokoh {

    private $getAll;
    private $count;
    private $CI;
    private $id_data;
    private $nama;
    private $tentang;
    private $foto;
    private $video;
    private $tempat_lahir;
    private $tanggal_lahir;
    private $tanggal_wafat;
    private $id_users;

    function __construct() {
        $ci = & get_instance();
        $this->CI = $ci;
    }

    function getId_data() {
        return $this->id_data;
    }

    function getNama() {
        return $this->nama;
    }

    function getTentang() {
        return $this->tentang;
    }

    function getFoto() {
        return $this->foto;
    }

    function getVideo() {
        return $this->video;
    }

    function getTempat_lahir() {
        return $this->tempat_lahir;
    }

    function getTanggal_lahir() {
        return $this->tanggal_lahir;
    }

    function getTanggal_wafat() {
        return $this->tanggal_wafat;
    }

    function getId_users() {
        return $this->id_users;
    }

    function setId_data($id_data) {
        $this->id_data = $id_data;
    }

    function setNama($nama) {
        $this->nama = $nama;
    }

    function setTentang($tentang) {
        $this->tentang = $tentang;
    }

    function setFoto($foto) {
        $this->foto = $foto;
    }

    function setVideo($video) {
        $this->video = $video;
    }

    function setTempat_lahir($tempat_lahir) {
        $this->tempat_lahir = $tempat_lahir;
    }

    function setTanggal_lahir($tanggal_lahir) {
        $this->tanggal_lahir = $tanggal_lahir;
    }

    function setTanggal_wafat($tempat_wafat) {
        $this->tanggal_wafat = $tempat_wafat;
    }

    function setId_users($id_users) {
        $this->id_users = $id_users;
    }

    function save() {
        //Change With Your Query
        $data = array("nama" => $this->nama, "tentang" => $this->tentang, "foto" => $this->foto, "video" => $this->video, "tempat_lahir" => $this->tempat_lahir, "tanggal_lahir" => $this->tanggal_lahir, "tanggal_wafat" => $this->tanggal_wafat, "id_users" => $this->id_users);
        return $this->CI->db->insert("data_tokoh", $data);
    }

    function update() {
        $data =  array("nama" => $this->nama, "tentang" => $this->tentang, "foto" => $this->foto, "video" => $this->video, "tempat_lahir" => $this->tempat_lahir, "tanggal_lahir" => $this->tanggal_lahir, "tanggal_wafat" => $this->tanggal_wafat, "id_users" => $this->id_users);
        $update = $this->CI->db->where("id_data", $this->id_data)->update("data_tokoh", $data);
        return $this->CI->db->affected_rows() > 0;
    }
    function delete() {
        $del = $this->CI->db->delete("data_tokoh",array("id_data"=>$this->id_data));
        return $this->CI->db->affected_rows() > 0;
    }
    function find($id = '') {
        //Change With Your Query
        if ($id != '') {
            $get = $this->CI->db->get_where("data_tokoh", array("id_data" => $id));
            if($get->num_rows() > 0)
            {
                $this->id_data = $get->row()->id_data;
                $this->nama = $get->row()->nama;
                $this->tanggal_lahir = $get->row()->tanggal_lahir;
                $this->tempat_lahir = $get->row()->tempat_lahir;
                $this->tanggal_wafat = $get->row()->tanggal_wafat;
                $this->tentang = $get->row()->tentang;
                $this->foto = $get->row()->foto;
                $this->video = $get->row()->video;
                $this->getAll = $get->result();
            }else{
                return 0;
            }
        } else {
            $get = $this->CI->db->get("data_tokoh");
            $this->getAll = $get->result();
            $this->count = $get->num_rows();
        }
    }
    
    function fetchAll() {
        return $this->getAll();
    }

    function count_rows() {
        return $this->count;
    }

}
