<?php
    class Database {
        private $host = '45.89.204.4';
        private $db_name = 'u115254492_apidck';
        private $username = 'u115254492_rootdck';
        private $password = 'N4v[uGo7?';

        public $conn;
        public function conectar() {
            $this->conn = null;
            try {
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                echo "Error de conexión: " . $e->getMessage();
            }
            return $this->conn;
        }
    }
?>