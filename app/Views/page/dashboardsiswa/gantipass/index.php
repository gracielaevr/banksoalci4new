<script type="text/javascript">
    function proses() {
        var lama = document.getElementById('lama').value;
        var baru = document.getElementById('baru').value;

        if (lama === "") {
            alert("Password lama tidak boleh kosong");
        } else if (baru === "") {
            alert("Password baru tidak boleh kosong");
        } else {
            $('#btnSave').text('Saving...');
            $('#btnSave').attr('disabled', true);

            var form_data = new FormData();
            form_data.append('lama', lama);
            form_data.append('baru', baru);

            $.ajax({
                url: "<?php echo base_url(); ?>gantipass/proses",
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'God job!',
                        text: response.status,
                    })
                    location.reload();

                    $('#btnSave').text('Save');
                    $('#btnSave').attr('disabled', false);
                },
                error: function (response) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ups sorry!',
                        text: response.status,
                    })
                    $('#btnSave').text('Save');
                    $('#btnSave').attr('disabled', false);
                }
            });
        }
    }

    function togglePassword(fieldId) {
        var field = document.getElementById(fieldId);
        var toggleIcon = document.getElementById("toggle" + fieldId.charAt(0).toUpperCase() + fieldId.slice(1));

        if (field.type === "password") {
            field.type = "text";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        } else {
            field.type = "password";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        }
    }

    function openmodal_subs() {
        var modal = document.getElementById('subModal');
        modal.style.display = 'block';
    }
</script>



<section class="section">
    <div class="row">
        <div class="col-xl-12 col-sm-12 mb-2">
            <div class="card shadow-leap">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8 welcome-leap">
                            <h5 class="m-0">Ganti Password</h5>
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

    <div class="card p-3 shadow-leap">
        <div class="card-header d-flex justify-content-between">
            <h5>Ganti Password</h5>
        </div>


        <div class="card-body">

            <!-- Input lainnya di sebelah kanan -->
            <div class="col-12">
                <div class="form-group row">
                    <label for="lama" class="col-sm-4 control-label">Password Lama</label>
                    <div class="col-sm-12 input-group">
                        <input class="form-control" id="lama" name="lama" type="password">
                        <span class="input-group-text" onclick="togglePassword('lama')">
                            <i class="fas fa-eye" id="toggleLama"></i>
                        </span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="baru" class="col-sm-4 control-label">Password Baru</label>
                    <div class="col-sm-12 input-group">
                        <input class="form-control" id="baru" name="baru" type="password">
                        <span class="input-group-text" onclick="togglePassword('baru')">
                            <i class="fas fa-eye" id="toggleBaru"></i>
                        </span>
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    <button id="btnSave" type="button" class="btn btn-primary-leap mb-0  mt-4 me-2"
                        onclick="proses();">Update Password</button>
                    <button type="button" class="btn btn-default shadow mb-0  mt-4 ms-2">Batal</button>
                </div>
            </div>
        </div>



    </div>


</section>