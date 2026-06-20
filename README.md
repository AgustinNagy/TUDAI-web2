# API RESTful para Marketplace de Servicios

## Descripción

Esta API RESTful permite realizar operaciones CRUD (**Create, Read, Update y Delete**) sobre la entidad **Servicios** del sitio web *Marketplace de Servicios* desarrollado en la etapa anterior del proyecto.

Además de las operaciones básicas, la API ofrece funcionalidades de:

* Consulta de todos los servicios
* Consulta de servicios por identificador.
* Filtrado por distintos campos.
* Ordenamiento ascendente o descendente.
* Paginación de resultados.
* Combinación de filtros, ordenamiento y paginación.


## Endpoints disponibles

| Método | URL                                                                                         | Descripción                                                                                                                                                   |
| ------ | ------------------------------------------------------------------------------------------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| GET    | `localhost/web 2/API/api/servicios`                                                              | Devuelve la lista completa de servicios.                                                                                                                      |
| GET    | `localhost/web 2/API/api/servicio/1`                                                            | Devuelve el servicio cuyo `id_servicio` es 1.                                                                                                                 |
| GET    | `localhost/web 2/API/api/servicios?sort=campo&asc=true`                                          | Devuelve la lista de servicios ordenada por el campo indicado. El parámetro `asc=true` indica orden ascendente y `asc=false` orden descendente.               |
| GET    | `localhost/web 2/API/api/servicios?filter=Modalidad&value=Presencial`                            | Devuelve los servicios filtrados por el campo especificado y por el valor del campo indicado. En este ejemplo, se obtienen los servicios con modalidad presencial. |
| GET    | `localhost/web 2/API/api/servicios?filter=Modalidad&value=Presencial&sort=id_prestador&asc=true` | Devuelve los servicios filtrados y ordenados. En este ejemplo, se obtienen los servicios presenciales ordenados por `id_prestador` de forma ascendente.       |
| GET    | `localhost/web 2/API/api/servicios?page=2&limit=2`                                               | Devuelve la segunda página de resultados, mostrando dos servicios por página.                                                                                 |
| GET    | `localhost/web 2/API/api/servicios?page=2&limit=2&sort=Precio_base&asc=false`                    | Devuelve una página de resultados ordenada por `Precio_base` en forma descendente.                                                                            |
| DELETE | `localhost/web 2/API/api/servicio/2`                                                             | Elimina el servicio cuyo `id_servicio` es 2. Si el servicio no existe, se devuelve un mensaje de error.                                                       |
| POST   | `localhost/web 2/API/api/servicio`                                                               | Permite crear un nuevo servicio.                                                                                                                              |
| PATCH  | `localhost/web 2/API/api/servicio/2`                                                             | Permite modificar parcialmente el servicio cuyo `id_servicio` es 2. Si el servicio no existe, se informa mediante un mensaje de error.                        |
| PUT    | `localhost/web 2/API/api/servicio/2`                                                             | Permite reemplazar completamente la información del servicio cuyo `id_servicio` es 2. Si el servicio no existe, se informa mediante un mensaje de error.      |

---

## Parámetros soportados

### Ordenamiento

| Parámetro | Descripción                                                                            |
| --------- | -------------------------------------------------------------------------------------- |
| `sort`    | Campo por el cual se desea ordenar la respuesta.                                       |
| `asc`     | Indica el sentido del ordenamiento (`true` para ascendente, `false` para descendente). |

### Filtrado

| Parámetro | Descripción                                     |
| --------- | ----------------------------------------------- |
| `filter`  | Campo sobre el cual se desea aplicar el filtro. |
| `value`   | Valor que debe tomar el campo indicado.         |

### Paginación

| Parámetro | Descripción                       |
| --------- | --------------------------------- |
| `page`    | Número de página solicitada.      |
| `limit`   | Cantidad de elementos por página. |

---

## Códigos de respuesta

| Código | Descripción                                  |
| ------ | -------------------------------------------- |
| `200`  | Solicitud realizada correctamente.           |
| `201`  | Recurso creado correctamente.                |
| `400`  | Parámetros inválidos o solicitud incorrecta. |
| `404`  | Recurso solicitado no encontrado.            |
| `500`  | Error interno del servidor.                  |
