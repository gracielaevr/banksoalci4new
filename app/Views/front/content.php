<div class="ugf-wraper">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="ugf-dontation-wrap">
                    <div class="ugf-donation">
                        <div class="logo">
                            <a href="<?php echo base_url(); ?>/"><img src="<?php echo base_url(); ?>/front/images/leapverse.png" class="img-fluid" alt="logo" width="150px" height="70px"></a>
                        </div>
                        <h1>FREE ENGLISH TEST</h1>
                        <p>Having trouble finding English practice questions to help you study for school exams? Are you getting ready to compete in an English event or Olympiad? Or perhaps you simply want to measure how well your English is? Try the Leap English test questions now! <b>It's Free!</b></p>
                        <div class="form">
                            <div class="form-block">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="search_text" id="search_text" placeholder="Search here..">
                                </div>
                            </div>
                            <div class="row" style="margin-top: -40px;" id="wadah">

                            </div>
                            <button id="btnMore" class="btn btn-info btn-sm" style="margin-top: 20px; color: blue;" onclick="loadmore();">Read More . . .</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="widget">
                    <div class="social-link">
                        <ul>
<<<<<<< HEAD
                            <li><a target="_blank" href="/banksoal/public/loginsiswa">Student Sign in</a></li>
                            <li><a target="_blank" href="/banksoal/public/login">Teacher Sign in</a></li>
=======
                            <li><a target="_blank" href="http://localhost/banksoal/public/loginsiswa">Test As Yourself</a></li>
                            <li><a target="_blank" href="http://localhost/banksoal/public/logininstansi">Test As School</a></li>
>>>>>>> 6002e5429eac06fed92e8ef296b3b0ad4ecd6681
                            <li><a target="_blank" href="https://leapverse.leapsurabaya.sch.id/">Leapverse</a></li>
                            <li><a target="_blank" href="https://leapsurabaya.sch.id/"><i class="las la-home"></i></a></li>
                            <li><a target="_blank" href="https://www.facebook.com/LeapSurabaya/?locale=id_ID"><i class="lab la-facebook-f"></i></a></li>
                            <li><a target="_blank" href="https://www.linkedin.com/company/leap-english-digital-class/mycompany/"><i class="lab la-linkedin-in"></i></a></li>
                            <li><a target="_blank" href="https://www.instagram.com/leapsurabaya/?hl=en"><i class="lab la-instagram"></i></a></li>
                        </ul>
                    </div>
                    <div class="footer">
                        <p>Copyright &copy; <?php echo date("Y"); ?> <a href="<?php echo base_url(); ?>/">Leapverse - Bank Soal</a>. All Rights Reserved</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    
    var limit = 8;
    
    $(document).ready(function () {

        load_data("");

        $('#search_text').keyup(function () {
            var search = $("#search_text").val();
            if (search != "") {
                load_data(search);
            } else {
                load_data("");
            }
        });
    });
    
    function load_data(search) {
        $.ajax({
            url: "<?php echo base_url(); ?>/topic/ajaxlist",
            type: "POST",
            dataType: "JSON",
            data: {query: search, limit : limit},
            success: function (data) {
                $('#wadah').html(data.status);
                if(data.status_bottom === "aktif"){
                    $('#btnMore').show();
                }else{
                    $('#btnMore').hide();
                }
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error load data');
            }
        });
    }
    
    function loadmore(){
        limit *= 2;
        load_data("");
    }
</script>