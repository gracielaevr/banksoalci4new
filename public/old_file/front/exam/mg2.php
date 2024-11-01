<script type="text/javascript">
function start(id) {
    window.location.href = "<?php echo base_url(); ?>subtopic/exam/" + id;
}
</script>
<div class="ugf-wraper2">
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
                                            <?php
                                                $text = str_replace('p>', 'h3>', $row->soal);
                                                $pil = $model->getAllQ("select * from pilihan where idsoal = '" . $row->idsoal . "'");
                                                //dropdown
                                                $str = ' <select id="pilihan' . $i . '" name="pilihan' . $i . '[]">';
                                                $str .= '<option value=""></option>';
                                                foreach ($pil->getResult() as $row1) {
                                                    $str .= '<option value="' . $row1->pilihan . '">' . $row1->pilihan . '</option>';
                                                }
                                                $str .= '</select>';
                                                //end dropdon
                                                $txt = str_replace('____', $str, $text);
                                                echo str_replace('_', '', $txt) . '<span class="step-count">Poin : ' . $row->poin . '</span><br><span hidden="hidden" style="color: red; margin-top: 0;" id="errorsoal' . $i . '">* Required</span><hr>';

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
        pil[i] = $("select[name='pilihan" + i + "[]']").map(function() {
            return $(this).val();
        }).toArray();
        if (!pil[i].some(element => element === '') === false) {
            document.getElementById("errorsoal" + i).removeAttribute("hidden");
        } else {
            document.getElementById("errorsoal" + i).setAttribute("hidden", "hidden");
            tot += 1;
        }
    }

    var val1 = '';
    for (let i = 1; i < jml; i++) {
        val1 += $("select[name='pilihan" + i + "[]']").map(function() {
            return $(this).val() + ',';
        }).toArray();
    }


    var c = val1.substring(0, val1.length - 1);
    var d = c.split(",");

    var arr = [];
    for (let i = 0; i < d.length; i++) {
        if (d[i].length > 0) {
            arr.push(d[i]);
        }
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
        form_data.append('jawaban', arr);

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
                    window.location.href = "<?php echo base_url(); ?>test/done/" + data.id;
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