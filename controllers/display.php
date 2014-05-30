<?php
//ca c'est le controleur d'affichage, il affiche ce qu'on lui dit d'afficher ou d'exectuer et il inclut les classes au début
//ca permet d'avoir un squelette de page (index.php) à la racine et ensuite d'afficher le contenu du site à l'intérieur
//on affiche les controlleurs des différentes pages
//les controlleurs sont les fichiers qui executent les fonctions et qui font tous les traitements.
//a la fin des controlleurs on affiche les views dans lesquels on affiche les résultats
//c'est une architecture MVC (Model View Controller)

include_once ("classes/function.php");
include_once ("classes/Db.php");
include_once ("classes/Bdd.php");
include_once ("classes/Ouvrage.php");
include_once("classes/Label.php");

function afficher($affichage)
{
	include_once ("controllers/".$affichage.".php");
}

function executer($executer)
{
	include_once ("controllers/".$executer.".php");
}

if(isset($_GET['afficher']))
	afficher($_GET['afficher']);
	
elseif(isset($_GET['executer']))
	executer($_GET['executer']);
	
else
	afficher('index');
	
?>