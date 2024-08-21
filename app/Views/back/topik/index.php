<script type="text/javascript">
var save_method; //for save method string
var table;

$(document).ready(function() {
    table = $('#tb').DataTable({
        ajax: "<?php echo base_url(); ?>topik/ajaxlist",
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
    $('.modal-title').text('Tambah topik');
}

function subtopik(kode) {
    window.location.href = "<?php echo base_url(); ?>subtopik/detil/" + kode;
}

function save() {
    var kode = document.getElementById('kode').value;
    var nama = document.getElementById('nama').value;
    var best = document.getElementById('best').value;
    var code = document.getElementById('code').value;

    if (nama === '') {
        alert("Nama topik tidak boleh kosong");
    } else {
        $('#btnSave').text('Menyimpan...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 

        var url = "";
        if (save_method === 'add') {
            url = "<?php echo base_url(); ?>topik/ajax_add";
        } else {
            url = "<?php echo base_url(); ?>topik/ajax_edit";
        }

        var form_data = new FormData();
        form_data.append('kode', kode);
        form_data.append('code', code);
        form_data.append('best', best);
        form_data.append('nama', nama);

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

                $('#btnSave').text('Simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("Error json " + errorThrown);

                $('#btnSave').text('Simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 
            }
        });
    }
}

function hapus(id, nama) {
    if (confirm("Apakah anda yakin menghapus topik " + nama +
            " ini ? \n*Semua data terkait akan terhapus (subtopik / soal)*")) {
        $.ajax({
            url: "<?php echo base_url(); ?>topik/hapus/" + id,
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
    $('.modal-title').text('Ganti topik');
    $.ajax({
        url: "<?php echo base_url(); ?>topik/ganti/" + id,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
            $('[name="kode"]').val(data.idtopik);
            $('[name="code"]').val(data.code);
            $('[name="best"]').val(data.best);
            $('[name="nama"]').val(data.nama);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error get data');
        }
    });
}

function closemodal() {
    $('#modal_form').modal('hide');
}
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Daftar Topik dan Subtopik
            <small>Maintenance data topik & subtopik</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">Topik</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="box box">
                    <div class="box-header with-border">
                        <button type="button" class="btn btn-primary btn-sm" onclick="add();">Tambah</button>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="reload();">Reload</button>
                    </div>
                    <div class="box-body">
                        <table id="tb" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th width="30%">Topik</th>
                                    <th width="30%">Sub topik</th>
                                    <th style="text-align: center;" width="15%">Tambah Sub topik</th>
                                    <th style="text-align: center;" width="30%">Aksi</th>
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
                    <div class="form-group row">
                        <label for="code" class="col-sm-3 control-label">Kode topik</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="code" name="code"
                                placeholder="Masukkan kode topik disini" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama" class="col-sm-3 control-label">Nama topik</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama" name="nama"
                                placeholder="Masukkan topik disini" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="best" class="col-sm-3 control-label">Urutan</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="best" name="best">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnSave" type="button" class="btn btn-sm btn-primary" onclick="save();">Simpan</button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="closemodal();">Batal</button>
            </div>
        </div>
    </div>
</div>