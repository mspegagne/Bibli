<?php

include_once('Label.php');

class Ouvrage
{
	public $champs = array();
	
	public $values = array();
	
	public $tablab;
	
	
	public function __construct($champs, $values)
	{	
		$this->champs = $champs;
		$this->values = $values;	
		$this->tablab = new Label();
	}
	
	public function values(){
		return array(
		"champs"=>$this->champs,
		"values"=>$this->values);		
	}
	
	public static function getChamps($table)
	{
		//récupère tous les champs de la table $table dans la base de données $bdd.
		$champs = mysql_list_fields(_MYSQL_DATABASE_,$table);

		// Enumère le nombre de champs de la table.
		$nb_champs = mysql_num_fields($champs);

		// rempli le tableau temporaire des noms de champs.
		for ($i = 0; $i < $nb_champs; $i++)
		{
			$tableau_noms_temp[$i] = mysql_field_name($champs, $i);
		}

	   $tableau_noms = array();

		for ($i = 1; $i < $nb_champs; $i++)
		{
			array_push($tableau_noms,$tableau_noms_temp[$i]);
		}
		return $tableau_noms;

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
	
			//Affichage du label des champs
	public function printChamps($cle)
	{	
			if($this->tablab->existKey($cle))
			{
			$label = $this->tablab->getLabel($cle);
			echo "<strong>".$label."</strong>";
			}
			
			else 
		{
			echo "<strong>".$cle."</strong>"; 
		}
		
	}
	
	//Affichage propre d'UN ouvrage, $data de type ouvrage
	public function printOuvrage()
	{
	
	$champs = $this->champs;
	$values = $this->values;
	
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
				<div class="panel-body">
				<?php $this->printChamps($cle); ?> 				:
				<?php 
				if($valeur == "null")
				{
					echo "Non disponible";
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
				<div class="col-lg-3 col-lg-pull-9" style="margin-top: 45px;">
				<?php
				//echo '<img src="http://images.amazon.com/images/P/'.$isbn.'.01.LZZZZZZZ.jpg" alt="couverture" align="center"/>';
				echo '<img src="http://images.amazon.com/images/P/2765414173.01.LZZZZZZZ.jpg" alt="couverture" align="center"/>';
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