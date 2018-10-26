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
				<h3 class="judul">REPORT OF <strong>HISTORY PRODUCT</strong></h3>
				<p style="text-align: right">Periode : '.$periode.'</p>
				<table class="tabel" border="1px">
					<tr>
						<th style="width: 10px;"> No. </th>
		                <th> Product Code </th>
		                <th style="width: 200px;"> Product Name </th>
						<th> Barang Masuk </th>
						<th> Barang Keluar </th>
						<th> Sisa Stok Barang </th>
						<th style="width: 90px;text-align:center"> Cocok </th>
						<th style="text-align:center"> Gambar </th>
						<th> Request From </th>
						<th style="width: 40px;"> Divisi </th>
						<th> Keterangan </th>
						<th>Tanggal</th>
					</tr>';
						$no = 1;
						$query = "SELECT * FROM history_product";
						$hasil = $mysqli->query($query) or die($mysqli->error);
						while ($obj = $hasil->fetch_object()) {
							$content .='
								<tr>
					  <td style="text-align: center">'.$no++.'</td>
                      <td style="text-align: center">'.$obj->product_code.'</td>
                      <td>'.$obj->product_name.'</td>
					  <td style="text-align: center">'.$obj->masuk.'</td>
					  <td style="text-align: center">'.$obj->keluar.'</td>
					  <td style="text-align: center">'.$obj->qty.'</td>
					  <td style="width: 90px;">'.$obj->cocok.'</td>
					  <td style="width: 250px;">'.$obj->gambar.'</td>
					  <td style="text-align: center">'.$obj->username.'</td>
					  <td>'.$obj->level.'</td>
					  <td style="width: 80px;">'.$obj->keterangan.'</td>
					  <td style="width: 80px;">'.$obj->tanggal.'</td>
								</tr>
							';
						}
	$content .='
				</table>
			</div>
		</page>
	';

	require_once('asset/html2pdf/html2pdf.class.php');;
	$html2pdf = new HTML2PDF('L','A3','en');
	$html2pdf->writeHTML($content);
	$html2pdf->output('laporan-stuff-'.$periode.'.pdf','D');
?>