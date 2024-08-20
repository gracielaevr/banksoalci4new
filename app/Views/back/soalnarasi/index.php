<script type="text/javascript">

    var save_method; //for save method string
    var table;

    var BASE_URL = "<?php echo base_url(); ?>";
    tinymce.init({
        selector: "textarea#soal", theme: "modern", height: 250,
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
            ajax: "<?php echo base_url(); ?>/narasi/ajaxlist/<?php echo $head->idsubtopik; ?>",
            scrollx: true,
            responsive: true
        });
    });

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }
    
    function simpan() {
        var idsub = document.getElementById('idsub').value;
        var kode = document.getElementById('kode').value;
        var ket = tinyMCE.get('soal').getContent();
        
        if (soal === '') {
            alert("Narasi tidak boleh kosong");
        }else {
            $('#btnSave').text('Saving...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            if (kode === '') {
                url = "<?php echo base_url(); ?>/narasi/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>/narasi/ajax_edit";
            }
            
            var form_data = new FormData();
            form_data.append('idsubtopik', idsub);
            form_data.append('deskripsi', ket);
            form_data.append('kode', kode);
            
            // ajax adding data to database
            $.ajax({
                url: url,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                traditional: true,
                type: 'POST',
                success: function (data) {
                    alert(data.status);
                    location.reload();

                    $('#btnSave').text('Save'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 
                }, error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error json " + errorThrown);

                    $('#btnSave').text('Save'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 
                }
            });
        }
    }

    function hapus(id, nama) {
        if (confirm("Apakah anda yakin menghapus narasi ini ?")) {
            $.ajax({
                url: "<?php echo base_url(); ?>/narasi/hapus/" + id,
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

    function kembali() {
        window.location.href = "<?php echo base_url(); ?>/soal/";
    }

    function ganti(id) {
        save_method = 'update';
        $.ajax({
            url: "<?php echo base_url(); ?>/narasi/ganti/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.idnarasi);
                tinyMCE.get('soal').setContent(data.deskripsi);
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }

    function soal(kode) {
        window.location.href = "<?php echo base_url(); ?>/soalnarasi/detil/"+kode;
    }
    
    function closemodal(){
        $('#modal_form').modal('hide');
    } 

    function batal(){
        location.reload();
    }   
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Detail Narasi <small>Maintenance data narasi</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>/soal"> Soal</a></li>
            <li class="active">Detil Narasi</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div class="form-horizontal">
                            <input type="hidden" name="kode" id="kode">
                            <input type="hidden" name="idsub" id="idsub" value="<?php echo $head->idsubtopik; ?>">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Subtopik</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="<?php echo $head->namasub; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Narasi</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="soal" name="soal"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-9">
                                    <button id="btnSimpan" type="button" class="btn btn-sm btn-success" onclick="simpan();">Simpan</button>
                                    <button id="btnCancel" type="button" class="btn btn-sm btn-danger" onclick="batal();">Batal</button>
                                </div>
                                <div class="col-sm-1">
                                    <button id="btnBack" type="button" class="btn btn-sm btn-primary" onclick="kembali();">Kembali</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <button type="button" class="btn btn-secondary btn-sm" onclick="reload();">Reload</button>
                    </div>
                    <div class="box-body">
                        <table id="tb" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="75%">Narasi</th>
                                    <th width="10%">Tambah Soal</th>
                                    <th style="text-align: center;" width="20%">Aksi</th>
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