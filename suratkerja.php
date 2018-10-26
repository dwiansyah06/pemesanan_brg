<?php
	session_start();
	include 'config.php';
	$periode = date('d-m-Y');
	$nomor = $_GET['id_transaksi'];
	$nama_pengguna = $_SESSION['username'];
	$periode = date('d-m-Y');
	$tanggal = date('d F Y', strtotime($periode));
	
	$query2 = "SELECT * FROM approve_it WHERE id_transaksi = '$nomor'";
	$hasil2 = $mysqli->query($query2) or die($mysqli->error);
	$obj2 = $hasil2->fetch_object();

	$content = '
		<style type="text/css">
			.container{padding: 40 70 40 40;}
			.tabel{border-collapse: collapse;margin-left: 15px;}
			.tabel th{padding: 8px 5px;}
			.tabel td{padding-left: 5px;}
			.judul{text-align: center; margin-top: 8px; font-weight: 500;margin-bottom: 2px;}
		</style>';

	$content .= '
		<page>
			<div class="container">
				<img src="asset/images/logo.png"; style="width: 10%;" /> 
				<img src="asset/images/logo.png"; style="width: 10%; margin-top: -45px; float: right;"/>
				<hr style="margin-top: 15px;">
                <hr style="margin-top: -13px; height: 5px; background: #000;">
				<h3 class="judul">Bukti Penerimaan Barang</h3>
				
				<p style="margin-bottom: 0;">Nomor Transaksi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<strong> '.$nomor.' </strong></p>

				<p style="margin-bottom: 0;margin-top: 2px">Nama Pengguna &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: '.$obj2->user.'</p>

				<p style="margin-bottom: 0;margin-top: 2px">Tanggal Penyerahan &nbsp;: '.$tanggal.'</p>

				<p style="margin-top: 2px">Divisi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: '.$obj2->level2.'</p>

				<table class="tabel" border="1px">
					<tr>
						<th> No. </th>
						<th style="width: 200px;"> Nama Produk</th>
                		<th> Jumlah </th>
                		<th> Harga </th>
                		<th> Total </th>
                		<th> Satuan </th>
						<th style="width: 150px;"> Keterangan Manager</th>
						<th style="width: 150px;"> Keterangan IT</th>
					</tr>';
						$no = 1;
						$query = "SELECT * FROM approve_it WHERE id_transaksi = '$nomor'";
						$hasil = $mysqli->query($query) or die($mysqli->error);
						while ($obj = $hasil->fetch_object()) {

	$content .='
					<tr>
					  <td>'.$no++.'.</td>
                      <td>'.$obj->product_name.'</td>
                      <td style="text-align: center">'.$obj->units.'</td>
                      <td style="width: 100px;">Rp. '.number_format($obj->price, 0, ",", ".").'</td>
                      <td style="width: 100px;">Rp. '.number_format($obj->total, 0, ",", ".").'</td>
					  <td>PCS</td>
					  <td style="width: 150px;">'.$obj->keterangan.'</td>
					  <td style="width: 150px;">'.$obj->keteranganti.'</td>
					</tr>';
						}
						$total_q = "SELECT  SUM(total) FROM approve_it WHERE id_transaksi = '$nomor'";
						$total = $mysqli->query($total_q) or die($mysqli->error);
						$get = $total->fetch_array();
	$content .='
				<tr>
					<td colspan="4"> <strong>Grand Total</strong></td>
					<td colspan="4"> <strong>Rp. '.number_format($get['SUM(total)'], 0, ",", ".").'</strong></td>
				</tr>
				</table>
				<br><br>
				<p style="text-align: right">Mengetahui,</p> <br><br><br>
				<p style="text-align: right;">(Lorem ipsum dolor)</p>
			</div>
		</page>
	';

	require_once('asset/html2pdf/html2pdf.class.php');;
	$html2pdf = new HTML2PDF('L','A4','en');
	$html2pdf->writeHTML($content);
	$html2pdf->output('laporan-serahterima.pdf','D');
?>