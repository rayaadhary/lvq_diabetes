<!DOCTYPE HTML>

<head>
	<title>Learning Vector Quantization</title>
</head>
<style>
	table {
		border-collapse: collapse;
		border-spacing: 0;
	}

	a {
		text-decoration: none;
		color: #000;
	}
</style>

<body style="font-family:verdana;font-size:75%">
	<!-- Sidebar -->
	<div style="height: 30%; width: 150px; position: fixed; background-color: #f2f2f2; padding: 20px; left: 0; top: 50%; transform: translateY(-50%); border-radius: 5%;">
		<h3>&#9776; Menu</h3>
		<ul style="list-style-type: disc; padding: 0;">
			<li><a href="#hasil-klasifikasi">Hasil Klasifikasi</a></li>
			<li><a href="#hasil-uji">Hasil Uji</a></li>
		</ul>
	</div>

	<center>
		<section id="hasil-klasifikasi">
			<h1>Hasil Klasifikasi Diabetes dengan LVQ</h1>
		</section>

		<?php
		include_once "data.php";

		if (isset($_POST['sbmt'])) {
			$iterasi = $_POST['iterasi'];
			$alpha = $_POST['alpha'];
			$beta = $_POST['beta'];

			//penghitungan LVQ
			//looping epoch
			// Looping untuk penghitungan LVQ
			for ($i = 0; $i < $iterasi; $i++) {
				// Looping perdata
				for ($a = 0; $a < count($normalizedData); $a++) {
					$sum = array_fill(0, 2, 0); // Inisialisasi array sum dengan nilai 0
					$baris1 = 1;

					// Looping baris bobot
					for ($x = 0; $x < count($initialWeights); $x++) {
						// Looping kolom huruf & bobot
						for ($y = 0; $y < count($normalizedData[$a]); $y++) {
							$pangkat[$x][$y] = pow($normalizedData[$a][$y] - $initialWeights[$x][$y], 2);
						}

						// Menghitung sum
						$sum[$x] = array_sum($pangkat[$x]);

						// Menghitung euclidean distance
						$sqrt[$x] = sqrt($sum[$x]);
					}

					// Cari jarak minimal
					// Cari jarak minimal
					$minimal = min($sqrt[0], $sqrt[1]);

					// Looping untuk pembaruan bobot
					for ($x = 0; $x < count($initialWeights); $x++) {
						// Jika jarak = minimal
						if ($sqrt[$x] == $minimal) {
							// Pembaruan bobot hanya pada bobot pemenang
							for ($y = 0; $y < count($normalizedData[$a]); $y++) {
								// Jika target = kelas
								if ($initialWeights[$x][count($initialWeights[$x]) - 1] == $labels[$a]) {
									$updateWeight = $initialWeights[$x][$y] + ($alpha * ($normalizedData[$a][$y] - $initialWeights[$x][$y]));
									$initialWeights[$x][$y] = $updateWeight;
									// echo "Updated weight: " . $updateWeight . "\n"; // Pesan debugging
								}
							}
							break; // Keluar dari loop setelah pembaruan pertama
						}
					}

					// Menampilkan hasil seperti yang diinginkan
					$e = $i + 1;
					echo "</br><h2><b>Epoch ke $e</b></h2>"; ?>

					<table border="1">
						<h2><b>Euclidean Distance | data ke <?php echo $a + 1 ?> </b></h2>
						<tr BGCOLOR="gray"><?php for ($z = 0; $z < 2; $z++) { ?>
								<td> d<?php echo  $z + 1; ?></td><?php } ?>
						</tr>
						<tr><?php for ($z = 0; $z < 2; $z++) { ?>
								<td><?php echo number_format($sqrt[$z], 4) ?></td><?php } ?>
						</tr>
					</table>

					<table border="1">
						<h2><b>Bobot | data ke <?php echo $a + 1 ?></b></h2>
						<tr BGCOLOR="gray">
							<td>No</td>
							<?php for ($z = 0; $z < 8; $z++) { ?>
								<td width="60">W<?php echo $z + 1 ?></td>
							<?php } ?>
						</tr>

						<?php for ($z = 0; $z < 2; $z++) { ?>
							<tr>
								<td><?php echo $baris1++ ?></td>
								<?php for ($y = 0; $y < 8; $y++) { ?>
									<td><?php echo number_format($initialWeights[$z][$y], 4) ?></td>
								<?php }
								?>
							</tr>
						<?php } ?>
					</table>
		<?php
					echo "<br>";
				} // End looping per data

				// Update alpha
				$alpha = $alpha * exp(-$beta * ($i + 1));
				// $alpha = $alpha - $alpha * (-$beta * ($i + 1));
				echo "Alpha baru: $alpha";
				echo "<hr>";
				echo "<br>";
			} // End epoch			
		} //end isset
		// Hasil pengenalan

		$sum1 = 0;
		$sum2 = 0;
		?>
		<section id="hasil-uji">
			<table border="1">
				<thead>
					<tr BGCOLOR="gray">
						<th>No</th>
						<th>Data</th>
						<th>Bobot 0</th>
						<th>Bobot 1</th>
						<th>Minimum</th>
						<th>Outcome</th>
					</tr>
				</thead>
				<tbody>
					<?php
					echo "Hasil Uji:";
					for ($a = 0; $a < count($normalizedDataTes); $a++) {
						$sum = array_fill(0, count($initialWeights), 0); // Reset variabel sum
						$baris1 = 1;

						for ($x = 0; $x < count($initialWeights); $x++) {
							for ($y = 0; $y < count($normalizedDataTes[$a]); $y++) {
								$pangkat[$x][$y] = ($normalizedDataTes[$a][$y] - $initialWeights[$x][$y]) * ($normalizedDataTes[$a][$y] - $initialWeights[$x][$y]);
							}

							for ($y = 0; $y < count($normalizedDataTes[$a]); $y++) {
								$sum[$x] += $pangkat[$x][$y]; // Perbaiki penjumlahan nilai sum
							}

							$sqrt[$x] = sqrt($sum[$x]);

							// Pencetakan nilai untuk debugging
						}

						// Pembaruan bobot dilakukan setelah perhitungan Euclidean Distance
						$idxMin = array_search(min($sqrt), $sqrt);
						for ($y = 0; $y < count($normalizedDataTes[$a]); $y++) {
							$updateWeight = $initialWeights[$idxMin][$y] + ($alpha * ($normalizedDataTes[$a][$y] - $initialWeights[$idxMin][$y]));
							$initialWeights[$idxMin][$y] = $updateWeight;
						}

						// Tampilkan hasil pada baris tabel					
					?>
						<tr align="center">
							<td><?= $a + 1 ?></td>
							<td>
								<?php
								$formattedValues = array_map(function ($value) {
									return number_format($value, 2);
								}, $normalizedDataTes[$a]);
								echo implode(', ', $formattedValues);
								?>
							</td>
							<td><?= number_format($sqrt[0], 2) ?></td>
							<td><?= number_format($sqrt[1], 2) ?></td>
							<td><?= number_format(min($sqrt), 2) ?></td>
							<td><?= $idxMin ?></td>
						</tr>
					<?php
					}
					// }
					?>
				</tbody>
			</table>
		</section>
	</center>
</body>

</html>