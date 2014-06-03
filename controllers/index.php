<?php 

if(isset($_POST['search']) AND $_POST['search']!=null)
{
	$keywords=$_POST['search'];
	$retour=Ouvrage::getList($keywords);
}


include_once ("views/index.php");

?> 
