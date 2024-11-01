<script>
var table;

$(document).ready(function() {
    // new DataTable('#tb');
    table = $('#tb').DataTable({
        ajax: "<?php echo base_url(); ?>history/ajaxlist",
        scrollx: true,
        responsive: true
    });
});

// document.getElementById('subModal').addEventListener('click', function() {
//     openmodal(true, "<php echo base_url(); ?>history");
// })
</script>

<section class="section">
    <div class="row">
        <div class="col-xl-12 col-sm-12 mb-2">
            <div class="card shadow-leap">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8 welcome-leap">
                            <h5 class="m-0">History</h5>
                        </div>
                        <div class="col-4 welcome-leap text-end">
                            <span id="current-day"></span>, <span id="current-date"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (session()->getFlashdata('notification_free')): ?>
    <marquee behavior="scroll" direction="left" class="text-danger">
        <?= session()->getFlashdata('notification_free'); ?>
    </marquee>
    <?php endif; ?>

    <div class="card shadow-leap bg-white p-3 mt-2">

        <div class="table-responsive">
            <table id="tb" class="display">
                <thead>
                    <tr>
                        <th style="text-align: center;">#</th>
                        <th style="text-align: center;">Date</th>
                        <th style="text-align: center;">Sub topik</th>
                        <th style="text-align: center;">Corect</th>
                        <th style="text-align: center;">Wrong</th>
                        <th style="text-align: center;">score</th>
                    </tr>
                </thead>
                <tbody style="border-bottom: none;">

                </tbody>
            </table>
        </div>
    </div>

</section>