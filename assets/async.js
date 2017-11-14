/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
    $.get(base_url + "isLogin", function (e) {
        if (e["status"] == 1)
        {
            initDatatablesTokoh();
        } else {
            console.error("Not Function Loaded You Not Logged In");
        }
    });
    $("#btnLogout").on("click", function () {
        swal({
            title: "",
            text: "Apakah Kamu Ingin Keluar Dari System ? ",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
        }, function (isConfirm) {
            if (isConfirm) {
                $.get(base_url + "logout", function (e) {
                    console.log("XHR Accepted := " + e["status"]);
                    if (e["status"] == 1)
                    {
                        swal({
                            title: 'Logout Berhasil',
                            text: '',
                            type: 'success'
                        }, function () {
                            window.location = redir_base;
                        })
                    } else {
                        swal({
                            title: 'Logout Gagal',
                            text: '',
                            type: 'danger'
                        })
                    }
                });
            }
        })
    });
    $("#btnMasuk").on("click", function () {
        var username = $("#inputUser").val();
        var password = $("#inputPassword").val();
        var dialog = bootbox.dialog({
            title: 'Loading . . ',
            message: '<center><p><i class="fa fa-spin fa-spinner"></li></p></center>'
        });
        dialog.init(function () {
            setTimeout(function () {
                if (username != "" && password != "")
                {
                    var param = {user: username, pass: password};
                    $.post(base_url + "login", param, function (a) {
                        bootbox.hideAll();
                        if (a["status"] == 1)
                        {
                            swal({
                                title: 'Login Berhasil',
                                text: 'Tunggu Anda Akan Di Alihkan',
                                type: 'success'
                            }, function () {
                                window.location = redir_base;
                            })
                        } else {
                            swal({
                                title: 'Login Gagal !',
                                text: 'Silahkan Periksa Username dan Password',
                                type: 'error'
                            })
                        }
                    });
                } else {
                    bootbox.hideAll();
                    swal({
                        title: 'Error!',
                        text: 'Username dan Password Harus di Isi',
                        type: 'error'
                    })
                }
            }, 3000);
        });
    });
    function initDatatablesTokoh()
    {
        var table = $('#tokoh').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": base_url + "getDataTokoh",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [0], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ],
            "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "defaultContent": "<button class='btn btn-success waves-effect' id='detail'><li class='fa fa-search'></li></button> <button class='btn btn-warning waves-effect' id='edit'><li class='fa fa-edit'></li></button> <button class='btn btn-danger waves-effect' id='hapus'><li class='fa fa-trash'></li></button> <button class='btn btn-primary waves-effect' id='cetak'><li class='fa fa-print'></li></button>"
                }],
            dom: 'Bfrtip',
            buttons: [
                {
                    text: 'Tambah',
                    action: function (e, dt, node, config) {
                        var dialog = bootbox.dialog({
                            title: 'Loading . . ',
                            message: '<center><p><i class="fa fa-spin fa-spinner"></li></p></center>'
                        });
                        dialog.init(function () {
                            setTimeout(function () {
                                dialog.find(".modal-title").html("Tambahkan Data Tokoh");
                                dialog.find(".bootbox-body").html('<div class="row"><div class="col-md-12 col-sm-12 col-xs-12"><label>Nama :</label><input  class="form-control nama" placeholder="Nama Tokoh" required></div><div class="col-md-12 col-sm-12 col-xs-12"><label>Tempat Lahir :</label><input  class="form-control tempat_lahir" placeholder="Tempat Lahir" required></div><div class="col-md-12 col-sm-12 col-xs-12"><label>Nama :</label><input  class="form-control tanggal_lahir" placeholder="Tanggal Lahir" required></div><div class="col-md-12 col-sm-12 col-xs-12"><label>Tanggal Wafat :</label><input  class="form-control tanggal_wafat" placeholder="Optional"></div><div class="col-md-12 col-sm-12 col-xs-12"><label>Foto :</label><input  class="form-control foto" name="foto" type="file" required></div><div class="col-md-12 col-sm-12 col-xs-12"><label>Video :</label><input  class="form-control video" name="video" type="file"  required></div><div class="col-md-12 col-sm-12 col-xs-12"><label>Tentang Tokoh :</label><textarea class="form-control txtArea" row="4"></textarea> </div></div><div class="row" style="padding-top:10px"><div class="col-md-6 col-sm-6 col-xs-6"><button class="btn btn-success waves-effect saveit pull-right">Simpan Data</button></div><div class="col-md-6 col-sm-6 col-xs-6"><button class="btn btn-primary waves-effect pull-left" data-dismiss="modal">Tutup</button></div></div>');
                                dialog.find(".tanggal_lahir").datepicker({
                                    format: 'yyyy/mm/dd'
                                });
                                dialog.find(".tanggal_wafat").datepicker({
                                    format: 'yyyy/mm/dd'
                                });
                            }, 3000);
                        });
                    }
                }
            ]
        });
        $('#tokoh tbody').on('click', '#detail', function () {
            var data = table.row($(this).parents('tr')).data();
            $.get(base_url + "getdata/" + data[0], function (res) {
                if (res["status"] == 1)
                {
                    var d = res["data"];
                    var dialog = bootbox.dialog({
                        title: 'Loading . . ',
                        message: '<center><p><i class="fa fa-spin fa-spinner"></li></p></center>'
                    });
                    dialog.init(function () {
                        setTimeout(function () {
                            dialog.find(".modal-title").html('Biografi Karakter');
                            dialog.find(".bootbox-body").html('<div class="row"><div class="col-md-6"><p style="color:#000;"><b>Nama Tokoh</b></p><p>' + d.nama_tokoh + '</p><p style="color:#000;"><b>Tempat Lahir</b></p><p>' + d.tempat_lahir + '</p><p style="color:#000;"><b>Tanggal Lahir</b></p><p>' + d.tanggal_lahir + '</p><p style="color:#000;"><b>Tanggal Wafat</b></p><p>' + d.tanggal_wafat + '</p><p style="color:#000;"><b>Tentang </b></p><p>' + d.tentang + '</p></div><div class="col-md-6"><center></center><img src="' + d.foto + '" class="img img-rounded img-responsive border"></img><center><hr></center><video class="img-responsive" src="' + d.video + '" autoplay="false" controls="true"></video></div></div><div class="row" style="padding-top:10px"><center><p><button type="button" class="btn btn-danger closeBtn waves-effect" data-dismiss="modal"><li class="fa fa-close"></li> Close</button></p></center></div>');
                        }, 3000);
                    });
                } else {
                    bootbox.alert("<div class='alert alert-danger'><center>ID Not Valid</center></div>");
                }
            });
        });
        $('#tokoh tbody').on('click', '#edit', function () {
            var data = table.row($(this).parents('tr')).data();

        });
        $('#tokoh tbody').on('click', '#print', function () {
            var data = table.row($(this).parents('tr')).data();

        });
        $('#tokoh tbody').on('click', '#hapus', function () {
            var data = table.row($(this).parents('tr')).data();
            var $button = $(this);
            swal({
            title: "",
            text: "Apakah Kamu Ingin Menghapus ID "+data[0]+" ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
        }, function (isConfirm) {
            if (isConfirm) {
                $.post(base_url + "hapustokoh",{id:data[0]}, function (e) {
                    console.log("XHR Accepted := " + e["status"]);
                    if (e["status"] == 1)
                    {
                        swal({
                            title: 'Data Berhasil Di Hapus',
                            text: '',
                            type: 'success'
                        }, function () {
                            table.row( $button.parents('tr') ).remove().draw();
                        })
                    } else {
                        swal({
                            title: 'Data Gagal Di Hapus',
                            text: '',
                            type: 'danger'
                        })
                    }
                });
            }
        })
        });

    }
});

