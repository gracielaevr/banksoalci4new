<script type="text/javascript">
    var table;

    $(document).ready(function() {

        var id = <?php echo json_encode($id ?? ''); ?>;

        if (id) {
            table = $('#tb').DataTable({
                ajax: "<?php echo base_url(); ?>subscribesiswa/detaillist/" + id,
                scrollX: true,
                responsive: true
            });
        }
    });

    document.querySelector('.side-subscribesiswa').classList.add('active');
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
                                    <th width="5%">#</th>
                                    <th width="15%">Paket Subscribe</th>
                                    <th width="10%">Sesi</th>
                                    <th width="15%">Tanggal Mulai</th>
                                    <th width="15%">Tanggal Berakhir</th>
                                    <th width="15%">Status Paket</th>
                                </tr>
                            </thead>
                            <tbody class="t-topik" style="border-bottom: none;">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>