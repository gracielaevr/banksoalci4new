</div>

<footer class="footer pt-3 pb-3">
    <hr class="horizontal dark mt-0">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 mb-lg-0 mb-4 d-flex justify-content-between align-items-center">
                <div class="textstart">
                    Copyright &copy; <?= date("Y"); ?> • <a href=""> Leapverse -
                        Bank Soal.</a> All Rights Reserved
                </div>
                <div class="footer-right">
                    2.3.0
                </div>
            </div>

        </div>
    </div>
</footer>

</main>



<script src="<?= base_url() ?>front/dashboard_new/assets/js/core/popper.min.js"></script>
<script src="<?= base_url() ?>front/dashboard_new/assets/js/core/bootstrap.min.js"></script>
<script src="<?= base_url() ?>front/dashboard_new/assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="<?= base_url() ?>front/dashboard_new/assets/js/plugins/smooth-scrollbar.min.js"></script>
<script src="<?= base_url() ?>front/dashboard_new/assets/js/plugins/chartjs.min.js"></script>
<!-- General JS Scripts 
-->
<script src="<?= base_url() ?>front/assets/js/jquery.min.js"></script>
<script src="<?= base_url() ?>front/assets/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"
    integrity="sha512-zMfrMAZYAlNClPKjN+JMuslK/B6sPM09BGvrWlW+cymmPmsUT1xJF3P4kxI3lOh9zypakSgWaTpY6vDJY/3Dig=="
    crossorigin="anonymous" referrerpolicy="no-referrer">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="<?= base_url() ?>front/dashboard/assets/js/stisla.js"></script>


<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="<?= base_url() ?>front/dashboard_new/assets/js/argon-dashboard.min.js?v=2.0.4"></script>
<!-- Template JS File -->
<script src="<?= base_url() ?>front/dashboard/assets/js/custom.js"></script>


<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>
<script src="<?php echo base_url(); ?>back/bower_components/bootstrap-daterangepicker/daterangepicker.js">
</script>
<script src="<?php echo base_url(); ?>back/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js">
</script>

<script src="<?php echo base_url(); ?>back/bower_components/chart.js/Chart.js"></script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const activePage = window.location.pathname;
        const navLinks = document.querySelectorAll('#sidenav-collapse-main a').forEach(link => {
            if (link.href.includes(`${activePage}`)) {
                link.classList.add('active');
                console.log(link);
            }
        })


    });

    $(document).ready(function() {
        // Show the flash message
        $('#flashMessage').addClass('show');

        // Hide the flash message after 5 seconds
        setTimeout(function() {
            $('#flashMessage').removeClass('show');
        }, 5000);
    });


    // document.getElementById('profileImageInput').addEventListener('change', function() {
    //     var foto = document.getElementById('profileImageInput').files[0];

    //     if (foto) {
    //         console.log("foto selected:", foto.name); // Log nama file jika file dipilih
    //     } else {
    //         console.log("No file selected"); // Log jika tidak ada file yang dipilih
    //     }
    // });

    // Menampilkan preview gambar
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('profileImage');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

</body>

</html>