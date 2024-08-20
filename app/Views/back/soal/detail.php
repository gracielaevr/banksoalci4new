<script type="text/javascript">
var save_method; //for save method string
var table;

var BASE_URL = "<?php echo base_url(); ?>";
tinymce.init({
    selector: "textarea#soal",
    theme: "modern",
    height: 250,
    plugins: [
        "advlist autolink link image lists charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
        "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
    ],
    toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
    toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
    external_filemanager_path: BASE_URL + "/filemanager/",
    filemanager_title: "File Gallery",
    relative_urls: false,
    remove_script_host: false,
    convert_urls: true,
    external_plugins: {
        "filemanager": BASE_URL + "/filemanager/plugin.min.js"
    }
});

$(document).ready(function() {
    table = $('#tb').DataTable({
        ajax: "<?php echo base_url(); ?>/soal/ajaxdetil/<?php echo $head->idsubtopik; ?>",
        scrollx: true,
        responsive: true
    });

    $('.select2').select2();
});

function reload() {
    table.ajax.reload(null, false); //reload datatable ajax
}

function pindah() {
    var jml = $('input[name=kodesoal]:checked').length;
    if (jml < 1) {
        alert("Anda belum memilih soal yang ingin dipindah!");
    } else {
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah Subtopik');
    }

}

function pindah_instansi(id, nama) {
    if (confirm("Apakah anda yakin ingin memindahkan soal ini ke Leap ?")) {
        $.ajax({
            url: "<?php echo base_url(); ?>/soal/pindah_instansi/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                alert(data.status);
                reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error pindah data');
            }
        });
    }

}

function simpan() {
    var idsub = document.getElementById('idsub').value;
    var kode = document.getElementById('kode').value;
    var jenis = document.getElementById('jenis').value;
    var soal = tinyMCE.get('soal').getContent();
    var poin = document.getElementById('poin').value;
    var link = document.getElementById('link').value;

    var kode_pilihan = $("input[name='kode_pilihan[]']").map(function() {
        return $(this).val();
    }).get();
    var pilihan = $("input[name='pilihan[]']").map(function() {
        return $(this).val();
    }).get();

    var kode_jawaban = $("input[name='kode_jawaban[]']").map(function() {
        return $(this).val();
    }).get();
    var jawaban = $("input[name='jawaban[]']").map(function() {
        return $(this).val();
    }).get();
    var gambar = $('#file').prop('files')[0];

    if (jenis === '') {
        alert("Tipe Soal tidak boleh kosong");
    } else if (soal === '') {
        alert("Soal tidak boleh kosong");
    } else if (poin === '') {
        alert("Poin tidak boleh kosong");
    }
    // else if (gambar.size > 1000000) {
    //     alert("Maaf. File Terlalu Besar ! Maksimal Upload 1 MB");
    // }
    else {
        $('#btnSave').text('Saving...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 

        var url = "";
        if (kode === '') {
            url = "<?php echo base_url(); ?>/soal/ajax_add";
        } else {
            url = "<?php echo base_url(); ?>/soal/ajax_edit";
        }

        var form_data = new FormData();
        form_data.append('idsubtopik', idsub);
        form_data.append('jenis', jenis);
        form_data.append('soal', soal);
        form_data.append('poin', poin);
        form_data.append('kode_pilihan', kode_pilihan);
        form_data.append('pilihan', pilihan);
        form_data.append('kode_jawaban', kode_jawaban);
        form_data.append('jawaban', jawaban);
        form_data.append('file', gambar);
        form_data.append('link', link);
        form_data.append('kode', kode);

        // ajax adding data to database
        $.ajax({
            url: url,
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            traditional: true,
            type: 'POST',
            success: function(data) {
                alert(data.status);
                let wadah = document.getElementById("jawaban2");
                wadah.innerHTML = "";
                let wadah2 = document.getElementById("wadah");
                wadah2.innerHTML = "";
                $('[name="kode"]').val("");
                $('[name="jenis"]').val("");
                $('[name="poin"]').val("10");
                $('[name="link"]').val("");
                tinyMCE.get('soal').setContent("");
                reload();

                $('#btnSave').text('Save'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("Error json " + errorThrown);

                $('#btnSave').text('Save'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 
            }
        });
    }
}

function savepindah() {
    var idsub = document.getElementById('subtopik').value;

    if (idsub === '') {
        alert("Subtopik tidak boleh kosong");
    } else {
        $('#btnSave2').text('Saving...'); //change button text
        $('#btnSave2').attr('disabled', true); //set button disable 

        var kodesoal = [];
        $("input:checkbox[name=kodesoal]:checked").each(function() {
            kodesoal.push($(this).val());
        });

        var url = "";
        url = "<?php echo base_url(); ?>/soal/pindah";

        var form_data = new FormData();
        form_data.append('idsubtopik', idsub);
        form_data.append('hasil', kodesoal);

        // ajax adding data to database
        $.ajax({
            url: url,
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            traditional: true,
            type: 'POST',
            success: function(data) {
                alert(data.status);
                reload();

                $('#btnSave2').text('Save'); //change button text
                $('#btnSave2').attr('disabled', false); //set button enable 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("Error json " + errorThrown);

                $('#btnSave2').text('Save'); //change button text
                $('#btnSave2').attr('disabled', false); //set button enable 
            }
        });
    }
}

function hapus(id, nama) {
    if (confirm("Apakah anda yakin menghapus soal ini ?")) {
        $.ajax({
            url: "<?php echo base_url(); ?>/soal/hapus/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                alert(data.status);
                reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error hapus data');
            }
        });
    }
}

function deleteall() {
    var jml = $('input[name=kodesoal]:checked').length;
    if (jml < 1) {
        alert("Anda belum memilih soal yang ingin dihapus!");
    } else {
        if (confirm("Apakah anda yakin menghapus soal terpilih ini ?")) {
            var kodesoal = [];
            $("input:checkbox[name=kodesoal]:checked").each(function() {
                kodesoal.push($(this).val());
            });
            var url = "";
            url = "<?php echo base_url(); ?>/soal/hapussemua";

            var form_data = new FormData();
            form_data.append('hasil', kodesoal);

            // ajax adding data to database
            $.ajax({
                url: url,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                traditional: true,
                type: 'POST',
                success: function(data) {
                    alert(data.status);
                    reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("Error json " + errorThrown);
                }
            });
        }
    }
}

function selectall() {
    var ele = document.getElementsByName('kodesoal');
    for (var i = 0; i < ele.length; i++) {
        if (ele[i].type == 'checkbox')
            ele[i].checked = true;
    }
}

function deselectall() {
    var ele = document.getElementsByName('kodesoal');
    for (var i = 0; i < ele.length; i++) {
        if (ele[i].type == 'checkbox')
            ele[i].checked = false;
    }
}

function kembali() {
    window.location.href = "<?php echo base_url(); ?>/soal/";
}

function ganti(id) {
    save_method = 'update';
    $.ajax({
        url: "<?php echo base_url(); ?>/soal/ganti/" + id,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
            var idsoal = data.idsoal;
            $('[name="kode"]').val(data.idsoal);
            $('[name="jenis"]').val(data.jenis);
            $('[name="poin"]').val(data.poin);
            $('[name="link"]').val(data.link);
            tinyMCE.get('soal').setContent(data.soal);

            // akses soalyang banyak
            $.ajax({
                url: "<?php echo base_url(); ?>/soal/aksespilihan/" + idsoal,
                type: "POST",
                dataType: "JSON",
                success: function(data1) {
                    let wadah = document.getElementById("wadah");
                    wadah.innerHTML = "";
                    let coba = createKomponen(data1.status);
                    wadah.appendChild(coba);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data');
                }
            });

            // akses soalyang banyak
            $.ajax({
                url: "<?php echo base_url(); ?>/soal/aksesjawaban/" + idsoal,
                type: "POST",
                dataType: "JSON",
                success: function(data1) {
                    let wadah = document.getElementById("jawaban2");
                    wadah.innerHTML = "";

                    let coba = createKomponen(data1.status);
                    wadah.appendChild(coba);

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data');
                }
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error get data');
        }
    });
}

function closemodal() {
    $('#modal_form').modal('hide');
}

function batal() {
    location.reload();
}

function createKomponen(isi) {
    let div = document.createElement("div");
    div.innerHTML = isi;
    return div;
}

var counter = 1;

function tambah_div() {
    let contoh = '<label class="col-sm-2 control-label"></label>';
    contoh += '<div class="col-sm-10" style="margin-top: 5px;">';
    contoh += '<input type="hidden" class="form-control" id="pilihan_kode_' + counter + '" name="kode_pilihan[]">';
    contoh += '<input type="text" class="form-control" id="pilihan_' + counter +
        '" name="pilihan[]" placeholder="Masukkan Pilihan">';
    contoh += '</div>';

    let wadah = document.getElementById("wadah");
    let coba = createKomponen(contoh);

    wadah.appendChild(coba);
    counter++;
}

var counter2 = 1;

function tambah_div2() {
    let contoh = '<label class="col-sm-2 control-label"></label>';
    contoh += '<div class="col-sm-10" style="margin-top: 5px;">';
    contoh += '<input type="hidden" class="form-control" id="jawaban_kode_' + counter + '" name="kode_jawaban[]">';
    contoh += '<input type="text" class="form-control" id="jawaban_' + counter2 +
        '" name="jawaban[]" placeholder="Masukkan Jawaban">';
    contoh += '</div>';

    let wadah = document.getElementById("jawaban2");

    let coba = createKomponen(contoh);

    wadah.appendChild(coba);
    counter2++;
}

function showimg(kode) {
    $('#modal_show_img').modal('show');
    document.getElementById('kode').value = kode;
    $.ajax({
        url: "<?php echo base_url(); ?>/soal/load_gambar/" + kode,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#imgdetil').attr("src", data.foto);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error load foto');
        }
    });
}
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Detail Soal <small>Maintenance data soal</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>/soal"> Soal</a></li>
            <li class="active">Detil Soal</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div class="form-horizontal">
                            <input type="hidden" name="kode" id="kode">
                            <input type="hidden" name="idsub" id="idsub" value="<?php echo $head->idsubtopik; ?>">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Topik</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="<?php echo $head->namatopik; ?>"
                                        readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Subtopik</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="<?php echo $head->namasub; ?>"
                                        readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Soal</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="soal" name="soal"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Gambar (Opsional)</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" id="file" name="file" accept="image/*">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Link Audio / Video (Opsional)</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="link" name="link"
                                        placeholder="Masukkan Link Audio / Video">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Poin</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="poin" name="poin" placeholder="0">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Tipe Soal</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="jenis" name="jenis"
                                        data-placeholder="Pilih jenis soal">
                                        <option value="d">Dropdown (d)</option>
                                        <option value="mc">Multiple Choice (mc)</option>
                                        <option value="s">Short Answer (s)</option>
                                        <option value="p">Paragraph (p)</option>
                                        <option value="tf">True / False (tf)</option>
                                        <option value="mg">Multiple Grid (mg)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Pilihan</label>
                                <div class="col-sm-2">
                                    <button name="tambah1" class="btn btn-sm btn-secondary" id="tambah1" type="button"
                                        class="btn btn-xs btn-secondary" onclick="tambah_div();">+ Tambah</button>
                                </div>
                            </div>
                            <div class="form-group" id="wadah">
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Jawaban</label>
                                <div class="col-sm-2">
                                    <button name="tambah2" class="btn btn-sm btn-secondary" id="tambah2" type="button"
                                        class="btn btn-xs btn-secondary" onclick="tambah_div2();">+ Tambah</button>
                                </div>
                            </div>
                            <div class="form-group" id="jawaban2">
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-9">
                                    <button id="btnSimpan" type="button" class="btn btn-sm btn-success"
                                        onclick="simpan();">Simpan</button>
                                    <button id="btnCancel" type="button" class="btn btn-sm btn-danger"
                                        onclick="batal();">Batal</button>
                                </div>
                                <div class="col-sm-1">
                                    <button id="btnBack" type="button" class="btn btn-sm btn-primary"
                                        onclick="kembali();">Kembali</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <button type="button" class="btn btn-primary btn-sm" onclick="selectall();">Pilih Semua</button>
                        <button type="button" class="btn btn-warning btn-sm" onclick="deselectall();">Batalkan
                            pilihan</button>
                        <button type="button" class="btn btn-info btn-sm" onclick="pindah();"
                            style="float: right; margin-left:3px;"><i class="fa fa-fw fa-sign-out"></i>Pindah
                            Subtopik</button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteall();"
                            style="float: right;"><i class="fa fa-fw fa-trash"></i>Hapus</button>
                    </div>
                    <div class="box-body">
                        <table id="tb" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="10%">Gambar</th>
                                    <th width="20%">Soal</th>
                                    <th width="30%">Pilihan</th>
                                    <th width="25%">Jawaban</th>
                                    <th style="text-align: center;" width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modal_form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Default Modal</h4>
            </div>
            <div class="modal-body">
                <form id="form" class="form-horizontal">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Subtopik</label>
                            <select class="form-control select2" id="subtopik" name="subtopik"
                                data-placeholder="Pilih Subtopik" style="width: 100%;">
                                <option value="" selected>Pilih Subtopik</option>
                                <?php foreach ($subtopik->getResult() as $row) { ?>
                                <option value="<?php echo $row->idsubtopik; ?>">
                                    <?php echo $row->sub . ' == (Topik : ' . $row->top . ')'; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnSave2" type="button" class="btn btn-sm btn-primary"
                    onclick="savepindah();">Simpan</button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="closemodal();">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_show_img">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Gambar</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="kode" name="kode" readonly>
                <img id="imgdetil" src="" class="img-thumbnail">
            </div>
        </div>
    </div>
</div>