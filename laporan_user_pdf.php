<?php
	include 'config.php';

	$content = '
		<style type="text/css">
			.container{padding: 40 40 40 40;}
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
				<h3 class="judul">REPORT OF <strong>USER</strong></h3>
				<table class="tabel" border="1px">
						<tr>
							<th>No.</th>
							<th style="width: 150px;">Username</th>
							<th style="width: 150px;">Password</th>
							<th style="width: 50px;">Level</th>
						</tr>';
						$no = 1;
						$query = "SELECT  username, password, level FROM user";
						$hasil = $mysqli->query($query) or die($mysqli->error);
						while ($obj = $hasil->fetch_object()) {
							$content .='
								<tr>
									<td align="center">'.$no++.'.</td>
									<td style="width: 150px;">'.$obj->username.'</td>
									<td style="width: 150px;">'.$obj->password.'</td>
									<td style="width: 250px;">'.$obj->level.'</td>
								</tr>
							';
						}
	$content .='
				</table>
			</div>
		</page>
	';

	require_once('asset/html2pdf/html2pdf.class.php');
	$html2pdf = new HTML2PDF('p','A4','en');
	$html2pdf->writeHTML($content);
	$html2pdf->output('laporan-user.pdf','D');
?>