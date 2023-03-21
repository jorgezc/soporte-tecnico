<?php include('../templates/cabecera.php'); ?>
  
<?php 
    include('../configuraciones/bd.php'); 

    $conexionBD=BD::crearInstancia();

    
    if (isset($_GET['idocurrencias'])) {
        $idocurrencias = $_GET['idocurrencias'];
        //print_r($idocurrencias);
        //echo "<br>";
    }

    
    if (isset($_GET['accion'])) {
        $accion = $_GET['accion'];
        //print_r($accion);
        //echo "<br>";
    }
 

    if(isset($idocurrencias) && !isset($_POST['accionclick'])) {

        $sql = "SELECT * FROM ocurrencias WHERE idocurrencias = $idocurrencias";
        $consulta=$conexionBD->prepare($sql);
        $consulta->execute();
        $ocurrencia=$consulta->fetch(PDO::FETCH_ASSOC);
       
        $nombre = $ocurrencia['nombre'];
        $equipo = $ocurrencia['equipo']; 
        $lugar  = $ocurrencia['lugar']; 
        $suceso = $ocurrencia['suceso']; 
        $estado = $ocurrencia['estado']; 
        $fecha  = $ocurrencia['fecha']; 
        //print_r($fecha);
    } else {
        $nombre = $_SESSION['usuario'];
        $equipo = isset($_POST['equipo'])?$_POST['equipo']:'';
        $lugar  = isset($_POST['lugar'])?$_POST['lugar']:'';
        $suceso  = isset($_POST['suceso'])?$_POST['suceso']:'';
        $estado  = isset($_POST['estado'])?$_POST['estado']:'PENDIENTE';
        $fecha = isset($_POST['fecha'])?$_POST['fecha']:date("Y-m-d");
        //print_r($fecha);
   
    }

    // Si ha hecho clic en el formulario mas abajo
    if(isset($_POST['accionclick'])){

        switch($accion){
            case 'Grabar':
                $idusers = $_SESSION['user_id'];
                $sql= "INSERT INTO ocurrencias (idocurrencias, nombre, equipo, lugar, suceso, estado, fecha, idusers) VALUES 
                                            (NULL,'$nombre', '$equipo', '$lugar', '$suceso', '$estado', '$fecha', '$idusers')"; 
                $consulta = $conexionBD->prepare($sql);
                $consulta->execute();

                $_SESSION['mensaje'] = 'Ocurrencia agregada satisfactoriamente';
                $_SESSION['mensaje_color'] = 'success';
                
                header("Location: index.php");
                break;

            case 'Editar':

                $sql= "UPDATE ocurrencias SET equipo='$equipo', lugar='$lugar', suceso='$suceso', estado='$estado' WHERE idocurrencias=$idocurrencias";
                $consulta = $conexionBD->prepare($sql);
                $consulta->execute();

                $_SESSION['mensaje'] = 'Ocurrencia actualizada satisfactoriamente';
                $_SESSION['mensaje_color'] = 'warning';
                header("Location: index.php");
                break;

            case 'Borrar':

                $sql= "DELETE  FROM ocurrencias WHERE idocurrencias=$idocurrencias";

                $consulta = $conexionBD->prepare($sql);
                $consulta->execute();

                $_SESSION['mensaje'] = "Ocurrencia fue removida satisfactoriamente";
                $_SESSION['mensaje_color'] = "danger";
    
                header("Location: index.php");
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
            <a href="index.php">Volver</a>
        </div>
 
        <form class="formulario" method="POST" action="" novalidate>
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input 
                    type="date"
                    readonly
                    id="fecha"
                    name="fecha"
                    value="<?php echo $fecha; ?>"
                   
                />
            </div>

            <div class="campo">
                <label for="nombre">Nombre</label>
                <input 
                    type="text"
                    id="nombre"
                    readonly
                    placeholder="nombre"
                    name="nombre"
                    value="<?php echo $nombre; ?>"
                    
                />
            </div>

            <div class="campo">
                <label for="equipo">Equipo</label>
                <input 
                    type="text"
                    id="equipo"
                    placeholder="Código/Descripción de equipo"
                    name="equipo"
                    value="<?php echo $equipo; ?>"
                />
            </div>


            <div class="campo">
                <label for="suceso">Problema</label>
                <input 
                    type="text"
                    id="suceso"
                    placeholder="Ingrese detalle del problema"
                    name="suceso"
                    value="<?php echo $suceso; ?>"
                />
            </div>

            <div class="campo">
                <label for="lugar">Lugar del suceso</label>
                <input 
                    type="text"
                    id="lugar"
                    placeholder="Ingrese donde se ubica el suceso"
                    name="lugar"
                    value="<?php echo $lugar; ?>"
                />
            </div>


        



            <?php
                if ($_SESSION['usuario_tipo'] == "01") {
            ?>        
            
                <div class="campo">
                    <label for="suceso">Estado</label>


                    <select id="estado" name="estado">
                        <?php if($estado=="PENDIENTE"){ ?>
                            <option selected  value="PENDIENTE" >PENDIENTE</option>
                        <?php } else { ?>  <option value="PENDIENTE" >PENDIENTE</option> <?php } ?>

                        <?php if($estado=="PROCESO"){ ?>
                            <option selected  value="PROCESO" >PROCESO</option>
                        <?php } else { ?>  <option value="PROCESO" >PROCESO</option> <?php } ?>

                        <?php if($estado=="CERRADO"){ ?>
                            <option selected  value="CERRADO" >CERRADO</option>
                        <?php } else { ?>  <option value="CERRADO" >CERRADO</option> <?php } ?>

                    </select>

   
                </div>

            <?php
                } else {

            ?>
                <div class="campo">
                    
                    <input 
                        type="hidden"
                        name="estado"
                        value="<?php echo $estado; ?>"
                    />
                </div>
            
            
            <?php
                }
            ?>    

            <input type="hidden" name ="accionclick" value="Ejecutar">
            <!--input type="hidden" name ="idocurrencias" value="<?php echo  $idocurrencias; ?>"-->
            <input type="submit" name ="accion" class="boton" value="<?php echo $accion =="Editar" ? 'Grabar' :  $accion; ?>">
            
        </form>
            
    </div>
</div>

<?php include('../templates/pie.php'); ?>