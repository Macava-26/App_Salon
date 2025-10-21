<?php


namespace Controllers;

use MVC\Router;
use Classes\Email;
use Model\Usuario;

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
        $router->render('auth/restablecer-password', []);
    }
    public static function recuperar()
    {
        echo 'Desde recuperar';
    }
    public static function crear(Router $router)
    {
        $usuario = new Usuario;


        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();


            //Rwevisar alerta de dato vacio

            if (empty($alertas)) {
                //Verificacion de cuentas no registradas
                $resultado = $usuario->existeUsuario();


                if ($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    //Hashear Password
                    $usuario->hashPassword();

                    //Generar TOKEN
                    $usuario->crearToken();

                    //MANDAR EMAIL CON TOKEN
                    $email = new Email(
                        $usuario->nombre,
                        $usuario->email,
                        $usuario->token );

                        $email->enviarConfirmacion();
                }
            }
        }
        debuguear($usuario);

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }
}
