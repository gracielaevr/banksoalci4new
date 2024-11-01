<script>
var table;

$(document).ready(function() {
    // new DataTable('#tb');
    table = $('#tb').DataTable({
        ajax: "<?php echo base_url(); ?>session/ajaxlist",
        scrollx: true,
        responsive: true
    });

});

function closemodal() {
    $('#modal_form').modal('hide');
}

function reload() {
    location.reload(); // Memuat ulang seluruh halaman
}


function openModal(idkonsultasi, tanggal, waktu, guru, catatan, button) {
    save_method = 'add';
    $('#form')[0].reset();
    $('#modal_form').modal('show');
    $('.modal-title').text('Pertanyaan opsional');
    $('#btnSave').data('button', button);
    document.getElementById('idkonsultasi').value = idkonsultasi;
    document.getElementById('tanggal').value = tanggal;
    document.getElementById('waktu').value = waktu;
    document.getElementById('guru').value = guru;
    document.getElementById('catatan').value = catatan;

}


var BASE_URL = "<?php echo base_url(); ?>";
tinymce.init({
    selector: "textarea#pertanyaan",
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

// document.getElementById('file').addEventListener('change', function() {
//     var file = document.getElementById('file').files[0];

//     if (file) {
//         console.log("File selected:", file.name); // Log nama file jika file dipilih
//     } else {
//         console.log("No file selected"); // Log jika tidak ada file yang dipilih
//     }
// });

function save() {
    var idusers = document.getElementById('idusers').value;
    var idkonsultasi = document.getElementById('idkonsultasi').value;
    var guru = document.getElementById('guru').value;
    var catatan = document.getElementById('catatan').value;
    var tanggal = document.getElementById('tanggal').value;
    var waktu = document.getElementById('waktu').value;
    var pertanyaan = tinyMCE.get('pertanyaan').getContent();
    var file = document.getElementById('file').files[0];

    // var gambar = file.name;

    if (pertanyaan === '') {
        alert("Pertanyaan tidak boleh kosong");
    } else if (!file) { // Memeriksa apakah file tidak ada
        alert("File tidak boleh kosong");
    } else {
        $('#btnSave').text('Menyimpan...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 

        console.log(idusers + '\n' + idkonsultasi + '\n' + tanggal + '\n' + guru + '\n' + waktu + '\n' +
            pertanyaan + '\n' +
            file.name);

        var url = "";
        if (save_method === 'add') {
            url = "<?php echo base_url(); ?>session/ajax_add";
        } else {
            console.log('Url tidak di temukan');
        }

        var form_data = new FormData();
        form_data.append('idusers', idusers);
        form_data.append('idkonsultasi', idkonsultasi);
        form_data.append('guru', guru);
        form_data.append('catatan', catatan);
        form_data.append('tanggal', tanggal);
        form_data.append('waktu', waktu);
        form_data.append('pertanyaan', pertanyaan);
        form_data.append('file', file);

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
                tinyMCE.get('pertanyaan').setContent("");

                var button = $('#btnSave').data('button');
                $(button).closest('tr').hide();

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

document.querySelector('.side-session').classList.add('active');
</script>

<section class="section">
    <div class="row">
        <div class="col-xl-12 col-sm-12 mb-4">
            <div class="card shadow-leap">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8 welcome-leap">
                            <h5 class="m-0">Booking Session</h5>
                        </div>
                        <div class="col-4 welcome-leap text-end">
                            <span id="current-day"></span>, <span id="current-date"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section-body">

        <div class="col-md-12 mb-3">
            <div class="card shadow-leap ">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tb" class="display">
                            <thead>

                                <tr>
                                    <th style="text-align:center;">#</th>
                                    <th style="text-align:center;">Date</th>
                                    <th style="text-align:center;">Waktu</th>
                                    <th style="text-align:center;">Action</th>
                                </tr>
                            </thead>
                            <tbody style="border-bottom: none; text-align:center;">

                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>


    </div>
</section>

<div class="modal fade" id="modal_form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Default Modal</h6>
                <button type="button" class="close border-0 bg-transparent" data-dismiss="modal" aria-label="Close"
                    onclick="closemodal()">
                    <span aria-hidden="true" class="text-3xl">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="form" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="idusers" id="idusers" value="<?= $idusers ?>">
                    <input type="hidden" name="idkonsultasi" id="idkonsultasi">
                    <input type="hidden" name="tanggal" id="tanggal">
                    <input type="hidden" name="guru" id="guru">
                    <input type="hidden" name="catatan" id="catatan">
                    <input type="hidden" name="waktu" id="waktu">
                    <div class="form-group row">
                        <label class="col-12">Tulis pertanyaan mu di bawah ini</label>
                        <div class="col-12">
                            <textarea class="form-control" id="pertanyaan" name="pertanyaan"
                                placeholder="Enter Your Question...."></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="file" class="col-sm-3">File</label>
                        <div class="col-12">
                            <!-- <input type="file" class="form-control" id="file" name="file"
                                            placeholder="Masukkan file" autocomplete="off"> -->
                            <input type="file" class="form-control" id="file" name="file" accept="image/*"
                                placeholder="Masukkan file">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnSave" type="button" class="btn btn-sm btn-primary-leap" onclick="save();">Save</button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="closemodal();">Close</button>
            </div>
        </div>
    </div>
</div>