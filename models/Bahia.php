<?php 
    require_once 'Usuario.php';
    require_once 'Cliente.php';
    require_once 'Vehiculo.php';
    require_once 'Ticket.php';
    class Bahia extends Conectar{
        //Insertar una nueva bahia
        public function insertBahia($noEstacionamiento, $placa, $documento, $descripcion){
            $conectar = parent::Conexion();

            $sql= " INSERT INTO estacionamientos (id_estacionamiento, Num_estacionamiento, id_vehiculo, id_cliente, Estado_estacionamiento, esta_descripcion, fecha_creacion, hora_creacion, est) VALUES (NULL, ?,?,?,'Activo',?, CURRENT_DATE, CURRENT_TIME, 1);";

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $noEstacionamiento);
            $sql->bindValue(2, $placa);
            $sql->bindValue(3, $documento);
            $sql->bindValue(4, $descripcion);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        //Traer bahías activas
        public function getBahiasActivas(){
            $conectar = parent::Conexion();

            $sql="  SELECT  e.id_estacionamiento, te.Id_ticket_entrada, 
                            e.Num_estacionamiento, e.id_vehiculo, 
                            e.id_cliente, e.Estado_estacionamiento, 
                            e.esta_descripcion, e.fecha_creacion, e.hora_creacion
                    FROM estacionamientos e, tickets_entrada te 
                    WHERE e.Estado_estacionamiento = 'Activo' 
                    AND e.id_estacionamiento = te.id_estacionamiento 
                    AND e.est = 1;";

            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        //Retirar bahía activa
        public function retirarBahiaActiva($id, $id_entrada, $id_usuario){
            $usuario = new Usuario(); //Instancia clase usuario
            $ticket = new Ticket(); //Instancia clase ticket

            $conectar = parent::Conexion();

            $sql="UPDATE estacionamientos SET Estado_estacionamiento = 'Terminado' WHERE estacionamientos.id_estacionamiento = ?;";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id);
            $sql->execute();

            //Registrar movimiento
            $mov = "Ha retirado la <b>bahía</b> con id: <b>$id</b>";
            $usuario->insertMovimiento($id_usuario, $mov);

            //Registrar ticket de salida
            // $ticket->setTicketSalida($id_entrada, $id_usuario);

            //Terminar ticket de salida
            // $id_salida = $ticket->getTicketSalida_x_id($id_entrada);
            // $ticket->terminarTicketSalida($id_salida, $id_usuario);
            
            return $resultado=$sql->fetchAll();
        }

        //Get function from database -- Traer última bahía insertada.
        public function getLastBahia(){
            $conectar = parent::Conexion();

            $sql="SELECT MAX(id_estacionamiento) AS id_estacionamiento FROM estacionamientos";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            $validacion_esta=$sql->fetchAll();
            foreach ($validacion_esta as $row){
                $vali_esta = $row["id_estacionamiento"]; //Recuperar el atributo requerido.
                break;
            }

            return $vali_esta;
        }

        //Recuperar ID del último estacionamiento y registrar último movimiento
        public function gestionBahia($id_usuario){
            //Instancia clase usuario
            $Usuario = new Usuario();

            $id_estacionamiento = $this->getLastBahia(); //Recúperar ID estacionamiento
            $mov = "Ha agregado un nuevo <b>estacionamiento</b> con ID: <b>$id_estacionamiento</b>";
            $Usuario->insertMovimiento($id_usuario, $mov);

            return $id_estacionamiento;
        }

        /* CONSULTAS ESTACIONAMIENTO */
        //Traer bahías con un límite de 10
        public function getBahias(){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT id_estacionamiento, Num_estacionamiento, id_vehiculo, id_cliente, CONCAT(Nombre,' ',Apellido) AS nombres, Estado_estacionamiento, esta_descripcion, fecha_creacion FROM estacionamientos e, vehiculos, clientes WHERE id_vehiculo = Placa AND id_cliente = Documento AND e.est = 1 LIMIT 10;";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        //Traer bahía por id
        public function getBahia_x_id($id){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT * FROM estacionamientos WHERE id_estacionamiento = ?;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        //Traer bahía por condición SQL (BETWEEN)
        public function getBahiaBetween($desde, $hasta){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT id_estacionamiento, Num_estacionamiento, id_vehiculo, id_cliente, CONCAT(Nombre, Apellido) AS 'nombres', Estado_estacionamiento, esta_descripcion, fecha_creacion FROM estacionamientos e, vehiculos, clientes WHERE e.est = 1 AND id_vehiculo = Placa AND id_cliente = Documento AND fecha_creacion BETWEEN '$desde' AND '$hasta';";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        //Eliminar una bahía
        public function deleteBahia($id, $id_usuario){
            $usuario = new Usuario();
            $conectar = parent::Conexion();
            
            $sql="UPDATE estacionamientos SET est = '0', Estado_estacionamiento = 'Terminado' WHERE estacionamientos.id_estacionamiento = ?;";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id);
            $sql->execute();

            $mov = "Ha eliminado el <b>estacionamiento</b> con id: <b>$id</b>";
            $usuario->insertMovimiento($id_usuario, $mov);

            return $resultado=$sql->fetchAll();
        }

        //Actualizar una bahía
        public function updateBahia($id, $numEsta, $placa, $cliente, $estadoEsta, $descripEsta, $id_usuario){
            $usuario = new Usuario();

            $conectar = parent::Conexion();
            parent::set_names();

            $sql = 'UPDATE estacionamientos SET Num_estacionamiento = ?, id_vehiculo = ?, id_cliente = ?, Estado_estacionamiento = ?, esta_descripcion = ? WHERE id_estacionamiento = ?;';
            $sql = $conectar->prepare($sql);

            $sql->bindValue(1, $numEsta);
            $sql->bindValue(2, $placa);
            $sql->bindValue(3, $cliente);
            $sql->bindValue(4, $estadoEsta);
            $sql->bindValue(5, $descripEsta);
            $sql->bindValue(6, $id);

            $sql->execute();

            $mov = "Ha actualizado los datos del <b>estaconamiento</b> con ID <b>$id</b>";
            $usuario->insertMovimiento($id_usuario, $mov);

            return $resultado = $sql->fetchAll();
        }

        /* CONSULTA CLIENTES SIN LÍMITE */
        public function getClienteWhitoutLimit(){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT Documento FROM cliente WHERE est = 1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        /* CONSULTA VEHÍCULOS SIN LÍMITE */
        public function getVehiculoWhitoutLimit(){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT Placa FROM vehiculo WHERE est = 1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        // Registrar un nuevo aparcamiento en la base de datos. (Bahia, Cliente, Vehículo)
        public function insert_aparcamiento($documento, $nombre, $apellido, $telefono, $placa, $color_vehiculo = 'N/A', $modelo_vehiculo, $tamano_vehiculo, $tipo_vehiculo, $noEstacionamiento, $descripcion, $id_usuario){

            //Instancia de clases
            $Cliente = new Cliente();
            $Vehiculo = new Vehiculo();
            $ticket = new Ticket();

            //consultar si cliente/vehículo existe
            $validacion_cliente=$Cliente->validateCliente($documento);
            $validacion_vehiculo=$Vehiculo->validateVehiculo($placa);

            //Validación cliente existente.
            if(is_array($validacion_cliente) and count($validacion_cliente)==0){
                    //Bloque a ejecutar en caso de que el vehículo no exista
                    if(is_array($validacion_vehiculo) and count($validacion_vehiculo)==0){
                        //Agregar cliente, vehiculo, estacionamiento
                        $Cliente->setCliente($documento, $nombre, $apellido, $telefono, $id_usuario);
                        $Vehiculo->insertVehiculo($placa, $color_vehiculo, $modelo_vehiculo, $tamano_vehiculo, $tipo_vehiculo, $id_usuario);
                        $this->insertBahia($noEstacionamiento, $placa, $documento, $descripcion);
                        
                        //Obtener ID último estacionamiento y registrar movimiento de último estacionamiento agregado.
                        $id_estacionamiento = $this->gestionBahia($id_usuario);

                        //Registrar ticket
                        $ticket->setTicketEntrada($id_usuario, $id_estacionamiento);
                    }else{
                        //Agregar cliente y estacionamiento
                        $Cliente->setCliente($documento, $nombre, $apellido, $telefono, $id_usuario);
                        $this->insertBahia($noEstacionamiento, $placa, $documento, $descripcion);
                        
                        //Obtener ID último estacionamiento y registrar movimiento de último estacionamiento agregado.
                        $id_estacionamiento = $this->gestionBahia($id_usuario);

                        //Registrar ticket
                        $ticket->setTicketEntrada($id_usuario, $id_estacionamiento);
                    }
                
            }else if(is_array($validacion_vehiculo) and count($validacion_vehiculo)==0){
                //Bloque a ejecutar en caso de que el cliente ya exista y el vehículo no.

                //Agregar vehículo, estacionamiento
                $Vehiculo->insertVehiculo($placa, $color_vehiculo, $modelo_vehiculo, $tamano_vehiculo, $tipo_vehiculo, $id_usuario);
                $this->insertBahia($noEstacionamiento, $placa, $documento, $descripcion);

                //Obtener ID último estacionamiento y registrar movimiento de último estacionamiento agregado.
                $id_estacionamiento = $this->gestionBahia($id_usuario);

                //Registrar ticket entrada
                $ticket->setTicketEntrada($id_usuario, $id_estacionamiento);
            }else{
                //Agregar estacionamiento
                $this->insertBahia($noEstacionamiento, $placa, $documento, $descripcion);

                //Obtener ID último estacionamiento y registrar movimiento de último estacionamiento agregado.
                $id_estacionamiento = $this->gestionBahia($id_usuario);

                //Registrar ticket entrada
                $ticket->setTicketEntrada($id_usuario, $id_estacionamiento);
            }
        }
        
    }
?>