<!DOCTYPE HTML>

<head>
	<title>Learning Vector Quantization</title>
</head>
<style>
	table {
		border-collapse: collapse;
		border-spacing: 0;
	}
</style>

<body style="font-family:verdana;font-size:75%">
	<center>
		<h1>Hasil Klasifikasi Diabetes dengan LVQ</h1>
	</center>
	<center>

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
					$minimal = min($sqrt[0], $sqrt[1]);

					// Looping untuk pembaruan bobot
					for ($x = 0; $x < count($initialWeights); $x++) {
						// Jika jarak bukan minimal
						if ($sqrt[$x] != $minimal) {
							// Bobot tetap
							$initialWeights[$x] = $initialWeights[$x];
						} else { // Jika jarak = minimal
							// Looping untuk kolom huruf & bobot
							for ($y = 0; $y < count($normalizedData[$a]); $y++) {
								// Jika target = kelas
								if ($initialWeights[$x][count($initialWeights[$x]) - 1] == $labels[$a]) {
									$updateWeight = $initialWeights[$x][$y] + ($alpha * ($normalizedData[$a][$y] - $initialWeights[$x][$y]));
									$initialWeights[$x][$y] = $updateWeight;
								} else {
									// Jika target tidak sama dengan kelas
									$updateWeight = $initialWeights[$x][$y] - ($alpha * ($normalizedData[$a][$y] - $initialWeights[$x][$y]));
									$initialWeights[$x][$y] = $updateWeight;
								}
							}
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
					echo "<br>";
					echo "<br>";
				} // End looping per data

				// Update alpha
				$alpha = $alpha * exp(-$beta * ($i + 1));
				echo "Alpha baru: $alpha";
				echo "<br>=========================================================================================================================================================================================================================================================================================================";
			} // End epoc
			//echo "<br>=========================================================================================================================================================================================================================================================================================================";
		} //end isset

		// Hasil pengenalan
		$sum1 = 0;
		$sum2 = 0;

		for ($a = 0; $a < 10; $a++) { // Menggunakan hanya 10 data
			$data[0] = "Outcome(1)";
			$data[1] = "Outcome(0)";
			$data[2] = "Outcome(1)";
			$data[3] = "Outcome(0)";
			$data[4] = "Outcome(1)";
			$data[5] = "Outcome(0)";
			$data[6] = "Outcome(1)";
			$data[7] = "Outcome(0)";
			$data[8] = "Outcome(1)";
			$data[9] = "Outcome(1)";

			$sum = array(0, 0, 0, 0, 0, 0, 0, 0);
			$baris1 = 1;

			for ($x = 0; $x < 2; $x++) { // Baris bobot
				for ($y = 0; $y < 8; $y++) { // Kolom huruf & bobot (sesuai dengan jumlah fitur setelah normalisasi)
					$pangkat[$x][$y] = ($normalizedData[$a][$y] - $initialWeights[$x][$y]) * ($normalizedData[$a][$y] - $initialWeights[$x][$y]);
				}

				for ($y = 0; $y < 8; $y++) {
					$sum[$x] = $sum[$x] + $pangkat[$x][$y];
				}

				$sqrt[$x] = sqrt($sum[$x]); // Nilai d (jarak)
			}

			$minimal = min($sqrt[0], $sqrt[1]);
			echo "<br>";

			for ($y = 0; $y < 2; $y++) {
				if ($minimal == $sqrt[$y]) {
					$cluster = $y;
				}
			}

			echo "Data $data[$a] masuk dalam Kelas $cluster</br>";

			if ($cluster == 0) {
				$sum1++;
			} else {
				$sum2++;
			}
		}

		echo "Cluster 0 sebanyak: $sum1 <br />";
		echo "Cluster 1 sebanyak: $sum2";
		?>

	</center>
</body>

</html>