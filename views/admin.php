<div class="modal fade" id="envoi">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body">
          Bdd bien envoyée !
          <button type="button" class="close" data-dismiss="modal">x</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="suppr">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body">
          Bdd bien supprimée !
          <button type="button" class="close" data-dismiss="modal">x</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="relation">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body">
          Relation bien ajoutée !
          <button type="button" class="close" data-dismiss="modal">x</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="suppr">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body">
          Relation bien supprimée !
          <button type="button" class="close" data-dismiss="modal">x</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="mdpok">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body">
          Mot de passe bien modifié
          <button type="button" class="close" data-dismiss="modal">x</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="mdpdiff">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body">
          Les mots de passe sont différents ou bien vides
          <button type="button" class="close" data-dismiss="modal">x</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="mdpnok">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body">
          Mot de passe ou pseudo erroné...
          <button type="button" class="close" data-dismiss="modal">x</button>
        </div>
      </div>
    </div>
</div>



<div class="page-header">
	<h1 style="color: white;">Administration</h1>
</div>


<div class="row">
<div class="col-md-6">
	<div class="well well-sm">
	  <form class="form-horizontal" action="index.php?afficher=admin" method="post" name="ajoutbdd" enctype="multipart/form-data">
	  <fieldset>
		<legend class="text-center">Ajouter une Bdd</legend>

		<!-- Nom input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="nom">Nom</label>
		  <div class="col-md-9">
		<input id="nom" name="nom" type="text" placeholder="" class="form-control" required>
		  </div>
		</div>

		<!-- Description -->
		<div class="form-group" style="margin-bottom: 0px;">
		  <label class="col-md-3 control-label" for="description">Description</label>
		  <div class="col-md-9">
			<textarea class="form-control" id="description" name="description" placeholder="" rows="3"></textarea>
		  </div>
		</div>

		<!-- bdd input-->
		<div class="form-group" style="margin-bottom: 0px;">
		  <label class="col-md-3 control-label" for="bdd"></label>
			  <div class="col-md-9 controls">
				<input id="bdd" name="bdd" class="input-file" type="file">
			  </div> 
		</div>

		<!-- Form actions -->
		<div class="form-group">
		  <div class="col-md-12 text-right">
			<button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-send"></span>  Envoyer</button>
		  </div>
		</div>
	  </fieldset>
	  </form>
	</div>
  </div>
  
  <div class="col-md-6">
	<div class="well well-sm">
	  <form>
	  <fieldset>
		<legend class="text-center">Liste des BDD</legend>
			<?php afficheList(); ?>
	  </fieldset>
	  </form>
	</div>
  </div>
</div>
 
<div class="row">
  <div class="col-md-6">
	<div class="well well-sm">
	  <form class="form-horizontal" action="index.php?afficher=admin" method="post" name="ajoutrelation" enctype="multipart/form-data">
	  <fieldset>
		<legend class="text-center">Ajouter une relation</legend>

		<!-- Nom input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="sql">Nom Affichage</label>
		  <div class="col-md-9">
		<input id="sql" name="sql" type="text" placeholder="" class="form-control" required>
		  </div>
		</div>

		<!-- Nom input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="csv">Nom CSV</label>
		  <div class="col-md-9">
		<input id="csv" name="csv" type="text" placeholder="" class="form-control" required>
		  </div>
		</div>

		<!-- Form actions -->
		<div class="form-group">
		  <div class="col-md-12 text-right">
			<button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-send"></span>  Envoyer</button>
		  </div>
		</div>
	  </fieldset>
	  </form>
	</div>
  </div>
  
  
  <div class="col-md-6">
	<div class="well well-sm">
	  <form>
	  <fieldset>
		<legend class="text-center">Liste des relations</legend>
			<?php afficheRelation(); ?>
	  </fieldset>
	  </form>
	</div>
  </div>
</div>


<div class="row">
  <div class="col-md-6">
	<div class="well well-sm">
	  <form class="form-horizontal" action="index.php?afficher=admin" method="post" name="modifiermdp" enctype="multipart/form-data">
	  <fieldset>

		<!-- Form Name -->
		<legend class="text-center">Mot de passe Administrateur</legend>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="pseudo">Pseudo</label>  
		  <div class="col-md-4">
		  <input id="pseudo" name="pseudo" placeholder="<?php if (isset($_POST['pseudo'])){echo $_POST['pseudo'];} else{}   ?>" class="form-control input-md" required="" type="text">
			
		  </div>
		</div>

		<!-- Password input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="ancien">Ancien mot de passe</label>
		  <div class="col-md-4">
			<input id="ancien" name="ancien" placeholder="" class="form-control input-md" required="" type="password">
			
		  </div>
		</div>

		<!-- Password input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="new1">Nouveau</label>
		  <div class="col-md-4">
			<input id="new1" name="new1" placeholder="" class="form-control input-md" required="" type="password">
			
		  </div>
		</div>

		<!-- Password input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="new2">Retaper nouveau</label>
		  <div class="col-md-4">
			<input id="new2" name="new2" placeholder="" class="form-control input-md" required="" type="password">
			
		  </div>
		</div>
		
		<div class="form-group">
		  <div class="col-md-12 text-center">
			<button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-cog"></span>  Modifier</button>
		  </div>
		</div>

		</fieldset>
	  </form>
	</div>
  </div>
</div>

