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

function pagination($nombreDePages, $page, $search)
{
	 if ($nombreDePages > 1)
	{
	 ?>

	 <div class="row">
		 <div class="col-lg-6">
		 <ul class="pagination">
		 
		<?php		 
		if ($page == 1)
		{

		 echo '<li class="active" ><a href="#">1</a></li>';
		 $i=2;

		 $fin= 3;
		 if ($nombreDePages <= $fin )
		{
		 for ($i = $i ; $i <= $nombreDePages ; $i++)
		{
			echo '<li><a href="index.php?search='.$search.'&amp;page='.$i.'">'.$i.'</a></li>';
		}
		}
		else
		{
		 for ($i = $i ; $i <= $fin ; $i++)
		{
			echo '<li><a href="index.php?search='.$search.'&amp;page='.$i.'">'.$i.'</a></li>';
		}
		}


		 $next = $page + 1;
		if ($nombreDePages <= 3)
		{
		echo '<li><a href="index.php?search='.$search.'&amp;page='.$next.'">></a></li>';

		}
		else
		{
		echo '<li><a href="index.php?search='.$search.'&amp;page='.$next.'">></a></li><li><a href="index.php?search='.$search.'&amp;page=' . $nombreDePages . '">>></a></li>';

		}

		}
		if ($page == 2 OR $page == 3)
		{
		
		$before = $page - 1;
		echo '<li><a href="index.php?search='.$search.'&amp;page='.$before.'"><</a></li>';
		for ($i = 1 ; $i < $page ; $i++)
		{
			echo '<li><a href="index.php?search='.$search.'&amp;page='.$i.'">'.$i.'</a></li>';
		}
		echo '<li class="active"><a href="index.php?search='.$search.'&amp;page='.$i.'">'.$i.'</a></li>';
		 $i++;
		 
		$fin= $page+2;
		 if ($nombreDePages <= $fin )
		{
		 for ($i = $i ; $i <= $nombreDePages ; $i++)
		{
			echo '<li><a href="index.php?search='.$search.'&amp;page='.$i.'">'.$i.'</a></li>';
		}
		}
		else
		{
		 for ($i = $i ; $i <= $fin ; $i++)
		{
			echo '<li><a href="index.php?search='.$search.'&amp;page='.$i.'">'.$i.'</a></li>';
		}
		}

		  $next = $page + 1;
		if ($nombreDePages <= 3)
		{
		echo '<li><a href="index.php?search='.$search.'&amp;page='.$next.'">></a></li>';

		}
		else
		{
		echo '<li><a href="index.php?search='.$search.'&amp;page='.$next.'">></a></li><li><a href="index.php?search='.$search.'&amp;page=' . $nombreDePages . '">>></a></li>';

		}



		}


		if ( $page >= 4 )
		{
		echo '<li><a href="index.php?search='.$search.'&amp;page=1"><<</a></li>';
		$before = $page - 1;
		echo '<li><a href="index.php?search='.$search.'&amp;page='.$before.'"><</a></li>';
		
		$limdebut= $page -2;
		for ($i = $limdebut ; $i < $page ; $i++)
		{
			echo '<li><a href="index.php?search='.$search.'&amp;page='.$i.'">' . $i . '</a></li>';
		}
		 echo '<li class="active" ><a href="#">'.$i.'</a></li>';
		 $i++;
		 
		$fin= $page+2;
		 if ($nombreDePages <= $fin )
		{
		 for ($i = $i ; $i <= $nombreDePages ; $i++)
		{
			echo '<li><a href="index.php?search='.$search.'&amp;page='.$i.'">' . $i . '</a></li>';
		}
		}
		else
		{
		 for ($i = $i ; $i <= $fin ; $i++)
		{
			echo '<li><a href="index.php?search='.$search.'&amp;page='.$i.'">' . $i . '</a></li>';
		}
		}

		 $next = $page + 1;
		if ($nombreDePages <= $fin And $nombreDePages != $page And $nombreDePages > $page)
		{
		echo '<li><a href="index.php?search='.$search.'&amp;page='.$next.'">></a></li>';

		}
		elseif ($nombreDePages <= $page )
		{


		}
		else
		{
		echo '<li><a href="index.php?search='.$search.'&amp;page='.$next.'">></a></li><li><a href="index.php?search='.$search.'&amp;page=' . $nombreDePages . '">>></a></li>';

		}

		?>
		</div>
		<?php
		}
?>
		
		
		
		
		
		
		</ul>
		</div>
	</div>
	<?php

	}
}

/**
*	Function accepts either 12 or 13 digit number, and either provides or checks the validity of the 13th checksum digit
*    Optionally converts to ISBN 10 as well.
*/
function isbn13checker($input, $convert = FALSE){
	$output = FALSE;
	if (strlen($input) < 12){
		$output = array('error'=>'ISBN too short.');
	}
	if (strlen($input) > 13){
		$output = array('error'=>'ISBN too long.');
	}
	if (!$output){
		$runningTotal = 0;
		$r = 1;
		$multiplier = 1;
		for ($i = 0; $i < 13 ; $i++){
			$nums[$r] = substr($input, $i, 1);
			$r++;
		}
		$inputChecksum = array_pop($nums);
		foreach($nums as $key => $value){
			$runningTotal += $value * $multiplier;
			$multiplier = $multiplier == 3 ? 1 : 3;
		}
		$div = $runningTotal / 10;
		$remainder = $runningTotal % 10;

		$checksum = $remainder == 0 ? 0 : 10 - substr($div, -1);

		$output = array('checksum'=>$checksum);
		$output['isbn13'] = substr($input, 0, 12) . $checksum;
		if ($convert){
			$output['isbn10'] = isbn13to10($output['isbn13']);
		}
		if (is_numeric($inputChecksum) && $inputChecksum != $checksum){
			$output['error'] = 'Input checksum digit incorrect: ISBN not valid';
			$output['input_checksum'] = $inputChecksum;
		}
	}
	return $output;
}

/**
*	Function accepts either 10 or 9 digit number, and either provides or checks the validity of the 10th checksum digit
*    Optionally converts to ISBN 13 as well.
*/
function isbn10checker($input, $convert = FALSE){
	$output = FALSE;
	if (strlen($input) < 9){
		$output = array('error'=>'ISBN too short.');
	}
	if (strlen($input) > 10){
		$output = array('error'=>'ISBN too long.');
	}
	if (!$output){
		$runningTotal = 0;
		$r = 1;
		$multiplier = 10;
		for ($i = 0; $i < 10 ; $i++){
			$nums[$r] = substr($input, $i, 1);
			$r++;
		}
		$inputChecksum = array_pop($nums);
		foreach($nums as $key => $value){
			$runningTotal += $value * $multiplier;
			//echo $value . 'x' . $multiplier . ' + ';
			$multiplier --;
			if ($multiplier === 1){
				break;
			}
		}
		//echo ' = ' . $runningTotal;
		$remainder = $runningTotal % 11;
		$checksum = $remainder == 1 ? 'X' : 11 - $remainder;
		$checksum = $checksum == 11 ? 0 : $checksum;
		$output = array('checksum'=>$checksum);
		$output['isbn10'] = substr($input, 0, 9) . $checksum;
		if ($convert){
			$output['isbn13'] = isbn10to13($output['isbn10']);
		}
		if ((is_numeric($inputChecksum) || $inputChecksum == 'X') && $inputChecksum != $checksum){
			$output['error'] = 'Input checksum digit incorrect: ISBN not valid';
			$output['input_checksum'] = $inputChecksum;
		}
	}
	return $output;
}

function isbn10to13($isbn10){

	$isbnStem = strlen($isbn10) == 10 ? substr($isbn10, 0,9) : $isbn10;
	$isbn13data = isbn13checker('978' . $isbnStem);
	return $isbn13data['isbn13'];

}

function isbn13to10($isbn13){

	$isbnStem = strlen($isbn13) == 13 ? substr($isbn13, 12) : $isbn13;
	$isbnStem = substr($isbn13, -10);
	$isbn10data = isbn10checker($isbnStem);
	return $isbn10data['isbn10'];
}

function clean($string) 
{
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

?>