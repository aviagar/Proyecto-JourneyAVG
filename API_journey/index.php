<?php

require __DIR__ . '/Slim/autoload.php';

require "src/funciones_CTES_servicios.php";

$app = new \Slim\App;

$app->get('/logueado', function () {

    $test = validateToken();
    if (is_array($test)) {
        echo json_encode($test);
    } else
        echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
});


$app->post('/login', function ($request) {

    $datos_login[] = $request->getParam("usuario");
    $datos_login[] = $request->getParam("clave");


    echo json_encode(login($datos_login));
});

$app->post('/registro', function ($request) {
    $datos_registro[] = $request->getParam("usuario");
    $datos_registro[] = $request->getParam("nombreCompleto");
    $datos_registro[] = $request->getParam("email");
    $datos_registro[] = $request->getParam("telefono");
    $datos_registro[] = $request->getParam("clave");

    echo json_encode(registro($datos_registro));
});


$app->get('/obtenerCochesDisponibles', function ($request) {
    $datos[] = $request->getParam("fecha_inicio");
    $datos[] = $request->getParam("fecha_fin");
    $datos[] = $request->getParam("id_sede_recogida");
    echo json_encode(obtenerCochesDisponibles($datos));
});

$app->PUT('/resetSeleccionados', function ($request) {
    $datos_reseteo[] = $request->getParam("seleccionado_por");
    echo json_encode(resetSeleccionados($datos_reseteo));
});


$app->get('/obtenerCoche/{id_vehiculo}', function ($request) {

    $test = validateToken();
    if (is_array($test)) {
        if (isset($test["usuario"])) {
            if ($test["usuario"]["tipo"] == "admin") {
                $respuesta = obtener_coche($request->getAttribute("id_vehiculo"));
                $respuesta["token"] = $test["token"];

                echo json_encode($respuesta);
            } else
                echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
        } else
            echo json_encode($test);
    } else
        echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
});



$app->post('/realizarReserva', function ($request) {

    $test = validateToken();

    if (is_array($test)) {
        if (isset($test["usuario"])) {
            $datos_insert[] = $test["usuario"]["id_usuario"];
            $datos_insert[] = $request->getParam("id_vehiculo");
            $datos_insert[] = $request->getParam("fecha_inicio");
            $datos_insert[] = $request->getParam("fecha_fin");
            $datos_insert[] = $request->getParam("ubicacion_recogida");
            $datos_insert[] = $request->getParam("ubicacion_devolucion");
            $datos_insert[] = $request->getParam("plan");

            echo json_encode(realizarReserva($datos_insert));
        } else {
            echo json_encode($test);
        }
    } else {
        echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
    }
});


$app->get('/{tabla}', function ($request) {
    $test = validateToken();

    if (is_array($test)) {
        if (isset($test["usuario"]) && $test["usuario"]["tipo"] === "admin") {
            $tabla = $request->getAttribute('tabla');

            $tablas_permitidas = ['reservas', 'vehiculos', 'sedes'];
            if (!in_array($tabla, $tablas_permitidas)) {
                echo json_encode(['error' => 'Tabla no permitida']);
                return;
            }

            echo json_encode(obtenerTodosAdmin($tabla));
        } else {
            echo json_encode(["no_auth" => "No tienes permiso para usar el servicio"]);
        }
    } else {
        echo json_encode(["no_auth" => "No tienes permiso para usar el servicio"]);
    }
});

$app->delete('/eliminarVehiculo', function ($request) {
    $test = validateToken();
    if (is_array($test)) {
        if (isset($test["usuario"])) {
            if ($test["usuario"]["tipo"] == "admin") {
                echo json_encode(darDeBajaCoche($request->getParam("id_vehiculo")));
            } else
                echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
        } else {
            echo json_encode($test);
        }
    } else
        echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
});

$app->PUT('/seleccionarCoche', function ($request) {
    $datos_update[] = $request->getParam("seleccionado_por");
    $datos_update[] = $request->getParam("seleccionado_timestamp");
    $datos_update[] = $request->getParam("id_vehiculo");
    echo json_encode(seleccionarCoche($datos_update));
});

$app->get('/obtenerReservasCliente', function () {
    echo json_encode(obtenerReservasCliente());
});

$app->run();
