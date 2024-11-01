<script>
function local() {
    save_method = 'local';
    $('#form_local')[0].reset();
    $('#modal_local').modal('show');
    $('.modal-title').text('Local Package');
}

function international() {
    save_method = 'international';
    $('#form_international')[0].reset();
    $('#modal_international').modal('show');
    $('.modal-title').text('International Package');
}

function showLocalDetails() {
    const paketSesi = document.getElementById("paketLocal").value;
    let detail = '';

    switch (paketSesi) {
        case '0':
            detail = 'Rp 1,000<br>Masa Aktif: 1 hari';
            break;
        case '1':
            detail = 'Rp 94,000<br>Masa Aktif: 1 Minggu';
            break;
        case '4':
            detail = 'Rp 357,000<br>Masa Aktif: 1 Bulan';
            break;
        case '8':
            detail = 'Rp 665,000<br>Masa Aktif: 2.5 Bulan';
            break;
        case '15':
            detail = 'Rp 1,134,000<br>Masa Aktif: 4 Bulan';
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
            detail = 'Rp 1,000<br>Masa Aktif: 1 hari';
            break;
        case '1':
            detail = 'Rp 125,000<br>Masa Aktif: 1 Minggu';
            break;
        case '4':
            detail = 'Rp 475,000<br>Masa Aktif: 1 Bulan';
            break;
        case '8':
            detail = 'Rp 883,500<br>Masa Aktif: 2.5 Bulan';
            break;
        case '15':
            detail = 'Rp 1,510,000<br>Masa Aktif: 4 Bulan';
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
    const nama = document.getElementById("nama").value; // Ambil nama dari input

    // Tentukan paket dan sesi yang dipilih berdasarkan tipe paket (Local atau International)
    const paketSesi = packageType === 'Local Package' ? document.getElementById("paketLocal").value :
        document.getElementById("paketInternational").value;

    console.log(idusers + '\n' + email + '\n' + wa + '\n' + nama + '\n' + paketSesi);

    if (!paketSesi) {
        alert("Silakan pilih sesi!");
        return;
    }

    // // Tentukan jumlah pembayaran berdasarkan paket dan sesi yang dipilih
    // let amount = 0;
    // if (packageType === 'Local Package') {
    //     switch (paketSesi) {
    //         case '0':
    //             amount = 1000;
    //             break;
    //         case '1':
    //             amount = 94000;
    //             break;
    //         case '4':
    //             amount = 357000;
    //             break;
    //         case '8':
    //             amount = 665000;
    //             break;
    //         case '15':
    //             amount = 1134000;
    //             break;
    //     }
    // } else if (packageType === 'International Package') {
    //     switch (paketSesi) {
    //         case '0':
    //             amount = 1000;
    //             break;
    //         case '1':
    //             amount = 125000;
    //             break;
    //         case '4':
    //             amount = 475000;
    //             break;
    //         case '8':
    //             amount = 883500;
    //             break;
    //         case '15':
    //             amount = 1510000;
    //             break;
    //     }
    // }

    // if (amount <= 0) {
    //     alert("Jumlah pembayaran tidak valid.");
    //     return;
    // }

    function formatTanggal(tanggal) {
        const hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        let d = new Date(tanggal);

        let hariNama = hari[d.getDay()];
        let tanggalHari = d.getDate();
        let bulanNama = bulan[d.getMonth()];
        let tahun = d.getFullYear();

        let jam = String(d.getHours()).padStart(2, '0');
        let menit = String(d.getMinutes()).padStart(2, '0');

        // Gabungkan semuanya menjadi format yang diinginkan
        return `${hariNama}, ${tanggalHari} ${bulanNama} ${tahun} - ${jam}:${menit} WIB`;
    }

    // Persiapkan data untuk dikirim via AJAX
    const paymentData = {
        idusers: idusers,
        name: nama,
        email: email,
        mobile: wa,
        redirectUrl: "<?= base_url() ?>homesiswa",
        description: "Pembayaran untuk sesi " + paketSesi + " " + packageType,
        expiredAt: formatTanggal(Date.now() + 24 * 60 * 60 * 1000), // 24 jam dari sekarang
        paket: packageType,
        sesi: paketSesi,
    };

    console.log(paymentData);

    // Kirim data ke controller dengan AJAX
    $.ajax({
        url: '<?= base_url() ?>Subscribe/checkout',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(paymentData),
        success: function(response) {
            // if (response.success) {
            //     window.location.href = response.payment_url;
            // } else {
            //     alert("Pembayaran gagal: " + (response.message || "Silakan coba lagi."));
            // }
        },
        error: function(xhr) {
            alert("Terjadi kesalahan: " + xhr.status + " " + xhr.statusText);
        }
    });
}
</script>

<section class="section">
    <div class="row">
        <div class="col-xl-12 col-sm-12 mb-4">
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
                        <input type="hidden" name="email" id="email" value="<?= $email ?>">
                        <input type="hidden" name="wa" id="wa" value="<?= $wa ?>">
                        <input type="hidden" name="nama" id="nama" value="<?= $nama ?>">

                        <label for="paketLocal" class="control-label">Silahkan pilih sesi Local</label>
                        <div class="col-sm-12">
                            <select class="form-control" id="paketLocal" onchange="showLocalDetails()">
                                <option value="">Pilih Paket Local</option>
                                <option value="0">0 Sesi</option>
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
                        <input type="hidden" name="idusers" id="idusers" value="<?php $idusers ?>">
                        <input type="hidden" name="email" id="email" value="<?php $email ?>">
                        <input type="hidden" name="wa" id="wa" value="<?php $wa ?>">
                        <input type="hidden" name="nama" id="nama" value="<?= $nama ?>">

                        <label for="paketInternational" class="control-label">Silahkan pilih sesi International</label>
                        <div class="col-sm-12">
                            <select class="form-control" id="paketInternational" onchange="showInternationalDetails()">
                                <option value="">Pilih Paket International</option>
                                <option value="0">0 Sesi</option>
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