<script type="text/javascript">
    var save_method; //for save method string
    var table;

    $(document).ready(function() {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>subscribeadmin/ajaxlist",
            scrollx: true,
            responsive: true
        });
    });

    var BASE_URL = "<?php echo base_url(); ?>";
    tinymce.init({
        selector: "textarea#detail",
        theme: "modern",
        height: 250,
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
        ],
        toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
        toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
        external_filemanager_path: BASE_URL + "/filemanager/",
        filemanager_title: "File Gallery",
        relative_urls: false,
        remove_script_host: false,
        convert_urls: true,
        external_plugins: {
            "filemanager": BASE_URL + "/filemanager/plugin.min.js"
        }
    });

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function add() {
        save_method = 'add';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah Subscribe');
    }


    function save() {
        var idsubscribe = document.getElementById('idsubscribe').value;
        var judul = document.getElementById('judul').value;
        var harga = document.getElementById('harga').value;
        var detail = tinyMCE.get('detail').getContent();
        // var detail = document.getElementById('detail').value;
        var durasi = document.getElementById('durasi').value;
        var status = document.getElementById('status').value;
        var sesi = document.getElementById('sesi').value;
        var bundling = document.getElementById('bundling').value;

        if (judul === '') {
            alert("Judul tidak boleh kosong");
        } else if (harga === '') {
            alert("Harga tidak boleh kosong");
        } else if (detail === '') {
            alert("detail tidak boleh kosong");
        } else if (durasi === '') {
            alert("durasi tidak boleh kosong");
        } else if (status === '') {
            alert("Status tidak boleh kosong");
        } else if (sesi === '') {
            alert("Sesi tidak boleh kosong");
        } else if (bundling === '') {
            alert("Bundling tidak boleh kosong");
        } else {
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>subscribeadmin/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>subscribeadmin/ajax_edit";
            }

            var form_data = new FormData();
            form_data.append('idsubscribe', idsubscribe);
            form_data.append('judul', judul);
            form_data.append('harga', harga);
            form_data.append('detail', detail);
            form_data.append('durasi', durasi);
            form_data.append('status', status);
            form_data.append('sesi', sesi);
            form_data.append('bundling', bundling);
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
                    tinyMCE.get('detail').setContent("");

                    reload();

                    $('#btnSave').text('Simpan'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 
                },
                error: function(jqXHR, textStatus, errorThrown) {
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
                url: "<?php echo base_url(); ?>subscribeadmin/hapus/" + id,
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
        $('.modal-title').text('Ganti Subscribe');
        $.ajax({
            url: "<?php echo base_url(); ?>subscribeadmin/ganti/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                $('[name="idsubscribe"]').val(data.idsubscribe);
                $('[name="judul"]').val(data.judul);
                $('[name="harga"]').val(data.harga);
                $('[name="detail"]').val(data.detail);
                $('[name="durasi"]').val(data.durasi);
                $('[name="status"]').val(data.status);
                $('[name="sesi"]').val(data.sesi);
                $('[name="bundling"]').val(data.bundling);
                tinyMCE.get('detail').setContent(data.detail);
            },
            error: function(jqXHR, textStatus, errorThrown) {
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
            <h5 class="me-1 mb-0">Daftar Subscribe</h5><small>Subscribe</small>
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
                                    <th>#</th>
                                    <th width="10%">Judul</th>
                                    <th width="10%">Harga</th>
                                    <th width="20%">Detail Layanan</th>
                                    <th width="10%">Durasi Langganan</th>
                                    <th width="10%">Status Langganan</th>
                                    <th width="10%">Sesi</th>
                                    <th width="10%">Bundling</th>
                                    <th style="text-align: center;" width="30%">Aksi</th>
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
                    <input type="hidden" name="idsubscribe" id="idsubscribe">
                    <div class="form-group row">
                        <label for="judul" class="col-sm-3 control-label">Judul</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="judul" name="judul"
                                placeholder="Masukkan judul disini" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="harga" class="col-sm-3 control-label">Harga</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="harga" name="harga"
                                placeholder="Masukkan harga disini" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="durasi" class="col-sm-3 control-label">Durasi</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="durasi" name="durasi"
                                placeholder="Masukkan durasi disini" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama" class="col-sm-3 control-label">Status</label>
                        <div class="col-sm-12">
                            <select class="form-control" id="status" name="status" data-placeholder="Pilih Hak Akses">
                                <option value="Aktif">Aktif</option>
                                <option value="Non Aktif">Non Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="sesi" class="col-sm-3 control-label">Sesi</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="sesi" name="sesi"
                                placeholder="Masukkan sesi disini" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bundling" class="col-sm-3 control-label">Bundling</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="bundling" name="bundling"
                                placeholder="Masukkan bundling disini" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 control-label">Detail</label>
                        <div class="col-sm-12">
                            <textarea class="form-control" id="detail" name="detail"></textarea>
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