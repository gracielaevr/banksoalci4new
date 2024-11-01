<script>
function local() {
    $('#modal_local').modal('show');
    $('.modal-title').text('Local Package');

    var modal = document.getElementById('subModal') ?? '';
    modal.style.display = 'none';
}

function international() {
    $('#modal_international').modal('show');
    $('.modal-title').text('International Package');

    var modal = document.getElementById('subModal') ?? '';
    modal.style.display = 'none';
}

function showLocalDetails() {
    const paketSesi = document.getElementById("paketLocal").value;
    let detail = '';

    switch (paketSesi) {
        case '0':
            detail = 'Rp 1000<br>Masa Aktif: 1 Hari';
            break;
        case '1':
            detail = 'Rp 63,000<br>Masa Aktif: 1 Minggu';
            break;
        case '4':
            detail = 'Rp 242,000<br>Masa Aktif: 1 Bulan';
            break;
        case '8':
            detail = 'Rp 460,000<br>Masa Aktif: 2.5 Bulan';
            break;
        case '15':
            detail = 'Rp 811,000<br>Masa Aktif: 4 Bulan';
            break;
        default:
            detail = '';
    }

    document.getElementById("paketLocalDetail").innerHTML = detail;
}

function showInternationalDetails() {
    const paketSesi = document.getElementById("paketInternational").value;
    let detail = '';

    switch (paketSesi) {
        case '0':
            detail = 'Rp 1000<br>Masa Aktif: 1 Hari';
            break;
        case '1':
            detail = 'Rp 75,000<br>Masa Aktif: 1 Minggu';
            break;
        case '4':
            detail = 'Rp 288,000<br>Masa Aktif: 1 Bulan';
            break;
        case '8':
            detail = 'Rp 548,000<br>Masa Aktif: 2.5 Bulan';
            break;
        case '15':
            detail = 'Rp 965,000<br>Masa Aktif: 4 Bulan';
            break;
        default:
            detail = '';
    }

    document.getElementById("paketInternationalDetail").innerHTML = detail;
}

function save(packageType) {
    const idusers = document.getElementById("idusers").value;
    const email = document.getElementById("email").value;
    const wa = document.getElementById("wa").value;
    const name = document.getElementById("nama").value; // Ambil nama dari input

    // Tentukan paket dan sesi yang dipilih berdasarkan tipe paket (Native atau International)
    const paketSesi = packageType === 'Local Package' ? document.getElementById("paketLocal").value :
        document.getElementById("paketInternational").value;

    if (!paketSesi) {
        alert("Please select a session!");
        return;
    } else if (!packageType) {
        alert("Silakan pilih paket!");
        return;
    } else if (!name) {
        alert("Silakan masukkan nama!");
        return;
    } else if (!email) {
        alert("Silakan masukkan email!");
        return;
    } else if (!wa) {
        alert("Silakan masukkan nomor whatsapp!");
        return;
    }



    var form_data = new FormData();
    form_data.append('idusers', idusers);
    form_data.append('name', name);
    form_data.append('email', email);
    form_data.append('mobile', wa);
    form_data.append('paket', packageType);
    form_data.append('sesi', paketSesi);


    console.log("idusers: " + form_data.get('idusers'));
    console.log("name: " + form_data.get('name'));
    console.log("email: " + form_data.get('email'));
    console.log("mobile: " + form_data.get('mobile'));
    console.log("paket: " + form_data.get('paket'));
    console.log("sesi: " + form_data.get('sesi'));



    // Kirim data ke controller dengan AJAXs
    $.ajax({
        url: '<?= base_url() ?>payment/createInvoice',
        dataType: 'TEXT',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'POST',
        success: function(response) {
            response = JSON.parse(response);
            if (response.error) {
                alert("Payment failed: " + (response.message || "Please try again."));
            } else {
                window.location.href = response.invoice_url;
            }
        },
        error: function(xhr) {
            alert("Error occurred: " + xhr.status + " " + xhr.statusText);
        }
    });
}

function test() {
    window.location.href = '<?= base_url() ?>payment/index';
}

function openmodal_subs() {
    var modal = document.getElementById('subModal');
    modal.style.display = 'block';
}
</script>

<!-- <button class"btn btn-primary m-3" onclick="test()">Test Xeendit</button> -->

<section class="section">
    <div class="row">
        <div class="col-xl-12 col-sm-12 mb-3">
            <div class="card shadow-leap">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8 welcome-leap">
                            <h5 class="m-0">Subscribe</h5>
                        </div>
                        <div class="col-4 welcome-leap text-end">
                            <span id="current-day"></span>, <span id="current-date"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (session()->getFlashdata('notification_free')): ?>
    <marquee behavior="scroll" direction="left" class="text-danger">
        <?= session()->getFlashdata('notification_free'); ?>
    </marquee>
    <?php endif; ?>


    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-4 col-lg-4">
                <div class="pricing shadow-leap">
                    <div class="pricing-title">
                        Free
                    </div>
                    <div class="pricing-padding">
                        <div class="pricing-price">
                            <div>$0</div>
                            <div>per month</div>
                        </div>
                        <div class="pricing-details">
                            <div class="pricing-item">
                                <div class="pricing-item-icon col-2 me-3"><i class="fas fa-check"></i></div>
                                <div class="pricing-item-label col-10">Access unlimited English questions on a variety
                                    of topics.
                                </div>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-item-icon col-2 me-3"><i class="fas fa-check"></i></div>
                                <div class="pricing-item-label col-10">Know the correct and incorrect answers to each
                                    question. </div>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-item-icon col-2 me-3"><i class="fas fa-check"></i></div>
                                <div class="pricing-item-label col-10">View your question history. </div>
                            </div>
                        </div>
                    </div>
                    <div class="pricing-cta">
                        <a href="#">Your Plan</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4 col-lg-4">
                <div class="pricing pricing-highlight shadow-leap">
                    <div class="pricing-title">
                        Member - Local Package
                    </div>
                    <div class="pricing-padding">
                        <div class="pricing-price">
                            <div>$60</div>
                            <div>per month</div>
                        </div>
                        <div class="pricing-details">
                            <div class="pricing-item">
                                <div class="pricing-item-icon col-2 me-3"><i class="fas fa-check"></i></div>
                                <div class="pricing-item-label col-10">All the benefits that come with the Free package
                                </div>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-item-icon col-2 me-3"><i class="fas fa-check"></i></div>
                                <div class="pricing-item-label col-10">Discussion of desired topics with expert teachers
                                    from Leap English and Digital Class.</div>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-item-icon col-2 me-3"><i class="fas fa-check"></i></div>
                                <div class="pricing-item-label col-10">Free choice of topics, according to the questions
                                    that are not understood.</div>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-item-icon col-2 me-3"><i class="fas fa-check"></i></div>
                                <div class="pricing-item-label col-10">Flexible schedule, adjusted to the teacher's
                                    availability.</div>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-item-icon col-2 me-3"><i class="fas fa-check"></i></div>
                                <div class="pricing-item-label col-10">1 session lasts 25 minutes for each meeting.
                                </div>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-item-icon col-2 me-3"><i class="fas fa-check"></i></div>
                                <div class="pricing-item-label col-10">Choice of 1, 4, 8, or 15 sessions with a suitable
                                    active period.</div>
                            </div>
                        </div>
                    </div>
                    <div class="pricing-cta">
                        <a class="cursor-pointer" onclick="local()">Subscribe <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4 col-lg-4">
                <div class="pricing pricing-highlight shadow-leap">
                    <div class="pricing-title">
                        Member - International Package
                    </div>
                    <div class="pricing-padding">
                        <div class="pricing-price">
                            <div>$80</div>
                            <div>per month</div>
                        </div>
                        <div class="pricing-details">
                            <div class="pricing-item">
                                <div class="pricing-item-icon col-2 me-3"><i class="fas fa-check"></i></div>
                                <div class="pricing-item-label col-10">All the benefits that come with the Free package
                                </div>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-item-icon col-2 me-3"><i class="fas fa-check"></i></div>
                                <div class="pricing-item-label col-10">Discussion of desired topics directly with
                                    Foreign Teachers.</div>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-item-icon col-2 me-3"><i class="fas fa-check"></i></div>
                                <div class="pricing-item-label col-10">Free choice of topics, according to the questions
                                    that are not understood</div>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-item-icon col-2 me-3"><i class="fas fa-check"></i></div>
                                <div class="pricing-item-label col-10">Flexible schedule, adjusted to the teacher's
                                    availability</div>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-item-icon col-2 me-3"><i class="fas fa-check"></i></div>
                                <div class="pricing-item-label col-10">1 session lasts 25 minutes for each meeting.
                                </div>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-item-icon col-2 me-3"><i class="fas fa-check"></i></div>
                                <div class="pricing-item-label col-10">Choice of 1, 4, 8, or 15 sessions with a suitable
                                    active period. </div>
                            </div>
                        </div>
                    </div>
                    <div class="pricing-cta">
                        <a class="cursor-pointer" onclick="international()">Subscribe <i
                                class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Modal Local -->
<div class="modal fade" id="modal_local" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                <form id="form_local" class="form-horizontal">
                    <div class="form-group row">
                        <input type="hidden" name="idusers" id="idusers" value="<?= $idusers ?>">
                        <input type="hidden" name="email" id="email" value="<?= $pro->email ?>">
                        <input type="hidden" name="wa" id="wa" value="<?= $pro->wa ?>">
                        <input type="hidden" name="nama" id="nama" value="<?= $pro->nama ?>">

                        <label for="paketLocal" class="control-label">Silahkan pilih sesi Local</label>
                        <div class="col-sm-12">
                            <select class="form-control" id="paketLocal" onchange="showLocalDetails()">
                                <option value="">Pilih Paket Local</option>
                                <option value="0">Test Sesi</option>
                                <option value="1">1 Sesi</option>
                                <option value="4">4 Sesi</option>
                                <option value="8">8 Sesi</option>
                                <option value="15">15 Sesi</option>
                            </select>
                        </div>
                    </div>
                    <div id="paketLocalDetail" class="mb-3 text-center"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn text-white bg-secondary" data-bs-dismiss="modal">Close</button>
                <button id="btnSaveLocal" type="button" class="btn text-white bg-primary text-normal"
                    onclick="save('Local Package')">Checkout</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal International -->
<div class="modal fade" id="modal_international" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                <form id="form_international" class="form-horizontal">
                    <div class="form-group row">
                        <input type="hidden" name="idusers" id="idusers" value="<?= $idusers ?>">
                        <input type="hidden" name="email" id="email" value="<?= $pro->email ?>">
                        <input type="hidden" name="wa" id="wa" value="<?= $pro->wa ?>">
                        <input type="hidden" name="nama" id="nama" value="<?= $pro->nama ?>">

                        <label for="paketInternational" class="control-label">Silahkan pilih sesi International</label>
                        <div class="col-sm-12">
                            <select class="form-control" id="paketInternational" onchange="showInternationalDetails()">
                                <option value="">Pilih Paket International</option>
                                <option value="0">Test Sesi</option>
                                <option value="1">1 Sesi</option>
                                <option value="4">4 Sesi</option>
                                <option value="8">8 Sesi</option>
                                <option value="15">15 Sesi</option>
                            </select>
                        </div>
                    </div>
                    <div id="paketInternationalDetail" class="mb-3 text-center"></div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn text-white bg-secondary" data-bs-dismiss="modal">Close</button>
                <button id="btnSaveInternational" type="button" class="btn text-white bg-primary text-normal"
                    onclick="save('International Package')">Checkout</button>
            </div>
        </div>

    </div>
</div>