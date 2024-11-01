<script type="text/javascript">
    function save() {
        var role = '<?php echo $role; ?>';
        var nama = document.getElementById('nama').value;
        var wa = document.getElementById('wa').value;
        var foto = document.getElementById('profileImageInput').files[0] ?? '';

        if (role === 'R00001') {
            var email = document.getElementById('email').value;
        }

        console.log(foto + "\n" + wa + "\n" + nama);

        if (nama === "") {
            alert("Nama tidak boleh kosong");
        } else {
            if (foto) {
                const validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!validImageTypes.includes(foto.type)) {
                    alert('Hanya gambar (JPG, PNG, GIF).');
                    foto.value = ''; // Reset input jika tidak valid
                    return;
                }
            }
            $('#btnSave').text('Saving...');
            $('#btnSave').attr('disabled', true);

            var form_data = new FormData();
            if (role === 'R00001') {
                form_data.append('email', email);
            }
            form_data.append('nama', nama);
            form_data.append('wa', wa);
            form_data.append('file', foto);

            url = "<?php echo base_url(); ?>profile/proses";


            $.ajax({
                url: url,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (response) {
                    alert(response.status);

                    location.reload();
                    $('#btnSave').text('Update Profile');
                    $('#btnSave').attr('disabled', false);
                },
                error: function (response) {
                    alert(response.status);
                    $('#btnSave').text('Update Profile');
                    $('#btnSave').attr('disabled', false);
                }
            });
        }
    }
</script>




<section class="section">
    <div class="row-btn">
        <ol class="breadcrumb bg-white d-flex align-items-end">
            <h5 class="me-1 mb-0">Profil</h5>
            <ansmall>Maintenance profil</ansmall>
        </ol>
    </div>


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
                <?php if ($role === 'R00001'): ?>
                    <div class="form-profile mb-3  row align-items-center">
                        <label for="email" class="col-form-label">Email</label>
                        <div>
                            <input class="form-control" id="email" name="email" type="text"
                                value="<?php echo $pro->email; ?>">
                        </div>
                    </div>
                <?php else: ?>
                    <div class="form-profile mb-3  row align-items-center">
                        <label for="email" class="col-form-label">Email</label>
                        <div>
                            <input class="form-control" id="email" name="email" type="text"
                                value="<?php echo $pro->email; ?>" readonly>
                            <small class="text-muted">* Jika ingin mengganti email hubungi admin</small>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="form-profile mb-3 row align-items-center">
                    <label for="nama" class="col-form-label">Nama</label>
                    <div>
                        <input class="form-control" id="nama" name="nama" type="text" value="<?php echo $pro->nama; ?>">
                    </div>
                </div>
                <div class="form-profile mb-3 row align-items-center">
                    <label for="wa" class="col-form-label">No WA</label>
                    <div>
                        <input class="form-control" id="wa" name="wa" type="number" value="<?php echo $pro->wa; ?>">
                    </div>
                </div>



                <div class="d-flex justify-content-center">
                    <button id="btnSave" type="button" class="btn btn-primary-leap mb-0  mt-4 me-2"
                        onclick="save();">Update Profile</button>
                    <button type="button" class="btn btn-default shadow mb-0  mt-4 ms-2">Batal</button>
                </div>
            </div>
        </div>



    </div>


</section>