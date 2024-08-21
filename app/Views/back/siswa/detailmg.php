<script type="text/javascript">
var save_method; //for save method string
var table;

$(document).ready(function() {
    table = $('#tb').DataTable({
        ajax: "<?php echo base_url(); ?>siswaguru/ajaxdetil2/<?php echo $head->idpeserta; ?>",
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
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Detil Siswa <small>Maintenance data siswa</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>siswaguru"> Siswa</a></li>
            <li class="active">Detil siswa</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Nama</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Nama"
                                        value="<?php echo $head->nama; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Tanggal Test</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"
                                        value="<?php echo date('d M Y', strtotime($head->created_at)); ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Topik / Subtopik</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"
                                        value="<?php echo $topik . ' / ' . $subtopik; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Nilai</label>
                                <div class="col-sm-1">
                                    <input type="text" class="form-control" value="<?php echo $head->poin; ?>" readonly>
                                </div>
                                <label class="col-sm-1 control-label">Benar</label>
                                <div class="col-sm-1">
                                    <input type="text" class="form-control" value="<?php echo $head->benar; ?>"
                                        readonly>
                                </div>
                                <label class="col-sm-1 control-label">Salah</label>
                                <div class="col-sm-1">
                                    <input type="text" class="form-control" value="<?php echo $head->salah; ?>"
                                        readonly>
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
                        <button type="button" class="btn btn-danger btn-sm" onclick="print();"><i
                                class="fa fa-fw fa-file-pdf-o"></i>Export PDF</button>
                    </div>
                    <div class="box-body">
                        <table id="tb" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="55%">Soal</th>
                                    <th>Benar</th>
                                    <th>Jawaban Siswa</th>
                                    <th>Hasil</th>
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