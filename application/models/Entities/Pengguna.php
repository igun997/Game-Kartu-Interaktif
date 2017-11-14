<?php

namespace Entities;

class Pengguna {

    private $id_users;
    private $nama;
    private $username;
    private $password;
    private $getAll;
    private $count;
    private $CI;

    function __construct() {
        $ci = & get_instance();
        $this->CI = $ci;
    }

    function getId_users() {
        return $this->id_users;
    }

    function setId_users($id_users) {
        $this->id_users = $id_users;
    }

    function getNama() {
        return $this->nama;
    }

    function getUsername() {
        return $this->username;
    }

    function getPassword() {
        return $this->password;
    }

    function setNama($nama) {
        $this->nama = $nama;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function save() {
        $data = array("nama" => $this->nama, "username" => $this->username, "password" => $this->CI->encrypt->encode($this->password));
        return $this->CI->db->insert("users", $data);
    }

    function update() {
        $data = array("nama" => $this->nama, "username" => $this->username, "password" => $this->CI->encrypt->encode($this->password));
        $update = $this->CI->db->where("id_users", $this->id_users)->update("users", $data);
        return $this->CI->db->affected_rows() > 0;
    }

    function delete() {
        $del = $this->CI->db->delete("users", array("id_users" => $this->id_users));
        return $this->CI->db->affected_rows() > 0;
    }

    function find($id = '') {
        if ($id != '') {
            $get = $this->CI->db->get_where("users", array("id_users" => $id));
            $this->nama = $get->row()->nama;
            $this->id_users = $get->row()->id_users;
            $this->username = $get->row()->username;
            $this->password = $get->row()->password;
        } else {
            $get = $this->CI->db->get("users");
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
