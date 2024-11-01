<script type="text/javascript">
var save_method; //for save method string
var table;

$(document).ready(function() {
    // new DataTable('#tb');
    table = $('#tb').DataTable({
        ajax: "<?php echo base_url(); ?>topik/ajaxlist",
        scrollx: true,
        responsive: true
    });
});


function reload() {
    table.ajax.reload(null, false); //reload datatable ajax
}

function reload_page() {
    location.reload(); //reload page
}

function add() {
    save_method = 'add';
    $('#form')[0].reset();
    $('#modal_form').modal('show');
    $('.modal-title').text('Tambah topik');
}

function subtopik(kode) {
    window.location.href = "<?php echo base_url(); ?>subtopik/detil/" + kode;
}

function save() {
    var role = "<?= $role; ?>";
    var kode = document.getElementById('kode').value;
    var nama = document.getElementById('nama').value;
    var best = document.getElementById('best').value;
    var code = document.getElementById('code').value;
    var school_name = document.getElementById('school_name').value;
    var idinstansi = document.getElementById('idinstansi').value;


    if (nama === '') {
        alert("Nama topik tidak boleh kosong");
    } else {

        // console.log(nama + "\n" + code + "\n" + school_name)

        // $('#btnSave').text('Menyimpan...'); //change button text
        // $('#btnSave').attr('disabled', true); //set button disable 

        var url = "";
        if (save_method === 'add') {
            if (role === 'R00004') {

                // Pengecekan jumlah siswa di sini
                var topik = <?= $jml_topik; ?>;

                if (topik >= 1) {

                    alert("Anda hanya bisa membuat 1 topik, Hubungi Admin untuk info selengkapnya.");
                    $('#modal_form').modal('hide');
                    reload_page();
                } else {
                    url = "<?php echo base_url(); ?>topik/ajax_add";
                }
            } else {
                url = "<?php echo base_url(); ?>topik/ajax_add";
            }

        } else {
            url = "<?php echo base_url(); ?>topik/ajax_edit";
        }

        var form_data = new FormData();
        form_data.append('kode', kode);
        form_data.append('code', code);
        form_data.append('best', best);
        form_data.append('nama', nama);
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
    if (confirm("Apakah anda yakin menghapus topik " + nama +
            " ini ? \n*Semua data terkait akan terhapus (subtopik / soal)*")) {
        $.ajax({
            url: "<?php echo base_url(); ?>topik/hapus/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                alert(data.status);
                reload();
                reload_page()
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
    $('.modal-title').text('Ganti topik');
    $.ajax({
        url: "<?php echo base_url(); ?>topik/ganti/" + id,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
            $('[name="kode"]').val(data.idtopik);
            $('[name="code"]').val(data.code);
            $('[name="best"]').val(data.best);
            $('[name="nama"]').val(data.nama);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error get data');
        }
    });
}

function closemodal() {
    $('#modal_form').modal('hide');
    reload_page();
}
</script>

<section class="section">
    <div class="row-btn">
        <ol class="breadcrumb bg-white d-flex align-items-end">

            <h5 class="me-1 mb-0">Topik dan Subtopik</h5><small>Maintenance data topik & subtopik</small>
        </ol>

    </div>
    <div class="card shadow-leap p-3">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="card-header">
                    <button type="button" class="btn btn-primary btn-sm" onclick="add();">Tambah Topik</button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="reload_page();">Reload</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tb" class="display text-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Topik</th>
                                    <th>Sub topik</th>
                                    <th style="text-align: center;">Tambah Sub topik</th>
                                    <th style="text-align: center;">Aksi</th>
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
                    <input type="hidden" name="idinstansi" id="idinstansi" value="<?= $idinstansi; ?>">
                    <input type="hidden" name="school_name" id="school_name" value="<?= $school_name; ?>">
                    <input type="hidden" value="<?= $jml_topik; ?>">
                    <div class="form-group row">
                        <label for="code" class="col-sm-3 control-label">Kode topik</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="code" name="code"
                                placeholder="Masukkan kode topik disini" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama" class="col-sm-3 control-label">Nama topik</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="nama" name="nama"
                                placeholder="Masukkan topik disini" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="best" class="col-sm-3 control-label">Urutan</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="best" name="best">
                        </div>
                    </div>
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