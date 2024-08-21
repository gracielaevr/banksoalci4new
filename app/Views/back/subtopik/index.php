<script type="text/javascript">
var save_method; //for save method string
var table;

var BASE_URL = "<?php echo base_url(); ?>";
tinymce.init({
    selector: "textarea#deskripsi",
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

tinymce.init({
    selector: "textarea#deskripsi2",
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
        ajax: "<?php echo base_url(); ?>subtopik/ajaxdetil/<?php echo $head->idtopik; ?>",
        scrollx: true,
        responsive: true
    });
});

function reload() {
    table.ajax.reload(null, false); //reload datatable ajax
}

function add() {
    save_method = 'add';
    $('#form')[0].reset();
    $('#modal_form').modal('show');
    $('.modal-title').text('Tambah Subtopik');
}

function save() {
    var kode = document.getElementById('kode').value;
    var subtopik = document.getElementById('subtopik').value;
    var codes = document.getElementById('codes').value;
    var narasi = document.getElementById('narasis').checked;
    var ket = tinyMCE.get('deskripsi2').getContent();

    if (subtopik === '') {
        alert("Subtopik tidak boleh kosong");
    } else {
        $('#btnSave').text('Saving...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 

        var url = "";
        if (save_method === 'update') {
            url = "<?php echo base_url(); ?>subtopik/ajax_edit";
        }

        if (narasi === true) {
            var n = 1;
        } else {
            var n = 0;
        }

        var form_data = new FormData();
        form_data.append('kode', kode);
        form_data.append('code', codes);
        form_data.append('subtopik', subtopik);
        form_data.append('deskripsi', ket);
        form_data.append('narasi', n);

        // ajax adding data to database
        $.ajax({
            url: url,
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function(data) {
                alert(data.status);
                $('#modal_form').modal('hide');
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

function simpan() {
    var idtopik = document.getElementById('idtopik').value;
    var nama = document.getElementById('nama').value;
    var narasi = document.getElementById('narasi');
    var code = document.getElementById('code').value;
    var ket = tinyMCE.get('deskripsi').getContent();

    if (narasi.checked === true) {
        var n = 1;
    } else {
        var n = 0;
    }

    if (nama === '') {
        alert("Nama tidak boleh kosong");
    } else {
        $('#btnSave').text('Saving...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 

        url = "<?php echo base_url(); ?>subtopik/ajax_add";

        var form_data = new FormData();
        form_data.append('nama', nama);
        form_data.append('code', code);
        form_data.append('idtopik', idtopik);
        form_data.append('deskripsi', ket);
        form_data.append('narasi', n);

        // ajax adding data to database
        $.ajax({
            url: url,
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function(data) {
                alert(data.status);
                reload();
                $('[name="nama"]').val('');
                $('[name="code"]').val('');
                tinyMCE.get('deskripsi').setContent('');
                document.getElementById("narasi").checked = false;

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

function hapus(id, nama) {
    if (confirm("Apakah anda yakin menghapus subtopik " + nama + " ini ?")) {
        $.ajax({
            url: "<?php echo base_url(); ?>subtopik/hapus/" + id,
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

function ganti(id) {
    save_method = 'update';
    $('#form')[0].reset();
    $('#modal_form').modal('show');
    $('.modal-title').text('Ganti Subtopik');
    $.ajax({
        url: "<?php echo base_url(); ?>subtopik/ganti/" + id,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
            $('[name="kode"]').val(data.idsubtopik);
            $('[name="codes"]').val(data.code);
            $('[name="idtopik"]').val(data.idtopik);
            if (data.narasi === '1') {
                document.getElementById("narasis").checked = true;
            }
            $('[name="subtopik"]').val(data.nama);
            tinyMCE.get('deskripsi2').setContent(data.deskripsi);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error get data');
        }
    });
}

function closemodal() {
    $('#modal_form').modal('hide');
}

function kembali() {
    window.location.href = "<?php echo base_url(); ?>topik/";
}
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Detil Subtopik <small>Maintenance data subtopik</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>subtopik"> Topik</a></li>
            <li class="active">Detil Subtopik</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div class="form-horizontal">
                            <input type="hidden" name="idtopik" id="idtopik" value="<?php echo $head->idtopik; ?>">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Topik</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"
                                        value="<?php echo $head->code . ' - ' . $head->nama; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Subtopik</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        placeholder="Masukkan judul Subtopik">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Kode Subtopik</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="code" name="code"
                                        placeholder="Masukkan Kode Subtopik">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-10">
                                    <label>
                                        <input type="checkbox" id="narasi" name="narasi"> Soal narasi
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Deskripsi</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="deskripsi" id="deskripsi"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-10">
                                    <button id="btnSimpan" type="button" class="btn btn-sm btn-success"
                                        onclick="simpan();">Simpan</button>
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
                        <button type="button" class="btn btn-secondary btn-sm" onclick="reload();">Reload</button>
                    </div>
                    <div class="box-body">
                        <table id="tb" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="10%">Kode</th>
                                    <th width="20%">Judul Subtopik</th>
                                    <th>Deskripsi</th>
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
                    <input type="hidden" name="kode" id="kode">
                    <input type="hidden" name="idtopik" id="idtopik" value="<?php echo $head->idtopik; ?>">
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="subtopik" name="subtopik" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="codes" name="codes" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label><input type="checkbox" id="narasis" name="narasis"> Soal narasi</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <textarea class="form-control" name="deskripsi2" id="deskripsi2"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnSave" type="button" class="btn btn-sm btn-primary" onclick="save();">Simpan</button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="closemodal();">Tutup</button>
            </div>
        </div>
    </div>
</div>