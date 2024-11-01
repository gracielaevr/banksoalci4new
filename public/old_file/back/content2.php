<div class="content-wrapper">
    <section class="content-header">
        <h1>Beranda <small></small></h1>
        <ol class="breadcrumb">
            <li class="active">Beranda</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12">
                <div class="box">
                    <div class="box-body" style="text-align: center;">
                        <h1>Bank Soal</h1>
                        <h3>LEAP English And Digital</h3>
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
    </section>
</div>