<?php 
    class Cliente{
        private $conn;
        private $table_cliente = "tb_clientes";

        public $idCliente;
        public $nombreCliente;
        public $apellidoCliente;
        public $domicilioCliente;
        public $correoCliente;
        public $claveCliente;

        public function __construct($db) {
            $this->conn = $db;
        }

        // Función para crear un nuevo cliente
        public function crearCliente(){
            $query = "INSERT INTO $this->table_cliente (nombreCliente, apellidoCliente, domicilioCliente, correoCliente) VALUES (:nombreCliente, :apellidoCliente, :domicilioCliente, :correoCliente)";
            $stmt = $this->conn->prepare($query);

            // Limpia y filtra los datos antes de insertarlos en la base de datos
            $this->nombreCliente = htmlspecialchars(strip_tags($this->nombreCliente));
            $this->apellidoCliente = htmlspecialchars(strip_tags($this->apellidoCliente));
            $this->domicilioCliente = htmlspecialchars(strip_tags($this->domicilioCliente));
            $this->correoCliente = htmlspecialchars(strip_tags($this->correoCliente));

            $stmt->bindParam(":nombreCliente", $this->nombreCliente);
            $stmt->bindParam(":apellidoCliente", $this->apellidoCliente);
            $stmt->bindParam(":domicilioCliente", $this->domicilioCliente);
            $stmt->bindParam(":correoCliente", $this->correoCliente);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
        // Función para crear un leer cliente por ID
        public function leerCliente(){
            $query = "SELECT idCliente, nombreCliente, apellidoCliente, domicilioCliente, correoCliente FROM $this->table_cliente WHERE idCliente = ? ";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1, $this->idCliente);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->idCliente = $row['idCliente'];
            $this->nombreCliente = $row['nombreCliente'];
            $this->apellidoCliente = $row['apellidoCliente'];
            $this->domicilioCliente = $row['domicilioCliente'];
            $this->correoCliente = $row['correoCliente'];
        }
        // Función para crear un leer clientes
        public function leerClientes(){
            $query = "SELECT idCliente, nombreCliente, apellidoCliente, domicilioCliente, correoCliente FROM $this->table_cliente";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt;
        }
        // Función para crear un actualizar cliente
        public function actualizarCliente(){
            $query = "UPDATE $this->table_cliente SET nombreCliente = :nombreCliente, apellidoCliente = :apellidoCliente, domicilioCliente = :domicilioCliente, correoCliente = :correoCliente WHERE idCliente = :idCliente";
            $stmt = $this->conn->prepare($query);

            // Limpia y filtra los datos antes de insertarlos en la base de datos
            $this->nombreCliente = htmlspecialchars(strip_tags($this->nombreCliente));
            $this->apellidoCliente = htmlspecialchars(strip_tags($this->apellidoCliente));
            $this->domicilioCliente = htmlspecialchars(strip_tags($this->domicilioCliente));
            $this->correoCliente = htmlspecialchars(strip_tags($this->correoCliente));

            $stmt->bindParam(":idCliente", $this->idCliente);
            $stmt->bindParam(":nombreCliente", $this->nombreCliente);
            $stmt->bindParam(":apellidoCliente", $this->apellidoCliente);
            $stmt->bindParam(":domicilioCliente", $this->domicilioCliente);
            $stmt->bindParam(":correoCliente", $this->correoCliente);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
        // Función para crear un eliminar cliente
        public function eliminarCliente(){
            $query = "DELETE FROM $this->table_cliente WHERE idCliente = ?";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1, $this->idCliente);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
        // Función para login usurario
        public function loginUsuario(){
            
            if($this->correoCliente =='austin@gmail.com' &&  $this->claveCliente ==  '2909'){
                return true;
            }else{
                return false;
            }

            // $query = "SELECT * FROM $this->table_cliente WHERE correoCliente = '?' and claveCliente = '?'";
            // $stmt = $this->conn->prepare($query);
            // $stmt->bindParam(":correoCliente", $this->$correoCliente);
            // $stmt->bindParam(":claveCliente", $this->$claveCliente);
            // if ($stmt->execute()) {
            //     return true;
            // } else {
            //     return false;
            // }
        }
    }
?>