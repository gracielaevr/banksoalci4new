<?= $this->extend('back/dashboardsiswa/default') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>TOPIC : <?= $topik->nama ?>
        </h1>
        <div class="section-header-breadcrumb buttons">
            <a href="<?= base_url('homesiswa') ?>" class="btn btn-icon icon-left btn-primary"><i
                    class="far fa-edit"></i>
                Back to Topic</a>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">Subtopic</h2>
        <div class="row">
            <?php foreach ($subtopics as $subtopic): ?>
            <div class="col-12 col-md-4 col-lg-4">
                <a href="<?= base_url("start/{$subtopic->idsubtopik}") ?>">
                    <div class="card">
                        <div class="card-header-centered">
                            <h4><?= $subtopic->nama ?></h4>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
<?= $this->endSection() ?>