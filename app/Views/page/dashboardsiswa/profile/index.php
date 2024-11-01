<!-- Custom JS -->
<script>
    function proses() {
        var nama = document.getElementById('nama').value;
        var wa = document.getElementById('wa').value;
        // var foto = $('#profileImageInput').prop('files')[0];
        var foto = document.getElementById('profileImageInput').files[0] ?? '';

        console.log(nama + "\n" + wa + "\n" + foto);

        if (nama === "") {
            Swal.fire({
                icon: 'error',
                title: 'Ups sorry! ',
                text: "Name Cannot be null",
            })
        } else {

            if (foto) {
                const validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!validImageTypes.includes(foto.type)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ups sorry!',
                        text: 'Only image files are allowed (JPG, PNG, GIF).',
                    })
                    foto.value = ''; // Reset input jika tidak valid
                    return;
                }
            }
            $('#btnSave').text('Saving...');
            $('#btnSave').attr('disabled', true);

            var form_data = new FormData();
            form_data.append('nama', nama);
            form_data.append('wa', wa);
            form_data.append('file', foto);

            $.ajax({
                url: "<?php echo base_url(); ?>profile/proses",
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

    // Menampilkan preview gambar
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function () {
            const output = document.getElementById('profileImage');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    document.querySelector('.side-profile').classList.add('active');

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
                            <h5 class="m-0">Profile</h5>
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
            <h5>Form Profile</h5>
        </div>


        <div class="card-body row d-flex justify-content-between align-items-start">
            <!-- Gambar Profil di sebelah kiri -->
            <div class="col-md-4 col-12 text-center position-relative pt-2 pb-2"
                style="border: 2px solid #316aab; border-radius: 12px;">
                <div class="profile-image-container">
                    <img src="<?= $foto_profile; ?>" id="profileImage" style="width: 100%; height: 100%;"
                        alt="Profile Picture">
                    <div class="edit-overlay" onclick="document.getElementById('profileImageInput').click();">
                        <i class="fas fa-edit text-white" style="cursor: pointer; font-size: 1.5rem;"></i>
                        <span class="edit-text text-white ms-2">Choose here</span>
                    </div>
                    <input type="file" id="profileImageInput" name="foto" style="display: none;"
                        onchange="previewImage(event)">
                </div>
            </div>


            <!-- Input lainnya di sebelah kanan -->
            <div class="col-md-7 col-12 mt-4">
                <div class="form-profile mb-3  row align-items-center">
                    <label for="email" class="col-form-label">Email</label>
                    <div>
                        <input class="form-control" id="email" name="email" type="text" value="<?= $pro->email; ?>"
                            readonly>
                        <small class="text-muted">* Jika ingin mengganti email hubungi admin</small>
                    </div>
                </div>
                <div class="form-profile mb-3 row align-items-center">
                    <label for="nama" class="col-form-label">Nama</label>
                    <div>
                        <input class="form-control" id="nama" name="nama" type="text" value="<?= $pro->nama; ?>">
                    </div>
                </div>
                <div class="form-profile mb-3 row align-items-center">
                    <label for="wa" class="col-form-label">No WA</label>
                    <div>
                        <input class="form-control" id="wa" name="wa" type="number" value="<?= $pro->wa; ?>">
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    <button id="btnSave" type="submitss" class="btn btn-primary-leap mb-0  mt-4 me-2"
                        onclick="proses();">Update Profile</button>
                    <button type="button" class="btn btn-default shadow mb-0  mt-4 ms-2"
                        onclick="location.reload();">Batal</button>
                </div>
            </div>
        </div>



    </div>
</section>