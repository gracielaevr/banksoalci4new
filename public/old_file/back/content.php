<section class="section">
    <div class="row-btn">
        <ol class="breadcrumb bg-white d-flex align-items-end">
            <h5 class="me-1 mb-0">Beranda</h5><small>Beranda</small>
        </ol>

    </div>

    <div class="card shadow-leap p-3">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12">
                <div>
                    <div class="" style="text-align: center;">
                        <h2>Bank Soal</h2>
                        <h4>LEAP English And Digital</h4>
                        <img src="<?php echo base_url(); ?>front/images/leapverse.png"
                            style="width: 200px; height: auto; margin-top: 20px;">
                        <p style="margin-top: 50px;"><?php echo $alamat . ' - '; ?><a target="_blank"
                                href="<?php echo $website; ?>"><?php echo $website; ?></a></p>
                        <p style="margin-top: 5px;"><?php echo "Telp : " . $tlp;
                                                    if (strlen($fax) > 0) {
                                                        echo ', Fax : ' . $fax;
                                                    } ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>