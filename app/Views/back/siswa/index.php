<script type="text/javascript">

    var save_method; //for save method string
    var table;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>/siswaguru/ajaxlist",
            scrollx: true,
            responsive: true
        });
    });

    function nilai(id, jenis) {
        if(jenis === "mg"){
            window.location.href = "<?php echo base_url(); ?>/siswaguru/detilmg/"+id;
        }else{
            window.location.href = "<?php echo base_url(); ?>/siswaguru/detil/"+id;
        }
    }

</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Siswa <small>Maintenance data siswa</small></h1>
        <ol class="breadcrumb">
            <li class="active">siswa</li>
        </ol>
    </section>
    <section class="content">
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
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>Topik - Subtopik</th>
                                    <th>Hasil (Nilai)</th>
                                    <th style="text-align: center;" width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>20 Feb 2023</td>
                                    <td>Nana</td>
                                    <td>Adverb of Frequency (AOF) - Adverb of Frequency</td>
                                    <td>80</td>
                                    <td><button type="button" class="btn btn-warning btn-sm" onclick="nilai();"><i class="fa fa-fw fa-eye"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="nilai();"><i class="fa fa-fw fa-trash"></i></button>
                                    </td>
                                </tr>
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
                    <input type="hidden" name="kode" id="kode">
                    <input type="hidden" name="idsubtopik" id="idsubtopik" value="<?php //echo $head->idsubtopik; ?>">
                    <div class="form-group row">
                        <label for="subtopik" class="col-sm-3 control-label">Judul Subtopik</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="subtopik" name="subtopik" autocomplete="off">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnSave" type="button" class="btn btn-sm btn-primary" onclick="save();">Simpan</button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="closemodal();">Tutup</button>
            </div>
        </div>
    </div>
</div>