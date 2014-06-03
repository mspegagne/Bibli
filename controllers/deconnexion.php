
<img src="images/loading.gif" alt="loading" style="margin-left: 20px; margin-top: 30px; width: 100px;" />

<?php
 
$_SESSION = array();
if (isset($_COOKIE[session_name()]))
{ 
session_destroy();
}
?>
<script language="javascript">
<!--
self.location.href="index.php" 
  //-->
</script>
<?php
?>

