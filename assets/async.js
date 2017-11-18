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
                    "defaultContent": "<button class='btn btn-success waves-effect' id='detail'><li class='fa fa-search'></li></button> <button class='btn btn-warning waves-effect' id='edit'><li class='fa fa-edit'></li></button> <button class='btn btn-danger waves-effect' id='hapus'><li class='fa fa-trash'></li></button> <button class='btn btn-primary waves-effect' id='print'><li class='fa fa-print'></li></button>"
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
                                dialog.find(".bootbox-body").html('<div class="row"><div class="col-md-12 col-sm-12 col-xs-12"><label>Nama :</label><input  class="form-control nama" placeholder="Nama Tokoh" required></div><div class="col-md-12 col-sm-12 col-xs-12"><label>Tempat Lahir :</label><input  class="form-control tempat_lahir" placeholder="Tempat Lahir" required></div><div class="col-md-12 col-sm-12 col-xs-12"><label>Tanggal Lahir :</label><input  class="form-control tanggal_lahir" placeholder="Tanggal Lahir" required></div><div class="col-md-12 col-sm-12 col-xs-12"><label>Tanggal Wafat :</label><input  class="form-control tanggal_wafat" placeholder="Optional"></div><div class="col-md-12 col-sm-12 col-xs-12"><label>Foto :</label><input  class="form-control foto" id="foto" name="foto" type="file" required></div><div class="col-md-12 col-sm-12 col-xs-12"><label>Video :</label><input  class="form-control video" name="video" type="file" id="video"  required></div><div class="col-md-12 col-sm-12 col-xs-12"><label>Tentang Tokoh :</label><textarea class="form-control txtArea" row="4"></textarea> </div></div><div class="row" style="padding-top:10px"><div class="col-md-6 col-sm-6 col-xs-6"><button class="btn btn-success waves-effect saveit pull-right">Simpan Data</button></div><div class="col-md-6 col-sm-6 col-xs-6"><button class="btn btn-primary waves-effect pull-left" data-dismiss="modal">Tutup</button></div></div>');
                                dialog.find(".tanggal_lahir").datepicker({
                                    format: 'yyyy-mm-dd'
                                });
                                dialog.find(".tanggal_wafat").datepicker({
                                    format: 'yyyy-mm-dd'
                                });
                                dialog.find(".saveit").on("click",function(){
                                    var formData = new FormData();
                                    formData.append('foto', $('#foto')[0].files[0]);
                                    formData.append('video', $('#video')[0].files[0]);
                                    $.ajax({
                                        url: base_url+"upload",
                                        type: 'POST',
                                        data: formData,
                                        mimeType: "multipart/form-data",
                                        contentType: false,
                                        cache: false,
                                        processData: false,
                                        success: function(data, textStatus, jqXHR) {
                                            console.log(textStatus);
                                            if(textStatus == "success")
                                            {
                                                var data = JSON.parse(data);
                                                if(data["status"] == 1)
                                                {
                                                   var nama = $(".nama").val();
                                                   var tempat_lahir = $(".tempat_lahir").val();
                                                   var tanggal_lahir = $(".tanggal_lahir").val();
                                                   var tanggal_wafat = $(".tanggal_wafat").val();
                                                   var txtArea = $(".txtArea").val();
                                                   var foto = data["dataFoto"];
                                                   var video = data["dataVideo"];
                                                   $.post(base_url+"savedata",{nama:nama,tempat_lahir:tempat_lahir,tanggal_lahir:tanggal_lahir,tanggal_wafat:tanggal_wafat,txtArea:txtArea,foto:foto,video:video},function(e){
                                                    if(e["status"] == 1)
                                                    {
                                                        bootbox.hideAll();
                                                        swal({
                                                            title: 'Sukses',
                                                            text: 'Data Sukses Tersimpan',
                                                            type: 'success'
                                                        }, function () {
                                                           $('#tokoh').DataTable().ajax.reload();
                                                        })
                                                        
                                                    }else{
                                                        swal({
                                                            title: 'Error!',
                                                            text: 'Gagal Tambah Data',
                                                            type: 'error'
                                                        })
                                                    }
                                                   });
                                                }else{
                                                   swal({
                                                        title: 'Error!',
                                                        text: 'Gagal Upload File',
                                                        type: 'error'
                                                    })
                                                }
                                            }else if(textStatus == "timeout"){
                                                swal({
                                                        title: 'Error!',
                                                        text: 'Jaringan Timeout !',
                                                        type: 'error'
                                                    })
                                            }else if(textStatus == "error")
                                            {
                                                swal({
                                                        title: 'Error!',
                                                        text: 'Not Found',
                                                        type: 'error'
                                                    })
                                            }
                                            
                                        }
                                    });
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
            var dialog = bootbox.dialog({
                            title: 'Loading . . ',
                            message: '<center><p><i class="fa fa-spin fa-spinner"></li></p></center>'
                        });
                        dialog.init(function () {
                            setTimeout(function () {
                                dialog.find(".modal-title").html("Tambahkan Data Tokoh");
                                dialog.find(".bootbox-body").html('<div class="row"><div class="col-md-12 col-sm-12 col-xs-12"><label>Nama :</label><input  class="form-control nama" placeholder="Nama Tokoh" required></div><div class="col-md-12 col-sm-12 col-xs-12"><label>Tempat Lahir :</label><input  class="form-control tempat_lahir" placeholder="Tempat Lahir" required></div><div class="col-md-12 col-sm-12 col-xs-12"><label>Tanggal Lahir :</label><input  class="form-control tanggal_lahir" placeholder="Tanggal Lahir" required></div><div class="col-md-12 col-sm-12 col-xs-12"><label>Tanggal Wafat :</label><input  class="form-control tanggal_wafat" placeholder="Optional"></div><div class="col-md-12 col-sm-12 col-xs-12"><label>Foto :</label><div style="width:300px;margin: auto;"><img class="fotoDisplay img-responsive" src=""></img></div><input  class="form-control foto" id="foto" name="foto" type="file" required></div><div class="col-md-12 col-sm-12 col-xs-12"><label>Video :</label><div style="width:300px;margin: auto;"><video class="videoDisplay img-responsive" src="" autoplay="false" controls="true"></video></div><input  class="form-control video" name="video" type="file" id="video"  required></div><div class="col-md-12 col-sm-12 col-xs-12"><label>Tentang Tokoh :</label><textarea class="form-control txtArea" row="4"></textarea> </div></div><div class="row" style="padding-top:10px"><div class="col-md-6 col-sm-6 col-xs-6"><button class="btn btn-success waves-effect saveit pull-right">Simpan Data</button></div><div class="col-md-6 col-sm-6 col-xs-6"><button class="btn btn-primary waves-effect pull-left" data-dismiss="modal">Tutup</button></div></div>');
                                $.get(base_url+"findtokoh/"+data[0],function(es){
                                   es = es[0];
                                   console.log(es);
                                   dialog.find(".nama").val(es.nama);
                                   dialog.find(".tempat_lahir").val(es.tempat_lahir);
                                   dialog.find(".tanggal_lahir").val(es.tanggal_lahir);
                                   dialog.find(".tanggal_wafat").val(es.tanggal_wafat);
                                   dialog.find(".fotoDisplay").attr("src",base_assets+"/_upload/foto/"+es.foto);
                                   dialog.find(".videoDisplay").attr("src",base_assets+"/_upload/video/"+es.video);
                                   dialog.find(".txtArea").val(es.tentang);
                                });
                                dialog.find(".tanggal_lahir").datepicker({
                                    format: 'yyyy-mm-dd'
                                });
                                dialog.find(".tanggal_wafat").datepicker({
                                    format: 'yyyy-mm-dd'
                                });
                                dialog.find(".saveit").on("click",function(){
                                    var formData = new FormData();
                                    formData.append('foto', $('#foto')[0].files[0]);
                                    formData.append('video', $('#video')[0].files[0]);
                                    formData.append('id', data[0]);
                                    $.ajax({
                                        url: base_url+"uploadUpdate",
                                        type: 'POST',
                                        data: formData,
                                        mimeType: "multipart/form-data",
                                        contentType: false,
                                        cache: false,
                                        processData: false,
                                        success: function(datas, textStatus, jqXHR) {
                                            console.log(textStatus);
                                            if(textStatus == "success")
                                            {
                                                var datas = JSON.parse(datas);
                                                if(datas["status"] == 1)
                                                {
                                                   var nama = $(".nama").val();
                                                   var tempat_lahir = $(".tempat_lahir").val();
                                                   var tanggal_lahir = $(".tanggal_lahir").val();
                                                   var tanggal_wafat = $(".tanggal_wafat").val();
                                                   var txtArea = $(".txtArea").val();
                                                   var foto = datas["dataFoto"];
                                                   var video = datas["dataVideo"];
                                                   var fotoNow = datas["curFoto"];
                                                   var vidNow = datas["vidNow"];
                                                   $.post(base_url+"updatedata",{curFoto:fotoNow,vidNow:vidNow,id_data:data[0],nama:nama,tempat_lahir:tempat_lahir,tanggal_lahir:tanggal_lahir,tanggal_wafat:tanggal_wafat,txtArea:txtArea,foto:foto,video:video},function(e){
                                                    if(e["status"] == 1)
                                                    {
                                                        bootbox.hideAll();
                                                        swal({
                                                            title: 'Sukses',
                                                            text: 'Data Sukses Di Ubah',
                                                            type: 'success'
                                                        }, function () {
                                                           $('#tokoh').DataTable().ajax.reload();
                                                        })
                                                        
                                                    }else{
                                                        swal({
                                                            title: 'Error!',
                                                            text: 'Gagal Ubah Data',
                                                            type: 'error'
                                                        })
                                                    }
                                                   });
                                                }else{
                                                   swal({
                                                        title: 'Error!',
                                                        text: 'Gagal Upload File',
                                                        type: 'error'
                                                    })
                                                }
                                            }else if(textStatus == "timeout"){
                                                swal({
                                                        title: 'Error!',
                                                        text: 'Jaringan Timeout !',
                                                        type: 'error'
                                                    })
                                            }else if(textStatus == "error")
                                            {
                                                swal({
                                                        title: 'Error!',
                                                        text: 'Not Found',
                                                        type: 'error'
                                                    })
                                            }
                                            
                                        }
                                    });
                                });
                            }, 3000);
                        });
        });
        $('#tokoh tbody').on('click', '#print', function () {
            var data = table.row($(this).parents('tr')).data();
            var dialog = bootbox.dialog({
                            title: 'Proses Menciptakan Kartu . . ',
                            message: '<center><p><i class="fa fa-spin fa-spinner"></li></p></center>'
                        });
                        dialog.init(function () {
                            setTimeout(function () {
                                $.get(base_url+"generatecard/"+data[0],function(ez){
                                    if(ez["status"] == 1)
                                    {
                                        dialog.find(".modal-title").html("Kartu Sukses Di Buat");
                                        dialog.find(".bootbox-body").html("<div class='row'><div class='col-md-12 col-xs-12 col-sm-12'><center><img src='"+ez["data"]+"' class='img-responsive'></img></center></div></div>");
                                    }else{
                                        swal({
                                            title: 'Kartu Gagal di Buat',
                                            text: ez["msg"],
                                            type: 'error'
                                        })
                                    }
                                });
                                
                            },1000);
                        });

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

