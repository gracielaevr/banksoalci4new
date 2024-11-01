<script type="text/javascript">
var save_method; //for save method string
var table;

$(document).ready(function() {
    table = $('#tb').DataTable({
        ajax: "<?php echo base_url(); ?>siswa/ajaxdetil/<?php echo $head->idpeserta; ?>",
        scrollx: true,
        responsive: true
    });
});

function reload() {
    table.ajax.reload(null, false); //reload datatable ajax
}

function print() {
    window.open('<?php echo base_url() . '/laporan/cetak/' . $head->idpeserta; ?>', '_blank');
}

document.querySelector('.side-siswa').classList.add('active');
</script>



<section class="section">
    <div class="row-btn">
        <ol class="breadcrumb bg-white d-flex align-items-end">
            <h5 class="me-1 mb-0">Data Siswa</h5><small>Maintenance data siswa</small>
        </ol>
    </div>
    <div class="card shadow-leap p-3">
        <div class="row">
            <div class="col-lg-12 col-xs-12">

                <div class="card-body">
                    <div class="form-horizontal">
                        <div class="row justify-content-center">
                            <div class="col-11">
                                <label class="col-sm-2 control-label">Nama</label>
                                <div class="col-sm-12 mb-3">
                                    <input type="text" class="form-control" placeholder="Nana"
                                        value="<?php echo $head->nama; ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-11">
                                <label class="col-sm-2 control-label">Tanggal Test</label>
                                <div class="col-sm-12 mb-3">
                                    <input type="text" class="form-control"
                                        value="<?php echo date('d M Y', strtotime($head->created_at)); ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-11">
                                <label class="col-sm-2 control-label">Topik / Subtopik</label>
                                <div class="col-sm-12 mb-3">
                                    <input type="text" class="form-control"
                                        value="<?php echo $topik . ' / ' . $subtopik; ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group d-flex justify-content-center gap-4">
                            <div class="col-3">
                                <label class="control-label">Nilai</label>
                                <div class="mb-2">
                                    <input type="text" class="form-control" value="<?php echo $head->poin; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-3">
                                <label class=" control-label">Benar</label>
                                <div class="mb-2">
                                    <input type="text" class="form-control" value="<?php echo $head->benar; ?>"
                                        readonly>
                                </div>
                            </div>

                            <div class="col-3">
                                <label class=" control-label">Salah</label>
                                <div class="mb-2">
                                    <input type="text" class="form-control" value="<?php echo $head->salah; ?>"
                                        readonly>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card shadow-leap p-3 mt-3">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="card-header">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="reload();">Reload</button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="print();"><i
                            class="fa fa-fw fa-file-pdf-o"></i>Export PDF</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tb" class="display text-sm">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="55%">Soal</th>
                                    <th>Benar</th>
                                    <th>Jawaban Siswa</th>
                                    <th>Hasil</th>
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