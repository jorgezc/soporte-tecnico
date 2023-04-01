
<?php include('../templates/cabecera.php'); ?>

<?php 
  include('../configuraciones/bd.php'); 

  $conexionBD=BD::crearInstancia();


  $idusers = $_SESSION['user_id'];
  $nivel = $_SESSION['usuario_tipo'];

  switch($nivel){
    case '01':
        $sql = "SELECT * FROM ocurrencias ORDER BY idocurrencias DESC";
        break;

    case '02':
        $sql = "SELECT * FROM ocurrencias WHERE idusers = $idusers ORDER BY idocurrencias DESC";
        break;

  }  



  $consulta=$conexionBD->prepare($sql);
  $consulta->execute();
  $listaOcurrencias=$consulta->fetchAll();

  //print_r($listaOcurrencias);
?>

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
  <?php 
      $_SESSION['mensaje'] = ""; 
      } 
  ?>

  <br>
  <p class="tagline titulogradiente">Ingreso de ocurrencias</p> 

</div>
 

<!--a href="#" class="btn btn-success">Registrar nueva ocurrencia</a-->
<div class="container text-center">
  <a href="ocurrencias.php?accion=Grabar"> 
    <button class="botonnuevo">Registrar nueva ocurrencia</button>
  </a>

  <!--div class="col-lg-4 col-md-6 col-sm-12"-->
<div class="row">

      <?php foreach($listaOcurrencias as $ocurrencia){?> 
        <div class="col-lg-3 col-sm-12">       
          <div class="card">

            <div class="card-body">
              <p class="card-header titulo"> <?php echo "#: ". $ocurrencia['idocurrencias'] ." - " .  date("d/m/Y", strtotime($ocurrencia['fecha'])); ?></p> 
              <p class="card-header">  <?php echo  $ocurrencia['nombre']; ?> </p>
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">  <?php echo "Equipo: " . $ocurrencia['equipo']; ?> </li>
              
              <li class="list-group-item">  <?php echo "Suceso: " . $ocurrencia['suceso']; ?> </li>
              <li class="list-group-item">  <?php echo "Lugar: " . $ocurrencia['lugar']; ?> </li>
              <li class="list-group-item"> Estado: 
              

              <?php switch($ocurrencia['estado']){
                case 'PENDIENTE': ?>
                  <span  style="background: #39FF14;"> 
                    <?php echo $ocurrencia['estado']; ?> 
                  </span>
                <?php  break; ?>
                <?php case 'PROCESO': ?>
                  <span  style="background: #FFFF00;"> 
                    <?php echo $ocurrencia['estado']; ?> 
                  </span>
                  <?php break; ?>
                <?php case 'CERRADO': ?>
                  <span  style="background: #29D0FD;"> 
                    <?php echo $ocurrencia['estado']; ?> 
                  </span>
                  <?php break; ?>
                <?php }  ?>
 

              </li>
            </ul>                
            <div class="card-body">
              <a href="ocurrencias.php?idocurrencias=<?php echo $ocurrencia['idocurrencias']?>&accion=Editar" 
                    class="btn btn-secondary">
                    <i class="bi bi-pen-fill"></i>
              </a>

              <a href="ocurrencias.php?idocurrencias=<?php echo $ocurrencia['idocurrencias']?>&accion=Borrar" 
                    class="btn btn-danger">
                    <i class="bi bi-trash-fill"></i>
              </a>
                
              <!--input type="submit" name ="accion" class="btn btn-info" value="Editar"-->
              <a href="subir.php?idocurrencias=<?php echo $ocurrencia['idocurrencias']?>" class="btn btn-primary">
                    <i class="bi bi-file-richtext"></i>
              </a>   
            
            </div>
          </div>

        </div>

      
      <?php } ?>
 </div>
 
 </div>
 


  <?php include('../templates/pie.php'); ?>
    
