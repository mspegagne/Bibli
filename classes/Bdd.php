<?php
class Bdd
	{			
		protected $nom;

		protected $fichier;
		
		protected $description;
		
		protected $nombre;
		
		protected $maj;
		
			
		public function __construct($nom, $fichier, $description, $nombre, $maj)
		{	
			$this->nom = $nom;
			$this->fichier = $fichier;
			$this->description = $description;
			$this->nombre = $nombre;	
			$this->maj = $maj;		
		}
		
		public function values(){
			return array(
			"nom"=>$this->nom,
			"fichier"=>$this->fichier,
			"description"=>$this->description,
			"nombre"=>$this->nombre,
			"maj"=>$this->maj);		
		}
		
		
		public function getBdd($nom)
		{
			$bd = Db::getInstance();
			$requete = "SELECT * FROM bdd WHERE nom='".$nom."';";
			$value = $bd->getrow($requete);

			$currentBdd = new Bdd($nom, stripslashes($value['fichier']), stripslashes($value['description']), $value['nombre'], $value['maj']);
			
		}
		
		public function saveBdd()
		{
			$values= $this->values();
			
			$values['nom']=mysql_real_escape_string($values['nom']);			
			$values['fichier']=mysql_real_escape_string($values['fichier']);
			$values['description']=mysql_real_escape_string($values['description']);
			
			$bd = Db::getInstance();
			if($bd->autoExecute('bdd', $values, 'INSERT'))
			{
			
			}

			else{
			die(mysql_error()); 
			}
		}
		
		public function updateBdd()
		{
			$values= $this->values();
			
			$bd = Db::getInstance();
			
			$nom = $values['nom'];
			$values['fichier']=mysql_real_escape_string($values['fichier']);
			$values['description']=mysql_real_escape_string($values['description']);
			
			if($bd->autoExecute('bdd', $values, 'UPDATE', 'nom=\''.$nom.'\''))
			{
			
			}

			else{
			die(mysql_error()); 
			}
		}
		
		public static function supprBdd($nom)
		{
			$bd = Db::getInstance();
			$query = "DELETE FROM bdd WHERE nom='".$nom."'";
			if($bd->q($query))
			{ 
			
			}

			else{
			die(mysql_error()); 
			}
		}
		
		public function convertBdd()
		{
			$values= $this->values();
			
			$fichier=$values['nom'];
			
			
			
			
			$bd = Db::getInstance();
			if($bd->autoExecute('bdd', $values, 'INSERT'))
			{
			
			}

			else{
			die(mysql_error()); 
			}
		}
		
		
	
	}

?>