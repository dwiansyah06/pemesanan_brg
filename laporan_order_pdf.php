<?php
    session_start();
    include 'config.php';

    $content = '
        <style type="text/css">
            .container{padding: 40 20 40 20;}
            .tabel{border-collapse: collapse;}
            .tabel th{padding: 8px 5px;}
            .tabel td{padding-left: 5px;}
            .judul{text-align: center; margin-top: 15px; font-weight: 500;}
        </style>
    ';
    $content .= '
        <page>
            <div class="container">
                <img src="asset/images/3.png"; style="width: 22%;" /> 
                <img src="asset/images/4.png"; style="width: 22%; margin-top: -60px; float: right;"/>
                <hr style="margin-top: 15px;">
                <hr style="margin-top: -13px; height: 5px; background: #000;">
                <h3 class="judul">Transaction Report Of <strong> '.$_GET['id_transaksi'].'</strong></h3>
                <table class="tabel" border="1px">
                        <tr>
                            <th>No.</th>
                            <th>Product Name</th>
                            <th>Qty</th>
                            <th style="width: 75px;">Price</th>
                            <th style="width: 75px;">Total</th>
                            <th style="width: 100px;">Date</th>
                            <th style="width: 100px;" align="center">From</th>
                        </tr>';
                        $no = 1;
                        $nomor = $_GET['id_transaksi'];
                        $query = "SELECT product_code,product_name,units,price,total,date,level2 FROM approve_it WHERE id_transaksi ='$nomor'";
                        $hasil = $mysqli->query($query) or die($mysqli->error);
                        while ($obj = $hasil->fetch_object()) {
                            $content .='
                                <tr>
                                    <td align="center">'.$no++.'.</td>
                                    <td style="width: 170px;">'.$obj->product_name.'</td>
                                    <td align="center">'.$obj->units.'</td>
                                    <td>Rp. '.number_format($obj->price, 0, ',', '.').'</td>
                                    <td>Rp. '.number_format($obj->total, 0, ',', '.').'</td>
                                    <td style="width: 120px;">'.$obj->date.'</td>
                                    <td style="width: 110px;">'.$obj->level2.'</td>
                                </tr>
                            ';
                        }
    $content .='
                                <tr>
                                    <b><td colspan="4">Grand Total</td></b>
                                    <b><td>Rp. '.number_format($_SESSION['gt'], 0, ',', '.').'</td></b>
                                </tr>
                </table>
            </div>
        </page>
    ';

    require_once('asset/html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('p','A4','en');
    $html2pdf->writeHTML($content);
    $html2pdf->output('laporan-pesanan-'.$_GET['id_transaksi'].'.pdf','D');
?>