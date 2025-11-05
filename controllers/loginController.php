<?php


namespace Controllers;

use MVC\Router;
use Classes\Email;
use Model\Usuario;

class loginController
{

    public static function login(Router $router)
    {
        $alertas = [];

        $auth = new Usuario;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);

            $alertas = $auth->validarLogin();

            if (empty($alertas)) {
                //comprobar usuario
                $usuario = Usuario::where('email', $auth->email);

                if ($usuario) {

                    if ($usuario->VerificarPassword($auth->password)); {
                        //Autenticar Usuario
                        session_start();

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;


                        //redireccionar

                    }
                    if ($usuario->admin === "1") {
                        $_SESSION['admin'] = $usuario->admin ?? null;
                        header('Location: /cita');
                    } else {
                        header('Location: /cita');
                    }
                } else {
                    Usuario::setAlerta('error', 'Usuario no encontrado');;
                }
            }
        }

        $alertas = Usuario::getAlertas();


        $router->render('auth/login', [
            'alertas' => $alertas
        ]);
    }

    public static function logout()
    {
        echo 'Desde logout';
    }
    public static function restablecer(Router $router)
    {

        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new  Usuario($_POST);
            $alertas = $auth->validarEmail();

            if (empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);

                if ($usuario && $usuario->confirmado === "1") {
                    //Generar token de un solo Uso
                    $usuario->crearToken();
                    $usuario->guardar();

                    //Manda email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();
                    //Enviar Email
                    Usuario::setAlerta('exito', 'Revisa tu email');
                } else {
                    Usuario::setAlerta('error', 'El usuario no identificado');
                }
            }
        }

        $alertas = Usuario::getAlertas();


        $router->render('auth/restablecer-password', [
            'alertas' => $alertas
        ]);
    }
    public static function recuperar(Router $router)
    {
        $alertas = [];
        $error = false;

        $token = s($_GET['token']);

        //Identificar usuario por token
        $usuario = Usuario::where('token', $token);


        if (empty($usuario)) {
            Usuario::setAlerta('error', 'Token no Valido');
            $error=true;
        }

        if($_SERVER ['REQUEST_METHOD'] === 'POST'){
                //Actualizar nuevo Password en la DB

                $password = new Usuario($_POST);
                $alertas = $password->validarPassword();

                if(empty($alertas)){
                    $usuario->password = null;
                    $usuario->password = $password->password;
                    $usuario->hashPassword();
                    $usuario->token=null;
                    
                    $resultado = $usuario->guardar();
                    if($resultado){
                        header('Location: /');
                    }
                }


        }

        // debuguear($usuario);
        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-password', [
            'alertas' => $alertas,
            'error' => $error
        ]);
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
                        $usuario->email,  // Primero el email
                        $usuario->nombre, // Luego el nombre
                        $usuario->token   // Y finalmente el token
                    );

                    $email->enviarConfirmacion();

                    //Guardar de Usuario
                    $resultado = $usuario->guardar();
                    if ($resultado) {
                        header('Location: /mensaje');
                    }


                    // debuguear($usuario);

                }
            }
        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router)
    {

        $router->render('auth/mensaje');
    }
    public static function confirmar(Router $router)
    {
        $alertas = [];
        $token = s($_GET['token']);

        // Buscar el usuario con ese token
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            // Token no existe
            Usuario::setAlerta('error', 'Token no válido o expirado');
        } else {
            $usuario->confirmado = '1';
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta confirmada.');
        }

        $alertas = Usuario::getAlertas();

        //Renderizar la vista
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }
}
