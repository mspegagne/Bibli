<?php

function wd_remove_accents($str, $charset='utf-8')
{
	$str = htmlentities($str, ENT_NOQUOTES, $charset);
	
	$str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
	$str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
	$str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères
	$str=str_replace(' ', '_', ''.$str.'');
	
	$str=strtolower($str);
	return $str;
}

function pagination($nombreDePages, $pageActuelle)
{
 ?>

 <div class="row">
	 <div class="col-lg-6">
	 <ul class="pagination">

<?php

for($i=1; $i<=$nombreDePages; $i++) //On fait notre boucle
{
	 //On va faire notre condition
	 if($i==$pageActuelle) //Si il s'agit de la page actuelle...
	 {
		 echo '<li class="active" ><a href="#">'.$i.'</a></li>'; 
	 }	
	 else //Sinon...
	 {
		 echo '<li><a href="#">'.$i.'</a></li>'; 
	 }
}

	?>
	</ul>
	</div>
</div>
<?php


}


?>