<script type="text/javascript">
var save_method; //for save method string
var table;

$(document).ready(function() {
    table = $('#tb').DataTable({
        ajax: "<?php echo base_url(); ?>siswa/ajaxlist",
        scrollx: true,
        responsive: true
    });

    $('#tanggalrange').daterangepicker();
});

function nilai(id, jenis) {
    if (jenis === "mg") {
        window.location.href = "<?php echo base_url(); ?>siswa/detilmg/" + id;
    } else {
        window.location.href = "<?php echo base_url(); ?>siswa/detil/" + id;
    }
}

function excellap() {
    var tgl = document.getElementById('tanggalrange').value;
    var tanggal = tgl.replace("-", ":");
    var tg = tanggal.replaceAll("/", "-");
    var t = tg.replaceAll(" ", "")
    window.open("<?php echo base_url(); ?>siswa/exportexcel/" + t, "_blank");
}
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Siswa <small>Maintenance data siswa</small></h1>
        <ol class="breadcrumb">
            <li class="active">siswa</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <div class="input-group margin">
                            <input type="text" class="form-control pull-right" id="tanggalrange">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-success btn-flat" onclick="excellap();"><i
                                        class="fa fa-fw fa-file-excel-o"></i>Export Excel</button>
                            </span>
                        </div>

                    </div>
                    <div class="box-body">
                        <table id="tb" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>No Telp</th>
                                    <th>Topik - Subtopik</th>
                                    <th>Hasil (Nilai)</th>
                                    <th style="text-align: center;" width="10%">Aksi</th>
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