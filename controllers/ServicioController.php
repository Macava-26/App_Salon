<?php

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController
{
    public static function index(Router $router)
    {
        session_start();
        isAdmin();

        $servicios = Servicio::all();

        $router->render('servicios/index', [
            'nombre' => $_SESSION['nombre'],
            'servicios' => $servicios
        ]);
    }

    public static function crear(Router $router)
    {
        session_start();
        isAdmin();

        $servicios = new Servicio;
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lógica para POST aquí si es necesario
            $servicios->sincronizar($_POST);

            $alertas = $servicios->validar();

            if (empty($alertas)) {
                $servicios->guardar();
                header('Location: /servicios');
            }
        }

        $router->render('servicios/crear', [
            'nombre' => $_SESSION['nombre'] ?? null,
            'servicio' => $servicios,
            'alertas' => $alertas
        ]);
    }

    public static function actualizar(Router $router)
    {
        session_start();
        isAdmin();

        
        if(!is_numeric($_GET['id'])) return;
        $servicios = Servicio::find($_GET['id']);
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicios->sincronizar($_POST);

            $alertas = $servicios->validar();

            if(empty($alertas)){
                $servicios->guardar();
                header('Location: /servicios');
            }
        
        
        }

        $router->render('servicios/actualizar', [
            'nombre' => $_SESSION['nombre']  ?? null,
            'servicio' => $servicios,
            'alertas' => $alertas
        ]);
    }

    public static function eliminar(Router $router)
    {
        session_start();
        isAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $servicios = Servicio::find($id);
            $servicios-> eliminar();
            header('Location: /servicios');
        }
    }
}
