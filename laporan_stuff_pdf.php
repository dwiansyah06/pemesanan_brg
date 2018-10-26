<?php
	include 'config.php';
	$periode = date('d-m-Y');

	$content = '
		<style type="text/css">
			.container{padding: 40 70 40 40;}
			.tabel{border-collapse: collapse;margin-left: 20px;}
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
				<h3 class="judul">Report of stuff</h3>
				<p style="text-align: right">Periode : '.$periode.'</p>
				<table class="tabel" border="1px">
						<tr>
							<th>No.</th>
							<th>Product Code</th>
							<th style="width: 200px;">Product Name</th>
							<th>Category</th>
							<th>Quantity</th>
							<th style="width: 50px;" align="center">Price</th>
						</tr>';
						$no = 1;
						$query = "SELECT  product_code,product_name,kategori,qty,price FROM product";
						$hasil = $mysqli->query($query) or die($mysqli->error);
						while ($obj = $hasil->fetch_object()) {
							$content .='
								<tr>
									<td align="center">'.$no++.'.</td>
									<td align="center">'.$obj->product_code.'</td>
									<td style="width: 200px;">'.$obj->product_name.'</td>
									<td style="width: 50px;">'.$obj->kategori.'</td>
									<td align="center">'.$obj->qty.'</td>
									<td style="width: 120px;">Rp. '.number_format($obj->price, 0, ",", ".").'</td>
								</tr>
							';
						}
	$content .='
				</table>
			</div>
		</page>
	';

	require_once('asset/html2pdf/html2pdf.class.php');;
	$html2pdf = new HTML2PDF('p','A4','en');
	$html2pdf->writeHTML($content);
	$html2pdf->output('laporan-stuff-'.$periode.'.pdf','D');
?>