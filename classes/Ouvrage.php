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
		
		$res['table']=ucfirst($table);
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
	
	$bd = Db::getInstance();
	$champs = $this->champs;
	$values = $this->values;
	$image = 'images/book.png';
	$titre = '';
	$date = '';
	$url = '';
	$table = '';
	$infos='<ul>';
	$i=0;
	$debut='';
	
		foreach($values as $cle => $valeur)
		{
		
		
			if((!is_numeric($cle)) AND $cle!='id')
			{
			
				$requete = 'SELECT * FROM relation WHERE csv="'.$cle.'";';
				$res = $bd->getValue($requete);
				if($res!=null)
				$cle=$res;
				
				//récupération image
				if($cle=="ISBN"||$cle=="isbn"||$cle=="Isbn")
				{
				$infos .= '<li><span>ISBN : '.$valeur.'</span></li>';
				/*enlève le "-" de l'isbn*/
				$expl_isbn = explode("-" , $valeur);
				$isbn = $expl_isbn[0];
				$length = count($expl_isbn);
					for($i=1; $i<$length; $i++)
					{
						$isbn = $isbn.$expl_isbn[$i];
					}
					
					$isbn = isbn13to10($isbn);
							
				$image = 'http://images.amazon.com/images/P/'.$isbn.'.01.SZZZZZZZ.jpg';
				}
				
				elseif($cle=="Title"||$cle=="Titre"||$cle=="title"||$cle=="titre")
				{
				$titre=$valeur;
				}
				elseif($cle=="table")
				{
				$table=$valeur;
				}
				elseif($cle=="url" || $cle=="lien" || $cle=="link")
				{
				$url=$valeur;
				}
				
				else
				{
				if($valeur!='null')
				{
				
				$cle=ucfirst($cle);
				
				$infos .= '<li><span>'.$cle.' : '.$valeur.'</span></li>';
				}
				}
				
				
				
			}
			
			
			$requete = 'SELECT maj FROM bdd WHERE nom="'.$table.'";';
			$res = $bd->getValue($requete);
			if($res!=null)
			$date=date('d/m/Y', $res);
			$infos .= '</ul>';
		}
		?>
		<article class="search-result row">
			<div class="col-xs-12 col-sm-12 col-md-3">
				<span class="thumbnail"><img src="<?php echo $image; ?>" alt="couverture" style="max-width: 150px;" /></span>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-2">
				<ul class="meta-search">
					<li><i class="glyphicon glyphicon-calendar"></i> <span><?php echo $date; ?></span></li>
					
					<li><i class="glyphicon glyphicon-tags"></i> <span><?php echo $table; ?></span></li>
					<?php
					if($url!='')
					{
					?>
					<li><i class="glyphicon glyphicon-link"></i> <a href="<?php echo $url; ?>" target="_blank" title="Lien"><span>Lien</span></a></li>
					<?php
					}
					?>
				</ul>
			</div>
			<div class="col-xs-11 col-sm-12 col-md-7 excerpet">
				<h3><span style="color:#428bca;"><?php echo $titre; ?></span></h3>
				<?php echo $infos; ?>
				
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
		<h2 class="lead"><strong class="text-danger"><?php echo $total; ?></strong> ouvrage<?php if($total>1) echo 's';;
		$searchorigin=$search;
		$search = explode("-=-", $search);
		$keywords = $search[0];
		$base = $search[1];
		
		echo ' correspondant';
		if($total>1) echo 's';
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
		
		pagination($nombreDePages, $pageActuelle, $searchorigin);		

	}
}
?>