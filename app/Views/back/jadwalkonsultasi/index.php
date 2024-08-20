<script type="text/javascript">
var save_method; //for save method string
var table;

$(document).ready(function() {
    table = $('#tb').DataTable({
        ajax: "<?php echo base_url(); ?>/jadwalkonsultasi/ajaxlist",
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
    $('.modal-title').text('Tambah Jadwal');
}


function save() {
    var idkonsultasi = document.getElementById('idkonsultasi').value;
    var tanggal = document.getElementById('tanggal').value;
    var waktu = document.getElementById('waktu').value;
    var linkzoom = document.getElementById('linkzoom').value;
    var durasi = document.getElementById('durasi').value;
    var catatan = document.getElementById('catatan').value;
    var idrole = document.getElementById('idrole').value;

    if (tanggal === '') {
        alert("Tanggal tidak boleh kosong");
    } else if (waktu === '') {
        alert("Waktu tidak boleh kosong");
    } else if (linkzoom === '') {
        alert("Link Zoom tidak boleh kosong");
    } else if (durasi === '') {
        alert("Durasi tidak boleh kosong");
    } else if (catatan === '') {
        alert("Catatan tidak boleh kosong");
    } else {
        $('#btnSave').text('Menyimpan...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 

        var url = "";
        if (save_method === 'add') {
            url = "<?php echo base_url(); ?>/jadwalkonsultasi/ajax_add";
        } else {
            url = "<?php echo base_url(); ?>/jadwalkonsultasi/ajax_edit";
        }

        var form_data = new FormData();
        form_data.append('idkonsultasi', idkonsultasi);
        form_data.append('tanggal', tanggal);
        form_data.append('waktu', waktu);
        form_data.append('linkzoom', linkzoom);
        form_data.append('durasi', durasi);
        form_data.append('catatan', catatan);
        form_data.append('idrole', idrole);

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
    if (confirm("Apakah anda yakin menghapus Jadwal Konsultasi " + nama +
            " ini ? \n*Semua data terkait akan terhapus *")) {
        $.ajax({
            url: "<?php echo base_url(); ?>/jadwalkonsultasi/hapus/" + id,
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
    $('.modal-title').text('Ganti Jadwal');
    $.ajax({
        url: "<?php echo base_url(); ?>/jadwalkonsultasi/ganti/" + id,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
            $('[name="idkonsultasi"]').val(data.idkonsultasi);
            $('[name="tanggal"]').val(data.tanggal);
            $('[name="waktu"]').val(data.waktu);
            $('[name="linkzoom"]').val(data.linkzoom);
            $('[name="durasi"]').val(data.durasi);
            $('[name="catatan"]').val(data.catatan);
            $('[name="idrole"]').val(data.idrole);
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
        <h1>Jadwal Konsultasi</h1>
        <ol class="breadcrumb">
            <li class="active">Konsultasi</li>
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
                                    <th width="5%">#</th>
                                    <th width="5%">Tanggal</th>
                                    <th width="5%">Waktu</th>
                                    <th width="15%">Link Zoom</th>
                                    <th width="5%">Durasi</th>
                                    <th width="15%">Catatan</th>
                                    <th width="5%">Guru</th>
                                    <th style="text-align: center;" width="15%">Aksi</th>
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
                    <input type="hidden" name="idkonsultasi" id="idkonsultasi">
                    <div class="form-group row">
                        <label for="tanggal" class="col-sm-3 control-label">Tanggal</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="tanggal" name="tanggal"
                                placeholder="Masukkan tanggal disini" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="waktu" class="col-sm-3 control-label">Waktu</label>
                        <div class="col-sm-9">
                            <input type="time" class="form-control" id="waktu" name="waktu" placeholder="Masukan 123"
                                autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="linkzoom" class="col-sm-3 control-label">Link Zoom</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="linkzoom" name="linkzoom"
                                placeholder="Masukkan Link Zoom disini" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="durasi" class="col-sm-3 control-label">Durasi</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="durasi" name="durasi"
                                placeholder="Masukkan durasi disini" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="catatan" class="col-sm-3 control-label">Catatan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="catatan" name="catatan"
                                placeholder="Masukkan durasi disini" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Guru</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="idrole" id="idrole">
                                <option value="-">- Pilih -</option>
                                <?php
                                foreach ($users->getResult() as $row) {
                                ?>
                                <option value="<?php echo $row->idrole ?>">
                                    <?php

                                        echo $row->nama . '(' . $row->nama . ')'; ?> </option>
                                <?php
                                }; ?>
                            </select>
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