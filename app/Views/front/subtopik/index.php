<div class="ugf-wraper">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
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
            <div class="col-lg-10">
                <div class="ugf-dontation-wrap">
                    <div class="ugf-donation">
                        <h1>FREE ENGLISH TEST</h1>
                        <h5> TOPIC : <?php echo $topik; ?></h5>
                        <p>Here are all the subtopic for this topic that we have.</p>
                        <div class="form">
                            <div class="form-block">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="search_text" id="search_text"
                                        placeholder="Search here..">
                                </div>
                            </div>
                            <div class="row" style="margin-top: -40px;" id="wadah">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="widget" style="min-height: 20vh;">
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

<script>
$(document).ready(function() {

    load_data();

    function load_data(search) {
        $.ajax({
            url: "<?php echo base_url(); ?>subtopic/ajaxlist/<?php echo $idtopik; ?>",
            type: "POST",
            dataType: "JSON",
            data: {
                query: search
            },
            success: function(data) {
                $('#wadah').html(data.status);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error load data');
            }
        });
    }

    $('#search_text').keyup(function() {
        var search = $("#search_text").val();
        if (search != '') {
            load_data(search);
        } else {
            load_data();
        }
    });

});
</script>