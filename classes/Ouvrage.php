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
		
		$bd = Db::getInstance();
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
		
		return $resultat;
	}
	

	
	//Affichage propre d'UN ouvrage, $data de type ouvrage
	
	public function printOuvrage()
	{

	$champs = $this->champs;
	$values = $this->values;
<<<<<<< HEAD
<<<<<<< HEAD

	?>	<div class="row" style="margin-left: 15px;">
		<div class="col-lg-10 panel panel-info">
<?php
	$isbn ="";
	
	?>	
		<div class="row" style="margin-left: 15px;">
			<div class="col-lg-10 panel panel-info">
				<div class="col-lg-9 col-lg-push-3">
	<?php

	foreach($values as $cle =>$valeur)
	{
		if((!is_numeric($cle)) AND $cle!='id')
		{
			?>
			<div class="panel-body"><?php echo "<strong>".$cle."</strong>"; ?> : <?php 
			if(filter_var($valeur, FILTER_VALIDATE_URL))
			{
				echo "<a href=".$valeur." target=_blank>".$valeur."</a>";
			}
			elseif($cle=="ISBN"||$cle=="isbn"||$cle=="Isbn")
			{
			/*enlève le "-" de l'isbn*/
			$expl_isbn = explode("-" , $valeur);
			$isbn = $expl_isbn[0];
			$length = count($expl_isbn);
				for($i=1; $i<$length; $i++)
				{
					$isbn = $isbn.$expl_isbn[$i];
				}				
			}
			elseif($cle=="Title"||$cle=="Titre"||$cle=="title"||$cle=="titre")
			{
				echo "<strong style='color:red;'>".$valeur."</strong>";
			}
			elseif($cle=="ISBN"||$cle=="isbn")
			{
				echo $valeur;
				echo '<img src="images.amazon.com/images/P/'.$valeur.'.01.SZZZZZZZ.jpg" alt="couverture"/>';
			}
			else
			{
				echo $valeur;
			}
			?>
			</div>
<?php
				$isbn = $isbn.$expl_isbn[$i];
				}
				
				}
				elseif(filter_var($valeur, FILTER_VALIDATE_URL))
				{
					echo "<a href=".$valeur.">".$valeur."</a>";
				}
				elseif($cle=="Title"||$cle=="Titre"||$cle=="title"||$cle=="titre")
				{
					echo "<strong style='color: rgb(180, 46 , 69);'>".$valeur."</strong>";
				}
				else
				{
					echo $valeur;
				}
				?></div>
			<?php		
		}
	}
	?>
		
	</div>
	</div>
				</div>
				<div class="col-lg-3 col-lg-pull-9" style="margin-top: 45px;">
				<?php
				if(filter_var("http://images.amazon.com/images/P/'.$isbn.'.01.LZZZZZZZ.jpg", FILTER_VALIDATE_URL))
				// mauvais test : il faudrait tester si l'url est valide
				{
	
					//echo '<img src="http://images.amazon.com/images/P/'.$isbn.'.01.LZZZZZZZ.jpg" alt="couverture" align="center"/>';
					echo '<img src="http://images.amazon.com/images/P/2765414173.01.LZZZZZZZ.jpg" alt="couverture" align="center"/>';
					// pour le moment on affiche une couverture exemple
				}
				else
				{
					echo '<img src="images\default_couv.jpg" title="couverture non-disponible" align="center"/>';
				}
				?>
				</div>
			</div>
		</div>
	<?php
	}
	

		
	//Affichage d'une recherche
	public static function printRetour($data)
	{	
		foreach ($data as &$value) 
		{
			$value->printOuvrage();
		}	
	}
}
?>