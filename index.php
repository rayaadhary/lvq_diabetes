<?php
include_once "data.php";

$baris = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Klasifikasi Diabetes dengan LVQ</title>
  <style>
    table {
      border-collapse: collapse;
      border-spacing: 0;
      margin: 20px auto;
      /* Menengahkan tabel */
    }

    th,
    td {
      border: 1px solid black;
      padding: 8px;
      text-align: center;
    }

    th {
      background-color: gray;
    }

    h1,
    h2 {
      text-align: center;
      font-weight: bold;
    }
  </style>
</head>

<body>
  <h1>Klasifikasi Diabetes dengan LVQ</h1>

  <h2>Data Asli</h2>
  <table>
    <tr>
      <th>No</th>
      <?php foreach ($header as $colName) { ?>
        <th><?= $colName ?></th>
      <?php } ?>
    </tr>

    <?php foreach ($originalData as $index => $row) { ?>
      <tr>
        <td><?php echo $index + 1; ?></td>
        <?php foreach ($row as $value) { ?>
          <td><?php echo $value ?></td>
        <?php } ?>
        <td><?= $labels[$index] ?></td>
      </tr>
    <?php } ?>
  </table>

  <h2>Data Normalisasi</h2>
  <table>
    <tr>
      <th>No</th>
      <?php for ($z = 0; $z < 8; $z++) { ?>
        <th>X<?php echo $z + 1 ?></th>
      <?php } ?>
      <th>Outcome</th>
    </tr>

    <?php foreach ($normalizedData as $index => $row) { ?>
      <tr>
        <td><?php echo $index + 1; ?></td>
        <?php foreach ($row as $value) { ?>
          <td><?php echo number_format($value, 2); ?></td>
        <?php } ?>
        <td><?= $labels[$index] ?></td>
      </tr>
    <?php } ?>
  </table>

  <h2>Bobot 0</h2>
  <table>
    <tr>
      <th>No</th>
      <?php for ($z = 0; $z < 8; $z++) { ?>
        <th>X<?php echo $z + 1 ?></th>
      <?php } ?>
      <th>Outcome</th>
    </tr>

    <?php foreach ($initialWeights as $index => $row) { ?>
      <tr>
        <td><?php echo $index + 1; ?></td>
        <?php foreach ($row as $value) { ?>
          <td><?php echo number_format($value, 2); ?></td>
        <?php } ?>
        <td><?= $labels[$index] ?></td>
      </tr>
    <?php } ?>
  </table>

  <h2><b>Masukkan JUMLAH EPOCH, LEARNING RATE dan konstanta BETA</b></h2>
  <div style="display:flex; justify-content: center;">
    <form method="post" action="lvq.php">

      <div style="display:flex; flex-direction: column; gap: 1px;">
        <input name="iterasi" type="text" value="" size="50" placeholder="epoch" /><br>
        <input name="alpha" type="text" value="" size="50" placeholder="learning rate" /><br>
        <input name="beta" type="text" value="" size="50" placeholder="beta value" /><br>
        <div style="display:flex; justify-content: center;"><input type="submit" name="sbmt" value="Proses" /></div>
      </div>
  </div>
</body>

</html>