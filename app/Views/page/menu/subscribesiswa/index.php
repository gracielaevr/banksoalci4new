<script type="text/javascript">
    var table;

    $(document).ready(function() {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>subscribesiswa/ajaxlist",
            scrollx: true,
            responsive: true
        });
    });


    function detail(id) {
        window.location.href = "<?php echo base_url(); ?>subscribesiswa/detailsiswa/" + id;
    }
</script>


<section class="section">
    <div class="row-btn">
        <ol class="breadcrumb bg-white d-flex align-items-end">
            <h5 class="me-1 mb-0">Daftar Siswa Subscribe</h5><small>Subscribe</small>
        </ol>
    </div>
    <div class="card shadow-leap p-3">
        <div class="row">
            <div class="col-lg-12 col-xs-12">

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tb" class="display text-sm">
                            <thead>
                                <tr>
                                    <th class"text-center" width="5%">#</th>
                                    <th class"text-center" width="15%">Nama Siswa</th>
                                    <th class"text-center" width="15">Email</th>
                                    <th class"text-center" width="15%">No HP</th>
                                    <th class"text-center" width="20%">Asal Sekolah</th>
                                    <th class"text-center" width="15%">Paket Subscribe</th>
                                    <th class"text-center" width="15%">Tanggal Mulai</th>
                                    <th class"text-center" width="15%">Tanggal Berakhir</th>
                                    <th class"text-center" width="15%">Status Paket</th>
                                    <th class"text-center" width="15%">Aksi</th>
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