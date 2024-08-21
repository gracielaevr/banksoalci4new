<script type="text/javascript">
var save_method; //for save method string
var table;

$(document).ready(function() {
    table = $('#tb').DataTable({
        ajax: "<?php echo base_url(); ?>/instansi/ajaxlist",
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
    $('.modal-title').text('Tambah Instansi');
}

// function subtopik(kode) {
//     window.location.href = "<?php echo base_url(); ?>/subtopik/detil/" + kode;
// }

function save() {
    var idinstansi = document.getElementById('idinstansi').value;
    var nama_instansi = document.getElementById('nama_instansi').value;
    var jml_krywan = document.getElementById('jml_krywan').value;
    var alamat = document.getElementById('alamat').value;
    var kontak = document.getElementById('kontak').value;

    if (nama_instansi === '') {
        alert("Nama Instansi tidak boleh kosong");
    } else if (jml_krywan === '') {
        alert("Jumlah Karyawan tidak boleh kosong");
    } else if (alamat === '') {
        alert("Alamat tidak boleh kosong");
    } else if (kontak === '') {
        alert("Contact Person tidak boleh kosong");
    } else {
        $('#btnSave').text('Menyimpan...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 

        var url = "";
        if (save_method === 'add') {
            url = "<?php echo base_url(); ?>/instansi/ajax_add";
        } else {
            url = "<?php echo base_url(); ?>/instansi/ajax_edit";
        }

        var form_data = new FormData();
        form_data.append('idinstansi', idinstansi);
        form_data.append('nama_instansi', nama_instansi);
        form_data.append('jml_krywan', jml_krywan);
        form_data.append('alamat', alamat);
        form_data.append('kontak', kontak);

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
    if (confirm("Apakah anda yakin menghapus Instansi " + nama +
            " ini ? \n*Semua data terkait akan terhapus *")) {
        $.ajax({
            url: "<?php echo base_url(); ?>/instansi/hapus/" + id,
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
    $('.modal-title').text('Ganti Instansi');
    $.ajax({
        url: "<?php echo base_url(); ?>/instansi/ganti/" + id,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
            $('[name="idinstansi"]').val(data.idinstansi);
            $('[name="nama_instansi"]').val(data.nama_instansi);
            $('[name="jml_krywan"]').val(data.jml_krywan);
            $('[name="alamat"]').val(data.alamat);
            $('[name="kontak"]').val(data.kontak);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error get data');
        }
    });
}

function closemodal() {
    $('#modal_form').modal('hide');
}


function hanyaAngka(e, decimal) {
    var key;
    var keychar;
    if (window.event) {
        key = window.event.keyCode;
    } else if (e) {
        key = e.which;
    } else {
        return true;
    }
    keychar = String.fromCharCode(key);
    if ((key == null) || (key == 0) || (key == 8) || (key == 9) || (key == 13) || (key == 27)) {
        return true;
    } else if ((("0123456789").indexOf(keychar) > -1)) {
        return true;
    } else if (decimal && (keychar == ".")) {
        return true;
    } else {
        return false;
    }
}
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Daftar Instansi</h1>
        <ol class="breadcrumb">
            <li class="active">Instansi</li>
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
                                    <th width="25%">Nama Instansi</th>
                                    <th width="15%">Jumlah Karyawan</th>
                                    <th width="30%">Alamat</th>
                                    <th width="15%">Contact Person</th>
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
                    <input type="hidden" name="idinstansi" id="idinstansi">
                    <div class="form-group row">
                        <label for="nama_instansi" class="col-sm-3 control-label">Nama Instansi</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_instansi" name="nama_instansi"
                                placeholder="Masukkan nama instansi disini" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jml_krywan" class="col-sm-3 control-label">Jumlah Karyawan</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="jml_krywan" name="jml_krywan"
                                placeholder="Masukkan jumlah karyawan disini" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="alamat" class="col-sm-3 control-label">Alamat</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="alamat" name="alamat"
                                placeholder="Masukkan alamat disini" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kontak" class="col-sm-3 control-label">Contact Person</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="kontak" name="kontak"
                                placeholder="Masukkan contact person disini" autocomplete="off"
                                onkeypress="return hanyaAngka(event,false);">
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