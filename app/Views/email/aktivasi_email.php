<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?></title>
</head>

<body>
  <p>Dear <?= $nama ?>,</p>
  <p>Silahkan Klik Link berikut untuk melakukan aktivasi user anda di Aplikasi URO.</p>
  <p>
    <a href="<?= $url; ?>" target="_blank" style="padding:10px; color:white; background: blue; text-decoration:none;">Aktivasi User</a>
  </p>

</body>

</html>