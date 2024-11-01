<script>
    var table;

    $(document).ready(function () {
        // new DataTable('#tb');
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>session/ajaxlist2",
            scrollx: true,
            responsive: true
        });

    });

    function openmodal_subs() {
        var modal = document.getElementById('subModal');
        modal.style.display = 'block';
    }
</script>

<?php include('modal.php'); ?>
<section class="section">
    <div class="row">
        <div class="col-xl-12 col-sm-12 mb-3">
            <div class="card shadow-leap">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8 welcome-leap">
                            <h5 class="m-0">Session</h5>
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

        <div class="col-12">
            <div class="col-12 text-center">
                <h5>Session Subscribe : <?= $paket ?></h5>
                <?php
                if ($pakethabis == true): ?>
                    <p class="text-danger"><?= session()->getFlashdata('notification_expired'); ?></p>
                    <button onclick="openmodal_subs();" type="button" class="btn btn-primary shadow-leap">Subscribe</button>
                <?php else: ?>
                    <p><?= $detail ?> (<?= $subs->tgl_langganan ?? 'N/A' ?> - <?= $subs->tgl_berakhir ?? 'N/A' ?>)</p>
                    <p>Jumlah Sesi : <?= $sesi ?></p>
                    <i class="fa-solid fa-arrow-right-long me-3 animate-arrow text-primary arrow-large"></i>
                    <a href="<?= base_url() ?>session/session_bokked" class="btn btn-primary shadow-leap">Booking Now</a>
                    <i class="fa-solid fa-arrow-left-long ms-3 animate-arrow text-primary arrow-large"></i>
                <?php endif; ?>
            </div>
        </div>


        <!-- Table History & Upcoming -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <h6 class="section-title">Upcoming Session</h6>
                <div class="card shadow-leap">
                    <div class="card-header-centered pt-3 pb-0 ps-0 pe-0">
                        <h4>Upcoming Session</h4>
                        <div style="border-top: 3px solid blue; width: 30%; border-radius: 50px"></div>


                    </div>
                    <div class="card-body align-items-center card-300">
                        <div class="table-responsive">

                            <?php if (!empty($data_upcoming)): ?>
                                <?php foreach ($data_upcoming as $booking): ?>
                                    <p><i class=" fas fa-calendar-alt me-3"></i>
                                        <?= date('l, d F Y', strtotime($booking->tanggal)) ?></p>
                                    <p><i class="far fa-clock me-3"></i> <?= date('H:i', strtotime($booking->waktu)) ?> -
                                        <?= $booking->waktu_akhir ?>
                                    </p>
                                    <p style="width: 85%;" class="d-flex align-items-center"><i
                                            class="fas fa-map-marker-alt me-3"></i><a href="<?= $booking->linkzoom ?>"
                                            target="_blank" class="text-primary ">
                                            <?= $booking->linkzoom ?></a></p>
                                    <p><i class="fas fa-user me-3"></i> <?= $booking->guru ?></p>
                                    <hr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-center">No upcoming sessions.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <h6 class="section-title">Session History</h6>
                <div class="card shadow-leap">
                    <div class="card-header-centered pt-3 pb-0 ps-0 pe-0">
                        <h4>History Table</h4>
                        <div style="border-top: 3px solid blue; width: 30%; border-radius: 50px"></div>

                    </div>
                    <div class="card-body <?= empty($data_done) ? 'card-300' : '' ?>">
                        <div class=" table-responsive">
                            <table class="table table-sm text-center align-items-center">
                                <thead>
                                    <tr>
                                        <!-- <th scope="col">#</th> -->
                                        <th scope="col">Date</th>
                                        <th scope="col">Teacher</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($data_done)): ?>
                                        <?php foreach ($data_done as $session): ?>
                                            <tr>
                                                <td><?= date('l, d F Y', strtotime($session->tanggal)) ?></td>
                                                <td><?= $session->guru ?></td>
                                                <td>
                                                    <div class="badge badge-success">Completed</div>
                                                </td>
                                                <td>
                                                    <a href="<?php base_url() ?>session/session_detail/<?= $session->idkonsultasi ?>"
                                                        class="badge badge-primary">Detail</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center pt-3">No session history available.</td>
                                        </tr>
                                    <?php endif ?>
                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>
            </div>
        </div>

        <!-- Table remaining -->
        <div class="col-md-12 mb-3">
            <h6 class="section-title">Session Remains</h6>
            <div class="card shadow-leap ">
                <!-- <div class="card-header-centered pt-3 pb-0 ps-0 pe-0">
                    <h4>2 Sessions Remains</h4>
                    <div style="border-top: 3px solid blue; width: 30%; border-radius: 50px"></div>

                </div> -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tb" class="display">
                            <thead>

                                <tr>
                                    <th style="text-align:center;">#</th>
                                    <th style="text-align:center;">Date</th>
                                    <th style="text-align:center;">Time</th>
                                    <th style="text-align:center;">Status</th>
                                </tr>
                            </thead>
                            <tbody style="border-bottom: none; text-align:center;">

                                <!-- Data akan dimuat melalui AJAX -->
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>


    </div>
    <!-- </div> -->
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