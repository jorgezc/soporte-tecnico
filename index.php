<?php
    ini_set('display_errors', 1);
    ini_set("log_errors", 1);
    ini_set("error_log", "C:/PHP");
    
  
    	

    session_start();

    if($_POST){
        
        require('configuraciones/bd.php'); 
        $conexionBD=BD::crearInstancia();

        $email =  $_POST['email'];

        $email = strtolower($email);
       

        
       // $sql = "SELECT * FROM users WHERE email= '$email'";
       // $consulta=$conexionBD->prepare($sql);
       // $consulta->execute();
       // $usuario=$consulta->fetch(PDO::FETCH_ASSOC);
       
        
        $consulta = $conexionBD->prepare('SELECT idusers, email, password, nivel FROM users WHERE email= :email');
        $consulta->bindParam(':email', $email, PDO::PARAM_STR);
        $consulta->execute();
        $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

       
        if( $usuario ) {
        
            if ( $_POST['password']== $usuario['password']){
                $_SESSION['iniciada']='ok';
                $_SESSION['user_id'] = $usuario['idusers'];
                $_SESSION['usuario'] = $usuario['email'];
                $_SESSION['mensaje'] = "";
                $_SESSION['mensaje_color'] = "";
                $_SESSION['usuario_tipo'] = $usuario['nivel'];

               

                //echo "User" . $_SESSION['iniciada'];
                header('Location: secciones/index.php');
            }else {
               
  
                $mensaje =  "Password o usuario incorrecto";
            }
        } else {
            $mensaje = "Usuario no registrado en la Base de Datos";
        }
    
    }
?>

<?php if(isset($mensaje)) { ?>

    <div class="alert alert-info d-flex align-items-center alert-dismissible fade show" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </svg>
        <div>
            <strong><?php echo $mensaje; ?></strong> 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>

<?php  } ?>





<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soporte Ti</title>
    <link rel="shortcut icon" href="img/iconosoporteti.png"> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&family=Open+Sans&display=swap" rel="stylesheet"> 
   
   <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <link rel="stylesheet" href="css/app.css">
    
</head>
<body>

    <div class="contenedor login">
      <header>
        <h1 class="text-center titulogradiente"> Soporte TI </h1>
        <p class="tagline">Bienvenidos</p>
      </header>
    
        <div class="contenedor-sm">
            <p class="descripcion-pagina">Iniciar Sesión</p>

            <form class="formulario" method="POST" action="">
                <div class="campo">
                    <!--label for="email">Email</label-->
                    <input 
                        type="text"
                        id="email"
                        placeholder="Tu Email"
                        name="email"
                        styles="width:50%"
                    />
              </div>

                <div class="campo">
                    <!-- label for="password">Password</label -->
                    <input 
                        type="password"
                        id="password"
                        placeholder="Tu Password"
                        name="password"
                    />
                </div>

                <input type="submit" class="boton" value="Iniciar Sesión">
            </form>

            <div class="acciones">
                <a href=""></a>
                <a href="">Soporte TI - <?php echo date("Y"); ?></a>
            </div>
        </div> <!--.contenedor-sm -->
    </div> <!--.contenedor-->

<?php include('templates/pie.php'); ?>
