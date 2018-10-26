<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}
	include 'config.php';
	$periode = date('d-m-Y');
	$level=$_SESSION['level'];

	$content = '
		<style type="text/css">
			.container{padding: 40 70 40 40;}
			.tabel{border-collapse: collapse;margin-left: 7px;}
			.tabel th{padding: 8px 5px;}
			.tabel td{padding-left: 5px;}
			.judul{text-align: center; margin-top: 15px; font-weight: 500;}
		</style>
	';
	$content .= '
		<page>
			<div class="container">
				<img src="asset/images/logo.png"; style="width: 10%;" /> 
				<img src="asset/images/logo.png"; style="width: 10%; margin-top: -45px; float: right;"/>
				<hr style="margin-top: 15px;">
                <hr style="margin-top: -13px; height: 5px; background: #000;">
				<h3 class="judul">Report of transactions</h3>
				<table class="tabel" border="1px">
<tr>
							<th>No.</th>
							<th style="width: 120px;">Divisi</th>
							<th>Id Transaction</th>
							<th>Product Code</th>
							<th>Jumlah</th>
							<th> Harga </th>
							<th>Total</th>
						</tr>';
						$no = 1;
						$query = "SELECT * FROM approve_it WHERE level = '$level'";
						$hasil = $mysqli->query($query) or die($mysqli->error);
						
						while ($obj = $hasil->fetch_object()) {
							$content .='
								<tr>
									<td align="center">'.$no++.'.</td>
									<td style="width: 120px;">'.$obj->level2.'</td>
									<td align="center">'.$obj->id_transaksi.'</td>
									<td align="center">'.$obj->product_code.'</td>
									<td align="center">'.$obj->units.'</td>
									<td>Rp. '.number_format($obj->price, 0, ",", ".").'</td>
									<td>Rp. '.number_format($obj->total, 0, ",", ".").'</td>
								</tr>
							';
						}
						$query2 = "SELECT  SUM(total) FROM approve_it WHERE level = '$level'";
						$hasil2 = $mysqli->query($query2) or die($mysqli->error);
						$obj2 = $hasil2->fetch_array();
$content .='
<tr>
<td align="right" colspan=6 style="width: 120px;"><strong> Total Pemakaian </strong></td>
<td style="width: 120px;"><strong> Rp. '.number_format($obj2['SUM(total)'], 0, ",", ".").' </strong></td>
</tr>

				</table>
			</div>
		</page>
	';

	require_once('asset/html2pdf/html2pdf.class.php');;
	$html2pdf = new HTML2PDF('p','A4','en');
	$html2pdf->writeHTML($content);
	$html2pdf->output('laporan-pemakaian-'.$periode.'.pdf','D');
?>