<script type="text/javascript">

    var save_method; //for save method string
    var table;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>/rekap/ajaxdetil/<?php echo $head->idsubtopik; ?>",
            scrollx: true,
            responsive: true
        });
    });

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }
    
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Detil Rekap<small>Maintenance data rekap</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>/rekap"> Rekap</a></li>
            <li class="active">Detil Rekap</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div class="form-horizontal">
                           <div class="form-group">
                                <label class="col-sm-2 control-label">Topik / Subtopik</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="<?php echo $head->namatopik.' / '.$head->namasub ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Jumlah Diujikan</label>
                                <div class="col-sm-1">
                                    <input type="text" class="form-control" value="<?php echo $soal->jml; ?>" readonly>
                                </div>
                                <label class="col-sm-1 control-label">Benar</label>
                                <div class="col-sm-1">
                                    <input type="text" class="form-control" value="<?php echo $soal->bnr; ?>" readonly>
                                </div>
                                <label class="col-sm-1 control-label">Salah</label>
                                <div class="col-sm-1">
                                    <input type="text" class="form-control" value="<?php echo $soal->slh; ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Chart <?php echo date("Y"); ?> (Total Benar)</h3>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="lineChart" style="height:250px"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Chart <?php echo date("Y"); ?> (Total Salah)</h3>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="lineChart2" style="height:250px"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <button type="button" class="btn btn-secondary btn-sm" onclick="reload();">Reload</button>
                    </div>
                    <div class="box-body">
                        <table id="tb" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="60%">Soal</th>
                                    <th>Benar</th>
                                    <th>Salah</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modal_form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Default Modal</h4>
            </div>
            <div class="modal-body">
                <form id="form" class="form-horizontal">
                    <input type="hidden" name="kode" id="kode">
                    <div class="form-group row">
                        <label for="subtopik" class="col-sm-3 control-label">Judul Subtopik</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="subtopik" name="subtopik" autocomplete="off">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnSave" type="button" class="btn btn-sm btn-primary" onclick="save();">Simpan</button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="closemodal();">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- ChartJS -->
<script src="<?php echo base_url(); ?>/back/bower_components/chart.js/Chart.js"></script>
<script>
    $(function(){
        var areaChartData = {
            labels  : [<?php $bulan = $model->getAllQ("SELECT created_at FROM peserta p where YEAR(created_at) = YEAR(now()) group by MONTH(created_at);"); foreach($bulan->getResult() as $rows){ ?> '<?php echo date('F', strtotime($rows->created_at))?>', <?php }?>],
            datasets: [
                <?php foreach($quest->getResult() as $row) {
                    $hasil = $model->getAllQ("SELECT count(hasil) as benar FROM jawaban_peserta j, peserta p where idsoal = '".$row->idsoal."' and hasil = 1 and j.idpeserta = p.idpeserta group by MONTH(created_at);");?>
                {
                label               : '<?php echo strip_tags(preg_replace( "/\r|\n/", "", str_replace("&nbsp;", "", $row->soal))) ?>',
                strokeColor         : '<?php echo 'rgba('.$row->random.','.$row->random2.','.$row->random3.')' ?>',
                pointColor          : '<?php echo 'rgba('.$row->random.','.$row->random2.','.$row->random3.')' ?>',
                data                : [<?php foreach($hasil->getResult() as $rows){ echo $rows->benar.',';}?>]
                },
                <?php } ?>
            ]
        }

        var areaChartData2 = {
            labels  : [<?php $bulan = $model->getAllQ("SELECT created_at FROM peserta p where YEAR(created_at) = YEAR(now()) group by MONTH(created_at);"); foreach($bulan->getResult() as $rows){ ?> '<?php echo date('F', strtotime($rows->created_at))?>', <?php }?>],
            datasets: [
                <?php foreach($quest->getResult() as $row) {
                    $hasil = $model->getAllQ("SELECT count(hasil) as salah FROM jawaban_peserta j, peserta p where idsoal = '".$row->idsoal."' and hasil = 0 and j.idpeserta = p.idpeserta group by MONTH(created_at);");?>
                {
                label               : '<?php echo strip_tags(preg_replace( "/\r|\n/", "", str_replace("&nbsp;", "", $row->soal))) ?>',
                strokeColor         : '<?php echo 'rgba('.$row->random.','.$row->random2.','.$row->random3.')' ?>',
                pointColor          : '<?php echo 'rgba('.$row->random.','.$row->random2.','.$row->random3.')' ?>',
                data                : [<?php foreach($hasil->getResult() as $rows){ echo $rows->salah.',';}?>]
                },
                <?php } ?>
            ]
        }

        var areaChartOptions = {
            //Boolean - If we should show the scale at all
            showScale               : true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines      : false,
            //String - Colour of the grid lines
            scaleGridLineColor      : 'rgba(0,0,0,.05)',
            //Number - Width of the grid lines
            scaleGridLineWidth      : 1,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines  : true,
            //Boolean - Whether the line is curved between points
            bezierCurve             : true,
            //Number - Tension of the bezier curve between points
            bezierCurveTension      : 0.3,
            //Boolean - Whether to show a dot for each point
            pointDot                : false,
            //Number - Radius of each point dot in pixels
            pointDotRadius          : 4,
            //Number - Pixel width of point dot stroke
            pointDotStrokeWidth     : 1,
            //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
            pointHitDetectionRadius : 20,
            //Boolean - Whether to show a stroke for datasets
            datasetStroke           : true,
            //Number - Pixel width of dataset stroke
            datasetStrokeWidth      : 2,
            //Boolean - Whether to fill the dataset with a color
            datasetFill             : true,
            //String - A legend template
            legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
            //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio     : true,
            //Boolean - whether to make the chart responsive to window resizing
            responsive              : true
        }

        var areaChartOptions2 = {
            //Boolean - If we should show the scale at all
            showScale               : true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines      : false,
            //String - Colour of the grid lines
            scaleGridLineColor      : 'rgba(0,0,0,.05)',
            //Number - Width of the grid lines
            scaleGridLineWidth      : 1,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines  : true,
            //Boolean - Whether the line is curved between points
            bezierCurve             : true,
            //Number - Tension of the bezier curve between points
            bezierCurveTension      : 0.3,
            //Boolean - Whether to show a dot for each point
            pointDot                : false,
            //Number - Radius of each point dot in pixels
            pointDotRadius          : 4,
            //Number - Pixel width of point dot stroke
            pointDotStrokeWidth     : 1,
            //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
            pointHitDetectionRadius : 20,
            //Boolean - Whether to show a stroke for datasets
            datasetStroke           : true,
            //Number - Pixel width of dataset stroke
            datasetStrokeWidth      : 2,
            //Boolean - Whether to fill the dataset with a color
            datasetFill             : true,
            //String - A legend template
            legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
            //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio     : true,
            //Boolean - whether to make the chart responsive to window resizing
            responsive              : true
        }

        //-------------
        //- LINE CHART -
        //--------------
        var lineChartCanvas          = $('#lineChart').get(0).getContext('2d')
        var lineChart                = new Chart(lineChartCanvas)
        var lineChartOptions         = areaChartOptions
        lineChartOptions.datasetFill = false
        lineChart.Line(areaChartData, lineChartOptions)

        var lineChartCanvas2          = $('#lineChart2').get(0).getContext('2d')
        var lineChart2                = new Chart(lineChartCanvas2)
        var lineChartOptions2         = areaChartOptions2
        lineChartOptions2.datasetFill = false
        lineChart2.Line(areaChartData2, lineChartOptions2)

    });

</script>