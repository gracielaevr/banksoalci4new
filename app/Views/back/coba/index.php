<script type="text/javascript">

    $(document).ready(function () {

    });

    function proses() {
        $('#btnSave').text('Saving...');
        $('#btnSave').attr('disabled', true);

        var excel = $('#excel').prop('files')[0];

        alert(excel);
        // var form_data = new FormData();
        // form_data.append('file', excel);

        // $.ajax({
        //     url: "<?php echo base_url(); ?>/coba/proses",
        //     dataType: 'JSON',
        //     cache: false,
        //     contentType: false,
        //     processData: false,
        //     data: form_data,
        //     type: 'POST',
        //     success: function (response) {
        //         alert(response.status);

        //         $('#btnSave').text('Save');
        //         $('#btnSave').attr('disabled', false);
        //     }, error: function (response) {
        //         alert(response.status);
        //         $('#btnSave').text('Save');
        //         $('#btnSave').attr('disabled', false);
        //     }
        // });
    }

</script>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Identitas <small>Maintenance Indentitas Instansi</small></h1>
        <ol class="breadcrumb">
            <li class="active">Identitas</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Identitas</h3>
                    </div>
                    <div class="form-horizontal">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="logo" class="col-sm-2 control-label">Excel</label>
                                <div class="col-sm-10">
                                    <input type="file" name="excel" class="form-control" id="excel" required accept=".xls, .xlsx" />
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button id="btnSave" type="button" class="btn btn-primary" onclick="proses();">Save</button>
                            <button type="button" class="btn btn-default">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>