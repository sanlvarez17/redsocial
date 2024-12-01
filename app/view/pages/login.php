<?php
// Puedes agregar lógica PHP aquí para manejar el formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $contraseña = $_POST['contraseña'] ?? '';
    // Aquí puedes agregar validaciones o conexiones a la base de datos
    if ($usuario === 'admin' && $contraseña === 'password') {
        echo "";
    } else {
        echo "Credenciales inválidas";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Iniciar sesión</title>
    <link rel="icon" type="image/png" href="https://images.vexels.com/media/users/3/132335/isolated/preview/4af43ce1082231cba5e5aa60fbb03f2f-iconos-de-circulo-de-personal.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #b0b0b0, #e0e0e0);
            color: #333;
            font-family: 'Roboto', sans-serif;
        }
        .login-container {
            display: flex;
            align-items: center;
            background-color: #fff;
            padding: 70px;
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            color: #333;
        }
        .login-form {
            margin-right: 80px;
        }
        .login-form h2 {
            font-size: 50px;
            margin-bottom: 20px;
            color: #000000;
            font-family: 'Lobster', cursive;
        }
        .form-control {
            border-radius: 30px;
            margin-bottom: 15px;
            padding: 15px 20px;
            border: 1px solid #ddd;
        }
        .btn-primary {
            background-color: #000000;
            border: none;
            border-radius: 30px;
            padding: 15px 20px;
            width: 100%;
            font-size: 18px;
        }
        .btn-primary:hover {
            background-color: #007bff;
        }
        .register-link {
            display: block;
            text-align: center;
            margin-top: 40px;
        }
        .register-link a {
            color: #007bff;
            text-decoration: underline;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
        .illustration {
            text-align: center;
        }
        .illustration h1 {
            font-size: 70px;
            margin-bottom: 20px;
            color: #007bff;
            font-family: 'Lobster', cursive;
        }
        .illustration img {
            max-width: 200px;
            border-radius: 20px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <h2>Iniciar sesión</h2>
            <form method="POST" action="<?php echo URL_PROJECT?>/home/login">
                <input type="text" class="form-control" name="usuario" placeholder="Usuario" required>
                <input type="password" class="form-control" name="contrasena" placeholder="Contraseña" required>
                <button type="submit" class="btn btn-primary">Ingresar</button>
            </form>

            <?php if(isset($_SESSION['errorLogin'])) : ?>
                <div class="alert alert-danger alert-dismissible fade show mt-2 mb-2" role="alert">
                <?php echo $_SESSION['errorLogin'] ?>
            </div>
            <?php unset($_SESSION['errorLogin']); 
            endif?>

            <?php if(isset($_SESSION['loginComplete'])) : ?>
                <div class="alert alert-success alert-dismissible fade show mt-2 mb-2" role="alert">
                <?php echo $_SESSION['loginComplete'] ?>
            </div>
            <?php unset($_SESSION['loginComplete']); 
            endif?>

            <div class="register-link">
                <span>¿No tienes una cuenta?</span><a href="<?php echo URL_PROJECT?>/home/register">Registrarme</a>
            </div>
        </div>
        <div class="illustration">
            <h1>LensConnect</h1>
            <img src="https://img.freepik.com/vector-premium/icono-aislado-aplicacion-camara-fotos-digital_8071-7026.jpg" alt="Illustration of people interacting with a large mobile phone displaying a social media app">
        </div>
    </div>
</body>
</html>
