<section class="section">
    <div class="row">
        <div class="col-xl-12 col-sm-12 mb-2">
            <div class="card shadow-leap">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6 welcome-leap">
                            <h5 class="m-0">TOPIC : <?= $topik; ?>
                            </h5>
                        </div>
                        <div class="col-6 welcome-leap text-end btnnn">
                            <div class="section-header-breadcrumb buttons">
                                <a href="<?= base_url('homesiswa') ?>"
                                    class="btn btn-icon m-0 icon-left btn-primary-leap"><i
                                        class="fa fa-rotate-left me-2"></i>
                                    Back to Topic</a>
                            </div>
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
    <div class="section-body">

        <div class="d-flex align-items-start justify-content-between mt-3 mb-3 search-leap">

            <h5 class="section-title">Subtopic</h5>

            <div class="search-bar">
                <div class="input-group">
                    <input type="text" id="search_text" placeholder="Search topics..." class="form-control ms-2"
                        style="box-shadow: 0px 0px 23px 0px rgba(0,0,0,0.3);">
                    <div class="input-group-btn">
                        <button class="btn btn-primary-leap"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="wadah">

        </div>

    </div>
</section>



<script>
$(document).ready(function() {

    load_data();

    function load_data(search) {
        $.ajax({
            url: "<?php echo base_url(); ?>subtopic1/ajaxlist/<?php echo $idtopik; ?>",
            type: "POST",
            dataType: "JSON",
            data: {
                query: search
            },
            success: function(data) {
                $('#wadah').html(data.status);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error load data');
            }
        });
    }

    $('#search_text').keyup(function() {
        var search = $("#search_text").val();
        if (search != '') {
            load_data(search);
        } else {
            load_data();
        }
    });

});

document.querySelector('.side-dashboard').classList.add('active');
</script>
</body>

</html>