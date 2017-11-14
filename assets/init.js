
/* global Instascan, bootbox, base_url */

function getQR() {
    let scanner = new Instascan.Scanner({video: document.getElementById('cam')});
    scanner.addListener('scan', function (content) {
        console.log("Accept Request := " + content);
        console.log("Status Input := "+$("#bodi").attr("status-input"));
        if ($("#bodi").attr("status-input") == 0)
        {
            $("#bodi").attr("status-input","1");
            console.log("Status Input := "+$("#bodi").attr("status-input"));
            $.get(base_url + "getdata/" + content, function (res) {
                if (res["status"] == 1)
                {
                    document.getElementById('checklist').play();
                    var d = res["data"];
                    var dialog = bootbox.dialog({
                        title: 'Loading . . ',
                        message: '<center><p><i class="fa fa-spin fa-spinner"></li></p></center>'
                    });
                    dialog.init(function () {
                        setTimeout(function () {

                            console.log("Input := " + $("#bodi").attr("status-input"));
                            dialog.find(".modal-title").html('Biografi Karakter');
                            dialog.find(".bootbox-body").html('<div class="row"><div class="col-md-6"><p style="color:#000;"><b>Nama Tokoh</b></p><p>' + d.nama_tokoh + '</p><p style="color:#000;"><b>Tempat Lahir<b></p><p>' + d.tempat_lahir + '</p><p style="color:#000;"><b>Tanggal Lahir<b></p><p>' + d.tanggal_lahir + '</p><p style="color:#000;"><b>Tanggal Wafat<b></p><p>' + d.tanggal_wafat + '</p><p style="color:#000;"><b>Tentang <b></p><p>' + d.tentang + '</p></div><div class="col-md-6"><center></center><img src="' + d.foto + '" class="img img-rounded img-responsive border"></img><center><hr></center><video class="img-responsive" src="' + d.video + '" autoplay="false" controls="true"></video></div></div><div class="row" style="padding-top:10px"><center><p><button type="button" class="btn btn-success closeBtn" data-dismiss="modal"><li class="fa fa-search"></li> Scan Ulang</button></p></center></div>');
                            dialog.find(".closeBtn").on("click", function () {
                                $("#bodi").attr("status-input","0");
                                console.log("Status Input := "+$("#bodi").attr("status-input"));
                            });
                        }, 3000);
                    });
                } else {
                    bootbox.alert("<div class='alert alert-danger'><center>Kode QR Tidak Valid</center></div>");
                }
            });
        } else {
            console.error("In Use");
        }

    });
    Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
            var count = cameras.length;
            if (count > 1)
            {
                scanner.start(cameras[1]);
            } else {
                scanner.start(cameras[0]);
            }
        } else {
            console.error('No cameras found.');
        }
    }).catch(function (e) {
        console.error(e);
    });
}
;
function setModal(modalVar, title, content) {
    modalVar.find(".modal-title").text(title);
    modalVar.find(".modal-body").text(content);
}
