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
			$nom = wd_remove_accents($nom);
			$query = "DROP TABLE ".$nom."";
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
			
			$fichier='bdd/'.$values['fichier'];
			$nom=$values['nom'];
			
			// Tableau contenant la première ligne du fichier
			$entete ;

			// Tableau bidimensionnel contenant les autres lignes du fichier
			$champs;
			function lireChamps($nomFich, &$tab) 
			{
				global $entete ;
				
				$fp = fopen($nomFich, "r") ;        // Ouverture du fichier
				if( ! $fp) die("Abandon ".$nomFich." non lisible") ;

				// Lecture de la première ligne 

				$entete = fgetcsv($fp, 500, ",");

				// Boucle de lecture du reste du fichier
				while(!feof($fp)) {
					$tab[] = fgetcsv($fp, 500, ",");
				}
				
				fclose($fp) ;
			}
			
			
			global $entete ;
			lireChamps($fichier, $champs) ;
			
			//Création de la table à partir de l'entete du fichier csv
			
			$table='id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, ';			
			
			for($col = 0 ; $col < count($entete) ; $col++) 
			{
				if( $entete[$col]=='ISSN' OR $entete[$col]=='ISBN' )
				{
					$table.= wd_remove_accents($entete[$col])." VARCHAR(20),";
				}
				else
				{
					if($col==(count($entete)-1))
					{
						$table.= wd_remove_accents($entete[$col])." TEXT";
					}
					else
					{
						$table.= wd_remove_accents($entete[$col])." TEXT,";
					}
				}
			}
			
			$nom=wd_remove_accents($nom);
			
			$bd = Db::getInstance();
			$query = "CREATE TABLE ".$nom." ( ".$table." ) DEFAULT CHARSET=utf8;";		
			
			if($bd->q($query))
			{			
			}

			else{
			die(mysql_error()); 
			}

			
			//Enregistrement des données dans la table précédemment créée
			
			
			for($lig = 0 ; $lig < count($champs) ; $lig++) 
			{			
				$values="'',";
				
				for($col = 0 ; $col < count($champs[$lig]) ; $col++) 
				{		
					if($champs[$lig][$col] == '')
					{
							$champs[$lig][$col]= 'null';
					}
					if($col==(count($champs[$lig])-1))
					{
						$values.= "'".mysql_real_escape_string($champs[$lig][$col])."' ";
					}
					else
					{
						$values.= "'".mysql_real_escape_string($champs[$lig][$col])."', ";
					}
				}
			
				$query = "INSERT INTO ".$nom." VALUES (".$values.")";		
				
				$bd->q($query);
			}
			
			return $lig;
			
		}
		
		
	
	}

?>