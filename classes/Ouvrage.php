<?php

class Ouvrage
{
	public $champs = array();
	
	public $values = array();
	
	
	public function __construct($champs, $values)
	{	
		$this->champs = $champs;
		$this->values = $values;	
	}
	
	public function values(){
		return array(
		"champs"=>$this->champs,
		"values"=>$this->values);		
	}
	
	public static function getChamps($table)
	{		
		$bd = Db::getInstance();
		$retour = array();
		$requete = "SHOW COLUMNS FROM ".$table.";";
		$res = $bd->q($requete);
		foreach($res as $value)
		{
			$retour[] = $value['Field'];
		}
		
		return $retour;
	}
	
	public static function getValues($table, $id)
	{
		$bd = Db::getInstance();
		$requete = "SELECT * FROM ".$table." WHERE id='".$id."';";
		$res = $bd->getRow($requete);
		
		return $res;
	}
         
     

	
	public static function getList($keywords)
	{
		$resultat = array();
		
		$search = explode("-=-", $keywords);
		$keywords = $search[0];
		$base = $search[1];
		
		$bd = Db::getInstance();
		
		if($base!='all')
		{
			$table=$base;
			$champs = Ouvrage::getChamps($table);
			$chercher = trim($keywords);
			$elts = explode(" ", $chercher);
			$premier = "%".$elts[0]."%";
			$recherche = "((".$champs[1]." LIKE'".$premier."'";
			foreach($champs as $champ)
			{					
				$recherche.= "OR ".$champ." LIKE '".$premier."'";
			}
			
			$recherche .= ")";	
			
			for ( $i = 1 ; $i < count($elts) ; $i++ )
			{
				
				$elt_suivant = "%".$elts[$i]."%";				
				$recherche .= "AND (".$champs[1]." LIKE'".$elt_suivant."'";
				
				foreach($champs as $champ)
				{					
					$recherche.= "OR ".$champ." LIKE '".$elt_suivant."'";
				}
				
				$recherche .= ")";
			}
			
			$recherche .= ")";
		
			
			$requete = 'SELECT * FROM '.$table.' WHERE '.$recherche.';';
			$res = $bd->q($requete);
			
			foreach($res as $value)
			{
				$id = $value['id'];
				$values = Ouvrage::getValues($table,$id);
				$ouvrage = new Ouvrage($champs,$values);
				array_push($resultat,$ouvrage);
			}
		}
		
		else
		{
			$requete = "SELECT * FROM bdd;";
			$res = $bd->q($requete);
			
			foreach($res as $value)
			{
				$table = wd_remove_accents($value['nom']);
				$champs = Ouvrage::getChamps($table);
				$chercher = trim($keywords);
				$elts = explode(" ", $chercher);
				$premier = "%".$elts[0]."%";
				$recherche = "((".$champs[1]." LIKE'".$premier."'";
				foreach($champs as $champ)
				{					
					$recherche.= "OR ".$champ." LIKE '".$premier."'";
				}
				
				$recherche .= ")";	
				
				for ( $i = 1 ; $i < count($elts) ; $i++ )
				{
					
					$elt_suivant = "%".$elts[$i]."%";				
					$recherche .= "AND (".$champs[1]." LIKE'".$elt_suivant."'";
					
					foreach($champs as $champ)
					{					
						$recherche.= "OR ".$champ." LIKE '".$elt_suivant."'";
					}
					
					$recherche .= ")";
				}
				
				$recherche .= ")";
							
				$requete = 'SELECT * FROM '.$table.' WHERE '.$recherche.';';
				$res = $bd->q($requete);
				
				foreach($res as $value)
				{
					$id = $value['id'];
					$values = Ouvrage::getValues($table,$id);
					$ouvrage = new Ouvrage($champs,$values);
					array_push($resultat,$ouvrage);
				}			
			}
		}		
		
		return $resultat;
	}
	
	//Affichage propre d'UN ouvrage, $data de type ouvrage
	public function printOuvrage()
	{

	$champs = $this->champs;
	$values = $this->values;
	$image = 'images/book.png';
	$url ='';

		foreach($values as $cle =>$valeur)
		{
			if((!is_numeric($cle)) AND $cle!='id')
			{
				
				
				if($cle=="ISBN"||$cle=="isbn"||$cle=="Isbn")
				{
				/*enlève le "-" de l'isbn*/
				$expl_isbn = explode("-" , $valeur);
				$isbn = $expl_isbn[0];
				$length = count($expl_isbn);
					for($i=1; $i<$length; $i++)
					{
						$isbn = $isbn.$expl_isbn[$i];
					}
					
					$isbn = isbn13($isbn);
							
				$image = 'http://images.amazon.com/images/P/'.$isbn.'.01.SZZZZZZZ.jpg';
				}
				elseif($cle=="Title"||$cle=="Titre"||$cle=="title"||$cle=="titre")
				{
				}
				
			}
		}
		?>
		<article class="search-result row">
			<div class="col-xs-12 col-sm-12 col-md-3">
				<a href="#" title="Lorem ipsum" class="thumbnail"><img src="<?php echo $image; ?>" alt="couverture" style="max-width: 150px;" /></a>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-2">
				<ul class="meta-search">
					<li><i class="glyphicon glyphicon-calendar"></i> <span>02/15/2014</span></li>
					<li><i class="glyphicon glyphicon-time"></i> <span>4:28 pm</span></li>
					<li><i class="glyphicon glyphicon-tags"></i> <span>People</span></li>
				</ul>
			</div>
			<div class="col-xs-11 col-sm-12 col-md-7 excerpet">
				<h3><a href="#" title="">Voluptatem, exercitationem, suscipit, distinctio</a></h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatem, exercitationem, suscipit, distinctio, qui sapiente aspernatur molestiae non corporis magni sit sequi iusto debitis delectus doloremque.</p>						
                <span class="plus"><a href="<?php echo $url; ?>" title="Lien"><i class="glyphicon glyphicon-plus"></i></a></span>
			</div>
		</article>
	<?php
	}
	
	

		
	//Affichage d'une recherche
	public static function printRetour($data, $search)
	{	
	
	$OuvragesParPage=10; 	 
	$total= count($data);
	
	//Nous allons maintenant compter le nombre de pages.
	$nombreDePages=ceil($total/$OuvragesParPage);
	 
	if(isset($_GET['page'])) // Si la variable $_GET['page'] existe...
	{
		 $pageActuelle=intval($_GET['page']);
	 
		 if($pageActuelle>$nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
		 {
			  $pageActuelle=$nombreDePages;
		 }
	}
	else // Sinon
	{
		 $pageActuelle=1; // La page actuelle est la n°1    
	}
	 
	$premiereEntree=($pageActuelle-1)*$OuvragesParPage; // On calcul la première entrée à lire
	 
	?>
	<div class="col-lg-12 panel panel-info">
	<hgroup class="mb20">
		<h1>Search Results</h1>
		<h2 class="lead"><strong class="text-danger"><?php echo $total; ?></strong> ouvrage<?php if($total!=0) echo 's';;
		$search = explode("-=-", $search);
		$keywords = $search[0];
		$base = $search[1];
		
		echo ' correspondant';
		if($total!=0) echo 's';
		echo ' à "'.$keywords.'"';
		
		$bd = Db::getInstance();
		
		if($base!='all')
		{
		echo ' dans '.$base;
		}
		?> </h2>								
	</hgroup>
	<?php 
	 
	$data = new ArrayIterator($data);
	foreach (new LimitIterator($data, $premiereEntree, $OuvragesParPage) as $value) 
	{
			$value->printOuvrage();
	}
	 
	 ?>
	 </div>	 
	 <?php
		
		pagination($nombreDePages, $pageActuelle, $search);		

	}
}
?>