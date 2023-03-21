
<?php 

include('../templates/cabecera.php'); 
    ini_set('display_errors', 1);
    ini_set("log_errors", 1);
    ini_set("error_log", "C:/PHP");
    

?>

<?php 

    include('../configuraciones/bd.php'); 

    $conexionBD=BD::crearInstancia();

    if (isset($_GET['idocurrencias'])) {

        $idocurrencias = $_GET['idocurrencias'];

        $sql = "SELECT suceso, urlfile, extfile FROM ocurrencias WHERE idocurrencias = $idocurrencias";
        $consulta=$conexionBD->prepare($sql);
        $consulta->execute();
        $ocurrencia=$consulta->fetch(PDO::FETCH_ASSOC);
        
        $urlfile = $ocurrencia['urlfile'];
        $extfile = $ocurrencia['extfile']; 
        $suceso =  $ocurrencia['suceso']; 

        if (!$urlfile) {
          $urlfile="files/tihelp.jpg";
          $extfile ="jpg"; 

        }

    }


    if(isset($_POST['accion'])){
   
        if ($_FILES['archivo']['error'] == 0) {

            $rand = genRandomString();
            $final_filename = $idocurrencias . $rand ."_".time();

           
            $dir = "files/";
            $tamanio = 2000; //kb

            // Validando tipo de archivos
            // Modificar de ser necesario php.ini: upload_max_filesize y post_max_size

            $permitidos = array('jpg', 'jpeg', 'png', 'gif');
            $arregloArchivo = explode(".", $_FILES['archivo']['name']);
            $extension = strtolower(end($arregloArchivo));

            if (in_array($extension, $permitidos)) {

                //$ruta_carga = $dir . $idocurrencias."-". $_FILES['archivo']['name'];
                $ruta_carga = $dir .  $final_filename ."." . $extension;

                //$fileName = basename($_FILES["archivo"]["name"]); 
                //$imageUploadPath = $dir . $fileName; 
                $imageTemp  = $_FILES['archivo']['tmp_name'];
                //echo "<br>";
                    //echo "Size antes: " . $_FILES['archivo']['size'];
                 //echo "<br>";

                 $compressedImage = compressImage($imageTemp, $imageTemp, 75);
              
                 //echo "<br>";
                 //echo "Size despues: " .filesize($imageTemp);
                 //echo "<br>";


                //if ($_FILES['archivo']['size'] < ($tamanio * 1024)) {

                if (filesize($imageTemp) < ($tamanio * 1024)) {
   

                    if (!file_exists($dir)) {
                        mkdir($dir, 0777);
                    }

                    if ( move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta_carga)) {


                        $compressedImage = compressImage($ruta_carga, $ruta_carga, 40);

                        //echo "<br>";
                        //echo "Size despues: " .filesize($ruta_carga);
                        //echo "<br>";
          
                        $sql= "UPDATE ocurrencias SET urlfile='$ruta_carga', extfile='$extension' WHERE idocurrencias=$idocurrencias";
                        $consulta = $conexionBD->prepare($sql);
                        $consulta->execute();
                        $urlfile = $ruta_carga;

                        $_SESSION['mensaje'] = 'El archivo de cargó correctamente';
                        $_SESSION['mensaje_color'] = 'warning';
        
                    } else {
                        $_SESSION['mensaje'] = 'Error cargar archivo';
                        $_SESSION['mensaje_color'] = 'warning';

                    }
                } else {
                    $_SESSION['mensaje'] = 'Archivo excede el tamaño permitido: ' . $tamanio . "Kb";
                    $_SESSION['mensaje_color'] = 'warning';
    
                }

            } else {
                $stringPermitidos = implode(" ",$permitidos);  
                $_SESSION['mensaje'] = 'Tipo de archivo no permitido, solo puede subir los siguientes formatos: ' . $stringPermitidos;
                $_SESSION['mensaje_color'] = 'warning';

            }
        } else {
            
            $_SESSION['mensaje'] = 'No se nvió el archivo';
            $_SESSION['mensaje_color'] = 'warning';
        }
    } 
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
    <p class="tagline titulogradiente">Registrar Imagen</p> 
</div>

<div class="contenedor">
    <div class="contenedor-sm">

        <div class="volver">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
            </svg>
            <a href="index.php">Volver</a>
        </div>


        <div class="contenedor-img">
            <img  class="imagensub" src="<?php echo $urlfile ?>"  alt="No hay Imagen">
        </div>

        <form class="formulario" method="POST" action="" enctype="multipart/form-data">
            <div class="campo">
                
                <input 
                    type="text"
                    value="<?php echo "Suceso " . $idocurrencias . ": " . $suceso; ?>"
                    class="form-control form-control-lg"
                    readonly
                />
            </div>

            <div class="campo">
                <input 
                    type="file"
                    id="archivo"
                    placeholder="Elegir archivo"
                    name="archivo"
                    class="form-control form-control-lg"
                />
            </div>
    
            <input type="hidden" name ="accionclick" value="Ejecutar">
            <input type="submit" name ="accion" class="boton" value="Enviar">
            
        </form>
    </div>
</div>


<?php 
    include('../templates/pie.php'); 

    function genRandomString() {

        $length = 5;
        $characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWZYZ";

        $real_string_length = strlen($characters) ;     
        $string="id";

        for ($p = 0; $p < $length; $p++) 
    
            $string .= $characters[mt_rand(0, $real_string_length-1)];
    

    return strtolower($string);
    }


     

    function compressImage($source, $destination, $quality) { 
        // Obtenemos la información de la imagen
        $imgInfo = getimagesize($source); 
        $mime = $imgInfo['mime']; 

     
        // Creamos una imagen
        switch($mime){ 
            case 'image/jpeg': 
                $image = imagecreatefromjpeg($source); 
                break; 
            case 'image/png': 
                $image = imagecreatefrompng($source); 
                break; 
            case 'image/gif': 
                $image = imagecreatefromgif($source); 
                break; 
            default: 
                $image = imagecreatefromjpeg($source); 
        } 
     
        // Guardamos la imagen
        imagejpeg($image, $destination, $quality); 
     
        // Devolvemos la imagen comprimida
        return $destination; 
    } 

    
?>