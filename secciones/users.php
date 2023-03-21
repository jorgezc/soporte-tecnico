
<?php include('../templates/cabecera.php'); ?>
  
  <?php 

ini_set('display_errors', 1);
ini_set("log_errors", 1);
ini_set("error_log", "C:/PHP");
      include('../configuraciones/bd.php'); 
  
      $conexionBD=BD::crearInstancia();
  
      // Si fue Editar o borrar desde contrasenna.php
      if (isset($_GET['idusers'])) {
          $idusers = $_GET['idusers'];
          //print_r($idocurrencias);
          //echo "<br>";
      }
  
      //
      if (isset($_GET['accion'])) {
          $accion = $_GET['accion'];
          //print_r($accion);
          //echo "<br>";
      }
   
  //print_r($_POST['accionclick']);

      if(isset($idusers) && !isset($_POST['accionclick'])) {
  

        echo "Entro aqui";
          $sql = "SELECT * FROM users WHERE idusers = $idusers";
          $consulta=$conexionBD->prepare($sql);
          $consulta->execute();
          $users=$consulta->fetch(PDO::FETCH_ASSOC);
 
               
          $email =  $users['email'];
          $password = $users['password']; 
          $nivel =  $users['nivel']; 

 
          print_r($sql);
      } else {
          $nombre = $_SESSION['usuario'];
          $password = isset($_POST['password'])?$_POST['password']:'';
          $nivel  = isset($_POST['nivel'])?$_POST['nivel']:'02';
          $email  = isset($_POST['email'])?$_POST['email']:'';
     
      }
  
      // Si ha hecho clic en el formulario mas abajo
      if(isset($_POST['accionclick'])){
  
          switch($accion){
              case 'Grabar':
                  //$idusers = $_SESSION['user_id'];
                  $sql= "INSERT INTO users (idusers, email, password, nivel) VALUES 
                                              (NULL,'$email', '$password', '$nivel')"; 
                  $consulta = $conexionBD->prepare($sql);
                  $consulta->execute();
  
                  $_SESSION['mensaje'] = 'Usuario agregado satisfactoriamente';
                  $_SESSION['mensaje_color'] = 'success';
                  
                  header("Location: contrasenna.php");
                  break;
  
              case 'Editar':
  
                  $sql= "UPDATE users SET email='$email', password='$password', nivel='$nivel' WHERE idusers=$idusers";
                  $consulta = $conexionBD->prepare($sql);
                  $consulta->execute();
  
                  $_SESSION['mensaje'] = 'Usuario actualizado satisfactoriamente';
                  $_SESSION['mensaje_color'] = 'warning';
                  header("Location: contrasenna.php");
                  break;
  
              case 'Borrar':
  
                  $sql= "DELETE  FROM users WHERE idusers=$idusers";
  
                  $consulta = $conexionBD->prepare($sql);
                  $consulta->execute();
  
                  $_SESSION['mensaje'] = "Usuario fue removido satisfactoriamente";
                  $_SESSION['mensaje_color'] = "danger";
      
                  header("Location: contrasenna.php");
                  break;
          }
      }
  
  ?>
     
  <div class="container-fluid">
      <br>
      <p class="tagline titulogradiente">Registrar nueva ocurrencia</p> 
  </div>
  
  <div class="contenedor">
      <div class="contenedor-sm">
  
          <div class="volver">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
              </svg>
              <a href="contrasenna.php">Volver</a>
          </div>
   
          <form class="formulario" method="POST" action="">

            <div class="campo">
                <label for="email">Email</label>
                <input 
                    type="text"
                    id="email"
                    placeholder="email"
                    name="email"
                    value="<?php echo $email; ?>" 
                                      
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
                                     
                />
            </div>

            <div class="campo">
                <label for="nivel">Nivel</label>
                <input 
                    type="text"
                    id="nivel"
                    placeholder="Nivel"
                    name="nivel"
                    value="<?php echo $nivel; ?>" 
                                     
                />
            </div>
     
            <input type="hidden" name ="accionclick" value="Ejecutar">
           
            <input type="submit" name ="accion" class="boton" value="<?php echo $accion =="Editar" ? 'Grabar' :  $accion; ?>">




            </form>
 
 
 

              
      </div>
  </div>
  
  <?php include('../templates/pie.php'); ?>