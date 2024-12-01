<?php 

class Users
{
    private $db;

    public function __construct()
    {
        $this->db = new Base();
    }

    public function getUsuario($usuario){
        $this->db->query('SELECT * FROM usuarios WHERE usuario = :user');
        $this->db->bind(':user', $usuario);

        return $this->db->register();
    
    if ($result) {
        return $result;
    } else {
        return false; 
    }
    }

    public function getPerfil($idUsuario){
        $this->db->query('SELECT * FROM perfil WHERE idUsuario = :id');
        $this->db->bind(':id', $idUsuario);

        return $this->db->register();
        return $result ?: false; 
    }

    public function verificarContrasena($datosUsuario, $contrasena)
    {
        if(password_verify($contrasena, $datosUsuario->contrasena)){
            return true;
        }else{
            return false;
        }
     
    }

    // Verifica si el usuario ya existe
    public function verificarUsuario($datosUsuario)
    {
        $this->db->query('SELECT usuario FROM usuarios WHERE usuario = :user');
    $this->db->bind(':user', $datosUsuario['usuario']);
    $this->db->execute();

    return $this->db->count() == 0; // true si el usuario no existe, false si ya existe
    }

    public function register($datosUsuario)
    {
         $this->db->query('INSERT INTO usuarios (idPrivilegio, correo, usuario, contrasena) 
                              VALUES (:privilegio, :correo, :usuario, :contrasena)');
        $this->db->bind(':privilegio', $datosUsuario['privilegio']);
        $this->db->bind(':correo', $datosUsuario['email']);
        $this->db->bind(':usuario', $datosUsuario['usuario']);
        $this->db->bind(':contrasena', $datosUsuario['contrasena']);
    
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
        
    }

    public function connect()
    {
        $this->db->query("SELECT * FROM usuarios"); 
        return $this->db->registers(); 
    }

    public function insertarPerfil($datos)
    {
        
        $this->db->query('INSERT INTO perfil (idUsuario, fotoPerfil, nombreCompleto) 
                          VALUES (:id, :rutaFoto, :nombre)');
        $this->db->bind(':id', $datos['idusuario']);
        $this->db->bind(':rutaFoto', $datos['ruta']);
        $this->db->bind(':nombre', $datos['nombre']);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    
    }
}

