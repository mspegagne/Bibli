<?php
session_start();
include_once ("config.php");
?>

<!DOCTYPE html>
<html>
 <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mathieu SPEGAGNE">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	
    <!-- Custom styles for this template -->
    <link href="template.css" rel="stylesheet">
	
	<title>INSA's Library Search Engine</title>
	
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
	
	<script src="bootstrap/js/jquery.js"></script>
  </head>
<body>

    <!-- Fixed navbar -->
    <header class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
		  <div class="navbar-header">
			<a class="navbar-brand" href="index.php">INSA's Library Search Engine</a>
		  </div>
		  <ul class="nav navbar-nav">
			<li><a href="index.php?afficher=admin">Admin</a></li>
		  </ul>
		  <form class="navbar-form pull-right" action="index.php?afficher=index" method="post" name="search" enctype="multipart/form-data">
			<input type="text" style="width:150px" id="search" name="search" class="input-sm form-control" placeholder="Recherche...">
			<button type="submit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-search"></span> Chercher</button>
			<?php
			if (isset($_SESSION['connect']))//On vérifie que le variable existe
			{
					$connect=$_SESSION['connect'];//On récupère la valeur de la variable de session
			}
			else
			{
					$connect=0;//Si $_SESSION['connect'] n'existe pas, on donne la valeur "0"
			}
			if ($connect == '1')
			{
				?>
				<a href="index.php?executer=deconnexion" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-off"></span></a>
				<?php
			}
			?>
		  </form>
		  
      </div>
    </header>

    <!-- Begin page content -->
    <div class="container">
	  
	  <?php include_once("controllers/display.php"); ?>
	  
    </div>

    <footer id="footer">
      <div class="container">
        <p class="text-muted">By Dpt INFO - Copyright INSA</p>
      </div>
    </footer>


	
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>