<script>
    var limit = 8;

    $(document).ready(function() {

        load_data("");

        $('#search_text').keyup(function() {
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
            data: {
                query: search,
                limit: limit
            },
            success: function(data) {
                $('#wadah').html(data.status);
                if (data.status_bottom === "aktif") {
                    $('#btnMore').show();
                } else {
                    $('#btnMore').hide();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error load data');
            }
        });
    }

    function loadmore() {
        limit *= 2;
        load_data("");
    }
</script>