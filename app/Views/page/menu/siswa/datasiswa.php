<script type="text/javascript">
var save_method; //for save method string
var table;

$(document).ready(function() {

    table = $('#tb').DataTable({
        ajax: "<?php echo base_url(); ?>jadwalkonsultasi/siswalist/",
        scrollX: true,
        responsive: true
    });
    $('#tanggalrange').daterangepicker();
});

function siswa_list(id) {
    window.location.href = "<?php echo base_url(); ?>siswa/siswadetail/" + id;
}

function reload_page() {
    location.reload()
}



function save() {
    var idsession = document.getElementById('idsession').value;
    var catatan = document.getElementById('catatan').value;

    if (catatan === '') {
        alert("Catatan tidak boleh kosong");
    } else {
        $('#btnSave').text('Menyimpan...');
        $('#btnSave').attr('disabled', true);

        url = "<?php echo base_url(); ?>jadwalkonsultasi/ajax_edit1";

        var form_data = new FormData();
        form_data.append('idsession', idsession);
        form_data.append('catatan', catatan);

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
                reload_page();

                $('#btnSave').text('Simpan');
                $('#btnSave').attr('disabled', false);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("Error json " + errorThrown);

                $('#btnSave').text('Simpan');
                $('#btnSave').attr('disabled', false);
            }
        });
    }
}


function openModal(id) {
    $('#form')[0].reset();
    $('#modal_form').modal('show');
    $('.modal-title').text('Note');
    $.ajax({
        url: "<?php echo base_url(); ?>jadwalkonsultasi/ganti1/" + id,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
            $('[name="idsession"]').val(data.idsession);
            $('[name="catatan"]').val(data.catatan);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error get data');
        }
    });
}


function closemodal() {
    $('#modal_form').modal('hide');

}

//Menampilkan Gambar
function zoomImage(imageSrc) {
    const zoomedDiv = document.createElement('div');
    zoomedDiv.classList.add('zoomed');
    zoomedDiv.innerHTML = `
        <img src="${imageSrc}" alt="Zoomed Image" onclick="event.stopPropagation();">
    `;
    document.body.appendChild(zoomedDiv);

    const closeZoomHandler = (event) => {
        if (event.target === zoomedDiv) {
            closeZoom(zoomedDiv, closeZoomHandler);
        }
    };
    document.body.onclick = closeZoomHandler;
}

function closeZoom(zoomedDiv, closeZoomHandler) {
    if (document.body.contains(zoomedDiv)) {
        document.body.removeChild(zoomedDiv);
    }
    document.body.onclick = null; // Hapus listener setelah zoom ditutup
}

document.querySelector('.side-siswa').classList.add('active');
</script>
<style>
.zoomed {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    /* Latar belakang semi-transparan */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    /* Agar gambar di atas konten lain */
}

.zoomed img {
    max-width: 90%;
    /* Batas lebar maksimum gambar */
    max-height: 90%;
    /* Batas tinggi maksimum gambar */
}

.zoomed.active {
    display: flex;
    /* Tampilkan saat aktif */
}
</style>



<section class="section">
    <div class="row-btn">

        <ol class="breadcrumb bg-white d-flex align-items-end">
            <h5 class="me-1 mb-0">Data Siswa</h5><small>Maintenance data siswa</small>
        </ol>
    </div>
    <div class="card shadow-leap p-3">
        <div class="row">
            <div class="col-lg-12 col-xs-12">

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tb" class="display text-sm">
                            <thead>
                                <tr>
                                    <th width="3%">#</th>
                                    <th width="15%">Nama</th>
                                    <th width="15%">Tanggal</th>
                                    <th width="15%">Link Zoom</th>
                                    <th width="15%">Durasi</th>
                                    <th width="10%">Pertanyaan</th>
                                    <th width="10%">Catatan</th>
                                </tr>
                            </thead>
                            <tbody class="t-left" style="border-bottom: none;">

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
                    <input type="hidden" name="idsession" id="idsession">
                    <div class="form-group row">
                        <label class="col-12">Note :</label>
                        <div class="col-12">
                            <textarea style="height: 200px;" class="form-control" id="catatan" name="catatan"
                                placeholder="Enter Your Note...."></textarea>
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

<!-- Modal untuk gambar -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Gambar Pertanyaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="modalImage" src="" class="img-fluid" alt="Gambar Pertanyaan">
            </div>
        </div>
    </div>
</div>