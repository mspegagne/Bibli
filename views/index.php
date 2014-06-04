
	<div class="page-header">	
				<h1 style="color: white;">Rechercher un ouvrage</h1>
	</div>

<br />
	<form class="form-inline" action="index.php?afficher=index" method="post" name="search" >
	
		<div class="row">
			<div class="col-lg-offset-3 col-lg-6">
		
            <div class="input-group custom-search-form">
			<div class="input-group-btn search-panel">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    	<span id="search_concept">Base de données</span> <span class="caret"></span>
                    </button>
                    <?php afficheList(); ?>
                </div>
			<input type="hidden" id="bdd" name="bdd" value="all">
            <input name="search" type="search" class="form-control" id="search" placeholder="Recherche...">
			<span class="input-group-btn">
              <button type="submit" class="btn btn-primary" type="button">
              <span class="glyphicon glyphicon-search"></span>
             </button>
             </span>
             </div><!-- /input-group -->

				
			</div>
		</div>
			
	</form>
		

<br />



<?php

if(isset($_POST['search']) AND $_POST['search']!=null)
{
	$keywords=$_POST['search'];
	if(isset($_POST['bdd']))
	$bdd=$_POST['bdd'];
	else
	$bdd='all';
	$keywords=$keywords.'-=-'.$bdd;
	$retour=Ouvrage::getList($keywords);
	Ouvrage::printRetour($retour, $keywords);
	
}
if(isset($_GET['search']) AND $_GET['search']!=null)
{
	$keywords=$_GET['search'];
	$retour=Ouvrage::getList($keywords);
	Ouvrage::printRetour($retour, $keywords);
	
}


?> 
