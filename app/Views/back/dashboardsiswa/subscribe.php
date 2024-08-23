<?= $this->extend('back/dashboardsiswa/default') ?>

<?= $this->section('content') ?>
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

    <!-- Message -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="shadow-leap fade show" id="flashMessage">
            <?= session()->getFlashdata('error'); ?>
        </div>

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
                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                <div class="pricing-item-label">1 user agent</div>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                <div class="pricing-item-label">Core features</div>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                <div class="pricing-item-label">1GB storage</div>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                <div class="pricing-item-label">2 Custom domain</div>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-item-icon bg-danger text-white"><i class="fas fa-times"></i></div>
                                <div class="pricing-item-label">Live Support</div>
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
                        Member - Local Teacher
                    </div>
                    <div class="pricing-padding">
                        <div class="pricing-price">
                            <div>$60</div>
                            <div>per month</div>
                        </div>
                        <div class="pricing-details">
                            <div class="pricing-item">
                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                <div class="pricing-item-label">5 user agent</div>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                <div class="pricing-item-label">Core features</div>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                <div class="pricing-item-label">10GB storage</div>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                <div class="pricing-item-label">10 Custom domain</div>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                <div class="pricing-item-label">24/7 Support</div>
                            </div>
                        </div>
                    </div>
                    <div class="pricing-cta">
                        <a href="#">Subscribe <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 col-lg-4">
                <div class="pricing pricing-highlight shadow-leap">
                    <div class="pricing-title">
                        Member - Native Teacher
                    </div>
                    <div class="pricing-padding">
                        <div class="pricing-price">
                            <div>$80</div>
                            <div>per month</div>
                        </div>
                        <div class="pricing-details">
                            <div class="pricing-item">
                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                <div class="pricing-item-label">10 user agent</div>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                <div class="pricing-item-label">Core features</div>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                <div class="pricing-item-label">100GB storage</div>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                <div class="pricing-item-label">100 Custom domain</div>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                <div class="pricing-item-label">24 Support</div>
                            </div>
                        </div>
                    </div>
                    <div class="pricing-cta">
                        <a href="#">Subscribe <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>