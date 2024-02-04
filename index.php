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

    a {
      text-decoration: none;
      color: #000;
    }
  </style>
</head>

<body style="font-family:verdana;font-size:75%">
  <!-- Sidebar -->
  <div style="height: 30%; width: 150px; position: fixed; background-color: #f2f2f2; padding: 20px; left: 0; top: 50%; transform: translateY(-50%); border-radius: 5%;">
    <h3>&#9776; Menu</h3>
    <ul style="list-style-type: disc; padding: 0;">
      <li><a href="#data-set">Data Set</a></li>
      <li><a href="#data-normalisasi">Data Normalisasi</a></li>
      <li><a href="#bobot-0">Bobot 0</a></li>
      <li><a href="#data-uji">Data Uji</a></li>
      <li><a href="#normalisasi-data-uji">Normalisasi Data Uji</a></li>
      <li><a href="#input-form">Input Form</a></li>
    </ul>
  </div>

  <h1>Klasifikasi Diabetes dengan LVQ</h1>

  <section id="data-set">
    <h2>Data Set</h2>
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
  </section>

  <section id="data-normalisasi">
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
  </section>

  <section id="bobot-0">
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
          <td><?= $labels[$index + 1] ?></td>
        </tr>
      <?php } ?>
    </table>
  </section>

  <section id="data-uji">
    <h2>Data Uji</h2>
    <table>
      <tr>
        <th>No</th>
        <?php foreach ($header as $colName) { ?>
          <th><?= $colName ?></th>
        <?php } ?>
      </tr>

      <?php foreach ($originalDataTes as $index => $row) { ?>
        <tr>
          <td><?php echo $index + 1 ?></td>
          <?php foreach ($row as $value) { ?>
            <td><?php echo $value ?></td>
          <?php } ?>
          <td><?= $labelsTes[$index] ?></td>
        </tr>
      <?php } ?>
    </table>
  </section>

  <section id="normalisasi-data-uji">
    <h2>Normalisasi Data Uji</h2>
    <table>
      <tr>
        <th>No</th>
        <?php for ($z = 0; $z < 8; $z++) { ?>
          <th>X<?php echo $z + 1 ?></th>
        <?php } ?>
        <th>Outcome</th>
      </tr>

      <?php foreach ($normalizedDataTes as $index => $row) { ?>
        <tr>
          <td><?php echo $index + 1; ?></td>
          <?php foreach ($row as $value) { ?>
            <td><?php echo number_format($value, 2); ?></td>
          <?php } ?>
          <td><?= $labelsTes[$index] ?></td>
        </tr>
      <?php } ?>
    </table>
  </section>

  <section id="input-form">
    <h2><b>Masukkan JUMLAH EPOCH, LEARNING RATE dan konstanta BETA</b></h2>
    <div style="display:flex; justify-content: center;">
      <form method="post" action="lvq.php" target="_blank">
        <div style="display:flex; flex-direction: column; gap: 1px;">
          <input name="iterasi" type="text" size="50" placeholder="epoch" required /><br>
          <input name="alpha" type="text" size="50" placeholder="learning rate" required /><br>
          <input name="beta" type="text" size="50" placeholder="fungsi pembelajaran" required /><br>
          <div style="display:flex; justify-content: center;"><input type="submit" name="sbmt" value="Proses" /></div>
        </div>
    </div>
  </section>
</body>

</html>