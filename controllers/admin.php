<?php 

//fonction de récupération et d'enregistrement du fichier csv

if(isset($_FILES['bdd']))
{ 

	$filename = basename($_FILES['bdd']['name']);
	$name1=str_replace(' ', '_', ''.$filename.'');
	$name2=str_replace('È', 'e', ''.$name1.'');
	$name3=str_replace('Ë', 'e', ''.$name2.'');
	$name4=str_replace('Í', 'e', ''.$name3.'');
	$name5=str_replace('Î', 'e', ''.$name4.'');
	$name6=str_replace('Ù', 'o', ''.$name5.'');
	$name7=str_replace('Ô', 'i', ''.$name6.'');
	$name8=str_replace('˚', 'u', ''.$name7.'');
	$name9=str_replace('‡', 'a', ''.$name8.'');
	$name10=str_replace('‚', 'a', ''.$name9.'');
	$name11=str_replace('\'', '_', ''.$name10.'');
	$filename=strtolower($name11);

	function check($nom)
	{
	    if(file_exists('./bdd/'. $nom))
		{			
			return true;
		}
		else
		{
			return false;
		}	    		
	}
		
	$filename1=date('dmy').$filename;
	$i=2;	
	
	while(check($filename1))
    {
		$filename1=$filename.$i;
		$i++;
	}

	$name=$filename1;
	$data = '';
	$infosfichier = pathinfo($_FILES['bdd']['name']);
	$extension_upload = $infosfichier['extension'];
    $extensions_autorisees = array('csv');
   
   if (in_array($extension_upload, $extensions_autorisees))
   {
		if(move_uploaded_file($_FILES['bdd']['tmp_name'], 'bdd/' . $name))
		{			   
			$data = $name;		  
		}
	}
	
	?>
	<script>
	alert('<?php echo $data; ?>');
	</script>
	<?php 
	
}





include_once ("views/admin.php");

?> 
