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


	?>	
		<div class="col-lg-10 panel panel-info">
<?php
	$isbn ="";
	

	foreach($values as $cle =>$valeur)
	{
		if((!is_numeric($cle)) AND $cle!='id')
		{
			?>
			<?php echo "<strong>".$cle."</strong>"; ?> : <?php 
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
				echo "<strong style='color:red;'>".$valeur."</strong><br />";
			}
			elseif($cle=="ISBN"||$cle=="isbn")
			{
				echo $valeur.'<br />';
				echo '<img src="images.amazon.com/images/P/'.$valeur.'.01.SZZZZZZZ.jpg" alt="couverture"/>';
			}
			elseif(filter_var($valeur, FILTER_VALIDATE_URL))
			{
				echo "<a href=".$valeur.">".$valeur."</a>";
			}
			elseif($cle=="Title"||$cle=="Titre"||$cle=="title"||$cle=="titre")
			{
				echo "<strong style='color: rgb(180, 46 , 69);'>".$valeur."</strong><br />";
			}
			else
			{
				echo $valeur.'<br />';
			}		
		}
	}
	?>
		
				
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