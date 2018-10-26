<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}
	include 'config.php';
	$periode = date('d-m-Y');
	$level = $_SESSION['level'];
	$tgl_awal = $_GET['tgl_start'];
	$tgl_akhir = $_GET['tgl_finish'];
	$lvl = $_GET['level'];

	if ($tgl_awal === 'all') {
		$mulai = 'all';
		$akhir = 'all';
	} else {
		$mulai = date('d F Y', strtotime($tgl_awal));
		$akhir = date('d F Y', strtotime($tgl_akhir));
	}

	$content = '
		<style type="text/css">
			.container{padding: 5 35 5 5;}
			.tabel{border-collapse: collapse;margin-left: 30px;}
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
				<p style="text-align: right; margin-right: 30px;margin-bottom: 0">Periode : '.$mulai.' - '.$akhir.'</p>
				<p style="text-align: right; margin-right: 30px;">Level Filter : <strong>'.$lvl.'</strong></p>
				<table class="tabel" border="1px">
						<tr>
							<th style="width: 5%;">No.</th>
							<th style="width: 10%;">Id Transaction</th>
							<th style="width: 22%;">Divisi</th>
							<th style="width: 20%;">Product Name</th>
							<th style="width: 12%;">Harga</th>
							<th style="width: 4%;">Qty</th>
							<th style="width: 12%;">Total Harga</th>
							<th style="width: 10%;">Tanggal</th>
						</tr>';
						$no = 1;
						if ($tgl_awal == 'all') {
							$query = "SELECT * FROM approve_it";
						} else {
							$start = $_SESSION['start'];
							$finish = $_SESSION['finish'];
							if ($lvl == 'all') {
								$query = "SELECT * FROM approve_it WHERE date BETWEEN '$start' AND '$finish' ";
							} else {
								$level_filter = $_SESSION['level_filter'];
								$query = "SELECT * FROM approve_it WHERE date BETWEEN '$start' AND '$finish' AND level2 in($level_filter) ";
							}
						}
						
						$hasil = $mysqli->query($query) or die($mysqli->error);
						while ($obj = $hasil->fetch_object()) {
							$content .='
								<tr>
									<td style="width: 5%;" align="center">'.$no++.'.</td>
									<td style="width: 10%;" align="center">'.$obj->id_transaksi.'</td>
									<td style="width: 22%;">'.$obj->level2.'</td>
									<td style="width: 20%;">'.$obj->product_name.'</td>
									<td style="width: 12%;">Rp. '.number_format($obj->price, 0, ",", ".").'</td>
									<td style="width: 4%;">'.$obj->units.'</td>
									<td style="width: 12%;">Rp. '.number_format($obj->total, 0, ",", ".").'</td>
									<td style="width: 10%;">'.date('d F Y',strtotime($obj->date)).'</td>
								</tr>
							';
						}
	$content .='
				</table>
			</div>
		</page>
	';

	require_once('asset/html2pdf/html2pdf.class.php');;
	$html2pdf = new HTML2PDF('L','A4','en');
	$html2pdf->writeHTML($content);
	$html2pdf->output('laporan-transactions-'.$periode.'.pdf','D');
?>