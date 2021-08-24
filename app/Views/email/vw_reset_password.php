<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password</title>
</head>

<body>
  <p>
    <?php if ($status) { ?>
      Password berhasil di reset, password yang baru sudah di kirim ke email anda, silahkan periksa email anda.
    <?php } else { ?>
      Reset Password Gagal.
    <?php } ?>
  </p>

</body>

</html>