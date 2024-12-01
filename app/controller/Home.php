<?php

session_start();

class Home extends Controller
{
    public function __construct()
    {
        $this->usuario = $this->model("users");
    }

    public function index() {
        if (isset($_SESSION['logueado'])) {
            $datosUsuario = $this->usuario->getUsuario($_SESSION['usuario']);
            $datosPerfil = $this->usuario->getPerfil($_SESSION['logueado']);
    
            if ($datosUsuario) {
                if ($datosPerfil) {
                    // Si el perfil está completo, redirige a la página principal
                    $datosRed = [
                        'usuario' => $datosUsuario,
                        'perfil' => $datosPerfil
                    ];
                    $this->view('pages/home', $datosRed); 
                } else {
                    // Si no tiene perfil, muestra la página para completar perfil
                    $this->view('pages/perfil/completarPerfil', $_SESSION['logueado']);/////////////////////////////////////////////////////////////////////
                }
            } else {
                // Si el usuario no existe en la base de datos, cerrar sesión y redirigir
                session_destroy();
                redirect('/home/login');
            }
        } else {
            // Si no está logueado, redirige al login
            redirect('/home/login');
        }
    }

    public function login(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $datosLogin = [
                'usuario' =>trim($_POST['usuario']),
                'contrasena' =>trim($_POST['contrasena'])
            ];

            $datosUsuario = $this->usuario->getUsuario($datosLogin['usuario']);

            //echo '<pre>';
            //var_dump($datosUsuario);
            //echo '</pre>';
            //die();

            if($this->usuario->verificarContrasena($datosUsuario, $datosLogin['contrasena'])){
                $_SESSION['logueado'] = $datosUsuario->idPrivilegio;
                $_SESSION['usuario'] = $datosUsuario->usuario;
                redirect('/home');
            }else{
                $_SESSION['errorLogin'] = 'El usuario o la contraseña son incorrectos';
                redirect('/home');
            }
        }else{
            if(isset($_SESSION['logueado'])){
                redirect('/home');
            }else{
                $this->view('pages/login');
            }
        }       
    }

    public function register(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $datosRegristro = [
                'privilegio' => '2',
                'email' => trim($_POST['email']),
                'usuario' => trim($_POST['usuario']),
                'contrasena' => password_hash(trim($_POST['contrasena']), PASSWORD_DEFAULT)
            ];

            if($this->usuario->verificarUsuario($datosRegristro)){
                if($this->usuario->register($datosRegristro)){
                    $_SESSION['loginComplete'] = 'Tu registro se ha completado satisfactoriamente, ahora puedes ingresar';
                    redirect('/home');
                }else{ }
            }else{
                    $_SESSION['usuarioError'] = 'El usuario no esta disponible, intenta con otro usuario';
                    $this->view('pages/register');
            }
        }else{
            if(isset($_SESSION['logueado'])){
                redirect('/home');
            }else{
                $this->view('pages/register');
            }
        }           

    }

    public function insertarRegistrosPerfil()
{
    //echo('<pre>');
    //var_dump($_POST);

    $carpeta = 'C:/xampp/htdocs/redsocial/public/img/imagenesPerfil/';
    opendir($carpeta);

    $rutaImagen = 'img/imagenesPerfil/' . $_FILES['imagen']['name'];
    $ruta = $carpeta . $_FILES['imagen']['name'];
    copy($_FILES['imagen']['tmp_name'], $ruta);
    
    $datos = [
        'idusuario' => trim($_POST['id_user']),
        'nombre' => trim($_POST['nombre']),
        'ruta' => $rutaImagen
    ];

    if ($this->usuario->insertarPerfil($datos)) {
        redirect('/home'); 
    } else {
        echo 'El perfil no se ha guardado';
    }
}


    public function logout()
    {
        session_start();

        $_SESSION = [];

        session_destroy();

        redirect('/home');
    }

}