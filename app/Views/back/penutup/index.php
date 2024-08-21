<script type="text/javascript">
var BASE_URL = "<?php echo base_url(); ?>";
tinymce.init({
    selector: "textarea#deskripsi",
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

function proses() {
    $('#btnSave').text('Saving...');
    $('#btnSave').attr('disabled', true);

    var ket = tinyMCE.get('deskripsi').getContent();

    var form_data = new FormData();
    form_data.append('deskripsi', ket);

    $.ajax({
        url: "<?php echo base_url(); ?>penutup/proses",
        dataType: 'JSON',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'POST',
        success: function(response) {
            alert(response.status);

            $('#btnSave').text('Save');
            $('#btnSave').attr('disabled', false);
        },
        error: function(response) {
            alert(response.status);
            $('#btnSave').text('Save');
            $('#btnSave').attr('disabled', false);
        }
    });
}
</script>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Penutup <small>Maintenance Kata Penutup</small></h1>
        <ol class="breadcrumb">
            <li class="active">Penutup</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Kata Penutup</h3>
                    </div>
                    <div class="form-horizontal">
                        <div class="box-body">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <textarea class="form-control" name="deskripsi"
                                        id="deskripsi"><?php echo $deskripsi; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button id="btnSave" type="button" class="btn btn-primary"
                                onclick="proses();">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>