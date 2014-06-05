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


//conversion isbn13->isbn10
function isbn13($isbn)
{
	$length = strlen($isbn);
	
	if($length>10)
	{

		$isbn = substr($isbn, 3);

		$checksum = 0;
		$weight = 10;

		$n = str_split($isbn);
		
		foreach ($n as $c) 
		{
			$checksum += $c*$weight;	
			$weight -= 1;
		}

		$checksum = 11-($checksum % 11);

		if ($checksum == 10)
		{
			$isbn += $checksum;	
			$isbn=strval($isbn);
		}
	
		if ($checksum == 3)
		{
			$isbn=strval($isbn);
			$isbn = substr($isbn, 0, -1);
			$isbn = $isbn."X";
		}
		
		elseif ($checksum == 11)
		{
			$isbn=strval($isbn);
			$isbn = $isbn."0";
		}
		
		else
		{
			$isbn += $checksum;	
			$isbn=strval($isbn);
		}

		$length = strlen($isbn);	
		if($length==9)
		{
			$isbn='0'.$isbn;
		}		

	}
	
	return $isbn;
}

function clean($string) 
{
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

?>