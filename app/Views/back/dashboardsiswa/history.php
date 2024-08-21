<?= $this->extend('back/dashboardsiswa/default') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="row">
        <div class="col-xl-12 col-sm-12 mb-4">
            <div class="card shadow-leap">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8 welcome-leap">
                            <h5 class="m-0">History</h5>
                        </div>
                        <div class="col-4 welcome-leap text-end">
                            <span id="current-day"></span>, <span id="current-date"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card p-3 shadow-leap">
        <div class="card-header d-flex justify-content-between">
            <h5>History Table</h5>
            <div class="card-header-form">
                <form>
                    <div class="input-group">
                        <input type="text" class="form-control m-0" placeholder="Search">
                        <div class="input-group-btn">
                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped text-center align-items-center">
                    <tr class="text-start">
                        <th>SubTopic</th>
                        <th>Topic</th>
                        <th>Date</th>
                        <th>Grade</th>
                        <th>Action</th>
                    </tr>
                    <tr class="fst-normal">
                        <td>Create a mobile app</td>
                        <td>Create a mobile app</td>
                        <td>2018-01-20</td>
                        <td>
                            <div class="badge badge-success">80</div>
                        </td>
                        <td><a href="#" class="btn btn-secondary m-0 disabled">Detail</a></td>
                    </tr>
                    <tr>
                        <td>Create a mobile app</td>
                        <td>Create a mobile app</td>
                        <td>2018-01-20</td>
                        <td>
                            <div class="badge badge-success">80</div>
                        </td>
                        <td><a href="#" class="btn btn-secondary m-0 disabled">Detail</a></td>
                    </tr>
                    <tr>
                        <td>Create a mobile app</td>
                        <td>Create a mobile app</td>
                        <td>2018-01-20</td>
                        <td>
                            <div class="badge badge-success">80</div>
                        </td>
                        <td><a href="#" class="btn btn-secondary m-0 disabled">Detail</a></td>
                    </tr>
                    <tr>
                        <td>Create a mobile app</td>
                        <td>Create a mobile app</td>
                        <td>2018-01-20</td>
                        <td>
                            <div class="badge badge-success">80</div>
                        </td>
                        <td><a href="#" class="btn btn-secondary m-0 disabled">Detail</a></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</section>
<?= $this->endSection() ?>