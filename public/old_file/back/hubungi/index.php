<script type="text/javascript">
function proses() {
    $('#btnSave').text('Saving...');
    $('#btnSave').attr('disabled', true);

    var text = document.getElementById('text').value;
    var wa = document.getElementById('wa').value;

    var form_data = new FormData();
    form_data.append('text', text);
    form_data.append('wa', wa);

    $.ajax({
        url: "<?php echo base_url(); ?>hubungi/proses",
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
        <h1>Hubungi Kami <small>Maintenance Hubungi WA</small></h1>
        <ol class="breadcrumb">
            <li class="active">Hubungi Kami</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Text Whatsapp</h3>
                    </div>
                    <div class="form-horizontal">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="wa" class="col-sm-2 control-label">No Whatsapp</label>
                                <div class="col-sm-10">
                                    <input type="text" id="wa" class="form-control" name="wa" value="<?php echo $wa; ?>"
                                        placeholder="08123xxx">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="txt" class="col-sm-2 control-label">Text Chat</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="text" rows="4"
                                        id="text"><?php echo $text; ?></textarea>
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