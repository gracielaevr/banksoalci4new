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
                    <thead>
                        <tr class="text-start">
                            <th>Date</th>
                            <th>SubTopic</th>
                            <th>Correct</th>
                            <th>Wrong</th>
                            <th>Score</th>
                        </tr>
                    </thead>
                    <tbody>


                        <?php if (!empty($history_peserta)): ?>
                        <?php foreach ($history_peserta as $item): ?>
                        <tr class="fst-normal">
                            <td><?= $item->created_at ?></td>
                            <?php foreach ($subtopik_nama as $sub): ?>
                            <td><?= $sub->nama ?></td>
                            <?php endforeach; ?>
                            <td><?= $item->benar ?></td>
                            <td><?= $item->salah ?></td>
                            <td>
                                <div class="badge badge-success text-center"><?= $item->poin ?></div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">History Is Empty.</td>
                        </tr>
                        <?php endif; ?>

                    </tbody>

                </table>
            </div>
        </div>
    </div>

</section>