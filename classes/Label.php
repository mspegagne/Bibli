<?php 
/* table associant des champs à leurs labels.*/

class Label
{	
	/*champs de base*/
	private $labels = array(
		"titre"  => "Titre",
		"Titre" => "Titre",
		"title" => "Titre",
		"Title" => "Titre",
		"type"  => "Type",
		"Type" => "Type",
		"resource" => "Ressource",
		"Resource" => "Ressource",
		"ressource"  => "Ressource",
		"Ressource" => "Ressource",
		"enddate" => "Date de début",
		"startdate" => "Date de fin",
	);
	
	/* ajout d'une clé et son label à la table*/
	public function addLabel($key, $label)
	{
		$this->labels[$key] = $label;
	}
	
	public function getLabel($key)
	{
		return $this->labels[$key];
	}
	
	// ajoute une liste de clés et son label associé
	
	public function addLabelList($keyList, $label)
	{
		$length = count($keyList);
		$i = 0;
		while($i < $length)
		{
		$this->addLabel($keyList[$i], $label);
		$i++;
		}
	}
	
	/*Booléen : retourne true si la clé passée en paramètre est présente dans la table, false sinon*/
	public function existKey($key)
	{
	
		if(array_key_exists($key, $this->labels))
		{
		return true;
		}
		else return false;
		
	}
	
}
?>