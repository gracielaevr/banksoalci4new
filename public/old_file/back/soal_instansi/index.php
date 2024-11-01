<script type="text/javascript">
var save_method; //for save method string
var table;

$(document).ready(function() {
    table = $('#tb').DataTable({
        ajax: "<?php echo base_url(); ?>soalinstansi/ajaxlist",
        scrollx: true,
        responsive: true
    });
});

function reload() {
    table.ajax.reload(null, false); //reload datatable ajax
}

function subtopik(kode) {
    window.location.href = "<?php echo base_url(); ?>soalinstansi/detil/" + kode;
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
        url: "<?php echo base_url(); ?>soalinstansi/ajax_upload",
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


<section class="section">
    <div class="row-btn">
        <ol class="breadcrumb bg-white d-flex align-items-end">
            <h5 class="me-1 mb-0">Daftar Soa</h5><small>Maintenance data soal</small>
        </ol>
    </div>
    <div class="card shadow-leap p-3">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="card-header">
                    <button type="button" class="btn btn-primary btn-sm" onclick="importExcel();">Import
                        Soal</button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="reload();">Reload</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tb" class="display text-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th width="40%">Topik</th>
                                    <th style="text-align: center;" width="60%">Detail</th>
                                </tr>
                            </thead>

                            <tbody style="border-bottom: none;">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close text-danger" style="font-size: x-large;" data-bs-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form" class="form-horizontal">
                    <div class="form-group row">
                        <label for="subtopik" class="col-sm-3 control-label">Tipe Soal</label>
                        <div class="col-sm-12">
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
                        <div class="col-sm-12">
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