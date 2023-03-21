
<?php include('../templates/cabecera.php'); ?>

<?php 
    ini_set('display_errors', 1);
    ini_set("log_errors", 1);
    ini_set("error_log", "C:/PHP");
    include('../configuraciones/bd.php'); 

    $conexionBD=BD::crearInstancia();

    $idusers = $_SESSION['user_id'];
    $nivel = $_SESSION['usuario_tipo'];
    $usuario = $_SESSION['usuario'];
  

    if ($nivel == "01") {
        $sql = "SELECT * FROM users ORDER BY email";
        $consulta=$conexionBD->prepare($sql);
        $consulta->execute();
        $listaUsers=$consulta->fetchAll(); ?>

        <!--a href="#" class="btn btn-success">Registrar nueva ocurrencia</a-->
        <div class="container text-center">
            <div class="volver">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                </svg>
                <a href="index.php">Volver</a>
            </div>
 

            <a href="users.php?accion=Grabar"> 
                <button class="botonnuevo">Registrar nuevo usuario</button>
            </a>

        
            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">email</th>
                        <th scope="col">password</th>
                        <th scope="col">nivel</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach($listaUsers as $users){?> 

                        <tr>
                            <th> <?php echo $users['idusers']; ?> </th>     
                            <td> <?php echo $users['email']; ?> </td>
                            <td> <?php echo $users['password']; ?> </td>
                            <td> <?php echo $users['nivel']; ?> </td>
                            <td>

                                <a href="users.php?idusers=<?php echo $users['idusers']?>&accion=Editar" 
                                    class="btn btn-secondary">
                                    <i class="bi bi-pen-fill"></i>
                                </a>

                                <a href="users.php?idusers=<?php echo $users['idusers']?>&accion=Borrar" 
                                    class="btn btn-danger">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
    
                            </td>

                        </tr>            
                    
                    <?php } ?>    

                </tbody>
            </table>



        </div>

    <?php 
    }




    if ($nivel == "02") {
        $sql = "SELECT idusers, email, password FROM users WHERE idusers = $idusers";
        $consulta=$conexionBD->prepare($sql);
        $consulta->execute();
        $users=$consulta->fetch(PDO::FETCH_ASSOC);
       
        $email = $users['email'];
        $password = $users['password'];
        $passwordnew = "";

        // Si ha hecho clic en el formulario mas abajo
        if(isset($_POST['accionpwd'])){
            $accionpwd = $_POST['accionpwd'];

            switch($accionpwd){

                case 'Actualizar':

                    $passwordnew = $_POST['passwordnew'];

                    $sql= "UPDATE users SET password='$passwordnew' WHERE idusers=$idusers";
                    $consulta = $conexionBD->prepare($sql);
                    $consulta->execute();

                    $_SESSION['mensaje'] = 'Contraseña actualizada satisfactoriamente';
                    $_SESSION['mensaje_color'] = 'warning';
                    header("Location: index.php");
                    break;

            }
        }   ?>        

        <div class="container-fluid">

            <?php if($_SESSION['mensaje']) { ?>
            
            <div class="alert alert-<?= $_SESSION['mensaje_color']; ?> d-flex align-items-center alert-dismissible fade show" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </svg>
                <div>
                    <strong><?php echo $_SESSION['mensaje']; ?></strong> 
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>                
            <?php $_SESSION['mensaje'] = ""; } ?>
            <br>
            <p class="tagline titulogradiente">Cambiar Contraseña</p> 
        </div>

        <div class="contenedor">
            <div class="contenedor-sm">

                <div class="volver">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                    </svg>
                    <a href="index.php">Volver</a>
                </div>


                <form class="formulario" method="POST" action="">

                    <div class="campo">
                        <label for="email">Usuario</label>
                        <input 
                            type="text"
                            id="email"
                            placeholder="email"
                            name="email"
                            value="<?php echo $email; ?>" 
                            readonly                  
                        />
                    </div>

                    <div class="campo">
                        <label for="password">Password</label>
                        <input 
                            type="text"
                            id="password"
                            placeholder="Password"
                            name="password"
                            value="<?php echo $password; ?>" 
                            readonly                  
                        />
                    </div>

                    <div class="campo">
                        <label for="passwordnew">Nuevo Password</label>
                        <input 
                            type="text"
                            id="passwordnew"
                            placeholder="Ingrese nuevo password"
                            name="passwordnew"
                            value="<?php echo $passwordnew; ?>" 
                                        
                        />
                    </div>
        
                    <input type="submit" name ="accionpwd" class="boton" value="Actualizar">
                    
                </form>
            </div>
        </div>



    <?php } 


?>

