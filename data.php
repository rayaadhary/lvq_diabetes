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

$csvFileTest = fopen('data_tes.csv', 'r');
$originalDataTes = array();
$labelsTes = array();

while (($row = fgetcsv($csvFileTest)) !== false) {
  // Ambil kolom yang diinginkan untuk data
  $originalDataTes[] = array_slice($row, 0, 8);
  $labelsTes[] = $row[8];
}

fclose($csvFileTest);


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



// Normalisasi data set
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

// Normalisasi data tes
for ($i = 0; $i < count($originalDataTes[0]); $i++) {
  // Ambil kolom ke-i
  $column = array_column($originalDataTes, $i);

  // Hitung mean dan standar deviasi
  $mean = calculateMean($column);
  $stdDev = calculateStdDev($column);

  // Normalisasi data
  for ($j = 0; $j < count($originalDataTes); $j++) {
    $normalizedDataTes[$j][$i] = ($originalDataTes[$j][$i] - $mean) / $stdDev;
  }
}

$initialWeights = array_slice($normalizedData, 1, 2);
