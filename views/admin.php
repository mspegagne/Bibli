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
		<input id="nom" name="nom" type="text" placeholder="" class="form-control">
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

