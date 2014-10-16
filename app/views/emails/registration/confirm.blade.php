<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido a Sueños de vida</title>
</head>
<body>
<p>Gracias por registrarte a sueños de vida, puedes ingresar a tu cuenta con el correo <strong>{{ $email }}</strong>  y la contraseña utilizada en el proceso de registro</p>
<p>Tambien puedes compartir esta url {{ URL::to('/'.$username) }} con otros usuarios para que se agreguen a tu red. </p>

</body>
</html>