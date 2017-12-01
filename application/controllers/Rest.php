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

    function _resize_image($file, $w, $h, $crop = FALSE) {
        list($width, $height) = getimagesize($file);
        $r = $width / $height;
        if ($crop) {
            if ($width > $height) {
                $width = ceil($width - ($width * abs($r - $w / $h)));
            } else {
                $height = ceil($height - ($height * abs($r - $w / $h)));
            }
            $newwidth = $w;
            $newheight = $h;
        } else {
            if ($w / $h > $r) {
                $newwidth = $h * $r;
                $newheight = $h;
            } else {
                $newheight = $w / $r;
                $newwidth = $w;
            }
        }
        $src = imagecreatefromjpeg($file);
        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        return $dst;
    }

    function generatecard_get($card = '') {
        $this->_restrict(1);
        if ($card != '') {
            $tokoh = new Entities\Tokoh();
            $tokoh->find($card);
            if ($tokoh->count_rows() > 0) {
                $this->load->library('ciqrcode');
                $config['cacheable'] = true; //boolean, the default is true
                $config['cachedir'] = ''; //string, the default is application/cache/
                $config['errorlog'] = ''; //string, the default is application/logs/
                $config['quality'] = true; //boolean, the default is true

                $config['black'] = array(224, 255, 255); // array, default is array(255,255,255)
                $config['white'] = array(224, 255, 255); // array, default is array(0,0,0)
                $this->ciqrcode->initialize($config);
                $params['data'] = $tokoh->getId_data();
                ob_start();
                $this->ciqrcode->generate($params);
                $imgString = ob_get_clean();
                $cardTemplate = base_url("_upload/card/cardTemplate.jpg");
                $cardNow = base_url("_upload/foto/" . $tokoh->getFoto());
                $dest = imagecreatefromjpeg($cardTemplate);
                $qr = imagecreatefromstring($imgString);
                $textcolor = imagecolorallocate($dest, 0, 0, 0);
                $font = "assets/OpenSans-Regular.ttf";
                $fontSize = "18";
                ob_start();
                imagettftext($dest, 25, 90, 570, 750, $textcolor, $font, "AA");
                imagettftext($dest, 25, 90, 1268, 1620, $textcolor, $font, "AA");
                $foto = $this->_resize_image($cardNow, 350, 340);
                imagecopymerge($dest, $foto, 70, 64, 0, 0, 238, 340, 100);
                imagecopymerge($dest, $qr, 140, 450, 0, 0, 100, 100, 100);
                imagejpeg($dest);
                imagedestroy($dest);
                //header('Content-Type: image/jpeg');
                $realImage = base64_encode(ob_get_contents());
                ob_clean();
                $this->response(array("status" => 1, "msg" => "Success Generated", "data" => "data:image/jpeg;base64," . $realImage));
            } else {
                $this->response(array("status" => 0, "msg" => "Card Not Found"));
            }
        } else {
            $this->response(array("status" => 0, "msg" => "No Card ID"));
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

    function uploadUpdate_post() {
        $this->_restrict(1);
        $tokoh = new Entities\Tokoh();
        $tokoh->find($this->input->post("id", true));
        $fotoNow = $tokoh->getFoto();
        $videoNow = $tokoh->getVideo();
        $uploadFoto = false;
        $uploadVideo = false;
        $dataFoto = "";
        $dataVideo = "";
        $noFoto = false;
        $noVideo = false;
        $config["detect_mime"] = true;
        $config["encrypt_name"] = true;
        $config["mod_mime_fix"] = true;
        if (isset($_FILES["foto"]["tmp_name"])) {
            $config['upload_path'] = realpath(APPPATH . '../_upload/foto/');

            @unlink($config['upload_path'] . $fotoNow);
            $config['allowed_types'] = 'jpg|jpeg';
            $config['max_size'] = 500;
            $this->load->library('upload', $config, 'fotoObjek');
            $this->fotoObjek->initialize($config);
            $uploadFoto = $this->fotoObjek->do_upload('foto');
            if ($uploadFoto) {
                $dataFoto = $this->fotoObjek->data();
                $this->load->library('image_lib');
                $configer = array(
                    'image_library' => 'gd2',
                    'source_image' => $dataFoto['full_path'],
                    'maintain_ratio' => false,
                    'width' => 500,
                    'height' => 714,
                );
                $this->image_lib->clear();
                $this->image_lib->initialize($configer);
                $this->image_lib->resize();
            } else {
                $dataFoto = $this->fotoObjek->display_errors();
            }
        } else {
            $noFoto = true;
        }
        if (isset($_FILES["video"]["tmp_name"])) {
            $config['upload_path'] = '_upload/video/';
            @unlink($config['upload_path'] . $videoNow);
            $config['allowed_types'] = 'mp4|flv';
            $config['max_size'] = 50000;
            $this->load->library('upload', $config, 'videoObjek');
            $this->videoObjek->initialize($config);
            $uploadVideo = $this->videoObjek->do_upload('video');
            if ($uploadVideo) {
                $dataVideo = $this->videoObjek->data();
            } else {
                $dataVideo = $this->videoObjek->display_errors();
            }
        } else {
            $noVideo = true;
        }
        if ($noFoto && $noVideo) {
            $this->response(array("status" => 1, "curFoto" => $fotoNow, "vidNow" => $videoNow, "dataFoto" => (isset($dataFoto["file_name"])) ? $dataFoto["file_name"] : null, "dataVideo" => (isset($dataVideo["file_name"])) ? $dataVideo["file_name"] : null));
            exit();
        }
        if ($uploadFoto || $uploadVideo) {
            $this->response(array("status" => 1, "curFoto" => $fotoNow, "vidNow" => $videoNow, "dataFoto" => (isset($dataFoto["file_name"])) ? $dataFoto["file_name"] : null, "dataVideo" => (isset($dataVideo["file_name"])) ? $dataVideo["file_name"] : null));
        } else {
            //$this->response($_FILES["foto"]);
            $response = array("status" => 0, "msg" => "Fail to Upload", "debug" => array("foto" => array("status" => $uploadFoto, "data" => $dataFoto, "files" => null), "video" => array("status" => $uploadVideo, "data" => $dataVideo, "files" => null)));
            if ($response["debug"]["foto"]["status"]) {
                unlink("_upload/foto/" . $response["debug"]["foto"]["data"]["file_name"]);
            }
            if ($response["debug"]["video"]["status"]) {
                unlink("_upload/video/" . $response["debug"]["video"]["data"]["file_name"]);
            }
            $this->response($response);
        }
    }

    function findTokoh_get($id) {
        $this->_restrict(1);
        $tokoh = new Entities\Tokoh();
        $tokoh->find($id);
        $this->response($tokoh->fetchAll());
    }

    function updatedata_post() {
        $this->_restrict(1);
        $data = $this->input;
        $tokoh = new Entities\Tokoh();
        $tokoh->setId_data($data->post("id_data", true));
        $tokoh->setNama($data->post("nama", true));
        $tokoh->setTempat_lahir($data->post("tempat_lahir", true));
        $tokoh->setTanggal_lahir($data->post("tanggal_lahir", true));
        $tokoh->setTanggal_wafat($data->post("tanggal_wafat", true));
        $tokoh->setTentang($data->post("txtArea", false));
        if ($data->post("foto", true) != null) {
            $tokoh->setFoto($data->post("foto", true));
        } else {
            $tokoh->setFoto($data->post("curFoto", true));
        }
        if ($data->post("video", true) != null) {
            $tokoh->setVideo($data->post("video", true));
        } else {
            $tokoh->setFoto($data->post("vidNow", true));
        }

        $tokoh->setId_users($this->session->id_users);
        $status = $tokoh->update();
        if ($status) {
            $d = array("status" => 1, "msg" => "Success Update");
        } else {
            $d = array("status" => 0, "msg" => "Fail To Update", "debug" => $data->post("vidNow", true));
        }
        $this->response($d);
    }

    function savedata_post() {
        $this->_restrict(1);
        $data = $this->input;
        $tokoh = new Entities\Tokoh();
        $tokoh->setNama($data->post("nama", true));
        $tokoh->setTempat_lahir($data->post("tempat_lahir", true));
        $tokoh->setTanggal_lahir($data->post("tanggal_lahir", true));
        $tokoh->setTanggal_wafat($data->post("tanggal_wafat", true));
        $tokoh->setTentang($data->post("txtArea", false));
        $tokoh->setFoto($data->post("foto", true));
        $tokoh->setVideo($data->post("video", true));
        $tokoh->setId_users($this->session->id_users);
        $status = $tokoh->save();
        if ($status) {
            $d = array("status" => 1, "msg" => "Success Save");
        } else {
            $d = array("status" => 0, "msg" => "Fail To Save");
        }
        $this->response($d);
    }

    function upload_post() {
        $this->_restrict(1);
        $uploadFoto = false;
        $uploadVideo = false;
        $dataFoto = "";
        $dataVideo = "";
        $config["detect_mime"] = true;
        $config["encrypt_name"] = true;
        $config["mod_mime_fix"] = true;
        if (isset($_FILES["foto"]["tmp_name"])) {
            $config['upload_path'] = realpath(APPPATH . '../_upload/foto/');
            $config['allowed_types'] = 'jpg|jpeg';
            $config['max_size'] = 500;
            $this->load->library('upload', $config, 'fotoObjek');
            $this->fotoObjek->initialize($config);
            $uploadFoto = $this->fotoObjek->do_upload('foto');
            if ($uploadFoto) {
                $dataFoto = $this->fotoObjek->data();
                $this->load->library('image_lib');
                $configer = array(
                    'image_library' => 'gd2',
                    'source_image' => $dataFoto['full_path'],
                    'maintain_ratio' => false,
                    'width' => 500,
                    'height' => 714,
                );
                $this->image_lib->clear();
                $this->image_lib->initialize($configer);
                $this->image_lib->resize();
            } else {
                $dataFoto = $this->fotoObjek->display_errors();
            }
        }
        if (isset($_FILES["video"]["tmp_name"])) {
            $config['upload_path'] = '_upload/video/';
            $config['allowed_types'] = 'mp4|flv';
            $config['max_size'] = 50000;
            $this->load->library('upload', $config, 'videoObjek');
            $this->videoObjek->initialize($config);
            $uploadVideo = $this->videoObjek->do_upload('video');
            if ($uploadVideo) {
                $dataVideo = $this->videoObjek->data();
            } else {
                $dataVideo = $this->videoObjek->display_errors();
            }
        }
        if ($uploadFoto && $uploadVideo) {
            $this->response(array("status" => 1, "dataFoto" => $dataFoto["file_name"], "dataVideo" => $dataVideo["file_name"]));
        } else {
            //$this->response($_FILES["foto"]);
            $response = array("status" => 0, "msg" => "Fail to Upload", "debug" => array("foto" => array("status" => $uploadFoto, "data" => $dataFoto, "files" => $_FILES["foto"]), "video" => array("status" => $uploadVideo, "data" => $dataVideo, "files" => $_FILES["video"])));
            if ($response["debug"]["foto"]["status"]) {
                unlink("_upload/foto/" . $response["debug"]["foto"]["data"]["file_name"]);
            }
            if ($response["debug"]["video"]["status"]) {
                unlink("_upload/video/" . $response["debug"]["video"]["data"]["file_name"]);
            }
            $this->response($response);
        }
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
            if (@unlink($assetVideo . $nameVideo) && @unlink($assetFoto . $nameFoto)) {
                $this->response(array("status" => 1, "msg" => "Tokoh Di Hapus"));
            } else {
                $this->response(array("status" => 0, "msg" => "Assets Tokoh Gagal di Hapus"));
            }
        } else {
            $this->response(array("status" => 0, "msg" => "Tokoh Gagal Di Hapus"));
        }
    }

    function test_get() {
        $this->_restrict(1);
        $tokoh = new Entities\Tokoh();
        $tokoh->find();
        $this->response($tokoh->fetchAll());
    }

    function logout_get() {
        $this->session->sess_destroy();
        $this->response(array("status" => 1));
    }

}
