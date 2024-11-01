<script type="text/javascript">
    var save_method; //for save method string
    var table;

    $(document).ready(function() {

        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>siswa/siswalist/",
            scrollX: true,
            responsive: true
        });

        $('#tanggalrange').daterangepicker();
    });

    function siswa_list(id) {
        window.location.href = "<?php echo base_url(); ?>siswa/siswadetail/" + id;
    }

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
                <div class="card-header">
                    <div class="input-group">
                        <input type="text" class="form-control" id="tanggalrange" placeholder="Pilih Tanggal">

                        <span class="input-group-btn">
                            <button type="button" class="btn btn-success btn-flat" onclick="excellap();">
                                <i class="fa fa-file-excel text-white me-2"></i> <span>Export Excel</span>
                            </button>
                        </span>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tb" class="display text-sm">
                            <thead>
                                <tr>
                                    <th class="text-center" width="3%">#</th>
                                    <th class="text-center" width="10%">Foto</th>
                                    <th class="text-center" width="15%">Nama</th>
                                    <th class="text-center" width="15%">Email</th>
                                    <th class="text-center" width="15%">No Telp</th>
                                    <th class="text-center" width="15%">Asal Sekolah</th>
                                    <th class="text-center" width="10%">Aksi</th>
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