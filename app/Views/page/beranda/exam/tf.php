<div class="menu-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="navigation">
                    <div class="logo-das">
                        <a href="<?php echo base_url(); ?>/"><img
                                src="<?php echo base_url(); ?>/front/images/leapverse.png" class="img-fluid"
                                alt="logo-das" style="height: 70px;"></a>
                    </div>
                    <div class="nav-btns">
                        <a href="<?php echo base_url(); ?>/" class="get">Back to Main</span> Home</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="ugf-dontation-wrap">
                    <div class="ugf-donation">
                        <div class="ugf-form-card">
                            <div class="card-header">
                                <div class="covid-wrap">
                                    <div class="covid-header">
                                        <h2><?php echo $subtopik; ?> Excercise</h2>
                                        <input type="hidden" id="idsubtopik" name="idsubtopik"
                                            value="<?php echo $kode; ?>">
                                        <span class="step-count"><?php echo $topik; ?></span>
                                        <input type="hidden" id="idtopik" name="idtopik"
                                            value="<?php echo $idtopik; ?>">
                                    </div>
                                    <div class="form">
                                        <div class="covid-test-wrap test-step active">
                                            <?php $i = 1;
                                            foreach ($soal->getResult() as $row) {
                                                if ($row->gambar != null) {
                                                    $def_foto = base_url() . '/images/noimg.jpg';
                                                    $foto = $model->getAllQR("select gambar from soal where idsoal = '" . $row->idsoal . "';")->gambar;
                                                    if (strlen($foto) > 0) {
                                                        if (file_exists($modul->getPathApp() . $foto)) {
                                                            $def_foto = base_url() . '/uploads/' . $foto;
                                                        }
                                                    } ?>
                                                    <img src="<?php echo $def_foto; ?>" height="150px">
                                                <?php }
                                                if ($row->link != '') { ?>
                                                    <br>
                                                    <iframe class="embed-responsive-item"
                                                        src="<?php echo str_replace('watch?v=', 'embed/', $row->link); ?>?rel=0&mute=0&autoplay=1"
                                                        srcdoc="<style>*{padding:0;margin:0px;overflow:hidden}html,body{height:100%}img,span{position:absolute;width:100%;top:0;bottom:0;margin:auto}span{height:1.5em;text-align:center;font:48px/1.5 sans-serif;color:white;text-shadow:0 0 0.5em black}</style>
                                                    <a href=<?php echo str_replace('watch?v=', 'embed/', $row->link); ?>?rel=0&autoplay=1><img src=<?php $im = str_replace('www', 'img', $row->link);
                                                         echo str_replace('watch?v=', 'vi/', $im); ?>/maxresdefault.jpg><span>▶</span></a>"
                                                        frameborder="0"
                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                        allowfullscreen>
                                                    </iframe>
                                                <?php }
                                                ?>
                                                <input type="hidden" id="kodesoal<?php echo $i; ?>" name="kodesoal[]"
                                                    value="<?php echo $row->idsoal; ?>">
                                                <?php echo str_replace('p>', 'h3>', $row->soal); ?>
                                                <span class="step-count"><?php echo 'Poin : ' . $row->poin; ?></span>
                                                <div class="step-block">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-sm-12">
                                                            <div class="form-group">
                                                                <input type="radio" name="pilihan<?php echo $i; ?>"
                                                                    class="form-control" id="T<?php echo $i; ?>"
                                                                    value="True" required>
                                                                <label for="T<?php echo $i; ?>">True</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-sm-12">
                                                            <div class="form-group">
                                                                <input type="radio" name="pilihan<?php echo $i; ?>"
                                                                    class="form-control" id="F<?php echo $i; ?>"
                                                                    value="False" required>
                                                                <label for="F<?php echo $i; ?>">False</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <span hidden="hidden" style="color: red; margin-top: 0;"
                                                    id="errorsoal<?php echo $i; ?>">* Required</span>
                                                <?php
                                                $i++;
                                            }
                                            ?>
                                        </div>
                                        <input type="hidden" id="jml" value="<?php echo $i; ?>">
                                        <input type="hidden" id="jenis" value="<?php echo $jenis; ?>">
                                        <button id="btnSimpan" class="btn" onclick="simpan();">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="widget" style="min-height: 0;">
                    <div class="social-link">
                        <ul>
                            <li><a target="_blank" href="https://leapverse.leapsurabaya.sch.id/">Leapverse</a></li>
                            <li><a target="_blank" href="https://leapsurabaya.sch.id/"><i class="las la-home"></i></a>
                            </li>
                            <li><a target="_blank" href="https://www.facebook.com/LeapSurabaya/?locale=id_ID"><i
                                        class="lab la-facebook-f"></i></a></li>
                            <li><a target="_blank"
                                    href="https://www.linkedin.com/company/leap-english-digital-class/mycompany/"><i
                                        class="lab la-linkedin-in"></i></a></li>
                            <li><a target="_blank" href="https://www.instagram.com/leapsurabaya/?hl=en"><i
                                        class="lab la-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function simpan() {

        var idsubtopik = document.getElementById('idsubtopik').value;
        var jenis = document.getElementById('jenis').value;
        var idtopik = document.getElementById('idtopik').value;
        var jml = document.getElementById('jml').value;
        var idsoal = $("input[name='kodesoal[]']").map(function () {
            return $(this).val();
        }).get();
        var p1 = $("input[type='radio'][name='pilihan1']:checked").val();
        var p2 = $("input[type='radio'][name='pilihan2']:checked").val();
        var p3 = $("input[type='radio'][name='pilihan3']:checked").val();
        var p4 = $("input[type='radio'][name='pilihan4']:checked").val();
        var p5 = $("input[type='radio'][name='pilihan5']:checked").val();
        var p6 = $("input[type='radio'][name='pilihan6']:checked").val();
        var p7 = $("input[type='radio'][name='pilihan7']:checked").val();
        var p8 = $("input[type='radio'][name='pilihan8']:checked").val();
        var p9 = $("input[type='radio'][name='pilihan9']:checked").val();
        var p10 = $("input[type='radio'][name='pilihan10']:checked").val();

        var temp = '';
        for (let i = 1; i < jml; i++) {
            temp += $("input[type='radio'][name='pilihan" + i + "']:checked").val() + ',';
        }

        const pil = [];
        var tot = 0;
        var firstEmpty = null;
        if (p1 === undefined) {
            document.getElementById("errorsoal1").removeAttribute("hidden");
            // Tentukan soal pertama yang kosong
            if (firstEmpty === null) {
                firstEmpty = i;
            }
        } else {
            document.getElementById("errorsoal1").setAttribute("hidden", "hidden");
            tot += 1;
        }
        if (p2 === undefined) {
            document.getElementById("errorsoal2").removeAttribute("hidden");
            // Tentukan soal pertama yang kosong
            if (firstEmpty === null) {
                firstEmpty = i;
            }
        } else {
            document.getElementById("errorsoal2").setAttribute("hidden", "hidden");
            tot += 1;
        }
        if (p3 === undefined) {
            document.getElementById("errorsoal3").removeAttribute("hidden");
            // Tentukan soal pertama yang kosong
            if (firstEmpty === null) {
                firstEmpty = i;
            }
        } else {
            document.getElementById("errorsoal3").setAttribute("hidden", "hidden");
            tot += 1;
        }
        if (p4 === undefined) {
            document.getElementById("errorsoal4").removeAttribute("hidden");
            // Tentukan soal pertama yang kosong
            if (firstEmpty === null) {
                firstEmpty = i;
            }
        } else {
            document.getElementById("errorsoal4").setAttribute("hidden", "hidden");
            tot += 1;
        }
        if (p5 === undefined) {
            document.getElementById("errorsoal5").removeAttribute("hidden");
            // Tentukan soal pertama yang kosong
            if (firstEmpty === null) {
                firstEmpty = i;
            }
        } else {
            document.getElementById("errorsoal5").setAttribute("hidden", "hidden");
            tot += 1;
        }
        if (p6 === undefined) {
            document.getElementById("errorsoal6").removeAttribute("hidden");
            // Tentukan soal pertama yang kosong
            if (firstEmpty === null) {
                firstEmpty = i;
            }
        } else {
            document.getElementById("errorsoal6").setAttribute("hidden", "hidden");
            tot += 1;
        }
        if (p7 === undefined) {
            document.getElementById("errorsoal7").removeAttribute("hidden");
            // Tentukan soal pertama yang kosong
            if (firstEmpty === null) {
                firstEmpty = i;
            }
        } else {
            document.getElementById("errorsoal7").setAttribute("hidden", "hidden");
            tot += 1;
        }
        if (p8 === undefined) {
            document.getElementById("errorsoal8").removeAttribute("hidden");
            // Tentukan soal pertama yang kosong
            if (firstEmpty === null) {
                firstEmpty = i;
            }
        } else {
            document.getElementById("errorsoal8").setAttribute("hidden", "hidden");
            tot += 1;
        }
        if (p9 === undefined) {
            document.getElementById("errorsoal9").removeAttribute("hidden");
            // Tentukan soal pertama yang kosong
            if (firstEmpty === null) {
                firstEmpty = i;
            }
        } else {
            document.getElementById("errorsoal9").setAttribute("hidden", "hidden");
            tot += 1;
        }
        if (p10 === undefined) {
            document.getElementById("errorsoal10").removeAttribute("hidden");
            // Tentukan soal pertama yang kosong
            if (firstEmpty === null) {
                firstEmpty = i;
            }
        } else {
            document.getElementById("errorsoal10").setAttribute("hidden", "hidden");
            tot += 1;
        }

        if (tot < jml - 1 && firstEmpty !== null) {
            const errorElem = document.getElementById("errorsoal" + firstEmpty);

            if (errorElem) {
                errorElem.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            } else {
                console.error("Elemen error tidak ditemukan untuk soal " + firstEmpty);
            }
        } else {
            var url = "<?php echo base_url(); ?>test/finish";

            var form_data = new FormData();
            form_data.append('idsubtopik', idsubtopik);
            form_data.append('idtopik', idtopik);
            form_data.append('idsoal', idsoal);
            form_data.append('jml', jml);
            form_data.append('jenis', jenis);
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
                success: function (data) {
                    if (data.status === "ok") {
                        window.location.href = "<?php echo base_url(); ?>test/score/" + data.id;
                    }

                    $('#btnSimpan').text('Save'); //change button text
                    $('#btnSimpan').attr('disabled', false); //set button enable 
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error json " + errorThrown);

                    $('#btnSimpan').text('Save'); //change button text
                    $('#btnSimpan').attr('disabled', false); //set button enable 
                }
            });
        }
    }
</script>