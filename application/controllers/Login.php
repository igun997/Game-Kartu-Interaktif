<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->login == true) {
            redirect(base_url("admin"));
        }
    }

    public function index() {
        $data["js"] = array(
            base_url("assets/bootstrap/plugins/jquery/jquery.min.js"),
            base_url("assets/bootstrap/js/bootstrap.min.js"),
            base_url("assets/bootstrap/plugins/node-waves/waves.js"),
            base_url("assets/bootstrap/plugins/sweetalert/sweetalert.min.js"),
            base_url("assets/admin.js"),
            base_url("assets/async.js"),
            base_url("assets/bootbox.min.js")
        );
        $data["css"] = array(
            base_url("assets/bootstrap/css/bootstrap.min.css"),
            base_url("assets/bootstrap/plugins/node-waves/waves.css"),
            base_url("assets/bootstrap/plugins/animate-css/animate.css"),
            base_url("assets/bootstrap/plugins/sweetalert/sweetalert.css"),
            base_url("assets/bootstrap/plugins/material-design-preloader/md-preloader.css"),
            base_url("assets/bootstrap/css/style.css"),
            base_url("assets/bootstrap/plugins/font-awesome/css/font-awesome.css"),
            base_url("assets/bootstrap/css/themes/all-themes.css")
        );
        $this->load->view("login", $data);
    }

}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */