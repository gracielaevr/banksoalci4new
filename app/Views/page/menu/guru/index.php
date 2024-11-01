<script type="text/javascript">
    var save_method; //for save method string
    var table;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>tipeguru/ajaxlist",
            scrollx: true,
            responsive: true
        });
    });

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function lock(id) {
        if (confirm("Apakah anda yakin mereset password pengguna ini ?")) {
            $.ajax({
                url: "<?php echo base_url(); ?>tipeguru/reset/" + id,
                type: "POST",
                dataType: "JSON",
                success: function (data) {
                    alert(data.status);
                    reload();
                    reload_page();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error reset password');
                }
            });
        }
    }

    function add() {
        save_method = 'add';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah Guru ');
    }

    function save() {
        var idusers = document.getElementById('idusers').value;
        var email = document.getElementById('email').value;
        var nama = document.getElementById('nama').value;
        var idguru = document.getElementById('idguru').value;

        // alert(idinstansi);
        if (email === '') {
            alert("Email tidak boleh kosong");
        } else if (nama === '') {
            alert("Nama tidak boleh kosong");
        } else if (idguru === '') {
            alert("Tipe guru tidak boleh kosong");
        } else {
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            if (save_method === 'add') {

                url = "<?php echo base_url(); ?>tipeguru/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>tipeguru/ajax_edit";

            }

            var form_data = new FormData();
            form_data.append('idusers', idusers);
            form_data.append('email', email);
            form_data.append('nama', nama);
            form_data.append('idguru', idguru);


            // ajax adding data to database
            $.ajax({
                url: url,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (data) {
                    alert(data.status);
                    $('#modal_form').modal('hide');
                    reload();

                    $('#btnSave').text('Simpan'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error json " + errorThrown);

                    $('#btnSave').text('Simpan'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 
                }
            });
        }
    }

    function hapus(id, nama) {
        if (confirm("Apakah anda yakin menghapus " + nama +
            " ini ? \n*Semua data terkait akan terhapus *")) {
            $.ajax({
                url: "<?php echo base_url(); ?>tipeguru/hapus/" + id,
                type: "POST",
                dataType: "JSON",
                success: function (data) {
                    alert(data.status);
                    reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error hapus data');
                }
            });
        }
    }

    function ganti(id) {
        save_method = 'update';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Ganti Guru ');
        $.ajax({
            url: "<?php echo base_url(); ?>tipeguru/ganti/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="idusers"]').val(data.idusers);
                $('[name="email"]').val(data.email);
                $('[name="nama"]').val(data.nama);
                $('[name="idguru"]').val(data.idguru);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }

    function closemodal() {
        $('#modal_form').modal('hide');
    }
</script>
<section class="section">
    <div class="row-btn">
        <ol class="breadcrumb bg-white d-flex align-items-end">
            <h5 class="me-1 mb-0">Daftar Guru </h5><small></small>
        </ol>
    </div>
    <div class="card shadow-leap p-3">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="card-header">
                    <button type="button" class="btn btn-primary btn-sm" onclick="add();">Tambah</button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="reload();">Reload</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tb" class="display text-sm">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="20%">Email</th>
                                    <th width="25%">Nama</th>
                                    <th width="25%">Tipe Guru</th>
                                    <th style="text-align: center;" width="20%">Aksi</th>
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
                    <input type="hidden" name="idusers" id="idusers">
                    <div class="form-group row">
                        <label for="email" class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-12">
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Masukan email disini" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama" class="col-sm-3 control-label">Nama</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="nama" name="nama"
                                placeholder="Masukan nama disini" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Tipe Guru</label>
                        <div class="col-sm-12">
                            <select class="form-control" name="idguru" id="idguru">
                                <option value="-">- Pilih -</option>
                                <?php
                                foreach ($guru->getResult() as $row) {
                                    ?>
                                    <option value="<?php echo $row->idguru ?>">
                                        <?php

                                        echo $row->tipe; ?>
                                    </option>
                                    <?php
                                }
                                ; ?>
                            </select>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button id="btnSave" type="button" class="btn btn-sm btn-primary" onclick="save();">Simpan</button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="closemodal();">Batal</button>
            </div>
        </div>
    </div>
</div>