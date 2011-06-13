<?php
/**
 * A basic page to display search results.
 * Ideally this should be in a template.
 */

require(dirname (__FILE__) . "/../init.php");

$resultArray = array();
if( isset($_GET['term']) )
{
	$resultArray = RepoSearch::instance()->search(urlencode($_GET['term']));
}

if( count($resultArray) > 0 )
{
	$li = '';
	foreach( $resultArray as $result )
	{
		$li .= '<li><a href="' . $result->url . '">' . $result->name . '</a> on ' . $result->type . '</li>';
	}
	
	?>
		<h1>Results</h1>
		<ul class="result clearfix">
			<?=$li?>
		</ul>
	<?
	
}
