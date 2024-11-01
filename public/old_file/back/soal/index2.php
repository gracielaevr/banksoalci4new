<script type="text/javascript">
var save_method; //for save method string
var table;

$(document).ready(function() {
    table = $('#tb').DataTable({
        ajax: "<?php echo base_url(); ?>soal/ajaxlist",
        scrollx: true,
        responsive: true
    });
});

function reload() {
    table.ajax.reload(null, false); //reload datatable ajax
}

function subtopik(kode) {
    window.location.href = "<?php echo base_url(); ?>soal/detil/" + kode;
}

function soal(kode) {
    window.location.href = "<?php echo base_url(); ?>narasi/detil/" + kode;
}

function importExcel() {
    $('#form')[0].reset();
    $('#modal_form').modal('show');
    $('.modal-title').text('Tambah soal');
}

function closemodal() {
    $('#modal_form').modal('hide');
}

function save() {

    $('#imgLoading').show();
    $('#lbLoading').show();

    $('#btnSave').hide();
    $('#btnClose').hide();

    var jenis = document.getElementById('jenis').value;
    var file = $('#file').prop('files')[0];

    var form_data = new FormData();
    form_data.append('file', file);
    form_data.append('jenis', jenis);

    $.ajax({
        url: "<?php echo base_url(); ?>soal/ajax_upload",
        dataType: 'JSON',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'POST',
        success: function(response) {
            alert(response.status);

            $('#btnSave').show();
            $('#btnClose').show();
            $('#imgLoading').hide();
            $('#lbLoading').hide();

            $('#btnSave').text('Save');
            $('#btnSave').attr('disabled', false);
            $('#modal_form').modal('hide');

        },
        error: function(response) {
            alert(response.status);

            $('#btnSave').show();
            $('#btnClose').show();
            $('#imgLoading').hide();
            $('#lbLoading').hide();

            $('#btnSave').text('Save');
            $('#btnSave').attr('disabled', false);
        }
    });
}
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Daftar Soal
            <small>Maintenance data soal</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">Soal</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="box box">
                    <div class="box-header with-border">
                        <button type="button" class="btn btn-primary btn-sm" onclick="importExcel();">Import
                            Soal</button>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="reload();">Reload</button>
                    </div>
                    <div class="box-body">
                        <table id="tb" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th width="40%">Topik</th>
                                    <th style="text-align: center;" width="60%">Detail</th>
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
                    <div class="form-group row">
                        <label for="subtopik" class="col-sm-3 control-label">Tipe Soal</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="jenis" name="jenis" data-placeholder="Pilih jenis soal">
                                <option value="d">Dropdown (d)</option>
                                <option value="mc">Multiple Choice (mc)</option>
                                <option value="s">Short Answer (s)</option>
                                <option value="p">Paragraph (p)</option>
                                <option value="tf">True / False (tf)</option>
                                <option value="mg">Multiple Grid (mg)</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="subtopik" class="col-sm-3 control-label">File Excel</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" id="file" name="file" autocomplete="off">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <img id="imgLoading" src="<?php echo base_url(); ?>back/images/loading.gif"
                    style="width:30px; display : none;">
                &nbsp;
                <label id="lbLoading" class="control-label" style="display : none;">Loading...</label>
                <button id="btnSave" type="button" class="btn btn-sm btn-primary" onclick="save();">Simpan</button>
                <button id="btnClose" type="button" class="btn btn-secondary btn-sm"
                    onclick="closemodal();">Tutup</button>
            </div>
        </div>
    </div>
</div>