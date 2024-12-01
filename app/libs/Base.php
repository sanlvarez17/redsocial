<?php

class Base
{
    protected $dbhost = DB_HOST;
    protected $dbname = DB_NAME;
    protected $dbuser = DB_USER;
    protected $dbpass = DB_PASSWORD;

    private $cnx;
    private $stmt;
    private $error;

    public function __construct()
    {
        $dbh = "mysql:host=" . $this->dbhost . ";dbname=" . $this->dbname;

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Manejo de errores como excepciones
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, // Obtención predeterminada como objeto
        ];

        try {
            $this->cnx = new PDO($dbh, $this->dbuser, $this->dbpass, $options);
            $this->cnx->exec("set names utf8"); // Asegura la codificación UTF-8
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo "Error de conexión: " . $this->error;
            $this->cnx = null; // Evita intentos de uso en caso de error
        }
    }

    // Prepara una consulta SQL
    public function query($sql)
    {
        if ($this->cnx) {
            $this->stmt = $this->cnx->prepare($sql);
        } else {
            $this->stmt = null; // Evita errores si no hay conexión
        }
        return $this->stmt;
    }

    // Ejecuta la consulta preparada
    public function execute()
    {
        try {
            return $this->stmt->execute();
        } catch (PDOException $e) {
            die('Error en la ejecución: ' . $e->getMessage());
        }
    }

    // Vincula un valor a un parámetro de la consulta
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
                    break;
            }
        }

        if ($this->stmt) {
            $this->stmt->bindValue($param, $value, $type);
        }
    }

    // Obtiene un único registro
    public function register()
    {
        return ($this->execute() && $this->stmt)
            ? $this->stmt->fetch() // Cambié el nombre de la función `fetch` por la correcta.
            : null;
    }

    // Obtiene múltiples registros
    public function registers()
    {
        return ($this->execute() && $this->stmt)
            ? $this->stmt->fetchAll() // Cambié el nombre de la función `fetchAll` por la correcta.
            : [];
    }

    // Obtiene el número de filas afectadas
    public function count()
    {
        return $this->stmt->rowCount();
    }

    // Método adicional para obtener los errores de la última ejecución SQL
    public function getError()
    {
        return $this->error;
    }
}
