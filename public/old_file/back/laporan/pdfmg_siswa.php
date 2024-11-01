<html>
    <head>
        <title>Student Report - <?php echo $nama; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        
        <style>
            /** Define the margins of your page **/
            @page {
                margin: 100px 25px;
            }

            /** Define now the real margins of every page in the PDF **/
            body {
                margin-top: 1cm;
                margin-left: 2cm;
                margin-right: 2cm;
                margin-bottom: 1cm;
                /* background-image: url("back/images/noimg.jpg"); */
            }

            /** Define the header rules **/
            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 1cm;

                /** Extra personal styles **/
                background-color: white;
                font-size: 9px;
                color: black;
                text-align: center;
                line-height: 1cm;
            }

            /** Define the footer rules **/
            footer {
                position: fixed; 
                bottom: 0cm; 
                left: 0cm; 
                right: 0cm;
                height: 1cm;

                /** Extra personal styles **/
                background-color: white;
                font-size: 9px;
                color: black;
                text-align: center;
                line-height: 1cm;
            }
            
            .dash{
                border: 0 none;
                border-top: 1px dashed #322f32;
                background: none;
                height:0;
              } 

            footer {
                position: fixed; 
                bottom: -2cm; 
                left: 0cm; 
                right: 0cm;
                height: 2cm;
            }

            header {
                position: fixed;
                top: -40px;
                left: 65px;
                right: 0px;
                height: auto;
                text-align: left;
            }
        </style>
    </head>
    <body>
        <header>
        <img src="back/images/logo.jpg" style="width: 100px; height: auto;">
        </header>

        <footer>
            <img src="back/images/sub.jpg" style="width: 100%; height: auto;"/>
        </footer>

        <main style="font-size: 12px;">
           
            
            <table border="0" style="margin-top: 20px;">
                <tr>
                    <td><b>TOPIC</b></td>
                    <td>&nbsp;&nbsp; : <?php echo $topik; ?></td>
                    <td></td>
                </tr>
                
                <tr>
                    <td><b>SUBTOPIC</b></td>
                    <td>&nbsp;&nbsp; :  <?php echo $subtopik; ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td><b>NAME</b></td>
                    <td>&nbsp;&nbsp; :  <?php echo $nama; ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td><b>SCORE</b></td>
                    <td>&nbsp;&nbsp; :  <?php echo $poin; ?></td>
                    <td></td>
                </tr>
            </table>
            
            <?php if($narasi != ''){
                echo '<br><hr class="dash">';
                $p = '<p style="font-size: 14px; text-align: justify; line-height: 1.5;">';
                echo str_replace('<p>',$p,$narasi); 
            }?>

            <table style="border-collapse: collapse; border: 1px solid black; margin-top: 20px; margin-bottom: 5px; width: 100%;">
                <tr>
                    <td style="text-align: center; border: 1px solid black; padding: 5px; "><b>QUESTION</b></td>
                    <td style="text-align: center; border: 1px solid black; padding: 5px; width: 100px;"><b>YOUR ANSWER</b></td>
                    <td style="text-align: center; border: 1px solid black; padding: 5px; width: 130px;"><b>MARK</b></td>
                </tr>
            </table>

            <table style="border-collapse: collapse; border: 1px solid #b7bec5; margin-top: 10px; margin-bottom: 5px; width: 100%;">
                <?php foreach($soal->getResult() as $row) {?>
                <tr>
                    <td style="text-align: justify; border: 1px solid #b7bec5; padding: 5px; ">
                    <?php echo $row->soal; 
                    if($row->jenis != 'tf'){?>
                    <ol type='a'>
                        <?php 
                        $pilihan = $model->getAllQ("select * from pilihan where idsoal = '".$row->idsoal."'");
                        foreach($pilihan->getResult() as $row1){
                            echo '<li>'.$row1->pilihan.'</li>';
                        }?>
                    </ol>
                    <?php }
                    $items = array();
                    $list_js = $model->getAllQ("select jawab from jawaban_peserta where idsoal = '".$row->idsoal."'");
                    foreach ($list_js->getResult() as $row2) {
                        $items[] = $row2->jawab;
                    } 
                    $n=0;
                    $list_ja = $model->getAllQ("select jawaban from jawaban where idsoal = '".$row->idsoal."'");
                    ?>
                    </td>
                    <td style="text-align: justify; border: 1px solid #b7bec5; padding: 5px; width: 100px;"><ol type="a">
                    <?php foreach ($list_ja->getResult() as $row1) { echo '<li>'.$items[$n].'</li>'; $n++;}?></ol></td>
                    <td style="text-align: center; border: 1px solid #b7bec5; padding: 5px; width: 130px; ">
                    <?php $n=0;
                    foreach ($list_ja->getResult() as $row1) {
                        if($items[$n] == $row1->jawaban) {?>
                        <b style="color: green;">Right</b><br>
                        <?php }else{ ?>
                        <b style="color: red;">Wrong</b><br>
                    <?php } $n++;
                    }?>
                    </td>
                </tr>
                <?php } ?>
            </table>
            
            <div style="width: 100%; height: 25px; vertical-align: middle;">
                <div style="float: right; padding: 5px;text-align: right;">
                    <b>Correct = <?php echo $benar; ?></b>
                </div>
            </div>
            <div style="width: 100%; height: 25px; vertical-align: middle;">
                <div style="float: right; padding: 5px;text-align: right;">
                    <b>Wrong = <?php echo $salah; ?></b>
                </div>
            </div>
            <p style="font-size: 14px; text-align: justify;">If you want to know more about the explanation. You can contact us.
            </p>
            <hr class="dash">
            <br>
            
            <h2><?php echo strtoupper($topik); ?> - THEORY</h2>
            
            <?php 
            $p = '<p style="font-size: 14px; text-align: justify; line-height: 1.5;">';
            echo str_replace('<p>',$p,$teori); ?>
        </main>
    </body>
</html>