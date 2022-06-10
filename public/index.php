<?php
session_start();

include './../app/configuracao.php';
include './../app/autoload.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
    <title><?=APP_NOME ?></title>

    <link rel="stylesheet" href="<?=URL?>/public/css/initial_settings.css">
    <link rel="stylesheet" href="<?=URL?>/public/css/Usuario.css">
    <link rel="stylesheet" href="<?=URL?>/public/css/adm.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">



</head>
<body>
<?php
     


     if(isset($_SESSION['usu_nivel'])):
         if($_SESSION['usu_nivel'] == 2):
             include '../app/Views/componente/menu_usuario.php'; 
         endif;
     else:
         include '../app/Views/componente/menu_usuario.php'; 
     endif;


   
 
  
  
 ?>  
	
	
		
		<?php 
		 $rotas = new Rota();
         
		?>
		
		
	<?php
    
    
    if(isset($_SESSION['usu_nivel'])):
        if($_SESSION['usu_nivel'] == 2):
            include '../app/Views/componente/baseboard.php'; 
        endif;
    else:
        include '../app/Views/componente/baseboard.php';   
    endif;




    ?>
	 <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="js/slide.js"></script>
    <script src="js/jquery2.js"></script>
    <script src="<?=URL?>/js/ultilies.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    
    
</body>
</html>