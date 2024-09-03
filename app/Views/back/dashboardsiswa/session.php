<section class="section">
    <div class="row">
        <div class="col-xl-12 col-sm-12 mb-4">
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

    <div class="section-body">
        <div class="col-12 text-center">
            <i class="fa-solid fa-arrow-right-long me-3 animate-arrow text-primary  arrow-large"></i>
            <a href="<?= base_url() ?>session/session_bokked" class="btn btn-primary shadow-leap">Booking Now</a>
            <i class="fa-solid fa-arrow-left-long ms-3 animate-arrow text-primary  arrow-large"></i>

        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <h6 class="section-title">Upcoming Session</h6>
                <div class="card shadow-leap">
                    <div class="card-header-centered pt-3 pb-0 ps-0 pe-0">
                        <h4>Third Session</h4>
                        <div style="border-top: 3px solid blue; width: 30%; border-radius: 50px"></div>


                    </div>
                    <div class="card-body align-items-center card-300">
                        <div class="table-responsive">

                            <?php if (!empty($data_upcoming)): ?>
                            <?php foreach ($data_upcoming as $booking): ?>
                            <p><i class=" fas fa-calendar-alt me-3"></i>
                                <?= date('l, d F Y', strtotime($booking->tanggal)) ?></p>
                            <p><i class="far fa-clock me-3"></i> <?= date('H:i', strtotime($booking->waktu)) ?> -
                                <?= $booking->waktu_akhir ?></p>
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
                                    <?php if (!empty($data_done)) : ?>
                                    <!-- <php $no = 1; ?> -->
                                    <?php foreach ($data_done as $booking): ?>
                                    <tr>
                                        <!-- <th scope="row"><= $no ?></th> -->
                                        <td><?= date('d F Y', strtotime($booking->tanggal)) ?></td>
                                        <td><?= $booking->guru ?></td>
                                        <td>
                                            <div class="badge badge-success">Done</div>
                                        </td>
                                        <td>
                                            <a href="<?php base_url() ?>session/session_detail/<?= $booking->idkonsultasi ?>"
                                                class="badge badge-primary">Detail</a>
                                            <!--  -->

                                        </td>
                                    </tr>
                                    <!-- <php $no++; ?> -->
                                    <?php endforeach; ?>
                                    <?php else : ?>
                                    <tr>
                                        <td colspan="5" class="text-center pt-3">No completed sessions.</td>
                                    </tr>
                                    <?php endif ?>
                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <h6 class="section-title">Session Remains</h6>
            <div class="card shadow-leap ">
                <div class="card-header-centered pt-3 pb-0 ps-0 pe-0">
                    <h4>2 Sessions Remains</h4>
                    <div style="border-top: 3px solid blue; width: 30%; border-radius: 50px"></div>


                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm text-center align-items-center">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Teacher</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_booking as $booking): ?>
                                <tr>
                                    <th scope="row"><?= $no ?></th>
                                    <td><?= date('d F Y', strtotime($booking->tanggal)) ?></td>
                                    <td><?= $booking->guru ?></td>
                                    <td>
                                        <div class="badge badge-info">Upcoming</div>
                                    </td>
                                </tr>
                                <?php $no++; ?>
                                <?php endforeach; ?>



                                <!-- Menampilkan sesi yang belum dibooking -->
                                <?php for ($i = 0; $i < $remaining_sessions; $i++): ?>
                                <tr>
                                    <th scope="row"><?= $no ?></th>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>
                                        <div class="badge badge-danger text-center">Not Scheduled</div>
                                    </td>
                                </tr>
                                <?php $no++; ?>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
</section>