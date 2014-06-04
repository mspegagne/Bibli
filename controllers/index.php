<?php
 
function afficheList()
{
	$bd = Db::getInstance();
	$requete = "SELECT * FROM bdd;";
	$res = $bd->q($requete);
	
	?> <ul class="dropdown-menu" role="menu"> <?php
	
	foreach($res as $value)
	{
		$nom = stripslashes($value['nom']);
		?> <li><a href="#" onclick="javascript:document.getElementById('bdd').value='<?php echo $nom; ?>'"><?php echo $nom; ?></a></li> <?php
		

	}
	?>
	<li class="divider"></li>
    <li><a href="#" onclick="javascript:document.getElementById('bdd').value='all'">Toutes</a></li>
	</ul> <?php
}


include_once ("views/index.php");

?> 
