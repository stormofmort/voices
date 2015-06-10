<table width="100%" cellpadding="0" cellspacing="0" border="0">
<?php
	include('scripts/browser_func.php');

	$cats = getCats();

	$countMain = count($cats);
	echo "<tr><td>";
	for ( $x = 1; $x < $countMain; $x += 3 ) {
		echo "<div id='row'>";
		for ( $i = $x; $i < $x + 3; ++$i ) {
			echo "<div id='mainCat'>";
			echo $cats[$i]['catMainName']." <a id='cat".$cats[$i]['catMainID']."Link' onclick=\"componentHide('cat".$cats[$i]['catMainID']."')\"></a>";
			
			$countSub = $cats[$i]['numSub'];
			echo "<div id='cat".$cats[$i]['catMainID']."'>";
			for ( $j = 1; $j <= $countSub; ++$j ) {
				echo "<div id='catSub'><a href='category.php?catSub=".$cats[$i][$j]['catSubID']."'>".$cats[$i][$j]['catSubName']."(".$cats[$i][$j]['numArticles'].")</a></div>";
			}
			echo "</div>";
			echo "</div>";
		}
		echo "</div>";
	}
	echo "</td></tr>";
?>
</table>