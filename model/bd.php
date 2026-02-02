<?php
/**
 * Clase base de acceso a base de datos
 *
 * Gestiona la conexión mediante PDO y ofrece métodos protegidos para
 * consultar, ejecutar sentencias y obtener el último id insertado
 *
 * @package ProyectoTienda - Model
 */

require_once("config.php");

class BD
{
    /** @var PDO|null Conexión a la base de datos */
    private $con = null; // Conexión a la BBDD.

    /** @var string Mensaje de error producido en la última operación */
    private $error = ''; // Mensaje de error.

    /**
     * Crea la conexión con la base de datos usando los datos de configuración
     */
    function __construct()
    {
        $this->error = '';
        try {
            // Creamos la conexión.
            $this->con = new PDO(
                'mysql:host=' . SERVIDOR .
                    ';dbname=' . BASEDATOS .
                    ';charset=utf8',
                USUARIO,
                CONTRASENA
            );
            // Si se logra crear la conexión.
            if ($this->con) {
                // Ponemos los atributos para gestionar los errores con excepciones.
                $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // El juego de caracteres será utf-8
                $this->con->exec('SET CHARACTER SET utf8');
            }
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    /**
     * Cierra la conexión al destruir el objeto
     */
    function __destruct()
    {
        // Cerramos la conexión a la BBDD.
        $this->con = null;
    }

    /**
     * Ejecuta una consulta SELECT y devuelve las filas obtenidas
     *
     * @param string $query Consulta SQL a ejecutar
     * @return array<int, object>|null Filas devueltas o null si no hay resultados
     */
    protected function _consultar($query)
    {
        $this->error = '';
        $filas = null;
        try {
            // Preparamos la consulta...
            $stmt = $this->con->prepare($query);
            // y la ejecutamos.
            $stmt->execute();
            // Si nos devuelve alguna fila...
            if ($stmt->rowCount() > 0) {
                // Creamos el array...
                $filas = array();
                // y lo rellenamos con los datos de la consulta.
                while ($registro = $stmt->fetchObject())
                    $filas[] = $registro;
            }
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
        // Devolvemos las filas obtenidas de la consulta.
        return $filas;
    }

    /**
     * Ejecuta una sentencia de inserción, modificación o borrado
     *
     * @param string $query Sentencia SQL a ejecutar
     * @return int Número de filas afectadas
     */
    protected function _ejecutar($query)
    {
        $this->error = '';
        $filas = 0;
        try {
            // Ejecutamos la sentencia y guardamos el número de filas afectadas.
            $filas = $this->con->exec($query);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
        // Devolvemos el número de filas afectadas.
        return $filas;
    }

    /**
     * Obtiene el id de la última fila insertada
     *
     * @return string Id generado por la base de datos
     */
    protected function _ultimoId()
    {
        // Devolvemos el id de la última fila insertada.
        return $this->con->lastInsertId();
    }

    /**
     * Devuelve el último mensaje de error registrado
     *
     * @return string Mensaje de error
     */
    public function GetError()
    {
        // Obtenemos el mensaje del error, si este se produce.
        return $this->error;
    }

    /**
     * Indica si se ha producido algún error en la última operación
     *
     * @return bool True si hay error, false si no
     */
    public function Error()
    {
        // Indicamos si ha habido algún error.
        return ($this->error != '');
    }
}
