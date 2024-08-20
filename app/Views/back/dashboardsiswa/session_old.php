<?= $this->extend('back/dashboardsiswa/default') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>Session
        </h1>
        <div class="date-box section-header-breadcrumb">
            <p><span id="current-day"></span>, <span id="current-date"></span></p>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-md-6">
                <h4 class="section-title">Upcoming Session</h4>
                <div class="card card-300">
                    <div class="card-header-centered">
                        <h4>Third Session</h4>
                    </div>
                    <div class="card-body">
                        <p><i class="fas fa-calendar-alt"></i> Wed, 27 September 2023</p>
                        <p><i class="far fa-clock"></i> 09.00 A.M - 10.30 P.M</p>
                        <p><i class="fas fa-map-marker-alt"></i> Online</p>
                        <p><i class="fas fa-user"></i></i> Mr. ...</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h4 class="section-title">Session History</h4>
                <div class="card card-300">
                    <div class="card-header-centered">
                        <h4>History Table</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Teacher</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>10 June 2023</td>
                                    <td>Mr. Budiman</td>
                                    <td>
                                        <div class="badge badge-success">Done</div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>15 June 2023</td>
                                    <td>Mr. Budiman</td>
                                    <td>
                                        <div class="badge badge-success">Done</div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>20 June 2023</td>
                                    <td>Mr. Budiman</td>
                                    <td>
                                        <div class="badge badge-success">Done</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h4 class="section-title">Session Remains</h4>
                <div class="card card-300">
                    <div class="card-header-centered">
                        <h4>2 Sessions Remains</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Teacher</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>23 June 2023</td>
                                    <td>Mr. Budiman</td>
                                    <td>
                                        <div class="badge badge-info">Upcoming</div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>
                                        <div class="badge badge-danger">Not Scheduled Yet</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>