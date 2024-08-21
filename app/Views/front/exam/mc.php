<div class="ugf-wraper2">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="navigation">
                    <div class="logo">
                        <a href="<?php echo base_url(); ?>/"><img src="<?php echo base_url(); ?>/front/images/leapverse.png" class="img-fluid" alt="logo" style="height: 70px;"></a>
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
                                        <input type="hidden" id="idsubtopik" name="idsubtopik" value="<?php echo $kode; ?>">
                                        <span class="step-count"><?php echo $topik; ?></span>
                                        <input type="hidden" id="idtopik" name="idtopik" value="<?php echo $idtopik; ?>">
                                    </div>
                                    <div class="form">
                                        <div class="covid-test-wrap test-step active">
                                            <?php $i=1;
                                            foreach($soal->getResult() as $row){ 
                                                if($row->gambar != null){
                                                    $def_foto = base_url().'/images/noimg.jpg';
                                                    $foto = $model->getAllQR("select gambar from soal where idsoal = '".$row->idsoal."';")->gambar;
                                                    if(strlen($foto) > 0){
                                                        if(file_exists($modul->getPathApp().$foto)){
                                                            $def_foto = base_url().'/uploads/'.$foto;
                                                        }
                                                    }?>
                                                <img src="<?php echo $def_foto; ?>" height="150px">
                                                <?php }
                                                if($row->link != ''){?>
                                                <br>
                                                <iframe class="embed-responsive-item" src="<?php echo str_replace('watch?v=','embed/',$row->link); ?>?rel=0&mute=0&autoplay=1" 
                                                    srcdoc="<style>*{padding:0;margin:0px;overflow:hidden}html,body{height:100%}img,span{position:absolute;width:100%;top:0;bottom:0;margin:auto}span{height:1.5em;text-align:center;font:48px/1.5 sans-serif;color:white;text-shadow:0 0 0.5em black}</style>
                                                    <a href=<?php echo str_replace('watch?v=','embed/',$row->link); ?>?rel=0&autoplay=1><img src=<?php $im = str_replace('www','img',$row->link); echo str_replace('watch?v=','vi/',$im); ?>/maxresdefault.jpg><span>▶</span></a>"
                                                        frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                                                    </iframe>
                                                <?php }
                                                ?>
                                            <input type="hidden" id="kodesoal<?php echo $i;?>" name="kodesoal[]" value="<?php echo $row->idsoal; ?>">
                                            <?php echo str_replace('p>','h3>',$row->soal); ?> 
                                            <span class="step-count"><?php echo 'Poin : '.$row->poin; ?></span>
                                            <div class="step-block">
                                                <div class="row">
                                                    <?php 
                                                    $pil = $model->getAllQ("select * from pilihan where idsoal = '".$row->idsoal."'");
                                                    foreach($pil->getResult() as $row1) {?>
                                                    <div class="col-lg-6 col-sm-12">
                                                        <div class="form-group">
                                                            <input type="radio" name="pilihan<?php echo $i;?>" class="form-control" id="<?php echo $row1->pilihan.$i;?>" value="<?php echo $row1->idpilihan;?>" required>
                                                            <label for="<?php echo $row1->pilihan.$i;?>"><?php echo $row1->pilihan;?></label>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <span hidden="hidden" style="color: red; margin-top: 0;" id="errorsoal<?php echo $i;?>">* Required</span>
                                            <?php
                                                $i++; }
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
                            <li><a target="_blank"  href="https://leapsurabaya.sch.id/"><i class="las la-home"></i></a></li>
                            <li><a target="_blank" href="https://www.facebook.com/LeapSurabaya/?locale=id_ID"><i class="lab la-facebook-f"></i></a></li>
                            <li><a target="_blank" href="https://www.linkedin.com/company/leap-english-digital-class/mycompany/"><i class="lab la-linkedin-in"></i></a></li>
                            <li><a target="_blank" href="https://www.instagram.com/leapsurabaya/?hl=en"><i class="lab la-instagram"></i></a></li>
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
        var idsoal = $("input[name='kodesoal[]']").map(function(){return $(this).val();}).get();
        
        const pil = [];

        var tot = 0;
        for (let i = 1; i < jml; i++) {
            pil[i] = $("input[type='radio'][name='pilihan"+i+"']:checked").val();
            if (pil[i] === undefined) {
                document.getElementById("errorsoal"+i).removeAttribute("hidden");
            }else{  
                document.getElementById("errorsoal"+i).setAttribute("hidden", "hidden"); 
                tot += 1; 
            }
        }

        var temp = '';
        for (let i = 1; i < jml; i++) {
            temp += $("input[type='radio'][name='pilihan"+i+"']:checked").val() +',';
        }

        if(tot < jml-1){
            alert("Fill all the question first!");
        }else {
            var url = "<?php echo base_url(); ?>/test/finish";
            
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
                    if(data.status === "ok"){
                        window.location.href = "<?php echo base_url(); ?>/test/done/"+data.id;
                    }

                    $('#btnSimpan').text('Save'); //change button text
                    $('#btnSimpan').attr('disabled', false); //set button enable 
                }, error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error json " + errorThrown);

                    $('#btnSimpan').text('Save'); //change button text
                    $('#btnSimpan').attr('disabled', false); //set button enable 
                }
            });
        }
    }

</script>


