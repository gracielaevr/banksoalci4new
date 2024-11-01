<script>
    var table;

    $(document).ready(function () {

        var id = <?php echo json_encode($id ?? ''); ?>;

        if (id) {
            table = $('#tb').DataTable({
                ajax: "<?php echo base_url(); ?>session/ajaxdetail/" + id,
                scrollX: true,
                responsive: true
            });
        }

    });

    document.querySelector('.side-session').classList.add('active');


    $(document).ready(function () {
        // Menampilkan modal catatan
        $(document).on('click', '.btn-primary', function () {
            var catatan = $(this).data('catatan');
            $('#catatanContent').html(catatan);
            $('#modalCatatan').modal('show');
        });

        // Menghapus backdrop saat modal ditutup
        $('#modalCatatan').on('hidden.bs.modal', function () {
            $('.modal-backdrop').remove(); // Hapus backdrop yang ada
        });

        // Menampilkan modal pertanyaan
        $(document).on('click', '.btn-secondary', function () {
            var pertanyaan = $(this).data('pertanyaan');
            $('#pertanyaanContent').html(pertanyaan);
            $('#modalPertanyaan').modal('show');
        });

        // Menghapus backdrop saat modal pertanyaan ditutup
        $('#modalPertanyaan').on('hidden.bs.modal', function () {
            $('.modal-backdrop').remove(); // Hapus backdrop yang ada
        });
    });
</script>
<!-- Modal Catatan-->
<div class="modal fade" id="modalCatatan" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Note Teacher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body" id="catatanContent">
                <!-- Konten modal akan dimasukkan di sini -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPertanyaan" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Your Question</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body" id="pertanyaanContent">
                <!-- Konten modal akan dimasukkan di sini -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<section class="section">
    <div class="row">
        <div class="col-xl-12 col-sm-12 mb-4">
            <div class="card shadow-leap">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8 welcome-leap">
                            <h5 class="m-0">Session Detail</h5>
                        </div>
                        <div class="col-4 welcome-leap text-end">
                            <span id="current-day"></span>, <span id="current-date"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 col-sm-12 mb-4">
            <div class="row align-items-center">
                <div class="col-12 text-end">
                    <a href="<?= base_url('session') ?>" class="btn btn-icon m-0 icon-left btn-primary-leap"><i
                            class="fa fa-rotate-left me-2"></i>
                        Back to Session</a>
                </div>
            </div>
        </div>
    </div>

    <div class="card p-3 shadow-leap">

        <div class="card-body">
            <div class="table-responsive">
                <table id="tb" class="display text-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Teacher</th>
                            <th>Note Teacher</th>
                            <th>Question</th>
                        </tr>
                    </thead>
                    <tbody style="border-bottom: none;" class="t-left">

                    </tbody>
                </table>
            </div>
        </div>

    </div>

</section>