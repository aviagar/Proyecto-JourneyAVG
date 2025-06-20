<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require 'Firebase/autoload.php';

define("PASSWORD_API", "Una_clave_para_usar_para_encriptar");
define("TIEMPO_MINUTOS_API", 60);
define("SERVIDOR_BD", "localhost");
define("USUARIO_BD", "u598697057_journey");
define("CLAVE_BD", "Journey2026");
define("NOMBRE_BD", "u598697057_journey");


function validateToken()
{

    $headers = apache_request_headers();
    if (!isset($headers["Authorization"]))
        return false; //Sin autorizacion
    else {
        $authorization = $headers["Authorization"];
        $authorizationArray = explode(" ", $authorization);
        $token = $authorizationArray[1];
        try {
            $info = JWT::decode($token, new Key(PASSWORD_API, 'HS256'));
        } catch (\Throwable $th) {
            return false; //Expirado
        }

        try {
            $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        } catch (PDOException $e) {

            $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
            return $respuesta;
        }

        try {
            $consulta = "select * from usuarios where id_usuario=?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$info->data]);
        } catch (PDOException $e) {
            $respuesta["error"] = "Imposible realizar la consulta:" . $e->getMessage();
            $sentencia = null;
            $conexion = null;
            return $respuesta;
        }
        if ($sentencia->rowCount() > 0) {
            $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);

            $payload['exp'] = time() + TIEMPO_MINUTOS_API * 60;
            $payload['data'] = $respuesta["usuario"]["id_usuario"];
            $jwt = JWT::encode($payload, PASSWORD_API, 'HS256');
            $respuesta["token"] = $jwt;
        } else
            $respuesta["mensaje_baneo"] = "El usuario no se encuentra registrado en la BD";

        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }
}

function login($datos_login)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from usuarios where usuario=? and clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos_login);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No he podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    if ($sentencia->rowCount() > 0) {
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        $payload['exp'] = time() + TIEMPO_MINUTOS_API * 60;
        $payload['data'] = $respuesta["usuario"]["id_usuario"];
        $jwt = JWT::encode($payload, PASSWORD_API, 'HS256');
        $respuesta["token"] = $jwt;
    } else
        $respuesta["mensaje"] = "El usuario no se encuentra en la BD";

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function registro($datos_registro)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
        ]);
    } catch (PDOException $e) {
        return ["error" => "No se ha podido conectar a la base de datos: " . $e->getMessage()];
    }

    // Verificar si el usuario ya existe
    try {
        $consulta_check = "SELECT COUNT(*) FROM usuarios WHERE usuario = ?";
        $sentencia_check = $conexion->prepare($consulta_check);
        $sentencia_check->execute([$datos_registro[0]]);

        if ($sentencia_check->fetchColumn() > 0) {
            return ["usuario_existente" => "El nombre de usuario ya está en uso."];
        }
    } catch (PDOException $e) {
        return ["error" => "Error al verificar el usuario: " . $e->getMessage()];
    }

    // Insertar usuario
    try {
        $consulta = "INSERT INTO usuarios (usuario, nombre, email, telefono, clave, fecha_registro, tipo) VALUES (?, ?, ?, ?, ?, CURDATE(), 'cliente')";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos_registro);

        if ($sentencia->rowCount() > 0) {
            return ["mensaje" => "Usuario registrado correctamente."];
        } else {
            return ["error" => "No se pudo insertar el usuario."];
        }
    } catch (PDOException $e) {
        return ["error" => "Error al insertar el usuario: " . $e->getMessage()];
    } finally {
        $sentencia = null;
        $conexion = null;
    }
}


function obtener_coches()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from vehiculos";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No he podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    $respuesta["coches"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function resetSeleccionados($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "UPDATE vehiculos SET seleccionado_por = NULL, seleccionado_timestamp = NULL WHERE seleccionado_por = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No he podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }
}

function obtener_coche($referencia)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from vehiculos where id_vehiculo=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$referencia]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No he podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    $respuesta["libro"] = $sentencia->fetch(PDO::FETCH_ASSOC);




    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function darDeBajaCoche($referencia)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }

    try {

        $consulta = "DELETE FROM vehiculos WHERE id_vehiculo = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$referencia]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No he podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    $respuesta["mensaje"] = "Coche dado de baja correctamente en la BD";
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}


function darDeAltaCoche($datos_insertar)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }

    try {

        $consulta = "INSERT INTO vehiculos (id_vehiculo, marca, modelo, tipo, matricula, estado, sede_actual) VALUES (?,?,?,?,?,?,?)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos_insertar);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No he podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    $respuesta["mensaje"] = "Coche dado de alta correctamente en la BD";
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function seleccionarCoche($datos_update)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }

    try {

        $consulta = "UPDATE vehiculos SET seleccionado_por = ?, seleccionado_timestamp = ? WHERE id_vehiculo = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos_update);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No he podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    $respuesta["mensaje"] = "Coche actualizado con éxito";
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function obtenerSedes()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }

    try {

        $consulta = "SELECT * from sedes";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No he podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    $respuesta["sedes"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function obtenerCochesDisponibles($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarse a la base de datos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "SELECT * FROM vehiculos WHERE id_vehiculo NOT IN (SELECT id_vehiculo FROM reservas WHERE (? < fecha_fin AND ? > fecha_inicio)) AND estado = 'Disponible' AND sede_actual = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No he podido realizar la consulta: " . $e->getMessage();
        return $respuesta;
    }

    $respuesta = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia = null;
    $conexion = null;

    if (empty($respuesta)) {
        return ["sin_coches" => "No hay coches disponibles para los criterios seleccionados"];
    }

    return ["coches" => $respuesta];
}

function realizarReserva($datos_insertar, $importe)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarse a la base de datos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "INSERT INTO reservas (id_usuario, id_vehiculo, fecha_inicio, fecha_fin, sede_recogida, sede_entrega, estado_reserva, plan) VALUES (?, ?, ?, ?, ?, ?, 'Pendiente', ?)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos_insertar);
        $id_reserva = $conexion->lastInsertId();
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No he podido realizar la reserva: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consultaPago = "INSERT INTO pagos (id_reserva, importe, fecha_pago, metodo_pago) VALUES (?, ?, ?, ?)";
        $sentenciaPago = $conexion->prepare($consultaPago);
        $datosPago = [
            $id_reserva,
            $importe,
            date("Y-m-d"),
            "tarjeta"
        ];
        $sentenciaPago->execute($datosPago);
        $sentenciaPago = null;
    } catch (PDOException $e) {
        $conexion = null;
        return ["error" => "No he podido realizar el pago: " . $e->getMessage()];
    }

    try {
        $consultaUpdate = "UPDATE vehiculos SET seleccionado_por = NULL, seleccionado_timestamp = NULL WHERE id_vehiculo = ?";
        $sentenciaUpdate = $conexion->prepare($consultaUpdate);
        $sentenciaUpdate->execute([$datos_insertar[1]]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No he podido actualizar el coche: " . $e->getMessage();
        return $respuesta;
    }

    $respuesta["mensaje"] = "Reserva insertada correctamente";
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function obtenerTodosAdmin($tabla)
{
    $permitidas = ["reservas", "vehiculos", "sedes"];
    if (!in_array($tabla, $permitidas)) {
        return ["error" => "Tabla no válida"];
    }

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarse a la base de datos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "SELECT * FROM $tabla";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return ["error" => "No he podido realizar la consulta: " . $e->getMessage()];
    }

    $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia = null;
    $conexion = null;

    return ["datos" => $resultado];
}

function eliminarVehiculo($id_vehiculo)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarse a la base de datos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "DELETE FROM vehiculos WHERE id_vehiculo = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_vehiculo]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return ["error" => "No he podido realizar la consulta: " . $e->getMessage()];
    }

    $sentencia = null;
    $conexion = null;
    return ["mensaje" => "Registro eliminado"];
}

function obtenerReservasCliente($id_usuario)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return ["error" => "No he podido conectarme a la base de datos: " . $e->getMessage()];
    }

    try {
        $consulta = "SELECT r.*, s1.nombre_sede AS nombre_sede_recogida, s2.nombre_sede AS nombre_sede_entrega FROM reservas r JOIN sedes s1 ON r.sede_recogida = s1.id_sede JOIN sedes s2 ON r.sede_entrega = s2.id_sede WHERE r.id_usuario = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]);
    } catch (PDOException $e) {
        return ["error" => "No he podido realizar la consulta: " . $e->getMessage()];
    }

    $reservas = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia = null;
    $conexion = null;
    return ["reservas_usuario" => $reservas];
}


function actualizarReserva($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
        ]);
    } catch (PDOException $e) {
        return ["error" => "No se pudo conectar a la base de datos: " . $e->getMessage()];
    }

    try {
        $consulta = "UPDATE reservas SET fecha_inicio = ?, fecha_fin = ?, sede_recogida = ?, sede_entrega = ?,  estado_reserva = 'Pendiente' WHERE id_reserva = ?";

        $sentencia = $conexion->prepare($consulta);

        $sentencia->execute([
            $datos[1],
            $datos[2],
            $datos[3],
            $datos[4],
            $datos[0]
        ]);

        if ($sentencia->rowCount() > 0) {
            return ["success" => "Reserva actualizada correctamente."];
        } else {
            return ["error" => "No se pudo actualizar la reserva o no existe."];
        }
    } catch (PDOException $e) {
        return ["error" => "Error en la consulta: " . $e->getMessage()];
    } finally {
        $sentencia = null;
        $conexion = null;
    }
}

function actualizarUsuario($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]);
    } catch (PDOException $e) {
        return ["error" => "No se pudo conectar a la base de datos: " . $e->getMessage()];
    }

    try {
        $consulta = "UPDATE usuarios SET nombre = ?, email = ?, telefono = ?, usuario = ? WHERE id_usuario = ?";

        $sentencia = $conexion->prepare($consulta);

        $sentencia->execute([
            $datos['nombre'],
            $datos['email'],
            $datos['telefono'],
            $datos['usuario'],
            $datos['id_usuario']
        ]);


        if ($sentencia->rowCount() > 0) {
            return ["success" => "Usuario actualizado correctamente."];
        } else {
            return ["error" => "No se pudo actualizar el usuario o no existe."];
        }
    } catch (PDOException $e) {
        return ["error" => "Error en la consulta: " . $e->getMessage()];
    } finally {
        $sentencia = null;
        $conexion = null;
    }
}


function editarVehiculo($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return ["error" => "No se pudo conectar a la base de datos: " . $e->getMessage()];
    }

    try {
        $consulta = "UPDATE vehiculos SET marca = ?, modelo = ?, matricula = ?, estado = ?, sede_actual = ?, plazas = ?, transmision = ?, descripcion = ?, combustible = ? WHERE id_vehiculo = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([
            $datos["marca"],
            $datos["modelo"],
            $datos["matricula"],
            $datos["estado"],
            $datos["sede_actual"],
            $datos["plazas"],
            $datos["transmision"],
            $datos["descripcion"],
            $datos["combustible"],
            $datos["id_vehiculo"]
        ]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return ["error" => "No se pudo realizar la actualización: " . $e->getMessage()];
    }

    $sentencia = null;
    $conexion = null;
    return ["mensaje" => "Vehículo actualizado correctamente"];
}

function insertarVehiculo($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return ["error" => "No se pudo conectar a la base de datos: " . $e->getMessage()];
    }

    try {
        $consulta = "INSERT INTO vehiculos (marca, modelo, matricula, estado, sede_actual, plazas, transmision, descripcion, combustible) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([
            $datos["marca"],
            $datos["modelo"],
            $datos["matricula"],
            $datos["estado"],
            $datos["sede_actual"],
            $datos["plazas"],
            $datos["transmision"],
            $datos["descripcion"],
            $datos["combustible"]
        ]);
        $idInsertado = $conexion->lastInsertId();
    } catch (PDOException $e) {
        return ["error" => "No se pudo ejecutar la consulta: " . $e->getMessage()];
    }

    $sentencia = null;
    $conexion = null;

    return ["mensaje" => "Vehículo insertado", "id_vehiculo" => $idInsertado];
}
