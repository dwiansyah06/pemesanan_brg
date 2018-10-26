<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}
	include 'config.php';
	$periode = date('d-m-Y');
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
				<h3 class="judul">Report of transactions</h3>
				<p style="text-align: right; margin-right: 30px;margin-bottom: 0">Periode : '.$mulai.' - '.$akhir.'</p>
				<p style="text-align: right; margin-right: 30px;">Level Filter : <strong>'.$lvl.'</strong></p>
				<table class="tabel" border="1px">
						<tr>
							<th>No.</th>
							<th style="width: 200px;">Divisi</th>
							<th style="width: 120px;">Pemakaian</th>
						</tr>';
						$no = 1;
						if ($tgl_awal == 'all') {
							$query = "SELECT  level2, SUM(total) FROM approve_it GROUP BY level2";
						} else{
							if ($lvl == 'all') {
								$query = "SELECT  level2, SUM(total) FROM approve_it WHERE date BETWEEN '$tgl_awal' AND '$tgl_akhir' GROUP BY level2";
							}else{
								$level_filter = $_SESSION['level_filter'];
								$query = "SELECT  level2, SUM(total) FROM approve_it WHERE date BETWEEN '$tgl_awal' AND '$tgl_akhir' AND level2 in($level_filter) GROUP BY level2";
							}
						}
						
						$hasil = $mysqli->query($query) or die($mysqli->error);
						$total=0;
						
						while ($obj = $hasil->fetch_array()) {
							//$total = number_format($obj['SUM(total)'], 0, ",", ".");
							$content .='
								<tr>
									<td align="center">'.$no++.'.</td>
									<td style="width: 200px;">'.$obj['level2'].'</td>
									<td style="width: 120px;">Rp. '.number_format($obj['SUM(total)'], 0, ",", ".").'</td>
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
	$html2pdf->output('laporan-pemakaian-'.$periode.'.pdf','D');
?>