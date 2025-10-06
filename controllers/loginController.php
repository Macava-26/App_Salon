<?php


namespace Controllers;

use Model\Usuario;
use MVC\Router;

class loginController
{

    public static function login(Router $router)
    {
        $router->render('auth/login');
        }

    public static function logout()
    {
        echo 'Desde logout';
    }
    public static function restablecer(Router $router)
    {
            $router->render('auth/restablecer-password', [
                
            ]);
    }
    public static function recuperar()
    {
        echo 'Desde recuperar';
    }
    public static function crear(Router $router)
    {
            $usuario = new Usuario;    

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

        }
            $router->render('auth/crear-cuenta', [ 'usuario' => $usuario

            ]);
    }
}
