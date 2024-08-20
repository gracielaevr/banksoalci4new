<script type="text/javascript">

    var save_method; //for save method string
    var table;

    var BASE_URL = "<?php echo base_url(); ?>"; 
    tinymce.init({
        selector: "textarea#instruksi", theme: "modern", height: 250,
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
        external_plugins: {"filemanager": BASE_URL + "/filemanager/plugin.min.js"}
    });

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>/soaltest/ajaxlist",
            scrollx: true,
            responsive: true
        });
    });

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function add() {
        save_method = 'add';
        $('#formbidang')[0].reset();
        $('#modal_bidang').modal('show');
        $('.modal-title2').text('Tambah Bidang');
    }

    function save() {
        var kode = document.getElementById('kodebidang').value;
        var namabidang = document.getElementById('namabidang').value;
        var status = document.getElementById('statusbidang').value;
        
        if (namabidang === '') {
            alert("Nama Bidang tidak boleh kosong");
        } else {
            $('#btnSaveBidang').text('Menyimpan...'); //change button text
            $('#btnSaveBidang').attr('disabled', true); //set button disable 

            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>/bidang/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>/bidang/ajax_edit";
            }
            
            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('namabidang', namabidang);
            form_data.append('status', status);
            
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
                    $('#modal_bidang').modal('hide');
                    reload();

                    $('#btnSaveBidang').text('Simpan'); //change button text
                    $('#btnSaveBidang').attr('disabled', false); //set button enable 
                }, error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error json " + errorThrown);

                    $('#btnSaveBidang').text('Simpan'); //change button text
                    $('#btnSaveBidang').attr('disabled', false); //set button enable 
                }
            });
        }
    }

    function hapus(id, nama) {
        if (confirm("Apakah anda yakin menghapus bidang " + nama + " ini ? \n*Semua data terkait akan terhapus (soal dan data peserta)*")) {
            $.ajax({
                url: "<?php echo base_url(); ?>/bidang/hapus/" + id,
                type: "POST",
                dataType: "JSON",
                success: function (data) {
                    alert(data.status);
                    reload();
                }, error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error hapus data');
                }
            });
        }
    }

    function soal(kode) {
        window.location.href = "<?php echo base_url(); ?>/soaltest/detil/"+kode;
    }

    function nilai(kode) {
        window.location.href = "<?php echo base_url(); ?>/komentar/detil/"+kode;
    }

    function scoring(kode) {
        window.location.href = "<?php echo base_url(); ?>/scoring/detil/"+kode;
    }
    
    function importExcel(){
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah soal');
    }
    
    function closemodal(){
        $('#modal_form').modal('hide');
    }

    function closemodalbidang(){
        $('#modal_bidang').modal('hide');
    }

    function closemodalinstruksi(){
        $('#modal_instruksi').modal('hide');
    }
    
    function simpan(){

        $('#imgLoading').show();
        $('#lbLoading').show();

        $('#btnSave').hide();
        $('#btnClose').hide();

        var idbidang = document.getElementById('bidang').value;
        var file = $('#file').prop('files')[0];

        var form_data = new FormData();
        form_data.append('file', file);
        form_data.append('idbidang', idbidang);

        $.ajax({
            url: "<?php echo base_url(); ?>/soaltest/ajax_upload",
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function (response) {
                alert(response.status);

                $('#btnSave').show();
                $('#btnClose').show();
                $('#imgLoading').hide();
                $('#lbLoading').hide();

                $('#btnSave').text('Save');
                $('#btnSave').attr('disabled', false);
                $('#modal_form').modal('hide');
                
            }, error: function (response) {
                alert(response.status);

                $('#btnSave').show();
                $('#btnClose').show();
                $('#imgLoading').hide();
                $('#lbLoading').hide();
                
                $('#btnSave').text('Save');
                $('#btnSave').attr('disabled', false);
            }
        });
    }

    function ganti(id) {
        save_method = 'update';
        $('#formbidang')[0].reset();
        $('#modal_bidang').modal('show');
        $('.modal-title2').text('Ganti Bidang');
        $.ajax({
            url: "<?php echo base_url(); ?>/bidang/ganti/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kodebidang"]').val(data.idbidang);
                $('[name="namabidang"]').val(data.namabidang);
                $('[name="statusbidang"]').val(data.status);
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }

    function instruksi(idbidang) {
        $('#forminstruksi')[0].reset();
        $('#modal_instruksi').modal('show');
        $('.modal-title2').text('Tambah instruksi');
        $('[name="idbidang"]').val(idbidang);

        $.ajax({
            url: "<?php echo base_url(); ?>/instruksi/ganti/" + idbidang,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                if(data.instruksi != null){
                    $('[name="kodeinstruksi"]').val(data.idinstruksi);
                    tinyMCE.get('instruksi').setContent(data.instruksi);
                }
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }

    function saveinstruksi() {
        var kodeinstruksi = document.getElementById('kodeinstruksi').value;
        var idbidang = document.getElementById('idbidang').value;
        var instruksi = tinyMCE.get('instruksi').getContent();
        
        if (instruksi === '') {
            alert("Instruksi tidak boleh kosong");
        } else {
            $('#btnSaveInstruksi').text('Menyimpan...'); //change button text
            $('#btnSaveInstruksi').attr('disabled', true); //set button disable 

            var url = "";
            if (kodeinstruksi === '') {
                url = "<?php echo base_url(); ?>/instruksi/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>/instruksi/ajax_edit";
            }
            
            var form_data = new FormData();
            form_data.append('kode', kodeinstruksi);
            form_data.append('instruksi', instruksi);
            form_data.append('idbidang', idbidang);
            
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
                    $('[name="kodeinstruksi"]').val('');
                    
                    $('#modal_instruksi').modal('hide');
                    reload();

                    $('#btnSaveInstruksi').text('Simpan'); //change button text
                    $('#btnSaveInstruksi').attr('disabled', false); //set button enable 
                }, error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error json " + errorThrown);

                    $('#btnSaveInstruksi').text('Simpan'); //change button text
                    $('#btnSaveInstruksi').attr('disabled', false); //set button enable 
                }
            });
        }
    }
    
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Daftar Soal Diagnostic Test
            <small>Maintenance data soal diagnostic test</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">Soal Diagnostic Test</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="box box">
                    <div class="box-header with-border">
                        <button type="button" class="btn btn-success btn-sm" onclick="add();">Tambah Bidang</button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="importExcel();">Import Soal</button>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="reload();">Reload</button>
                    </div>
                    <div class="box-body">
                        <table id="tb" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th width="30%">Bidang</th>
                                    <th width="10%">Status</th>
                                    <th width="10%">Instruksi</th>
                                    <th style="text-align: center;" width="25%">Nilai</th>
                                    <th style="text-align: center;" width="35%">Aksi</th>
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
                    <div class="form-group row">
                        <label for="bidang" class="col-sm-3 control-label">Bidang</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="bidang" name="bidang" data-placeholder="Pilih bidang soal">
                                <?php foreach($bidang->getResult() as $row ){
                                    echo '<option value="'.$row->idbidang.'">'.$row->namabidang.'</option>';
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="subtopik" class="col-sm-3 control-label">File Excel</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" id="file" name="file" autocomplete="off">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <img id="imgLoading" src="<?php echo base_url(); ?>/back/images/loading.gif" style="width:30px; display : none;">
                &nbsp;
                <label id="lbLoading" class="control-label" style="display : none;">Loading...</label>
                <button id="btnSave" type="button" class="btn btn-sm btn-primary" onclick="simpan();">Simpan</button>
                <button id="btnClose" type="button" class="btn btn-secondary btn-sm" onclick="closemodal();">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_bidang">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title2">Default Modal</h4>
            </div>
            <div class="modal-body">
                <form id="formbidang" class="form-horizontal">
                    <input type="hidden" name="kodebidang" id="kodebidang">
                    <div class="form-group row">
                        <label for="bidang" class="col-sm-3 control-label">Nama Bidang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="namabidang" name="namabidang" placeholder="Masukkan nama bidang disini" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status" class="col-sm-3 control-label">Status</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="statusbidang" name="statusbidang" data-placeholder="Pilih status bidang">
                               <option value="Aktif">Aktif</option>
                               <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnSaveBidang" type="button" class="btn btn-sm btn-primary" onclick="save();">Simpan</button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="closemodalbidang();">Batal</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_instruksi">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title2">Default Modal</h4>
            </div>
            <div class="modal-body">
                <form id="forminstruksi" class="form-horizontal">
                    <input type="hidden" name="kodeinstruksi" id="kodeinstruksi">
                    <input type="hidden" name="idbidang" id="idbidang">
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <textarea class="form-control" id="instruksi" name="instruksi"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnSaveInstruksi" type="button" class="btn btn-sm btn-primary" onclick="saveinstruksi();">Simpan</button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="closemodalinstruksi();">Batal</button>
            </div>
        </div>
    </div>
</div>