<?php 
    session_start();

    class Conectar{
        protected $dbh;
        //Creacion metodo para acceder a la conexión.
        protected function Conexion(){
            try{
                $conectar = $this->dbh = new PDO("mysql:local=localhost;dbname=par_queadero", "root", "");
                return $conectar;
            } catch (Exception $e) {
                print "Se ha producido un error en la conexión: " . $e->getMessage()."<br/>";
                die();
            }
        }

        //Enviar los caracteres especiales
        public function set_names(){
            return $this->dbh->query("SET NAMES 'utf-8'");
        }

        //ruta raiz del sistema
        public function ruta(){
            return "http://localhost/Digital-parking/";
        }
    }
?>