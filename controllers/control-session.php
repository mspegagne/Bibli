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
?>
<script language="javascript">
<!--
self.location.href="index.php?afficher=login" 
  //-->
</script>
<?php
}
?>