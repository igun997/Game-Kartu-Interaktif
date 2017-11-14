<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Rest extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model("M_Datamining");
    }

    function _restrict($lvl) {
        if ($lvl == 1) {
            if (!$this->session->login == true && !$this->session->login_lvl == 1) {
                return $this->response(array("status" => 0, "msg" => "You Must Login"));
                exit();
            }
        }
    }

    function getdata_get($kode = '') {
        if ($kode != '') {

            $this->response($this->M_Datamining->getData($kode));
        } else {
            $this->response(array("status" => 0, "mgs" => "No Data"));
        }
    }

    function getDataTokoh_post() {
        $this->_restrict(1);
        $this->load->library("datatables");
        $this->datatables->select("id_data,nama,tempat_lahir,tanggal_lahir");
        $this->datatables->from("data_tokoh");
        $data = $this->datatables->generate();
        $this->response($data);
    }

    function login_post() {
        $this->response($this->M_Datamining->login($this->input->post("user", true), $this->input->post("pass")));
    }

    function isLogin_get() {
        $this->_restrict(1);
        $this->response(array("status" => 1, "msg" => "Logged In"));
    }

    function hapustokoh_post() {
        $tokoh = new Entities\Tokoh();
        $tokoh->find($this->input->post("id", true));
        $nameFoto = $tokoh->getFoto();
        $nameVideo = $tokoh->getVideo();
        $res = $tokoh->delete();
        if ($res) {
            $assetVideo = "_upload/video/";
            $assetFoto = "_upload/foto/";
            if(unlink($assetVideo.$nameVideo) && unlink($assetFoto.$nameFoto))
            {
                $this->response(array("status" => 1, "msg" => "Tokoh Di Hapus"));
            }else{
                $this->response(array("status" => 0, "msg" => "Assets Tokoh Gagal di Hapus"));
            }
            
        } else {
            $this->response(array("status" => 0, "msg" => "Tokoh Gagal Di Hapus"));
        }
    }

    function test_get() {
        $this->_restrict(1);
    }

    function logout_get() {
        $this->session->sess_destroy();
        $this->response(array("status" => 1));
    }

}
