 
<?php


if (isset($_SESSION['connect']))//On vérifie que le variable existe
{
        $connect=$_SESSION['connect'];//On récupère la valeur de la variable de session
}
else
{
        $connect=0;//Si $_SESSION['connect'] n'existe pas, on donne la valeur "0"
}
if ($connect == '0')
{

if((isset ($_POST['login'])) AND (isset ($_POST['password'])) AND (!empty($_POST['login'])) AND (!empty($_POST['password']))){

$pass = sha1($_POST['password']);
$pseudo = $_POST['login'];

$bd = Db::getInstance();
$requete = "SELECT id FROM membre WHERE pseudo='".$pseudo."' AND mdp='".$pass."';";
$res = $bd->getRow($requete);

$id=$res['id'];

if ($id)
{ 

$_SESSION['connect']=1;
$_SESSION['id']=$id;
?>

	<section style="padding: 25px">
<img src="images/loading.gif" alt="loading" style="margin-left: 20px; margin-top: 30px; width: 100px;" />
<script language="javascript">
<!--
self.location.href="index.php?afficher=admin" 
  //-->
</script>
<?php
}

else{
?>
<script type="text/javascript">
	$(window).load(function () {
		$('#error').modal('show');
	});
</script>
	
<div class="modal fade" id="error">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body">
          Il y a une erreur dans les identifiants !
          <button type="button" class="close" data-dismiss="modal">x</button>
        </div>
      </div>
    </div>
</div>

<?php 
}
}
}
else{
?>

	<section style="padding: 25px">
<img src="images/loading.gif" alt="loading" style="margin-left: 20px; margin-top: 30px;" />

<script language="javascript">
<!--
self.location.href="index.php?afficher=admin" 
  //-->
</script>
<?php
}

include_once ("views/login.php");
