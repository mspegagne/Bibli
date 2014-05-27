<?php 
/* table associant des champs à leurs labels.*/

class Label
{	
	
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
	
	
	public function addLabel($key, $label)
	{
	$this->labels[$key] = $label;
	}
	
	public function getLabel($key)
	{
		return $this->labels[$key];
	}
	
	// ajoute une liste de clés et son label associé
	
	/*public function add LabelList($keyList, $label)
	{
		
	}
	*/
	
	public function existKey($key)
	{
	
		if(array_key_exists($key, $this->labels) == true)
		{
		return true;
		}
		else return false;
		
	}
	
}
?>