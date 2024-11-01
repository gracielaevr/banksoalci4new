<?= $this->extend('back/dashboardinstansisiswa/default') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>History
        </h1>
        <div class="date-box section-header-breadcrumb">
            <p><span id="current-day"></span>, <span id="current-date"></span></p>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>History Table</h4>
                <div class="card-header-form">
                    <form>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search">
                            <div class="input-group-btn">
                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>SubTopic</th>
                            <th>Topic</th>
                            <th>Date</th>
                            <th>Grade</th>
                            <th>Action</th>
                        </tr>
                        <tr>
                            <td>Create a mobile app</td>
                            <td>Create a mobile app</td>
                            <td>2018-01-20</td>
                            <td>
                                <div class="badge badge-success">80</div>
                            </td>
                            <td><a href="#" class="btn btn-secondary">Detail</a></td>
                        </tr>
                        <tr>
                            <td>Create a mobile app</td>
                            <td>Create a mobile app</td>
                            <td>2018-01-20</td>
                            <td>
                                <div class="badge badge-success">80</div>
                            </td>
                            <td><a href="#" class="btn btn-secondary">Detail</a></td>
                        </tr>
                        <tr>
                            <td>Create a mobile app</td>
                            <td>Create a mobile app</td>
                            <td>2018-01-20</td>
                            <td>
                                <div class="badge badge-success">80</div>
                            </td>
                            <td><a href="#" class="btn btn-secondary">Detail</a></td>
                        </tr>
                        <tr>
                            <td>Create a mobile app</td>
                            <td>Create a mobile app</td>
                            <td>2018-01-20</td>
                            <td>
                                <div class="badge badge-success">80</div>
                            </td>
                            <td><a href="#" class="btn btn-secondary">Detail</a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
</section>
<?= $this->endSection() ?>