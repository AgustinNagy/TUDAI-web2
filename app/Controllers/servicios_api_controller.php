<?php



class servicios_api_controller{

        private $modelo; 
    
        public function __construct(){
            require_once __DIR__."/../Models/servicios_api_modelo.php";
            $this->modelo = new servicios_api_modelo();
        }


        public function getServicioById($req,$res){
            
            $id = $req->params->id;
            $servicio = $this->modelo->getServicioById($id);

            if(!$servicio){
                return $res->json("no existe servicio con ese id",400);
            }

            return $res->json($servicio,200);
        }

        public function eliminarServicioById($req,$res){

            $id = $req->params->id;
            $servicio = $this->modelo->getServicioById($id);

            if(!$servicio){
                return $res->json("No existe el servicio que quiere eliminar", 404);
            }

            $this->modelo->eliminarServicioById($id);
            return $res->json("el servicio ha sido eliminado con exito", 204);
        }


        public function addServicio($req,$res){

            $id_prestador = $req->body->id_prestador ?? null;    
            $prestador = $this->modelo->getPrestador($id_prestador);

            if(!$id_prestador || !$prestador){
                return $res->json("El prestador indicado no es un prestador válido",404);
            }

            $rubro = $req->body->Rubro ?? null;
            $servicio = $req->body->Servicio ?? null;
            $descripcion = $req->body->Descripcion ?? null;
            $precio = $req->body->Precio_base ?? null;
            $modalidad = $req->body->Modalidad ?? null;

            if(!$servicio || !$precio){
                return $res->json("faltan datos para agregar el servicio",400);
            }

            $servicio_a_agregar = [$id_prestador,$rubro,$servicio,$descripcion,$precio,$modalidad];

            $this->modelo->addServicio($servicio_a_agregar);
            return $res->json("servicio agregado con Exito", 201);
        }


        public function patchServicio($req,$res){
        
            $id = $req->params->id;
            $servicio_a_actualizar = $this->modelo->getServicioById($id);

            if(!$servicio_a_actualizar){
                return $res->json("El servicio seleccionado no existe", 404);
            }

            $id_prestador = $req->body->id_prestador ?? $servicio_a_actualizar->id_prestador;
            
            if($id_prestador != null){
                $prestador = $this->modelo->getPrestador($id_prestador);
                if(!$prestador){
                    return $res->json("El prestador indicado no es un prestador válido",404);
                 }
            }

            $rubro = $req->body->Rubro ?? $servicio_a_actualizar->Rubro;
            $servicio = $req->body->Servicio ?? $servicio_a_actualizar->Servicio;
            $descripcion = $req->body->Descripcion ?? $servicio_a_actualizar->Descripcion;
            $precio = $req->body->Precio_base ?? $servicio_a_actualizar->Precio_base;
            $modalidad = $req->body->Modalidad ?? $servicio_a_actualizar->Modalidad;

            $servicio_actualizado = [$id_prestador,$rubro,$servicio,$descripcion,$precio,$modalidad,$id];

            $this->modelo->updateServicio($servicio_actualizado);
            return $res->json("el servicio ha sido actualizado con exito",200);
        
        }


        public function updateServicio($req,$res){
            
            $id = $req->params->id;

            $servicio_a_actualizar = $this->modelo->getServicioById($id);

            if(!$servicio_a_actualizar){
                return $res->json("El servicio seleccionado no existe", 404);
            }

        
            $id_prestador = $req->body->id_prestador ?? null;
            $rubro = $req->body->Rubro ?? null;
            $servicio = $req->body->Servicio ?? null;
            $descripcion = $req->body->Descripcion ?? null;
            $precio = $req->body->Precio_base ?? null;
            $modalidad = $req->body->Modalidad ?? null;

            if($id_prestador == null || $rubro == null || $servicio == null || $descripcion == null || $precio == null || $modalidad == null){
                return $res->json("Faltan ingresar los datos para actualizar",400);
            }

            $prestador = $this->modelo->getPrestador($id_prestador);

            if(!$prestador){
                return $res->json("El prestador indicado no es válido",404);
            }


            $servicio_actualizado = [$id_prestador,$rubro,$servicio,$descripcion,$precio,$modalidad,$id];
            $this->modelo->updateServicio($servicio_actualizado);
            return $res->json("el servicio ha sido actualizado con exito",200);
        
        }


        /* FUNCION FINAL  */

        private function filtroValido($filtro){
            return ($filtro == "id_prestador" || $filtro == "id_servicio" || $filtro == "Servicio" || $filtro =="Rubro" || $filtro =="Modalidad");
        }

        private function campoValido($campo){
            return ($campo == "Precio_base" || $campo == "id_prestador" || $campo == "id_servicio" || $campo =="Rubro" || $campo =="Servicio" || $campo == "Modalidad");
        }


        public function getServicios($req,$res){

            $set = $req->query->offset ?? null;
            $limit = $req->query->limit ?? null;
            $campo = $req->query->sort ?? null;
            $orden = $req->query->asc ?? false;
            $filtro = $req->query->filter ?? null;
            $value = $req->query->value ?? null;


            /* bloque de paginación */

            if($set != null && $limit != null){
                
                if($set <= 0){
                    return $res->json("Ingrese un valor de conjunto válido",400);
                }

                if($limit <= 0){
                    return $res->json("Ingrese un valor de limite válido",400);
                }

                $page = ((int)$set - 1) * $limit; /* calcula limite inferior del intervalo */
                $limite = (int)$limit;

                if($filtro != null){

                    if(!($this->filtroValido($filtro))){
                        return $res->json("filtro de busqueda inválido",400);
                    }

                    if($value == null){
                        return $res->json("No se ingresó un valor de filtrado",400);
                    }

                   if($campo != null){
                        if(!($this->campoValido($campo))){
                            return $res->json("campo de busqueda es inválido",400);
                        }
                        $servicios = $this->modelo->getPaginaFiltradaOrdenada($page,$limite,$filtro,$value,$campo,$orden);
                        return $res->json($servicios,200);
                    }
                    
                    $servicios = $this->modelo->getPaginaFiltrada($page,$limite,$filtro,$value);
                    return $res->json($servicios,200);
                }

            
                /* bloque de paginación y ordenado */
            
                if($campo != null){
                    if(!($this->campoValido($campo))){
                        return $res->json("campo de busqueda es inválido",400);
                    }
                    $servicios = $this->modelo->getPaginaOrdenada($page,$limite,$campo,$orden);
                    return $res->json($servicios,200);
                }

                $servicios = $this->modelo->getPagina($page,$limite);
                return $res->json($servicios,200);
            }

            /* bloque de filtrado */

            if($filtro != null){
                
                if(!($this->filtroValido($filtro))){
                    return $res->json("filtro de busqueda inválido",400);
                }

                if($value == null){
                    return $res->json("No se ingresó un valor de filtrado",400);
                }

                /* bloque de filtro ordenado */

                if($campo != null){
                        if(!($this->campoValido($campo))){
                            return $res->json("campo de busqueda es inválido",400);
                        }
                        $servicios = $this->modelo->getFiltroOrdenado($filtro,$value,$campo,$orden);
                        return $res->json($servicios,200);
                }

                $servicios = $this->modelo->getFiltro($filtro,$value);
                return $res->json($servicios,200);
            }
        
        /* bloque de orden */

            if($campo != null){
                if(!($this->campoValido($campo))){
                    return $res->json("campo de busqueda es inválido",400);
                }
                $servicios = $this->modelo->getServiciosOrdenados($campo,$orden);
                return $res->json($servicios,200);
            }


             $servicios = $this->modelo->getServicios();
             return $res->json($servicios,200);
        }
        




        
    }


        








?>