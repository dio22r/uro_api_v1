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
  <p>Berikut Password Anda yang baru, silahkan login menggunakan password tersebut, kemudian ganti password tersebut dengan password anda pribadi.</p>
  <ul>
    <li>email: <?= $email; ?></li>
    <li>password: <?= $password; ?></li>
  </ul>

</body>

</html>