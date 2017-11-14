
    $("#daftarBuku").on("click", ".edBuku", function () {
        var element = $(this);
        $.post("./ajax/ajax_load.php?cmd=rak-list-edit", {
                id_buku: element.attr("data-id"),
                verif: element.attr("data-verif")
            },
            function (data) {
                var select = $('body').find('#rak_list_edit');
                result = jQuery.parseJSON(data);
                var options = "";
                options += "<option value='" + result[0] + "' selected>" + result[0] + "</option>";

                for (var k in result) {
                    if (result[0] == result[k]) {
                        continue;
                    }
                    options += "<option value='" + result[k] + "'>" + result[k] + "</option>";
                }




                select.empty().append(options);
                select.selectpicker('refresh'); // without this MAYBE you'll see error
                select.selectpicker('val', select.data('default'));
                select.selectpicker('refresh');
            });
        verif = element.attr("data-verif");
        $.post("./ajax/ajax_load.php?cmd=buku", {
                ibuku: element.attr("data-id"),
                verif: element.attr("data-verif")
            },
            function (data) {
                dataJson = JSON.parse(data);
                var element = $(this);
                $("#kode_buku_edit").attr("value", dataJson[0].kode_buku);
                $("#judul_buku_edit").attr("value", dataJson[0].judul);
                $("#pengarang_edit").attr("value", dataJson[0].pengarang);
                $("#penerbit_edit").attr("value", dataJson[0].penerbit);
                $("#thn_terbit_edit").attr("value", dataJson[0].thn_terbit);
                $("#isbn_edit").attr("value", dataJson[0].isbn);
                $("#jml_buku_edit").attr("value", dataJson[0].jmlh_buku);
                $("#sumber_buku_edit").attr("value", dataJson[0].asal);
                $("#tgl_input_edit").attr("value", dataJson[0].tgl_input);
                $("#verifikasi").attr("value", verif);
                $("#id_edit").attr("value", dataJson[0].id);
                var id = dataJson[0].kode_buku.split('.');
                    if(id[2] == 1)
                        {
                            $(".kodeEditBuku").html("<button type='button' class='btn btn-danger waves-effect kodeEditBuku'>Edit Kode Buku</button<br>");
                        }
                    
                
            })
    });
    $(".simpan-bank-soal").click(function () {
        var element = $(this);
        $.post("./ajax/ajax_update.php?cmd=buku", {
                judul_buku: $("#judul_buku_edit").val(),
                pengarang: $("#pengarang_edit").val(),
                penerbit: $("#penerbit_edit").val(),
                thn_terbit: $("#thn_terbit_edit").val(),
                isbn: $("#isbn_edit").val(),
                kode_buku: $("#kode_buku_edit").val(),
                jmlh_buku: $("#jml_buku_edit").val(),
                sumber_buku: $("#sumber_buku_edit").val(),
                lokasi: $("#rak_list_edit").val(),
                tgl_input: $("#tgl_input_edit").val(),
                verifikasi: $("#verifikasi").val(),
                id: $("#id_edit").val()
            },
            function (data) {
                jsonData = jQuery.parseJSON(data);
                if (jsonData.status != 0) {
                    $("#n_buku_edit").attr("class", "alert alert-success");
                    $("#n_buku_edit").html("<center><h3>Data Sukses Di Simpan</h3></center>");
                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                    $("#ubah-buku").hide();
                } else {
                    $("#n_buku_edit").attr("class", "alert alert-danger");
                    $("#n_buku_edit").html("<center><h3>Data Gagal Di Simpan</h3></center>");
                   // setTimeout(function () {
                    //    location.reload();
                    //}, 3000);

                }
            })
    });