<script type="text/javascript">
function save() {
    var nama = document.getElementById('nama').value;
    var wa = document.getElementById('wa').value;
    var school_name = document.getElementById('school_name').value;
    var foto = $('#foto').prop('files')[0];

    if (nama === "") {
        alert("Nama tidak boleh kosong");
    } else if (!foto) {
        alert("foto tidak boleh kosong");
    } else {
        $('#btnSave').text('Saving...');
        $('#btnSave').attr('disabled', true);

        var form_data = new FormData();
        form_data.append('nama', nama);
        form_data.append('wa', wa);
        form_data.append('school_name', school_name);
        form_data.append('file', foto);

        url = "<?php echo base_url(); ?>profilinstansi/proses";


        $.ajax({
            url: url,
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function(response) {
                alert(response.status);

                location.reload();
                $('#btnSave').text('Update Profile');
                $('#btnSave').attr('disabled', false);
            },
            error: function(response) {
                alert(response.status);
                $('#btnSave').text('Update Profile');
                $('#btnSave').attr('disabled', false);
            }
        });
    }
}
</script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Profil
            <small>Maintenance profil</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">Profil</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Profil</h3>
                    </div>
                    <div class="form-horizontal">
                        <div class="box-body">
                            <div class="form-group row">
                                <label for="email" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="email" name="email" type="text"
                                        value="<?php echo $pro->email; ?>" readonly>
                                    <small>* Jika ingin mengganti email hubungi admin</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-sm-2 control-label">Nama</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="nama" name="nama" type="text"
                                        value="<?php echo $pro->nama; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="wa" class="col-sm-2 control-label">No WA</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="wa" name="wa" type="text" value="<?= $pro->wa; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="wa" class="col-sm-2 control-label">Sekolah</label>
                                <div class="col-sm-10">

                                    <input class="form-control" id="email" name="email" type="text"
                                        value="<?php echo $pro->school_name; ?>" readonly>
                                    <small>* Khusus Pelanggan</small>
                                </div>

                            </div>
                            <div class="form-group row">
                                <label for="foto" class="col-sm-2 control-label">Foto</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="foto" name="foto" type="file">
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button id="btnSave" type="button" class="btn btn-primary" onclick="save();">Update
                                Profile</button>
                            <button type="button" class="btn btn-default">Batal</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>