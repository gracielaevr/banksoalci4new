<style>
#floating-timer {
    position: fixed;
    top: 10px;
    right: 10px;
    background-color: #fff;
    color: #333;
    padding: 10px;
    font-size: 24px;
    border-radius: 5px;
    display: none;
}
</style>
<script type="text/javascript">
function save() {
    var jml = document.getElementById('jml').value;
    var kos = 0;
    for (let i = 1; i < jml; i++) {
        $n = $("input[type='radio'][name='pilihan" + i + "']:checked").val();
        if ($n === undefined) {
            kos += 1;
        }
    }
    if (kos > 0) {
        simpan("0");
    } else {
        Swal.fire({
            title: "Apakah Anda yakin dengan Jawaban Anda??",
            text: "Masih ada waktu tersisa.",
            icon: "info",
            confirmButtonColor: "#3085d6",
            showCancelButton: true,
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes!",
            cancelButtonText: "No"
        }).then((result) => {
            if (result.isConfirmed) {
                simpan("0");
            } else {
                Swal.fire("Dibatalkan", "Silahkan Lanjutkan Testnya!", "error");
            }
        });
    }
}

function simpan(status) {
    var idbidang = document.getElementById('idbidang').value;
    var idpeserta = document.getElementById('idpeserta').value;
    var jml = document.getElementById('jml').value;
    var idsoal = $("input[name='kodesoal[]']").map(function() {
        return $(this).val();
    }).get();

    const pil = [];

    var tot = 0;
    var er = 0;
    // alert(status);
    if (status != "timeout") {
        for (let i = 1; i < jml; i++) {
            pil[i] = $("input[type='radio'][name='pilihan" + i + "']:checked").val();
            if (pil[i] === undefined) {
                document.getElementById("errorsoal" + i).removeAttribute("hidden");
                if (er === 0) {
                    document.getElementById("divsoal" + i).tabIndex = -1;
                    document.getElementById("divsoal" + i).focus();
                    er = 1;
                }
            } else {
                document.getElementById("errorsoal" + i).setAttribute("hidden", "hidden");
                tot += 1;
            }
        }
    }

    var temp = '';
    for (let i = 1; i < jml + 1; i++) {
        n = $("input[type='radio'][name='pilihan" + i + "']:checked").val();
        if (n === undefined) {
            n = "kosong";
        }
        temp += n + ',';
    }

    if (tot < jml - 1 && status == 0) {
        alert("Fill all the question first!");
    } else {
        var url = "<?php echo base_url(); ?>diagnostictest/finish";

        var form_data = new FormData();
        form_data.append('bidang', idbidang);
        form_data.append('idpeserta', idpeserta);
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
                //console.log(data);
                if (data.status === "ok") {
                    window.location.href = "<?php echo base_url(); ?>diagnostictest/done/" + data.ids;
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

document.addEventListener('DOMContentLoaded', function() {
    var floatingTimer = document.getElementById('floating-timer');
    var timerId = window.location.pathname; // Use the page URL as a unique identifier
    var storedTimerId = localStorage.getItem('timerId');
    // var seconds = 6;
    var bid = document.getElementById('idbidang').value;

    if (bid != 'English') {
        var seconds = parseInt(localStorage.getItem('timerSeconds')) || 1801; // 30 minutes countdown
    } else {
        var seconds = parseInt(localStorage.getItem('timerSeconds')) || 2101; // 35 minutes countdown
    }
    var timerInterval;

    // Check if a timer is already running and if the page or ID has changed
    if (storedTimerId === timerId) {
        // If yes, continue the timer
        timerInterval = setInterval(updateTimer, 1000);
        floatingTimer.style.display = 'block';
    } else {
        // If not, start a new timer
        resetTimer();
    }

    function updateTimer() {
        if (seconds > 0) {
            seconds--;
            localStorage.setItem('timerSeconds', seconds);

            var minutes = Math.floor(seconds / 60);
            var remainingSeconds = seconds % 60;

            floatingTimer.textContent = pad(minutes) + ':' + pad(remainingSeconds);

            // Change color to red when remaining time is 180 seconds or less
            if (seconds <= 180) {
                floatingTimer.style.color = 'red';
            }

            // Notify when the timer is about to finish
            if (seconds === 0) {
                notif();
            }

        } else {
            floatingTimer.textContent = '00:00';
            clearInterval(timerInterval);
            localStorage.removeItem('timerSeconds'); // Clear storage when timer reaches 0
        }
    }

    function pad(value) {
        return value < 10 ? '0' + value : value;
    }

    function resetTimer() {
        // Reset the timer to 1801 seconds
        var bid = document.getElementById('idbidang').value;

        if (bid != 'English') {
            seconds = 1801;
        } else {
            seconds = 2101;
        }
        localStorage.setItem('timerSeconds', seconds);

        // Update the stored timerId
        localStorage.setItem('timerId', timerId);

        // Restart the timer
        clearInterval(timerInterval);
        timerInterval = setInterval(updateTimer, 1000);
        floatingTimer.style.display = 'block';

        // Update the displayed timer
        updateTimer();
    }

});

function notif() {
    Swal.fire({
        title: "WAKTU HABIS!!",
        text: "Hitungan mundur selesai.",
        icon: "info",
        confirmButtonColor: "#ffc107",
        confirmButtonText: "Kirimkan jawaban.",
        allowOutsideClick: false
    }).then((result) => {
        if (result.isConfirmed) {
            simpan("timeout");
        }
    });
}

function playOnce(audioId) {
    const audio = document.getElementById("myAudio" + audioId);

    if (!audio.paused && !audio.ended) {
        return; // If already playing or ended, do nothing
    }

    $('#btnaudio_' + audioId).text('Playing'); //change button text
    audio.play();

    audio.addEventListener("ended", function() {
        audio.remove(); // Remove the audio element after playback 
        $("#btnaudio_" + audioId).text('STOP'); //change button text
        $("#btnaudio_" + audioId).attr('disabled', true); //set button enable 
        document.getElementById("btnaudio_" + audioId).className = "btn-lg btn-secondary";
    });

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
                </div>
            </div>
            <div class="col-lg-12">
                <div class="ugf-dontation-wrap">
                    <div class="ugf-donation">
                        <div class="ugf-form-card">
                            <div class="card-header">
                                <div class="covid-wrap">
                                    <div class="covid-header">
                                        <h2><?php echo $bidang->namabidang; ?> Diagnostik Test</h2>
                                        <input type="hidden" id="idbidang" name="idbidang"
                                            value="<?php echo $bidang->namabidang; ?>">
                                        <input type="hidden" id="idpeserta" name="idpeserta"
                                            value="<?php echo $kode; ?>">
                                    </div>
                                    <div class="form">
                                        <div class="covid-test-wrap test-step active">
                                            <?php $i = 1;
                                            foreach ($soal->getResult() as $row) {
                                                if ($row->jenis == 'Soal') { ?>
                                            <div style="text-align: justify; text-justify: inter-word;"
                                                id="divsoal<?php echo $i; ?>">
                                                <?php } else {
                                                    ?>
                                                <div style="text-align: justify; text-justify: inter-word;">

                                                    <?php
                                                    }
                                                    if ($row->jenis == 'Soal') {
                                                        ?>
                                                    <input type="hidden" id="kodesoal<?php echo $i; ?>"
                                                        name="kodesoal[]" value="<?php echo $row->idsoal; ?>">
                                                    <?php
                                                            if ($bidang->namabidang != 'English') {
                                                                echo '<h3>Pertanyaan No. ' . $i . '</h3>';
                                                            }
                                                        }
                                                        if (str_contains($row->soal, '<p>')) {
                                                            echo str_replace('p>', 'h3>', $row->soal);
                                                        } else {
                                                            echo '<h3>' . $row->soal . '</h3>';
                                                        }
                                                        echo '</div>';
                                                        if ($row->gambar != null) {
                                                            $def_foto = base_url() . '/images/noimg.jpg';
                                                            $foto = $model->getAllQR("select gambar from soaltest where idsoal = '" . $row->idsoal . "';")->gambar;
                                                            if (strlen($foto) > 0) {
                                                                if (file_exists($modul->getPathApp() . $foto)) {
                                                                    $def_foto = base_url() . '/uploads/' . $foto;
                                                                }
                                                            } ?>
                                                    <img src="<?php echo $def_foto; ?>"
                                                        style=" max-width: 100%; height: auto; display: block; margin: 0 auto;"><br>
                                                    <?php }
                                                        if ($row->jenis == 'Soal') { ?>
                                                    <div class="step-block">
                                                        <div class="row">
                                                            <?php
                                                                    $pil = $model->getAllQ("select * from pilihantest where idsoal = '" . $row->idsoal . "'");
                                                                    foreach ($pil->getResult() as $row1) { ?>
                                                            <div class="col-lg-6 col-sm-12">
                                                                <div class="form-group">
                                                                    <input type="radio" name="pilihan<?php echo $i; ?>"
                                                                        class="form-control"
                                                                        id="<?php echo str_replace('"', '', $row1->pilihan) . $i; ?>"
                                                                        value="<?php echo $row1->idpilihan; ?>"
                                                                        required>
                                                                    <label
                                                                        for="<?php echo str_replace('"', '', $row1->pilihan) . $i; ?>"><?php echo  htmlspecialchars(str_replace('"', '', $row1->pilihan)); ?></label>
                                                                </div>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <span hidden="hidden" style="color: red; margin-top: 0;"
                                                        id="errorsoal<?php echo $i; ?>">* Required</span>
                                                    <hr style="border-top: 4px solid purple;">
                                                    <?php $i++;
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                                <input type="hidden" id="jml" value="<?php echo $jml; ?>">
                                                <button id="btnSimpan" class="btn" onclick="save();">KIRIM</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="floating-timer"></div>
                    <div class="col-lg-12">
                        <div class="widget" style="min-height: 0;">
                            <div class="social-link">
                                <ul>
                                    <li><a target="_blank" href="https://leapverse.leapsurabaya.sch.id/">Leapverse</a>
                                    </li>
                                    <li><a target="_blank" href="https://leapsurabaya.sch.id/"><i
                                                class="las la-home"></i></a></li>
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