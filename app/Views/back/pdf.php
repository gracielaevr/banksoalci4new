<html>
    <head>
        <title>PENILAIAN</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            
            /** 
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
            @page {
                margin: 0cm 0cm;
            }

            /** Define now the real margins of every page in the PDF **/
            body {
                margin-top: 0.5cm;
                margin-left: 1cm;
                margin-right: 1cm;
                margin-bottom: 0.5cm;
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
              
            .circle {
                border-radius: 50%;
                width: 10px;
                height: 10px;
                padding: 5px;
                background: #fff;
                border: 0.8px solid #000;
                color: #000;
                text-align: center;
                font: 9px Arial, sans-serif;
            }
        </style>
    </head>
    <body>
<!--        <header>
            RAHASIA
        </header>
        <footer>
        </footer>-->
        <main style="font-size: 12px;">
            <p style="text-align: center; font-size: 14px;"><b>RINCIAN KERTAS KERJA SATKER T.A. 7</b></p>
            <table>
                <tr>
                    <td><b>ALOKASI</b></td>
                    <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                    <td>7</td>
                </tr>
                <tr>
                    <td><b>SATKER</b></td>
                    <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                    <td>7</td>
                </tr>
            </table>

            <table style="font-size: 11px; font-family: Arial; width: 100%; margin-top: 20px; border-collapse: collapse; border: 1px solid black;" border="1">
                <thead>
                    <tr>
                        <th rowspan="2" style="text-align: center; vertical-align: middle; padding:5px;">KODE</th>
                        <th rowspan="2" style="text-align: center; vertical-align: middle; padding:5px;">KEGIATAN</th>
                        <th colspan="3" style="text-align: center; vertical-align: middle; padding:5px;">PERHITUNGAN TAHUN <?php echo $tahun; ?></th>
                    </tr>
                    <tr>
                        <th style="text-align: center; vertical-align: middle; padding:5px;">VOLUME</th>
                        <th style="text-align: center; vertical-align: middle; padding:5px;">HARGA SATUAN</th>
                        <th style="text-align: center; vertical-align: middle; padding:5px;">JUMLAH BIAYA</th>
                    </tr>
                    <tr>
                        <td style="text-align: center; vertical-align: middle;"> (1) </td>
                        <td style="text-align: center; vertical-align: middle;"> (2) </td>
                        <td style="text-align: center; vertical-align: middle;"> (3) </td>
                        <td style="text-align: center; vertical-align: middle;"> (4) </td>
                        <td style="text-align: center; vertical-align: middle;"> (5) </td>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </main>
    </body>
</html>