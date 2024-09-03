<script type="text/javascript">
    var save_method; //for save method string
    var table;

    $(document).ready(function() {

        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>pengguna/ajaxlist",
            scrollx: true,
            responsive: true
        });

    });

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function add() {
        save_method = 'add';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah pengguna');
    }

    function subtopik(kode) {
        window.location.href = "<?php echo base_url(); ?>pengguna/detil/" + kode;
    }

    function detail_siswa(id) {
        window.location.href = "<?php echo base_url(); ?>siswa/index/" + id;
    }


    function save() {
        var role = "<?php echo $role; ?>";
        var kode = document.getElementById('kode').value;
        var email = document.getElementById('email').value;

        if (role === 'R00005') {
            var clickCount = parseInt(localStorage.getItem('R00005_click_count')) || 0;
            console.log("Klik count sebelum update: ", clickCount);
            if (clickCount >= 3) {

                $('#message').css('opacity', '1');
                $('#btnSave').attr('disabled', true);
                return;
            }

            localStorage.setItem('R00005_click_count', clickCount + 1);
            console.log("Klik count setelah update: ", clickCount + 1);

            var nama = document.getElementById('nama').value;
            var wa = document.getElementById('wa').value;
        } else {
            var idrole = document.getElementById('idrole').value;
        }

        if (email === '') {
            alert("Email tidak boleh kosong");
        } else {
            $('#btnSave').text('Saving...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>pengguna/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>pengguna/ajax_edit";
            }

            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('nama', nama);
            form_data.append('wa', wa);
            form_data.append('email', email);
            form_data.append('idrole', idrole);


            // ajax adding data to database
            $.ajax({
                url: url,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function(data) {
                    alert(data.status);
                    $('#modal_form').modal('hide');
                    reload();

                    $('#btnSave').text('Save'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("Error json " + errorThrown);

                    $('#btnSave').text('Save'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 
                }
            });
        }
    }

    function hapus(id, nama) {
        if (confirm("Apakah anda yakin menghapus pengguna " + nama + " ini ?")) {
            $.ajax({
                url: "<?php echo base_url(); ?>pengguna/hapus/" + id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    alert(data.status);
                    reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error hapus data');
                }
            });
        }
    }

    function ganti(id) {
        save_method = 'update';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Ganti Pengguna');
        $.ajax({
            url: "<?php echo base_url(); ?>pengguna/ganti/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                $('[name="kode"]').val(data.idusers);
                $('[name="nama"]').val(data.nama);
                $('[name="email"]').val(data.email);
                $('[name="wa"]').val(data.wa);
                $('[name="idrole"]').val(data.idrole);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }

    function lock(id) {
        if (confirm("Apakah anda yakin mereset password pengguna ini ?")) {
            $.ajax({
                url: "<?php echo base_url(); ?>pengguna/reset/" + id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    alert(data.status);
                    reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error reset password');
                }
            });
        }
    }

    function closemodal() {
        $('#modal_form').modal('hide');
    }
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Daftar Pengguna
            <small>Maintenance data pengguna</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">Pengguna</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="box box">
                    <div class="box-header with-border">
                        <button type="button" class="btn btn-primary btn-sm" onclick="add();">Tambah</button>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="reload();">Reload</button>
                    </div>
                    <div class="box-body">
                        <table id="tb" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="10%">Foto</th>
                                    <th>Nama</th>
                                    <th width="20%">Email</th>
                                    <th>Telp</th>
                                    <?php if ($role != 'R00005') { ?>
                                        <th>Hak Akses</th>
                                    <?php } ?>
                                    <th width="15%" style="text-align: center;">Aksi</th>

                                    <?php if ($role === 'R00005'); { ?>
                                        <th width="15%" style="text-align: center;">Opsi</th>
                                    <?php }; ?>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modal_form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Default Modal</h4>
            </div>
            <div class="modal-body">
                <form id="form" class="form-horizontal">
                    <h5 class="text-center fw-bold" style="color:red; opacity: 0;" id="message">Anda hanya bisa membuat
                        3 akun saja.
                    </h5>
                    <input type="hidden" name="kode" id="kode">
                    <?php if ($role === 'R00005') { ?>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-3 control-label">Nama</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="nama" id="nama" placeholder="Masukkan Nama">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="email" id="email"
                                    placeholder="Masukkan email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="wa" class="col-sm-3 control-label">Telepon</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="wa" id="wa" placeholder="Masukkan No Telepon">
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="email" name="email" id="email"
                                    placeholder="Masukkan email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-3 control-label">Hak Akses</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="idrole" name="idrole" data-placeholder="Pilih Hak Akses">
                                    <option value="R00002">Guru</option>
                                    <option value="R00001">Administrator</option>
                                </select>
                            </div>
                        </div>
                    <?php } ?>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnSave" type="button" class="btn btn-sm btn-primary" onclick="save();">Simpan</button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="closemodal();">Tutup</button>
            </div>
        </div>
    </div>
</div>