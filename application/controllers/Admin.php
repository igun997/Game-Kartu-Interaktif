<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    private $em;

    function __construct() {
        parent::__construct();
        if ($this->session->login != true) {
            redirect(base_url("login"));
        }
        $this->load->model("M_Datamining");
    }

    public function index() {
        $data["csf"] = rand();
        $data["css"] = array(
            base_url("assets/css/bootstrap.min.css"),
            base_url("assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css"),
            base_url("assets/plugins/ionicons-2.0.1/css/ionicons.min.css"),
            base_url("assets/bootstrap/plugins/node-waves/waves.css"),
            base_url("assets/bootstrap/plugins/animate-css/animate.css"),
            base_url("assets/bootstrap/plugins/sweetalert/sweetalert.css"),
            base_url("assets/css/AdminLTE.min.css"),
            base_url("assets/plugins/datatables/dataTables.bootstrap.css"),
            base_url("assets/plugins/lbox/css/lightbox.min.css"),
            base_url("assets/plugins/select2/select2.min.css"),
            base_url("assets/plugins/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css"),
            base_url("/assets/css/skins/_all-skins.css")
        );
        $data["js"] = array(
            base_url("assets/plugins/jQuery/jquery-2.2.3.min.js"),
            base_url("assets/plugins/lbox/js/lightbox-plus-jquery.min.js"),
            base_url("assets/js/bootstrap.min.js"),
            base_url("assets/bootstrap/plugins/sweetalert/sweetalert.min.js"),
            base_url("assets/bootstrap/plugins/node-waves/waves.js"),
            base_url("assets/js/app.min.js"),
            base_url("assets/plugins/select2/select2.full.min.js"),
            base_url("assets/bootstrap/plugins/momentjs/moment.js"),
            base_url("assets/plugins/datatables/jquery.dataTables.min.js"),
            base_url("assets/plugins/datatables/dataTables.bootstrap.min.js"),
            base_url("assets/js/inputmask.js"),
            base_url("assets/plugins/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"),
            base_url("assets/admin.js"),
            base_url("assets/async.js"),
            base_url("assets/bootbox.min.js")
        );
        $user = new Entities\Pengguna();
        $user->find();
        $data["totalPembuat"] = $user->count_rows();
        $tokoh = new Entities\Tokoh();
        $tokoh->find();
        $data["totalTokoh"] = $tokoh->count_rows();
        $quiz = new Entities\Quiz();
        $quiz->find();
        $data["totalQuiz"] = $quiz->count_rows();
        $data["miniLogo"] = "I-BIO";
        $data["Logo"] = "Interactive Bio";
        $data["judul"] = "Dashbiard";
        $this->load->view("admin/header", $data);
        $this->load->view("adminpage/admin", $data);
        $this->load->view("admin/footer", $data);
    }

    function tokoh() {
        $data["csf"] = rand();
        $data["css"] = array(
            base_url("assets/css/bootstrap.min.css"),
            base_url("assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css"),
            base_url("assets/plugins/ionicons-2.0.1/css/ionicons.min.css"),
            base_url("assets/bootstrap/plugins/node-waves/waves.css"),
            base_url("assets/bootstrap/plugins/animate-css/animate.css"),
            base_url("assets/bootstrap/plugins/sweetalert/sweetalert.css"),
            base_url("assets/css/AdminLTE.min.css"),
            base_url("assets/plugins/datatables/dataTables.bootstrap.css"),
            base_url("assets/plugins/datatables/button.css"),
            base_url("assets/plugins/lbox/css/lightbox.min.css"),
            base_url("assets/plugins/select2/select2.min.css"),
            base_url("assets/plugins/datepicker/datepicker3.css"),
            base_url("/assets/css/skins/_all-skins.css")
        );
        $data["js"] = array(
            base_url("assets/plugins/jQuery/jquery-2.2.3.min.js"),
            base_url("assets/plugins/lbox/js/lightbox-plus-jquery.min.js"),
            base_url("assets/js/bootstrap.min.js"),
            base_url("assets/bootstrap/plugins/sweetalert/sweetalert.min.js"),
            base_url("assets/bootstrap/plugins/node-waves/waves.js"),
            base_url("assets/js/app.min.js"),
            base_url("assets/plugins/select2/select2.full.min.js"),
            base_url("assets/bootstrap/plugins/momentjs/moment.js"),
            base_url("assets/plugins/datatables/jquery.dataTables.min.js"),
            base_url("assets/plugins/datatables/dataTables.bootstrap.min.js"),
            base_url("assets/plugins/datatables/button.js"),
            base_url("assets/js/inputmask.js"),
            base_url("assets/plugins/datepicker/bootstrap-datepicker.js"),
            base_url("assets/admin.js"),
            base_url("assets/async.js"),
            base_url("assets/bootbox.min.js")
        );
        $data["miniLogo"] = "I-BIO";
        $data["Logo"] = "Interactive Bio";
        $data["judul"] = "Tokoh Manajer";
        $this->load->view("admin/header", $data);
        $this->load->view("adminpage/tokoh", $data);
        $this->load->view("admin/footer", $data);
    }

}
