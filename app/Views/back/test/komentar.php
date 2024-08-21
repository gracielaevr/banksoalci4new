<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Detail Komentar <small>Maintenance data komentar</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>komentar"> Komentar</a></li>
            <li class="active">Detil Komentar</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div class="form-horizontal">
                            <input type="hidden" name="kode" id="kode">
                            <input type="hidden" name="idbidang" id="idbidang" value="<?php echo $head->idbidang; ?>">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Bidang</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="<?php echo $head->namabidang; ?>"
                                        readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Nilai Min</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="min" name="min" placeholder="0"
                                        min="0">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Nilai Max</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="max" name="max" placeholder="0"
                                        min="0">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Komentar</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="komentar" name="komentar"></textarea>
                                </div>
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
                    <div class="box-body">
                        <table id="tb" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="15%">Nilai Min</th>
                                    <th width="15%">Nilai Max</th>
                                    <th width="45%">Komentar</th>
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

<script type="text/javascript">
var save_method; //for save method string
var table;

$(document).ready(function() {
    table = $('#tb').DataTable({
        ajax: "<?php echo base_url(); ?>komentar/ajaxdetil/<?php echo $head->idbidang; ?>",
        scrollx: true,
        responsive: true
    });
});

function simpan() {
    var kode = document.getElementById('kode').value;
    var idbidang = document.getElementById('idbidang').value;
    var min = document.getElementById('min').value;
    var max = document.getElementById('max').value;
    var komentar = document.getElementById('komentar').value;

    if (min === '') {
        alert("Nilai Minimal wajib diisi!");
    } else if (max === '') {
        alert("Nilai Maximal wajib diisi!");
    } else if (komentar === '') {
        alert("Komentar wajib diisi!");
    } else {
        $('#btnSave').text('Saving...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 

        var url = "";
        if (kode === '') {
            url = "<?php echo base_url(); ?>komentar/ajax_add";
        } else {
            url = "<?php echo base_url(); ?>komentar/ajax_edit";
        }

        var form_data = new FormData();
        form_data.append('kode', kode);
        form_data.append('idbidang', idbidang);
        form_data.append('min', min);
        form_data.append('max', max);
        form_data.append('komentar', komentar);

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
                $('[name="kode"]').val("");
                $('[name="min"]').val("");
                $('[name="max"]').val("");
                $('[name="komentar"]').val("");

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

function reload() {
    table.ajax.reload(null, false); //reload datatable ajax
}

function ganti(id) {
    save_method = 'update';
    $.ajax({
        url: "<?php echo base_url(); ?>komentar/ganti/" + id,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
            $('[name="kode"]').val(data.idkomentar);
            $('[name="min"]').val(data.min);
            $('[name="max"]').val(data.max);
            $('[name="komentar"]').val(data.komentar);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error get data');
        }
    });
}

function hapus(id, nama) {
    if (confirm("Apakah anda yakin menghapus komentar nilai ini ?")) {
        $.ajax({
            url: "<?php echo base_url(); ?>komentar/hapus/" + id,
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
</script>