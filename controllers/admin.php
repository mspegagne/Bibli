<?php 


include_once ("control-session.php");


//fonction de récupération et d'enregistrement du fichier csv

if(isset($_FILES['bdd']) AND $_FILES['bdd']['error'] == 0)
{ 

	$filename = basename($_FILES['bdd']['name']);
	$filename=wd_remove_accents($filename);

	function check($nom)
	{
	    if(file_exists('./bdd/'. $nom))
		{			
			return true;
		}
		else
		{
			return false;
		}	    		
	}
		
	$filename=date('dmy').$filename;
	$filename1=$filename;
	$i=2;	
	
	while(check($filename1))
    {
		$filename1=$i.$filename;
		$i++;
	}

	$name=$filename1;
	$data = '';
	$infosfichier = pathinfo($_FILES['bdd']['name']);
	$extension_upload = $infosfichier['extension'];
    $extensions_autorisees = array('csv', 'CSV');
   
   if (in_array($extension_upload, $extensions_autorisees))
   {
		if(move_uploaded_file($_FILES['bdd']['tmp_name'], 'bdd/' . $name))
		{			   
			$fichier = $name;		  
		}
	}
	
	
	
	$nom=$_POST['nom'];
	$description=$_POST['description'];
	$nb='42';
	$maj= time();
	
	$bdd = new Bdd($nom, $fichier, $description, $nb, $maj);
	$nb=($bdd->convertBdd())-1;
	$bdd = new Bdd($nom, $fichier, $description, $nb, $maj);
	$bdd->saveBdd();
	
	?>
	<script type="text/javascript">
		$(window).load(function () {
			$('#envoi').modal('show');
		});
	</script>
	<?php 
	
}

//fonction de récupération et d'affichage de la liste des BDD

function afficheList()
{
	$bd = Db::getInstance();
	$requete = "SELECT * FROM bdd;";
	$res = $bd->q($requete);
	
	?> <ul class="list-group"> <?php
	
	foreach($res as $value)
	{
		$nom = stripslashes($value['nom']);
		$description = stripslashes($value['description']);
		$fichier = stripslashes($value['fichier']);		
		$nombre = $value['nombre'];	
		$maj = $value['maj'];
		

		?>
		 <div href="#" class="list-group-item">
			<span class="list-group-item-heading"><h4><?php echo $nom; ?><a href="index.php?afficher=admin&amp;suppr=<?php echo $nom; ?>"><span class="glyphicon glyphicon-remove pull-right" style="margin-left: 10px;"></span></a><a href="bdd/<?php echo $fichier; ?>"><span class="glyphicon glyphicon-save pull-right" style="margin-left: 10px;"></span></a><span class="badge pull-right"><?php echo $nombre; ?></span></h4></span>
			<span class="list-group-item-text"><?php echo $description; ?></span>
		 </div>
          
		<?php

	}	

	?> </ul> <?php
}

//déclenchement suppression bdd
if(isset($_GET['suppr']))
{
	$nom=$_GET['suppr'];
	Bdd::supprBdd($nom);
	
	?>
	<script type="text/javascript">
		$(window).load(function () {
			$('#suppr').modal('show');
		});
	</script>
	<?php 
}

//enregistre une nouvelle relation
if(isset($_POST['sql']))
{
	$sql=$_POST['sql'];
	$csv=$_POST['csv'];

	$values= array("sql"=>$sql,"csv"=>$csv);	
				
				
	$bd = Db::getInstance();
	if($bd->autoExecute('relation', $values, 'INSERT'))
	{
	?>
	<script type="text/javascript">
		$(window).load(function () {
			$('#relation').modal('show');
		});
	</script>
	<?php 
	}

	else{

	}

}

function afficheRelation()
{
	$bd = Db::getInstance();
	$requete = "SELECT * FROM relation;";
	$res = $bd->q($requete);
	
	?> <ul class="list-group"> <?php
	
	foreach($res as $value)
	{
		$sql = stripslashes($value['sql']);
		$csv = stripslashes($value['csv']);
		

		?>
		 <div href="#" class="list-group-item">
		 
			<span class="list-group-item-heading"><h4><?php echo $csv." "; ?><span class="glyphicon glyphicon-arrow-right" ></span><?php echo " ".$sql; ?><a href="index.php?afficher=admin&amp;supprrel=<?php echo $csv; ?>"><span class="glyphicon glyphicon-remove pull-right" style="margin-left: 10px;"></span></a></h4></span>
			
		 </div>
          
		<?php

	}	

	?> </ul> <?php
}

//déclenchement suppression relation
if(isset($_GET['supprrel']))
{
	$nom=$_GET['supprrel'];
	$bd = Db::getInstance();
	$query = "DELETE FROM relation WHERE csv='".$nom."'";
	if($bd->q($query))
	{ 
	
	}

	else{
	
	}
	
	
	?>
	<script type="text/javascript">
		$(window).load(function () {
			$('#supprrel').modal('show');
		});
	</script>
	<?php 
}

include_once ("views/admin.php");

?> 
