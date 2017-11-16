<?php

namespace Entities;

class Quiz {

    private $id_quiz;
    private $soal;
    private $kunci_jawaban;
    private $a, $b, $c, $d;
    private $dibuat;
    private $id_users;
    private $id_data;
    private $getAll;
    private $count;
    private $CI;

    function __construct() {
        $ci = & get_instance();
        $this->CI = $ci;
    }

    function getId_quiz() {
        return $this->id_quiz;
    }

    function getSoal() {
        return $this->soal;
    }

    function getKunci_jawaban() {
        return $this->kunci_jawaban;
    }

    function getA() {
        return $this->a;
    }

    function getB() {
        return $this->b;
    }

    function getC() {
        return $this->c;
    }

    function getD() {
        return $this->d;
    }

    function getDibuat() {
        return $this->dibuat;
    }

    function getId_users() {
        return $this->id_users;
    }

    function getId_data() {
        return $this->id_data;
    }

    function setId_quiz($id_quiz) {
        $this->id_quiz = $id_quiz;
    }

    function setSoal($soal) {
        $this->soal = $soal;
    }

    function setKunci_jawaban($kunci_jawaban) {
        $this->kunci_jawaban = $kunci_jawaban;
    }

    function setA($a) {
        $this->a = $a;
    }

    function setB($b) {
        $this->b = $b;
    }

    function setC($c) {
        $this->c = $c;
    }

    function setD($d) {
        $this->d = $d;
    }

    function setDibuat($dibuat) {
        $this->dibuat = $dibuat;
    }

    function setId_users($id_users) {
        $this->id_users = $id_users;
    }

    function setId_data($id_data) {
        $this->id_data = $id_data;
    }

    function save() {
        //Change With Your Query
        $data = array("soal" => $this->soal, "kunci_jawaban" => $this->kunci_jawaban, "a" => $this->a, "b" => $this->b, "c" => $this->c, "d" => $this->d, "dibuat" => $this->dibuat, "id_users" => $this->id_users, "id_data" => $this->id_data);
        return $this->CI->db->insert("data_quiz", $data);
    }

    function update() {
        //Change With Your Query
        $data = array("soal" => $this->soal, "kunci_jawaban" => $this->kunci_jawaban, "a" => $this->a, "b" => $this->b, "c" => $this->c, "d" => $this->d, "dibuat" => $this->dibuat, "id_users" => $this->id_users, "id_data" => $this->id_data);
        $update = $this->CI->db->where("id_quiz", $this->id_quiz)->update("data_quiz", $data);
        return $this->CI->db->affected_rows() > 0;
    }

    function delete() {
        //Change With Your Query
        $del = $this->CI->db->delete("data_quiz", array("id_quiz" => $this->id_quiz));
        return $this->CI->db->affected_rows() > 0;
    }

    function find($id = '') {
        //Change With Your Query
        if ($id != '') {
            $get = $this->CI->db->get_where("data_quiz", array("id_quiz" => $id));
            //Insert Your Atribut
            if ($get->num_rows() > 0) {
                $this->id_quiz = $get->row()->id_quiz;
                $this->soal = $get->row()->soal;
                $this->kunci_jawaban = $get->row()->kunci_jawaban;
                $this->a = $get->row()->a;
                $this->b = $get->row()->b;
                $this->c = $get->row()->c;
                $this->d = $get->row()->d;
                $this->dibuat = $get->row()->dibuat;
                $this->id_users = $get->row()->id_users;
                $this->id_data = $get->row()->id_data;
                $this->getAll = $get->result();
            } else {
                return 0;
            }
        } else {
            $get = $this->CI->db->get("data_quiz");
            $this->getAll = $get->result();
            $this->count = $get->num_rows();
        }
    }

    function fetchAll() {
        return $this->getAll;
    }

    function count_rows() {
        return $this->count;
    }

}
