<?php



    class servicios_api_modelo{

        private $data;
        
        private const MYSQL_USER = 'root';
        private  const MYSQL_PASS = '';
        private const MYSQL_DB = 'base_tpe';
        private const MYSQL_HOST = 'localhost';


        function __construct(){
            $this->data = new PDO("mysql:host=".self::MYSQL_HOST."; dbname=".self::MYSQL_DB."; charset=UTF8",self::MYSQL_USER,self::MYSQL_PASS);
            $this->_deploy();
        }

        function getServicios(){
            $query = $this->data->prepare("SELECT * FROM servicios");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_OBJ);
        }

        
        function getServicioById($id){
            $query = $this->data->prepare("SELECT * FROM servicios WHERE id_servicio = ?");
            $query->execute([$id]);
            return $query->fetch(PDO::FETCH_OBJ);
        }


        public function getPrestador($id){        
            $query = $this->data->prepare("SELECT * FROM prestadores WHERE id_prestador = ?");
            $query->execute([$id]);
            return $query->fetch(PDO::FETCH_OBJ);
        }

        public function addServicio($servicio){
            $query = $this->data->prepare("INSERT INTO servicios (id_prestador, rubro, servicio, descripcion, precio_base, modalidad) VALUES (?, ?, ?, ?, ?, ?)");
            $query->execute($servicio);
        }


        public function eliminarServicioById($id){
            $query = $this->data->prepare("DELETE FROM servicios WHERE id_servicio = ?");
            $query->execute([$id]);
        }

        public function updateServicio($servicio){
            $query = $this->data->prepare("UPDATE `servicios` SET id_prestador = ?, Rubro = ? , Servicio = ?, Descripcion = ?, Precio_base = ?, Modalidad = ?  WHERE id_servicio = ?");
            $query->execute($servicio);  
        }

        public function getServiciosOrdenados($campo,$orden){
            if($orden=="true"){
                $query = $this->data->prepare("SELECT * FROM servicios ORDER BY $campo ASC");
                $query->execute();
                return $query->fetchAll(PDO::FETCH_OBJ);
            }else{
                $query = $this->data->prepare("SELECT * FROM servicios ORDER BY $campo DESC");
                $query->execute();
                return $query->fetchAll(PDO::FETCH_OBJ);
            }
        }

        public function getFiltro($filtro,$value){
            $query = $this->data->prepare("SELECT * FROM servicios WHERE $filtro = ?");
            $query->execute([$value]);
            return $query->fetchAll(PDO::FETCH_OBJ);
        }

        public function getFiltroOrdenado($filtro,$value,$campo,$orden){
            if($orden=="true"){
                $query = $this->data->prepare("SELECT * FROM servicios WHERE $filtro = ? ORDER BY $campo ASC");
                $query->execute([$value]);
                return $query->fetchAll(PDO::FETCH_OBJ);
            }
            else{
                $query = $this->data->prepare("SELECT * FROM servicios WHERE $filtro = ? ORDER BY $campo DESC");
                $query->execute([$value]);
                return $query->fetchAll(PDO::FETCH_OBJ);
            }
        }

        public function getPagina($page,$limite){
            $query = $this->data->prepare("SELECT * FROM servicios LIMIT $limite OFFSET $page");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_OBJ);
        }

        public function getPaginaOrdenada($page,$limite,$campo,$orden){      
            if($orden =="true"){
                $query = $this->data->prepare("SELECT * FROM servicios ORDER BY $campo ASC LIMIT $limite OFFSET $page");
                $query->execute();
                return $query->fetchAll(PDO::FETCH_OBJ);
            }
                $query = $this->data->prepare("SELECT * FROM servicios ORDER BY $campo DESC LIMIT $limite OFFSET $page");
                $query->execute();
                return $query->fetchAll(PDO::FETCH_OBJ);   
        }

        public function getPaginaFiltrada($page,$limite,$filtro,$value){
            $query = $this->data->prepare("SELECT * FROM servicios WHERE $filtro = ? LIMIT $limite OFFSET $page");
            $query->execute([$value]);
            return $query->fetchAll(PDO::FETCH_OBJ);
        }

        public function getPaginaFiltradaOrdenada($page,$limite,$filtro,$value,$campo,$orden){
            if($orden == "true"){
                $query = $this->data->prepare("SELECT * FROM servicios WHERE $filtro = ? ORDER BY $campo ASC LIMIT $limite OFFSET $page");
                $query->execute([$value]);
                return $query->fetchAll(PDO::FETCH_OBJ);
            }
            else{
                $query = $this->data->prepare("SELECT * FROM servicios WHERE $filtro = ? ORDER BY $campo DESC LIMIT $limite OFFSET $page");
                $query->execute([$value]);
                return $query->fetchAll(PDO::FETCH_OBJ);
            }
        }
        




        private function _deploy() {
            $query = $this->data->query('SHOW TABLES');
            $tables = $query->fetchAll();
            if(count($tables) == 0) {
                $sql = <<<SQL

                    CREATE TABLE `prestadores` (
                    `id_prestador` int(11) NOT NULL,
                    `Nombre` varchar(100) NOT NULL,
                    `Apellido` varchar(100) NOT NULL,
                    `Email` varchar(100) NOT NULL,
                    `Ciudad` varchar(100) NOT NULL,
                    `Domicilio` varchar(100) NOT NULL,
                    `Telefono` varchar(50) NOT NULL,
                    `dni_cuit` int(11) NOT NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


                    INSERT INTO `prestadores` (`id_prestador`, `Nombre`, `Apellido`, `Email`, `Ciudad`, `Domicilio`, `Telefono`, `dni_cuit`) VALUES
                    (3, 'Anibal ', 'Tolaba', 'anibaltolaba07@gmail.com', 'Tandil', 'Montiel 826', '2494334424', 34659781),
                    (5, 'Lucia', 'Gomez', 'lucia.gomez@gmail.com', 'Tandil', 'Belgrano 742', '2494123456', 30123456),
                    (6, 'Martin', 'Lopez', 'martin.lopez@gmail.com', 'Mar del Plata', 'Colon 1234', '2235567890', 28987654),
                    (7, 'Sofia', 'Martinez', 'sofia.martinez@gmail.com', 'Azul', 'Mitre 567', '2281543210', 31234567),
                    (8, 'Diego', 'Fernandez', 'diego.fernandez@gmail.com', 'Olavarria', 'Rivadavia 890', '2284567891', 27654321),
                    (9, 'Valentina', 'Ruiz', 'valentina.ruiz@gmail.com', 'Tandil', 'Pellegrini 345', '2494789652', 33456789),
                    (10, 'Javier', 'Sanchez', 'javier.sanchez@gmail.com', 'Necochea', 'Calle 62 1450', '2262567890', 26543219),
                    (11, 'Camila', 'Torres', 'camila.torres@gmail.com', 'Balcarce', 'Av. Kelly 220', '2266451234', 34567890),
                    (12, 'Federico', 'Diaz', 'federico.diaz@gmail.com', 'Tandil', 'España 678', '2494011122', 29876543),
                    (13, 'Carlos ', 'Gonzalez ', 'carlos_gonzales@gmail.com', 'Tandil', 'San Martin 826', '225846598', 36459875),
                    (21, 'Agustín', 'Nagy', 'agustin.nagy@gmail.com', 'Tandil', 'San Martin 826', '02281655628', 456548),
                    (23, 'Ricardo ', 'Perez', 'rPerez@hotmail.com', 'Olavarria', 'La Madrid 432', '2284433333', 13659748);

                    
                    CREATE TABLE `servicios` (
                    `id_servicio` int(11) NOT NULL,
                    `id_prestador` int(11) NOT NULL,
                    `Rubro` varchar(50) NOT NULL,
                    `Servicio` varchar(50) NOT NULL,
                    `Descripcion` text NOT NULL,
                    `Precio_base` int(11) NOT NULL,
                    `Modalidad` varchar(50) NOT NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


                    INSERT INTO `servicios` (`id_servicio`, `id_prestador`, `Rubro`, `Servicio`, `Descripcion`, `Precio_base`, `Modalidad`) VALUES
                    (40, 3, 'Electricidad', 'Instalacion electrica', 'instalacion electrica de obra', 25000, 'Presencial'),
                    (42, 5, 'Hogar', 'Electricidad domiciliaria', 'Instalaciones eléctricas.', 16000, 'Presencial'),
                    (43, 6, 'Educación', 'Clases de inglés', 'Clases online personalizadas.', 10000, 'Virtual'),
                    (44, 7, 'Automotor', 'Mecánica ligera', 'Reparaciones básicas de autos.', 20000, 'Presencial'),
                    (45, 8, 'Sanidad Animal', 'Veterinaria', 'Atención para mascotas.', 25000, 'Presencial'),
                    (47, 3, 'Carpinteria ', 'Carpinteria', 'Clases de yoga virtual.', 120000, 'Presencial'),
                    (50, 6, 'Educación', 'Clases de matemática', 'Apoyo escolar.', 9500, 'Virtual'),
                    (51, 8, 'Sanidad Animal', 'Vacunación', 'Vacunas para mascotas.', 12000, 'Presencial'),
                    (53, 3, 'Tecnología', 'Configuración de redes', 'Instalación y configuración de redes domésticas.', 14000, 'Presencial'),
                    (55, 5, 'Hogar', 'Instalación de aire acondicionado', 'Colocación de equipos split.', 25000, 'Presencial'),
                    (56, 6, 'Educación', 'Clases de programación', 'Introducción a programación web.', 15000, 'Virtual'),
                    (57, 7, 'Automotor', 'Diagnóstico electrónico', 'Escaneo computarizado del vehículo.', 18000, 'Presencial'),
                    (60, 3, 'Tecnologia ', 'Desarrollador', 'Rutinas adaptadas a objetivos personales.', 50000, 'Hibrida'),
                    (61, 5, 'Hogar', 'Reparación de filtraciones', 'Solución de problemas de humedad y filtraciones.', 19000, 'Presencial'),
                    (64, 7, 'Sanindad', 'Medico general', 'Medico clinico', 32000, 'Hibrida'),
                    (65, 5, 'Tecnologia ', 'Desarrollador java', 'Medico clinico', 12546, 'Presencial'),
                    (73, 5, 'Carpinteria ', 'Carpinteria', 'Carpinteria en melamina', 10000, 'Presencial'),
                    (75, 5, 'Tecnologia ', 'Desarrollador', 'Desarrollo backend ', 4510, 'hibrida'),
                    (77, 21, 'Tecnologia ', 'Data Science', 'Analisis de datos con ML', 20000, 'Hibrida'),
                    (81, 3, 'Electricidad', 'Instalacion electrica', 'instalacion electrica de obra', 25000, 'Presencial');

                    CREATE TABLE `users` (
                    `id` int(11) NOT NULL,
                    `email` varchar(50) NOT NULL,
                    `password` varchar(100) NOT NULL,
                    `nombre` varchar(100) NOT NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                    INSERT INTO `users` (`id`, `email`, `password`, `nombre`) VALUES
                    (1, 'agustin.nagy@gmail.com', '$2y$10$KK5coTsxMRz.KWmJeA2x2.iajppCMdObwXpdoauluPdzIO5cc/kcm', 'Agus'),
                    (2, 'anibaltolaba07@gmail.com', '$2y$10$u6lTnyU3pqkQrf7NayE68OMQKdbEnk.4dd5oISkzWLd6UAznPfySe', 'Anibal');

            
                SQL;
            $this->data->query($sql);
            }
        }
    

}


?>



