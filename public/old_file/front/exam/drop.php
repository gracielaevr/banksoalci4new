<script type="text/javascript">
    function start(id) {
        window.location.href = "<?php echo base_url(); ?>subtopic/exam/" + id;
    }
</script>
<div class="menu-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="navigation">
                    <div class="logo">
                        <a href="<?php echo base_url(); ?>"><img
                                src="<?php echo base_url(); ?>front/images/leapverse.png" class="img-fluid" alt="logo"
                                style="height: 70px;"></a>
                    </div>
                    <div class="nav-btns">
                        <a href="<?php echo base_url(); ?>" class="get">Back to Main</span> Home</a>
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
                                            ?>
                                                <input type="hidden" id="kodesoal<?php echo $i; ?>" name="kodesoal[]"
                                                    value="<?php echo $row->idsoal; ?>">
                                                <?php echo str_replace('p>', 'h3>', $row->soal); ?>
                                                <span class="step-count"><?php echo 'Poin : ' . $row->poin; ?></span>
                                                <div class="step-block">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-sm-12">
                                                            <div class="form-group">
                                                                <div class="select-input">
                                                                    <span></span>
                                                                    <?php
                                                                    $pil = $model->getAllQ("select * from pilihan where idsoal = '" . $row->idsoal . "'");
                                                                    //dropdown
                                                                    $str = ' <select id="pilihan' . $i . '" name="pilihan' . $i . '" class="form-control">';
                                                                    $str .= '<option value="" disabled selected>Choose..</option>';
                                                                    foreach ($pil->getResult() as $row1) {
                                                                        $str .= '<option value="' . $row1->idpilihan . '">' . $row1->pilihan . '</option>';
                                                                    }
                                                                    $str .= '</select>';
                                                                    echo $str;
                                                                    //end dropdown
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <span hidden="hidden" style="color: red; margin-top: 0;"
                                                    id="errorsoal<?php echo $i; ?>">* Required</span>
                                            <?php
                                                $i++;
                                            } ?>
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
        var idtopik = document.getElementById('idtopik').value;
        var jml = document.getElementById('jml').value;
        var jenis = document.getElementById('jenis').value;
        var idsoal = $("input[name='kodesoal[]']").map(function() {
            return $(this).val();
        }).get();

        const pil = [];

        var tot = 0;
        for (let i = 1; i < jml; i++) {
            pil[i] = document.getElementById('pilihan' + i).value;
            if (pil[i] === '') {
                document.getElementById("errorsoal" + i).removeAttribute("hidden");
            } else {
                document.getElementById("errorsoal" + i).setAttribute("hidden", "hidden");
                tot += 1;
            }
        }

        var temp = '';
        for (let i = 1; i < jml; i++) {
            temp += $("#pilihan" + i + " option:selected").val() + ',';
        }

        if (tot < jml - 1) {
            alert("Fill all the question first!");
        } else {
            var url = "<?php echo base_url(); ?>test/finish";

            var form_data = new FormData();
            form_data.append('idsubtopik', idsubtopik);
            form_data.append('idtopik', idtopik);
            form_data.append('idsoal', idsoal);
            form_data.append('jenis', jenis);
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
                        window.location.href = "<?php echo base_url(); ?>test/score/" + data.id;
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