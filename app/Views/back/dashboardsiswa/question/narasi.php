<body class="layout-3 ">

    <div id="app">
        <nav class="navbar navbar-expand-lg main-navbar d-flex justify-content-between pt-3 pb-3 ps-5 pe-5 " style="background: rgb(255,255,255);
background: linear-gradient(90deg, rgba(255,255,255,1) 0%, rgba(47,104,170,1) 100%);
">
            <img src="<?= base_url() ?>front/images/leapverse.png" alt="" width="80px">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="ms-3" id="nama"><?= $nama; ?></span>
                        <input type="hidden" name="idusers" id="idusers" value="<?= $idusers ?>">
                        <img src="<?= $foto_profile ?>" class="avatar avatar-sm  ms-3" aria-hidden="true">

                    </a>
                    <ul class="dropdown-menu  dropdown-menu-end  px-2 py-2 me-sm-n2"
                        aria-labelledby="dropdownMenuButton">

                        <li>
                            <a class="dropdown-item border-radius-md" href="<?= base_url() ?>profilestudent">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <i class="ni ni-single-02 text-success me-3"></i>Profile
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item border-radius-md" href="<?= base_url() ?>logout">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <i class="ni ni-bold-right text-danger me-3 text-center"></i>Logout
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>

        <nav
            class="navbar navbar-expand-lg navbar-expand-md navbar-expand-sm navbar-expand pt-2 pb-2 ps-5 pe-5 bg-white">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="<?= base_url() ?>homesiswa" class="nav-link text-center"><i
                            class="ni ni-tv-2 text-primary text-sm opacity-10 me-2"></i><span>Dashboard</span></a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url() ?>history" class="nav-link text-center"><i
                            class="ni ni-bullet-list-67 text-warning text-sm opacity-10 me-2"></i><span>History</span></a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url() ?>session" class="nav-link text-center"><i
                            class="ni ni-app text-info text-sm opacity-10 me-2"></i><span>Session</span></a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url() ?>subscribe" class="nav-link text-center"><i
                            class="ni ni-like-2 text-danger text-sm opacity-10 me-2"></i><span>Subscribe</span></a>
                </li>
            </ul>
        </nav>
        <div class="main-wrapper container">
            <div class="main-concent">
                <section class="section">

                    <div class="section-body mt-4">
                        <div class="card shadow-leap p-3">

                            <div class="card-header d-flex justify-content-between mb-3 topic-column-sm">
                                <h4 style="width:80%"><?php echo $subtopik; ?> Excercise</h4>
                                <input type="hidden" id="idsubtopik" name="idsubtopik"
                                    value="<?php echo $idsubtopik; ?>">
                                <h5 class="text-sm-end" style="color:#a7b2c1"><?php echo $topik; ?></h5>
                                <input type="hidden" id="idtopik" name="idtopik" value="<?php echo $idtopik; ?>">
                            </div>

                            <div class="card-body">
                                <?php
                                echo $narasi . '<br><hr>';
                                $i = 1;
                                foreach ($soal->getResult() as $row) { ?>
                                    <input type="hidden" id="kodesoal<?php echo $i; ?>" name="kodesoal[]"
                                        value="<?php echo $row->idsoal; ?>">
                                    <h3><?php echo str_replace('p>', 'h3>', $row->soal); ?></h3>
                                    <span class="step-count"><?php echo 'Poin : ' . $row->poin; ?></span>
                                    <div class="step-block">
                                        <div class="row">
                                            <?php
                                            $pil = $model->getAllQ("select * from pilihan where idsoal = '" . $row->idsoal . "'");
                                            foreach ($pil->getResult() as $row1) { ?>
                                                <div class="col-lg-6 col-sm-12">
                                                    <div class="form-group">
                                                        <input type="radio" name="pilihan<?php echo $i; ?>" class="form-control"
                                                            id="<?php echo $row1->pilihan . $i; ?>"
                                                            value="<?php echo $row1->idpilihan; ?>" required>
                                                        <label
                                                            for="<?php echo $row1->pilihan . $i; ?>"><?php echo $row1->pilihan; ?></label>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <span hidden="hidden" style="color: red; margin-top: 0;"
                                        id="errorsoal<?php echo $i; ?>">* Required</span>

                                <?php
                                    $i++;
                                }
                                ?>
                                <!-- <div class="card-footer"> -->
                                <input type="hidden" id="jml" value="<?php echo $i; ?>">
                                <button id="btnSimpan" class="btn btn-primary-leap w-100"
                                    onclick="simpan();">Submit</button>
                                <!-- </div> -->
                            </div>





                        </div>
                    </div>

                </section>

            </div>


        </div>
    </div>

    <footer class="footer mt-5 pb-3">
        <hr class="horizontal dark mt-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 d-flex justify-content-between align-items-center">
                    <div class="text-start">
                        Copyright &copy; <?= date("Y"); ?> • <a href=""> Leapverse -
                            Bank Soal.</a> All Rights Reserved
                    </div>
                    <div class="footer-right">
                        2.3.0
                    </div>
                </div>

            </div>
        </div>
    </footer>

    <script type="text/javascript">
        function simpan() {

            var nama = document.getElementById('nama').textContent;
            var idusers = document.getElementById('idusers').value;
            var idsubtopik = document.getElementById('idsubtopik').value;
            var idtopik = document.getElementById('idtopik').value;
            var jml = document.getElementById('jml').value;
            var idsoal = $("input[name='kodesoal[]']").map(function() {
                return $(this).val();
            }).get();
            var p1 = $("input[type='radio'][name='pilihan1']:checked").val();
            var p2 = $("input[type='radio'][name='pilihan2']:checked").val();
            var p3 = $("input[type='radio'][name='pilihan3']:checked").val();
            var p4 = $("input[type='radio'][name='pilihan4']:checked").val();
            var p5 = $("input[type='radio'][name='pilihan5']:checked").val();

            var temp = '';
            for (let i = 1; i < jml; i++) {
                temp += $("input[type='radio'][name='pilihan" + i + "']:checked").val() + ',';
            }

            var tot = 0;
            if (p1 === undefined) {
                document.getElementById("errorsoal1").removeAttribute("hidden");
            } else {
                document.getElementById("errorsoal1").setAttribute("hidden", "hidden");
                tot += 1;
            }
            if (p2 === undefined) {
                document.getElementById("errorsoal2").removeAttribute("hidden");
            } else {
                document.getElementById("errorsoal2").setAttribute("hidden", "hidden");
                tot += 1;
            }
            if (p3 === undefined) {
                document.getElementById("errorsoal3").removeAttribute("hidden");
            } else {
                document.getElementById("errorsoal3").setAttribute("hidden", "hidden");
                tot += 1;
            }
            if (p4 === undefined) {
                document.getElementById("errorsoal4").removeAttribute("hidden");
            } else {
                document.getElementById("errorsoal4").setAttribute("hidden", "hidden");
                tot += 1;
            }
            if (p5 === undefined) {
                document.getElementById("errorsoal5").removeAttribute("hidden");
            } else {
                document.getElementById("errorsoal5").setAttribute("hidden", "hidden");
                tot += 1;
            }



            if (tot < jml - 1) {
                alert("Fill all the question first!");
            } else {
                var url = "<?php echo base_url(); ?>question/finish";

                var form_data = new FormData();
                form_data.append('nama', nama);
                form_data.append('idusers', idusers);
                form_data.append('idsubtopik', idsubtopik);
                form_data.append('idtopik', idtopik);
                form_data.append('idsoal', idsoal);
                form_data.append('jml', jml);
                form_data.append('jawaban', temp);

                // ajax adding data to database
                $.ajax({
                    url: url,
                    dataType: 'JSON',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'POST',
                    success: function(data) {
                        if (data.status === "ok") {
                            window.location.href = "<?php echo base_url(); ?>question/score/" + data.id;
                        }

                        $('#btnSimpan').text('Save'); //change button text
                        $('#btnSimpan').attr('disabled', false); //set button enable 
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert("Error json " + errorThrown);

                        $('#btnSimpan').text('Save'); //change button text
                        $('#btnSimpan').attr('disabled', false); //set button enable 
                    }
                });
            }


        }
    </script>