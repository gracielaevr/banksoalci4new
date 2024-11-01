<script type="text/javascript">
var save_method; //for save method string
var table;

$(document).ready(function() {
    table = $('#tb').DataTable({
        ajax: "<?php echo base_url(); ?>rekap/ajaxlist",
        scrollx: true,
        responsive: true
    });
});

function soal(id) {
    window.location.href = "<?php echo base_url(); ?>rekap/detil/" + id;
}
</script>




<section class="section">
    <div class="row-btn">
        <ol class="breadcrumb bg-white d-flex align-items-end">
            <h5 class="me-1 mb-0">Data Rekap Soal</h5><small>Maintenance data rekap soal</small>
        </ol>
    </div>
    <div class="card shadow-leap p-3 mt-3">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="card-header">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="reload_page();">Reload</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tb" class="display text-sm">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Topik</th>
                                    <th>Total Diujikan</th>
                                    <th>% Jawaban Benar</th>
                                    <th>% Jawaban Salah</th>
                                    <th style="text-align: center;">Detail</th>
                                </tr>
                            </thead>
                            <tbody class="t-left" style="border-bottom: none;">

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
                    <input type="hidden" name="kode" id="kode">
                    <input type="hidden" name="idsubtopik" id="idsubtopik" value="<?php //echo $head->idsubtopik; 
                                                                                    ?>">
                    <div class="form-group row">
                        <label for="subtopik" class="col-sm-3 control-label">Judul Subtopik</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="subtopik" name="subtopik" autocomplete="off">
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