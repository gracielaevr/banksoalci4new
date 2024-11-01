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

    function reload_page() {
        location.reload(); // Memuat ulang seluruh halaman
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
        var role = "<?= $role; ?>";
        var kode = document.getElementById('kode').value;
        var email = document.getElementById('email').value;

        if (role === 'R00004') {
            var nama = document.getElementById('nama').value;
            var wa = document.getElementById('wa').value;
            var idinstansi = document.getElementById('idinstansi').value;
            var school_name = document.getElementById('school_name').value;
        } else {
            var idrole = document.getElementById('idrole').value;
        }

        if (email === '') {
            alert("Email tidak boleh kosong");
        } else {
            // $('#btnSave').text('Saving...'); //change button text
            // $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            if (save_method === 'add') {

                if (role === 'R00004') {

                    var siswa = <?= $jml_siswa; ?>;

                    if (siswa >= 1) {
                        alert("Anda hanya bisa membuat 1 akun, Hubungi Admin untuk info selengkapnya.");
                        $('#modal_form').modal('hide');
                        reload_page();
                    } else {
                        url = "<?php echo base_url(); ?>pengguna/ajax_add";
                    }
                } else {
                    url = "<?php echo base_url(); ?>pengguna/ajax_add";
                }

            } else {
                url = "<?php echo base_url(); ?>pengguna/ajax_edit";
            }

            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('nama', nama);
            form_data.append('wa', wa);
            form_data.append('email', email);
            form_data.append('idrole', idrole);
            form_data.append('idinstansi', idinstansi);
            form_data.append('school_name', school_name);

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
                    reload_page();

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
                    reload_page();
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
                    reload_page();
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



<section class="section">
    <div class="row-btn">
        <ol class="breadcrumb bg-white d-flex align-items-end">
            <h5 class="me-1 mb-0">Daftar Pengguna</h5><small>Maintenance data pengguna</small>
        </ol>
    </div>
    <div class="card shadow-leap p-3">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="card-header">
                    <button type="button" class="btn btn-primary btn-sm" onclick="add();">Tambah Pengguna</button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="reload_page();">Reload</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tb" class="display text-sm">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="10%">Foto</th>
                                    <th>Nama</th>
                                    <th width="20%">Email</th>
                                    <th>Telp</th>
                                    <?php if ($role != 'R00004') { ?>
                                        <th>Hak Akses</th>
                                        <th width="15%" style="text-align: center;">Aksi</th>
                                    <?php } ?>


                                    <?php if ($role === 'R00004') { ?>

                                        <th width="15%" style="text-align: center;">Opsi</th>
                                    <?php } else { ?>

                                    <?php }; ?>
                                </tr>
                            </thead>
                            <tbody style="border-bottom: none;">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close text-danger" style="font-size: x-large;" data-bs-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form" class="form-horizontal">
                    <input type="hidden" name="kode" id="kode">
                    <?php if ($role === 'R00004') { ?>
                        <div class="form-group row">
                            <input type="hidden" name="idinstansi" id="idinstansi" value="<?= $idinstansi; ?>">
                            <input type="hidden" name="school_name" id="school_name" value="<?= $school_name; ?>">
                            <input type="hidden" value="<?= $jml_siswa; ?>">
                            <label for="nama" class="col-sm-3 control-label">Nama</label>
                            <div class="col-sm-12">
                                <input class="form-control" type="text" name="nama" id="nama" placeholder="Masukkan Nama">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-12">
                                <input class="form-control" type="text" name="email" id="email"
                                    placeholder="Masukkan email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="wa" class="col-sm-3 control-label">Telepon</label>
                            <div class="col-sm-12">
                                <input class="form-control" type="text" name="wa" id="wa" placeholder="Masukkan No Telepon">
                            </div>
                        </div>
                    <?php } else { ?>

                        <div class="form-group row">
                            <label for="nama" class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-12">
                                <input class="form-control" type="email" name="email" id="email"
                                    placeholder="Masukkan email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-3 control-label">Hak Akses</label>
                            <div class="col-sm-12">
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
                <button type="button" class="btn text-white bg-secondary" data-bs-dismiss="modal"
                    onclick="closemodal();">Close</button>
                <button id="btnSave" type="button" class="btn text-white bg-primary" onclick="save();">Save
                    changes</button>
            </div>
        </div>
    </div>
</div>