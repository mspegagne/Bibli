<div class="page-header">
	<h1 style="color: white;">Rechercher un ouvrage</h1>
</div>

<form class="form-inline" action="index.php?afficher=index" method="post" name="search" >
  <div class="form-group">
	<label class="sr-only" for="search">Texte</label>
	<input name="search" type="search" class="form-control" id="search" placeholder="Recherche...">
  </div>
  <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
</form>

<br />

<?php

if(isset($_POST['search']) AND $_POST['search']!=null)
{
	Ouvrage::printRetour($retour);
	if(empty($retour))
	{
	?>
	<div class="row" style="margin-left: 15px;">
		<div class="col-lg-10 panel panel-info">
			<div class="panel-body">Aucun résultat...</div>
		</div>
	</div>
	<?php
	}
}

?>