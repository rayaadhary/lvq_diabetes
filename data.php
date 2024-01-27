<?php
// Baca file CSV
$csvFile = fopen('diabetes.csv', 'r');

// Inisialisasi array untuk menyimpan data dan label
$originalData = array();
$normalizedData = array();
$labels = array();

// Baca baris pertama untuk mengabaikan header
$header = fgetcsv($csvFile);

// Baca baris demi baris
while (($row = fgetcsv($csvFile)) !== false) {
  // Ambil kolom yang diinginkan untuk data
  $originalData[] = array_slice($row, 0, 8);
  $labels[] = $row[8];
}

// Tutup file CSV
fclose($csvFile);

// Fungsi untuk menghitung mean dari sebuah array
function calculateMean($array)
{
  return array_sum($array) / count($array);
}

// Fungsi untuk menghitung standar deviasi dari sebuah array
function calculateStdDev($array)
{
  $mean = calculateMean($array);
  $sumSquaredDiff = 0;

  foreach ($array as $value) {
    $sumSquaredDiff += pow($value - $mean, 2);
  }

  return sqrt($sumSquaredDiff / count($array));
}

// Normalisasi data
for ($i = 0; $i < count($originalData[0]); $i++) {
  // Ambil kolom ke-i
  $column = array_column($originalData, $i);

  // Hitung mean dan standar deviasi
  $mean = calculateMean($column);
  $stdDev = calculateStdDev($column);

  // Normalisasi data
  for ($j = 0; $j < count($originalData); $j++) {
    $normalizedData[$j][$i] = ($originalData[$j][$i] - $mean) / $stdDev;
  }
}

$initialWeights = array_slice($normalizedData, 0, 2);
